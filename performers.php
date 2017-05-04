<?php
if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off")
{
	$redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	// header('HTTP/1.1 301 Moved Permanently');
	header('Location: ' . $redirect, true, 301);
	exit();
}
require_once('_global.php');
include_once('_includes.php');
$db = db::getInstance();
check_access($db,false);

$current_user = new User($_SESSION["user_id"]);
$current_user->set_city_auto();
$ref = isset($_SESSION["LAST_PAGE"]) ? trim($_SESSION["LAST_PAGE"]) : false;
if ( $ref == "profile/project-responds" )
{
	$data["ts_project_responds"] = time();
	$current_user->update_profile_info($data);
}
$_SESSION["LAST_PAGE"] = "/performers";
$preselect = get_var("preselect","array",Array());
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<?php include(PD.'/includes/html-head.php');?>
</head>
<body>

<?php include(PD.'/includes/main-header.php');?>

<div class="container main-container" id="projects">
	<div class="row bottom-shadow">
		<div class="col margins left"></div>
		<div class="col main">
			<div class="row">
				<div class="col wdo-main-left right-shadow" style="padding-top: 0px;">
					<div class="row">
						<div class="col text-center" style="padding: 15px 5px; align-items: center;background: url('/images/ornament-w-bg.png');height: 70px;">
							<h44 style="font-size: 1.6rem;" class="text-purple-dark text-roboto-cond-bold">ВСЕ ИСПОЛНИТЕЛИ</h44>
						</div>
					</div>
					<br />
					<?php include(PD.'/includes/left-list-categories.php');?>
					<?php include(PD.'/includes/left-list-adv.php');?>
					<?php include(PD.'/includes/left-list-top-10.php');?>
				</div><!-- /.wdo-main-left -->
				<div class="col wdo-main-right">
					<div class="row">
						<div class="col" style="border-bottom: 1px solid #ece7e7;padding-bottom: 5px;">
							Здесь представлены все исполнители, отсортированные по рейтингу. Вы можете добавить заказ для конкретного исполнителя.
						</div>
					</div>
					<div class="row">
						<div class="col" style="padding-top: 5px;">
							<img src="/images/arrow-down.png" style="position: absolute; top: -3px; left: 50px;" >
							Сортировать по: 
							<span class="performers-sort active" data-dir="desc" data-col="rating">рейтингу</span>
							<span class="performers-sort" data-dir="desc" data-col="registered">новизне</span>
							<span class="performers-sort" data-dir="desc" data-col="user_responds">количеству отзывов</span>
						</div>
					</div>

					<table class="table" id="performers-table">
						<thead>
							<th>Исполнители</th>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div><!-- /.wdo-main-right -->
			</div>
		</div><!-- /.main -->
		<div class="col margins right"></div>
	</div>
</div>

<?php include(PD.'/includes/footer.php');?>
<?php include(PD.'/includes/modals.php');?>
<?php include(PD.'/includes/scripts.php');?>

