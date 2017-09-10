
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
						<br /><input type="text" class="form-control" placeholder="Ваш e-mail" name="username" value="" />
						<br /><input type="text" class="form-control" placeholder="Ваше имя" name="real_user_name" value="" />
						<br /><input type="password" class="form-control" placeholder="Введите пароль" name="password" value="" />
						<br /><input type="password" class="form-control" placeholder="Повторите пароль" name="password_2" value="" />
						<br /><div class="wdo-btn btn-sm bg-yellow strong" onClick="app.user.register(this);" data-ot="Отправить" data-lt="Отправка">Отправить</div>
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
							<br /><input type="email" class="form-control" placeholder="Введите e-mail" name="username" />
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

<!-- conversation-modal -->
<div class="modal fade" id="conversation-modal" tabindex="-1" role="dialog" aria-labelledby="conversation-modal-label" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title text-roboto-cond" id="conversation-modal-label">Отправить сообщение</h5>
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
						<br /><div class="wdo-btn btn-sm bg-yellow strong" modal="true" data-trigger="send-message" data-ot="Отправить" data-lt="Отправка"><i class="fa"></i>Отправить</div>
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


<!-- alert-modal -->
<div class="modal" id="performers-map-modal" tabindex="-1" role="dialog" aria-labelledby="performers-map-modal-label" aria-hidden="true">
	<div class="modal-dialog" role="document" style="max-width: 80%;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title text-roboto-cond" id="performers-map-modal-label">Исполнители на карте</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="map" style="height: 700px;"></div>
			</div><!-- /.modal-body -->
			<div class="modal-footer" style="height: 55px; background: url(/images/ornament-3.png) repeat-x bottom 10px right;"></div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- change_password-modal -->
<div class="modal fade" id="change_password-modal" tabindex="-1" role="dialog" aria-labelledby="change_password-modal-label" aria-hidden="true">
	<div class="modal-dialog" role="document" style="width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title text-roboto-cond" id="change_password-modal-label">Смена пароля</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row" style="justify-content: center;">
					<div class="col text-center">
						<br /><input type="password" class="form-control" placeholder="Введите пароль" name="password" />
						<br /><input type="password" class="form-control" placeholder="Повторите пароль" name="password_2" />
						<br /><div class="wdo-btn btn-sm bg-yellow strong" id="change_password_btn">Изменить</div>
					</div>
				</div>
			</div><!-- /.modal-body -->
			<div class="modal-footer" style="height: 55px; background: url(/images/ornament-3.png) repeat-x bottom 10px right;"></div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- add project modal apm-modal -->
<div class="modal fade" id="apm-modal" tabindex="-1" role="dialog" aria-labelledby="apm-modal-label" aria-hidden="true">
	<div class="modal-dialog" role="document" style="width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title text-roboto-cond" id="apm-modal-label">Создать мероприятие</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row" style="justify-content: center;">
					<div class="col text-center">
						<div class="jumbotron">
							<h4 class="text-purple">
								<span class="fa-stack text-purple">
									<i class="fa fa-circle-o fa-stack-2x"></i>
									<i class="fa fa-star fa-stack-1x"></i>
								</span>
								Мастер праздников
							</h4>
							<p class="lead">Наш мастер поможет Вам создать проекты в необходимых разделах и организовать мероприятие на высоком уровне</p>
							<hr class="my-4">
							<!-- <p>It uses utility classes for typography and spacing to space content out within the larger container.</p> -->
							<p class="lead">
								<a class="btn btn-primary btn-lg" href="/profile/#scenarios" role="button">
									Перейти в Мастер праздников
								</a>
							</p>
							<p class="lead">или</p>
							<a class="btn btn-primary btn-lg" href="/project/add/" role="button">
								Создать проект
							</a>
						</div>
				</div>
				</div>
			</div><!-- /.modal-body -->
			<div class="modal-footer" style="height: 55px; background: url(/images/ornament-3.png) repeat-x bottom 10px right;"></div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
