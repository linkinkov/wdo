$(document).on("click",".top-ten .wdo-link",function(){
	window.location = $(this).attr("href");
})
$(document).on("click",".dialog",function(){
	var dialog_id = $(this).data('dialog_id');
	$(".conversation-container").data('dialog_id',dialog_id).data('all_loaded',false);
	app.im.getMessages(dialog_id,0,config.profile.messages_per_page+4,function(response){
		var objDiv = $(".conversation-messages");
		if ( response.result == "true" )
		{
			$(".conversation-container").data('loaded',config.profile.messages_per_page).show();
			$.each(response.messages,function(){
				$(".conversation-messages").append(app.im.format_message(this));
			})
			$(".dialogs-container").hide();
			$(".conversation-container").removeClass("loading");
		}
		else
		{
			showAlert("error",response.message);
		}
		var d = $('#conversation-messages');
		setTimeout(function(){
			d.scrollTop(d.prop("scrollHeight"));
		},500);
	})
})
