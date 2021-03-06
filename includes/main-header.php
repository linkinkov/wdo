
<div class="container header-container">
	<div class="row header-container-shadow">
		<div class="col margins left"></div>
		<div class="col main">
			<div class="row wdo-main-header">
				<div class="col wdo-main-left logo">
					<div class="row">
						<div class="col text-center">
							<a href="<?php echo HOST;?>"><img src="/images/main-logo.png" style="margin-top: 10px;"/></a>
						</div>
					</div>
					<div class="row">
						<div class="col text-center">
							<a href="#" data-toggle="modal" data-target="#city-select-modal" class="text-yellow"><?php echo $_COOKIE["city_name"];?></a>
						</div>
					</div>
				</div><!-- /.wdo-main-left -->
				<div class="col wdo-main-right">
					<div class="row wdo-main-banners-container">
						<?php
						$banners = $db->queryRows(sprintf("SELECT * FROM `banners` WHERE type = '%s' AND `active` = 1","top_banners"));
						if ( $current_user->user_id > 0 && rand(0,10)%3 == 0 && sizeof($banners) > 0 ) // user authorized
						{
							$files = Array();
							foreach ( $banners as $banner )
							{
								$files = glob(sprintf("%s/images/banners/top/%s.{jpg,png,jpeg,gif}",PD,$banner->id),GLOB_BRACE);
								foreach ( $files as $file )
								{
									if ( $banner->link != '' )
									{
										echo sprintf("<div class='col top-banner'><a href='%s' target='_blank'><img src='%s'/></a></div>",$banner->link,str_replace(PD,"",$file));
									}
									else
									{
										echo sprintf("<div class='col top-banner'><img src='%s'/></div>",str_replace(PD,"",$file));
									}
								}
							}
						?>
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
					<hr style="margin: 0;padding: 0;margin-left: -15px;margin-right: -15px;">
					<div class="row text-center" style="align-items: center;">
					<?php
						$current_page = $_SERVER["REQUEST_URI"];
						if ( $current_page == "/" ) $current_page = "/projects/";
						$pages = Array(
							"projects" => "Проекты",
							"performers" => "Исполнители",
							"about" => "О сервисе",
							"adv" => "Реклама"
						);
						foreach ( $pages as $page=>$name)
						{
							$class = ('/'.$page.'/' == $current_page) ? "main-nav active" : "main-nav";
							$class = (preg_match("/$page/",$current_page)) ? "main-nav active" : "main-nav";
							echo sprintf('<a class="col %s text-roboto-cond" title="%s" href="/%s/" data-page="/%s/">%s</a>',$class,$name,$page,$page,$name);
						}
						if ( $current_user->user_id > 0 ) // user authorized
						{
						?>
						<div class="col main-nav text-roboto-cond" style="padding-left: 20px;padding-top: 9px;">
							<div style="display: flex; align-items: center;">
								<img class="rounded-circle" src="/user.getAvatar?user_id=<?php echo $current_user->user_id;?>&w=25&h=25" />
								<div class="btn-group">
									<div href="#" class="wdo-link dropdown-toggle dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="align-items: end-flex;">
										&nbsp;Мой кабинет<span data-type="total" class="badge badge-pill badge-info profile-counter" style="position: absolute; top: 0; right: -20px;">3</span>
									</div>
									<div class="dropdown-menu profile-menu" style="width: 230px;">
										<?php
											if ( $current_user->template_id == 2 )
											{
												echo '<a class="wdo-link dropdown-item text-purple" href="/admin/"><i>Админка</i></a>';
											}
										?>
										<a class="wdo-link dropdown-item" href="/profile/#profile"><strong>Профиль</strong>
											<?php
											if ( $current_user->status_id == 3 )
											{
											?>
											<span class="pull-right">
												<small class="text-purple-dark2">Заблокирован</small>
											</span>
											<?php
											}
											?>
										</a>
										<a class="wdo-link dropdown-item" href="/profile/#projects">
											<span class="pull-right">
												<span data-type="projects" class="badge badge-pill badge-info profile-counter"></span>
											</span>
											Проекты
										</a>
										<a class="wdo-link dropdown-item" href="/profile/#messages">
											<span class="pull-right">
												<span data-type="messages" class="badge badge-pill badge-info profile-counter"></span>
											</span>
											Сообщения
										</a>
										<a class="wdo-link dropdown-item" href="/profile/#user-responds">
											<span class="pull-right">
												<span data-type="responds" class="badge badge-pill badge-info profile-counter"></span>
											</span>
											Отзывы
										</a>
										<?php
										if ( $current_user->as_performer == 0 )
										{
										?>
										<a class="wdo-link dropdown-item" href="/profile/#projects">
											<span class="pull-right">
												<span data-type="project-responds" class="badge badge-pill badge-info profile-counter"></span>
											</span>
											Заявки
										</a>
										<?php
										}
										else
										{
										?>
										<a class="wdo-link dropdown-item" href="/profile/#project-responds">
											<span class="pull-right">
												<span data-type="project-responds" class="badge badge-pill badge-info profile-counter"></span>
											</span>
											Заявки
										</a>
										<?php
										}
										?>
										<a class="wdo-link dropdown-item" href="/profile/#warnings">
											<span class="pull-right">
												<span data-type="warnings" class="badge badge-pill badge-info profile-counter"></span>
											</span>
											Предупреждения
										</a>
										<a class="wdo-link dropdown-item" href="/my_adv/">Объявления</a>
										<div class="dropdown-divider"></div>
										<a class="wdo-link dropdown-item" href="/logout/">Выход</a>
									</div>
								</div>
							</div>
						</div>
						<?php
						}
						else
						{
						?>
						<div class="col" style="flex:0 0 200px;min-width: 200px; padding: 0;">
							<a class="wdo-btn btn-sm bg-yellow" data-toggle="modal" data-target="#login-modal">Вход / Регистрация</a>
						</div>
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

<?php
if ( $_SESSION["LAST_PAGE"] != "/projects" )
{
?>
<div class="container header-container">
	<div class="row">
		<div class="col margins left"></div>
		<div class="col main">
			<div class="row wdo-main-header">
				<div class="col" style="padding: 0;">
					<div class="card-group" id="top-adv-container" style="justify-content: center;"></div>
				</div><!-- /.wdo-main-right -->
			</div><!-- /.wdo-main-header -->
		</div><!-- /.main -->
		<div class="col margins right"></div>
	</div>
</div>
<?php
}