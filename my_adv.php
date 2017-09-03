<?php
if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off")
{
	$redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	header('Location: ' . $redirect, true, 301);
	exit();
}
require_once('_global.php');
include_once('_includes.php');

$counters["1"] = $db->getValue("adv","COUNT(`adv_id`)","counter",array("user_id"=>$current_user->user_id,"status_id"=>1));
$counters["2"] = $db->getValue("adv","COUNT(`adv_id`)","counter",array("user_id"=>$current_user->user_id,"status_id"=>2));
$counters["3"] = $db->getValue("adv","COUNT(`adv_id`)","counter",array("user_id"=>$current_user->user_id,"status_id"=>3));
$counters["4"] = $db->getValue("adv","COUNT(`adv_id`)","counter",array("user_id"=>$current_user->user_id,"status_id"=>4));
$counters["5"] = $db->getValue("adv","COUNT(`adv_id`)","counter",array("user_id"=>$current_user->user_id,"status_id"=>5));

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
				<div class="col wdo-main-right" id="wdo-main-right">


					<div class="row">
						<div class="col">
							<h4 class="text-purple text-roboto-cond-bold">МОИ ОБЪЯВЛЕНИЯ</h4>
						</div>
					</div>
					<div class="row"><div class="col"><hr /></div></div>
					<div class="row">
						<div class="col">
							<div class="adv-filter active" data-toggle="filter_status" data-value="1">Активные (<?php echo $counters["1"];?>)</div>
							<div class="adv-filter" data-toggle="filter_status" data-value="2">На модерации (<?php echo $counters["2"];?>)</div>
							<div class="adv-filter" data-toggle="filter_status" data-value="3">Черновики (<?php echo $counters["3"];?>)</div>
							<div class="adv-filter" data-toggle="filter_status" data-value="4">Архив (<?php echo $counters["4"];?>)</div>
							<div class="adv-filter" data-toggle="filter_status" data-value="5">Отклоненные (<?php echo $counters["5"];?>)</div>
						</div>
					</div>
					<div class="row"><div class="col"><hr /></div></div>
					<div class="row">
						<div class="col">
							<div id="user_advs" style="display: flex;flex-wrap: wrap;"></div>
						</div>
					</div>

					<div class="row"><div class="col"><hr /></div></div>

					<div class="row">
						<div class="col">
							<h4 class="text-purple text-roboto-cond-bold">Создать / Редактировать</h4>
						</div>
					</div>
					<div class="row"><div class="col"><hr /></div></div>
					<input type="hidden" id="adv_id" data-adv_id="" />
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
								<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" data-name="portfolio_id" aria-haspopup="true" aria-expanded="false" style="width: 100%;">Мой профиль</button>
								<div class="dropdown-menu portfolio_id_list" style="width: 100%;">
									<a class="dropdown-item wdo-option active" data-name="portfolio_id" data-value="0">Мой профиль</a>
									<div class="dropdown-divider"></div>
									<h6 class="dropdown-header">Портфолио</h6>
									<?php
									foreach ( Portfolio::get_list($current_user->user_id) as  $pf )
									{
										echo sprintf('<a class="dropdown-item wdo-option" data-name="portfolio_id" data-value="%d">%s</a>',$pf->portfolio_id,$pf->title);
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
								<div class="col" id="preview">
									<div class="user-adv preview">
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
							<text class="text-purple">Лимит</text> <input type="number" data-name="prolong_limit" value="0" class="form-control" style="display: inline-block; max-width: 100px;" min="0" max="10000" /> <text class="text-purple">руб.</text>
							<span class="pull-right">
								<text class="text-purple">Период</text> <input type="number" data-name="prolong_days" value="0" class="form-control" style="display: inline-block; max-width: 70px;" min="0" max="31" /> <text class="text-purple">дней</text>
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
							<div class="wdo-btn btn-sm bg-purple" data-toggle="adv_action" data-action="create" data-draft="0">Отправить на модерацию</div>
							<div class="wdo-btn btn-sm bg-yellow" data-toggle="adv_action" data-action="create" data-draft="1">Сохранить черновик</div>
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

function load_my_advs(status_id)
{
	var data = {
		"status_id": status_id
	};
	$("#user_advs").html('');
	$("[data-toggle='filter_status']").removeClass("active");
	$("[data-toggle='filter_status'][data-value='"+status_id+"']").addClass("active");
	app.adv.action("load_user_advs",status_id,function(response)
	{
		if ( response.length > 0 && !typeof response.result !== 'undefined' )
		{
			$.each(response,function(i,v){
				var item = app.formatter.format_adv(v);
				$("#user_advs").append(item);
			})
		}
		$("#user_advs").find(".user-adv").each(function(i,v){
			$(v).click(function(){
				load_single_adv($(this).data());
				$("html, body").animate({ scrollTop: $('#wdo-main-right').offset().top }, 500);
			}).addClass("preview");
		})
	})
}

function load_single_adv(adv_id)
{
	app.adv.action("load",adv_id,function(response){
		console.log("click, loaded");
		$(".wdo-option[data-name='category']").removeClass("active");
		$(".wdo-option[data-name='category'][data-value='"+response.cat_id+"']").addClass("active");
		$("button[data-name='category']").text($(".wdo-option[data-name='category'][data-value='"+response.cat_id+"']").text());
		app.getSubCategories(response.cat_id,function(subresponse){
			if ( subresponse )
			{
				$(".subcat-list").html('');
				$.each(subresponse,function(){
					$(".subcat-list").append($.sprintf('<a class="dropdown-item wdo-option" data-name="subcategory" data-value="%d" data-parentid="%d">%s</a>',this.id,this.parent_cat_id,this.subcat_name));
				})
				$(".dropdown-toggle[data-name='subcategory']").removeClass("disabled");
				$(".wdo-option[data-name='subcategory'][data-value='"+response.subcat_id+"']").click();
			}
		})
		$(".wdo-option[data-name='portfolio_id']").removeClass("active");
		$(".wdo-option[data-name='portfolio_id'][data-value='"+response.portfolio_id+"']").addClass("active");
		$("button[data-name='portfolio_id']").text($(".wdo-option[data-name='portfolio_id'][data-value='"+response.portfolio_id+"']").text());
		$("input[data-name='title']").val(response.title);
		$("textarea[data-name='descr']").val(response.descr);
		$("#adv_id").attr("adv_id",response.adv_id).data('adv_id',response.adv_id);
		$("input[data-name='prolong_limit']").val(response.prolong_limit);
		$("input[data-name='prolong_days']").val(response.prolong_days);
		$("#preview").find(".title").html(response.title);
		$("#preview").find(".descr").html(response.descr);
		$("[data-trigger='update-preview']").trigger("keyup");
	})
}

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
		$("#preview").find("."+name).html(value);
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
	$("[data-toggle='adv_action']").click(function(){
		var action = $(this).data("action");
		var data = {
			"cat_id": $(".wdo-option.active[data-name='category']").data('value'),
			"subcat_id": $(".wdo-option.active[data-name='subcategory']").data('value'),
			"portfolio_id": $(".wdo-option.active[data-name='portfolio_id']").data('value'),
			"title": $("input[data-name='title']").val(),
			"descr": $("textarea[data-name='descr']").val(),
			"adv_id": $("#adv_id").data('adv_id'),
			"prolong_limit": $("input[data-name='prolong_limit']").val(),
			"prolong_days": $("input[data-name='prolong_days']").val(),
			"as_draft": $(this).data("draft")
		}
		app.adv.action(action,data,function(response)
		{
			if ( response.result == "false" )
			{
				showAlert("error",response.message);
				return;
			}
			// window.location.reload();
			showAlert("info",response.message);
		})
	})
	$("[data-toggle='filter_status']").click(function(){
		var data = $(this).data();
		load_my_advs(data.value);
	})
	load_my_advs(1);
	
})
</script>
</body>
</html>