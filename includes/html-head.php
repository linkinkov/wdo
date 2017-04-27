<?php
$title = ( isset($current_user) && $current_user->user_id ) ? 'WeeDo | '.$current_user->real_user_name : 'WeeDo';
?>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $title;?></title>
<!--<link rel="icon" type="image/png" href="<?php echo HOST;?>/images/favicon.ico">-->

<link rel="apple-touch-icon" sizes="180x180" href="/favicons/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicons/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicons/favicon-16x16.png">
<link rel="manifest" href="/favicons/manifest.json">
<link rel="mask-icon" href="/favicons/safari-pinned-tab.svg" color="#5bbad5">
<meta name="theme-color" content="#ffffff">

<link rel="stylesheet" type="text/css" href="<?php echo HOST;?>/css/font-awesome.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo HOST;?>/css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo HOST;?>/css/daterangepicker.css" />
<link rel="stylesheet" type="text/css" href="<?php echo HOST;?>/css/wdo-main.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo HOST;?>/css/wdo-btn.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo HOST;?>/css/fonts.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo HOST;?>/js/dataTables/css/dataTables.bootstrap4.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo HOST;?>/js/gallery/css/blueimp-gallery.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo HOST;?>/js/gallery/css/blueimp-gallery-indicator.css">
<link rel="stylesheet" type="text/css" href="<?php echo HOST;?>/js/gallery/css/blueimp-gallery-video.css">
<link rel="stylesheet" type="text/css" href="<?php echo HOST;?>/js/leaflet/leaflet.css" />
<link rel="stylesheet" type="text/css" href="<?php echo HOST;?>/js/leaflet/MarkerCluster.css" />
<link rel="stylesheet" type="text/css" href="<?php echo HOST;?>/js/leaflet/MarkerCluster.Default.css" />
