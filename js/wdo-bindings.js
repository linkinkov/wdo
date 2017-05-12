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
					app.im.poller.check_msgs(dialog_id,response.wait);
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

$(document).on("click",".download",function(e){
	e.stopPropagation();
	e.preventDefault();
	var href = $(this).attr("href");
	window.open(href,'_blank');
})


$(document).on("click","[data-toggle='show-portfolio']",function(e){
	e.preventDefault();
	var portfolio_id = $(this).data('portfolio-id');
	app.portfolio.showPortfolio(portfolio_id,function(response){
		$("#portfolio-title").text('');
		$("#portfolio-descr").text('');
		$("#portfolio-photos").html('');
		$("#portfolio-videos").html('');
		$("#portfolio-docs").html('');
		$(".portfolio-photos-container").hide();
		$(".portfolio-videos-container").hide();
		$(".portfolio-docs-container").hide();
		if ( response.result == "true" )
		{
			var pf = response.portfolio;
			$("#portfolio-title").text(pf.title);
			$("#portfolio-descr").text(pf.descr);
			$("#portfolio-edit-link").attr("data-pfid",portfolio_id).data("portfolio_id",portfolio_id);
			$("#portfolio-delete-link").attr("data-pfid",portfolio_id).data("portfolio_id",portfolio_id);
			if ( pf.attaches.length > 0 )
			{
				var att_p = 0,
						att_v = 0,
						att_d = 0;
				$.each(pf.attaches,function(){
					var object = '',
							is_cover = (this.attach_id == pf.cover_id) ? 'true' : 'false';
					if ( this.attach_type == 'image' )
					{
						object = '<a href="/get.Attach?attach_id='+this.attach_id+'&w=800&h=800"><img style="height: 100px;" class="img-thumbnail" src="/get.Attach?attach_id='+this.attach_id+'&w=150&h=150&force_resize=true" data-is_cover="'+is_cover+'" data-attach-id="'+this.attach_id+'"/></a>';
						$("#portfolio-photos").append(object);
						att_p++;
					}
					else if ( this.attach_type == 'video' )
					{
						object = '<a '
						+'	href="'+this.url+'"'
						+'	title="" type="text/html"'
						+'	data-youtube="'+this.youtube_id+'" poster="http://img.youtube.com/vi/'+this.youtube_id+'/0.jpg">'
						+'<img style="height: 100px;" class="img-thumbnail" src="http://img.youtube.com/vi/'+this.youtube_id+'/0.jpg" />';
						+'</a>';
						$("#portfolio-videos").append(object);
						att_v++;
					}
					else if ( this.attach_type == 'document' )
					{
						object = '<a class="download" href="/get.Attach?attach_id='+this.attach_id+'"><img class="img-thumbnail" src="/images/document.png" /></a>';
						$("#portfolio-docs").append(object);
						att_d++;
					}
				});
				if ( att_p > 0 ) $(".portfolio-photos-container").show();
				if ( att_v > 0 ) $(".portfolio-videos-container").show();
				if ( att_d > 0 ) $(".portfolio-docs-container").show();
				$("#portfolio-photos").click(function (event) {
					event = event || window.event;
					var target = event.target || event.srcElement,
							link = target.src ? target.parentNode : target,
							options = {
								index: link,
								event: event,
								onopen: function () {
									$(".portfolio-image-action").show();
									$(".portfolio-image-action[data-action='delete_image']").data('portfolio_id',portfolio_id).data('attach_id',$(target).data('attach_id'));
								},
								onslide: function (index, slide) {
									var img = $(slide).find("img"),
											attach_id = $.urlParam('attach_id',$(img).attr('src'));
									if ( attach_id.length == 32 )
									{
										var real_image = $("img[data-attach-id='"+attach_id+"']"),
												cover_btn = $(".portfolio-image-action[data-action='change_cover']"),
												delete_btn = $(".portfolio-image-action[data-action='delete_image']");
										if ( real_image.data('is_cover') == true )
										{
											$(delete_btn).data('portfolio_id',portfolio_id).data('attach_id',attach_id);
											$(cover_btn).data('portfolio_id',portfolio_id).data('attach_id',attach_id).data('subact','delete_cover');
											$(cover_btn).find("i.fa").removeClass("fa-star-o").addClass("fa-star");
											$(cover_btn).show();
										}
										else if ( real_image.data('is_cover') == false )
										{
											$(delete_btn).data('portfolio_id',portfolio_id).data('attach_id',attach_id)
											$(cover_btn).data('portfolio_id',portfolio_id).data('attach_id',attach_id).data('subact','set-cover');
											$(cover_btn).find("i.fa").removeClass("fa-star").addClass("fa-star-o");
											$(cover_btn).show();
										}
										else
										{
											$(cover_btn).data('portfolio_id','').data('attach_id','').data('subact','');
											$(cover_btn).find("i.fa").removeClass("fa-star").addClass("fa-star-o");
											$(cover_btn).hide();
										}
									}
									// Callback function executed on slide change.
								},
							},
							links = $(this).find("a").not(".download");
					app.portfolio.gallery = blueimp.Gallery(links, options);
				})
				$("#portfolio-videos").click(function (event) {
					video_links = $(this).find("a").not(".download");
					event = event || window.event;
					var target = event.target || event.srcElement,
							link = target.src ? target.parentNode : target,
							options = {
								index: link,
								event: event,
							};
					blueimp.Gallery(video_links, options);
				})
			}
			var $sp = $("#portfolio_single");
			$sp.show().css({
				left: -($sp.width())
			}).animate({
				left: 15
			}, 500);
		}

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
				var real_image = $("img[data-attach-id='"+data.attach_id+"']"),
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
					$('[data-toggle="show-portfolio"][data-portfolio-id="'+data.portfolio_id+'"]').find("img.card-img-top").attr('src','/get.Attach?attach_id='+data.attach_id+'&w=230&h=500');
					$(cover_btn).data('portfolio_id',data.portfolio_id).data('attach_id',data.attach_id).data('subact','delete-cover');
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
	else if ( data.action == "delete_image" )
	{
		$("img.slide-content[src='*"+data.attach_id+"*']").remove();
		var slide_img = $("img.slide-content[src*='"+data.attach_id+"']"),
				li = $("ol.indicator").find("li[style*='"+data.attach_id+"']");
		app.portfolio.deleteItem(data.portfolio_id,data.attach_id,"image",function(response){
			if ( response == true )
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

$(document).on('click','a[data-toggle="tab"]', function(e){
	var target = $(e.target);
	if ( app.im.getMessagesAjax != null ) app.im.getMessagesAjax.abort();
	clearTimeout(app.im.poller.poller_id_msg);
	if ( $(target).data('target') == '#messages' && $("#messages").find(".dialogs-container").length > 0 )
	{
		$(".tab-pane#messages").removeClass("active");
		$(target).removeClass("active").tab('show');
	}
	if ( $(target).data('target') == '#portfolio' )
	{
		$(".tab-pane#portfolio").removeClass("active");
		$(target).removeClass("active").tab('show');
	}
})
$(document).on('shown.bs.tab','a[data-toggle="tab"]', function (e) {
	$(".dialogs-container").html('');
});

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

	$(prev_tab).html('');
	$(target_tab).html('');
	$(target_tab).html('<div class="loader text-center" style="width: 100%;"><i class="fa fa-spinner fa-spin fa-3x"></i></div>');
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
	$("button[data-name='subcategory']").text('Подкатегория');
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
