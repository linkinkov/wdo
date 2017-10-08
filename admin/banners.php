<?php
require_once('../_global.php');
require_once('../_includes.php');
require(PD.'/admin/check_admin.php');

check_access($db,true);
$job = get_var("job","string","");
$banner_id = get_var("banner_id","string","");
if ( $job == "upload" )
{
	$type = get_var("type","string","main_banners");
	header('Content-Type: text/plain; charset=utf-8');
	try
	{
		// Undefined | Multiple Files | $_FILES Corruption Attack
		// If this request falls under any of them, treat it invalid.
		if ( !isset($_FILES['upfile']['error']) || is_array($_FILES['upfile']['error']) )
		{
			throw new RuntimeException('Invalid parameters.');
		}
	
		// Check $_FILES['upfile']['error'] value.
		switch ($_FILES['upfile']['error'])
		{
			case UPLOAD_ERR_OK:
				break;
			case UPLOAD_ERR_NO_FILE:
				throw new RuntimeException('No file sent.');
			case UPLOAD_ERR_INI_SIZE:
			case UPLOAD_ERR_FORM_SIZE:
				throw new RuntimeException('Exceeded filesize limit.');
			default:
				throw new RuntimeException('Unknown errors.');
		}
	
		// You should also check filesize here. 
		if ($_FILES['upfile']['size'] > 1000000)
		{
			throw new RuntimeException('Exceeded filesize limit.');
		}

		// DO NOT TRUST $_FILES['upfile']['mime'] VALUE !!
		// Check MIME Type by yourself.
		$finfo = new finfo(FILEINFO_MIME_TYPE);
		if (false === $ext = array_search(
			$finfo->file($_FILES['upfile']['tmp_name']),
			array(
				'jpg' => 'image/jpeg',
				'png' => 'image/png',
				'gif' => 'image/gif',
			),
			true
		)) {
			throw new RuntimeException('Invalid file format.');
		}
	
		// You should name it uniquely.
		// DO NOT USE $_FILES['upfile']['name'] WITHOUT ANY VALIDATION !!
		// On this example, obtain safe unique name from its binary data.
		$banner_id = md5($_FILES['upfile']['tmp_name']);
		if (!move_uploaded_file(
				$_FILES['upfile']['tmp_name'],
				sprintf(PD.'/banners/%s.%s',
					$banner_id,
					$ext
				)
		)) {
			throw new RuntimeException('Failed to move uploaded file.');
		}
		$sql = sprintf("INSERT INTO `banners` (`id`,`type`,`timestamp`,`active`) VALUES ('%s','%s',UNIX_TIMESTAMP(),0)",$banner_id,$type);
		$db->query($sql);
		echo 'File is uploaded successfully.';
	}
	catch (RuntimeException $e)
	{
		echo $e->getMessage();
	}
}
else if ( $job == "activate" && strlen($banner_id) == 32 )
{
	header('Content-Type: application/json');
	$response = Array(
		"result" => "false",
		"banner_id" => $banner_id
	);
	try
	{
		$type = $db->getValue("banners","type","type",Array("id"=>$banner_id));
		$files = glob(sprintf("%s/banners/%s.{jpg,png,jpeg,gif}",PD,$banner_id),GLOB_BRACE);
		foreach ( $files as &$file )
		{
			$resizeObj = new resize($file);
			$w = 360;
			$h = 60;
			$path_parts = pathinfo($file);
			if ( $type == "main_banners" )
			{
				$target = sprintf("%s/images/banners/%s",PD,$path_parts["basename"]);
				$w = 1600;
				$h = 360;
			}
			$resizeObj->resizeImage($w, $h, 'crop');
			$resizeObj->saveImage($target, 90);
			$file = str_replace(PD,'',$file);
		}
		$db->query(sprintf("UPDATE `banners` SET `active` = 0 WHERE `type` = '%s'",$type));
		$db->query(sprintf("UPDATE `banners` SET `active` = 1 WHERE `type` = '%s' AND `id` = '%s'",$type,$banner_id));
		$response["result"] = "true";
	}
	catch ( Exception $e )
	{

	}
	echo json_encode($response);
}
else if ( $job == "delete" && strlen($banner_id) == 32 )
{
	header('Content-Type: application/json');
	$response = Array(
		"result" => "false",
		"banner_id" => $banner_id
	);
	try
	{
		$files = glob(sprintf("%s/banners/%s.{jpg,png,jpeg,gif}",PD,$banner_id),GLOB_BRACE);
		foreach ( $files as $file )
		{
			unlink($file);
		}
		$response["result"] = "true";
	}
	catch ( Exception $e )
	{

	}
	echo json_encode($response);
}
if ( $job != "" ) exit();
?>

