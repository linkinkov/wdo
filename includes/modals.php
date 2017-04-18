

<!-- city-select-modal -->
<div class="modal fade" id="city-select-modal" tabindex="-1" role="dialog" aria-labelledby="city-select-modal-label" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="city-select-modal-label">Выбор города</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row" style="justify-content: center;">
					<div class="col strong" style="flex: 0 0 80%; text-align: center;">
						<p>Мы определили Ваш город как <?php echo $current_user->city_name;?></p>
						<p>Если мы определили его не правильно, введите свой город</p>
					</div>
				</div>
				<div class="row" style="justify-content: center;">
					<div class="col" style="flex: 0 0 80%; text-align: center;">
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Введите для поиска и выберите из списка ниже" onKeyUp="update_city_list(this,event);" />
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<div class="row" id="city_list"></div>
			</div>
		</div>
	</div>
</div>

<!-- login-modal -->
<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="login-modal-label" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="login-modal-label">Авторизация</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row" style="justify-content: center;">
					<div class="col" style="border-right: 1px solid #eee;">
						<form method="post" action="<?php echo HOST;?>/login/" onSubmit="formhash(this,this.password);return false;">
							<br /><input type="text" class="form-control" placeholder="Введите e-mail" name="username" />
							<br /><input type="password" class="form-control" placeholder="Введите пароль" name="password" />
							<br /><button type="submit" class="wdo-btn bg-yellow strong">Вход</button>
						</form>
						<br /><a class="wdo-link" href="#" style="color: #4b5257;" data-toggle="modal" data-target="#restore-password-modal">Забыли пароль?</a>
					</div>
					<div class="col">
						<!-- Put this div tag to the place, where Auth block will be -->
						<!--<div id="vk_auth"></div>
						<script type="text/javascript">
						VK.Widgets.Auth("vk_auth", {authUrl: '/login/'});
						</script>-->
						<div class="bottom right">
							<a class="wdo-link" href="#" style="color: #4b5257;" data-toggle="modal" data-target="#register-modal">У меня нет аккаунта</a>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer" style="height: 55px; background: url(/images/ornament-3.png) repeat-x bottom 10px right;">
			</div>
		</div>
	</div>
</div>

<!-- restore-password-modal -->
<div class="modal fade" id="restore-password-modal" tabindex="-1" role="dialog" aria-labelledby="restore-password-modal-label" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="restore-password-modal-label">Восстановление пароля</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row" style="justify-content: center;">
					<div class="col strong" style="flex: 0 0 80%; text-align: center;">
						<p>Ссылка на восстановление пароля будет отправлена на почту</p>
					</div>
				</div>
				<div class="row" style="justify-content: center;background: url(/images/ornament-2.png) repeat-x bottom right 10px;">
					<div class="col" style="flex: 0 0 50%;">
						<br /><input type="text" class="form-control" placeholder="Введите e-mail" name="username" />
						<br /><div class="wdo-btn bg-yellow strong">Отправить</div>
						<br /><br /><br />
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- register-modal -->
<div class="modal fade" id="register-modal" tabindex="-1" role="dialog" aria-labelledby="register-modal-label" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="register-modal-label">Регистрация</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row" style="justify-content: center;background: url(/images/ornament.png) no-repeat bottom right 10px;">
					<div class="col" style="flex: 0 0 70%;">
						<br /><input type="text" class="form-control" placeholder="Введите e-mail" name="username" />
						<br /><input type="password" class="form-control" placeholder="Введите пароль" name="password" />
						<br /><input type="password" class="form-control" placeholder="Повторите пароль" name="password_confirm" />
						<br /><div class="wdo-btn bg-yellow strong">Отправить</div>
						<br /><br /><br />
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- send-pm-modal -->
<div class="modal fade" id="send-pm-modal" tabindex="-1" role="dialog" aria-labelledby="send-pm-modal-label" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="send-pm-modal-label">Отправить сообщение</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col">
						<text class="text-muted strong">Кому:</text> <img name="userAvatar" src="" class="rounded-circle" /> <a name="userName" href="/profile/id1" class="wdo-link">Username</a>
					</div>
				</div>
				<div class="row" style="justify-content: center;background: url(/images/ornament.png) no-repeat bottom right 10px;">
					<div class="col">
						<br /><textarea class="form-control" placeholder="Введите сообщение" name="message-text-from-modal"></textarea>
						<br /><div class="wdo-btn bg-yellow strong" name="send-pm" data-recipient-id="" style="max-width: 75%; margin: 0 auto;"><i class="fa"></i>Отправить</div>
						<br /><br /><br />
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
