function loadPage(page,params,container)
{
	page = page.replace("#","");
	if ( page == "main" )
	{
		window.location.href = "/";
		return;
	}
	container = container || ".app-content";
	params = params;
	$(".app-loader").show();
	$(".menu-entry").removeClass("active");
	$.ajax({
		type: "POST",
		url: page,
		cache: false,
		xhrFields: {
			withCredentials: true
		},
		data: params,
		dataType: "html",
		timeout: 30000,
		error: function(x, t, m) {
			if(t==="timeout") {showAlert('danger','timeout');}
		},
		success: function (response) {
			$(".app-loader").hide();
			$(container).html(response);
			app.currentPage = page;
		},
		error: function(XMLHttpRequest, textStatus, errorThrown)
		{
			$(".app-loader").hide();
			switch ( XMLHttpRequest.status )
			{
				case 200: $(container).html(XMLHttpRequest.responseText);
					break;
				case 401:
					window.location.href = "/";
					break;
				case 404: $(container).html(XMLHttpRequest.responseText);
					break;
				default: $(container).html(XMLHttpRequest.responseText);
					break;
			}
		}
	}).done(function(){
		var li = $(".menu-entry[data-page='#"+page+"']");
		$(li).addClass("active");
		$(document).attr("title", ' WAdmin | ' + $(li).text());
	})
}
function showAlert(type,message)
{
	var modal = $("#alert-modal");
	$("#alert-modal-message").html(message);
	$(modal).modal('show');
}

function showAlertMini(type,message,title,timeout)
{
	title = (title) ? '<strong>'+title+'</strong><br />' : '';
	timeout = timeout || 3000;
	message = message || "?";
	var alert_id = Math.random().toString(36).substring(7);
	var html = ''
	+'<div class="alert alert-'+type+' alert-dismissible fade in" role="alert" id="'+alert_id+'">'
  +'<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
	+'	<span aria-hidden="true">&times;</span>'
	+'</button>'
	+'	'+title+''+message
	+'</div>';
	$(".alert-container").append(html);
	setTimeout(function(){
		$("#"+alert_id).fadeOut("normal", function() {
			$(this).remove();
		});
	},timeout);
}

function set_btn_state(btn,state,message)
{
	state = state || false;
	message = message || false;
	if ( !state ) return;
	if ( state == "loading" )
	{
		message = ( message != false ) ? message : $(btn).data('lt');
		$(btn).addClass("disabled").html('<i class="fa fa-spinner fa-spin"></i> '+message);
	}
	else if ( state == "reset" )
	{
		message = ( message != false ) ? message : $(btn).data('ot');
		$(btn).removeClass("disabled").html(message);
	}
}

$(document).on("click",".wdo-btn",function(e){
	if ( $(this).hasClass("disabled") ) return false;
})

$('#warn-user-modal').on('show.bs.modal', function(e){
	var related = e.relatedTarget,
			recipient_id = $(related).data('recipient_id'),
			real_user_name = $(related).data('real_user_name'),
			block_type = $(related).data('block_type'),
			project_id = $(related).data('project_id'),
			respond_id = $(related).data('respond_id'),
			modal = e.delegateTarget,
			submit_btn = $(modal).find("[data-trigger='send-warning']");
	app.im.getDialogId(recipient_id,function(response){
		if ( response.result == "true" )
		{
			$(submit_btn).data('dialog_id',response.dialog_id).attr('dialog_id',response.dialog_id).data('block_type',block_type);
			$(submit_btn).data('recipient_id',recipient_id).attr('recipient_id',recipient_id).data('block_type',block_type);
			$(submit_btn).data('block_type',block_type).attr('block_type',block_type).data('block_type',block_type);
			$(submit_btn).data('project_id',project_id).attr('project_id',project_id).data('project_id',project_id);
			$(submit_btn).data('respond_id',respond_id).attr('respond_id',respond_id).data('respond_id',respond_id);
			$(modal).find("img[name='userAvatar']").attr("src","/user.getAvatar?user_id="+recipient_id+"&w=35&h=35");
			$(modal).find("textarea").data('dialog_id',response.dialog_id).attr('data-dialog_id',response.dialog_id);
			// console.log($(modal).find("textarea").data());
			set_btn_state(submit_btn,"reset");
			$(modal).find("a[name='real_user_name']").attr("href","/profile/id"+recipient_id).text(real_user_name);
			// console.log($(submit_btn).data('dialog_id'));
		}
		else
		{
			console.log("error","Произошла ошибка получения ID диалога!");
		}
	})
})

$('#warn-user-modal').on('hidden.bs.modal', function(e){
	var modal = modal = e.delegateTarget;
	$(modal).find("textarea").data('dialog_id',0).attr('data-dialog_id',0);
})


$('#change-banner-link-modal').on('show.bs.modal', function(e){
	var related = e.relatedTarget,
			banner_id = $(related).data('id'),
			banner_link = $(related).data('link'),
			modal = e.delegateTarget,
			submit_btn = $(modal).find("[data-trigger='save-link']"),
			input = $(modal).find("input[name='banner_link']");
	$(input).val(banner_link);
	$(submit_btn).data('id',banner_id);
})

$('#resolve-ticket-modal').on('show.bs.modal', function(e){
	var related = e.relatedTarget,
			ticket_id = $(related).data('ticket_id'),
			profit_for = $(related).data('profit_for'),
			modal = e.delegateTarget,
			submit_btn = $(modal).find("[data-trigger='resolve-ticket']"),
			textarea = $(modal).find("textarea[name='resolve-text']");
	$(submit_btn).data('ticket_id',ticket_id).data('profit_for',profit_for);
})