function formhash(form, password) {
	var p = document.createElement("input");
	var submit = $(form).find("button[type='submit']");
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
function scrollTo(elementID)
{
	$('html, body').animate({
			scrollTop: $("#"+elementID).offset().top
	}, 1000);
}
function update_city_list(input,e)
{
	if ( e.keyCode < 20 && e.keyCode != 8 ) return;
	var search = $(input).val();
	$.ajax({
		type: "POST",
		url: "/get.cityList",
		data: {
			"search": search
		},
		dataType: "JSON",
		success: function (response) {
			$("#city_list").html('');
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
		}
	});
}
function saveSelectedSpecs(reload)
{
	reload = reload || true;
	config.projects.specs = [];
	$(".subcategory.selected").each(function(){
		config.projects.specs.push($(this).data("subcat_id"));
	})
	setCookie("config.projects.specs",JSON.stringify(config.projects.specs));
	if ( reload == true ) reloadProjectsTable();
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
function reloadProjectsTable()
{
	config.projects.dt.ajax.reload();
}
function set_btn_state(btn,state,message,clas)
{
	clas = clas || "";
	message = message || false;
	var i = $(btn).find("i.fa");
	if ( state == "loading" )
	{
		$(btn).addClass("disabled").text(message);
		$(i).attr('class','fa fa-spinner fa-spin');
	}
	else if ( state == "reset" )
	{
		$(btn).removeClass("disabled").text(message);
		$(i).attr('class','fa '+clas);
	}
}

$(function(){
	$('#city-select-modal').on('shown.bs.modal', function (e){
		update_city_list(this,e);
	})
	$('#restore-password-modal').on('show.bs.modal', function(e){
		$("#login-modal").modal("hide");
	})
	$('#register-modal').on('show.bs.modal', function(e){
		$("#login-modal").modal("hide");
	})
	$('#send-pm-modal').on('show.bs.modal', function(e){
		var related = e.relatedTarget,
				recipient_id = $(related).data('recipient'),
				modal = e.delegateTarget,
				submit_btn = $(modal).find(".wdo-btn[name='send-pm']");
		$(submit_btn).data('recipient',recipient_id);
		$(modal).find("img[name='userAvatar']").attr("src","/user.getAvatar?user_id="+recipient_id+"&w=35&h=35");
		$(modal).find("textarea[name='message-text']").data('recipient',recipient_id);
		set_btn_state(submit_btn,"reset");
		app.user.getUserName(recipient_id,function(){
			$(modal).find("a[name='userName']").attr("href","/profile/id"+recipient_id).text(app.user.userName);
		});
	})
	$('#add-note-modal').on('show.bs.modal', function(e){
		var related = e.relatedTarget,
				recipient_id = $(related).data('recipient'),
				modal = e.delegateTarget,
				submit_btn = $(modal).find(".wdo-btn[name='add-note']");
		$(submit_btn).data('recipient',recipient_id);
		$(modal).find("img[name='userAvatar']").attr("src","/user.getAvatar?user_id="+recipient_id+"&w=35&h=35");
		$(modal).find("textarea[name='note-text']").data('recipient',recipient_id);
		set_btn_state(submit_btn,"reset");
		app.user.getUserName(recipient_id,function(){
			$(modal).find("a[name='userName']").attr("href","/profile/id"+recipient_id).text(app.user.userName);
		});
		app.user.getUserNote(recipient_id,function(){
			$(modal).find("textarea[name='note-text']").val(app.user.userNote);
		});
	})

	$(".wdo-btn[name='send-pm']").click(function(){
		var btn = this,
				recipient_id = $(this).data('recipient'),
				textarea = $("textarea[name='message-text-from-modal']")
				message_text = $(textarea).val();
		console.log("Sending message: '"+message_text+"' to user:",recipient_id);
		set_btn_state(btn,"loading");
		app.user.sendMessage(recipient_id,message_text,function(){
			$('#send-pm-modal').modal("hide");
			$(textarea).val("");
			set_btn_state(btn,"reset");
		});
	})

	$(".wdo-btn[name='add-note']").click(function(){
		var btn = this,
				recipient_id = $(this).data('recipient'),
				textarea = $("textarea[name='note-text-from-modal']")
				note_text = $(textarea).val();
		console.log("Saving note: '"+note_text+"' to user:",recipient_id);
		set_btn_state(btn,"loading");
		app.user.addNote(recipient_id,note_text,function(){
			$('#send-pm-modal').modal("hide");
			$(textarea).val("");
			set_btn_state(btn,"reset");
		},function(response){
			console.log("error_callback! response:",response);
			if ( response.message ) set_btn_state(btn,"reset",response.message);
		});
	})
	var login_btn = $('#login-modal').find("button[type='submit']");
	$('#login-modal').find("form input").each(function(){
		$(this).on("keyup",function(e){
			if ( e.keyCode == 13 ) return;
			$(login_btn).removeClass("bg-warning").removeClass("disabled").addClass("bg-yellow").text("Вход");
		})
	})
	$(document).on("click",".wdo-btn",function(e){
		if ( $(this).hasClass("disabled") ) return false;
	})
	$(document).on("click",".custom-control-description, .toggle-category",function(e){
		e.stopPropagation();
		e.preventDefault();
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
	$(document).on("click",".subcategory",function(e){
		e.stopPropagation();
		e.preventDefault();
		var value = $(this).find("input[type='radio']").prop("checked");
		toggleSubCategory($(this).data("subcat_id"),!value);
		saveSelectedSpecs();
	})
	$(document).on("click",".custom-radio",function(e){
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
})