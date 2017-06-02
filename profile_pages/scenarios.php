<?php
$action = get_var("action","string","");
if ( $action == "create_event" )
{
	$title = get_var("title","string","");
	$budget = get_var("budget","int",0);
	$timestamp_start = get_var("timestamp_start","int",0);
	$timestamp_end = get_var("timestamp_end","int",0);
	$scenario_id = get_var("scenario_id","int",0);
	$subcats = get_var("subcats","array",Array());
	$response["result"] = "false";
	if ( $title == "" ) $response["message"] = "Укажите название праздника";
	else if ( sizeof($subcats) == 0 ) $response["message"] = "Выберите хотя-бы один раздел";
	else if ( $scenario_id > 0 && sizeof($subcats) )
	{
		$response = Scenario::create_event($title,$budget,$timestamp_start,$timestamp_end,$scenario_id,$subcats);
	}
	header('Content-Type: application/json');
	echo json_encode($response);
}
else if ( $action == "archive_event" )
{
	$event_id = get_var("event_id","string","");
	$response = Array(
		"result"=>"false",
		"message"=>"Ошибка"
	);
	if ( $event = new Scenario($event_id) )
	{
		$response = $event->archive_event();
	}
	header('Content-Type: application/json');
	echo json_encode($response);
}
else if ( $action == "add_to_event_dialog" )
{
	$event_id = get_var("event_id","string","");
	$performer_id = get_var("performer_id","int",0);
	$response = Array(
		"result"=>"false",
		"message"=>"Ошибка"
	);
	if ( $performer_id > 0 && strlen($event_id) == 32 )
	{
		if ( $event = new Scenario($event_id) )
		{
			$response = $event->add_to_event_dialog($performer_id);
		}
	}
	header('Content-Type: application/json');
	echo json_encode($response);
}
if ( $action != "" )
{
	exit;
}
$list_active = Scenario::get_list(0);
$list_archive = Scenario::get_list(1);
?>
<br />
<h6 class="text-purple-dark"><strong>Сценарии</strong></h6>
<br />
<div class="row">
	<div class="col">
		<small><strong>Вы можете выбрать один из сценариев. Наш мастер поможет вам подать заявки и организовать мероприятие на высоком уровне.<br />
		Чтобы начать выберите нужное мероприятие, оставьте выделенными только те пункты, которые вам понадобятся и нажмите старт. Затем пройдите по разделам и создайте проекты. Наш мастер поможет вам ничего не забыть и поможет отследить процесс подготовки.
		</strong></small>
	</div>
</div>
<br />
<div id="event-create" style="display: none;">

	<h4 class="text-muted text-roboto-cond">Создайте праздник:</h4>

	<div class="row"><div class="col"><hr /></div></div>
	<div class="row">
		<div class="col" style="flex: 0 0 280px; max-width: 280px; align-self: center;">
			<text class="text-muted">Название</text>
		</div>
		<div class="col">
			<input type="text" class="form-control" data-name="title" placeholder="Например: Свадьба Вовы и Маши" />
		</div>
	</div>

	<div class="row"><div class="col"><hr /></div></div>
	<div class="row">
		<div class="col" style="flex: 0 0 280px; max-width: 280px; align-self: center;">
			<text class="text-muted">Бюджет</text>
		</div>
		<div class="col">
			<input type="number" class="form-control" data-name="budget" placeholder="Бюджет в рублях" />
		</div>
	</div>

	<div class="row"><div class="col"><hr /></div></div>
	<div class="row">
		<div class="col" style="flex: 0 0 280px; max-width: 280px; align-self: center;">
			<text class="text-muted">Дата мероприятия</text>
		</div>
		<div class="col">
			<input type="text" class="form-control" data-name="start_end" data-timestamp_start="0" data-timestamp_end="0" placeholder="Дата мероприятия" />
		</div>
	</div>

	<br />
	<h4 class="text-muted text-roboto-cond">Выберите сценарий:</h4>

	<div id="scenario-list" style="width: 400px;"></div>
</div>

