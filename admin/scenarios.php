<?php
require_once('../_global.php');
require_once('../_includes.php');
require(PD.'/admin/check_admin.php');

check_access($db,true);
?>
<hr />
<div class="row">
	<div class="col">
		<h5>Шаблоны сценариев</h5>
		<button class="btn btn-secondary btn-md" type="button" data-toggle="modal" data-target="#add-scenario-modal">
			<i class="fa fa-plus"></i> Добавить
		</button>
	</div>
</div>
<hr />
<table class="table table-hover" id="scenariosTable">
	<thead>
		<th width="50">Порядок</th>
		<th>Наименование</th>
		<th width="100">Активных</th>
		<th width="100">Всего</th>
		<th width="150">Подкатегорий</th>
		<th width="150">Статус</th>
	</thead>
	<tbody>
	</tbody>
</table>

<hr />
<div class="row">
	<div class="col">
		<h5>Подкатегории в шаблоне</h5>
	</div>
</div>
<hr />
<table class="table table-hover" id="subCategoriesTable">
	<thead>
		<th>Наименование</th>
	</thead>
	<tbody>
	</tbody>
</table>

<script>

$(function(){
	conf.scenariosTable = $("#scenariosTable").DataTable({
		"language": {"url": "/js/dataTables/dataTables.russian.lang"},
		"bProcessing": true,
		"bServerSide": true,
		"pagingType": "full_numbers",
		"ajax": {
			"url": "/admin/dt/scenarios",
			"type": "POST",
		},
		"bStateSave": true,
		"columns": [
			{"data": "sort"},
			{"data": "scenario_name"},
			{"data": "active_events"},
			{"data": "total_events"},
			{"data": "scenario_subcats_counter"},
			{"data": "disabled"},
		],
		"order": [[0, 'desc']],
		"initComplete": function(table,data) {
			// $("#projects-table").find("th:eq(1)").css('min-width','100px');
		},
		"createdRow": function ( row, data, index ) {
			$('td', row).eq(0).html('<a href="#" class="editable" data-mode="popup" data-type="text" data-name="sort" data-url="/admin/action.php?job=update&type=scenario" data-pk="'+data.scenario_id+'">'+data.sort+'</a>');
			$('td', row).eq(1).html('<a href="#" class="editable" data-mode="popup" data-type="text" data-name="scenario_name" data-url="/admin/action.php?job=update&type=scenario" data-pk="'+data.scenario_id+'">'+data.scenario_name+'</a>');
			$('td', row).eq(4).html('<text class="text-purple">'+data.scenario_subcats_counter+'</text><span class="pull-right"><a href="#" data-trigger="filter-scenario" data-scenario_id="'+data.scenario_id+'">Показать</a></span>');
			console.log(data.total_events,data.active_events);
			if ( data.total_events == 0 && data.active_events == 0 )
			{
				$('td', row).eq(1).append('<span class="pull-right"><a href="#" data-trigger="delete" data-type="scenario" data-id="'+data.scenario_id+'">Удалить</a></span>');
			}
		},
		"drawCallback": function( settings ) {
			$(".paginate_button > a").on("focus", function() {$(this).blur();});
			$(".editable").editable({
				ajaxOptions: {
					dataType: "JSON"
				},
				success: function(response, newValue) {
					if (response.result == 'false') return response.message;
				}
			});
		}
	})

	conf.subCategoriesTable = $("#subCategoriesTable").DataTable({
		"language": {"url": "/js/dataTables/dataTables.russian.lang"},
		"bProcessing": true,
		"bServerSide": true,
		"pagingType": "full_numbers",
		"ajax": {
			"url": "/admin/dt/subcategories",
			"type": "POST",
			"data": function(d)
			{
				var selected_scenario_id = $("#scenariosTable").find("tr.selected").attr("id");
				if ( isNaN(selected_scenario_id) ) selected_scenario_id = -1;
				d.scenario_id = selected_scenario_id;
				return d;
			}
		},
		"bStateSave": true,
		"columns": [
			{"data": "subcat_name"},
		],
		"order": [[0, 'desc']],
		"initComplete": function(table,data) {
			// $("#projects-table").find("th:eq(1)").css('min-width','100px');
		},
		"createdRow": function ( row, data, index ) {
		},
		"drawCallback": function( settings ) {
			$(".paginate_button > a").on("focus", function() {$(this).blur();});
		}
	})
	$("#subCategoriesTable tbody").on("click","tr.pointer",function(){
		$(this).toggleClass("selected");
		var scenario_subcats = [],
				scenario_id = $("#scenariosTable").find("tr.selected").attr("id");
		$("#subCategoriesTable tbody").find("tr.pointer.selected").each(function(i,v){
			scenario_subcats.push($(this).attr("id"));
		})
		app.action.update("scenario",scenario_id,"scenario_subcats",scenario_subcats,function(response){
			if ( response.result == "true" )
			{
				// showAlertMini('success',response.message);
			}
			else
			{
				showAlertMini('danger',response.message);
			}
		})
	})
})


</script>