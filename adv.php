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

<div class="container main-container">
	<div class="row bottom-shadow">
		<div class="col margins left"></div>
		<div class="col main">
			<div class="row">
				<div class="col wdo-main-left right-shadow" style="padding-top: 0px;">
					<div class="row">
						<div class="col">
							<br />
							<h44 style="font-size: 1.6rem;" class="text-purple text-roboto-cond-bold">ВСЕ ОБЪЯВЛЕНИЯ</h44>
						</div>
					</div>
				</div><!-- /.wdo-main-left -->
				<div class="col wdo-main-right" id="wdo-main-right">

			<div id="all_advs"></div>
			<div class="pages"></div>
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

function load_advs(page)
{
	page = page || 0;
	limit = ( page > 0 ) ? (page * 30) : 30;
	app.adv.get_list(limit,function(response){
		$.each(response,function(i,v){
			$("#all_advs").append('<a href="'+v.link+'" class="wdo-link">'+app.formatter.format_adv(v)+'</a>');
		})
	})
}

$(function(){
	load_advs(0);
})
</script>
</body>
</html>