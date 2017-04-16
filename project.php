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

$id = get_var("id","int");
$cat_name = get_var("cat_name","string");
$subcat_name = get_var("subcat_name","string");
$title = get_var("title","string");

if ( !$id ) die("wrong id");

$project = new Project($id);

if ( $project->status_id == 3 )
{
	header("Location: /404/",true,302);
}

?>


<!DOCTYPE html>
<html lang="ru">
<head>
<?php include(PD.'/includes/html-head.php');?>
</head>
<body>
<?php include(PD.'/includes/main-header.php');?>

<div class="container main-container">
	<div class="row bottom-shadow">
		<div class="col margins left"></div>
		<div class="col main">
			<div class="row">
				<div class="col wdo-main-left right-shadow">
					<div class="row">
						<div class="col">
							<h44 class="text-purple strong">КАК ПОДАТЬ ЗАЯВКУ</h44>
							<br /><br />
							<div class="row">
								<div class="col text-purple" style="flex: 0 0 10px; padding-right: 0;">1.</div>
								<div class="col"><a class="wdo-link text-purple" data-toggle="modal" data-target="#register-modal">Зарегистрируйтесь</a> как исполнитель</div>
							</div>
							<hr />
							<div class="row">
								<div class="col text-purple" style="flex: 0 0 10px; padding-right: 0;">2.</div>
								<div class="col">Внимательно изучите запрос и оставьте заявку на исполнение</div>
							</div>
							<hr />
							<div class="row">
								<div class="col text-purple" style="flex: 0 0 10px; padding-right: 0;">3.</div>
								<div class="col">Ожидайте выбора заказчика</div>
							</div>
							<hr />
							<div class="row">
								<div class="col text-purple" style="flex: 0 0 10px; padding-right: 0;">4.</div>
								<div class="col">Оставьте отзыв о заказчике в случае сотрудничества</div>
							</div>
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
				<div class="col wdo-main-right" style="padding: 30px;">
					<div class="row">
						<div class="col" style="flex: 0 0 75%; max-width: 75%;">
							<?php
							echo sprintf('
							<a class="wdo-link" href="%s"><h5 style="font-weight: 800;">%s</h5></a>
							<a class="wdo-link text-purple" href="%s">%s</a> / <a class="wdo-link text-purple" href="%s">%s</a> | <text class="timestamp" data-timestamp="%s"></text>',
							HOST.$_SERVER['REQUEST_URI'],
							$project->title,
							HOST.'/projects/'.strtolower(r2t($project->cat_name)).'/',$project->cat_name,
							HOST.'/projects/'.strtolower(r2t($project->cat_name)).'/'.strtolower(r2t($project->subcat_name)).'/',$project->subcat_name,
							$project->created
							);?>
							<span class="pull-right">
								<i class="fa fa-eye" title="Просмотров"></i> <text class="text-purple">15</text>
								<i class="fa fa-comment-o" title="Заявок"></i> <text class="text-purple">4</text>
							</span>
						</div>
						<div class="col">
							<span class="pull-right">
								<?php
								echo sprintf('
								<div class="project-cost">%s <i class="fa fa-rouble"></i></div>',
								number_format($project->cost,0,","," ")
								)
							?>
							</span>
						</div>
					</div>
					<div class="row"><div class="col"><hr /></div></div>
					<div class="row">
						<div class="col" style="flex: 0 0 60%; max-width: 60%;"><!-- info block -->
							<div class="row">
								<div class="col" style="flex: 0 0 180px; max-width: 180px; align-self: center;">
									<text class="text-muted">Прием заявок</text>
								</div>
								<div class="col">
									04.04.2017 - 08.04.2018<br />(осталось 4 дня)
								</div>
							</div>

							<div class="row"><div class="col"><hr /></div></div>
							<div class="row">
								<div class="col" style="flex: 0 0 180px; max-width: 180px; align-self: center;">
									<text class="text-muted">Дата проведения</text>
								</div>
								<div class="col">
									10.04.2017 - 15.04.2018
								</div>
							</div>

							<div class="row"><div class="col"><hr /></div></div>
							<div class="row">
								<div class="col" style="flex: 0 0 180px; max-width: 180px; align-self: center;">
									<text class="text-muted">Статус</text>
								</div>
								<div class="col">
									<text class="text-success">Открыт</text>
								</div>
							</div>
