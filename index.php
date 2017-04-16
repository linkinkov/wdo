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

$preselect = isset($_REQUEST["preselect"]) ? $_REQUEST["preselect"] : array();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<?php include(PD.'/includes/html-head.php');?>
</head>
<body>

<?php include(PD.'/includes/main-header.php');?>

<div class="container banner-container">
	<div class="row shadow inset">
		<div class="col margins left"></div>
		<div class="col main">
			<div class="row">
				<div class="col wdo-main-left bg-purple-dark" style="z-index: 1; padding-top: 10px;">
					<div class="row">
						<div class="col"><h3>О СЕРВИСЕ</h3></div>
					</div>
					<div class="row">
						<div class="col" style="max-height: 180px; overflow: hidden;"><p style="-webkit-column-width: 243px;column-width: 243px;height: 100%;overflow: hidden;">Первая биржа праздников, всяких дней рождений и прочей Первая биржа праздников, всяких дней рождений и прочей Первая биржа праздников, всяких дней рождений и прочей Первая биржа праздников, всяких дней рождений и прочейПервая биржа праздников, всяких дней рождений и прочей</p></div>
					</div>
					<div class="row">
						<div class="col">
							<div class="wdo-btn wdo-btn-xs bg-purple learnMore">Узнать больше</div>
						</div>
					</div>
				</div><!-- /.wdo-main-left -->
				<div class="col wdo-main-right" style="display: flex; align-items: flex-end; padding-bottom: 15px;">
					<div style="z-index: 1;">
						<div class="row" style="align-items: center;">
							<div class="col" style="flex: 0 0 571px">Добавить проект может любой пользователь. Если у вас нет аккаунта, то сперва зарегистрируйтесь, а затем Вы сможете создавать новые проекты</div>
							<div class="col">
								<a class="wdo-btn bg-purple text-white"><i class="fa fa-plus"></i> Добавить проект</a>
							</div>
						</div>
					</div>
				</div><!-- /.wdo-main-right -->
			</div>
		</div><!-- /.main -->
		<div class="col margins right"></div>
		<div class="white-overlay"></div>
	</div>
</div>

