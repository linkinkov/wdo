<?php
$_SESSION["LAST_PAGE"] = "profile/messages";
?>
<div class="wdo-scrollbar dialogs-container scrollable"></div>

<div class="conversation-container">
	<div class="wdo-scrollbar conversation-messages scrollable" id="conversation-messages"></div>
	<div class="conversation-footer">
		<div class="row"><div class="col">
			<textarea class="form-control" id="conversation-message-text" placeholder="Текст сообщения" rows="1"></textarea>
		</div></div>
		<br />
		<div class="row"><div class="col">
			<div class="wdo-btn btn-sm bg-purple pull-right" data-trigger="send-message" id="conversation-message-send" data-ot="Отправить" data-lt="Отправка">Отправить</div>
		</div></div>
	</div>
</div>

<script>
$(function(){
	$( '.scrollable' ).on( 'mousewheel DOMMouseScroll', function ( e ) {
		if ( $(this).hasClass("loading") )
		{
			e.preventDefault();
			e.stopPropagation();
			return false;
		}
		var e0 = e.originalEvent,
				delta = e0.wheelDelta || -e0.detail;
		this.scrollTop += ( delta < 0 ? 1 : -1 ) * 30;
		e.preventDefault();
	});

	app.im.getDialogs(function(response){
		if ( response.result == "true" )
		{
			$(".dialogs-container").html('');
			$.each(response.dialogs,function(){
				$(".dialogs-container").append(app.formatter.format_dialog(this));
			})
		}
	})
	var last_scroll = 0;
	$(".conversation-messages").scroll(_.debounce(function(){}, 150, { 'leading': true, 'trailing': false }));
	$(".conversation-messages").scroll(_.debounce(function(){
		var scrollTop = $(this).scrollTop(),
				topDistance = $(this).offset().top,
				dialog_id = $(".conversation-container").data('dialog_id'),
				container = this;
		if ( $(container).hasClass("loading") ) return;

		if ( scrollTop < 160 )
		{
			if ( $(".conversation-container").data('all_loaded') == true ) return;
			$(container).addClass("loading");
			var start = $(".conversation-container").data('loaded');
			last_scroll = scrollTop;
			app.im.getMessages(dialog_id,start,config.profile.messages_per_page,0,0,function(response){
				if ( response.result == "true" )
				{
					var now_loaded = $(".conversation-container").data('loaded')+config.profile.messages_per_page;
					$.each(response.messages,function(){
						$(".conversation-messages").prepend(app.formatter.format_message(this));
					})
					$(".conversation-container").data('loaded',now_loaded);
					$(".conversation-messages").scrollTop(last_scroll+response.messages.length*70);
				}
				else
				{
					$(".conversation-container").data('all_loaded',true);
				}
				setTimeout(function(){
					$(container).removeClass("loading");
				},250)
			})
		}
	}, 150));
	autosize($("#conversation-message-text"));
})
</script>