
<div class="container header-container">
	<div class="row shadow">
		<div class="col margins left bg-purple-dark"></div>
		<div class="col main">
			<div class="row">
				<div class="col wdo-main-left bg-purple-dark text-center" style="z-index: 1; padding: 5px;">
					<a href="/"><img src="/images/logo-mic.png" /></a>
				</div>
				<div class="col wdo-main-right bg-purple-dark" style="display: flex; align-items: center;">
						<a class="mini-header-nav" href="<?php echo HOST;?>/projects/">Проекты</a>
						<a class="mini-header-nav" href="<?php echo HOST;?>/performers/">Исполнители</a>
						<a class="mini-header-nav" href="<?php echo HOST;?>/about/">О сервисе</a>
						<a class="mini-header-nav" href="<?php echo HOST;?>/adv/">Реклама</a>
						<?php
						if ( $current_user->user_id > 0 )
							echo '<a class="mini-header-nav" href="<?php echo HOST;?>/logout/">Выход</a>';
						else
							echo '<a class="mini-header-nav" href="" data-toggle="modal" data-target="#login-modal">Вход</a>'
						?>
				</div>
			</div><!-- /.wdo-main-header -->
		</div><!-- /.main -->
		<div class="col margins right bg-purple-dark"></div>
	</div>
</div>