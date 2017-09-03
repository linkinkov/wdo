<?php
if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off")
{
	$redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	header('Location: ' . $redirect, true, 301);
	exit();
}
require_once('../_global.php');
require_once('../_includes.php');
require(PD.'/admin/check_admin.php');
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>WEEDO | Admin</title>
	<link rel="stylesheet" type="text/css" href="/admin/css/sidebar.css"/>
	<link rel="stylesheet" type="text/css" href="/css/font-awesome.min.css"/>
	<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="/js/dataTables/css/dataTables.bootstrap4.min.css"/>
	<link rel="stylesheet" type="text/css" href="/css/fonts.css"/>
	<link rel="apple-touch-icon" sizes="180x180" href="/favicons/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/favicons/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/favicons/favicon-16x16.png">
	<link rel="manifest" href="/favicons/manifest.json">
	<link rel="mask-icon" href="/favicons/safari-pinned-tab.svg" color="#5bbad5">
	<meta name="theme-color" content="#ffffff">
	<link rel="stylesheet" type="text/css" href="/css/daterangepicker.css" />
	<link rel="stylesheet" type="text/css" href="/js/gallery/css/blueimp-gallery.min.css">
	<link rel="stylesheet" type="text/css" href="/js/gallery/css/blueimp-gallery-indicator.css">
	<link rel="stylesheet" type="text/css" href="/js/gallery/css/blueimp-gallery-video.css">
	<link rel="stylesheet" type="text/css" href="/js/leaflet/leaflet.css" />
	<link rel="stylesheet" type="text/css" href="/js/leaflet/MarkerCluster.css" />
	<link rel="stylesheet" type="text/css" href="/js/leaflet/MarkerCluster.Default.css" />
	<link rel="stylesheet" type="text/css" href="/admin/css/bootstrap-editable.css"/>
	<link rel="stylesheet" type="text/css" href="/css/wdo-main.css"/>
	<link rel="stylesheet" type="text/css" href="/css/wdo-btn.css"/>
	<link rel="stylesheet" type="text/css" href="/admin/css/admin.css"/>
</head>
<body>
<div id="app">
	<div class="app-loader"><i class="fa fa-spinner fa-spin fa-3x"></i></div>
	<div class="nav-side-container">
		<div class="nav-side-menu">
			<div class="brand" title="Weedo | Admin">WAdmin</div>
			<div class="menu-list">
				<ul id="menu-content" class="menu-content">
					<li class="menu-entry" data-page="#main">
						<i class="fa fa-home"></i> <a href="/" target="_blank">Перейти на сайт</a>
					</li>
					<li class="menu-entry" data-page="#projects">
						<i class=""></i> Проекты
					</li>
					<li class="menu-entry" data-page="#categories">
						<i class=""></i> Категории
					</li>
					<li class="menu-entry" data-page="#users">
						<i class=""></i> Пользователи
					</li>
					<li class="menu-entry" data-page="#scenarios">
						<i class=""></i> Сценарии
					</li>
					<li class="menu-entry" data-page="#transactions">
						<i class=""></i> Транзакции
					</li>
					<li class="menu-entry" data-page="#adv">
						<i class=""></i> Реклама
					</li>
					<li class="menu-entry" data-page="#banners">
						<i class=""></i> Баннеры
					</li>
				</ul>
			</div> <!-- /.menu-list -->
		</div> <!-- /.nav-side-menu -->
	</div> <!-- /.nav-side-container -->
	<div class="app-content">

	</div><!-- End of app-content -->
</div><!-- End of #app -->
<div class="alert-container"></div>


<?php include('modals.php');?>

<!-- The Gallery  -->
<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls">
	<div class="slides"></div>
	<h3 class="title"></h3>
	<a class="prev">‹</a>
	<a class="next">›</a>
	<a class="close">×</a>
	<a class="play-pause"></a>
	<a class="custom-control portfolio-image-action" data-action="change_cover" data-subact="" style="color: gold;" title="Установить как обложку"><i class="fa fa-star-o fa-3x"></i></a>
	<a class="custom-control portfolio-image-action" data-action="delete_attach" style="color: grey;" title="Удалить фото"><i class="fa fa-trash fa-3x"></i></a>
	<ol class="indicator"></ol>
