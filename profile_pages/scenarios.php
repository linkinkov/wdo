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
	if ( $scenario_id > 0 && sizeof($subcats) )
	{
		$response = Scenario::create_event($title,$budget,$timestamp_start,$timestamp_end,$scenario_id,$subcats);
	}
	else
	{
		if ( $title == "" ) $response["message"] = "Укажите название праздника";
		if ( sizeof($subcats) == 0 ) $response["message"] = "Выберите хотя-бы один раздел";
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