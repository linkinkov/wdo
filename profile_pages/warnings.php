<table class="table table-striped table-hover" id="warnings-table">
	<thead>
		<th>Дата</th>
		<th>Сообщение</th>
	</thead>
	<tbody></tbody>
</table>

<script>
$(function(){
	var warningsTable = $("#warnings-table").DataTable({
		"language": {"url": "/js/dataTables/dataTables.russian.lang"},
		"dom": 'tr<"row"<"col"p>><"row"<"col"i>>',
		"bProcessing": true,
		"bServerSide": true,
		"pagingType": "full_numbers",
		"ajax": {
			"url": "/dt/warnings",
			"type": "POST",
			"data": function( d ) {
			}
		},
		"bStateSave": false,
		"columns": [
			{"data": "timestamp","class": "timestamp"},
			{"data": "message"},
		],
		"order": [[0, 'desc']],
		"initComplete": function(table,data) {
		},
		"createdRow": function ( row, data, index ) {
			$(".timestamp", row).html(moment.unix(data.timestamp).format("LLL")).attr("title",moment.unix(data.timestamp).format("YYYY-MM-DD H:m:s"));
			$(row).on("click",function(){
				var tr = $(this).closest('tr');
				var row = warningsTable.row( tr );
				console.log(row.data());
				if ( row.child.isShown() )
				{
					row.child.hide();
					tr.removeClass('shown');
				}
				else
				{
					row.child( app.formatter.format_warning_info(row.data()) ).show();
					tr.addClass('shown');
				}
			});
		},
		"drawCallback": function( settings ) {
			$(".paginate_button > a").on("focus", function() {
				$(this).blur();
			});
		}
	})
})
</script>