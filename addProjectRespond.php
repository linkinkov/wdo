<?php
require_once('_global.php');
include_once('_includes.php');
$job = get_var("job","string","");
if ( $job == "publish" )
{
	if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off")
	{
		$redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		header('Location: ' . $redirect, true, 301);
		exit();
	}
	$db = db::getInstance();
	check_access($db,false);

	$current_user = new User($_SESSION["user_id"]);
	$current_user->set_city_auto();

	$data = get_var("data","array",Array());
	// $data["for_project_id"] = $project->project_id;
	$response = ProjectRespond::publish($data);
	header('Content-Type: application/json');
	echo json_encode($response);
	exit;
}

if ( $current_user->user_id == 0 )
{
	$error = 401;
	include(PD.'/errors/error.php');
	exit;
}
$_SESSION["LAST_PAGE"] = "/addProjectPespond";
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
							<h44 class="text-purple strong">СОЗДАНИЕ ЗАЯВКИ НА ПРОЕКТ</h44>
						</div>
					</div>
				</div><!-- /.wdo-main-left -->
				<div class="invisible" id="project_id" data-project-id="<?php echo $project->project_id;?>"></div>
				<div class="col wdo-main-right" style="padding-top: 20px; padding-bottom: 0px;">
					<div class="row">
						<div class="col">
							<?php
							echo sprintf('
							<a class="wdo-link" href="%s"><h5 style="font-weight: 800;">%s</h5></a>
							<a class="wdo-link text-purple" href="%s">%s</a> / <a class="wdo-link text-purple" href="%s">%s</a>',
							parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH),
							$project->title,
							HOST.'/projects/'.$project->cat_name_translated.'/',$project->cat_name, // category href link
							HOST.'/projects/'.$project->cat_name_translated.'/'.$project->subcat_name_translated.'/',$project->subcat_name // subcategory href link
							);
							?>
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
							<input id="fileupload" type="file" name="files[]" multiple style="display: none;">
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
							<div class="wdo-btn btn-sm bg-purple disabled" id="submit" data-lt="Загрузка" data-ot="Опубликовать проект">Опубликовать заявку</div>
						</div>
					</div>
					<div class="row"><div class="col"><br /></div></div>

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
			(value === true) ? $("#submit").removeClass("disabled") : $("#submit").addClass("disabled");
		}
	})


	$("#submit").click(function(){
		if ( $(this).hasClass("disabled") ) return false;
		var ar = [],
				btn = $(this);
		$("input[data-name='youtube-link']").each(function(){
			if ( $(this).val() != "" )
				ar.push($(this).val())
		})
		var data = {
				"agreement": $("input[data-name='agreement']").prop("checked"),
				"cost": $("input[data-name='cost']").val(),
				"descr": $("textarea[data-name='descr']").val(),
				"youtube_links": ar,
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
		if ( data.descr == "" || data.descr === undefined ) {
			$("[data-name='descr']").addClass("warning");
			text = 'Введите описание заявки';
			error++;
		}
		data.for_project_id = $("#project_id").data('project-id');
		if ( error > 0 ) {
			( error == 1 ) ? $(this).text(text) : $(this).text('Пожалуйста, проверьте данные');
			return;
		}
		set_btn_state(btn,'loading');
		$.ajax({
			type: "POST",
			url: "/project_respond/publish",
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

})
</script>