<div class="row">
	<div class="col">
		<h5>Баннеры</h5>
	</div>
</div>
<div class="row"><div class="col"><hr /></div></div>
<div class="row">
	<div class="col">Основной</div>
</div>
<div class="row">
	<div class="col" style="flex: 0 0 280px; max-width: 280px; align-self: center;">
		<text class="text-muted">Загрузить новый</text>
	</div>
	<div class="col" style="max-width: 300px;">
		<div id="uploaded" style="display: none;">
			<div class="attaches-container gallery text-center">
				<!-- <a href="/get.Attach?attach_id=1&w=500"><img class="img-thumbnail" src="/get.Attach?attach_id=1&w=100&h=100" /></a> -->
			</div>
			<hr />
			<div class="progress">
				<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
			</div>
			<br />
		</div>
		<label for="fileupload" class="wdo-btn bg-purple" data-lt="Загрузка..." data-ot="Выберите файлы">Выберите файлы</label>
		<form id="main_banners_upload" enctype="multipart/form-data" method="post">
			<input id="fileupload" type="file" name="upfile" style="display: none;" accept=".png,.jpg,.jpeg,.gif">
			<input type="submit" value="Отправить"></p>
		</form>
	</div>
</div>

<div class="row">
	<div class="col">
		<div id="main_banners"></div>
	</div>
</div>

<script>
function getBanners()
{
	$.get('/admin/dt/banners',function(response){
		$('#main_banners').html('');
		if ( response.recordsTotal > 0 )
		{
			$.each(response.data, function(banner_idx,banner){
				$.each(banner.files, function(file_idx,filepath){
					if (banner.active == 1)
					{
						var btn_text = 'Активен';
						var btn_class = 'btn btn-success disabled';
						var activate_btn = '<button data-toggle="activate" data-id="'+banner.id+'" class="'+btn_class+'" style="width: 150px;">'+btn_text+'</button>';
						var delete_btn = '<button data-toggle="delete" data-id="'+banner.id+'" class="btn btn-secondary disabled" style="width: 150px;">Удалить</button>';
					}
					else
					{
						var btn_text = 'Сделать активным';
						var btn_class = 'btn btn-secondary';
						var activate_btn = '<button data-toggle="activate" data-id="'+banner.id+'" class="'+btn_class+'" style="width: 150px;">'+btn_text+'</button>';
						var delete_btn = '<button data-toggle="delete" data-id="'+banner.id+'" class="btn btn-secondary" style="width: 150px;">Удалить</button>';
					}
					var html = $.sprintf(''
							+'<div class="row">'
							+'	<div class="col">'
							+'		<img src="%s" class="img-thumbnail" />'
							+'	</div>'
							+'	<div class="col" style="max-width: 170px;">'
							+'		<span class="pull-right">'
							+'			'+activate_btn+'<br/>'
							+'			'+delete_btn
							+'		</span>'
							+'	</div>'
							+'</div>',filepath);
					$('#'+banner.type).append(html);
				})
				$('button[data-toggle="activate"]').unbind().click(function(e){
					if ( $(this).hasClass('disabled') ) return;
					var data = $(this).data();
					$.ajax({
						'url': '/admin/banners/',
						'dataType': 'JSON',
						'data': {
							'job': 'activate',
							'banner_id': data.id
						},
						success: function(response){
							console.log("response:",response);
							getBanners();
						}
					})
				})
				$('button[data-toggle="delete"]').unbind().click(function(e){
					if ( $(this).hasClass('disabled') ) return;
					var data = $(this).data();
					$.ajax({
						'url': '/admin/banners/',
						'dataType': 'JSON',
						'data': {
							'job': 'delete',
							'banner_id': data.id
						},
						success: function(response){
							console.log("response:",response);
							getBanners();
						}
					})
				})
			})
		}
	})
}
$(function(){
	$("form#main_banners_upload").submit(function(){
		var formData = new FormData(this);
		$.ajax({
			url: '/admin/banners/?job=upload',
			type: 'POST',
			data: formData,
			async: false,
			success: function (data) {
				alert(data)
			},
			cache: false,
			contentType: false,
			processData: false
		});

		return false;
	});
	$(".gallery").click(function (event) {
		event = event || window.event;
		var target = event.target || event.srcElement,
				link = target.src ? target.parentNode : target,
				options = {index: link, event: event},
				links = $(this).find("a").not(".download").not(".delete");
		blueimp.Gallery(links, options);
	});
	getBanners();
})
</script>