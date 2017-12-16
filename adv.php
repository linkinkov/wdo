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
					<?php
					if ( $current_user->user_id > 0 )
					{
					?>
					<div class="row">
						<div class="col">
							<span class="pull-right">
								<a class="wdo-btn btn-sm bg-yellow" href="/my_adv/">Мои объявления / Добавить новое</a>
							</span>
						</div>
					</div>
					<hr />
					<?php
					}
					?>
					<!-- <div id="all_advs" style="maring-left: 10px;"></div> -->
					<div class="card-columns" id="all_advs">
					<!-- Portfolio cards from JSON answer -->
					</div>
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
	$("#all_advs").html('');
	var html = '';
	app.adv.get_list(10,function(response){
		$("#all_advs").html("");
		if ( response.length > 0 )
		{
			// $("#all_advs").append("<hr />");
			$.each(response,function(i,v){
				var item = app.formatter.format_adv(v);
				$("#all_advs").append(app.formatter.format_adv(v));
			})
			// $("#all_advs").append('<a href="/adv/" class="wdo-link text-yellow" style="padding: 0px 20%;">Все объявления</a>');
		}
	},"", false);

}

$(function(){
	load_advs(0);
})
</script>
</body>
</html>