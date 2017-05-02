$(document).on("click",".top-ten .wdo-link",function(){
	window.location = $(this).attr("href");
})

$(document).on("click",".subcategory",function(e){
	e.stopPropagation();
	e.preventDefault();
	var value = $(this).find("input[type='radio']").prop("checked");
	toggleSubCategory($(this).data("subcat_id"),!value);
	saveSelectedSpecs();
})
$(document).on("click",".custom-radio-cat",function(e){
	e.stopPropagation();
	e.preventDefault();
	var li = $(this).parent();
	if ( $(li).hasClass("category") )
	{
		var cat_id = $(li).data("cat_id");
		var radio = $(this).find("input[type='radio']");
		var value = $(radio).prop("checked");
		toggleCategory(cat_id,!value);
		saveSelectedSpecs();
	}
	else
	{
		var value = $(this).find("input[type='radio']").prop("checked");
		toggleSubCategory($(li).data("subcat_id"),!value);
		saveSelectedSpecs();
	}
})
$(document).on("click",".project-extra-filter",function(e){
	$(this).toggleClass("active");
	reloadProjectsTable();
})
$(document).on("click",".wdo-option",function(e){
	var menu = $(this).parent(),
			data = $(this).data();
	$(menu).find(".wdo-option").removeClass("active");
	$(this).addClass("active");
	$("button[data-name='"+data.name+"']").removeClass("warning").text($(this).text());
})

$(document).on("click",".dialog",function(){
	var dialog_id = $(this).data('dialog_id');
	$("#conversation-message-text").data('dialog_id',dialog_id).attr('data-dialog_id',dialog_id);
	$("#conversation-message-send").data('dialog_id',dialog_id).attr('data-dialog_id',dialog_id);
	$(".conversation-container").data('dialog_id',dialog_id).data('all_loaded',false);
	app.im.getMessages(dialog_id,0,config.profile.messages_per_page+4,0,0,function(response){
		if ( response.result == "true" )
		{
			$(".conversation-container").data('loaded',config.profile.messages_per_page);
			if ( response.messages.length > 0 )
			{
				app.im.lmts = response.messages[0].message.timestamp;
				setTimeout(function(){
					app.im.poller.start(dialog_id,response.wait);
				},3000);
			}
			$.each(response.messages,function(){
				$(".conversation-messages").prepend(app.im.format_message(this));
			})
			$(".dialogs-container").hide();
			$(".conversation-container").removeClass("loading").show();
			var d = $('#conversation-messages');
			setTimeout(function(){
				d.scrollTop(d.prop("scrollHeight"));
			},250);
		}
		else
		{
			showAlert("error",response.message);
		}
	})
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
			app.im.lmts = response.timestamp-1;
			$(textarea).val("");
		}
		if ( $(this).attr("modal") == "true" )
		{
			set_btn_state(btn,"reset",response.message);
		}
		else
		{
			set_btn_state(btn,"reset","Отправить");
			app.im.poller.start(dialog_id,5);
/*
			app.im.getMessages(dialog_id,0,0,response.timestamp,0,function(response){
				if ( response.result == "true" )
				{
					if ( response.messages.length > 0 )
					{
						app.im.append_messages(response.messages);
					}
				}
				else
				{
					showAlert("error",response.message);
				}
				set_btn_state(btn,"reset","Отправить");
			})
*/
		}
	});
})

$(document).on("click",".wdo-btn",function(e){
	if ( $(this).hasClass("disabled") ) return false;
})
$(document).on("click",".list-group-item,.custom-control-description-cat, .toggle-category",function(e){
	e.stopPropagation();
	e.preventDefault();
	if ( $(this).hasClass("category") )
	{
		slideCategory($(this).data('cat_id'));
		return;
	}
	var li = $(this).parent().parent();
	var data = $(li).data();
	if ( $(li).hasClass("subcategory") )
	{
		var value = $(li).find("input[type='radio']").prop("checked");
		toggleSubCategory($(li).data("subcat_id"),!value);
		saveSelectedSpecs();
		return;
	}
	else
	{
		slideCategory(data.cat_id);
		return;
	}
})