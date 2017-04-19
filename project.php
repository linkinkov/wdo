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

if ( $project->status_id == 5 && $_SESSION["user_id"] != $project->user_id )
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
				<div class="invisible" id="project_id" data-project-id="<?php echo $project->project_id;?>"></div>
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
							$pu = new User($project->user_id);
							$pu->get_counters();
							echo sprintf('
							<a href="%s" class="wdo-link"><img class="rounded-circle" src="%s" />
							<br />
							%s</a>',
								HOST.'/profile/id'.$project->user_id,
								HOST.'/user.getAvatar?user_id='.$project->user_id.'&w=100&h=100',
								$pu->realUserName
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
								<div class="container">
									<p class="lead" style="white-space: pre-wrap;"><?php echo $project->descr;?></p>
								</div>
							</div>
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
$(function(){
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
				d.for_project_id = $("#project_id").data('project-id');
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
					attaches = $('<div/>',{class: "project-respond-attaches"}),
					header = $('<div/>',{class: "project-respond-header"}),
					header_html = '',
					html = ''
			+'<div class="row">'
			+'	<div class="col" style="border-right: 1px solid #eee;">'
			+'		<div class="row">'
			+'			<div class="col text-center" style="padding-top: 10px; max-width: 100px;">'
			+'				<img class="rounded-circle" src="'+data.user.avatar_path+'&w=50&h=50" /><br />'
			+'				'+moment.unix(data.respond.created).format("YYYY-MM-DD HH:MM")
			+'			</div>'
			+'			<div class="col" style="padding-top: 10px;padding-left: 0;">'
			+'				<a class="wdo-link underline" href="/profile/id'+data.user.user_id+'">'+data.user.realUserName+'</a>'
			+'				<br /><br /><p style="white-space: pre-wrap;">'+data.respond.descr+'</p>'
			+'			</div>'
			+'		</div>'
			+'	</div>'
			+'	<div class="col" style="min-width: 220px; max-width: 220px; flex: 0 0 220px;">'
			+'		<text style="line-height: 2rem;">Рейтинг <span class="pull-right">'+data.user.rating+'</span></text><br />'
			+'		<text style="line-height: 2rem;">Отзывов <span class="pull-right"><img src="/images/rating-good.png" /> '+data.user.counters.responds.good+' | <img src="/images/rating-bad.png" /> '+data.user.counters.responds.bad+'</span></text><br />'
			+'		<text style="line-height: 2rem;">В сервисе <span class="pull-right">'+moment.unix(data.user.registered).fromNow(true)+'</span></text><br />'
			if ( data.respond.cost )
			{
				html += '<hr /><div class="project-cost" style="margin: 0 auto;">'+data.respond.cost+' <i class="fa fa-rouble"></i></div>';
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
				}
				header_html = ''
				+'<div class="row">'
				+'	<div class="col">'
				+'		<i class="fa fa-comments-o"></i> <a class="wdo-link" data-toggle="modal" data-target="#send-pm-modal" data-recipient="'+data.respond.user_id+'" data-realUserName="'+data.user.realUserName+'">Написать сообщение</a> | <i class="fa fa-pencil"></i> <a class="wdo-link" data-toggle="modal" data-target="#save-note-modal" data-recipient="'+data.respond.user_id+'" data-realUserName="'+data.user.realUserName+'">Добавить заметку</a>'
				+'		<span class="pull-right">'+actions+'</span>'
				+'	</div>'
				+'</div>'
				header.html(header_html).appendTo($('td', row));
			}
			respond.html(html);
			respond.appendTo(container);
			container.appendTo($('td', row));
			if ( data.respond.attaches.length > 0 )
			{
				$.each(data.respond.attaches,function(){
					var object = '';
					if ( this.attach_type == 'image' )
					{
						object = '<a href="/get.Attach?attach_id='+this.attach_id+'&w=500"><img class="img-thumbnail" src="/get.Attach?attach_id='+this.attach_id+'&w=100&h=100" /></a>';
					}
					else if ( this.attach_type == 'video' )
					{
						object = '<a '
						+'	href="'+this.url+'"'
						+'	title="" type="text/html"'
						+'	data-youtube="'+this.youtube_id+'" poster="http://img.youtube.com/vi/'+this.youtube_id+'/0.jpg">'
						+'<img class="img-thumbnail" src="http://img.youtube.com/vi/'+this.youtube_id+'/0.jpg" />';
						+'</a>';
					}
					else if ( this.attach_type == 'document' )
					{
						object = '<a class="download" href="/get.Attach?attach_id='+this.attach_id+'"><img class="img-thumbnail" src="/images/document.png" /></a>';
					}
					$(attach_container).append(object);
				})
				$(attaches).html(attach_container);
				$(attaches).insertAfter(respond);
			}
		},
		"drawCallback": function( settings, table ) {
			$(".paginate_button > a").on("focus", function() {
				$(this).blur();
			});
			$(".gallery").click(function (event) {
				event = event || window.event;
				var target = event.target || event.srcElement,
						link = target.src ? target.parentNode : target,
						options = {index: link, event: event},
						// links = this.getElementsByTagName('a');
						links = $(this).find("a").not(".download");
				blueimp.Gallery(links, options);
			});
			$(".download").click(function(e){
				e.stopPropagation();
				e.preventDefault();
				var href = $(this).attr("href");
				window.open(href,'_blank');
			})
			$(".respond-action").click(function(e){
				$.ajax({
					type: "POST",
					url: "/update.project-respond",
					data: {
						"respond_id": $(this).data('respond_id'),
						"field": "status_id",
						"value": $(this).data('status_id')
					},
					dataType: "JSON",
					success: function (response) {
						respondsTable.ajax.reload(false,false);
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