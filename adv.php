<?php
if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off")
{
	$redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	header('Location: ' . $redirect, true, 301);
	exit();
}
require_once('_global.php');
include_once('_includes.php');

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
						<div class="col">
							<br />
							<h44 style="font-size: 1.6rem;" class="text-purple text-roboto-cond-bold">СОЗДАНИЕ И РЕДАКТИРОВАНИЕ ОБЪЯВЛЕНИЯ</h44>
						</div>
					</div>
				</div><!-- /.wdo-main-left -->
				<div class="col wdo-main-right">

					<div class="row">
						<div class="col" style="flex: 0 0 200px; max-width: 200px; align-self: center;">
							<text class="text-muted">Выберите раздел</text>
						</div>
						<div class="col">
							<div class="btn-group" style="width: 100%;">
								<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" data-name="category" aria-haspopup="true" aria-expanded="false" style="width: 100%;">Раздел</button>
								<div class="dropdown-menu cat-list" style="width: 100%;">
									<?php
									foreach ( Category::get_list() as $cat )
									{
										echo sprintf('<a class="dropdown-item wdo-option" data-name="category" data-value="%d">%s</a>',$cat->id,$cat->cat_name);
									}
									?>
								</div>
							</div>
						</div>
					</div>

					<div class="row"><div class="col"><hr /></div></div>
					<div class="row">
						<div class="col" style="flex: 0 0 200px; max-width: 200px; align-self: center;">
							<text class="text-muted">Выберите подраздел</text>
						</div>
						<div class="col">
							<div class="btn-group" style="width: 100%;">
								<button type="button" class="btn btn-secondary dropdown-toggle disabled" data-toggle="dropdown" data-name="subcategory" aria-haspopup="true" aria-expanded="false" style="width: 100%;">Подраздел</button>
								<div class="dropdown-menu subcat-list" style="width: 100%;">
								</div>
							</div>
						</div>
					</div>

					<div class="row"><div class="col"><hr /></div></div>
					<div class="row">
						<div class="col" style="flex: 0 0 200px; max-width: 200px; align-self: center;">
							<text class="text-muted">Заголовок<br /><small>(до 50 символов)</small></text>
						</div>
						<div class="col">
							<input type="text" maxlength="50" class="form-control" data-name="title" placeholder="Заголовок объявления, например: Фотограф на свадьбу" />
						</div>
					</div>

					<div class="row"><div class="col"><hr /></div></div>
					<div class="row">
						<div class="col" style="flex: 0 0 200px; max-width: 200px; align-self: center;">
							<text class="text-muted">Описание<br /><small>(до 60 символов)</small></text>
						</div>
						<div class="col">
							<textarea class="form-control" maxlength="60" rows="7" data-name="descr" placeholder="Детальное описание проекта"></textarea>
						</div>
					</div>

					<div class="row"><div class="col"><hr /></div></div>
					<div class="row">
						<div class="col" style="flex: 0 0 200px; max-width: 200px; align-self: center;">
							<text class="text-muted">Ссылка</text>
						</div>
						<div class="col">
							<div class="btn-group" style="width: 100%;">
								<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" data-name="adv-link-to" aria-haspopup="true" aria-expanded="false" style="width: 100%;">Мой профиль</button>
								<div class="dropdown-menu adv-link-to-list" style="width: 100%;">
									<a class="dropdown-item wdo-option active" data-name="adv-link-to" data-value="profile">Мой профиль</a>
									<div class="dropdown-divider"></div>
									<h6 class="dropdown-header">Портфолио</h6>
									<?php
									foreach ( Portfolio::get_list($current_user->user_id) as  $pf )
									{
										echo sprintf('<a class="dropdown-item wdo-option" data-name="adv-link-to" data-value="%d">%s</a>',$pf->portfolio_id,$pf->title);
									}
									?>
								</div>
							</div>
							<small class="text-muted">Ссылка, на которую будет вести объявление, только в пределах биржи.  Если ссылка не указана, то переход по объявлению будет на профиль автора.</small>
						</div>
					</div>

					<div class="row"><div class="col"><hr /></div></div>
					<div class="row">
						<div class="col" style="flex: 0 0 200px; max-width: 200px; align-self: center;">
							<text class="text-muted">Изображение</text>
						</div>
						<div class="col">
							<div id="uploaded" style="display: none;">
								<div class="attaches-container gallery text-center">
									<!--<a href="/get.Attach?attach_id=1&w=500"><img class="img-thumbnail" src="/get.Attach?attach_id=1&w=100&h=100" /></a>-->
								</div>
								<hr />
								<div class="progress">
									<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
								<br />
							</div>
							<label for="fileupload" class="wdo-btn bg-purple" data-lt="Загрузка..." data-ot="Выберите файлы">Выберите файлы (<small>Не более 10</small>)</label>
							<input id="fileupload" type="file" name="files[]" multiple style="display: none;" accept=".png,.jpg,.jpeg,.gif,.pdf,.xls,.xlsx,.doc,.docx">
						</div>
					</div>
					<div class="row">
						<div class="col" style="flex: 0 0 200px; max-width: 200px; align-self: center;">
						</div>
						<div class="col">
							<label class="custom-control custom-checkbox" style="padding-left: 2.5rem;">
								<input type="checkbox" class="custom-control-input">
								<span class="custom-control-indicator"></span>
								<span class="custom-control-description" style="padding-top: 10px;"><h6 class="text-purple">Использовать аватар</h6></span>
							</label>
						</div>
					</div>

dfdf

<br /><br /><br />
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
</script>
</body>
</html>