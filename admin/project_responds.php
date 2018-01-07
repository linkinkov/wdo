<?php
require_once('../_global.php');
require_once('../_includes.php');
require(PD.'/admin/check_admin.php');

check_access($db,true);
?>
<div class="row">
	<div class="col">
		<h5>Заявки исполнителей</h5>
	</div>
</div>
<hr />
<div class="row">
	<div class="col">
		<div class="btn-group">

			<div class="btn-group filter-group">
				<button class="btn btn-secondary btn-md dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-filter="city_id" data-counter="0">
					<i class="fa fa-map-marker"></i> Город <text class="filter-counter"></text>
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
				<button class="btn btn-secondary btn-md dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-filter="category_id" data-filter2="subcategory_id" data-counter="0">
					<i class="fa fa-group"></i> Категории <text class="filter-counter"></text>
				</button>
				<div class="dropdown-menu" style="min-width: 200px;">
					<button class="dropdown-item" type="button" onClick="clear_filter('category_id');clear_filter('subcategory_id');">
						<span class="pull-right"><i class="fa fa-times"></i></span>
						Сбросить фильтр
					</button>
					<?php
					foreach ( Category::get_list() as $c )
					{
						echo '<div class="dropdown-divider"></div>';
						echo sprintf('<button class="dropdown-item filter-item" type="button" data-filter="category_id" data-value="%d">%s</button>',$c->id,$c->cat_name);
						echo '<div class="dropdown-divider"></div>';
						foreach ( Subcategory::get_list($c->id) as $sc )
						{
							echo sprintf('<button class="dropdown-item filter-item" type="button" data-filter="subcategory_id" data-value="%d" data-parent_id="%d"><span class="pull-right">%s</span></button>',$sc->id,$sc->parent_cat_id,$sc->subcat_name);
						}
					}
					?>
				</div>
			</div>

			<div class="btn-group filter-group">
				<button class="btn btn-secondary btn-md dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-filter="status_id" data-counter="0">
					<i class="fa fa-flag-checkered"></i> Статус <text class="filter-counter"></text>
				</button>
				<div class="dropdown-menu" style="min-width: 200px;">
					<button class="dropdown-item" type="button" onClick="clear_filter('status_id');">
						<span class="pull-right"><i class="fa fa-times"></i></span>
						Сбросить фильтр
					</button>
					<div class="dropdown-divider"></div>
					<?php
					foreach ( $db->queryRows("SELECT * FROM `project_responds_statuses`") as $s )
					{
						echo sprintf('<button class="dropdown-item filter-item" type="button" data-filter="status_id" data-value="%d">%s</button>',$s->id,$s->status_name);
					}
					?>
				</div>
			</div>

<!-- 
			<div class="btn-group filter-group">
				<button class="btn btn-secondary btn-md dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-filter="safe_deal" data-filter2="vip" data-counter="0">
					<i class="fa fa-shield"></i> Опции <text class="filter-counter"></text>
				</button>
				<div class="dropdown-menu" style="min-width: 200px;">
					<button class="dropdown-item" type="button" onClick="clear_filter('safe_deal');clear_filter('vip');">
						<span class="pull-right"><i class="fa fa-times"></i></span>
						Сбросить фильтр
					</button>
					<div class="dropdown-divider"></div>
					<button class="dropdown-item filter-item" type="button" data-filter="safe_deal" data-value="1">Безопасная сделка</button>
					<button class="dropdown-item filter-item" type="button" data-filter="vip" data-value="1">VIP проект</button>
				</div>
			</div>
 -->
		</div>
	</div>
</div>
<hr />
<table class="table table-hover" id="projectRespondsTable">
	<thead>
		<th>Проект</th>
		<th>Категория</th>
		<th>Подкатегория</th>
		<th>Город</th>
		<th>Пользователь</th>
		<th>Создан</th>
		<th>Стоимость</th>
		<th>Статус</th>
	</thead>
	<tbody>
	</tbody>
</table>


