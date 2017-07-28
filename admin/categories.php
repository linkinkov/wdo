<?php
require_once('../_global.php');
require_once('../_includes.php');
require(PD.'/admin/check_admin.php');

check_access($db,true);
$job = get_var("job","string",false);
if ( $job == "update" )
{
	$pk = get_var("pk","int",0);
	$name = get_var("name","string",0);
	$value = get_var("value","string",0);
	$type = get_var("type","string","cat");
	$entry = ( $type == "cat" ) ? new Category($pk) : new SubCategory($pk);
	$response = $entry->update($name,$value);
	exit(json_encode($response));
}
?>
<hr />
<div class="row">
	<div class="col">
		<h5>Категории</h5>
		<button class="btn btn-secondary btn-md" type="button" data-toggle="modal" data-target="#add-category-modal">
			<i class="fa fa-plus"></i> Добавить
		</button>
	</div>
</div>
<hr />
<table class="table table-hover" id="categoriesTable">
	<thead>
		<th width="50">Порядок</th>
		<th>Наименование</th>
		<th width="150">Подкатегорий</th>
		<th width="80">Проектов</th>
		<th width="80">Портфолио</th>
		<th width="150">Статус</th>
	</thead>
	<tbody>
	</tbody>
</table>

<hr />
<div class="row">
	<div class="col">
		<h5>Подкатегории</h5>
		<div class="btn-group">
			<div class="btn-group filter-group category">
				<button class="btn btn-secondary btn-md dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-filter="cat_id" data-counter="0">
					<i class="fa fa-folder-o"></i> Категория: <text class="text-purple-dark" id="selected_subcat_name">Все</text>
				</button>
				<div class="dropdown-menu" style="min-width: 200px;">
					<button class="dropdown-item filter-item-category active" data-filter="cat_id" data-value="0" type="button">Все</button>
					<div class="dropdown-divider"></div>
					<?php
					foreach ( Category::get_list(false,false,true) as $r )
					{
						echo sprintf('<button class="dropdown-item filter-item-category" type="button" data-filter="cat_id" data-value="%d">%s</button>',$r->id,$r->cat_name);
					}
					?>
				</div>
			</div>
			<button class="btn btn-secondary btn-md" type="button" data-toggle="modal" data-target="#add-subcategory-modal">
				<i class="fa fa-plus"></i> Добавить
			</button>
		</div>
	</div>
</div>
<hr />
<table class="table table-hover" id="subCategoriesTable">
	<thead>
		<th width="50">Порядок</th>
		<th>Наименование</th>
		<th width="80">Проектов</th>
		<th width="80">Портфолио</th>
		<th width="150">Статус</th>
	</thead>
	<tbody>
	</tbody>
</table>

<script>

$(function(){
	conf.categoriesTable = $("#categoriesTable").DataTable({
		"language": {"url": "/js/dataTables/dataTables.russian.lang"},
		"bProcessing": true,
		"bServerSide": true,
		"pagingType": "full_numbers",
		"ajax": {
			"url": "/admin/dt/categories",
			"type": "POST",
		},
		"bStateSave": true,
		"columns": [
			{"data": "sort"},
			{"data": "cat_name"},
			{"data": "subcats_counter"},
			{"data": "projects_counter"},
			{"data": "portfolio_counter"},
			{"data": "disabled"},
		],
		"order": [[0, 'desc']],
		"initComplete": function(table,data) {
			// $("#projects-table").find("th:eq(1)").css('min-width','100px');
		},
		"createdRow": function ( row, data, index ) {
			$('td', row).eq(0).html('<a href="#" class="editable" data-mode="popup" data-type="text" data-name="sort" data-url="/admin/categories.php?job=update&type=cat" data-pk="'+data.cat_id+'">'+data.sort+'</a>');
			$('td', row).eq(1).html('<a href="#" class="editable" data-mode="popup" data-type="text" data-name="cat_name" data-url="/admin/categories.php?job=update&type=cat" data-pk="'+data.cat_id+'">'+data.cat_name+'</a>');
			$('td', row).eq(2).html('<text class="text-purple">'+data.subcats_counter+'</text><small class="pull-right"><a href="#" class="wdo-link" data-trigger="filter-subcategory" data-cat_id="'+data.cat_id+'">Показать</a></small>');
			$('td', row).eq(3).html('<text class="text-purple">'+data.projects_counter+'</text>');
			$('td', row).eq(4).html('<text class="text-purple">'+data.portfolio_counter+'</text>');
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
				d.cat_id = $(".filter-item-category.active[data-filter='cat_id']").data('value');
				return d;
			}
		},
		"bStateSave": true,
		"columns": [
			{"data": "sort"},
			{"data": "subcat_name"},
			{"data": "projects_counter"},
			{"data": "portfolio_counter"},
			{"data": "disabled"},
		],
		"order": [[0, 'desc']],
		"initComplete": function(table,data) {
			// $("#projects-table").find("th:eq(1)").css('min-width','100px');
		},
		"createdRow": function ( row, data, index ) {
			$('td', row).eq(0).html('<a href="#" class="editable" data-mode="inline" data-type="text" data-name="sort" data-url="/admin/categories.php?job=update&type=subcat" data-pk="'+data.subcat_id+'">'+data.sort+'</a>');
			$('td', row).eq(1).html('<a href="#" class="editable" data-mode="inline" data-type="text" data-name="subcat_name" data-url="/admin/categories.php?job=update&type=subcat" data-pk="'+data.subcat_id+'">'+data.subcat_name+'</a>');
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
})


</script>