<script>
$(function(){

	<?php
	if ( isset($preselect["cat_name"]) )
	{
		$preselect["cat_id"] = $db->getValue("cats","id","id",Array("translated"=>strtolower($preselect["cat_name"])));
	}
	if ( isset($preselect["subcat_name"]) )
	{
		$preselect["subcat_id"] = $db->getValue("subcats","id","id",Array("translated"=>strtolower($preselect["subcat_name"])));
	}
	if ( isset($preselect["subcat_id"]) && intval($preselect["subcat_id"]) > 0 )
	{
		echo sprintf('toggleSubCategory(%d,true);',$preselect["subcat_id"],$preselect["cat_id"]);
	}
	elseif ( isset($preselect["cat_id"]) && intval($preselect["cat_id"]) > 0 )
	{
		echo sprintf('toggleCategory(%d,true,false);',$preselect["cat_id"],$preselect["cat_id"]);
	}
	else
	{
		echo 'restoreSelectedSpecs();';
	}
	?>

	config.performers.dt = $("#performers-table").DataTable({
		"language": {"url": "/js/dataTables/dataTables.russian.lang"},
		"dom": 'tr<"row"<"col"p>>',
		"bProcessing": true,
		"bServerSide": true,
		"pagingType": "full_numbers",
		"ajax": {
			"url": "/dt/performers",
			"type": "POST",
			"data": function( d ) {
				var order = {"col": $(".performers-sort.active").data("col"),"dir": $(".performers-sort.active").data("dir")};
				d.order = order;
				d.selected = function() {return config.projects.specs;};
			}
		},
		"bStateSave": false,
		"iDisplayLength": 10,
		"columns": [
			{"data": "real_user_name","class":""},
		],
		"order": [[0, 'asc']],
		"initComplete": function(table,data) {
			$("#performers-table").find("thead").hide();
		},
		"createdRow": function ( row, data, index ) {
			$('td', row).html('');
			var container = $('<div />', {class: "performer-container"}),
					performer = $('<div/>', {class: "performer-entry"}),
					portfolio_thumbs = '',
					html = '';
			if ( data.portfolios.length > 0 )
			{
				$.each(data.portfolios,function(){
					portfolio_thumbs += '<a href="/profile/id'+data.user.user_id+'#portfolio"><img width="100" class="img-thumbnail" src="/get.Attach?attach_id='+this.cover_id+'&w=250&h=250&force_resize=true&method=crop" /></a>'
				})
			}
			html += ''
			+'<div class="row">'
			+'	<div class="col vertical-dotted">'
			+'		<div class="row">'
			+'			<div class="col text-center" style="padding-top: 20px; max-width: 100px;">'
			+'				<img class="rounded-circle shadow" src="'+data.user.avatar_path+'&w=50&h=50" /><br />'
			+'				'+moment.unix(data.user.registered).format("YYYY-MM-DD")
			+'			</div>'
			+'			<div class="col" style="padding-top: 20px;padding-left: 0;">'
			+'				<a class="wdo-link underline" href="/profile/id'+data.user.user_id+'">'+data.user.real_user_name+'</a>'
			+'				<br /><br /><p class="text-truncated" style="text-overflow: ellipsis; line-height: 1.1rem; max-height: 2.2rem; overflow: hidden;">'+data.user.rezume+'</p>'
			+'			</div>'
			+'		</div>'
			+'		<div class="row">'
			+'			<div class="col" style="padding: 15px;">'
			+					portfolio_thumbs
			+'			</div>'
			+'		</div>'
			+'	</div>'
			+'	<div class="col text-center" style="max-width: 165px; background-color: #f6f5f6; padding-top: 15px;">'
			+'		<text style="line-height: 2rem;"><span class="pull-left">Рейтинг</span><span class="pull-right">'+data.user.rating+'</span></text><br />'
			+'		<text style="line-height: 2rem;"><span class="pull-left"><a class="wdo-link underline" href="/profile/id'+data.user.user_id+'#responds">Отзывов</a></span><span class="pull-right"><img src="/images/rating-good.png" /> '+data.user.counters.responds.good+' | <img src="/images/rating-bad.png" /> '+data.user.counters.responds.bad+'</span></text><br />'
			+'		<text style="line-height: 2rem;"><span class="pull-left">В сервисе</span><span class="pull-right">'+moment.unix(data.user.registered).fromNow(true)+'</span></text><br />'
			+'		<br />'
			+'		<text style="line-height: 3rem; font-size:.8rem;"><a class="wdo-link underline" href="/profile/id'+data.user.user_id+'#portfolio">Смотреть портфолио</a></text><br />'
			+'		<a class="wdo-btn btn-sm bg-yellow" href="/project/add?for_performer='+data.user.user_id+'">Предложить работу</a><br /><br />'
			+'	</div>'
			+'</div>';
			performer.html(html).appendTo(container);
			container.appendTo($('td', row));

		},
		"drawCallback": function( settings ) {
			$(".paginate_button > a").on("focus", function() {
				$(this).blur();
			});
		}
	})

	var prevSort = {"col":"rating","ord":"desc"};
	$(".performers-sort").click(function(e){
		var col = $(this).data('col'),
				dir = $(this).data('dir');
		if ( prevSort.col == col )
		{
			dir = (dir == "desc") ? "asc" : "desc";
			$(this).data('dir',dir);
		}
		else
		{
			$(".performers-sort").removeClass("active");
			$(this).addClass("active");
		}
		prevSort.col = col;
		prevSort.dir = dir;
		config.performers.dt.ajax.reload();
	})
});
</script>
</body>
</html>