<script>
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
	conf.project_responds.table.ajax.reload();
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
function get_respond_attaches(respond_id)
{
	app.respond.getAttachList(respond_id,function(response){
		if ( response.length > 0 )
		{
			var att_p = 0,
					att_v = 0,
					att_d = 0;
			$.each(response,function(){
				var object = app.formatter.format_portfolio_attach(this);
				if ( this.attach_type == 'image' )
				{
					$("#respond-photos"+respond_id).append(object);
					att_p++;
				}
				else if ( this.attach_type == 'video' )
				{
					$("#respond-videos"+respond_id).append(object);
					att_v++;
				}
				else if ( this.attach_type == 'document' )
				{
					$("#respond-docs"+respond_id).append(object);
					att_d++;
				}
			});
			if ( att_p > 0 ) $(".respond-photos-container").show();
			if ( att_v > 0 ) $(".respond-videos-container").show();
			if ( att_d > 0 ) $(".respond-docs-container").show();
		}
	})
	$(".gallery"+respond_id).click(function (event) {
		event = event || window.event;
		var target = event.target || event.srcElement,
				link = target.src ? target.parentNode : target,
				options = {index: link, event: event,
					onopen: function(){
						$(".portfolio-image-action").hide();
					}
				},
				links = $(this).find("a").not(".download");
		blueimp.Gallery(links, options);
	});

}
$(function(){
	try {
		conf.project_responds.filter = JSON.parse(getCookie("conf.project_responds.filter"));
		// console.log("got conf.project_responds.filter:",conf.project_responds.filter);
		$.each(conf.project_responds.filter,function(filter_type,value){
			var values = value.split(",");
			if ( values.length > 1 )
			{
				$.each(values,function(i,v){
					$(".filter-item[data-filter='"+filter_type+"'][data-value='"+v+"']").addClass("active");
				})
			}
			else
			{
				$(".filter-item[data-filter='"+filter_type+"'][data-value='"+value+"']").addClass("active");
			}
		})
	} catch (error) {
		// console.log("error fetching filter",error);
	}
	conf.project_responds.table = $("#projectRespondsTable").DataTable({
		"language": {"url": "/js/dataTables/dataTables.russian.lang"},
		"bProcessing": true,
		"bServerSide": true,
		"pagingType": "full_numbers",
		"ajax": {
			"url": "/admin/dt/project_responds",
			"type": "POST",
			"data": function( d ) {
				d.selected_subcategory = get_filter_selected('subcategory_id');
				d.selected_city = get_filter_selected('city_id');
				d.selected_status = get_filter_selected('status_id');
			}
		},
		"bStateSave": true,
		"columns": [
			{"data": "title"},
			{"data": "cat_name"},
			{"data": "subcat_name"},
			{"data": "city_name"},
			{"data": "real_user_name"},
			{"data": "created", "class":"timestamp-lll"},
			{"data": "cost"},
			{"data": "status_name"},
		],
		"order": [[5, 'desc']],
		"initComplete": function(table,data) {
			// $("#projects-table").find("th:eq(1)").css('min-width','100px');
		},
		"createdRow": function ( row, data, index ) {
			$('td', row).eq(0).html('<a class="wdo-link underline word-break" href="'+data.project_link+'" target="_blank">'+data.title+'</a>');
			$('td', row).eq(4).html('<a class="wdo-link underline word-break" href="/profile/id'+data.user_id+'" target="_blank">'+data.real_user_name+'</a>');
			$('td', row).eq(5).html(moment.unix($('td', row).eq(5).text()).format("LLL"));
		},
		"drawCallback": function( settings ) {
			$(".paginate_button > a").on("focus", function() {
				$(this).blur();
			});
		}
	})

	$('#projectRespondsTable tbody').on('click', 'tr.respond', function () {
		var tr = $(this).closest('tr'),
				row = conf.project_responds.table.row( tr ),
				respond_id = $(tr).attr("id");
		if ( row.child.isShown() ) 
		{
			childRow = $(tr).next();
			$(childRow).find(".editable").each(function(i,v){
				$(v).editable('destroy');
			})
			$('div.slider', row.child()).slideUp("fast", function () {
				row.child.hide();
				tr.removeClass('shown');
				// icon.attr("class","fa fa-plus-square pointer");
			});
			return;
		}
		tr.addClass("childLoading");

		$.ajax({
			type: "POST",
			url: "/admin/dt/respondInfo",
			data: {
				"respond_id": respond_id
			},
			xhrFields: {withCredentials: true},
			dataType: "HTML",
			timeout: 10000,
			error: function(x, t, m) {
				if(t==="timeout") {showAlert('danger','timeout');}
			},
			success: function (response) {
				// icon.attr("class","fa fa-minus-square pointer");
				row.child(response).show();
				get_respond_attaches(respond_id);

				// tr.addClass("shown");
				// tr.removeClass("childLoading");
			}
		}).done(function(){
			childRow = $(tr).next();
			$(childRow).addClass("nohover");
			$(childRow).find("td").addClass("shown");
			tr.addClass("shown");
			tr.removeClass("childLoading");
			$('div.slider', row.child()).slideDown("fast");
			$(childRow).find(".timestamp").each(function(){
				var ts = $(this);
				( $(ts).data('format') == "fromNow" )
				? $(ts).html(moment.unix($(ts).data('timestamp')).fromNow(true)).attr("title",moment.unix($(ts).data('timestamp')).format("LLL"))
				: $(ts).html(moment.unix($(ts).data('timestamp')).calendar()).attr("title",moment.unix($(ts).data('timestamp')).format("LLL"));
			})
		})

	})


	$(".filter-item").click(function(e){
		e.stopPropagation();
		var data = $(this).data();
		$(this).toggleClass("active");
		$(this).blur();
		if ( data.filter == "category_id" )
		{
			if ( $(this).hasClass("active") )
			{
				$(".filter-item[data-filter='subcategory_id'][data-parent_id='"+data.value+"']").addClass("active");
			}
			else
			{
				$(".filter-item[data-filter='subcategory_id'][data-parent_id='"+data.value+"']").removeClass("active");
			}
		}
		conf.project_responds.table.ajax.reload();
		
		conf.project_responds.filter = {
			"subcategory_id": get_filter_selected('subcategory_id'),
			"city_id": get_filter_selected('city_id'),
			"status_id": get_filter_selected('status_id'),
		}
		setCookie("conf.project_responds.filter",JSON.stringify(conf.project_responds.filter));
	})
})
</script>