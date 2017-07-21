<?php
if ( isset($_SESSION["LAST_PAGE"]) && $_SESSION["LAST_PAGE"] == "/about" )
{
	$wave_class["margins_left"] = "wave";
	$wave_class["main-left"] = "wave";
	$wave_class["main-right"] = "wave";
	$wave_class["margins_right"] = "wave";
}
else
{
	$wave_class["margins_left"] = "wave";
	$wave_class["main-left"] = "wave";
	$wave_class["main-right"] = "wave grey";
	$wave_class["margins_right"] = "wave grey";
}
?>
<div class="container wave-container">
	<div class="row">
		<div class="col margins left" style="padding: 0;">
			<div class="<?php echo $wave_class["margins_left"];?>"></div>
		</div>
		<div class="col main">
			<div class="row">
				<div class="col wdo-main-left" style="padding:0;max-width: 240px;">
					<div class="<?php echo $wave_class["main-left"];?>"></div>
				</div><!-- /.wdo-main-left -->
				<div class="col" style="padding:0;">
					<div class="<?php echo $wave_class["main-right"];?>"></div>
				</div>
			</div>
		</div><!-- /.main -->
		<div class="col margins right" style="padding:0;">
			<div class="<?php echo $wave_class["margins_right"];?>"></div>
		</div>
	</div>
</div>
<div class="container footer-container">
	<div class="row">
		<div class="col margins left"></div>
		<div class="col main">
			<div class="row">
				<div class="col wdo-main-left" style="align-items: center;background: url('/images/ornament-w-bg.png');">
					<h3 class="text-purple text-roboto-cond-bold">СЕРВИС ОРГАНИЗАЦИИ МЕРОПРИЯТИЙ</h3>
				</div><!-- /.wdo-main-left -->

				<div class="col wdo-main-right">
				<p>
					<strong>WeeDo</strong> - биржа для организации праздников. Благодаря инновационному подходу вы подберете необходимый персонал, арендуете банкетный зал или найдете красивое свадебное платье в три клика! Оставьте заявку, укажите бюджет и получайте предложения.
				</p>
				<p>
					Кроме того в каталоге есть все необходимое для подбора исполнителя по критериям: рейтинг, отзывы, ценовой диапазон и местоположение на карте.
				</p>
				<p>
					<strong>WeeDo</strong> - праздник в два клика!
				</p>
				</div><!-- /.wdo-main-right -->
			</div><!-- /.wdo-main-header -->
		</div><!-- /.main -->
		<div class="col margins right"></div>
	</div>
</div>

<div class="container footer-container-2">
	<div class="row">
		<div class="col margins left bg-purple-dark-2"></div>
		<div class="col main">
			<div class="row">
				<div class="col wdo-main-left bg-purple-dark-2">
					<a href="/support/" class="wdo-link underline text-white">Техническая поддержка</a>
					<br /><br />
					<h6>WEEDO.RU 2017 г.</h6>
				</div><!-- /.wdo-main-left -->

				<div class="col wdo-main-right bg-purple-dark-2">
					<div class="pull-right">
						Расскажите о нас друзьям
					</div>
				</div><!-- /.wdo-main-right -->
			</div><!-- /.wdo-main-header -->
		</div><!-- /.main -->
		<div class="col margins right bg-purple-dark-2"></div>
	</div>
</div>

<div class="container footer-container-3">
	<div class="row">
		<div class="col" style="background: url('/images/ornament-3.png') repeat-x center center; height: 100px;"></div><!-- /.main -->
	</div>
</div>