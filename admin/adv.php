<?php
require_once('../_global.php');
require_once('../_includes.php');
require(PD.'/admin/check_admin.php');

check_access($db,true);
$job = get_var("job","string",false);
?>
<div class="row">
	<div class="col">
		<h5>Реклама</h5>
	</div>
</div>
<hr />
<div class="row">
	<div class="col">
		<div class="btn-group">

			<div class="btn-group filter-group">
				<button class="btn btn-secondary btn-md dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-filter="status_id" data-counter="0">
					Статус <text class="filter-counter"></text>
				</button>
				<div class="dropdown-menu" style="min-width: 200px;">
					<button class="dropdown-item" type="button" onClick="clear_filter('status_id');">
						<span class="pull-right"><i class="fa fa-times"></i></span>
						Сбросить фильтр
					</button>
					<div class="dropdown-divider"></div>
					<button class="dropdown-item filter-item" type="button" data-filter="status_id" data-value="1">Активные</button>
					<button class="dropdown-item filter-item" type="button" data-filter="status_id" data-value="2">На модерации</button>
					<button class="dropdown-item filter-item" type="button" data-filter="status_id" data-value="3">Черновики</button>
					<button class="dropdown-item filter-item" type="button" data-filter="status_id" data-value="4">Архив</button>
					<button class="dropdown-item filter-item" type="button" data-filter="status_id" data-value="5">Отклоненные</button>
					<a class="dropdown-item pointer hidden" data-trigger="change_status_id" data-value="1" style="width: auto;">Принять</a>
				</div>
			</div>
		</div>
	</div>
</div>
<hr />
<table class="table table-hover" id="advTable">
	<thead>
		<th>Пользователь</th>
		<th>ID</th>
		<th>Заголовок</th>
		<th>Описание</th>
		<th>Лимит</th>
		<th>Дни</th>
		<th>Создано</th>
		<th>Изменено</th>
		<th>Поднято</th>
		<th>Одобрено</th>
		<th>Статус</th>
		<th>#</th>
	</thead>
	<tbody>
	</tbody>
</table>

<script>
$(function(){
	conf.advTable = $("#advTable").DataTable({
		"language": {"url": "/js/dataTables/dataTables.russian.lang"},
		"bProcessing": true,
		"bServerSide": true,
		"pagingType": "full_numbers",
		"ajax": {
			"url": "/admin/dt/adv",
			"type": "POST",
			"data": function( d ) {
				d.status_id = get_filter_selected('status_id');
			}
		},
		"bStateSave": true,
		"columns": [
			{"data": "real_user_name"},
			{"data": "adv_id"},
			{"data": "title"},
			{"data": "descr"},
			{"data": "prolong_limit"},
			{"data": "prolong_days"},
			{"data": "created","class":"timestamp"},
			{"data": "modified","class":"timestamp"},
			{"data": "last_prolong","class":"timestamp"},
			{"data": "accepted","class":"timestamp"},
			{"data": "status_name"},
			{"data": "actions","orderable": "false", "name": "status_idy"},
		],
		"order": [[0, 'desc']],
		"initComplete": function(table,data) {
			// $("#projects-table").find("th:eq(1)").css('min-width','100px');
		},
		"createdRow": function ( row, data, index ) {
			$(row).find(".timestamp").each(function(i,v){
				$(v).html(moment.unix($(v).text()).format("LLL"));
			});
		},
		"drawCallback": function( settings ) {
			$(".paginate_button > a").on("focus", function() {$(this).blur();});
			$("[data-trigger='change_adv_status']").click(function(){
				var adv_id = $(this).closest("tr").attr("id"),
						status_id = $(this).data("value");
				app.action.change_adv_status(adv_id,status_id,function(response){
					if ( response.result == "true" )
					{
						showAlertMini("success",response.message);
						conf.advTable.ajax.reload();
					}
					else
					{
						showAlertMini("danger",response.message);
					}
				});
			})
		}
	})

	$(".filter-item").click(function(e){
		e.stopPropagation();
		var data = $(this).data();
		$(this).toggleClass("active");
		$(this).blur();
		conf.advTable.ajax.reload();
	})

})

function highlight_filter_group()
{
	$.each($(".filter-group"),function(){
		var $group = $(this),
				$dropdown_btn = $group.find(".dropdown-toggle"),
				$dropdown_menu = $group.find(".dropdown-menu"),
				active_filters = $dropdown_menu.find(".filter-item.active");
		( active_filters.length > 0 ) ? $dropdown_btn.addClass("active text-purple") : $dropdown_btn.removeClass("active text-purple");
	})
}
function clear_filter(filter_type)
{
	$(".filter-item[data-filter='"+filter_type+"']").removeClass("active");
	conf.advTable.ajax.reload();
}
function get_filter_selected(filter_type)
{
	var arr = [];
	$.each($(".filter-item.active[data-filter='"+filter_type+"']"), function(i,v){
		arr.push($(v).data('value'));
	})
	highlight_filter_group();
	return arr.join(',');
}

</script>