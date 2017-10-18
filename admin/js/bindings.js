$(document).on("click","#menu-content .menu-entry", function(){
	var li = $(this),
			page = $(li).data('page');
	loadPage(page);
	window.location.hash = page;
})

$(document).on("click","[data-trigger='send-message']", function(){
	var btn = this,
			dialog_id = $(this).data('dialog_id'),
			textarea = $("textarea[data-dialog_id='"+dialog_id+"']"),
			message_text = $(textarea).val();
	set_btn_state(btn,"loading");
	app.im.sendMessage(dialog_id,message_text,function(response){
		if ( response.result == "true" )
		{
			app.im.lmts = response.timestamp;
			$(textarea).val("");
		}
		if ( $(btn).attr("modal") == "true" )
		{
			set_btn_state(btn,"reset",response.message);
		}
		else
		{
			set_btn_state(btn,"reset","Отправить");
		}
	});
})

$(document).on("click","[data-trigger='send-warning']", function(){
	var btn = this,
			dialog_id = $(this).data('dialog_id'),
			textarea = $("textarea[data-dialog_id='"+dialog_id+"']"),
			message_text = $(textarea).val(),
			block_type = $(this).data('block_type'),
			recipient_id = $(this).data('recipient_id'),
			project_id = $(this).data('project_id'),
			modal = $(".modal.show");
	set_btn_state(btn,"loading");
	app.action.block(block_type,project_id,message_text,recipient_id,function(response){
		if ( response.result == "true" )
		{
			$(modal).find("textarea[name='warning-text']").attr("disabled","disabled");
			conf.projects.table.ajax.reload(false,false);
		}
		set_btn_state(btn,"reset",response.message);
	});
})

$(document).on("click","[data-trigger='add-category']", function(){
	var btn = this,
			modal = $(".modal.show"),
			value = $(modal).find("input[name='cat_name']").val();
	set_btn_state(btn,"loading");
	app.action.add.category(value,function(response){
		if ( response.result == "true" )
		{
			conf.categoriesTable.ajax.reload(false,false);
			$(".filter-group.category").find(".dropdown-menu").append('<button class="dropdown-item filter-item-category" type="button" data-filter="cat_id" data-value="'+response.cat_id+'">'+value+'</button>');
			$("#add-subcategory-modal").find("select[name='parent_cat_id']").append('<option value="'+response.cat_id+'">'+value+'</option>');
			showAlertMini('success',response.message);
		}
		else
		{
			showAlertMini('danger',response.message);
		}
		set_btn_state(btn,"reset",response.message);
	});
})

$(document).on("click","[data-trigger='add-subcategory']", function(){
	var btn = this,
			modal = $(".modal.show"),
			value = $(modal).find("input[name='cat_name']").val(),
			parent_cat_id = $(modal).find("select[name='parent_cat_id']").val();
	if ( parseInt(parent_cat_id) <= 0 || isNaN(parseInt(parent_cat_id)) ) return;
	set_btn_state(btn,"loading");
	app.action.add.subcategory(parent_cat_id,value,function(response){
		if ( response.result == "true" )
		{
			conf.subCategoriesTable.ajax.reload(false,false);
			showAlertMini('success',response.message);
		}
		else
		{
			showAlertMini('danger',response.message);
		}
		set_btn_state(btn,"reset",response.message);
	});
})

$(document).on("click","[data-trigger='add-scenario']", function(){
	var btn = this,
			modal = $(".modal.show"),
			value = $(modal).find("input[name='scenario_name']").val();
	set_btn_state(btn,"loading");
	app.action.add.scenario(value,function(response){
		if ( response.result == "true" )
		{
			conf.scenariosTable.ajax.reload(false,false);
			showAlertMini('success',response.message);
		}
		else
		{
			showAlertMini('danger',response.message);
		}
		set_btn_state(btn,"reset",response.message);
	});
})

$(document).on("click","[data-trigger='filter-subcategory']", function(){
	var data = $(this).data();
	$(".filter-item-category[data-filter='cat_id'][data-value='"+data.cat_id+"']").click();
	$("html, body").animate({ scrollTop: $('#subCategoriesTable').offset().top }, 500);
})


$(document).on("click",".filter-item-category", function(){
	var data = $(this).data();
	$(".filter-item-category[data-filter='"+data.filter+"']").removeClass("active");
	$(this).toggleClass("active");
	$(this).blur();
	$("#selected_subcat_name").html($(this).text());
	$("#add-subcategory-modal").find("select[name='parent_cat_id']").val(data.value);
	conf.subCategoriesTable.ajax.reload();
})

$(document).on("click","[data-trigger='filter-scenario']", function(){
	var scenario_id = $(this).data('scenario_id');
	$("#scenariosTable tbody").find("tr.selected").removeClass("selected");
	$(this).closest("tr").addClass("selected");
	conf.subCategoriesTable.ajax.reload();
})

