$.urlParam = function(name, url) {
	if (!url) url = window.location.href;
	name = name.replace(/[\[\]]/g, "\\$&");
	var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
			results = regex.exec(url);
	if (!results) return null;
	if (!results[2]) return '';
	return decodeURIComponent(results[2].replace(/\+/g, " "));
}
$.extend({
	playSound: function () {
		return $(
			'<audio class="sound-player" autoplay="autoplay" style="display:none;">'
				+ '<source src="' + arguments[0] + '" />'
				+ '<embed src="' + arguments[0] + '" hidden="true" autostart="true" loop="false"/>'
			+ '</audio>'
		).appendTo('body');
	},
	stopSound: function () {
		$(".sound-player").remove();
	}
});
function formhash(form, password) {
	var submit = $(form).find("button[type='submit']");
	console.log(form,$(form).serialize());
	if ( $(form).find("input[name='username']").val() == "" || $(form).find("input[name='password']").val() == "" )
	{
		$(submit).removeClass("bg-yellow").addClass("bg-warning").text("Введите email / пароль").blur();
		return false;
	}
	var p = document.createElement("input");
	form.appendChild(p);
	p.name = "p";
	p.type = "hidden";
	p.value = hex_sha512(password.value);
	password.value = "";
	$(submit).removeClass("bg-warning").addClass("bg-yellow disabled").text("Вход...");
	$.ajax({
		url: $(form).attr('action'),
		type: "post",
		data : $(form).serialize(),
		success: function(response)
		{
			if ( response.result == true )
			{
				window.location.reload();
				return;
			}
			else
			{
				if ( response.message )
				{
					$(submit).removeClass("bg-yellow").addClass("bg-warning").text(response.message);
				}
				else
				{
					$(submit).removeClass("bg-yellow").addClass("bg-warning").text("Ошибка");
				}
			}
			$(submit).removeClass("disabled");
			return false;
		}
	})
	return false;
}
function showAlert(type,message)
{
	var modal = $("#alert-modal");
	$("#alert-modal-message").text(message);
	$(modal).modal('show');
}
/*
function scrollTo(elementID,o)
{
	o = o || false;
	if ( o ) return;
	$('html, body').animate({
			scrollTop: $("#"+elementID).offset().top
	}, 1000);
}
*/
function saveSelectedSpecs(reload)
{
	reload = reload || true;
	config.projects.specs = [];
	$(".subcategory.selected").each(function(){
		config.projects.specs.push($(this).data("subcat_id"));
	})
	setCookie("config.projects.specs",JSON.stringify(config.projects.specs));
	if ( reload == true ) reloadTable();
}
function restoreSelectedSpecs()
{
	$.each(config.projects.specs,function(){
		toggleSubCategory(this,true);
	})
}
function slideCategory(cat_id)
{
	$(".category[data-cat_id='"+cat_id+"']").toggleClass("show");
	$(".subcategories[data-parent_cat_id='"+cat_id+"']").slideToggle(function(){
		$(".category[data-cat_id='"+cat_id+"']").find("i.fa").toggleClass("fa-chevron-down fa-chevron-left");
	});
}
function toggleCategory(cat_id,value,single)
{
	single = single || false;
	var li = $(".category[data-cat_id='"+cat_id+"']"),
			radio = $(li).find("input[type='radio']");
	$(radio).prop("checked",value);
	if ( single == false )
	{
		$(".subcategory[data-parent_cat_id='"+cat_id+"']").each(function(){
			var radio = $(this).find("input[type='radio']");
			$(radio).prop("checked",value);
			if ( value == true ) $(this).addClass("selected"); else $(this).removeClass("selected");
		})
	}
	if ( !$(li).hasClass("show") && value == true )
	{
		slideCategory(cat_id);
	}
}
function toggleSubCategory(subcat_id,value)
{
	var li = $($.sprintf(".subcategory[data-subcat_id='%d']",subcat_id)),
			parent_cat_id = $(li).data('parent_cat_id'),
			total_subcats = $(li).parent().children().length;
			radio = $(li).find("input[type='radio']");
	$(radio).prop("checked",value);
	if ( value == true ) $(li).addClass("selected"); else $(li).removeClass("selected");
	var selected_subcats = $(".subcategory.selected[data-parent_cat_id='"+parent_cat_id+"']").length;
	if ( selected_subcats < total_subcats )
	{
		if ( !$(".category[data-cat_id='"+parent_cat_id+"']").hasClass("show") && value == true )
		{
			slideCategory(parent_cat_id);
		}
		toggleCategory(parent_cat_id,false,true);
	}
	if ( selected_subcats == total_subcats ) toggleCategory(parent_cat_id,true,true);
}
function toggleScenarioCategory(scenario_id,subcat_id,value)
{
	var li = $(".scenario-subcategory[data-scenario_id='"+scenario_id+"'][data-subcat_id='"+subcat_id+"']"),
			radio = $(li).find("input[type='radio']");
	$(radio).prop("checked",value);
	( value == true ) ? $(li).addClass("selected") : $(li).removeClass("selected");

}
function showScenarioDetails(item)
{
	var scenario_id = $(item).data('scenario_id'),
			card = $(".scenario-card[data-scenario_id='"+scenario_id+"']"),
			card_block = $(card).find(".card-block"),
			icon = $(card).find("i.fa");
	if ( $(card).hasClass("show") )
	{
		$(card).removeClass("show");
		$(card_block).slideUp();
		$(icon).removeClass("fa-arrow-circle-o-down").addClass("fa-arrow-circle-o-up");
	}
	else
	{
		$(".scenario-card[data-scenario_id!='"+scenario_id+"']").removeClass("show").find(".card-block").slideUp();
		$(card).addClass("show");
		$(card_block).slideDown();
		$(icon).removeClass("fa-arrow-circle-o-up").addClass("fa-arrow-circle-o-down");
	}
}
function reloadTable()
{
	( /performers/.test(window.location.pathname) ) ? config.performers.dt.ajax.reload() : config.projects.dt.ajax.reload();
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

function updateProfileCounter(type,counter)
{
	var indicator = $(".profile-counter[data-type='"+type+"']");
	counter = ( counter > 99 ) ? "99+" : counter;
	( parseInt(counter) > 0 ) ? $(indicator).css('display','inline-block') : $(indicator).css('display','none');
	$(indicator).text(counter);
}

function ytVidId(url) {
	var p = /^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
	return (url.match(p)) ? RegExp.$1 : false;
}

function process_show_portfolio(response)
{
	$("div.tab-pane#portfolio-edit").removeClass("active");
	$("a[data-toggle='tab'][data-target='#portfolio-edit']").removeClass("active");
	// $("a[data-toggle='tab'][data-target='#portfolio']").removeClass("active").tab("show");
	// $("div.tab-pane#portfolio").addClass("active");
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
		var pf = response.portfolio,
				portfolio_id = pf.portfolio_id;
		$("#portfolio-title").text(pf.title);
		$("#portfolio-descr").text(pf.descr);
		$("#portfolio-edit-link").attr("data-portfolio_id",portfolio_id).data("portfolio_id",portfolio_id);
		$("#portfolio-delete-link").attr("data-portfolio_id",portfolio_id).data("portfolio_id",portfolio_id);
		if ( pf.attaches.length > 0 )
		{
			var att_p = 0,
					att_v = 0,
					att_d = 0;
			$.each(pf.attaches,function(){
				var is_cover = (this.attach_id == pf.cover_id) ? 'true' : 'false',
						object = app.formatter.format_portfolio_attach(this,is_cover);
				if ( this.attach_type == 'image' )
				{
					$("#portfolio-photos").append(object);
					att_p++;
				}
				else if ( this.attach_type == 'video' )
				{
					$("#portfolio-videos").append(object);
					att_v++;
				}
				else if ( this.attach_type == 'document' )
				{
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
								$(".portfolio-image-action[data-action='delete_attach']").data('portfolio_id',portfolio_id).data('attach_id',$(target).data('attach_id'));
							},
							onclose: function() {
								$("body").css("overflow","visible").attr("style","");
							},
							onslide: function (index, slide) {
								var img = $(slide).find("img"),
										attach_id = $.urlParam('attach_id',$(img).attr('src'));
								if ( attach_id.length == 32 )
								{
									var real_image = $("img[data-attach_id='"+attach_id+"']"),
											cover_btn = $(".portfolio-image-action[data-action='change_cover']"),
											delete_btn = $(".portfolio-image-action[data-action='delete_attach']");
									if ( real_image.data('is_cover') == true )
									{
										$(delete_btn).data('portfolio_id',portfolio_id).data('attach_id',attach_id);
										$(cover_btn).data('portfolio_id',portfolio_id).data('attach_id',attach_id).data('subact','delete-cover');
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
							"onopen": function(){
								$(".portfolio-image-action").hide();
							}
						};
				blueimp.Gallery(video_links, options);
			})
		}
		$("#portfolio_single").fadeIn();
	}
}

var city_search = "";
$(function(){
	app.user.updateProfileCounters();
	var input = $("#city-select-modal").find("input[type='search']"),
			city_list = $("#city_list");
	app.getCityList("",9,function(response){
		$(city_list).html('');
		if ( response.length ) {
			$.each(response,function(){
				var col_class = ( config.city_id == this.id ) ? "col city-entry active" : "col city-entry";
				var col = $.sprintf('<div class="%s" data-city_id="%d" data-city_name="%s">%s</div>',col_class,this.id,this.city_name,this.city_name);
				$("#city_list").append(col);
			})
			$(".city-entry").click(function(){
				var data = $(this).data();
				config.city_id = data.city_id;
				setCookie("city_id",data.city_id);
				setCookie("city_name",data.city_name);
				window.location.reload();
			})
		}
	})
	$(input).on("keyup",function(e){
		var search = $(this).val();
		if ( city_search == search ) return false;
		city_search = search;
		app.getCityList(search,9,function(response){
			$(city_list).html('');
			if ( response.length ) {
				$.each(response,function(){
					var col_class = ( config.city_id == this.id ) ? "col city-entry active" : "col city-entry";
					var col = $.sprintf('<div class="%s" data-city_id="%d" data-city_name="%s">%s</div>',col_class,this.id,this.city_name,this.city_name);
					$("#city_list").append(col);
				})
				$(".city-entry").click(function(){
					var data = $(this).data();
					config.city_id = data.city_id;
					setCookie("city_id",data.city_id);
					setCookie("city_name",data.city_name);
					window.location.reload();
				})
			}
		})
	})
	$('#city-select-modal').on('show.bs.modal', function (e){
		$(this).find("input[type='search']").trigger("keyup");
	})
	$('#restore-password-modal').on('show.bs.modal', function(e){
		if ( $("#login-modal").hasClass('show') ) $("#login-modal").modal("hide");
	})
	$('#register-modal').on('show.bs.modal', function(e){
		if ( $("#login-modal").hasClass('show') ) $("#login-modal").modal("hide");
	})
	$('#conversation-modal').on('show.bs.modal', function(e){
		var related = e.relatedTarget,
				recipient_id = $(related).data('recipient_id'),
				real_user_name = $(related).data('real_user_name'),
				modal = e.delegateTarget,
				submit_btn = $(modal).find("[data-trigger='send-message']");
		app.im.getDialogId(recipient_id,function(response){
			if ( response.result == "true" )
			{
				$(submit_btn).data('dialog_id',response.dialog_id);
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

	$('#conversation-modal').on('hidden.bs.modal', function(e){
		var modal = modal = e.delegateTarget;
		$(modal).find("textarea").data('dialog_id',0).attr('data-dialog_id',0);
	})
	$('#save-note-modal').on('show.bs.modal', function(e){
		var related = e.relatedTarget,
				recipient_id = $(related).data('recipient'),
				real_user_name = $(related).data('real_user_name'),
				modal = e.delegateTarget,
				submit_btn = $(modal).find(".wdo-btn[name='save-note']"),
				textarea = $(modal).find("textarea[name='note-text']");
		$(submit_btn).data('recipient',recipient_id);
		$(modal).find("img[name='userAvatar']").attr("src","/user.getAvatar?user_id="+recipient_id+"&w=35&h=35");
		$(textarea).data('recipient',recipient_id);
		$(textarea).on("keyup",function(){
			set_btn_state(submit_btn,"reset");
		})
		set_btn_state(submit_btn,"reset");
		$(modal).find("a[name='real_user_name']").attr("href","/profile/id"+recipient_id).text(real_user_name);
		app.user.getNote(recipient_id,function(response){
			if ( response.result == "true" )
			{
				var matches = response.userNote.match(/\n/g),
						breaks = matches ? matches.length : 2;
				$(textarea).val(_.unescape(response.userNote)).attr('rows',breaks + 2);
			}
			else
			{
				var matches = response.message.match(/\n/g),
						breaks = matches ? matches.length : 2;
				$(textarea).val(response.message).attr('rows',breaks + 2);;
			}
		});
	})

	$('#user-calendar-modal').on('show.bs.modal', function(e){
		var related = e.relatedTarget,
				modal = e.delegateTarget,
				submit_btn = $(modal).find(".wdo-btn[name='save-calendar']"),
				calendar = $(modal).find(".calendar");
		set_btn_state(submit_btn,"reset");
		$(calendar).multiDatesPicker();
		app.user.getCalendar(config.profile.user_id,function(response){
			if ( response.result == "true" )
			{
				if ( response.dates.length > 0 )
				{
					var dates = [],
							disabledDates = [],
							disabledDays = [];
					$.each(response.dates,function(){
						var date = moment.unix(this.timestamp).toDate();
						if (this.editable == 1)
						{
							dates.push(date);
						}
						else
						{
							disabledDays.push(jQuery.datepicker.formatDate('yy-mm-dd', date));
							disabledDates.push(date);
						}
					})
					if ( disabledDates.length > 0 ) $(calendar).multiDatesPicker({
						'addDisabledDates': disabledDates,
						'beforeShowDay': function(date){
							var str = jQuery.datepicker.formatDate('yy-mm-dd', date);
							if ( $.inArray(str, disabledDays) != -1 )
								return [false,'special'];
							else
								return [true,''];
						}
					});
					if ( dates.length > 0 ) $(calendar).multiDatesPicker('addDates',dates);
					$(calendar).find(".ui-datepicker-unselectable.ui-state-disabled.special").attr("title","На этот день у вас уже запланировано мероприятие");
				}
			}
		})
	})

	$(".wdo-btn[name='save-note']").click(function(){
		var btn = this,
				recipient_id = $(this).data('recipient'),
				textarea = $("textarea[name='note-text']")
				note_text = $(textarea).val();
		set_btn_state(btn,"loading");
		app.user.saveNote(recipient_id,note_text,function(response){
			set_btn_state(btn,"reset",response.message);
			if ( window.location.pathname.match('/profile/') && response.result == "true" )
			{
				$("#user_note").text(note_text);
			}
		});
	})

	$(".wdo-btn[name='save-calendar']").click(function(){
		var btn = this,
				calendar = $("#user-calendar-modal").find(".calendar"),
				calendar_view = $(".calendar-view");
		set_btn_state(btn,"loading");
		var dates_tmp = $(calendar).multiDatesPicker('getDates'),
				dates = [];
		$.each(dates_tmp,function(idx,val){
			dates.push(moment(val).format("X"));
		})
		app.user.saveCalendar(dates,function(response){
			set_btn_state(btn,"reset",response.message);
			$(calendar).multiDatesPicker('resetDates');
			$(calendar_view).multiDatesPicker('resetDates');
			$(calendar).multiDatesPicker('addDates', dates_tmp);
			$(calendar_view).multiDatesPicker('addDates', dates_tmp);
		});
	})

	var login_btn = $('#login-modal').find("button[type='submit']");
	$('#login-modal').find("form input").each(function(){
		$(this).on("keyup",function(e){
			if ( e.keyCode == 13 ) return;
			$(login_btn).removeClass("bg-warning").removeClass("disabled").addClass("bg-yellow").text("Вход");
		})
	})


	$('#performers-map-modal').on('shown.bs.modal', function(e){
		map.invalidateSize();
	})
	$('#performers-map-modal').on('hidden.bs.modal', function(e){
		map.invalidateSize();
	})
})