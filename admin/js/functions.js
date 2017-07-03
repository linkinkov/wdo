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