<div class="container main-container" id="projects">
	<div class="row bottom-shadow">
		<div class="col margins left"></div>
		<div class="col main">
			<div class="row">
				<div class="col wdo-main-left right-shadow">
					<div class="row">
						<div class="col">
							<h44 class="text-yellow strong">ФИЛЬТР СПЕЦИАЛИЗАЦИЙ</h44>
							<?php include(PD.'/includes/left-list-categories.php');?>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<hr />
							<h44 class="text-yellow strong">ПРЕДЛОЖЕНИЯ КОМПАНИЙ</h44>
							<?php include(PD.'/includes/left-list-adv.php');?>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<hr />
							<h44 class="text-yellow strong">ТОП 10 ИСПОЛНИТЕЛЕЙ</h44>
							<?php include(PD.'/includes/left-list-top-10.php');?>
						</div>
					</div>
				</div><!-- /.wdo-main-left -->
				<div class="col wdo-main-right">
					
					<div class="row">
						<div class="col">
							<div class="input-group">
								<input type="search" class="form-control" style="" placeholder="<?php echo $lang["monitoring"]["search"];?>" aria-controls="deviceListTable" id="dt_filter">
								<div class="input-group-btn">
									<div class="btn-group">
										<button type="button" class="btn btn-secondary calendar"><i class="fa fa-calendar"></i></button>
										<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											Фильтр
										</button>
										<div class="dropdown-menu dropdown-menu-right">
											<a class="dropdown-item wdo-link project-extra-filter" for="safe_deal">Только безопасные сделки</a>
											<a class="dropdown-item wdo-link project-extra-filter" for="vip">Только VIP</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<table class="table" id="projects-table">
						<thead>
							<th>Наименование</th>
							<th>Дата</th>
							<th>Бюджет</th>
							<th>Заявки</th>
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
function updateProfileIndicator(type,counter)
{
	var indicator = $(".notify[notifyType='"+type+"']");
	counter = ( counter > 99 ) ? "99+" : counter;
	$(indicator).find(".counter").text(counter);
	if ( parseInt(counter) > 0 )
	{
		$(indicator).find("i").addClass("active");
		$(indicator).find("span").show();
	}
	else
	{
		$(indicator).find("i").removeClass("active");
		$(indicator).find("span").hide();
	}
}
$(function(){

	<?php
	if ( isset($preselect["cat_name"]) )
	{
		$preselect["cat_id"] = $db->getValue("cats","id","id",Array("transliterated"=>strtolower($preselect["cat_name"])));
	}
	if ( isset($preselect["subcat_name"]) )
	{
		$preselect["subcat_id"] = $db->getValue("subcats","id","id",Array("transliterated"=>strtolower($preselect["subcat_name"])));
	}
	if ( isset($preselect["subcat_id"]) && intval($preselect["subcat_id"]) > 0 )
	{
		echo sprintf('toggleSubCategory(%d);slideCategory(%d);scrollTo("projects");',$preselect["subcat_id"],$preselect["cat_id"]);
	}
	elseif ( isset($preselect["cat_id"]) && intval($preselect["cat_id"]) > 0 )
	{
		echo sprintf('toggleCategory(%d,true);slideCategory(%d);scrollTo("projects");',$preselect["cat_id"],$preselect["cat_id"]);
	}
	?>
	updateProfileIndicator("messages",13);
	updateProfileIndicator("info",1);
	config.projects.calendar = $('.calendar').daterangepicker(config.datePickerOptions);
	$('.calendar').on('apply.daterangepicker', function(ev, picker) {
		reloadProjectsTable();
	});
	config.projects.dt = $("#projects-table").DataTable({
		"language": {"url": "/js/dataTables/dataTables.russian.lang"},
		"dom": 'tr<"row"<"col"l><"col"i>><"row"<"col"p>>',
		"bProcessing": true,
		"bServerSide": true,
		"pagingType": "full_numbers",
		"ajax": {
			"url": "/dt/projects",
			"type": "POST",
			"data": function( d ) {
				d.length = function() {return parseInt(config.projects.table.length);};
				d.showParams = config.projects.table;
				d.selected = function() {
					var arr = [];
					$(".subcategory.selected").each(function(){
						arr.push($(this).data("subcat_id"));
					})
					return arr;
				};
				d.start_date = function() {return $(config.projects.calendar).data('daterangepicker').startDate.format("X");};
				d.end_date = function() {return $(config.projects.calendar).data('daterangepicker').endDate.format("X");};
				d.safe_deal = function() {return $(".project-extra-filter[for='safe_deal']").hasClass("active")};
				d.vip = function() {return $(".project-extra-filter[for='vip']").hasClass("active")};

			}
		},
		"bStateSave": true,
		"stateSaveCallback": function(settings, data) {
			config.projects.table.state = data;
			setCookie("config.projects.table",JSON.stringify(config.projects.table));
		},
		"stateLoadCallback": function (settings) {
			return config.projects.table.state;
		},
		"iDisplayLength": parseInt(config.projects.table.length),
		"columns": [
			{"data": "project.title","class":"project-table-title","width":"300px"},
			{"data": "project.start_date","class":"project-table-created"},
			{"data": "project.cost","class":"project-table-cost"},
			{"data": "bids","class":"project-table-bids"},
		],
		"order": [[0, 'asc']],
		"initComplete": function(table,data) {
			$("#dt_filter").val(config.projects.table.state.search.search);
			$("#projects-table").find("th:eq(1)").css('min-width','100px');
		},
		"createdRow": function ( row, data, index ) {
			var title = $.sprintf('<a class="wdo-link word-break" href="%s">%s</a>',data.project_link,data.project.title);
			var category = $.sprintf('<br /><br /><small><text class="text-purple strong">%s</text> / <text title="Был опубликован">%s</text></small>',data.project.cat_name,moment.unix(data.project.created).fromNow());
			var start_date = moment.unix(data.project.start_date).format("DD.MM.YYYY");
			var duration = "";
			if ( data.project.continuous == 1 )
			{
				var m1 = moment.unix(data.project.start_date);
				var m2 = moment.unix(data.project.end_date);
				duration = '<span class="pull-right"><i class="fa fa-clock-o" title="Мероприятие продлится '+moment.preciseDiff(m1, m2)+'"></i></span>';
			}
			var cost = data.project.cost + ' <i class="fa fa-rouble"></i>';
			$('td', row).eq(0).html(title+category);
			$('td', row).eq(1).html(start_date+duration).attr("title",$.sprintf("Дата проведения мероприятия (%s)",moment.unix(data.project.start_date).format("LL")));
			$('td', row).eq(2).html(cost);
			var extra_title = [];
			if ( data.project.safe_deal == 1 )
			{
				$('td', row).eq(3).addClass('safe-deal');
				extra_title.push("Безопасная сделка");
			}
			if ( data.project.vip == 1 )
			{
				$('td', row).eq(3).attr("title","VIP проект").addClass('vip');
				extra_title.push("VIP проект");
			}
			$('td', row).eq(3).attr("title",extra_title.join("; "))
			$(row).click(function(){
				window.location.href = data.project_link;
			})
		},
		"drawCallback": function( settings ) {
			$(".paginate_button > a").on("focus", function() {
				$(this).blur();
			});
		}
	})

	var prevFilter;
	$("#dt_filter").keyup(function(e){
		if (prevFilter != $(this).val() )
		{
			var oTable = $('#projects-table').dataTable();
			oTable.fnFilter( this.value );
			prevFilter = $(this).val();
		}
		else
		{
			return false;
		}
	})
});
</script>
</body>
</html>