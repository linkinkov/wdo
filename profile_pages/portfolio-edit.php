<?php

if ( $current_user->user_id == 0 || $user->user_id != $current_user->user_id )
{
	header('HTTP/1.0 401 Unauthorized',true,401);
	exit;
}
$portfolio_id = get_var("portfolio_id","int",0);
if ( $portfolio_id <= 0 ) exit("error");
$pf = Portfolio::get_portfolio($portfolio_id);
if ( $pf["result"] == "true" )
{
	$pf = $pf["portfolio"];
}
else
{
	exit("error");
}
// print_r($pf);
?>

<div class="row">
	<div class="col" style="flex: 0 0 280px; max-width: 280px; align-self: center;">
		<a class="wdo-link" onClick="showThisPf();">Вернуться к просмотру</a>
	</div>
</div>
<div class="row">
	<div class="col" style="flex: 0 0 280px; max-width: 280px; align-self: center;">
		<text class="text-muted">Выберите раздел</text>
	</div>
	<div class="col">
		<div class="btn-group" style="width: 100%;">
			<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" data-name="category" aria-haspopup="true" aria-expanded="false" style="width: 100%;"><?php echo $pf->cat_name;?></button>
			<div class="dropdown-menu cat-list" style="width: 100%;">
				<?php
				foreach ( Category::get_list() as $cat )
				{
					$class = ( $cat->id == $pf->cat_id ) ? 'active' : '';
					echo sprintf('<a class="dropdown-item wdo-option %s" data-name="category" data-value="%d">%s</a>',$class,$cat->id,$cat->cat_name);
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
			<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" data-name="subcategory" aria-haspopup="true" aria-expanded="false" style="width: 100%;"><?php echo $pf->subcat_name;?></button>
			<div class="dropdown-menu subcat-list" style="width: 100%;">
				<?php
				foreach ( SubCategory::get_list($pf->cat_id) as $subcat )
				{
					$class = ( $subcat->id == $pf->subcat_id ) ? 'active' : '';
					echo sprintf('<a class="dropdown-item wdo-option %s" data-name="subcategory" data-value="%d">%s</a>',$class,$subcat->id,$subcat->subcat_name);
				}
				?>
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
		<input type="text" class="form-control" data-name="title" placeholder="Название портфолио, например: Свадьба Алёны и Максима" value="<?php echo htmlspecialchars_decode(filter_string($pf->title,'out'));?>"/>
	</div>
</div>

<div class="row"><div class="col"><hr /></div></div>
<div class="row">
	<div class="col" style="flex: 0 0 280px; max-width: 280px; align-self: center;">
		<text class="text-muted">Описание</text>
	</div>
	<div class="col">
		<textarea class="form-control" rows="7" data-name="descr" placeholder="Детальное описание портфолио"><?php echo htmlspecialchars_decode(filter_string($pf->descr,'out'));?></textarea>
	</div>
</div>

<div class="row"><div class="col"><hr /></div></div>
<div class="row">
	<div class="col" style="flex: 0 0 280px; max-width: 280px; align-self: center;">
		<text class="text-muted">Фото и документы</text>
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
		<label for="fileupload_edit" class="wdo-btn bg-purple" data-lt="Загрузка..." data-ot="Выберите файлы">Выберите файлы (<small>Не более 10</small>)</label>
		<input id="fileupload_edit" type="file" name="files[]" multiple style="display: none;" accept=".png,.jpg,.jpeg,.gif,.pdf,.xls,.xlsx,.doc,.docx">
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
	<div class="col text-center">
		<div class="wdo-btn btn-sm bg-purple" id="submit" data-lt="Сохранение..." data-ot="Сохранить">Сохранить</div>
	</div>
</div>

<script>
<?php
	echo 'var portfolio_id="'.$portfolio_id.'";';
?>
function showThisPf()
{
	$("a[data-toggle='tab'][data-target='#portfolio']").removeClass("active").tab("show");
	app.portfolio.showPortfolio(portfolio_id,function(response){
		process_show_portfolio(response);
	});
}
var current_links = [];
$(function(){
	var upload_btn = $("label[for='fileupload_edit']");
	var total_files = 0;
	var max_files = 10;
	$.get("/get.PortfolioAttaches?portfolio_id="+portfolio_id,function(response){
		try {
			var resp = $.parseJSON(response),
					files = resp.files;
			if ( files.length > 0 )
			{
				var $form = $('#fileupload_edit');
				$form.fileupload();
				$form.fileupload('option', 'done').call($form, $.Event('done'), {result: {files: files}});
			}
		}
		catch (msg)
		{
			console.log(msg);
		}
	})
	$.get("/upload/",function(response){
		try {
			var resp = $.parseJSON(response),
					files = resp.files;
			if ( files.length > 0 )
			{
				var $form = $('#fileupload_edit');
				$form.fileupload();
				$form.fileupload('option', 'done').call($form, $.Event('done'), {result: {files: files}});
				total_files += files.length;
			}
		}
		catch (msg)
		{
			console.log(msg);
		}
	})
	$('#fileupload_edit').fileupload({
		dataType: 'json',
		url: '/upload/',
		submit:  function (e, data) {
			$("#uploaded").show();
			$(".progress").show();
			set_btn_state(upload_btn,"loading");
		},
		done: function (e, data) {
			$("#uploaded").show();
			$.each(data.result.files, function () {
				object = app.formatter.format_pf_edit_attach(this);
				if ( this.attach_type == 'image' || this.attach_type == 'document' )
				{
					$(".attaches-container").append(object);
					total_files++;
				}
				else if ( this.attach_type == 'video' )
				{
					$(".attaches-container").append(object);
					$("#yt_links").find("input.empty[data-name='youtube-link']").addClass("disabled").removeClass("empty").attr("disabled","disabled").data("attach_id",this.attach_id).attr("data-attach_id",this.attach_id).val(this.url).trigger("keyup");
				}
				else
				{
					total_files++;
					var is_image = /image/ig;
					if ( is_image.test(this.type) )
					{
						$(".attaches-container").append(object);
					}
					else
					{
						$(".attaches-container").append(object);
					}
				}
				// total_files++;
			});
			$(".download").off("click").on("click",function(e){
				e.stopPropagation();
				e.preventDefault();
				var href = $(this).attr("href");
				window.open(href,'_blank');
			})
			$(".delete").off("click").on("click",function(e){
				e.stopPropagation();
				e.preventDefault();
				var link = $(this),
						href = $(link).attr("href"),
						data = $(link).data(),
						obj = $("div[data-filename='"+data.filename+"']"),
						deleteType = data.deletetype || 'DELETE',
						deleteUrl = $(this).attr("href");
				if ( deleteType == "DELETE" )
				{
					$.ajax({
						"url": deleteUrl,
						"type": "DELETE",
						"dataType": "JSON",
						"success": function(response)
						{
							if ( response[data.filename] == true )
							{
								$(obj).remove();
								if ( $(".attaches-container").children().length == 0 ) $("#uploaded").hide();
								total_files--;
							}
							return false;
						}
					})
				}
				else
				{
					app.portfolio.deleteAttach(data.attach_id,data.attach_type,function(response){
						if ( response.result == true )
						{
							$(obj).remove();
							if ( data.attach_type == "video" )
							{
								$("#yt_links").find("input[data-attach_id='"+data.attach_id+"']").remove();
							}
							if ( $(".attaches-container").children().length == 0 ) $("#uploaded").hide();
							total_files--;
						}
					})
				}
				return false;
			})
		},
		acceptFileTypes: /(\.|\/)(gif|jpe?g|png|docx?|xlsx?|pdf)$/i,
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
				options = {index: link, event: event,
				"onopen": function(){
					$(".portfolio-image-action").hide();
				}},
				links = $(this).find("a").not(".download").not(".delete");
		blueimp.Gallery(links, options);
	});
	$("#submit").click(function(){
		if ( $(this).hasClass("disabled") ) return false;
		var ar = [],
				btn = $(this);
		$("input[data-name='youtube-link']").each(function(){
			if ( $(this).val() != "" )
				ar.push($(this).val())
		})
		var data = {
				"portfolio_id": portfolio_id,
				"cat_id": $(".wdo-option.active[data-name='category']").data('value'),
				"subcat_id": $(".wdo-option.active[data-name='subcategory']").data('value'),
				"title": $("input[data-name='title']").val(),
				"descr": $("textarea[data-name='descr']").val(),
				"youtube_links": ar,
			},
			error = 0,
			text = '';
			// https://www.youtube.com/watch?v=aJaRUYE3C-I
			// youtu.be/H9mNjb9XYy8
		$(".warning").removeClass("warning");
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
			text = 'Введите название портфолио';
			error++;
		}
		if ( data.descr == "" || data.descr === undefined ) {
			$("[data-name='descr']").addClass("warning");
			text = 'Введите описание портфолио';
			error++;
		}
		if ( error > 0 ) {
			( error == 1 ) ? $(this).text(text) : $(this).text('Пожалуйста, проверьте данные');
			$('html, body').animate({
					scrollTop: $(".nav-tabs").offset().top
			}, 1000);
			return;
		}
		set_btn_state(btn,'loading');
		$.ajax({
			type: "POST",
			url: "/portfolio/update",
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
					console.log("published!",response);
					$('.tab-pane#portfolio').removeClass("active");
					$('a[data-toggle="tab"][data-target="portfolio"]').removeClass("active").tab('show');
				}
			}
		})
	})
})
</script>