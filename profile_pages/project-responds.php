<?php
$_SESSION["LAST_PAGE"] = "profile/project-responds";
?>

<table class="table" id="project-responds-table">
	<thead>
		<th>Наименование</th>
		<th>Заказчик</th>
		<th>Бюджет</th>
		<th>Статус</th>
	</thead>
	<tbody>
	</tbody>
</table>

<script>
$(function(){
	var respondsTable = $("#project-responds-table").DataTable({
		"language": {"url": "/js/dataTables/dataTables.russian.lang"},
		"dom": 'tr<"row"<"col"p>><"row"<"col"i>>',
		"bProcessing": true,
		"bServerSide": true,
		"pagingType": "full_numbers",
		"ajax": {
			"url": "/dt/project-responds",
			"type": "POST",
			"data": function( d ) {
				d.for_profile = true;
				d.status_id = "-1";
			}
		},
		"columns": [
			{"data": "project.title","class":"project-table-title","width":"300px"},
			{"data": "project_user.user_id","name":"project.user_id","class":"project-table-user"},
			{"data": "respond.cost","name":"project_responds.cost","class":"project-table-cost"},
			{"data": "respond.status_id","name":"project_responds.status_id","class":"project-table-status"},
		],
		"initComplete": function(table,data) {
		},
		"createdRow": function ( row, data, index ) {
			var title = $.sprintf('<a class="wdo-link word-break" href="%s">%s</a>',data.project_link,data.project.title);
			var category = $.sprintf('<br /><small><text class="text-purple strong">%s</text> / <text title="Был опубликован">%s</text></small>',data.project.cat_name,moment.unix(data.project.created).fromNow());
			var username = '<div class="row"><div class="col" style="padding: 0;flex: 0 0 35px; max-width: 35px; min-width: 35px;"><a href="/profile/id'+data.project_user.user_id+'" class="wdo-link"><img class="rounded-circle shadow" src="'+data.project_user.avatar_path+'" /></a></div><div class="col"><a href="/profile/id'+data.project_user.user_id+'" class="wdo-link">'+data.project_user.real_user_name+'</a></div></div>';
			var cost = data.respond.cost + ' <i class="fa fa-rouble"></i>';
			$('td', row).eq(0).html(title+category);
			$('td', row).eq(1).html(username);
			$('td', row).eq(2).html(cost);
			$('td', row).eq(3).html('<img src="'+data.respond.image_path+'" title="'+data.respond.status_name+'" />');
		},
		"drawCallback": function( settings ) {
			$(".paginate_button > a").on("focus", function() {
				$(this).blur();
			});
		}
	})

	$(".loader").remove();
})
</script>