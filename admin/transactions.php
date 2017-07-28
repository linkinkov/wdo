<?php
require_once('../_global.php');
require_once('../_includes.php');
require(PD.'/admin/check_admin.php');

check_access($db,true);
$job = get_var("job","string",false);
?>
<div class="row">
	<div class="col">
		<h5>Транзакции</h5>
	</div>
</div>
<hr />
<div class="row">
	<div class="col">
		<div class="btn-group">

			<div class="btn-group filter-group">
				<button class="btn btn-secondary btn-md dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-filter="type" data-counter="0">
					Тип транзакции <text class="filter-counter"></text>
				</button>
				<div class="dropdown-menu" style="min-width: 200px;">
					<button class="dropdown-item" type="button" onClick="clear_filter('type');">
						<span class="pull-right"><i class="fa fa-times"></i></span>
						Сбросить фильтр
					</button>
					<div class="dropdown-divider"></div>
					<button class="dropdown-item filter-item" type="button" data-filter="type" data-value="PAYMENT">Зачисление</button>
					<button class="dropdown-item filter-item" type="button" data-filter="type" data-value="HOLD">Удержание</button>
					<button class="dropdown-item filter-item" type="button" data-filter="type" data-value="WITHDRAWAL">Списание</button>
				</div>
			</div>

		</div>
	</div>
</div>
<hr />
<table class="table table-hover" id="transactionsTable">
	<thead>
		<th>Пользователь</th>
		<th width="205">ID транзакции</th>
		<th width="205">Reference ID</th>
		<th width="205">Кошелёк</th>
		<th width="65">Тип</th>
		<th>Сумма</th>
		<th width="120">Дата</th>
		<th>Описание</th>
	</thead>
	<tbody>
	</tbody>
</table>

<script>
$(function(){
	conf.transactionsTable = $("#transactionsTable").DataTable({
		"language": {"url": "/js/dataTables/dataTables.russian.lang"},
		"bProcessing": true,
		"bServerSide": true,
		"pagingType": "full_numbers",
		"ajax": {
			"url": "/admin/dt/transactions",
			"type": "POST",
			"data": function( d ) {
				d.type = get_filter_selected('type');
			}
		},
		"bStateSave": true,
		"columns": [
			{"data": "real_user_name"},
			{"data": "transaction_id"},
			{"data": "reference_id"},
			{"data": "wallet_id"},
			{"data": "type_name"},
			{"data": "amount"},
			{"data": "timestamp","class":"timestamp"},
			{"data": "descr"},
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
		}
	})

	$(".filter-item").click(function(e){
		e.stopPropagation();
		var data = $(this).data();
		$(this).toggleClass("active");
		$(this).blur();
		conf.transactionsTable.ajax.reload();
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
	conf.transactionsTable.ajax.reload();
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