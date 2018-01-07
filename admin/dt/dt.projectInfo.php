<div class="slider" style="padding-left: 30px;">

<?php
require_once('../../_global.php');
require_once(PD.'/_includes.php');
// require(PD.'/admin/check_admin.php');

$db = db::getInstance();

check_access($db,false);
if ( !isset($current_user) || $current_user->user_id <= 0 || $current_user->template_id != 2 ) exit;

$project_id = get_var("project_id","int",false);
if ( !$project_id )
{
	echo 'not found';
	exit;
}

$project = new Project($project_id);
$pu = new User($project->user_id);
$pu->get_counters();
?>

<div class="row">
	<div class="col">
		<h5>
			<a class="wdo-link" href="/profile/id<?php echo $pu->user_id;?>">
				<img class="rounded-circle" src="<?php echo $pu->avatar_path;?>" /> <?php echo $pu->real_user_name;?>
			</a>
		</h5>
	</div>
	<div class="col">
		<span class="pull-right">
			Рейтинг: <?php echo $pu->rating ;?> | 
			В сервисе: <text class="timestamp" data-format="fromNow" data-timestamp="<?php echo $pu->registered ;?>"></text> | 
			Был онлайн: <text class="timestamp" data-format="calendar" data-timestamp="<?php echo $pu->last_login ;?>"></text> | 
			Отзывы: <img title="Позитивных отзывов" src="/images/rating-good.png" /><?php echo $pu->counters->responds->good;?> | <img title="Негативных отзывов" src="/images/rating-bad.png" /><?php echo $pu->counters->responds->bad;?></span>
		</span>
	</div>
</div>
<hr />

<div class="row">
	<div class="col">
		<span class="pull-right">
			<i class="fa fa-eye"></i> Просмотров: <?php echo $project->views;?> <br />
			<i class="fa fa-comments-o"></i> Заявок: <?php echo $project->get_responds_counter();?>
		</span>
		<h5>Описание проекта:</h5><?php echo htmlentities($project->descr);?>
	</div>
</div>

<div class="project-photos-container" style="display: none;">
	<div class="row"><div class="col"><hr /></div></div>
	<div class="row">
		<div class="col" style="max-width: 100px;">
			<h5>Фото</h5>
		</div>
		<div class="col gallery<?php echo $project_id;?>" id="project-photos<?php echo $project_id;?>"></div>
	</div>
</div>

<div class="project-videos-container" style="display: none;">
	<div class="row"><div class="col"><hr /></div></div>
	<div class="row">
		<div class="col" style="max-width: 100px;">
			<h5>Видео</h5>
		</div>
		<div class="col gallery<?php echo $project_id;?>" id="project-videos<?php echo $project_id;?>"></div>
	</div>
</div>

<div class="project-docs-container" style="display: none;">
	<div class="row"><div class="col"><hr /></div></div>
	<div class="row">
		<div class="col" style="max-width: 100px;">
			<h5>Документы</h5>
		</div>
		<div class="col" id="project-docs<?php echo $project_id;?>"></div>
	</div>
</div>

<hr />

<div class="btn-group" role="group" aria-label="Project actions">
	<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#warn-user-modal" data-project_id="<?php echo $project_id;?>" data-project_title="<?php echo $project->title;?>" data-block_type="project" data-recipient_id="<?php echo $pu->user_id;?>" data-real_user_name="<?php echo $pu->real_user_name;?>"><span class="fa-stack fa-lg"><i class="fa fa-birthday-cake fa-stack-1x"></i><i class="fa fa-ban fa-stack-2x text-danger"></i></span> Заблокировать проект и вынести предупреждение</button>
	<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#warn-user-modal" data-project_id="<?php echo $project_id;?>" data-project_title="<?php echo $project->title;?>" data-block_type="user" data-recipient_id="<?php echo $pu->user_id;?>" data-real_user_name="<?php echo $pu->real_user_name;?>"><span class="fa-stack fa-lg"><i class="fa fa-user fa-stack-1x"></i><i class="fa fa-ban fa-stack-2x text-danger"></i></span> Заблокировать пользователя и вынести предупреждение</button>
	<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#conversation-modal" data-recipient_id="<?php echo $pu->user_id;?>" data-real_user_name="<?php echo $pu->real_user_name;?>"><i class="fa fa-comment-o fa-lg"></i> Отправить сообщение</button>
<?php
if ( in_array($project->status_id,Array('1','2','5','6')) )
{
	$actions = '
		<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" data-name="category" aria-haspopup="true" aria-expanded="false" style="width: 100%;"><i class="fa fa-cog"></i> Изменить статус</button>
		<div class="dropdown-menu dropdown-menu-right">
			<a class="dropdown-item pointer" data-trigger="update" data-type="project" data-id="'.$project_id.'" data-name="status_id" data-value="1" style="width: auto;">Принять</a>
			<a class="dropdown-item pointer" data-trigger="update" data-type="project" data-id="'.$project_id.'" data-name="status_id" data-value="5" style="width: auto;">Отклонить</a>
			<a class="dropdown-item pointer" data-trigger="update" data-type="project" data-id="'.$project_id.'" data-name="status_id" data-value="6" style="width: auto;">На модерации</a>
		</div>
	';
}
else
{
	$actions = '';
}
echo $actions;
?>
</div>
</div><!-- /.slider-->

