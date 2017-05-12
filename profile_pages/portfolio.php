<?php
$_SESSION["LAST_PAGE"] = "profile/portfolio";
if ( $current_user->user_id == $user->user_id )
{
?>
<div class="row">
	<div class="col">
		<a class="wdo-btn btn-sm yellow-outline" data-toggle="tab" data-target="#portfolio-add" role="tab"><i class="fa fa-plus"></i> Добавить работу</a>
	</div>
</div>
<br />
<?php
}
?>
<div class="row">
	<div class="col" style="overflow-x: hidden;position: relative;">
		<div id="portfolio_single">
			<div class="row">
				<div class="col">
					<span class="pull-left">
						<h4 class="text-purple-dark" id="portfolio-title"></h4>
					</span>
					<?php
					if ( $user->user_id == $current_user->user_id )
					{
					?>
					<span class="pull-right">
						<a id="portfolio-delete-link" class="wdo-link opacity" data-portfolio_id=""><i class="fa fa-trash"></i> Удалить</a>
						<a id="portfolio-edit-link" class="wdo-link opacity" data-portfolio_id="" data-toggle="tab" data-target="#portfolio-edit" role="tab"><i class="fa fa-pencil"></i> Редактировать</a>
					</span>
					<?php
					}
					?>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<a class="wdo-link opacity" onClick="app.portfolio.hide();"><img src="/images/back-arrow.png" /> Вернуться</a>
				</div>
			</div>
			<div class="row"><div class="col"><hr /></div></div>
			<div class="row">
				<div class="col">
					<p id="portfolio-descr" class="text-justify">Описание</p>
				</div>
			</div>
			
			<div class="portfolio-photos-container">
				<div class="row"><div class="col"><hr /></div></div>
				<div class="row">
					<div class="col" style="max-width: 100px;">
						Фото
					</div>
					<div class="col" id="portfolio-photos"></div>
				</div>
			</div>

			<div class="portfolio-videos-container">
				<div class="row"><div class="col"><hr /></div></div>
				<div class="row">
					<div class="col" style="max-width: 100px;">
						Видео
					</div>
					<div class="col" id="portfolio-videos"></div>
				</div>
			</div>

			<div class="portfolio-docs-container">
				<div class="row"><div class="col"><hr /></div></div>
				<div class="row">
					<div class="col" style="max-width: 100px;">
						Документы
					</div>
					<div class="col" id="portfolio-docs"></div>
				</div>
			</div>

		</div>
		<div class="card-columns" id="portfolio_list"></div>
	</div>
</div>
<script>
$(function(){
	app.portfolio.getList(function(response){
		if ( response.length > 0 )
		{
			$("#portfolio_list").html('');
			$.each(response,function(){
				$("#portfolio_list").append(app.portfolio.format_preview(this));
			})
		}
	})
})
</script>