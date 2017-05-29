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
$_SESSION["LAST_PAGE"] = "/projects";
$preselect = get_var("preselect","array",Array());
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
						<div class="col text-roboto-cond-bold strong"><h3>О СЕРВИСЕ</h3></div>
					</div>
					<div class="row">
						<div class="col" style="max-height: 180px; overflow: hidden;"><p style="-webkit-column-width: 243px;column-width: 243px;height: 100%;overflow: hidden;">Первая биржа праздников, всяких дней рождений и прочей Первая биржа праздников, всяких дней рождений и прочей Первая биржа праздников, всяких дней рождений и прочей Первая биржа праздников, всяких дней рождений и прочейПервая биржа праздников, всяких дней рождений и прочей</p></div>
					</div>
					<div class="row">
						<div class="col">
							<div class="wdo-btn bg-purple learnMore">Узнать больше</div>
						</div>
					</div>
				</div><!-- /.wdo-main-left -->
				<div class="col wdo-main-right" style="display: flex; align-items: flex-end; padding-bottom: 15px;">
					<div style="z-index: 1;">
						<div class="row" style="align-items: center;">
							<div class="col" style="min-width: 571px; padding-right: 0;">Добавить проект может любой пользователь. Если у вас нет аккаунта, то сперва зарегистрируйтесь, а затем Вы сможете создавать новые проекты</div>
							<div class="col text-right" style="padding-left: 0;">
								<a href="<?php echo HOST.'/project/add/';?>" class="wdo-btn bg-purple btn-sm"><i class="fa fa-plus"></i> Добавить проект</a>
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
					<?php include(PD.'/includes/left-list-categories.php');?>
					<?php include(PD.'/includes/left-list-adv.php');?>
					<?php include(PD.'/includes/left-list-top-10.php');?>
				</div><!-- /.wdo-main-left -->
				<div class="col wdo-main-right">
					<div class="row">
						<div class="col">
							<div class="input-group">
								<input type="search" class="form-control" style="" placeholder="Поиск" aria-controls="deviceListTable" id="dt_filter">
								<div class="input-group-btn">
									<div class="btn-group">
										<button type="button" class="btn btn-secondary calendar"><i class="fa fa-calendar"></i></button>
										<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<i class="fa fa-cogs"></i> Фильтр
										</button>
										<div class="dropdown-menu dropdown-menu-right">
											<a class="dropdown-item wdo-link project-extra-filter" for="safe_deal">Только безопасные сделки</a>
											<a class="dropdown-item wdo-link project-extra-filter" for="vip">Только VIP</a>
											<a class="dropdown-item wdo-link project-extra-filter" onClick="event.preventDefault();event.stopPropagation();">
												<div class="dataTables_length">
													<select class="form-control" id="projects-table_length" name="length" data-param="length" aria-controls="deviceListTable" style="width: 100%;">
														<option value="10">по 10 записей</option>
														<option value="25">по 25 записей</option>
														<option value="50">по 50 записей</option>
														<option value="100">по 100 записей</option>
													</select>
												</div>
											</a>
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
	var opts = config.datePickerOptions;
	opts.endDate = moment().add(6,"months");
	config.projects.calendar = $('.calendar').daterangepicker(opts);
	$('.calendar').on('apply.daterangepicker', function(ev, picker) {
		reloadTable();
	});
	$("#projects-table_length").on("change",function(){
		config.projects.table.length = this.value;
		config.projects.dt.page.len( config.projects.table.length );
		setCookie("config.projects.table",JSON.stringify(config.projects.table));
		config.projects.dt.ajax.reload();
	})
	config.projects.dt = $("#projects-table").DataTable({
		"language": {"url": "/js/dataTables/dataTables.russian.lang"},
		"dom": 'tr<"row"<"col"p>><"row"<"col"i>>',
		"bProcessing": true,
		"bServerSide": true,
		"pagingType": "full_numbers",
		"ajax": {
			"url": "/dt/projects",
			"type": "POST",
			"data": function( d ) {
				d.length = function() {return parseInt(config.projects.table.length);};
				d.showParams = config.projects.table;
				d.selected = function() {return config.projects.specs;};
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
			{"data": "bids","class":"project-table-bids text-center align-top"},
		],
		"order": [[0, 'asc']],
		"initComplete": function(table,data) {
			$("#dt_filter").val(config.projects.table.state.search.search);
			$("#projects-table").find("th:eq(1)").css('min-width','100px');
			$("#projects-table_length").val(config.projects.table.length);
		},
		"createdRow": function ( row, data, index ) {
			var title = $.sprintf('<a class="wdo-link word-break" href="%s">%s</a>',data.project.project_link,data.project.title);
			var category = $.sprintf('<br /><small><text class="text-purple strong">%s</text> / <text title="Был опубликован">%s</text></small>',data.project.cat_name,moment.unix(data.project.created).fromNow());
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
			if ( extra_title.length == 0 ) $('td', row).eq(3).removeClass('align-top');
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