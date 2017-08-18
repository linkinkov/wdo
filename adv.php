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
						<div class="col" style="max-width: 190px; align-self: center;">
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
						<div class="col" style="max-width: 190px; align-self: center;">
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
						<div class="col" style="max-width: 190px; align-self: center;">
							<text class="text-muted">Заголовок<br /><small>(осталось символов: <label for="title">30</label>)</small></text>
						</div>
						<div class="col">
							<input type="text" maxlength="30" class="form-control" data-trigger="update-preview" data-name="title" placeholder="Заголовок объявления, например: Фотограф на свадьбу" />
						</div>
					</div>

					<div class="row"><div class="col"><hr /></div></div>
					<div class="row">
						<div class="col" style="max-width: 190px; align-self: center;">
							<text class="text-muted">Описание<br /><small>(осталось символов: <label for="descr">40</label>)</small></text>
						</div>
						<div class="col">
							<textarea class="form-control" maxlength="40" rows="3" data-trigger="update-preview" data-name="descr" placeholder="Пара слов о себе"></textarea>
						</div>
					</div>

					<div class="row"><div class="col"><hr /></div></div>
					<div class="row">
						<div class="col" style="max-width: 190px; align-self: center;">
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
						<div class="col" style="max-width: 190px; align-self: center;">
							<text class="text-muted">Предпросмотр</text>
						</div>
						<div class="col">
							<div class="row">
								<div class="col hidden">
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
								</div>
								<div class="col">
									<div class="user-adv">
										<div class="col">
											<div class="top-block">
												<div class="logo"><img id="adv-logo" class="rounded-circle shadow" width="80" avatar_path="/user.getAvatar?user_id=<?php echo $current_user->user_id;?>&w=80&h=80" src="/user.getAvatar?user_id=<?php echo $current_user->user_id;?>&w=80&h=80" /></div>
												<div class="title word-break">Заголовок вашего объявления</div>
											</div>
											<div class="bottom-block">
												<div class="descr word-break">Здесь Ваш текст объявления</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col" style="max-width: 190px; align-self: center;">
						</div>
						<div class="col">
							<div class="row">
								<div class="col">
									<label class="custom-control custom-checkbox" style="padding-left: 2.5rem;">
										<input type="checkbox" class="custom-control-input" checked="checked" data-name="use_avatar">
										<span class="custom-control-indicator"></span>
										<span class="custom-control-description" style="padding-top: 10px;"><h6 class="text-purple">Использовать аватар</h6></span>
									</label>
								</div>
								<div class="col">
									<label id="fileupload_label" for="fileupload" class="wdo-btn bg-yellow disabled" data-lt="Загрузка..." data-ot="Выберите изображение">Выберите изображение</label>
									<input id="fileupload" type="file" name="adv_logo[]" style="display: none;" accept=".png,.jpg,.jpeg">
								</div>
							</div>
						</div>
					</div>

					<div class="row"><div class="col"><hr /></div></div>
					<div class="row">
						<div class="col" style="max-width: 190px; align-self: top;">
							<text class="text-muted">Автоподнятие</text>
						</div>
						<div class="col">
							<text class="text-purple">Лимит</text> <input type="number" value="0" class="form-control" style="display: inline-block; max-width: 100px;" min="0" max="10000" /> <text class="text-purple">руб.</text>
							<span class="pull-right">
								<text class="text-purple">Период</text> <input type="number" value="0" class="form-control" style="display: inline-block; max-width: 70px;" min="0" max="31" /> <text class="text-purple">дней</text>
								<!-- <input type="number" class="form-control" style="display: inline-block; max-width: 100px;" min="0" max="24" /> <text class="text-purple">часов</text> -->
							</span>
							<br />
							<small class="text-muted">
								<br /><b>Лимит</b> - сумма, в пределах которой будет происходить автоподнятие (после каждого она уменьшается), если не указан, но есть период, то автоподнятие будет постоянным
								<br /><b>Период</b> - период времени для автоподятия (например, поднимать каждые 5 дней)
								<br /><i>Отсчёт периода ведется от момента последнего поднятия</i>
							</small>
						</div>
					</div>

					<div class="row"><div class="col"><hr /></div></div>
					<div class="row">
						<div class="col" style="max-width: 190px; align-self: center;"></div>
						<div class="col">
							<div class="wdo-btn btn-sm bg-purple" data-toggle="adv_action" data-action="to_moderate">Отправить на модерацию</div>
							<div class="wdo-btn btn-sm bg-yellow" data-toggle="adv_action" data-action="to_drafts">Сохранить черновик</div>
						</div>
					</div>


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
$(function(){
	var upload_btn = $("label[for='fileupload']");
	$('#fileupload').fileupload({
		dataType: 'json',
		url: '/upload/',
		submit:  function (e, data) {
			set_btn_state(upload_btn,"loading");
		},
		done: function (e, data) {
			$.each(data.result.adv_logo, function (index, file) {
				if ( file.error )
				{
					showAlert("error",file.error);
					return;
				}
				var is_image = /image/ig;
				if ( is_image.test(file.type) )
				{
					$("#adv-logo").attr("src",file.thumbnailUrl).attr("uploaded_thumbnail",file.thumbnailUrl);
				}
				else
				{
					return false;
				}
			});
		},
		acceptFileTypes: /(\.|\/)(jpe?g|png)$/i,
		maxFileSize: 4000000,
		stop: function(e, data) {
			set_btn_state(upload_btn,"reset");
		},
		processfail: function(e,data) {
			$.each(data.files, function (index, file) {
				if ( file.error )
				{
					showAlert("error","("+file.name+"):"+file.error);
				}
			})
		}
	});
	var fields_value = [];
	fields_value["title"] = "";
	fields_value["descr"] = "";
	$("[data-trigger='update-preview']").keyup(function(e){
		var name = $(this).data("name"),
				value = $(this).val(),
				maxlength = $(this).attr("maxlength"),
				label = $("label[for='"+name+"']");
		if ( value == fields_value[name] ) return;
		fields_value[name] = value;
		$(label).html((maxlength - fields_value[name].length));
		$(".user-adv").find("."+name).html(value);
	})

	$("input[type='checkbox']").on("change",function(e){
		var name = $(this).data('name'),
				value = $(this).prop('checked');
		if ( name == "use_avatar" )
		{
			if (value === false)
			{
				$("#fileupload_label").removeClass("disabled");
				if ( $("#adv-logo").attr("uploaded_thumbnail") != "" )
					$("#adv-logo").attr("src",$("#adv-logo").attr("uploaded_thumbnail"));
			}
			else
			{
				$("#fileupload_label").addClass("disabled");
				$("#adv-logo").attr("src",$("#adv-logo").attr("avatar_path"));
			}
		}
	})
})
</script>
</body>
</html>