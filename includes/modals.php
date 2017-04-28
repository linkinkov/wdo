
<!-- register-modal -->
<div class="modal fade" id="register-modal" tabindex="-1" role="dialog" aria-labelledby="register-modal-label" aria-hidden="true">
	<div class="modal-dialog" role="document" style="width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title text-roboto-cond" id="register-modal-label">Регистрация</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row" style="justify-content: center;background: url(/images/ornament.png) no-repeat bottom right 10px;">
					<div class="col text-center">
						<br /><input type="text" class="form-control" placeholder="Введите e-mail" name="username" />
						<br /><input type="password" class="form-control" placeholder="Введите пароль" name="password" />
						<br /><input type="password" class="form-control" placeholder="Повторите пароль" name="password_confirm" />
						<br /><div class="wdo-btn btn-sm bg-yellow strong">Отправить</div>
						<br /><br /><br />
					</div>
				</div><!-- /.row -->
			</div><!-- /.modal-body -->
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- city-select-modal -->
<div class="modal fade" id="city-select-modal" tabindex="-1" role="dialog" aria-labelledby="city-select-modal-label" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title text-roboto-cond" id="city-select-modal-label">Выбор города</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row" style="justify-content: center;">
					<div class="col strong text-center" style="flex: 0 0 80%;">
						<p>Мы определили Ваш город как <?php echo $_COOKIE["city_name"];?></p>
						<p>Если мы определили его не правильно, введите свой город</p>
					</div>
				</div>
				<div class="row" style="justify-content: center;">
					<div class="col text-center" style="flex: 0 0 80%;">
						<input type="search" class="form-control" placeholder="Введите для поиска и выберите из списка ниже" />
					</div>
				</div>
			</div>
			<div class="modal-footer" style="justify-content: space-around;"><div class="row" id="city_list"></div></div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- login-modal -->
<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="login-modal-label" aria-hidden="true">
	<div class="modal-dialog" role="document" style="width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title text-roboto-cond" id="login-modal-label">Авторизация</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row" style="justify-content: center;">
					<div class="col text-center">
						<form method="post" action="<?php echo HOST;?>/login/" onSubmit="formhash(this,this.password);return false;">
							<br /><input type="text" class="form-control" placeholder="Введите e-mail" name="username" />
							<br /><input type="password" class="form-control" placeholder="Введите пароль" name="password" />
							<br /><button type="submit" class="wdo-btn btn-sm bg-yellow strong">Вход</button>
						</form>
						<hr />
						<span class="pull-left">
							<a class="wdo-link" href="#" style="color: #4b5257;" data-toggle="modal" data-target="#restore-password-modal">Забыли пароль?</a>
						</span>
						<span class="pull-right">
							<a class="wdo-link" href="#" style="color: #4b5257;" data-toggle="modal" data-target="#register-modal">У меня нет аккаунта</a>
						</span>
					</div>
				</div>
			</div><!-- /.modal-body -->
			<div class="modal-footer" style="height: 55px; background: url(/images/ornament-3.png) repeat-x bottom 10px right;"></div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- restore-password-modal -->
<div class="modal fade" id="restore-password-modal" tabindex="-1" role="dialog" aria-labelledby="restore-password-modal-label" aria-hidden="true">
	<div class="modal-dialog" role="document" style="width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title text-roboto-cond" id="restore-password-modal-label">Восстановление пароля</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row" style="justify-content: center;">
					<div class="col strong text-center">
						<p>Ссылка на восстановление пароля будет отправлена на почту</p>
					</div>
				</div>
				<div class="row" style="justify-content: center;background: url(/images/ornament-2.png) repeat-x bottom right 10px;">
					<div class="col text-center">
						<br /><input type="text" class="form-control" placeholder="Введите e-mail" name="username" />
						<br /><div class="wdo-btn btn-sm bg-yellow strong">Отправить</div>
						<br /><br /><br />
					</div>
				</div><!-- /.row -->
			</div><!-- /.modal-body -->
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- send-pm-modal -->
<div class="modal fade" id="send-pm-modal" tabindex="-1" role="dialog" aria-labelledby="send-pm-modal-label" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title text-roboto-cond" id="send-pm-modal-label">Отправить сообщение</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col">
						<text class="text-muted strong">Кому:</text> <img name="userAvatar" src="" class="rounded-circle shadow" /> <a name="real_user_name" href="" class="wdo-link"></a>
					</div>
				</div>
				<div class="row" style="justify-content: center;background: url(/images/ornament.png) no-repeat bottom right 10px;">
					<div class="col text-center">
						<br /><textarea class="form-control" placeholder="Введите сообщение" name="message-text"></textarea>
						<br /><div class="wdo-btn btn-sm bg-yellow strong" name="send-pm" data-ot="Отправить" data-lt="Отправка" data-recipient-id=""><i class="fa"></i>Отправить</div>
						<br /><br /><br />
					</div>
				</div><!-- /.row -->
			</div><!-- /.modal-body -->
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- add-note-modal -->
<div class="modal fade" id="save-note-modal" tabindex="-1" role="dialog" aria-labelledby="save-note-modal-label" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title text-roboto-cond" id="save-note-modal-label">Добавить / изменить заметку</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col">
						<img name="userAvatar" src="" class="rounded-circle shadow" /> <a name="real_user_name" href="" class="wdo-link"></a>
					</div>
				</div>
				<div class="row" style="justify-content: center;background: url(/images/ornament.png) no-repeat bottom right 10px;">
					<div class="col text-center">
						<br /><textarea class="form-control" placeholder="Введите заметку" name="note-text"></textarea>
						<br /><div class="wdo-btn btn-sm bg-yellow strong" name="save-note" data-ot="Сохранить" data-lt="Сохранение" data-recipient-id=""><i class="fa"></i>Сохранить</div>
						<br /><br /><br />
					</div>
				</div><!-- /.row -->
			</div><!-- /.modal-body -->
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- user-calendar-modal -->
<div class="modal fade" id="user-calendar-modal" tabindex="-1" role="dialog" aria-labelledby="user-calendar-modal-label" aria-hidden="true">
	<div class="modal-dialog" role="document" style="width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title text-roboto-cond" id="user-calendar-modal-label">Отметить даты как занятые</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row" style="justify-content: center;">
					<div class="col strong text-center">
						<p>На занятую дату Вы не будете получать заявки</p>
					</div>
				</div>
				<div class="row">
					<div class="col">
						<div class="calendar calendar-wide"></div>
					</div>
				</div><!-- /.row -->
				<div class="row" style="justify-content: center;background: url(/images/ornament-2.png) repeat-x bottom right 10px;">
					<div class="col text-center">
						<div class="wdo-btn btn-sm bg-yellow" name="save-calendar" data-ot="Сохранить" data-lt="Сохранение">Сохранить</div>
						<br /><br /><br />
					</div>
				</div><!-- /.row -->
			</div><!-- /.modal-body -->
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- alert-modal -->
<div class="modal" id="alert-modal" tabindex="-1" role="dialog" aria-labelledby="alert-modal-label" aria-hidden="true">
	<div class="modal-dialog" role="document" style="width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title text-roboto-cond" id="alert-modal-label">Внимание!</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row" style="justify-content: center;">
					<div class="col text-center">
						<h5 id="alert-modal-message"></h5>
					</div>
				</div>
			</div><!-- /.modal-body -->
			<div class="modal-footer" style="height: 55px; background: url(/images/ornament-3.png) repeat-x bottom 10px right;"></div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
