<?php
if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off")
{
	$redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	header('Location: ' . $redirect, true, 301);
	exit();
}
require_once('_global.php');
include_once('_includes.php');
$db = db::getInstance();
check_access($db,false);

$current_user = new User($_SESSION["user_id"]);
$current_user->set_city_auto();

$id = get_var("id","int");
$cat_name = get_var("cat_name","string");
$subcat_name = get_var("subcat_name","string");
$title = get_var("title","string");

if ( !$id ) die("wrong id");
$ref = isset($_SESSION["LAST_PAGE"]) ? trim($_SESSION["LAST_PAGE"]) : false;
if ( $ref == "profile/project-responds" )
{
	$data["ts_project_responds"] = time();
	$current_user->update_profile_info($data);
}
$_SESSION["LAST_PAGE"] = "/project";

$project = new Project($id);

if ( $project->error == true || ($project->status_id == 5 && $current_user->user_id != $project->user_id) )
{
	$error = 404;
	include(PD.'/errors/error.php');
	exit;
}
if ( $project->for_user_id > 0 && $current_user->user_id != $project->for_user_id && $current_user->user_id != $project->user_id )
{
	$error = 404;
	include(PD.'/errors/error.php');
	exit;
}

if ( isset($_GET["add_respond"]) )
{
	include("project-respond.php");
	exit;
}
$window_title = $project->title;

