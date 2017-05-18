<?php
if ( !isset($error) )
{
	if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off")
	{
		$redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		header('HTTP/1.1 301 Moved Permanently');
		header('Location: ' . $redirect);
		exit();
	}
	require_once('../_global.php');
	include_once('../_includes.php');
	$db = db::getInstance();
	check_access($db,false);

	$current_user = new User($_SESSION["user_id"]);
	$current_user->set_city_auto();
}

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
						<div class="col" style="height: 500px;"></div>
					</div>
				</div><!-- /.wdo-main-left -->
				<div class="col wdo-main-right">
					<div class="row" style="text-align: center;">
						<div class="col">
							<!--<h3 class="text-purple strong">Произошла ошибка!</h3>-->
							<!--<hr />-->
							<!--<h5>-->
							<?php
							// print_r($_SERVER);
							$link = '<a href="'.$_SERVER["REDIRECT_URL"].'" class="wdo-link underline">Вернуться</a>';
							if ( !isset($error) ) $error = get_var("code","int");
							switch ( $error )
							{
								case "404":
									echo '<h4 class="text-purple strong">Запрашиваемая страница не найдена</h4>';
									break;
								case "401":
									echo '<h4 class="text-purple strong">Доступ ограничен</h4><a class="wdo-link underline" data-toggle="modal" data-target="#login-modal">Вход / Регистрация</a>';
									break;
								case "500":
									echo 'Внутренняя ошибка сервера, попробуйте позже';
									break;
								case "700":
									echo 'У вас уже есть заявка на данный проект';
									// $link = '<a href="javascript:history.back()" class="wdo-link underline">Вернуться на главную</a>';
									break;
								default:
									echo 'Произошла ошибка';
									break;
							}
							?>
							<!--</h5>-->
							<hr />
							<?php echo $link;?>
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
</body>
</html>