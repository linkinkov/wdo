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
	reloadTable();
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
	$("#conversation-leave-btn").data('dialog_id',dialog_id).attr('data-dialog_id',dialog_id);
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
					app.im.poller.check_msgs(dialog_id,response.wait);
				},3000);
			}
			$.each(response.messages,function(){
				$(".conversation-messages").prepend(app.formatter.format_message(this));
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

$(document).on("keydown","#conversation-message-text", function(e){
	if (e.ctrlKey && e.keyCode == 13) {
		$("#conversation-message-send").click();
	}
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
		if ( $(this).attr("modal") == "true" )
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

$(document).on("click","[data-trigger='leave-chat']", function(){
	if ( confirm('Вы уверены, что хотите покинуть общий диалог ?') )
	{
		dialog_id = $(this).data('dialog_id'),
		app.im.leaveChat(dialog_id,function(response){
			if ( response.result == "true" ) $("a[data-toggle='tab'][data-target='#messages']").click();
			else if ( response.result == "false" ) showAlert("danger",response.message);
		})
	}
})

$(document).on("click",".wdo-btn",function(e){
	if ( $(this).hasClass("disabled") ) return false;
})
$(document).on("click",".list-group-item,.custom-control-description-cat, .toggle-category",function(e){
	e.stopPropagation();
	e.preventDefault();
	if ( $(this).hasClass("scenario-subcategory") )
	{
		var value = $(this).find("input[type='radio']").prop("checked");
		toggleScenarioCategory($(this).data('scenario_id'),$(this).data('subcat_id'),!value);
		return;
	}
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

$(document).on("click",".download",function(e){
	e.stopPropagation();
	e.preventDefault();
	var href = $(this).attr("href");
	window.open(href,'_blank');
})


$(document).on("click","[data-toggle='show-portfolio']",function(e){
	e.preventDefault();
	var portfolio_id = $(this).data('portfolio_id');
	app.portfolio.showPortfolio(portfolio_id,function(response){
		process_show_portfolio(response);
	});
})

$(".portfolio-image-action").click(function(e){
	var btn = $(this),
			data = $(btn).data();
	if ( data.action == "change_cover" )
	{
		app.portfolio.changeCover(data.portfolio_id,data.attach_id,data.subact,function(response){
			if ( response.result == "true" )
			{
				var real_image = $("img[data-attach_id='"+data.attach_id+"']"),
						cover_btn = $(".portfolio-image-action[data-action='change_cover']");
				if ( real_image.data('is_cover') == true )
				{
					$(cover_btn).data('portfolio_id',data.portfolio_id).data('attach_id',data.attach_id).data('subact','set-cover');
					$(cover_btn).find("i.fa").removeClass("fa-star").addClass("fa-star-o");
					$(real_image).data('is_cover',false);
					$(cover_btn).show();
				}
				else if ( real_image.data('is_cover') == false )
				{
					$('[data-toggle="show-portfolio"][data-portfolio_id="'+data.portfolio_id+'"]').find("img.card-img-top").attr('src','/get.Attach?attach_id='+data.attach_id+'&w=230&h=500');
					$(cover_btn).data('portfolio_id',data.portfolio_id).data('attach_id',data.attach_id).data('subact','delete-cover');
					// $("i.fa-star").removeClass("fa-star").addClass("fa-star-o");
					$("#portfolio-photos").find("img").data("is_cover",false).attr("data-is_cover","false");
					$(cover_btn).find("i.fa").removeClass("fa-star-o").addClass("fa-star");
					$(real_image).data('is_cover',true);
					$(cover_btn).show();
				}
				else
				{
					$(cover_btn).data('portfolio_id','').data('attach_id','').data('subact','');
					$(cover_btn).find("i.fa").removeClass("fa-star").addClass("fa-star-o");
					$(cover_btn).hide();
				}
			}
		})
	}
	else if ( data.action == "delete_attach" )
	{
		$("img.slide-content[src='*"+data.attach_id+"*']").remove();
		var slide_img = $("img.slide-content[src*='"+data.attach_id+"']"),
				li = $("ol.indicator").find("li[style*='"+data.attach_id+"']");
		app.portfolio.deleteAttach(data.attach_id,"image",function(response){
			console.log(response);
			if ( response.result == true )
			{
				$(li).remove();
				$(slide_img).remove();
				$("img[data-attach_id='"+data.attach_id+"']").remove();
				$(slide_img).remove();
				app.portfolio.gallery.next();
			}
			else
			{
				showAlert("error","Ошибка удаления");
			}
		})
	}
})
$(document).on('click','#portfolio-delete-link', function(e){
	var data = $(this).data();
	var res = confirm('Удалить портфолио?');
	if ( res == true )
	{
		app.portfolio.delete(data.portfolio_id,function(response){
			if ( response.result == "true" )
			{
				$("a[data-target='#portfolio']").click();
			}
		});
	}
})
$(document).on('click','a[data-toggle="tab"]', function(e){
	var target = $(e.target);
	if ( app.im.getMessagesAjax != null ) app.im.getMessagesAjax.abort();
	clearTimeout(app.im.poller.poller_id_msg);
	if ( $(target).data('target') == '#messages' && $("#messages").find(".dialogs-container").length > 0 )
	{
		$(".tab-pane#messages").removeClass("active");
		$(target).removeClass("active").tab('show');
	}
	else if ( $(target).data('target') == '#portfolio' && $("#portfolio_list").length > 0 )
	{
		$(".tab-pane#portfolio").removeClass("active");
		$(target).removeClass("active").tab('show');
	}
})
$(document).on('shown.bs.tab','a[data-toggle="tab"]', function (e) {
	$(".dialogs-container").html('');
	// $("#portfolio_list").html('');
});

$(document).on("click",'a[data-toggle="custom-tab"]', function(e) {
	var target = $(this).data('target');
	$('a[data-toggle="custom-tab"]').removeClass("text-purple");
	$('a[data-toggle="tab"][data-target="'+target+'"]').tab('show');
	$(this).addClass("text-purple");
})

$(document).on('show.bs.tab','a[data-toggle="tab"]', function (e) {
	var current_tab = e.target,
			prev = e.relatedTarget,
			prev_tab = $(prev).data('target'),
			target = $(current_tab).data('target'),
			target_tab = $("div.tab-pane"+target),
			id = $(e.target).data("target").substr(1),
			prev_id = window.location.hash;
	if ( !/portfolio-/.test(id) )
	{
		window.location.hash = id;
	}
	$(".dialogs-container").html('');
	$('a[data-toggle="custom-tab"]').removeClass("text-purple");
	$(prev_tab).html('');
	$(target_tab).html('');
	$(target_tab).html('<div class="loader text-center"><i class="fa fa-spinner fa-spin fa-3x"></i></div>');
	$(".loader").show();
	var post_data = {
		"user_id": config.profile.user_id
	}
	if ( id == "portfolio-edit" ) post_data["portfolio_id"] = $(this).data('portfolio_id');
	$.ajax({
		type: "POST",
		url: "/pp/"+id,
		dataType: "html",
		data: post_data,
		error: function(err)
		{
			window.location = '/';
		},
		success: function (response) {
			$(target_tab).append(response);
		}
	});
})

$(document).on("click",".performer_found",function(e){
	if ( $(this).hasClass("active") )
	{
		$(this).toggleClass("active");
		return;
	};
	$(".performer_found").removeClass("active");
	$(this).addClass("active");
})

$(document).on("click",".wdo-option[data-name='category']", function(){
	var cat_id = $(this).data('value');
	$("button[data-name='subcategory']").text('Подраздел');
	app.getSubCategories(cat_id,function(response){
		if ( response )
		{
			$(".subcat-list").html('');
			$.each(response,function(){
				$(".subcat-list").append($.sprintf('<a class="dropdown-item wdo-option" data-name="subcategory" data-value="%d" data-parentid="%d">%s</a>',this.id,this.parent_cat_id,this.subcat_name));
			})
			$(".dropdown-toggle[data-name='subcategory']").removeClass("disabled");
		}
	})
})

var current_links = [];
$(document).on("keyup","input[data-name='youtube-link']",function(){
	if ( current_links.length >= 5 ) return;
	if ( ytVidId($(this).val()) && $.inArray($(this).val(),current_links) == -1 )
	{
		current_links.push($(this).val());
		$(this).removeClass("empty");
	}
	var empty = $("input.empty[data-name='youtube-link']");
	if ( empty.length == 0 ) $('<input type="text" class="form-control empty" data-name="youtube-link" placeholder="Ссылка на ваше видео в YouTube" />').appendTo("#yt_links");
})

$(document).on("click",".rating-grade", function(e){
	var grade_val = parseInt($(this).text()),
			respond_id = $(this).data("respond_id"),
			grade_text = "балл",
			ico = "good",
			container = $(".project-respond-result-body[data-respond_id='"+respond_id+"']");
	$(container).find(".rating-grade").removeClass("selected");
	$(this).addClass("selected");
	switch ( grade_val )
	{
		case 1: grade_text = "балл"; break;
		case 2: grade_text = "балла"; break;
		case 3: grade_text = "балла"; break;
		case 4: grade_text = "балла"; break;
		default: grade_text = "баллов"; break;
	}
	ico = ( grade_val >= 5 ) ? "good" : "bad";
	$(container).find(".rating-grade-value").text(grade_val);
	$(container).find(".rating-grade-text").text(grade_text);
	$(container).find(".rating-ico").attr("src","/images/rating-"+ico+"-big.png");

})