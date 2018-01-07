<div class="slider" style="padding-left: 30px;">

<?php
require_once('../../_global.php');
require_once(PD.'/_includes.php');
// require(PD.'/admin/check_admin.php');

$db = db::getInstance();

check_access($db,false);
if ( !isset($current_user) || $current_user->user_id <= 0 || $current_user->template_id != 2 ) exit;

$respond_id = get_var("respond_id","int",false);
if ( !$respond_id )
{
	echo 'not found';
	exit;
}

$respond = new ProjectRespond($respond_id);
$ru = new User($respond->user_id);
$ru->get_counters();
?>

<div class="row">
	<div class="col">
		<h5>
			<a class="wdo-link" href="/profile/id<?php echo $ru->user_id;?>">
				<img class="rounded-circle" src="<?php echo $ru->avatar_path;?>" /> <?php echo $ru->real_user_name;?>
			</a>
		</h5>
	</div>
	<div class="col">
		<span class="pull-right">
			Рейтинг: <?php echo $ru->rating ;?> | 
			В сервисе: <text class="timestamp" data-format="fromNow" data-timestamp="<?php echo $ru->registered ;?>"></text> | 
			Был онлайн: <text class="timestamp" data-format="calendar" data-timestamp="<?php echo $ru->last_login ;?>"></text> | 
			Отзывы: <img title="Позитивных отзывов" src="/images/rating-good.png" /><?php echo $ru->counters->responds->good;?> | <img title="Негативных отзывов" src="/images/rating-bad.png" /><?php echo $ru->counters->responds->bad;?></span>
		</span>
	</div>
</div>
<hr />

<div class="row">
	<div class="col">
		<h5>Текст отзыва:</h5><?php echo htmlentities($respond->descr);?>
	</div>
</div>

<div class="respond-photos-container" style="display: none;">
	<div class="row"><div class="col"><hr /></div></div>
	<div class="row">
		<div class="col" style="max-width: 100px;">
			<h5>Фото</h5>
		</div>
		<div class="col gallery<?php echo $respond_id;?>" id="respond-photos<?php echo $respond_id;?>"></div>
	</div>
</div>

<div class="respond-videos-container" style="display: none;">
	<div class="row"><div class="col"><hr /></div></div>
	<div class="row">
		<div class="col" style="max-width: 100px;">
			<h5>Видео</h5>
		</div>
		<div class="col gallery<?php echo $respond_id;?>" id="respond-videos<?php echo $respond_id;?>"></div>
	</div>
</div>

<div class="respond-docs-container" style="display: none;">
	<div class="row"><div class="col"><hr /></div></div>
	<div class="row">
		<div class="col" style="max-width: 100px;">
			<h5>Документы</h5>
		</div>
		<div class="col" id="respond-docs<?php echo $respond_id;?>"></div>
	</div>
</div>

<?php
if ( $respond->arbitrage != false )
{
?>
<hr />
<div class="row">
	<div class="col">
		<div class="alert alert-warning">
			Заявка в арбитраж: <?php echo $respond->arbitrage->ticket_id;?>
		</div>
	</div>
</div>

<?php
}
?>
<hr />

<div class="btn-group" role="group" aria-label="respond actions">
	<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#warn-user-modal" data-respond_id="<?php echo $respond_id;?>" data-block_type="respond" data-recipient_id="<?php echo $ru->user_id;?>" data-real_user_name="<?php echo $ru->real_user_name;?>"><span class="fa-stack fa-lg"><i class="fa fa-birthday-cake fa-stack-1x"></i><i class="fa fa-ban fa-stack-2x text-danger"></i></span> Заблокировать отзыв и вынести предупреждение</button>
	<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#warn-user-modal" data-respond_id="<?php echo $respond_id;?>" data-block_type="user" data-recipient_id="<?php echo $ru->user_id;?>" data-real_user_name="<?php echo $ru->real_user_name;?>"><span class="fa-stack fa-lg"><i class="fa fa-user fa-stack-1x"></i><i class="fa fa-ban fa-stack-2x text-danger"></i></span> Заблокировать пользователя и вынести предупреждение</button>
	<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#conversation-modal" data-recipient_id="<?php echo $ru->user_id;?>" data-real_user_name="<?php echo $ru->real_user_name;?>"><i class="fa fa-comment-o fa-lg"></i> Отправить сообщение</button>
	<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" data-name="category" aria-haspopup="true" aria-expanded="false" style="width: 100%;"><i class="fa fa-cog"></i> Изменить статус</button>
	<div class="dropdown-menu dropdown-menu-right">
		<a class="dropdown-item pointer" data-trigger="update" data-type="respond" data-id="<?php echo $respond_id;?>" data-name="status_id" data-value="1" style="width: auto;">Опубликован</a>
		<a class="dropdown-item pointer" data-trigger="update" data-type="respond" data-id="<?php echo $respond_id;?>" data-name="status_id" data-value="4" style="width: auto;">Заблокирован</a>
	</div>
</div>
</div><!-- /.slider-->