$(document).on("click","[data-trigger='disable']", function(){
	var data = $(this).data();
	if ( data.type == "category" )
	{
		app.action.disable.category(data.id,function(response){
			if ( response.result == "true" )
			{
				conf.categoriesTable.ajax.reload(false,false);
				conf.subCategoriesTable.ajax.reload(false,false);
				showAlertMini('success',response.message);
			}
			else
			{
				showAlertMini('danger',response.message);
			}
		})
	}
	else if ( data.type == "subcategory" )
	{
		app.action.disable.subcategory(data.id,function(response){
			if ( response.result == "true" )
			{
				conf.categoriesTable.ajax.reload(false,false);
				conf.subCategoriesTable.ajax.reload(false,false);
				showAlertMini('success',response.message);
			}
			else
			{
				showAlertMini('danger',response.message);
			}
		})
	}
	else if ( data.type == "user" )
	{
		app.action.disable.user(data.id,function(response){
			if ( response.result == "true" )
			{
				conf.usersTable.ajax.reload(false,false);
				showAlertMini('success',response.message);
			}
			else
			{
				showAlertMini('danger',response.message);
			}
		})
	}
	else if ( data.type == "scenario" )
	{
		app.action.disable.scenario(data.id,function(response){
			if ( response.result == "true" )
			{
				conf.scenariosTable.ajax.reload(false,false);
				showAlertMini('success',response.message);
			}
			else
			{
				showAlertMini('danger',response.message);
			}
		})
	}
})

$(document).on("click","[data-trigger='enable']", function(){
	var data = $(this).data();
	if ( data.type == "category" )
	{
		app.action.enable.category(data.id,function(response){
			if ( response.result == "true" )
			{
				conf.categoriesTable.ajax.reload(false,false);
				conf.subCategoriesTable.ajax.reload(false,false);
				showAlertMini('success',response.message);
			}
			else
			{
				showAlertMini('danger',response.message);
			}
		})
	}
	else if ( data.type == "subcategory" )
	{
		app.action.enable.subcategory(data.id,function(response){
			if ( response.result == "true" )
			{
				conf.categoriesTable.ajax.reload(false,false);
				conf.subCategoriesTable.ajax.reload(false,false);
				showAlertMini('success',response.message);
			}
			else
			{
				showAlertMini('danger',response.message);
			}
		})
	}
	else if ( data.type == "user" )
	{
		app.action.enable.user(data.id,function(response){
			if ( response.result == "true" )
			{
				conf.usersTable.ajax.reload(false,false);
				showAlertMini('success',response.message);
			}
			else
			{
				showAlertMini('danger',response.message);
			}
		})
	}
	else if ( data.type == "scenario" )
	{
		app.action.enable.scenario(data.id,function(response){
			if ( response.result == "true" )
			{
				conf.scenariosTable.ajax.reload(false,false);
				showAlertMini('success',response.message);
			}
			else
			{
				showAlertMini('danger',response.message);
			}
		})
	}
})

$(document).on("click","[data-trigger='delete']", function(){
	var data = $(this).data();
	if ( data.type == "category" )
	{
		app.action.delete.category(data.id,function(response){
			if ( response.result == "true" )
			{
				$(".filter-item-category[data-filter='cat_id'][data-value='"+data.id+"']").remove();
				$("#add-subcategory-modal").find("option[value='"+data.id+"']").remove();
				conf.categoriesTable.ajax.reload();
				conf.subCategoriesTable.ajax.reload();
				showAlertMini('success',response.message);
			}
			else
			{
				showAlertMini('danger',response.message);
			}
		})
	}
	else if ( data.type == "subcategory" )
	{
		app.action.delete.subcategory(data.id,function(response){
			if ( response.result == "true" )
			{
				conf.categoriesTable.ajax.reload();
				conf.subCategoriesTable.ajax.reload();
				showAlertMini('success',response.message);
			}
			else
			{
				showAlertMini('danger',response.message);
			}
		})
	}
	else if ( data.type == "scenario" )
	{
		app.action.delete.scenario(data.id,function(response){
			if ( response.result == "true" )
			{
				conf.scenariosTable.ajax.reload();
				conf.subCategoriesTable.ajax.reload();
				showAlertMini('success',response.message);
			}
			else
			{
				showAlertMini('danger',response.message);
			}
		})
	}
})

$(document).on("click","[data-trigger='update']", function(){
	var data = $(this).data();
	console.log("click",data);
	app.action.update(data.type,data.id,data.name,data.value,function(response){
		if ( response.result == "true" )
		{
			if ( data.type == "user" )
			{
				conf.usersTable.ajax.reload();
			}
			if ( data.type == "project" )
			{
				conf.projects.table.ajax.reload(false,false);
			}
			showAlertMini('success',response.message);
		}
		else
		{
			showAlertMini('danger',response.message);
		}
	})
})


$(document).on("click","[data-trigger='save-link']", function(){
	var data = $(this).data();
	var input = $("#change-banner-link-modal").find("input[name='banner_link']");
	console.log(input.val());
	$.ajax({
		"url": "/admin/banners",
		"type": "POST",
		"dataType": "JSON",
		"data": {
			"job": "change_banner_link",
			"banner_id": data.id,
			"value": $(input).val()
		},
		"success": function(response){
			if ( response.result == "true" )
			{
				showAlertMini('success',response.message);
				$("#change-banner-link-modal").modal("hide");
				getBanners();
			}
			else
			{
				showAlertMini('danger',response.message);
			}
		}
	})
})


$(document).on("click","[data-trigger='save-setting']", function(){
	var data = $(this).data(),
			btn = $(this);
	var input = $("[data-setting='"+data.setting+"']");
	console.log(input.val());
	$(btn).button('loading');
	$.ajax({
		"url": "/admin/settings",
		"type": "POST",
		"dataType": "JSON",
		"data": {
			"job": "set_setting",
			"param_name": input.data('setting'),
			"param_value": $(input).val()
		},
		"success": function(response){
			if ( response.result == "true" )
			{
				showAlertMini('success',response.message);
				$(btn).button('reset');
			}
			else
			{
				showAlertMini('danger',response.message);
			}
		}
	})
})