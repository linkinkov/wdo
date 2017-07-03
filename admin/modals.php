
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


<!-- warn-user-modal -->
<div class="modal fade" id="warn-user-modal" tabindex="-1" role="dialog" aria-labelledby="warn-user-modal-label" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title text-roboto-cond" id="warn-user-modal-label">Заблокировать проект</h5>
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
				<hr />
				<div class="row">
					<div class="col">
						<text class="text-muted strong">Проект:</text> <text name="project_title" class="text-purple"></text>
					</div>
				</div>
				<div class="row" style="justify-content: center;background: url(/images/ornament.png) no-repeat bottom right 10px;">
					<div class="col text-center">
						<br /><textarea class="form-control" placeholder="Введите текст предупреждения" name="warning-text"></textarea>
						<br /><div class="wdo-btn btn-sm bg-yellow strong" modal="true" data-trigger="send-warning" data-ot="Отправить" data-lt="Отправка"><i class="fa"></i>Отправить</div>
						<br /><br /><br />
					</div>
				</div><!-- /.row -->
			</div><!-- /.modal-body -->
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
