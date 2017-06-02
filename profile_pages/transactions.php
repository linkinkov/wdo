<table class="table table-striped" id="transactions-table">
	<thead>
		<th>Дата</th>
		<th>Тип</th>
		<th>Описание</th>
	</thead>
	<tbody></tbody>
</table>

<script>
$(function(){
	var transactionsTable = $("#transactions-table").DataTable({
		"language": {"url": "/js/dataTables/dataTables.russian.lang"},
		"dom": 'tr<"row"<"col"p>><"row"<"col"i>>',
		"bProcessing": true,
		"bServerSide": true,
		"pagingType": "full_numbers",
		"ajax": {
			"url": "/dt/transactions",
			"type": "POST",
			"data": function( d ) {
			}
		},
		"bStateSave": false,
		"columns": [
			{"data": "timestamp"},
			{"data": "type"},
			{"data": "descr"},
		],
		"order": [[0, 'asc']],
		"initComplete": function(table,data) {
		},
		"createdRow": function ( row, data, index ) {
		},
		"drawCallback": function( settings ) {
			$(".paginate_button > a").on("focus", function() {
				$(this).blur();
			});
		}
	})
})
</script>