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
$_SESSION["LAST_PAGE"] = "profile/user-responds";
?>

<table class="table" id="responds-table">
	<thead>
		<th>Заказчик</th>
		<th>Проект</th>
		<th>Оценка</th>
	</thead>
	<tbody>
	</tbody>
</table>

<script>
$(function(){
	var respondsTable = $("#responds-table").DataTable({
		"language": {"url": "/js/dataTables/dataTables.russian.lang"},
		"dom": 'tr<"row"<"col"p>><"row"<"col"i>>',
		"bProcessing": true,
		"bServerSide": true,
		"pagingType": "full_numbers",
		"ajax": {
			"url": "/dt/user-responds",
			"type": "POST",
			"data": function( d ) {
				d.user_id = config.profile.user_id;
			}
		},
		"columns": [
			{"data": "author_user_name","width":"200px"},
			{"data": "project.url","name":"project_id"},
			{"data": "grade","width":"100px","class":"text-center align-middle"}
		],
		"order": [[0, 'asc']],
		"initComplete": function(table,data) {
		},
		"createdRow": function ( row, data, index ) {
			var grade_text = "балл",
					ico = "good";
			switch ( data.grade )
			{
				case 1: grade_text = "балл"; break;
				case 2: grade_text = "балла"; break;
				case 3: grade_text = "балла"; break;
				case 4: grade_text = "балла"; break;
				default: grade_text = "баллов"; break;
			}
			ico = ( data.grade >= 5 ) ? "good" : "bad";
			$('td', row).eq(0).html(''
				+'<div class="row">'
				+'	<div class="col" style="padding: 0;flex: 0 0 35px; max-width: 35px; min-width: 35px;">'
				+'		<a href="/profile/id'+data.project.user_id+'" class="wdo-link">'
				+'			<img class="rounded-circle shadow" src="/user.getAvatar?user_id='+data.project.user_id+'">'
				+'		</a>'
				+'	</div>'
				+'	<div class="col" style="align-self: center;">'
				+'		<a href="/profile/id'+data.project.user_id+'" class="wdo-link">'+data.author_user_name+'</a>'
				+'	</div>'
				+'</div>'
			);
			$('td', row).eq(0).css("padding-left","30px").css("vertical-align","middle");
			$('td', row).eq(1).css("vertical-align","middle").css("border-right","1px dotted #ccc");
			$('td', row).eq(2).html('<img src="/images/rating-'+ico+'-big.png" /><br /><h4 style="display: inline-block;">'+data.grade+'</h4> <small>'+grade_text+'</small>');

			var child = ''
			+'<tr class="bg-white row-bordered">'
			+'	<td colspan="3">'
			+'		<div style="position: relative;">'
			+'			<img style="position: absolute; top: -15px; left: 0px; background-color: #fff;" src="/images/arrow-down-transparent.png" />'
			+'			<h6 class="text-purple-dark" style="padding: 15px;">'+data.descr+'</h6>'
			+'		</div>'
			+'	</td>'
			+'</tr>'
			+'<tr style="height: 30px; background-color: #f3f1f1;"><td colspan="3"></td></tr>';
			setTimeout(function(){
				$(child).insertAfter(row);
			},100);
		},
		"drawCallback": function( settings ) {
			$(".timestamp").each(function(){
				$(this).html(moment.unix($(this).data('timestamp')).calendar()).removeClass("timestamp");
			})
			$(".paginate_button > a").on("focus", function() {
				$(this).blur();
			});
		}
	})

	// $(".loader").remove();
})
</script>