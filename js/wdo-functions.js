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
function slideCategory(cat_id)
{
	$(".subcategories[data-parent_cat_id='"+cat_id+"']").slideToggle(function(){
		$(".category[data-cat_id='"+cat_id+"']").find("i.fa").toggleClass("fa-chevron-down fa-chevron-left");
		$(".category[data-cat_id='"+cat_id+"']").toggleClass("show");
	});
}
function toggleCategory(cat_id,value,reload)
{
	reload = reload || false;
	var li = $($.sprintf(".category[data-cat_id='%d']",cat_id));
	var radio = $(li).find("input[type='radio']");
	$(radio).prop("checked",value);
	$(".subcategory[data-parent_cat_id='"+cat_id+"']").each(function(){
		var radio = $(this).find("input[type='radio']");
		$(radio).prop("checked",value);
		$(this).toggleClass("selected");
	})
	if ( reload == true ) reloadProjectsTable();
}
function toggleSubCategory(subcat_id,reload)
{
	reload = reload || false;
	var li = $($.sprintf(".subcategory[data-subcat_id='%d']",subcat_id));
	var radio = $(li).find("input[type='radio']");
	var value = $(radio).prop("checked");
	$(radio).prop("checked",!value);
	$(li).toggleClass("selected");
	if ( reload == true ) reloadProjectsTable();
}
function reloadProjectsTable()
{
	config.projects.dt.ajax.reload();
}
$(function(){
	$('#city-select-modal').on('shown.bs.modal', function (e) {
		update_city_list(this,e);
	})
	$('#restore-password-modal').on('show.bs.modal', function(e) {
		$("#login-modal").modal("hide");
	})
	$('#register-modal').on('show.bs.modal', function(e) {
		$("#login-modal").modal("hide");
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
			toggleSubCategory($(li).data("subcat_id"),true);
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
		toggleSubCategory($(this).data("subcat_id"),true);
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
			toggleCategory(cat_id,!value,true);
		}
		else
		{
			toggleSubCategory($(li).data("subcat_id"),true);
		}
	})
	$(document).on("click",".project-extra-filter",function(e){
		$(this).toggleClass("active");
		reloadProjectsTable();
	})
})