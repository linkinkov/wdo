
<div class="container header-container">
	<div class="row shadow">
		<div class="col margins left"></div>
		<div class="col main">
			<div class="row wdo-main-header">
				<div class="col wdo-main-left logo">
					<div class="row">
						<div class="col" style="text-align: center;">
							<a href="<?php echo HOST;?>"><img src="/images/main-logo.png" style="margin-top: 10px;"/></a>
						</div>
					</div>
					<div class="row">
						<div class="col" style="text-align: center;">
							<a href="#" data-toggle="modal" data-target="#city-select-modal" class="text-yellow"><?php echo $current_user->city_name;?></a>
						</div>
					</div>
				</div><!-- /.wdo-main-left -->
				<div class="col wdo-main-right">
					<div class="row wdo-main-banners-container">
<?php
if ( $current_user->user_id > 0 ) // user authorized
{
?>
						<div class="col top-banner"><img src="/banners/top-example1.jpg"/></div>
						<div class="col top-banner"><img src="/banners/top-example2.jpg"/></div>
<?php
}
else
{
?>
						<div class="col">
							<div class="row" style="align-items: center;">
								<div class="col" style="flex: 0 0 0;padding: 0 0 0 15px;">
									<img src="/images/advantage-selection.png" />
								</div>
								<div class="col">
									Удобный подбор исполнителя
								</div>
							</div>
						</div>
						<div class="col">
							<div class="row" style="align-items: center;">
								<div class="col" style="flex: 0 0 0;padding: 0;">
									<img src="/images/advantage-system.png" />
								</div>
								<div class="col">
									Система рейтингов и отзывов
								</div>
							</div>
						</div>
						<div class="col">
							<div class="row" style="align-items: center;">
								<div class="col" style="flex: 0 0 0;padding: 0;">
									<img src="/images/advantage-safe-deal.png" />
								</div>
								<div class="col">
									Безопасная сделка
								</div>
							</div>
						</div>
<?php
}
?>
					</div>
					<hr style="height: 0;margin: 0; padding: 0;">
					<div class="row header-nav-row">
						<a title="Проекты" href="/projects/" class="col wdo-link header-nav active">Проекты</a>
						<a title="Исполнители" href="/performers/" class="col wdo-link header-nav">Исполнители</a>
						<a title="О сервисе" href="/about/" class="col wdo-link header-nav">О сервисе</a>
						<a title="Реклама" href="/adv/" class="col wdo-link header-nav">Реклама</a>
<?php
if ( $current_user->user_id > 0 ) // user authorized
{
?>
						<div class="col wd-link header-nav" style="display: flex; align-items: center;">
							<img class="rounded-circle" src="<?php echo HOST;?>/user.getAvatar?user_id=<?php echo $current_user->user_id;?>&w=25&h=25" />
							<div class="btn-group">
								<div href="#" class="wdo-link dropdown-toggle dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="align-items: end-flex;">
									&nbsp;Профиль<span class="badge badge-pill badge-info" style="position: absolute; top: 0; right: -20px;">3</span>
								</div>
								<div class="dropdown-menu dropdown-menu-right profile-menu" style="width: 230px;">
									<a class="wdo-link dropdown-item" href="#"><strong>Мой кабинет</strong></a>
									<a class="wdo-link dropdown-item" href="#"><span class="pull-right"><span class="badge badge-pill badge-info">2</span></span>Сообщения</a>
									<a class="wdo-link dropdown-item" href="#"><span class="pull-right"><span class="badge badge-pill badge-info">0</span></span>Отзывы</a>
									<a class="wdo-link dropdown-item" href="#"><span class="pull-right"><span class="badge badge-pill badge-info">1</span></span>Заявки</a>
									<a class="wdo-link dropdown-item" href="#"><span class="pull-right"><span class="badge badge-pill badge-info">0</span></span>Предупреждения</a>
									<div class="dropdown-divider"></div>
									<a class="wdo-link dropdown-item" href="/logout/">Выход</a>
								</div>
							</div>
						</div>
<?php
}
else
{
?>
							<a class="col wdo-btn bg-yellow header-nav" data-toggle="modal" data-target="#login-modal">Вход / Регистрация</a>
<?php
}
?>
					</div>
				</div><!-- /.wdo-main-right -->
			</div><!-- /.wdo-main-header -->
		</div><!-- /.main -->
		<div class="col margins right"></div>
	</div>
</div>