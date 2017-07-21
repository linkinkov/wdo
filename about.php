<?php
if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off")
{
	$redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	header('Location: ' . $redirect, true, 301);
	exit();
}
require_once('_global.php');
include_once('_includes.php');

$ref = isset($_SESSION["LAST_PAGE"]) ? trim($_SESSION["LAST_PAGE"]) : false;
if ( $ref == "profile/project-responds" )
{
	$data["ts_project_responds"] = time();
	$current_user->update_profile_info($data);
}
$_SESSION["LAST_PAGE"] = "/about";

$job = get_var("job","string","");
$min = get_var("min","array",Array());

opcache_reset();

?>

<!DOCTYPE html>
<html lang="ru">
<head>
<?php include(PD.'/includes/html-head.php');?>
</head>
<body>

<?php include(PD.'/includes/main-header.php');?>

<div class="container main-container" id="projects">
	<div class="row bottom-shadow">
		<div class="col margins left"></div>
		<div class="col main">
			<div class="row">
				<div class="col wdo-main-left right-shadow" style="padding-top: 0px;">
					<div class="row">
						<div class="col" style="padding: 15px; background: url('/images/ornament-w-bg.png');">
							<h44 style="font-size: 1.6rem;" class="text-purple-dark2 text-roboto-cond-bold">СЕРВИС ОРГАНИЗАЦИИ МЕРОПРИЯТИЙ</h44>
						</div>
					</div>
					<br />
					<?php include(PD.'/includes/left-list-top-10.php');?>
					<?php include(PD.'/includes/left-list-adv.php');?>
				</div><!-- /.wdo-main-left -->
				<div class="col wdo-main-right" style="background-color: #fff !important;">
					<!-- 1ST BLOCK -->
					<div class="row">
						<div class="col" style="padding-bottom: 5px;">
							<h4 class="text-purple-dark2">ПОСМОТРИТЕ ВИДЕО И ВСЕ ПОЙМЕТЕ!</h4>
						</div>
					</div>
					<div class="row">
						<div class="col text-center" style="padding-top: 5px;">
							<iframe width="435" height="245" src="https://www.youtube.com/embed/uopOnwn3xuQ"></iframe>
						</div>
					</div>

					<!-- 2ND BLOCK -->
					<br />
					<div class="row">
						<div class="col" style="background-color: #f5f5f5; padding: 25px;">
							<h5 class="text-purple-dark2">WEEDO.RU - ПЕРВАЯ БИРЖА ПРАЗДНИКОВ</h5>

							<div class="row" style="align-items: center;">
								<div class="col text-right">
									С НАМИ УДОБНО:<br />
									Все исполнители на одном сайте:
									каталог исполнителей, рейтинги, отзывы заказчиков.
								</div>
								<div class="col">
									<img src="/images/about-people.png" />
								</div>
							</div>
						</div>
					</div>

					<!-- 3RD BLOCK -->
					<br />
					<div class="row">
						<div class="col" style="padding: 25px;">
							<h5 class="text-purple-dark2">НАЙДЕТСЯ ЛЮБОЙ</h5>

							<div class="row" style="align-items: center;">
								<div class="col">
									<div class="wdo-notice yellow">
										Широкий рубрикатор специалистов в сфере красоты, подготовки и проведения праздников, обслуживания.
									</div>
								</div>
								<div class="col">
									<img style="padding-bottom: 5px;" src="/images/about-filter-icon.png" /> фильтр специализаций <br />
									<img style="padding-bottom: 5px;" src="/images/about-sort-icon.png" /> сортировка по рейтингу <br />
									<img style="padding-bottom: 5px;" src="/images/about-gps-icon.png" /> поиск исполнителя по карте <br />
								</div>
							</div>
						</div>
					</div>

					<!-- 4TH BLOCK -->
					<br />
					<div class="row">
						<div class="col" style="background-color: #f5f5f5; padding: 5px;">
							<br />
							<div class="row" style="align-items: center;">
								<div class="col text-center">
									<div class="wdo-notice">
										<text class="text-purple-dark2" style="font-weight: 800;">НЕТ ВРЕМЕНИ ИСКАТЬ</text>
									</div>
								</div>
							</div>
							<br />
							<div class="row" style="align-items: center;">
								<div class="col text-center" style="margin: 0 auto; max-width: 600px;">
									<h5 class="text-purple-dark2" style="font-size: 0.75rem;">Опиши задачу и исполнители сами найдут тебя</h5>
									<img src="/images/about-line-bottom-arrow.png" />
								</div>
							</div>
							<div class="row" style="align-items: center;">
								<div class="col text-center" style="margin: 0 auto; max-width: 520px;">
									<span class="pull-left">
										<img src="/images/about-customer-avatar.png" />
										<text style="margin-left: 50px; padding: 3px; color: #fff; background-color: #f88069;">Заказчик</text>
									</span>
									<span class="pull-right">
										<text style="margin-right: 50px; padding: 3px; color: #fff; background-color: #22827d;">Исполнитель</text>
										<img src="/images/about-performer-avatar.png" />
									</span>
								</div>
							</div>
							<br />
							<div class="row" style="align-items: center;">
								<div class="col text-center" style="margin: 0 auto; max-width: 350px;">
									<div class="row" style="align-items: center;">
										<div class="col" style="padding-left: 0px; padding-right: 0px; text-align: right; font-size: 0.75rem;">
											<text style="color: #f4705a;">Зарегистрируйся</text>
										</div>
										<div class="col" style="padding-left: 0px; padding-right: 0px; max-width: 80px;">
											<div style="display: inline-block; position: relative; height: 50px; width: 50px; text-align: center; vertical-align: middle; font-size: 1.5rem; line-height: 45px; color: #22827d; border-style: solid; border-radius: 30px; border-width: 2px; border-color: #22827d; background-color: #fff;">1</div>
										</div>
										<div class="col" style="padding-left: 0px; padding-right: 0px; text-align: left; font-size: 0.75rem;">
											<text style="color: #22827d;">Зарегистрируйся</text>
										</div>
									</div>
								</div>
							</div>
							<br />
							<div class="row" style="align-items: center;">
								<div class="col text-center" style="margin: 0 auto; max-width: 350px;">
									<div class="row" style="align-items: center;">
										<div class="col" style="padding-left: 0px; padding-right: 0px; text-align: right; font-size: 0.75rem;">
											<text style="color: #4e0534;">Создай проект</text>
										</div>
										<div class="col" style="padding-left: 0px; padding-right: 0px; max-width: 80px;">
											<div style="display: inline-block; position: relative; height: 50px; width: 50px; text-align: center; vertical-align: middle; font-size: 1.5rem; line-height: 45px; color: #f4705a; border-style: solid; border-radius: 30px; border-width: 2px; border-color: #f4705a; background-color: #fff;">2</div>
										</div>
										<div class="col" style="padding-left: 0px; padding-right: 0px; text-align: left; font-size: 0.75rem;">
											<text style="color: #4e0534;">Создай портфолио</text>
										</div>
									</div>
								</div>
							</div>
							<br />
							<div class="row" style="align-items: center;">
								<div class="col text-center" style="margin: 0 auto; max-width: 350px;">
									<div class="row" style="align-items: center;">
										<div class="col" style="padding-left: 0px; padding-right: 0px; text-align: right; font-size: 0.75rem;">
											<text style="color: #f4705a;">Получай заявки</text>
										</div>
										<div class="col" style="padding-left: 0px; padding-right: 0px; max-width: 80px;">
											<div style="display: inline-block; position: relative; height: 50px; width: 50px; text-align: center; vertical-align: middle; font-size: 1.5rem; line-height: 45px; color: #22827d; border-style: solid; border-radius: 30px; border-width: 2px; border-color: #22827d; background-color: #fff;">3</div>
										</div>
										<div class="col" style="padding-left: 0px; padding-right: 0px; text-align: left; font-size: 0.75rem;">
											<text style="color: #22827d;">Отправляй заявки</text>
										</div>
									</div>
								</div>
							</div>
							<br />
							<div class="row" style="align-items: center;">
								<div class="col text-center" style="margin: 0 auto;">
									Оплатить можно через сервис или договориться напрямую.
								</div>
							</div>
						</div>
					</div>

					<!-- 5TH BLOCK -->
					<br />
					<div class="row">
						<div class="col text-center" style="padding: 25px;">
							<h5 class="text-purple-dark2">МАСТЕР ПРАЗДНИКОВ - ПОДУМАЙ ОБО ВСЁМ!</h5>

							<div class="row" style="align-items: center;">
								<div class="col">
									<strong class="text-muted">Учти всё необходимое и контроллируй процесс подготовки:</strong>
								</div>
							</div>
							<br /><br /><br />
							<!-- 1-4 -->
							<div class="row" style="align-items: center;">
								<div class="col text-justify">
									<div class="wdo-notice yellow">1</div>
									<div class="wdo-notice yellow" style="margin-left: 155px; ">2</div>
									<div class="wdo-notice yellow" style="margin-left: 155px; ">3</div>
									<div class="wdo-notice yellow" style="margin-left: 155px; ">4</div>
									<hr style="z-index: 0; border: none; height: 3px; background-color: #c9c532; color: #c9c532; position: absolute; width: 93%; top: 5px; left: 45px;" />
								</div>
							</div>
							<div class="row">
								<div class="col text-justify" style="max-width: 140px; margin-left: 30px;">Создай событие</div>
								<div class="col text-justify" style="max-width: 160px; margin-left: 90px;">Выбери сценарий</div>
								<div class="col text-justify" style="max-width: 160px; margin-left: 90px;">Заполни проекты</div>
								<div class="col text-justify" style="max-width: 160px; margin-left: 90px;">Утверди исполнителей</div>
							</div>

							<br /><br />
							<!-- 5-6 -->
							<div class="row" style="align-items: center;">
								<div class="col text-justify">
									<img src="/images/about-master-graph.png" style="margin-left: 90px;" />
									<img src="/images/about-master-chat.png" style="margin-left: 250px;"/>
								</div>
							</div>
							<div class="row" style="align-items: center;">
								<div class="col text-justify">
									<div class="wdo-notice yellow">5</div>
									<div class="wdo-notice yellow" style="margin-left: 350px; ">6</div>
									<hr style="z-index: 0; border: none; height: 3px; background-color: #c9c532; color: #c9c532; position: absolute; width: 93%; top: 5px; left: 45px;" />
								</div>
							</div>
							<div class="row">
								<div class="col text-left" style="margin-left: 30px;">Следи за ходом подготовки и расходом средств</div>
								<div class="col text-left" style="margin-left: 80px;">Будь в курсе - общайся в общем чате мероприятия со всеми сразу</div>
							</div>
						</div>
					</div>

					<!-- 6TH BLOCK -->
					<br />
					<div class="row">
						<div class="col" style="background-color: #f5f5f5; padding: 25px;">
							<h5 class="text-purple-dark2">ВЫБЕРИ БЕЗОПАСНУЮ СДЕЛКУ: ЭТО ГАРАНТИЯ ЧЕСТНОЙ ОПЛАТЫ.</h5>
							<br /><br />

							<div class="row" style="align-items: center; padding-bottom: 10px;">
								<div class="col" style=" padding-right: 0px; max-width: 80px;">
									<div style="display: inline-block; position: relative; height: 35px; width: 35px; text-align: center; vertical-align: middle; font-size: 1.2rem; line-height: 30px; color: #2a638a; border-style: solid; border-radius: 30px; border-width: 2px; border-color: #2a638a; background-color: #fff;">1</div>
								</div>
								<div class="col" style="padding-left: 0px; padding-right: 0px; text-align: left; font-size: 0.75rem;">
									<text>Пополни баланс на необходимую сумму для проекта</text>
								</div>
							</div>

							<div class="row" style="align-items: center; padding-bottom: 10px;">
								<div class="col" style=" padding-right: 0px; max-width: 80px;">
									<div style="display: inline-block; position: relative; height: 35px; width: 35px; text-align: center; vertical-align: middle; font-size: 1.2rem; line-height: 30px; color: #2a638a; border-style: solid; border-radius: 30px; border-width: 2px; border-color: #2a638a; background-color: #fff;">2</div>
								</div>
								<div class="col" style="padding-left: 0px; padding-right: 0px; text-align: left; font-size: 0.75rem;">
									<text>Выбери исполнителя</text>
								</div>
							</div>

							<div class="row" style="align-items: center; padding-bottom: 10px;">
								<div class="col" style=" padding-right: 0px; max-width: 80px;">
									<div style="display: inline-block; position: relative; height: 35px; width: 35px; text-align: center; vertical-align: middle; font-size: 1.2rem; line-height: 30px; color: #2a638a; border-style: solid; border-radius: 30px; border-width: 2px; border-color: #2a638a; background-color: #fff;">3</div>
								</div>
								<div class="col" style="padding-left: 0px; padding-right: 0px; text-align: left; font-size: 0.75rem;">
									<text>Деньги будут заморожены сервисом до принятия работы заказчиком</text>
								</div>
							</div>

							<div class="row" style="align-items: center; padding-bottom: 10px;">
								<div class="col" style=" padding-right: 0px; max-width: 80px;">
									<div style="display: inline-block; position: relative; height: 35px; width: 35px; text-align: center; vertical-align: middle; font-size: 1.2rem; line-height: 30px; color: #2a638a; border-style: solid; border-radius: 30px; border-width: 2px; border-color: #2a638a; background-color: #fff;">4</div>
								</div>
								<div class="col" style="padding-left: 0px; padding-right: 0px; text-align: left; font-size: 0.75rem;">
									<text>Когда работа готова, просто жми «принять» и исполнитель получит оплату</text>
								</div>
							</div>
						</div>
						<div class="col" style="background-color: #f5f5f5; padding: 25px;">
							<img src="/images/about-safe-deal-icon.png" />
						</div>
					</div>

					<!-- 6TH BLOCK -->
					<br />
					<div class="row">
						<div class="col" style="padding: 25px;">
							<h5 class="text-purple-dark2">ЕСЛИ ЧТО-ТО ПОШЛО НЕ ТАК - ОБРАТИСЬ В АРБИТРАЖ!</h5>
							<br /><br />

							<div class="row" style="align-items: center; padding-bottom: 10px;">
								<div class="col" style="max-width: 230px;">
									<img src="/images/about-arbitrazh-icon.png" />
								</div>
								<div class="col" style="text-align: justify; font-size: 0.8rem;">
									<text style="line-height: 1.7rem;">В случае, если между заказчиком и исполнителем возникло 
разногласие по поводу качества работы или задержки оплаты, любой из заинтересованных сторон может обратиться в арбитраж. Претензия будет рассмотрена и вынесено решение. Для принятия решения будет учитываться только переписка заказчика и исполнителя внутри сервиса.</text>
								</div>
							</div>
						</div>
					</div>


				</div><!-- /.wdo-main-right -->
			</div>
		</div><!-- /.main -->
		<div class="col margins right" style="background-color: #fff !important;"></div>
	</div>
</div>

<?php include(PD.'/includes/footer.php');?>
<?php include(PD.'/includes/modals.php');?>
<?php include(PD.'/includes/scripts.php');?>

<script>
$(function(){


})
</script>