$pu = new User($project->user_id);
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
					<?php include(PD.'/includes/left-list-adv.php');?>
					<?php include(PD.'/includes/left-list-top-10.php');?>
				</div><!-- /.wdo-main-left -->
				<div class="invisible" id="project_id" data-project-id="<?php echo $project->project_id;?>"></div>
				<div class="invisible" id="project_user_id" data-project-user-id="<?php echo $pu->user_id;?>" data-project-user-name="<?php echo $pu->real_user_name;?>"></div>
				<div class="col wdo-main-right" style="padding: 30px;">
					<div class="row">
						<div class="col" style="flex: 0 0 75%; max-width: 75%;">
							<?php
							echo sprintf('
							<a class="wdo-link" href="%s"><h5 style="font-weight: 800;">%s</h5></a>
							<a class="wdo-link text-purple" href="%s">%s</a> / <a class="wdo-link text-purple" href="%s">%s</a> | <text class="timestamp" data-timestamp="%s"></text>',
							HOST.$_SERVER['REQUEST_URI'],
							$project->title,
							HOST.'/projects/'.$project->cat_name_translated.'/',$project->cat_name, // category href link
							HOST.'/projects/'.$project->cat_name_translated.'/'.$project->subcat_name_translated.'/',$project->subcat_name, // subcategory href link
							$project->created
							);?>
							<span class="pull-right">
								<i class="fa fa-eye" title="Просмотров"></i> <text class="text-purple"><?php echo $project->views;?></text>
								<i class="fa fa-comment-o" title="Заявок"></i> <text class="text-purple"><?php echo $project->get_responds_counter();?></text>
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
									<text class="text-muted">Прием заявок до</text>
								</div>
								<div class="col">
									<?php echo date("d.m.Y",$project->accept_till);?><text class="text-muted pull-right"><text class="accept_till" data-timestamp="<?php echo $project->accept_till;?>"></text></text>
								</div>
							</div>

							<div class="row"><div class="col"><hr /></div></div>
							<div class="row">
								<div class="col" style="flex: 0 0 180px; max-width: 180px; align-self: center;">
									<text class="text-muted">Дата проведения</text>
								</div>
								<div class="col" style="display: flex;align-items: center;justify-content: space-between;">
									<?php
									if ( $project->continuous == 1 )
									{
										echo ' с ' . date("d.m.Y",$project->start_date);
										echo '<br /> по ' . date("d.m.Y",$project->end_date);
									}
									else
									{
										echo date("d.m.Y",$project->start_date);
									}
									?>
									<text class="text-muted pull-right"><text class="accept_till" data-timestamp="<?php echo $project->start_date;?>"></text></text>
								</div>
							</div>

							<div class="row"><div class="col"><hr /></div></div>
							<div class="row">
								<div class="col" style="flex: 0 0 180px; max-width: 180px; align-self: center;">
									<text class="text-muted">Статус</text>
								</div>
								<div class="col">
								<?php
								switch ( $project->status_id )
								{
									case 1:
										$status_class = "text-success";
										break;
									case 2:
										$status_class = "text-info";
										break;
									case 3:
										$status_class = "text-purple";
										break;
									case 4:
										$status_class = "text-warning";
										break;
									case 5:
										$status_class = "text-danger";
										break;
									case 6:
										$status_class = "text-warning";
										break;
									default:
										$status_class = "text-muted";
										break;
								}
								echo sprintf('<text class="%s">%s</text>',$status_class,$project->status_name);
								?>
								</div>
							</div>
							<?php
							if ( $project->for_user_id > 0 )
							{
							?>
							<div class="row"><div class="col"><hr /></div></div>
							<div class="row">
								<div class="col" style="flex: 0 0 180px; max-width: 180px; align-self: center;">
									<text class="text-muted">Назначен</text>
								</div>
								<div class="col">
							<?php
								echo sprintf('<i class="fa fa-user-secret" title="Проект доступен только одному пользователю"></i> <a href="/profile/id%d" class="wdo-link">%s</a>',$project->for_user_id,User::get_real_user_name($project->for_user_id));
							?>
								</div>
							</div>
							<?php
							}
							if ( strlen($project->for_event_id) == 32 )
							{
							?>
							<div class="row"><div class="col"><hr /></div></div>
							<div class="row">
								<div class="col" style="align-self: center;">
									<span class="fa-stack text-purple" title="Проект создан через мастер праздников">
										<i class="fa fa-circle-o fa-stack-2x"></i>
										<i class="fa fa-star fa-stack-1x"></i>
									</span>
									<a class="wdo-link" href="/profile/#scenarios">
							<?php
								echo $db->getValue("user_scenarios","title","title",Array("event_id"=>$project->for_event_id,"user_id"=>$current_user->user_id));
							?>
									</a>
								</div>
							</div>
							<?php
							}
							if ( $project->status_id == 5 )
							{
								$reason = $db->getValue("warnings","message","message",Array("for_project_id"=>$project->project_id));
							?>
								<div class="row"><div class="col"><hr /></div></div>
								<div class="row">
									<div class="col">
										<?php echo sprintf('<blockquote class="blockquote"><p class="mb-0 text-danger strong">%s</p></blockquote>',$reason);?>
									</div>
								</div>
							<?php
								
							}
							?>
						</div>
						<div class="col text-center" style="align-self: center;"><!-- user block -->
							<?php
							$pu->get_counters();
							echo sprintf('
							<a href="%s" class="wdo-link"><img class="rounded-circle shadow" src="%s" />
							<br />
							%s</a>',
								HOST.'/profile/id'.$project->user_id,
								HOST.'/user.getAvatar?user_id='.$project->user_id.'&w=100&h=100',
								$pu->real_user_name
							);
							echo sprintf('<br />
								<img src="%s" title="Положительных отзывов" /> %d | <img src="%s" title="Негативных отзывов" /> %d
							',
							HOST.'/images/rating-good.png',$pu->counters->responds->good,
							HOST.'/images/rating-bad.png',$pu->counters->responds->bad
							);
							?>
						</div>
					</div>
					<div class="row"><div class="col"><hr /></div></div>
					<div class="row">
						<div class="col">
							<div class="jumbotron jumbotron-fluid">
								<div class="container" style="max-width: 700px;">
									<p class="lead" style="white-space: pre-wrap;"><?php echo $project->descr;?></p>
								</div>
							</div>
						</div>
					</div>

					<div class="project-photos-container" style="display: none;">
						<div class="row"><div class="col"><hr /></div></div>
						<div class="row">
							<div class="col" style="max-width: 100px;">
								Фото
							</div>
							<div class="col gallery" id="project-photos"></div>
						</div>
					</div>

					<div class="project-videos-container" style="display: none;">
						<div class="row"><div class="col"><hr /></div></div>
						<div class="row">
							<div class="col" style="max-width: 100px;">
								Видео
							</div>
							<div class="col gallery" id="project-videos"></div>
						</div>
					</div>

					<div class="project-docs-container" style="display: none;">
						<div class="row"><div class="col"><hr /></div></div>
						<div class="row">
							<div class="col" style="max-width: 100px;">
								Документы
							</div>
							<div class="col" id="project-docs"></div>
						</div>
					</div>

					<?php
					if ( $pu->user_id != $current_user->user_id )
					{
					?>
					<div class="row"><div class="col"><hr /></div></div>
					<?php
					}
					?>
					<div class="row">
						<div class="col text-center">
							<?php
							if ( $current_user->user_id == 0 )
							{
								echo sprintf('<a class="wdo-btn text-white btn-sm bg-purple" data-toggle="modal" data-target="#login-modal">Подать заявку</a>');
							}
							else if ( $pu->user_id != $current_user->user_id && $current_user->as_performer == 1 )
							{
								$already_has_respond = intval($db->getValue("project_responds","COUNT(`respond_id`)","counter",Array("user_id"=>$current_user->user_id,"for_project_id"=>$project->project_id)));
								if ( $project->status_id != 1 )
								{
									echo sprintf('<div class="wdo-btn btn-sm bg-purple disabled">'.$project->status_name.'</div>');
								}
								else if ( $already_has_respond == 0 )
								{
									echo sprintf('<a href="?add_respond" id="add_respond" class="wdo-btn btn-sm bg-purple" data-ot="Подать заявку" data-lt="Загрузка">Подать заявку</a>',$project->project_id);
								}
								else
								{
									echo sprintf('<div class="wdo-btn btn-sm bg-purple disabled">У вас уже есть заявка на данный проект</div>');
								}
							}
							?>
						</div>
					</div>


					<div class="row"><div class="col"><hr /></div></div>
					<h44 class="text-purple-dark strong">Заявки исполнителей</h44>
					<?php if ( $project->is_project_author == 1 )
					{
					?>
					<span class="pull-right">
						<div data-status="0" class="responds-filter responds-filter-all checked"></div>
						<div data-status="2" class="responds-filter responds-filter-deny"></div>
						<div data-status="1" class="responds-filter responds-filter-no-status"></div>
						<div data-status="3" class="responds-filter responds-filter-ispolnitel"></div>
					</span>
					<?php
					}
					?>
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
function toggle_respond_result_body(respond_id)
{
	$(".project-respond-result-body[data-respond_id='"+respond_id+"']").slideToggle('medium', function() {
		if ($(this).is(':visible'))
			$(this).css('display','flex');
	});
}
$(function(){
	var project_id = $("#project_id").data('project-id');
	app.project.getAttachList(project_id,function(response){
		if ( response.length > 0 )
		{
			var att_p = 0,
					att_v = 0,
					att_d = 0;
			$.each(response,function(){
				var object = app.formatter.format_portfolio_attach(this);
				if ( this.attach_type == 'image' )
				{
					$("#project-photos").append(object);
					att_p++;
				}
				else if ( this.attach_type == 'video' )
				{
					$("#project-videos").append(object);
					att_v++;
				}
				else if ( this.attach_type == 'document' )
				{
					$("#project-docs").append(object);
					att_d++;
				}
			});
			if ( att_p > 0 ) $(".project-photos-container").show();
			if ( att_v > 0 ) $(".project-videos-container").show();
			if ( att_d > 0 ) $(".project-docs-container").show();
		}
	})
	$(".timestamp").each(function(){
		var ts = $(this).data('timestamp');
		$(this).text(moment.unix(ts).fromNow());
		$(this).attr("title",moment.unix(ts).format("LLL"));
	})
	$(".accept_till").each(function(){
		var ts = $(this).data('timestamp');
		$(this).text(moment.unix(ts).fromNow());
		$(this).attr("title",moment.unix(ts).fromNow());
	})
	var respondsTable = $("#project-responds-table").DataTable({
		"language": {"url": "/js/dataTables/dataTables.russian.lang"},
		"dom": 'tr<"row"<"col"p>>',
		"bProcessing": true,
		"bServerSide": true,
		"pagingType": "full_numbers",
		"ajax": {
			"url": "/dt/project-responds",
			"type": "POST",
			"data": function( d ) {
				d.for_project_id = project_id;
				d.status_id = $(".responds-filter.checked").data('status');
			}
		},
		"iDisplayLength": 10,
		"columns": [
			{"data": "respond_id","orderable": false, "targets": 0},
		],
		"initComplete": function(table,data) {
			$("#project-responds-table").find("thead").hide();
		},
		"createdRow": function ( row, data, index ) {
			$('td', row).html('');
			var container = $('<div />', {class: "project-respond-container"}),
					respond = $('<div/>', {class: "project-respond"}),
					attach_container = $('<div/>',{class: "attach-container gallery"}),
					attaches = $('<div/>',{class: "attaches"}),
					header = $('<div/>',{class: "project-respond-header"}),
					header_html = '',
					actions_bottom = '',
					html = ''
			+'<div class="row">'
			+'	<div class="col" style="border-right: 1px solid #eee;">'
			+'		<div class="row">'
			+'			<div class="col text-center" style="padding-top: 20px; max-width: 100px;">'
			+'				<img class="rounded-circle shadow" src="'+data.user.avatar_path+'&w=50&h=50" /><br />'
			+'				'+moment.unix(data.respond.created).format("YYYY-MM-DD HH:MM")
			+'			</div>'
			+'			<div class="col" style="padding-top: 20px;padding-left: 0;">'
			+'				<a class="wdo-link underline" href="/profile/id'+data.user.user_id+'">'+data.user.real_user_name+'</a>'
			+'				<br /><br /><p style="white-space: pre-wrap;">'+data.respond.descr+'</p>'
			+'			</div>'
			+'		</div>'
			+'	</div>'
			+'	<div class="col" style="max-width: 165px;padding-top: 15px;">'
			+'		<text style="line-height: 2rem;">Рейтинг <span class="pull-right">'+data.user.rating+'</span></text><br />'
			+'		<text style="line-height: 2rem;">Отзывов <span class="pull-right"><img src="/images/rating-good.png" /> '+data.user.counters.responds.good+' | <img src="/images/rating-bad.png" /> '+data.user.counters.responds.bad+'</span></text><br />'
			+'		<text style="line-height: 2rem;">В сервисе <span class="pull-right">'+moment.unix(data.user.registered).fromNow(true)+'</span></text><br />'
			if ( data.respond.cost )
			{
				html += '<hr /><div class="project-cost" style="margin: 20px auto;">'+data.respond.cost+' <i class="fa fa-rouble"></i></div>';
			}
			html += ''
			+'	</div>'
			+'</div>';
			if ( data.is_project_author == 1 )
			{
				var actions = '';
				if ( data.respond.status_id == 1 )
				{
					actions = ''
					+'<a class="wdo-link respond-action" data-respond_id="'+data.respond_id+'" data-status_id="2">'
					+'	<img src="/images/respond-deny.png"'
					+'			 onmouseover="this.src=\'/images/respond-deny-hover.png\'"'
					+'			 onmouseout="this.src=\'/images/respond-deny.png\'"/>'
					+'</a>'
					+'<a class="wdo-link respond-action" data-respond_id="'+data.respond_id+'" data-status_id="3">'
					+'	<img src="/images/respond-select-ispoln.png"'
					+'			 onmouseover="this.src=\'/images/respond-select-ispoln-hover.png\'"'
					+'			 onmouseout="this.src=\'/images/respond-select-ispoln.png\'"/>'
					+'</a>';
				}
				else if ( data.respond.status_id == 2 )
				{
					actions = ''
					+'<a class="wdo-link respond-action" data-respond_id="'+data.respond_id+'" data-status_id="2">'
					+'	<img src="/images/respond-deny-checked.png" />'
					+'</a>';
				}
				else if ( data.respond.status_id == 3 )
				{
					actions = ''
					+'<a class="wdo-link respond-action" data-respond_id="'+data.respond_id+'" data-status_id="3">'
					+'	<img src="/images/respond-select-ispoln-checked.png" />'
					+'</a>';
					actions_bottom = ''
					+'<div class="row" style="border: 3px solid #cecd48;">'
					+'	<div class="col">'
					+'		<div class="row">'
					+'			<div class="col text-center project-respond-result" onClick="toggle_respond_result_body('+data.respond_id+')">Принять работу</div>'
					+'		</div>'
					+'		<div class="row project-respond-result-body" data-respond_id="'+data.respond_id+'">'
					+'			<div class="col">'
					+'					<div class="row">'
					+'						<div class="col"><small class="text-muted">Ваша оценка работы исполнителя</small></div>'
					+'					</div>'
					+'					<div class="row">'
					+'						<div class="col" style="padding: 20px;">'
					+'							<div class="row" style="align-items: center;">'
					+'								<div class="col" style="max-width:55px;">'
					+'									<img class="rounded-circle shadow" src="/user.getAvatar?user_id='+$("#project_user_id").data("project-user-id")+'&w=55&h=55" />'
					+'								</div>'
					+'								<div class="col" style="max-width: 180px;">'
					+'									<text class="text-purple strong">'+$("#project_user_id").data("project-user-name")+'</text>'
					+'								</div>'
					+'								<div class="col">'
					+'									<ul class="set-rating">'
					+'										<li class="rating-grade" data-respond_id="'+data.respond_id+'">1</li>'
					+'										<li class="rating-grade" data-respond_id="'+data.respond_id+'">2</li>'
					+'										<li class="rating-grade" data-respond_id="'+data.respond_id+'">3</li>'
					+'										<li class="rating-grade" data-respond_id="'+data.respond_id+'">4</li>'
					+'										<li class="rating-grade" data-respond_id="'+data.respond_id+'">5</li>'
					+'										<li class="rating-grade" data-respond_id="'+data.respond_id+'">6</li>'
					+'										<li class="rating-grade" data-respond_id="'+data.respond_id+'">7</li>'
					+'										<li class="rating-grade" data-respond_id="'+data.respond_id+'">8</li>'
					+'										<li class="rating-grade" data-respond_id="'+data.respond_id+'">9</li>'
					+'										<li class="rating-grade" data-respond_id="'+data.respond_id+'">10</li>'
					+'									</ul>'
					+'								</div>'
					+'							</div>'
					+'						</div>'
					+'					</div>'
					+'					<div class="row" style="padding: 10px;">'
					+'						<div class="col" style="border: 1px solid rgba(0,0,0,0.1);">'
					+'							<div class="row" style="align-items: center;">'
					+'								<div class="col" style="border-right: 1px dotted #ccc;">'
					+'									<img src="/images/arrow-down-transparent.png" style="position: absolute;top: -2px;left: 28px;background-color: #fff;">'
					+'									<textarea class="form-control respond-text" placeholder="Ваш отзыв" rows="3"></textarea>'
					+'								</div>'
					+'								<div class="col text-center" style="max-width: 100px;padding-top: 10px;">'
					+'									<img style="border: 0;" src="/images/rating-good-big.png" class="rating-ico" /><br />'
					+'									<h4 class="rating-grade-value" style="display: inline-block;">0</h4> <small class="rating-grade-text">баллов</small>'
					+'								</div>'
					+'							</div>'
					+'						</div>'
					+'					</div>'
					+'					<div class="row">'
					+'						<div class="col wave">'
					+'						</div>'
					+'					</div>'
					+'					<div class="row">'
					+'						<div class="col" style="background-color: #ece7e7;margin-top: -10px;">'
					+'							<div class="row" style="padding: 15px 0px; align-items: center;">'
					+'								<div class="col">'
					+'									Я согласен принять работу исполнителя и перечислить оплату с моего лицевого счета на счет исполнителя'
					+'								</div>'
					+'								<div class="col" style="display: flex; max-width: 240px; justify-content: space-between;">'
					+'									<div class="wdo-btn bg-white btn-sm" onClick="toggle_respond_result_body('+data.respond_id+')">Отменить</div>'
					+'									<div class="wdo-btn bg-yellow btn-sm" onClick="app.project.acceptRespond('+data.respond_id+',this)" data-lt="Загрузка" data-ot="Принять работу">Принять работу</div>'
					+'								</div>'
					+'							</div>'
					+'						</div>'
					+'					</div>'
					+'			</div>'
					+'		</div>'
					+'	</div>'
					+'</div>'
				}
				
				header_html = ''
				+'<div class="row">'
				+'	<div class="col">'
				+'		<i class="fa fa-comments-o"></i> <a class="wdo-link" data-toggle="modal" data-target="#conversation-modal" data-recipient_id="'+data.respond.user_id+'" data-real_user_name="'+data.user.real_user_name+'">Написать сообщение</a> | <i class="fa fa-pencil"></i> <a class="wdo-link" data-toggle="modal" data-target="#save-note-modal" data-recipient="'+data.respond.user_id+'" data-real_user_name="'+data.user.real_user_name+'">Добавить заметку</a>'
				+'		<span class="pull-right">'+actions+'</span>'
				+'	</div>'
				+'</div>';
				header.html(header_html).appendTo($('td', row));
			}
			if ( data.respond.status_id == 5 )
			{
				actions_bottom = ''
				+'<div class="row" style="border: 3px solid #cecd48;">'
				+'	<div class="col">'
				+'		<div class="row">'
				+'			<div class="col text-center project-respond-result">Работа принята ('+moment.unix(data.respond.modify_timestamp).calendar()+')</div>'
				+'		</div>'
				+'	</div>'
				+'</div>';
			}
			respond.html(html);
			respond.appendTo(container);
			container.appendTo($('td', row));
			if ( data.respond.attaches.length > 0 )
			{
				$.each(data.respond.attaches,function(){
					var object = app.formatter.format_portfolio_attach(this);
					if ( this.attach_type == 'document' )
					{
						$(attach_container).append("<br />" + object);
					}
					else
					{
						$(attach_container).append(object);
					}
				})
				$(attaches).html(attach_container);
			}
			$(attaches).insertAfter(respond);
			$(actions_bottom).insertAfter(attaches);
		},
		"drawCallback": function( settings, table ) {
			$(".paginate_button > a").on("focus", function() {
				$(this).blur();
			});
			autosize($(".respond-text"));
			$(".gallery").click(function (event) {
				event = event || window.event;
				var target = event.target || event.srcElement,
						link = target.src ? target.parentNode : target,
						options = {index: link, event: event,
						onopen: function(){
							$(".portfolio-image-action").hide();
						}
						},
						links = $(this).find("a").not(".download");
				blueimp.Gallery(links, options);
			});
			$(".respond-action").click(function(e){
				// if ( $(this).data('status_id') == 3 ) return false;
				$.ajax({
					type: "POST",
					url: "/project_respond/update",
					data: {
						"respond_id": $(this).data('respond_id'),
						"field": "status_id",
						"value": $(this).data('status_id')
					},
					dataType: "JSON",
					success: function (response) {
						if ( response.result == "false" )
						{
							showAlert("error",response.message);
						}
						else respondsTable.ajax.reload(false,false);
					}
				});
			})
		}
	})
	$(".responds-filter").click(function(){
		$(".responds-filter").removeClass("checked");
		$(this).addClass("checked");
		respondsTable.ajax.reload(false,true);
	})
})
</script>
</body>
</html>

<?php
if ( !in_array($project->project_id,$_SESSION["viewed_projects"]) )
{
	$_SESSION["viewed_projects"][] = $project->project_id;
	$project->update("views",$project->views+1);
}
?>