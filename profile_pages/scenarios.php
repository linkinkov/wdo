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
if ( $action != "" )
{
	exit;
}
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

<?php

$list_active = Scenario::get_active();
if ( sizeof($list_active) > 0 )
{
?>
<h4 class="text-muted text-roboto-cond event_id" data-event_id="">Праздник: <text class="text-purple event-title">Свадьба Вовы и Маши</text></h4>
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
						<text class="event-budget-total">1 200 000 р.</text>
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
						<text class="event-budget-spent">60 000 р.</text>
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
						<text class="event-budget-left">1 140 000 р.</text>
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
  <div class="progress-bar event-progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
	<div class="event-progress-current">3/8</div>
</div>
<br />
<hr />
<h6 class="text-muted">Вы создали проекты</h6>
<hr />
<div class="event-projects-created">
	<div class="row event-project" data-project_id="1">
		<div class="col">
			<label class="custom-control custom-radio custom-radio">
				<input name="radio-c-1-2" checked="true" type="radio" class="custom-control-input">
				<span class="custom-control-indicator"></span>
				<span class="custom-control-description event-project-title">Ведущий</span>
			</label>
		</div>
		<div class="col event-project-cost">
			20 000 р.
		</div>
		<div class="col event-project-performer">
			Женя Черн
		</div>
		<div class="col event-add-chat">
			<a title="Добавить исполнителя в общий чат" href="" class="wdo-link">+ <i class="fa fa-comments"></i></a>
		</div>
		<div class="col event-project-status">
			В работе
		</div>
	</div>
</div>
<hr />
<h6 class="text-muted">Нужно создать</h6>
<hr />
<div class="event-projects-to-create">
	<a class="btn-link wdo-link underline" onClick="add_project()">+ Добавить проект</a>
</div>
<hr />
<div class="wdo-btn btn-sm bg-purple">+ Добавить праздник</div>
<div class="wdo-btn btn-sm bg-purple">В архив</div>
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
$(function(){
	var event_id = '796722fb15975876560de5d7ce0c87d7';
	app.scenario.getEventInfo(event_id,function(response){
		if ( response.event_id.length != 32 )
		{
			return false;
		}
		var budget_left_percent = parseInt(response.event.budget_left.value) / parseInt(response.event.budget_total.value) * 100;
		var cost_class = colorize_budget(budget_left_percent);

		$(".event_id").attr("data-event_id",event_id).data('event_id',event_id);
		$(".event-title").text(response.event.title);
		$(".event-budget-total").text(response.event.budget_total.format+" р.");
		$(".event-budget-spent").text(response.event.budget_spent.format+" р.");
		$(".event-budget-left").text(response.event.budget_left.format+" р.").addClass(cost_class);
		if ( response.created_projects.length > 0 )
		{
			$(".event-projects-created").html("");
			$.each(response.created_projects,function(i,project){
				$(".event-projects-created").append(app.formatter.format_scenario_created_project(project));
			})
		}
		if ( response.event.projects_to_create.length > 0 )
		{
			$(".event-projects-to-create").html("");
			$.each(response.event.projects_to_create,function(i,subcat){
				$(".event-projects-to-create").append(app.formatter.format_scenario_projects_to_create(subcat));
			})
			$(".event-projects-to-create").append('<a class="btn-link wdo-link underline" onClick="add_project()">+ Добавить проект</a>');
		}
		$(".event-progress-bar").css("width",response.progress.percent+"%");
		$(".event-progress-current").css("left","calc("+response.progress.percent+"% - 25px").text(response.progress.projects_done+"/"+response.progress.projects_total);
	})
})
</script>
<?php
}
else // user have no active events, let him create one
{
?>
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

<div id="scenario-list" style="width: 400px;">
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
<?php
} // user have no active events, let him create one
?>
