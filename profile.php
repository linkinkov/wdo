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
$user_id = get_var("id","int",$_SESSION["user_id"]);
$user = new User($user_id);
// $user->get_responds_counters();
$self_profile = ( $current_user->user_id == $user->user_id ) ? true : false;
$user->get_counters();
if ( $self_profile )
{
}
// echo "Showing profile: $user_id";
// echo "<pre>";print_r($user);echo "</pre>";
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<?php include(PD.'/includes/html-head.php');?>
</head>
<body>

<?php include(PD.'/includes/mini-header.php');?>

<div class="container main-container">
	<div class="row bottom-shadow">
		<div class="col margins left"></div>
		<div class="col main">
			<div class="row">
				<div class="col wdo-main-left right-shadow">
					<div class="row">
						<div class="col text-center" style="padding-top: 20px;">
							<img class="rounded-circle" src="<?php echo $user->avatar_path;?>&w=150&h=150" />
							<i class="fa fa-circle text-success" id="online_tracker" style="display: none; position: absolute; right: 25px;" title="Сейчас на сайте"></i>
						</div>
					</div>
					<?php
					if ( $self_profile )
					{
					?>
					<div class="row">
						<div class="col">
							<hr />
							<a href="#scenario" class="wdo-link profile-link">
								<span class="fa-stack text-purple">
									<i class="fa fa-circle-o fa-stack-2x"></i>
									<i class="fa fa-star fa-stack-1x"></i>
								</span>
								Типовые сценарии
							</a>
						</div>
					</div>
					<div class="row"><div class="col"><hr /></div></div>
					<div class="row">
						<div class="col account-management">
							<h5 class="strong">Баланс: <text class="text-purple-dark"><i class="fa fa-rouble"></i> <?php echo number_format($user->get_balance(),0,","," ");?></text></h5>
							<div style="text-align: center; margin-top: 35px;">
								<h6 style="line-height: 1.6rem;"><a class="wdo-link" href="#">Пополнить баланс</a></h6>
								<h6 style="line-height: 1.6rem;"><a class="wdo-link" href="#">Вывести средства</a></h6>
								<h6 style="line-height: 1.6rem;"><a class="wdo-link" href="#">История транзакций</a></h6>
							</div>
						</div>
					</div>
					<?php
					}
					?>
					<div class="row">
						<div class="col">
							<hr />
							<h5>Контакты</h5>
							<hr />
						</div>
					</div>
					<div class="row">
						<div class="col">
							<p><span class="pull-right"><i title="Город" class="text-purple fa fa-map-marker fa-lg fa-fw"></i></span><?php echo $user->city_name;?></p>
							<p><span class="pull-right"><i title="Телефон" class="text-purple fa fa-mobile-phone fa-lg fa-fw"></i></span><?php echo ($user->phone) ? $user->phone : "Не указан";?></p>
							<p><span class="pull-right"><i title="Skype" class="text-purple fa fa-skype fa-lg fa-fw"></i></span><?php echo ($user->skype) ? $user->skype : "Не указан";?></p>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<hr />
							<h5>Статистика</h5>
							<hr />
						</div>
					</div>
					<div class="row">
						<div class="col">
							<p>Отзывов<span class="pull-right"><img title="Позитивных отзывов" src="/images/rating-good.png" /><?php echo $user->counters->responds->good;?> | <img title="Негативных отзывов" src="/images/rating-bad.png" /><?php echo $user->counters->responds->bad;?></span></p>
							<p>Заявок<span class="pull-right"><?php echo $user->counters->project_responds->created;?></span></p>
							<?php
							if ( $self_profile )
							{
							?>
							<p style="padding-left: 10px;"> - выигранных<span class="pull-right"><?php echo $user->counters->project_responds->won;?></span></p>
							<p style="padding-left: 10px;"> - сумма<span class="pull-right"><i class="fa fa-rouble"></i> <?php echo $user->counters->project_responds->won_sum;?></span></p>
							<?php
							}
							?>
							<p>Портфолио<span class="pull-right"><?php echo $user->counters->portfolio->created;?></span></p>
							<p>Рейтинг<span class="pull-right"><?php echo $user->rating;?></span></p>
							<p>В сервисе<span class="pull-right timestamp fromNow" data-timestamp="<?php echo $user->registered;?>"></span></p>
							<p>Предупреждений<span class="pull-right"><?php echo $user->counters->warnings;?></span></p>
							<p>Был онлайн<span class="pull-right timestamp last_login" data-timestamp="<?php echo $user->last_login;?>"></span></p>
						</div>
					</div>

				</div><!-- /.wdo-main-left -->
				<div class="col wdo-main-right" style="padding-top: 20px;">
					<div class="row">
						<div class="col">
							<ol class="breadcrumb" style="background-color: #f3f1f1;">
								<li class="breadcrumb-item"><a class="wdo-link text-purple" href="<?php echo HOST;?>/performers/">Исполнители</a></li>
								<li class="breadcrumb-item active"><?php echo $user->realUserName;?></li>
							</ol>
							<?php
							if ( !$self_profile )
							{
								$note = User::get_user_note($user->user_id);
								echo sprintf('<blockquote class="blockquote"><footer class="blockquote-footer">Ваша заметка</footer><p style="max-width: 400px;white-space: pre-wrap;word-wrap: break-word;" id="user_note">%s</p></blockquote>',$note["userNote"]);
							}
							?>
						</div>
						<div class="col" style="border-left: 1px solid #ccc;  flex: 0 0 35%; max-width: 35%; min-width: 35%; text-align: center;">
						<?php
						if ( $user->as_performer == 1 )
						{
						?>
						<?php
							echo implode(' / ',$user->get_top_categories());
						?>
							<hr />
						<?php
						}
						else
						{
							echo '<br /><br />';
						}
						?>
							<p><i class="fa fa-comments-o"></i> <a class="wdo-link" data-toggle="modal" data-target="#send-pm-modal" data-recipient="<?php echo $user->user_id;?>" data-realUserName="<?php echo $user->realUserName;?>">Написать сообщение</a></p>
							<p><i class="fa fa-pencil"></i> <a class="wdo-link" data-toggle="modal" data-target="#save-note-modal" data-recipient="<?php echo $user->user_id;?>" data-realUserName="<?php echo $user->realUserName;?>">Добавить заметку</a></p>
						<?php
						if ( $user->as_performer == 1 && !$self_profile )
						{
						?>
							<div class="wdo-btn bg-purple">Предложить работу</div>
						<?php
						}
						?>
						</div>
					</div>
					<div class="row"><div class="col"><hr style="margin-bottom: 0px;" /></div></div>
					<div class="row">
						<div class="col">
							<!-- Nav tabs -->
							<ul class="nav nav-tabs" role="tablist">
							<?php
							if ( $self_profile )
							{
								// $active = "project-responds";
								$active = "profile";
								$tabs = Array(
									"profile" => "Профиль",
									"projects" => "Мои проекты",
									"project-responds" => "Мои заявки",
									"portfolio" => "Портфолио",
									"messages" => "Сообщения",
									"responds" => "Отзывы"
								);
							}
							else
							{
								$active = "projects";
								$tabs = Array(
									"projects" => "Проекты",
									"portfolio" => "Портфолио",
									"responds" => "Отзывы"
								);
							}
							foreach ( $tabs as $id=>$tab_name )
							{
								$class = ($id == $active) ? "" : "";
								echo sprintf('
								<li class="nav-item">
									<a class="nav-link text-muted %s" data-toggle="tab" href="#%s" role="tab" data-pageid="%s">%s</a>
								</li>',$class,$id,$id,$tab_name);
							}
							?>
							</ul>
							<!-- Tab panes -->
							<div class="tab-content">
							<?php
							foreach ( $tabs as $id=>$tab_name )
							{
								$class = ($id == $active) ? "active" : "";
								$content = ($class == "active") ? '<div class="loader text-center" style="width: 100%;"><i class="fa fa-spinner fa-spin fa-3x"></i></div>' : '';
								echo sprintf('
								<div class="tab-pane %s" id="%s" role="tabpanel">%s</div>',$class,$id,$content);
							}
							?>
							</div>



						</div>
					</div>
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
	<?php echo sprintf('config.profile.user_id = "%d";',$user->user_id);?>
	console.log("showing user: ",config.profile.user_id);
	$(".timestamp").each(function(e){
		var title = moment.unix($(this).data('timestamp')).format("LLL");
		( $(this).hasClass("fromNow") )
		? $(this).text(moment.unix($(this).data('timestamp')).fromNow(true)).attr("title",title)
		: $(this).text(moment.unix($(this).data('timestamp')).fromNow()).attr("title",title);
		var pass = ($(this).data('timestamp') - parseInt(moment().format("X")));
		if ( pass > -60 && $(this).hasClass("last_login") )
		{
			$(this).parent().html('<text class="text-success">Сейчас на сайте</text>');
			$("#online_tracker").show();
		}
	})
	$('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
		var current_tab = e.target,
				prev_tab = e.relatedTarget,
				target_page = $(current_tab).data('pageid'),
				tab_content = $("#"+$(current_tab).data('pageid'));
		$("#"+$(prev_tab).data('pageid')).html('');
		$(tab_content).html('<div class="loader text-center" style="width: 100%;"><i class="fa fa-spinner fa-spin fa-3x"></i></div>');
		$.ajax({
			type: "POST",
			url: "/pp/"+target_page,
			dataType: "html",
			data: {
				"user_id": config.profile.user_id
			},
			success: function (response) {
				$(tab_content).append(response);
			}
		});
	})
	<?php echo sprintf('$("a[data-pageid=\'%s\']").click();',$active);?>

})
</script>