<!-- 
							<div class="row"><div class="col"><hr /></div></div>
							<div class="row">
								<div class="col" style="flex: 0 0 180px; max-width: 180px;">
									<text class="text-muted">Статистика</text>
								</div>
								<div class="col">
									Заявки:1 Просмотров: 4
								</div>
							</div>
-->
						</div>
						<div class="col" style="text-align: center;align-self: center;"><!-- user block -->
							<?php
							$pu = new User($project->user_id);
							$pu->getRespondsCounters();
							echo sprintf('
							<a href="%s" class="wdo-link"><img class="rounded-circle" src="%s" />
							<br />
							%s</a>',
								HOST.'/profile/id'.$project->user_id,
								HOST.'/get.UserAvatar?user_id='.$project->user_id.'&w=100&h=100',
								// HOST.'/profile/id'.$project->user_id,
								$pu->realUserName
							);
							echo sprintf('<br />
								<img src="%s" title="Положительных отзывов" /> %d | <img src="%s" title="Негативных отзывов" /> %d
							',
							HOST.'/images/rating-good.png',$pu->responds->good_counter,
							HOST.'/images/rating-bad.png',$pu->responds->bad_counter
							);
							?>
						</div>
					</div>
					<div class="row"><div class="col"><hr /></div></div>
					<div class="row">
						<div class="col">
							<div class="jumbotron jumbotron-fluid">
								<div class="container">
									<p class="lead" style="white-space: pre-wrap;"><?php echo $project->descr;?></p>
								</div>
							</div>
						</div>
					</div>
					<div class="row"><div class="col"><hr /></div></div>
					<h44 class="text-purple-dark strong">Заявки исполнителей</h44>

					<table class="table" id="project-responds-table">
						<thead>
							<th>Заявка</th>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div><!-- /.wdo-main-right -->
			</div>
		</div><!-- /.main -->
		<div class="col margins right">
		</div>
	</div>
</div>

<?php include(PD.'/includes/footer.php');?>
<?php include(PD.'/includes/modals.php');?>
<?php include(PD.'/includes/scripts.php');?>

<script>
$(function(){
	$(".timestamp").each(function(){
		var ts = $(this).data('timestamp');
		$(this).text(moment.unix(ts).fromNow());
		$(this).attr("title",moment.unix(ts).format("LLL"));
	})

	var responds = $("#project-responds-table").DataTable({
		"language": {"url": "/js/dataTables/dataTables.russian.lang"},
		"dom": 'tr<"row"<"col"p>>',
		"bProcessing": true,
		"bServerSide": true,
		"pagingType": "full_numbers",
		"ajax": {
			"url": "/dt/project-responds",
			"type": "POST",
			"data": function( d ) {
				d.for_project_id = 104;
				// d.length = function() {return parseInt(config.projects.table.length);};
				// d.showParams = config.projects.table;
				// d.status = function() {
				// 	var arr = [];
				// 	$(".subcategory.selected").each(function(){
				// 		arr.push($(this).data("subcat_id"));
				// 	})
				// 	return arr;
				// };
			}
		},
		// "bStateSave": true,
		"iDisplayLength": 10,
		"columns": [
			{"data": "respond_id","orderable": false, "targets": 0},
		],
		"initComplete": function(table,data) {
			// console.log(table);
			$("#project-responds-table").find("thead").hide();
		},
		"createdRow": function ( row, data, index ) {
			console.log(data);
			$('td', row).html('');
			var respond = jQuery('<div/>', {
				class: "project-respond"
			})
			var html = ''
			+'<div class="row">'
			+'	<div class="col" style="border-right: 1px solid #eee;">respond</div>'
			+'	<div class="col" style="min-width: 220px; max-width: 220px; flex: 0 0 220px;">'
			+'		Рейтинг <span class="pull-right">'+data.user.rating+'</span><br />'
			+'		Отзывов <span class="pull-right"><img src="/images/rating-good.png" /> '+data.user.responds.good_counter+' | <img src="/images/rating-bad.png" /> '+data.user.responds.bad_counter+'</span><br />'
			+'		В сервисе <span class="pull-right">'+data.user.registered+'</span><br />'
			+'		<hr />'
			+'		<div class="project-cost" style="margin: 0 auto;">'+data.respond.cost+' <i class="fa fa-rouble"></i></div>'
			+'	</div>'
			+'</div>'
			'';
			respond.html(html);
			respond.appendTo($('td', row));
/*
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
*/
		},
		"drawCallback": function( settings ) {
			$(".paginate_button > a").on("focus", function() {
				$(this).blur();
			});
		}
	})
})
</script>
</body>
</html>