</div>

<!-- JS Loading -->
<script type="text/javascript" src="<?php echo HOST;?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo HOST;?>/js/sha512.js"></script>
<script type="text/javascript" src="<?php echo HOST;?>/js/cookies.js"></script>

<!-- bootstrap deps -->
<script type="text/javascript" src="<?php echo HOST;?>/js/tether.min.js"></script>
<script type="text/javascript" src="<?php echo HOST;?>/js/ie10-viewport-bug-workaround.js"></script>

<!-- bootstrap 4.0 -->
<script type="text/javascript" src="<?php echo HOST;?>/js/bootstrap.min.js"></script>

<!-- Others -->
<script type="text/javascript" src="<?php echo HOST;?>/js/moment-with-locales.min.js"></script>
<script type="text/javascript" src="<?php echo HOST;?>/js/moment-precise-range.js"></script>
<script type="text/javascript" src="<?php echo HOST;?>/js/daterangepicker.js"></script>
<script type="text/javascript" src="<?php echo HOST;?>/js/jquery.sprintf.js"></script>

<!-- dataTables -->
<script type="text/javascript" src="<?php echo HOST;?>/js/dataTables/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo HOST;?>/js/dataTables/dataTables.bootstrap4.min.js"></script>

<!-- Gallery -->
<script type="text/javascript" src="<?php echo HOST;?>/js/gallery/js/blueimp-gallery.min.js"></script>
<script type="text/javascript" src="<?php echo HOST;?>/js/gallery/js/blueimp-gallery-indicator.js"></script>
<script type="text/javascript" src="<?php echo HOST;?>/js/gallery/js/blueimp-gallery-video.js"></script>
<script type="text/javascript" src="<?php echo HOST;?>/js/gallery/js/blueimp-gallery-youtube.js"></script>
<script type="text/javascript" src="<?php echo HOST;?>/js/gallery/js/blueimp-gallery-vimeo.js"></script>
<script type="text/javascript" src="<?php echo HOST;?>/js/gallery/js/jquery.blueimp-gallery.min.js"></script>

<!-- WEEDO -->
<script type="text/javascript" src="<?php echo HOST;?>/admin/js/functions.js"></script>
<script type="text/javascript" src="<?php echo HOST;?>/admin/js/main.js"></script>
<script type="text/javascript" src="<?php echo HOST;?>/admin/js/bindings.js"></script>

<!-- MAP -->
<script type="text/javascript" src="<?php echo HOST;?>/js/leaflet/leaflet-src.js"></script>
<script type="text/javascript" src="<?php echo HOST;?>/js/leaflet/leaflet.markercluster-src.js"></script>
<script type="text/javascript" src="<?php echo HOST;?>/js/leaflet/leaflet.ajax.min.js"></script>
<script type="text/javascript" src="<?php echo HOST;?>/js/underscore.js"></script>
<script type="text/javascript" src="<?php echo HOST;?>/js/autosize.min.js"></script>

<script type="text/javascript" src="<?php echo HOST;?>/js/file-upload/vendor/jquery.ui.widget.js"></script>
<script type="text/javascript" src="<?php echo HOST;?>/js/file-upload/jquery.iframe-transport.js"></script>
<script type="text/javascript" src="<?php echo HOST;?>/js/file-upload/jquery.fileupload.js"></script>
<script type="text/javascript" src="<?php echo HOST;?>/js/file-upload/jquery.fileupload-process.js"></script>
<script type="text/javascript" src="<?php echo HOST;?>/js/file-upload/jquery.fileupload-validate.js"></script>

<script type="text/javascript" src="<?php echo HOST;?>/admin/js/bootstrap-tooltip-popover.js"></script>
<script type="text/javascript" src="<?php echo HOST;?>/admin/js/bootstrap-editable.js"></script>


</body>
</html>