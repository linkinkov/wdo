<div class="slider" style="padding-left: 30px;">

<?php
require_once('../../_global.php');
require_once(PD.'/_includes.php');
// require(PD.'/admin/check_admin.php');

$db = db::getInstance();

check_access($db,false);
if ( !isset($current_user) || $current_user->user_id <= 0 || $current_user->template_id != 2 ) exit;

$ticket_id = get_var("ticket_id","string",false);
if ( !$ticket_id )
{
	echo 'not found';
	exit;
}

$ticket = new Arbitrage($ticket_id);
$project_user = new User($db->getValue("project","user_id","user_id",Array("project_id"=>$ticket->project_id)));
$respond_user = new User($db->getValue("project_responds","user_id","user_id",Array("respond_id"=>$ticket->respond_id)));
?>
<div class="row">
	<div class="col">
		<h5>Участники:</h5>
		<span style="line-height: 50px; width: 100px; display: inline-block;">Заказчик:</span> <?php echo sprintf('<img class="rounded-circle shadow" src="%s"/> <a href="%s">%s</a>',$project_user->avatar_path,HOST.'/profile/id'.$project_user->user_id,$project_user->real_user_name);?>
		<br />
		<span style="line-height: 50px; width: 100px; display: inline-block;">Исполнитель:</span> <?php echo sprintf('<img class="rounded-circle shadow" src="%s"/> <a href="%s">%s</a>',$respond_user->avatar_path,HOST.'/profile/id'.$respond_user->user_id,$respond_user->real_user_name);?>
	</div>
</div>

<hr />

<div class="row">
	<div class="col">
		<h5>Текст претензии:</h5>
		<blockquote class="blockquote"><?php echo htmlentities($ticket->descr);?></blockquote>
	</div>
</div>

<hr />

<div class="row">
	<div class="col">
		<h5>История изменений</h5>
	</div>
</div>

<br />

<div class="ticket-messages" data-ticket_id="<?php echo $ticket_id;?>">
<?php
foreach ( $ticket->get_comments() as $comment )
{
	// print_r($comment);
	echo sprintf('<blockquote class="blockquote">%s<footer class="blockquote-footer">%s @ <text class="timestamp" data-timestamp="%d"></text></footer></blockquote>',
	$comment->message,$comment->real_user_name,$comment->timestamp);
}
if ( $ticket->status_id == 3 ) exit;
?>
</div>
<div class="row">
	<div class="col">
		<textarea class="form-control comment-message" data-ticket_id="<?php echo $ticket_id;?>" placeholder="Текст сообщения" rows="5"></textarea>
	</div>
	<div class="col">
		<button class="btn btn-success" data-lt="Отправка..." data-ot="Отправить" data-trigger="send-ticket-comment" data-ticket_id="<?php echo $ticket_id;?>">Отправить</button>
	</div>
</div>

<hr />

<div class="btn-group" role="group" aria-label="ticket actions">
	<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#resolve-ticket-modal" data-ticket_id="<?php echo $ticket_id;?>" data-profit_for="project_user">Вернуть средства заказчику</button>
	<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#resolve-ticket-modal" data-ticket_id="<?php echo $ticket_id;?>" data-profit_for="respond_user">Зачислить средства исполнителю</button>
</div>
</div><!-- /.slider-->

