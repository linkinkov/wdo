$(document).on("click",".top-ten .wdo-link",function(){
	window.location = $(this).attr("href");
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
