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
