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
if ( $current_user->user_id <= 0 )
{
	$error = 401;
	include(PD.'/errors/error.php');
	exit;
}
$job = get_var("job","string","");
$_SESSION["LAST_PAGE"] = "/addProject";
if ( $job == "publish" )
{
	$data = get_var("data","array",Array());
	$response = Project::publish($data);
	header('Content-Type: application/json');
	echo json_encode($response);
	exit;
}
$for_performer = get_var("for_performer","int",0);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<?php include(PD.'/includes/html-head.php');?>
</head>
<body>

<?php include(PD.'/includes/main-header.php');?>

<div class="container main-container">
	<div class="row">
		<div class="col margins left"></div>
		<div class="col main">
			<div class="row">
				<div class="col wdo-main-left right-shadow">
					<div class="row">
						<div class="col">
							<h44 class="text-purple strong">СОЗДАНИЕ НОВОГО ПРОЕКТА</h44>
						</div>
					</div>
				</div><!-- /.wdo-main-left -->
				<div class="col wdo-main-right" style="padding-top: 20px; padding-bottom: 0px;">
					<div class="row">
						<div class="col" style="flex: 0 0 280px; max-width: 280px; align-self: center;">
							<text class="text-muted">Выберите раздел</text>
						</div>
						<div class="col">
							<div class="btn-group" style="width: 100%;">
								<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" data-name="category" aria-haspopup="true" aria-expanded="false" style="width: 100%;">Категория</button>
								<div class="dropdown-menu cat-list" style="width: 100%;">
									<?php foreach ( Category::get_list() as $cat )
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
						<div class="col" style="flex: 0 0 280px; max-width: 280px; align-self: center;">
							<text class="text-muted">Выберите подраздел</text>
						</div>
						<div class="col">
							<div class="btn-group" style="width: 100%;">
								<button type="button" class="btn btn-secondary dropdown-toggle disabled" data-toggle="dropdown" data-name="subcategory" aria-haspopup="true" aria-expanded="false" style="width: 100%;">Подкатегория</button>
								<div class="dropdown-menu subcat-list" style="width: 100%;">
								</div>
							</div>
						</div>
					</div>

					<div class="row"><div class="col"><hr /></div></div>
					<div class="row">
						<div class="col" style="flex: 0 0 280px; max-width: 280px; align-self: center;">
							<text class="text-muted">Название</text>
						</div>
						<div class="col">
							<input type="text" class="form-control" data-name="title" placeholder="Название проекта, например: Фотограф на свадьбу" />
						</div>
					</div>

					<div class="row"><div class="col"><hr /></div></div>
					<div class="row">
						<div class="col" style="flex: 0 0 280px; max-width: 280px; align-self: center;">
							<text class="text-muted">Бюджет</text>
						</div>
						<div class="col">
							<input type="number" class="form-control" data-name="cost" placeholder="Бюджет в рублях" />
						</div>
					</div>

					<div class="row"><div class="col"><hr /></div></div>
					<div class="row">
						<div class="col" style="flex: 0 0 280px; max-width: 280px; align-self: center;">
							<text class="text-muted">Приём заявок до</text>
						</div>
						<div class="col">
							<input type="text" class="form-control" data-name="accept_till" data-timestamp="0" placeholder="Приём заявок до указанной даты" />
						</div>
					</div>

					<div class="row"><div class="col"><hr /></div></div>
					<div class="row">
						<div class="col" style="flex: 0 0 280px; max-width: 280px; align-self: center;">
							<text class="text-muted">Дата мероприятия</text>
						</div>
						<div class="col">
							<input type="text" class="form-control" data-name="start_end" data-timestamp_start="0" data-timestamp_end="0" placeholder="Дата мероприятия" />
						</div>
					</div>

					<div class="row"><div class="col"><hr /></div></div>
					<div class="row">
						<div class="col" style="flex: 0 0 280px; max-width: 280px; align-self: center;">
							<text class="text-muted">Описание</text>
						</div>
						<div class="col">
							<textarea class="form-control" rows="7" data-name="descr" placeholder="Детальное описание проекта"></textarea>
						</div>
					</div>

					<div class="row"><div class="col"><hr /></div></div>
					<div class="row">
						<div class="col" style="flex: 0 0 280px; max-width: 280px; align-self: center;">
							<text class="text-muted">Файлы</text>
						</div>
						<div class="col">
							
							<div id="uploaded" style="display: none;">
								<div class="attaches-container gallery">
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

					<div class="row"><div class="col"><hr /></div></div>
					<div class="row">
						<div class="col" style="flex: 0 0 280px; max-width: 280px; align-self: center;">
							<text class="text-muted">Видео</text>
						</div>
						<div class="col" id="yt_links">
							<small class="text-muted">Не более 6 ссылок</small>
							<input type="text" class="form-control empty" data-name="youtube-link" placeholder="Ссылка на ваше видео в YouTube" />
						</div>
					</div>

					<div class="row"><div class="col"><hr /></div></div>
					<div class="row">
						<div class="col">
							<text class="text-muted">Введите имя или название исполнителя, если хотите, чтобы проект был виден только ему</text>
							<input type="text" class="form-control" placeholder="Введите имя исполнителя" id="search_performer"/>
							<hr />
							<div id="performers" class="row text-center" style="align-items: center; display: none; border-bottom: 1px solid #ccc; padding-bottom: 15px; ">
								<?php
								if ( $for_performer > 0 && $for_performer != $current_user->user_id )
								{
									$fu = new User($for_performer);
									if ( $fu->as_performer == 1 )
									{
										echo sprintf('
											<div class="col performer_found active" data-user_id="%d">
												<div class="row" style="align-items: center;">
													<div class="col" style="max-width: 50px;">
														<img class="rounded-circle shadow" src="%s">
													</div>
													<div class="col">	
														%s
													</div>
												</div>
											</div>
										',$fu->user_id,$fu->avatar_path,$fu->real_user_name);
										echo '<script>document.getElementById("performers").style.display = "block";</script>';
									}
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


<div class="container main-container">
	<div class="row bottom-shadow">
		<div class="col margins left"></div>
		<div class="col main">
			<div class="row">
				<div class="col wdo-main-left right-shadow">
					<div class="row">
						<div class="col">
							<h44 class="text-purple strong">ХОТИТЕ НАЙТИ ИСПОЛНИТЕЛЯ БЫСТРЕЕ ?</h44>
						</div>
					</div>
				</div><!-- /.wdo-main-left -->
				<div class="col wdo-main-right" style="padding-top: 10px;">

					<div class="row">
						<div class="col" style="align-self: center;">
							<label class="custom-control custom-checkbox">
								<input type="checkbox" class="custom-control-input" data-name="vip">
								<span class="custom-control-indicator"></span>
								<span class="custom-control-description">
									<h6 class="text-purple strong">Поднятие в списке и выделение цветом на 7 дней</h6>
									<p class="text-muted">Ваше объявление в списке проектов будет всегда вверху списка и выделено цветом</p>
								</span>
							</label>
						</div>
						<div class="col" style="max-width: 130px;">
							<h3 class="text-purple">300 <i class="fa fa-rouble"></i></h3>
						</div>
					</div>

					<div class="row">
						<div class="col" style="align-self: center;">
							<label class="custom-control custom-checkbox">
								<input type="checkbox" class="custom-control-input" data-name="safe_deal">
								<span class="custom-control-indicator"></span>
								<span class="custom-control-description">
									<h6 class="text-purple strong">Я хочу использовать функционал "Безопасная сделка"</h6>
									<p class="text-muted">Арбитражная сделка. Средства на Вашем счёте будут заблокированы до завершения проекта</p>
								</span>
							</label>
						</div>
					</div>

					<div class="row"><div class="col"><hr /></div></div>
					<div class="row">
						<div class="col">
							<label class="custom-control custom-checkbox">
								<input type="checkbox" class="custom-control-input" data-name="agreement">
								<span class="custom-control-indicator"></span>
								<span class="custom-control-description" style="padding-top: 9px;">
									<h6 class="text-purple strong">Я согласен с правилами работы сервиса</h6>
									<p class="text-muted"></p>
								</span>
							</label>
						</div>
					</div>
					<div class="row"><div class="col"><hr /></div></div>
					<div class="row">
						<div class="col text-center">
							<div class="wdo-btn btn-sm bg-purple disabled" id="preview" data-lt="Загрузка" data-ot="Опубликовать проект">Опубликовать проект</div>
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
	$(".wdo-option[data-name='category']").click(function(){
		var cat_id = $(this).data('value');
		app.getSubCategories(cat_id,function(response){
			if ( response )
			{
				$(".subcat-list").html('');
				$.each(response,function(){
					$(".subcat-list").append($.sprintf('<a class="dropdown-item wdo-option" data-name="subcategory" data-value="%d" data-parentid="%d">%s</a>',this.id,this.parent_cat_id,this.subcat_name));
				})
				$(".dropdown-toggle[data-name='subcategory']").removeClass("disabled");
			}
		})
	})
	var upload_btn = $("label[for='fileupload']");
	var total_files = 0;
	var max_files = 10;
	$.get("/upload/",function(response){
		try {
			var resp = $.parseJSON(response),
					files = resp.files;
			if ( files.length > 0 )
			{
				var $form = $('#fileupload');
				$form.fileupload();
				$form.fileupload('option', 'done').call($form, $.Event('done'), {result: {files: files}});
				total_files = files.length;
			}
		}
		catch (msg)
		{
			console.log(msg);
		}
	})
	$('#fileupload').fileupload({
		dataType: 'json',
		url: '/upload/',
		change : function (e, data) {
			if(total_files>=max_files){
				alert("Максимум "+max_files+" файлов");
				return false;
			}
		},
		submit:  function (e, data) {
			if(total_files>=max_files){
				alert("Максимум "+max_files+" файлов");
				return false;
			}
			$("#uploaded").show();
			$(".progress").show();
			set_btn_state(upload_btn,"loading");
		},
		done: function (e, data) {
			$("#uploaded").show();
			$.each(data.result.files, function (index, file) {
				if ( file.error )
				{
					showAlert("error",file.error);
					return;
				}
				var is_image = /image/ig;
				if ( is_image.test(file.type) )
				{
					$(".attaches-container").append('<div class="project-upload-attach" data-filename="'+file.name+'"><a href="'+file.url+'"><img class="img-thumbnail" src="'+file.thumbnailUrl+'" /></a><br /><a data-filename="'+file.name+'" class="delete" href="'+file.deleteUrl+'">Удалить</a></div>');
				}
				else
				{
					$(".attaches-container").append('<div class="project-upload-attach" data-filename="'+file.name+'"><a class="download" href="'+file.url+'"><img class="img-thumbnail" width="50px" src="/images/document.png" /></a><br /><a data-filename="'+file.name+'" class="delete" href="'+file.deleteUrl+'">Удалить</a></div>');
				}
				total_files++;
			});
			$(".download").click(function(e){
				e.stopPropagation();
				e.preventDefault();
				var href = $(this).attr("href");
				window.open(href,'_blank');
			})
			$(".delete").click(function(e){
				e.stopPropagation();
				e.preventDefault();
				var link = $(this),
						href = $(link).attr("href"),
						data = $(link).data(),
						obj = $("div[data-filename='"+data.filename+"']");
				$.ajax({
					url: href,
					type: 'DELETE',
					dataType: "JSON",
					success: function(result) {
						if ( result[data.filename] == true )
						{
							$(obj).remove();
							if ( $(".attaches-container").children().length == 0 ) $("#uploaded").hide();
							total_files--;
						}
						return false;
					}
				});
				return false;
			})
		},
		acceptFileTypes: /(\.|\/)(gif|jpe?g|png|docx?|xlsx?|pdf)$/i,
		maxFileSize: 4000000,
		stop: function(e, data) {
			set_btn_state(upload_btn,"reset");
			$(".progress").hide();
		},
		progressall: function (e, data) {
			var progress = parseInt(data.loaded / data.total * 100, 10);
			$('.progress .progress-bar').css(
				'width',
				progress + '%'
			);
		}
	});
	$(".gallery").click(function (event) {
		event = event || window.event;
		var target = event.target || event.srcElement,
				link = target.src ? target.parentNode : target,
				options = {index: link, event: event},
				links = $(this).find("a").not(".download").not(".delete");
		blueimp.Gallery(links, options);
	});
	var current_links = [];
	$(document).on("keyup","input[data-name='youtube-link']",function(){
		if ( current_links.length >= 5 ) return;
		if ( ytVidId($(this).val()) && $.inArray($(this).val(),current_links) == -1 )
		{
			current_links.push($(this).val());
			$(this).removeClass("empty");
		}
		var empty = $("input.empty[data-name='youtube-link']");
		if ( empty.length == 0 ) $('<input type="text" class="form-control empty" data-name="youtube-link" placeholder="Ссылка на ваше видео в YouTube" />').appendTo("#yt_links");
	})

	$("input[type='checkbox']").on("change",function(e){
		var name = $(this).data('name'),
				value = $(this).prop('checked');
		if ( name == "agreement" )
		{
			(value === true) ? $("#preview").removeClass("disabled") : $("#preview").addClass("disabled");
		}
	})
	$(".wdo-option[data-name='category']").click(function(){
		$("button[data-name='subcategory']").text('Подкатегория');
	})
	var accept_till_opts = config.datePickerOptionsSingle;
	accept_till_opts.locale.format = "DD.MM.YYYY";
	accept_till_opts.showDropdowns = false;
	accept_till_opts.minDate = moment().add(1,"days");
	accept_till_opts.maxDate = moment().add(1,"years");
	accept_till_opts.startDate = moment().add(7,"days");
	$('input[data-name="accept_till"]').daterangepicker(accept_till_opts);
	$('input[data-name="accept_till"]').on('apply.daterangepicker', function(ev, picker) {
		$(this).data('timestamp',picker.startDate.format("X"));
	});
	$('input[data-name="accept_till"]').data('timestamp',accept_till_opts.startDate.format("X"));

	var start_end_opts = config.datePickerOptions;
	start_end_opts.locale.format = "DD.MM.YYYY";
	start_end_opts.showDropdowns = false;
	start_end_opts.minDate = moment().add(1,"days").format("DD.MM.YYYY");
	start_end_opts.maxDate = moment().add(1,"years").format("DD.MM.YYYY");
	start_end_opts.startDate = moment().add(7,"days");
	start_end_opts.endDate = moment().add(7,"days");
	start_end_opts.dateLimit = {months: 1},
	start_end_opts.separator = " / ";
	$('input[data-name="start_end"]').daterangepicker(start_end_opts);
	$('input[data-name="start_end"]').on('apply.daterangepicker', function(ev, picker) {
		$(this).data('timestamp_start',picker.startDate.format("X"));
		$(this).data('timestamp_end',picker.endDate.format("X"));
	});
	$('input[data-name="start_end"]').data('timestamp_start',start_end_opts.startDate.format("X"));
	$('input[data-name="start_end"]').data('timestamp_end',start_end_opts.endDate.format("X"));

	$("#preview").click(function(){
		if ( $(this).hasClass("disabled") ) return false;
		var ar = [],
				btn = $(this);
		$("input[data-name='youtube-link']").each(function(){
			if ( $(this).val() != "" )
				ar.push($(this).val())
		})
		var data = {
				"agreement": $("input[data-name='agreement']").prop("checked"),
				"vip": $("input[data-name='vip']").prop("checked"),
				"safe_deal": $("input[data-name='safe_deal']").prop("checked"),
				"cat_id": $(".wdo-option.active[data-name='category']").data('value'),
				"subcat_id": $(".wdo-option.active[data-name='subcategory']").data('value'),
				"title": $("input[data-name='title']").val(),
				"cost": $("input[data-name='cost']").val(),
				"accept_till": $("input[data-name='accept_till']").data('timestamp'),
				"start_date": $("input[data-name='start_end']").data('timestamp_start'),
				"end_date": $("input[data-name='start_end']").data('timestamp_end'),
				"descr": $("textarea[data-name='descr']").val(),
				"youtube_links": ar,
				"for_user_id": $(".performer_found.active").data('user_id')
			},
			error = 0,
			text = '';
			// https://www.youtube.com/watch?v=aJaRUYE3C-I
			// youtu.be/H9mNjb9XYy8
		$(".warning").removeClass("warning");
		if ( data.agreement != true ) {
			text = 'Примите правила работы сервиса';
			error++;
		}
		if ( data.cat_id <= 0 || data.cat_id === undefined ) {
			$("button[data-name='category']").addClass("warning");
			text = 'Выберите категорию';
			error++;
		}
		if ( data.subcat_id <= 0 || data.subcat_id === undefined ) {
			$("button[data-name='subcategory']").addClass("warning");
			text = 'Выберите подкатегорию';
			error++;
		}
		if ( data.title == "" || data.title === undefined ) {
			$("[data-name='title']").addClass("warning");
			text = 'Введите название проекта';
			error++;
		}
		if ( data.descr == "" || data.descr === undefined ) {
			$("[data-name='descr']").addClass("warning");
			text = 'Введите описание проекта';
			error++;
		}
		if ( data.accept_till <= 0 || data.accept_till === undefined ) {
			$("[data-name='accept_till']").addClass("warning");
			text = 'Укажите "Приём заявок до"';
			error++;
		}
		if ( data.start_date <= 0 || data.start_date === undefined || data.end_date <= 0 || data.end_date === undefined ) {
			$("[data-name='start_end']").addClass("warning");
			text = 'Укажите дату мероприятия';
			error++;
		}
		if ( error > 0 ) {
			( error == 1 ) ? $(this).text(text) : $(this).text('Пожалуйста, проверьте данные');
			return;
		}
		set_btn_state(btn,'loading');
		$.ajax({
			type: "POST",
			url: "/project/publish",
			xhrFields: {withCredentials: true},
			data: {"data": data},
			dataType: "JSON",
			success: function (response) {
				if ( response.message )
				{
					set_btn_state(btn,'reset',response.message);
				}
				else
				{
					set_btn_state(btn,'reset');
				}
				if ( response.result == "true" )
				{
					window.location = response.project_link;
				}
			}
		})
	})
	var search_performer = "";
	$("#search_performer").keyup(function(){
		var search = $(this).val();
		if ( search == "" ) $("#performers").html('');
		if ( search == search_performer ) return;
		console.log("search:",search,", search_performer:",search_performer);
		search_performer = search;
		$.ajax({
			type: "POST",
			url: "/get.UserList",
			data: {"search":search},
			dataType: "JSON",
			success: function (response) {
				$("#performers").html('');
				if ( response.length > 0 )
				{
					$.each(response,function(){
						var obj = $('<div class="col performer_found" data-user_id="'+this.user_id+'">'
						+'<div class="row" style="align-items: center;">'
						+'	<div class="col" style="max-width: 50px;">'
						+'		<img class="rounded-circle shadow" src="'+this.avatar_path+'&w=35&h=35" />'
						+'	</div>'
						+'	<div class="col">'
						+'		'+this.real_user_name+''
						+'	</div>'
						+'</div>');
						$(obj).appendTo("#performers");
					})
					$("#performers_separator").show();
				}
			}
		});
	})
})
$(document).on("click",".performer_found",function(e){
	if ( $(this).hasClass("active") )
	{
		$(this).toggleClass("active");
		return;
	};
	$(".performer_found").removeClass("active");
	$(this).addClass("active");
})

</script>
</body>
</html>