<script>
$(function(){
	var start_end_opts = config.datePickerOptions;
	start_end_opts.locale.format = "DD.MM.YYYY";
	start_end_opts.showDropdowns = false;
	start_end_opts.ranges = false;
	start_end_opts.showCustomRangeLabel = false;
	start_end_opts.autoApply = true;
	start_end_opts.minDate = moment().add(1,"days").format("DD.MM.YYYY");
	start_end_opts.maxDate = moment().add(1,"years").format("DD.MM.YYYY");
	start_end_opts.startDate = moment().add(7,"days");
	start_end_opts.endDate = moment().add(7,"days");
	start_end_opts.dateLimit = {months: 1},
	start_end_opts.separator = " / ";

	$('input[data-name="start_end"]').daterangepicker(start_end_opts);
	$('input[data-name="start_end"]').on('apply.daterangepicker', function(ev, picker) {
		$(this).data('timestamp_start',picker.startDate.format("X"));
		$(this).data('timestamp_end',picker.endDate.format("X"));
	});
	$('input[data-name="start_end"]').data('timestamp_start',start_end_opts.startDate.format("X"));
	$('input[data-name="start_end"]').data('timestamp_end',start_end_opts.endDate.format("X"));

	app.scenario.getList(function(response){
		if ( response.length > 0 )
		{
			var row = $("<div />",{
				class: "row"
			});
			$.each(response,function(i,data){
				var col = app.formatter.format_scenario_col(data);
				$(row).append(col);
			})
			$(row).appendTo($("#scenario-list"));
		}
	})
})

</script>
<div id="event" style="display: none;">
	<h4 class="text-muted text-roboto-cond event_id" data-event_id="">Праздник: <text class="text-purple event-title"></text></h4>
	<br />
	<div class="row">
		<div class="col">
			<div class="row event-budget-dashboard">
				<div class="col">
					<div class="row" style="align-items: center;">
						<div class="col" style="max-width: 35px;">
							<img src="/images/event-budget-total.png" />
						</div>
						<div class="col">
							Бюджет: <br />
							<text class="event-budget-total"></text>
						</div>
					</div>
				</div>
				<div class="col">
					<div class="row" style="align-items: center;">
						<div class="col" style="max-width: 45px;">
							<img src="/images/event-budget-spent.png" />
						</div>
						<div class="col">
							Истрачено: <br />
							<text class="event-budget-spent"></text>
						</div>
					</div>
				</div>
				<div class="col">
					<div class="row" style="align-items: center;">
						<div class="col" style="max-width: 45px;">
							<img src="/images/event-budget-left.png" />
						</div>
						<div class="col">
							Осталось: <br />
							<text class="event-budget-left"></text>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col" style="max-width: 200px;">
			<div class="row event-budget-scale">
				<div class="col scale scale-default"></div>
				<div class="col scale scale-default"></div>
				<div class="col scale scale-default"></div>
				<div class="col scale scale-default"></div>
				<div class="col scale scale-default"></div>
			</div>
		</div>
	</div>
	<br />
	<div class="progress event-progress">
		<div class="progress-bar event-progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
		<div class="event-progress-current">0/0</div>
	</div>
	<br />
	<hr />
	<h6 class="text-muted">Вы создали проекты</h6>
	<hr />
	<div class="event-projects-created"></div>
	<div id="event-extra-actions">
		<hr />
		<h6 class="text-muted">Нужно создать</h6>
		<hr />
		<div class="event-projects-to-create">
			<!--<a class="btn-link wdo-link underline" onClick="add_project()">+ Добавить проект</a>-->
		</div>
		<hr />
		<div class="wdo-btn btn-sm bg-purple archive_event" onClick="archive_event()">В архив</div>
	</div>
</div>

