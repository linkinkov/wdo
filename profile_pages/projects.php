<?php

if ( $user->user_id == $current_user->user_id )
{
	$ref = isset($_SESSION["LAST_PAGE"]) ? trim($_SESSION["LAST_PAGE"]) : false;
	if ( $ref == "profile/project-responds" )
	{
		$data["ts_project_responds"] = time();
		$current_user->update_profile_info($data);
	}
}
$_SESSION["LAST_PAGE"] = "profile/projects";
?>

<table class="table" id="projects-table">
	<thead>
		<th>Наименование</th>
		<th>Бюджет</th>
		<th>Заявки</th>
<?php
	if ( $current_user->user_id == $user->user_id )
		echo '<th>Исполнитель</th>';
?>
		<th>Статус</th>
	</thead>
	<tbody>
	</tbody>
</table>

<script>
$(function(){
	var projectsTable = $("#projects-table").DataTable({
		"language": {"url": "/js/dataTables/dataTables.russian.lang"},
		"dom": 'tr<"row"<"col"p>><"row"<"col"i>>',
		"bProcessing": true,
		"bServerSide": true,
		"pagingType": "full_numbers",
		"ajax": {
			"url": "/dt/projects",
			"type": "POST",
			"data": function( d ) {
				d.for_profile = true;
				d.user_id = config.profile.user_id;
				d.status_id = "-1";
			}
		},
		"columns": [
			{"data": "project.title","class":"project-table-title","width":"300px"},
			{"data": "project.cost","class":"project-table-cost"},
			{"data": "bids","class":"project-table-bids"},
	<?php
		if ( $current_user->user_id == $user->user_id )
		echo '{"data": "performer_name","class":"project-table-performer"},';
	?>
			{"data": "project.status_name","name":"status_id","class":"project-table-status text-center align-top"},
		],
		"order": [[0, 'asc']],
		"initComplete": function(table,data) {
		},
		"createdRow": function ( row, data, index ) {
			var scenario_icon = (data.project.for_event_id.length == 32 ) ? '<span style="font-size: 0.5rem;" class="fa-stack text-purple" title="Проект создан через мастер праздников">'
										+'<i class="fa fa-circle-o fa-stack-2x"></i>'
										+'<i class="fa fa-star fa-stack-1x"></i>'
										+'</span>' : '';
			var title = $.sprintf(scenario_icon+' <a class="wdo-link word-break" href="%s">%s</a>',data.project_link,data.project.title);
			var category = $.sprintf('<br /><small><text class="text-purple strong">%s</text> / <text title="Был опубликован">%s</text></small>',data.project.cat_name,moment.unix(data.project.created).fromNow());
			var cost = data.project.cost + ' <i class="fa fa-rouble"></i>';
			if ( data.performer_id ) $('td', row).eq(3).html('<a class="wdo-link" href="/profile/id'+data.performer_id+'">'+data.performer_name+'</a>');
			$('td', row).eq(0).html(title+category);
			$('td', row).eq(1).html(cost);
			var extra_title = [];
			if ( data.project.safe_deal == 1 )
			{
				$('td', row).eq(4).addClass('safe-deal');
				extra_title.push("Безопасная сделка");
			}
			if ( data.project.vip == 1 )
			{
				$('td', row).eq(4).attr("title","VIP проект").addClass('vip');
				extra_title.push("VIP проект");
			}
			$('td', row).eq(4).attr("title",extra_title.join("; "));
			if ( extra_title.length == 0 ) $('td', row).eq(4).removeClass('align-top');
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