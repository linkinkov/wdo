
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

<!-- add-category-modal -->
<div class="modal fade" id="add-category-modal" tabindex="-1" role="dialog" aria-labelledby="add-category-modal-label" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title text-roboto-cond" id="add-category-modal-label">Добавить категорию</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col">
						<input class="form-control" placeholder="Наименование" name="cat_name" />
					</div>
				</div>
				<div class="row" style="justify-content: center;background: url(/images/ornament.png) no-repeat bottom right 10px;">
					<div class="col text-center">
						<br /><div class="wdo-btn btn-sm bg-yellow strong" modal="true" data-trigger="add-category" data-ot="Добавить" data-lt="Сохранение"><i class="fa"></i>Добавить</div>
						<br /><br /><br />
					</div>
				</div><!-- /.row -->
			</div><!-- /.modal-body -->
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- add-subcategory-modal -->
<div class="modal fade" id="add-subcategory-modal" tabindex="-1" role="dialog" aria-labelledby="add-subcategory-modal-label" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title text-roboto-cond" id="add-subcategory-modal-label">Добавить категорию</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col">
						<select class="form-control" name="parent_cat_id">
							<option value="0" disabled="disabled" selected="selected">Выберите категорию</option>
							<?php
							foreach ( Category::get_list() as $r )
							{
								echo sprintf('<option value="%d">%s</option>',$r->id,$r->cat_name);
							}
							?>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col">
						<input class="form-control" placeholder="Наименование" name="cat_name" />
					</div>
				</div>
				<div class="row" style="justify-content: center;background: url(/images/ornament.png) no-repeat bottom right 10px;">
					<div class="col text-center">
						<br /><div class="wdo-btn btn-sm bg-yellow strong" modal="true" data-trigger="add-subcategory" data-ot="Добавить" data-lt="Сохранение"><i class="fa"></i>Добавить</div>
						<br /><br /><br />
					</div>
				</div><!-- /.row -->
			</div><!-- /.modal-body -->
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- add-scenario-modal -->
<div class="modal fade" id="add-scenario-modal" tabindex="-1" role="dialog" aria-labelledby="add-scenario-modal-label" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title text-roboto-cond" id="add-scenario-modal-label">Добавить категорию</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col">
						<input class="form-control" placeholder="Наименование" name="scenario_name" />
					</div>
				</div>
				<div class="row" style="justify-content: center;background: url(/images/ornament.png) no-repeat bottom right 10px;">
					<div class="col text-center">
						<br /><div class="wdo-btn btn-sm bg-yellow strong" modal="true" data-trigger="add-scenario" data-ot="Добавить" data-lt="Сохранение"><i class="fa"></i>Добавить</div>
						<br /><br /><br />
					</div>
				</div><!-- /.row -->
			</div><!-- /.modal-body -->
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