<script>
function add_project()
{
	var preselected_subcat_id = 0;
	$.each($("input[name='radio-c-1']"),function(i,v){
		if ( $(v).prop("checked") == true )
		{
			preselected_subcat_id = $(v).attr("data-subcat_id");
			return;
		}
	})
	var event_id = $(".event_id").data('event_id'),
			link = '/project/add?event_id='+event_id;
	if ( preselected_subcat_id > 0 ) link += '&subcat_id='+preselected_subcat_id;
	window.location = link;
}
function colorize_budget(budget_left_percent)
{
	if ( budget_left_percent >= 81 )
	{
		$(".event-budget-scale").find(".scale").each(function(i,v){
			$(v).removeClass("scale-default").addClass("scale-green");
		})
		cost_class = 'text-success';
	}
	else if ( budget_left_percent >= 61 )
	{
		$(".event-budget-scale").find(".scale").each(function(i,v){
			if ( i > 3 ) return;
			$(v).removeClass("scale-default").addClass("scale-green");
		})
		cost_class = 'text-success';
	}
	else if ( budget_left_percent >= 41 )
	{
		$(".event-budget-scale").find(".scale").each(function(i,v){
			if ( i > 2 ) return;
			$(v).removeClass("scale-default").addClass("scale-green");
		})
		cost_class = 'text-warning';
	}
	else if ( budget_left_percent >= 21 )
	{
		$(".event-budget-scale").find(".scale").each(function(i,v){
			if ( i > 1 ) return;
			$(v).removeClass("scale-default").addClass("scale-yellow");
		})
		cost_class = 'text-warning';
	}
	else if ( budget_left_percent >= 0 )
	{
		$(".event-budget-scale").find(".scale").each(function(i,v){
			if ( i > 0 ) return;
			$(v).removeClass("scale-default").addClass("scale-red");
		})
		cost_class = 'text-danger';
	}
	else
	{
		cost_class = 'text-danger';
	}
	return cost_class;
}
function archive_event()
{
	var event_id = $(".event_id").data('event_id');
	app.scenario.moveToArchive(event_id,function(response){
		if ( response.result == "true" ) window.location.reload();
		else showAlert("error",response.message);
	})
}
function addToEventDialog(performer_id)
{
	if ( parseInt(performer_id) <= 0 ) return false;
	var event_id = $(".event_id").data('event_id');
	$.ajax({
		type: "POST",
		url: "/pp/scenarios",
		dataType: "JSON",
		data: {
			"action": "add_to_event_dialog",
			"event_id": event_id,
			"performer_id": performer_id
		},
		success: function (response) {
			if ( response.message )
			{
				showAlert("info",response.message);
			}
		}
	})

}
function show_event(event_id)
{
	$(".loader").show();
	app.scenario.getEventInfo(event_id,function(response){
		if ( response.event_id.length != 32 )
		{
			return false;
		}
		var budget_left_percent = parseInt(response.event.budget_left.value) / parseInt(response.event.budget_total.value) * 100;
		var cost_class = colorize_budget(budget_left_percent);

		$(".event-projects-created").html("");
		$(".event-projects-to-create").html("");
		if ( response.event.archive == 1 )
		{
			$("#event-extra-actions").hide();
		}
		else
		{
			$("#event-extra-actions").show();
		}
		$(".event_id").attr("data-event_id",event_id).data('event_id',event_id);
		if ( response.event.archive == 1 ) response.event.title += ' (архивный)';
		$(".event-title").text(response.event.title);
		$(".event-budget-total").text(response.event.budget_total.format+" р.");
		$(".event-budget-spent").text(response.event.budget_spent.format+" р.");
		$(".event-budget-left").text(response.event.budget_left.format+" р.").addClass(cost_class);
		if ( response.created_projects.length > 0 )
		{
			$.each(response.created_projects,function(i,project){
				$(".event-projects-created").append(app.formatter.format_scenario_created_project(project));
			})
		}
		if ( response.event.projects_to_create.length > 0 )
		{
			$.each(response.event.projects_to_create,function(i,subcat){
				$(".event-projects-to-create").append(app.formatter.format_scenario_projects_to_create(subcat));
			})
		}
		$(".event-projects-to-create").append('<a class="btn-link wdo-link" href="/project/add?event_id='+event_id+'"><i class="fa fa-plus"></i> Добавить проект</a>');
		$(".event-progress-bar").css("width",response.progress.percent+"%");
		$(".event-progress-current").css("left","calc("+response.progress.percent+"% - 25px").text(response.progress.projects_done+"/"+response.progress.projects_total);
		$("#event-create").hide('slow');
		$("#event").show('slow');
		$(".loader").hide();
	})
}
if ( getCookie('last_event_id') && getCookie('last_event_id').length == 32 )
{
	show_event(getCookie('last_event_id'));
}
</script>

<hr />

<div id="accordion" role="tablist" aria-multiselectable="true">
	<div class="card" style="margin-bottom: 30px;">
		<div class="card-header pointer" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
			<h5 class="mb-0">
				<a class="wdo-link">
					Активные праздники
				</a>
			</h5>
		</div>

		<div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
			<div class="card-block">
				<?php
				if ( sizeof($list_active) )
				{
					foreach ( $list_active as $event )
					{
						echo sprintf('
						<h6><a href="#scenarios" class="wdo-link" onClick="show_event(\'%s\')">%s</a></h6>
						',$event->event_id,$event->title);
					}
					echo '<hr />';
				}
				?>
				<div class="wdo-btn btn-sm bg-purple" onClick="$('#event-create').show('slow');$('#event').hide('slow');">+ Добавить праздник</div>
			</div>

		</div>
	</div>
	<div class="card">
		<div class="card-header collapsed pointer" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
			<h5 class="mb-0">
				<a class="wdo-link">
					Архив
				</a>
			</h5>
		</div>
		<div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
			<div class="card-block">
			<?php
				if ( sizeof($list_archive) )
				{
					foreach ( $list_archive as $event )
					{
						echo sprintf('
						<h6><a href="#scenarios" class="wdo-link" onClick="show_event(\'%s\')">%s</a></h6>
						',$event->event_id,$event->title);
					}
				}
			?>
			</div>
		</div>
	</div>
</div>

