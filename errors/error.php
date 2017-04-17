<?php
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

?>
<!DOCTYPE html>
<html lang="ru">
<head>
<?php include(PD.'/includes/html-head.php');?>
</head>
<body>

<?php include(PD.'/includes/main-header.php');?>

<div class="container banner-container">
	<div class="row shadow inset">
		<div class="col margins left"></div>
		<div class="col main">
			<div class="row">
				<div class="col wdo-main-left bg-purple-dark" style="z-index: 1; padding-top: 10px;">
					<div class="row">
						<div class="col"><h3>О СЕРВИСЕ</h3></div>
					</div>
					<div class="row">
						<div class="col" style="max-height: 180px; overflow: hidden;"><p style="-webkit-column-width: 243px;column-width: 243px;height: 100%;overflow: hidden;">Первая биржа праздников, всяких дней рождений и прочей Первая биржа праздников, всяких дней рождений и прочей Первая биржа праздников, всяких дней рождений и прочей Первая биржа праздников, всяких дней рождений и прочейПервая биржа праздников, всяких дней рождений и прочей</p></div>
					</div>
					<div class="row">
						<div class="col">
							<div class="wdo-btn wdo-btn-xs bg-purple learnMore">Узнать больше</div>
						</div>
					</div>
				</div><!-- /.wdo-main-left -->
				<div class="col wdo-main-right" style="display: flex; align-items: flex-end; padding-bottom: 15px;">
					<div style="z-index: 1;">
						<div class="row" style="align-items: center;">
							<div class="col" style="flex: 0 0 571px">Добавить проект может любой пользователь. Если у вас нет аккаунта, то сперва зарегистрируйтесь, а затем Вы сможете создавать новые проекты</div>
							<div class="col">
								<a class="wdo-btn bg-purple text-white"><i class="fa fa-plus"></i> Добавить проект</a>
							</div>
						</div>
					</div>
				</div><!-- /.wdo-main-right -->
			</div>
		</div><!-- /.main -->
		<div class="col margins right"></div>
		<div class="white-overlay"></div>
	</div>
</div>

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
							<h3 class="text-purple strong">Произошла ошибка!</h3>
							<hr />
							<h5>
							<?php
							$error = get_var("code","int");
							switch ( $error )
							{
								case "404":
									echo 'Запрашиваемая страница не найдена';
									break;
								case "500":
									echo 'Внутренняя ошибка сервера, попробуйте позже';
									break;
							}
							?>
							</h5>
							<a href="<?php echo HOST;?>" class="wdo-link underline">Вернуться на главную</a>
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

<!-- JS Loading -->
<!-- jQuery 3.0 -->
<!--<script src="/js/jquery.min.js"></script>-->
<script src="/js/jquery.min.js"></script>
<script src="/js/cookies.js"></script>

<!-- bootstrap deps -->
<script src="/js/tether.min.js"></script>
<script src="/js/ie10-viewport-bug-workaround.js"></script>

<!-- bootstrap 4.0 -->
<script src="/js/bootstrap.min.js"></script>

<!-- Others -->
<script src="/js/moment-with-locales.min.js"></script>
<script src="/js/daterangepicker.js"></script>
<script src="/js/jquery.sprintf.js"></script>

<!-- dataTables -->
<script src="/js/dataTables/jquery.dataTables.min.js"></script>
<script src="/js/dataTables/dataTables.bootstrap4.min.js"></script>

<!-- WEEDO -->
<script src="/js/wdo-functions.js"></script>
<script src="/js/wdo-main.js"></script>
<script src="/js/wdo-bindings.js"></script>

</body>
</html>