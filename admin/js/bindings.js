$(document).on("click","#menu-content .menu-entry", function(){
	var li = $(this),
			page = $(li).data('page');
	loadPage(page);

})


$(document).on("click","[data-trigger='send-message']", function(){
	var btn = this,
			dialog_id = $(this).data('dialog_id'),
			textarea = $("textarea[data-dialog_id='"+dialog_id+"']"),
			message_text = $(textarea).val();
	set_btn_state(btn,"loading");
	console.log("btn:",$(btn).attr("modal"));
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
			app.im.append_messages(response.messages);
			app.im.poller.check_msgs(dialog_id,5);
		}
	});
})