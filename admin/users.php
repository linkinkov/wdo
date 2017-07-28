<?php
require_once('../_global.php');
require_once('../_includes.php');
require(PD.'/admin/check_admin.php');

check_access($db,true);
$job = get_var("job","string",false);
?>
<div class="row">
	<div class="col">
		<h5>Пользователи</h5>
	</div>
</div>
<hr />
<div class="row">
	<div class="col">
		<div class="btn-group">

			<div class="btn-group filter-group">
				<button class="btn btn-secondary btn-md dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-filter="city_id" data-counter="0">
					Город <text class="filter-counter"></text>
				</button>
				<div class="dropdown-menu" style="min-width: 200px;">
					<button class="dropdown-item" type="button" onClick="clear_filter('city_id');">
						<span class="pull-right"><i class="fa fa-times"></i></span>
						Сбросить фильтр
					</button>
					<div class="dropdown-divider"></div>
					<?php
					foreach ( City::get_list() as $r )
					{
						echo sprintf('<button class="dropdown-item filter-item" type="button" data-filter="city_id" data-value="%d">%s</button>',$r->id,$r->city_name);
					}
					?>
				</div>
			</div>

			<div class="btn-group filter-group">
				<button class="btn btn-secondary btn-md dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-filter="type_id" data-counter="0">
					Тип <text class="filter-counter"></text>
				</button>
				<div class="dropdown-menu" style="min-width: 200px;">
					<button class="dropdown-item" type="button" onClick="clear_filter('type_id');">
						<span class="pull-right"><i class="fa fa-times"></i></span>
						Сбросить фильтр
					</button>
					<div class="dropdown-divider"></div>
					<button class="dropdown-item filter-item" type="button" data-filter="type_id" data-value="1">Юридическое лицо</button>
					<button class="dropdown-item filter-item" type="button" data-filter="type_id" data-value="2">Физическое лицо</button>
				</div>
			</div>

			<div class="btn-group filter-group">
				<button class="btn btn-secondary btn-md dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-filter="as_performer" data-counter="0">
					Вид <text class="filter-counter"></text>
				</button>
				<div class="dropdown-menu" style="min-width: 200px;">
					<button class="dropdown-item" type="button" onClick="clear_filter('as_performer');">
						<span class="pull-right"><i class="fa fa-times"></i></span>
						Сбросить фильтр
					</button>
					<div class="dropdown-divider"></div>
					<button class="dropdown-item filter-item" type="button" data-filter="as_performer" data-value="0">Заказчик</button>
					<button class="dropdown-item filter-item" type="button" data-filter="as_performer" data-value="1">Исполнитель</button>
				</div>
			</div>

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
					<?php
					foreach ( $db->queryRows("SELECT * FROM `user_statuses`") as $s )
					{
						echo sprintf('<button class="dropdown-item filter-item" type="button" data-filter="status_id" data-value="%d">%s</button>',$s->status_id,$s->status_name);
					}
					?>
				</div>
			</div>

			<div class="btn-group filter-group">
				<button class="btn btn-secondary btn-md dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-filter="template_id" data-counter="0">
					Доступ <text class="filter-counter"></text>
				</button>
				<div class="dropdown-menu" style="min-width: 200px;">
					<button class="dropdown-item" type="button" onClick="clear_filter('template_id');">
						<span class="pull-right"><i class="fa fa-times"></i></span>
						Сбросить фильтр
					</button>
					<div class="dropdown-divider"></div>
					<button class="dropdown-item filter-item" type="button" data-filter="template_id" data-value="1">Пользователь</button>
					<button class="dropdown-item filter-item" type="button" data-filter="template_id" data-value="2">Администратор</button>
				</div>
			</div>

		</div>
	</div>
</div>
<hr />
<table class="table table-hover" id="usersTable">
	<thead>
		<th width="50">ID</th>
		<th>Логин</th>
		<th>Имя</th>
		<th>Город</th>
		<th>Зарегистрирован</th>
		<th>Вход</th>
		<th>Тип</th>
		<th width="120">Вид</th>
		<th width="120">Статус</th>
		<th title="Рейтинг"><i class="fa fa-star-half-o"></i></th>
		<th title="Проектов"><i class="fa fa-tag"></i></th>
		<th title="Заявок"><i class="fa fa-tags"></i></th>
		<th title="Отзывов"><i class="fa fa-comments-o"></i></th>
		<th title="Нарушений"><i class="fa fa-warning"></i></th>
		<th title="Баланс"><i class="fa fa-credit-card"></i></th>
	</thead>
	<tbody>
	</tbody>
</table>

<script>
$(function(){
	conf.usersTable = $("#usersTable").DataTable({
		"language": {"url": "/js/dataTables/dataTables.russian.lang"},
		"bProcessing": true,
		"bServerSide": true,
		"pagingType": "full_numbers",
		"ajax": {
			"url": "/admin/dt/users",
			"type": "POST",
			"data": function( d ) {
				d.city_id = get_filter_selected('city_id');
				d.status_id = get_filter_selected('status_id');
				d.type_id = get_filter_selected('type_id');
				d.as_performer = get_filter_selected('as_performer');
				d.template_id = get_filter_selected('template_id');
			}
		},
		"bStateSave": true,
		"columns": [
			{"data": "user_id"},
			{"data": "username"},
			{"data": "real_user_name"},
			{"data": "city_name"},
			{"data": "registered","class":"timestamp"},
			{"data": "last_login","class":"timestamp"},
			{"data": "type_name"},
			{"data": "performer"},
			{"data": "status_name"},
			{"data": "rating"},
			{"data": "projects_counter"},
			{"data": "responds_counter"},
			{"data": "user_responds_counter"},
			{"data": "warnings_counter"},
			{"data": "balance"},
		],
		"order": [[0, 'desc']],
		"initComplete": function(table,data) {
			// $("#projects-table").find("th:eq(1)").css('min-width','100px');
		},
		"createdRow": function ( row, data, index ) {
			$(row).find(".timestamp").each(function(i,v){
				$(v).html(moment.unix($(v).text()).format("LLL"));
			});
			$('td', row).eq(1).html('<a href="/profile/id'+data.user_id+'" target="_BLANK">'+data.username+'</a>');
			if ( data.status_id == 1 )
			{
				$('td', row).eq(8).append('<span class="pull-right"><a href="#" data-trigger="disable" data-type="user" data-id="'+data.user_id+'" title="Заблокировать"><i class="fa fa-lock"></i></a></span>');
			}
			else if ( data.status_id == 3 )
			{
				$('td', row).eq(8).append('<span class="pull-right"><a href="#" data-trigger="enable" data-type="user" data-id="'+data.user_id+'" title="Разблокировать"><i class="fa fa-unlock-alt"></i></a></span>');
			}
			if ( data.template_id == 2 )
			{
				$('td', row).eq(7).append('<span class="pull-right"><a href="#" data-trigger="update" data-type="user" data-name="template_id" data-value="1" data-id="'+data.user_id+'" title="Сделать пользователем"><i class="fa fa-user-secret"></i></a></span>');
			}
			else if ( data.template_id == 1 )
			{
				$('td', row).eq(7).append('<span class="pull-right"><a href="#" class="text-muted" data-trigger="update" data-type="user" data-name="template_id" data-value="2" data-id="'+data.user_id+'" title="Сделать администратором"><i class="fa fa-user"></i></a></span>');
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

	$(".filter-item").click(function(e){
		e.stopPropagation();
		var data = $(this).data();
		$(this).toggleClass("active");
		$(this).blur();
		conf.usersTable.ajax.reload();
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
	conf.usersTable.ajax.reload();
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