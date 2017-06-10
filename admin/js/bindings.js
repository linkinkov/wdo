$(document).on("click","#menu-content .menu-entry", function(){
	var li = $(this),
			page = $(li).data('page');
	loadPage(page);

})