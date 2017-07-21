var current_date = new Date;
moment.locale("ru");
moment.updateLocale('ru', {
	calendar: {
		lastDay : '[Вчера в] LT',
		sameDay : '[Сегодня в] LT',
		nextDay : '[Завтра в] LT',
		lastWeek : 'dddd[,] LT',
		nextWeek : 'dddd[,] LT',
		sameElse : 'L'
	}
});

var config = {
	"city_id": getCookie("city_id") || 1,
	"projects":
	{
		"dt": null,
		"table": {
			"length": 10,
			"state": {},
		},
		"calendar": null,
		"specs": []
	},
	"performers":
	{
		"dt": null,
	},
	"respondsTable": null,
	"profile":
	{
		"user_id": 0,
		"placeCoords": "55,55",
		"messages_per_page": 10
	},
	"datePickerOptions": {
		"ranges": {
			"Сегодня": [ current_date, current_date ],
			"След. 3 дня": [ current_date, moment().add(3,"days") ],
			"След. 7 дней": [ current_date, moment().add(6,"days") ],
			"След. 30 дней": [ current_date, moment().add(30,"days") ],
			"След. 6 месяцев": [ current_date, moment().add(6,"months") ]
		},
		"opens":"left",
		"locale": {
			"format": "YYYY-MM-DD",
			"applyLabel": "Применить",
			"cancelLabel": "Отмена",
			"customRangeLabel": "Указать",
			"daysOfWeek": [
				"Вс",
				"Пн",
				"Вт",
				"Ср",
				"Чт",
				"Пт",
				"Сб"
			],
			"monthNames": [
				"Январь",
				"Февраль",
				"Март",
				"Апрель",
				"Май",
				"Июнь",
				"Июль",
				"Август",
				"Сентябрь",
				"Октябрь",
				"Ноябрь",
				"Декабрь"
			]
		},
		"startDate": moment().startOf("day").format("YYYY-MM-DD"),
		"endDate": moment().add(6,"days").format("YYYY-MM-DD"),
		"alwaysShowCalendars": true,
		"showCustomRangeLabel": false
	},
	"datePickerOptionsSingle": {
		"opens":"left",
		"locale": {
			"format": "DD/MM/YYYY",
			"applyLabel": "Применить",
			"cancelLabel": "Отмена",
			"daysOfWeek": [
				"Вс",
				"Пн",
				"Вт",
				"Ср",
				"Чт",
				"Пт",
				"Сб"
			],
			"monthNames": [
				"Январь",
				"Февраль",
				"Март",
				"Апрель",
				"Май",
				"Июнь",
				"Июль",
				"Август",
				"Сентябрь",
				"Октябрь",
				"Ноябрь",
				"Декабрь"
			]
		},
		"alwaysShowCalendars": true,
		"singleDatePicker": true,
		"showDropdowns": true,
		"minDate": moment().subtract(80,"years"),
		"maxDate": moment().subtract(18,"years")
	}
};

var app = {
	"user": {
		"register": function (btn)
		{
			var modal = $("#register-modal"),
					username = $(modal).find("input[name='username']").val(),
					real_user_name = $(modal).find("input[name='real_user_name']").val(),
					passw = $(modal).find("input[name='password']").val(),
					passw_2 = $(modal).find("input[name='password_2']").val();
			if ( !isValidEmail(username) )
			{
				$(btn).text("Некорректный email").removeClass("bg-yellow").addClass("bg-warning");
				return;
			}
			if ( passw != passw_2 )
			{
				$(btn).text("Пароли не совпадают").removeClass("bg-yellow").addClass("bg-warning");
				return;
			}
			if ( real_user_name == "" )
			{
				$(btn).text("Укажите имя").removeClass("bg-yellow").addClass("bg-warning");
				return;
			}
			set_btn_state(btn,'loading');
			$.ajax({
				type: "POST",
				url: "/user.register",
				data: {
					"username": username,
					"real_user_name": real_user_name,
					"password": hex_sha512(passw)
				},
				dataType: "JSON",
				success: function (response) {
					if ( response.message )
					{
						if ( response.result == "true" )
						{
							$(modal).find("input[name='username']").val("");
							$(modal).find("input[name='real_user_name']").val("");
							$(modal).find("input[name='password']").val("");
							$(modal).find("input[name='password_2']").val("");
							$(modal).modal('hide');
						}
						showAlert("info",response.message);
					}
					set_btn_state(btn,'reset');
				}
			})
		},
		"activate": function(key)
		{
			$.ajax({
				type: "POST",
				url: "/user.activate",
				dataType: "JSON",
				data: {
					"key": key
				},
				success: function (response) {
					if ( response.message )
					{
						showAlert("info",response.message);
					}
				}
			})
		},
		"updateProfileCounters": function()
		{
			$.ajax({
				type: "POST",
				url: "/user.getProfileCounters",
				dataType: "JSON",
				success: function (response) {
					if ( response.result == "true" )
					{
						$.each(response.counters,function(key,value){
							if ( $.type(value) == 'object' )
							{
								if ( key == 'project_responds' )
								{
									updateProfileCounter('project-responds',value.unreaded);
								}
								else if ( key == 'responds' )
								{
									updateProfileCounter('responds',value.unreaded);
								}
								else if ( key == 'warnings' )
								{
									updateProfileCounter('warnings',value.unreaded);
								}
							}
							else
							{
								updateProfileCounter(key,value);
							}
						})
					}
				}
			})
		},
		"getNote": function(user_id,callback)
		{
			callback = callback || function(){};
			$.ajax({
				type: "POST",
				url: "/user.getNote",
				data: {
					"user_id": user_id
				},
				dataType: "JSON",
				success: function (response) {
					callback(response);
				}
			})
		},
		"saveNote": function(user_id,note_text,callback)
		{
			callback = callback || function(){};
			$.ajax({
				type: "POST",
				url: "/user.saveNote",
				data: {
					"user_id": user_id,
					"note_text": note_text
				},
				dataType: "JSON",
				success: function (response) {
					callback(response);
				}
			})
		},
		"getProfileInfo": function(user_id,callback)
		{
			callback = callback || function(){};
			$.ajax({
				type: "POST",
				url: "/user.getProfileInfo",
				data: {
					"user_id": user_id
				},
				dataType: "JSON",
				success: function (response) {
					callback(response);
				}
			})
		},
		"updateProfileInfo": function(data,callback)
		{
			callback = callback || function(){};
			$.ajax({
				type: "POST",
				url: "/user.updateProfileInfo",
				data: {
					"data": data
				},
				dataType: "JSON",
				success: function (response) {
					callback(response);
				}
			})
		},
		"getCalendar": function(user_id,callback)
		{
			callback = callback || function(){};
			$.ajax({
				type: "POST",
				url: "/user.calendar",
				data: {"user_id":user_id,"action":"get"},
				dataType: "JSON",
				success: function (response) {
					callback(response);
				}
			})
		},
		"saveCalendar": function(dates,callback)
		{
			callback = callback || function(){};
			$.ajax({
				type: "POST",
				data: {"action":"set","dates": dates},
				url: "/user.calendar",
				dataType: "JSON",
				success: function (response) {
					callback(response);
				}
			})
		}
	},
	"project": {
		"getAttachList": function(project_id,callback)
		{
			if ( parseInt(project_id) <= 0 ) return false;
			callback = callback || function(){};
			$.ajax({
				type: "POST",
				url: "/get.AttachList",
				data: {
					"id": project_id
				},
				dataType: "JSON",
				success: function (response) {
					callback(response);
				}
			})
		},
		"acceptRespond": function(respond_id,btn)
		{
			var container = $(".project-respond-result-body[data-respond_id='"+respond_id+"']"),
					grade_val = parseInt($(container).find(".rating-grade-value").text()),
					respond_text = $(container).find(".respond-text").val();
			if ( grade_val <= 0 ) {showAlert("danger","Пожалуйста, укажите оценку");return;};
			if ( respond_text.length < 2 ) {showAlert("danger","Пожалуйста, укажите текст отзыва"); return;};
			set_btn_state(btn,'loading');
			$.ajax({
				type: "POST",
				url: "/project_respond/accept",
				data: {
					"respond_id": respond_id,
					"descr": respond_text,
					"grade": grade_val
				},
				dataType: "JSON",
				success: function (response) {
					if ( response.result == "true" )
					{
						config.respondsTable.ajax.reload();
						$(btn).text(response.message);
					}
					else
					{
						var message = ( response.message ) ? response.message : "Произошла ошибка, обновите страницу или попробуйте позже";
						showAlert("danger",message);
						set_btn_state(btn,"reset");
					}
				}
			})
		}
	},
	"getCityList": function(search,limit,callback,print_user_city)
	{
		callback = callback || function(){};
		print_user_city = print_user_city || "true";
		limit = limit || 3;
		$.ajax({
			type: "POST",
			url: "/get.CityList",
			data: {
				"search": search,
				"limit": limit,
				"print_user_city": print_user_city
			},
			dataType: "JSON",
			success: function (response) {
				callback(response);
			}
		})
	},
	"getSubCategories": function(parent_id,callback)
	{
		callback = callback || function(){};
		$.ajax({
			type: "POST",
			url: "/get.SubCatList",
			data: {
				"parent_id": parent_id
			},
			dataType: "JSON",
			success: function (response) {
				callback(response);
			}
		})
	},
	"im": {
		"lmts": 0,
		"poller": {
			"poller_id_msg": null,
			"poller_id_dlg": null,
			"check_msgs": function(dialog_id,wait)
			{
				clearTimeout(app.im.poller.poller_id_msg);
				var ms = 250;
				app.im.poller.poller_id_msg = setTimeout(function(){
					app.im.getMessages(dialog_id,0,0,app.im.lmts,wait,function(response){
						if ( response.result == "true" )
						{
							if ( response.messages.length > 0 )
							{
								app.im.lmts = response.messages[0].message.timestamp;
								app.im.append_messages(response.messages);
								$.playSound('/sounds/message.ogg');
							}
							app.im.poller.check_msgs(dialog_id,response.wait);
						}
					})
				},ms);
			}
		},
		"getDialogId": function(recipient_id,callback)
		{
			callback = callback || function(){};
			if ( !recipient_id ) return false;
			$.ajax({
				type: "POST",
				url: "/dialog.getDialogId",
				dataType: "JSON",
				data: {
					"recipient_id": recipient_id
				},
				success: function (response) {
					callback(response);
				}
			})
		},
		"getDialogs": function(callback)
		{
			callback = callback || function(){};
			$.ajax({
				type: "POST",
				url: "/dialog.getDialogs",
				dataType: "JSON",
				success: function (response) {
					callback(response);
				}
			})
		},
		"getMessagesAjax": null,
		"getMessages": function(dialog_id,start,limit,timestamp,wait,callback)
		{
			if ( app.im.getMessagesAjax != null ) app.im.getMessagesAjax.abort();
			callback = callback || function(){};
			// if ( timestamp < 1483228800 ) return;
			start = start || 0;
			limit = limit || 50;
			setTimeout(function(){
				app.im.getMessagesAjax = $.ajax({
					type: "POST",
					url: "/dialog.getMessages",
					data: {
						"dialog_id": dialog_id,
						"start": start,
						"limit": limit,
						"timestamp": timestamp,
						"wait": wait
					},
					dataType: "JSON",
					success: function (response) {
						callback(response);
					}
				})
			},250);
		},
		"sendMessage": function(dialog_id,message_text,callback)
		{
			callback = callback || function(){};
			if ( dialog_id.length < 32 ) return;
			if ( app.im.getMessagesAjax != null ) app.im.getMessagesAjax.abort();
			clearTimeout(app.im.poller.poller_id_msg);
			setTimeout(function(){
				$.ajax({
					type: "POST",
					url: "/dialog.sendMessage",
					data: {
						"dialog_id": dialog_id,
						"message_text": message_text
					},
					dataType: "JSON",
					success: function (response) {
						callback(response);
					}
				})
			},250)
		},
		"append_messages": function(messages)
		{
			if ( messages.length == 0 ) return;
			$.each(messages,function(){
				$(".conversation-messages").append(app.formatter.format_message(this));
			});
			var d = $('#conversation-messages');
			setTimeout(function(){
				d.scrollTop(d.prop("scrollHeight"));
			},250);
		}
	},
	"portfolio": {
		"gallery": null,
		"getList": function(callback)
		{
			callback = callback || function(){};
			$.ajax({
				type: "POST",
				url: "/get.PortfolioList",
				dataType: "JSON",
				data: {
					"user_id": config.profile.user_id
				},
				success: function (response) {
					callback(response);
				}
			})
		},
		"showPortfolio": function(portfolio_id,callback)
		{
			if ( parseInt(portfolio_id) <= 0 ) return;
			callback = callback || function(){};
			$.ajax({
				type: "POST",
				url: "/get.Portfolio",
				dataType: "JSON",
				data: {
					"portfolio_id": portfolio_id
				},
				success: function (response) {
					callback(response);
				}
			})
		},
		"hide": function()
		{
			$("#portfolio_single").fadeOut();
		},
		"delete": function(portfolio_id,callback)
		{
			if ( parseInt(portfolio_id) <= 0 ) return;
			callback = callback || function(){};
			$.ajax({
				type: "POST",
				url: "/portfolio/delete",
				dataType: "JSON",
				data: {
					"portfolio_id": portfolio_id
				},
				success: function (response) {
					callback(response);
				}
			})
		},
		"changeCover": function(portfolio_id,attach_id,action,callback)
		{
			if ( parseInt(portfolio_id) <= 0 || parseInt(attach_id) <= 0 ) return;
			callback = callback || function(){};
			$.ajax({
				type: "POST",
				url: "/portfolio/update_cover",
				dataType: "JSON",
				data: {
					"portfolio_id": portfolio_id,
					"attach_id": attach_id,
					"action": action,
				},
				success: function (response) {
					callback(response);
				}
			})
		},
		"deleteAttach": function(attach_id,type,callback)
		{
			if ( attach_id.length != 32 ) return;
			type = type || "image";
			callback = callback || function(){};
			$.ajax({
				type: "POST",
				url: "/portfolio/delete_attach",
				dataType: "JSON",
				data: {
					"attach_id": attach_id,
					"type": type
				},
				success: function (response) {
					callback(response);
				}
			})
		},
	},
	"scenario": {
		"getList": function(callback)
		{
			callback = callback || function(){};
			$.ajax({
				type: "POST",
				url: "/get.ScenarioList",
				dataType: "JSON",
				success: function (response) {
					callback(response);
				}
			})
		},
		"start": function()
		{
			var card = $(".scenario-card.show"),
					scenario_id = $(card).data("scenario_id"),
					subcats = [],
					title = $("input[data-name='title']").val(),
					budget = $("input[data-name='budget']").val(),
					timestamp_start = $("input[data-name='start_end']").data("timestamp_start"),
					timestamp_end = $("input[data-name='start_end']").data("timestamp_end");
			$.each($(".scenario-subcategory[data-scenario_id='"+scenario_id+"']"),function(i,li){
				if ( $(li).hasClass("selected") ) subcats.push($(li).data("subcat_id"));
			})
			$.ajax({
				type: "POST",
				url: "/pp/scenarios",
				dataType: "JSON",
				data: {
					"action": "create_event",
					"title": title,
					"budget": budget,
					"timestamp_start": timestamp_start,
					"timestamp_end": timestamp_end,
					"scenario_id": scenario_id,
					"subcats": subcats
				},
				success: function (response) {
					if ( response.result == "false" )
					{
						showAlert("danger",response.message);
						return;
					}
					else
					{
						$("#event-create").hide();
						show_event(response.event_id);
						setCookie('last_event_id',response.event_id);
					}
				}
			})
		},
		"getEventInfo": function(event_id, callback)
		{
			callback = callback || function(){};
			$.ajax({
				type: "POST",
				url: "/get.ScenarioEventInfo",
				dataType: "JSON",
				data: {
					"event_id": event_id
				},
				success: function (response) {
					callback(response);
				}
			})
		},
		"moveToArchive": function(event_id, callback)
		{
			callback = callback || function(){};
			$.ajax({
				type: "POST",
				url: "/pp/scenarios",
				dataType: "JSON",
				data: {
					"action": "archive_event",
					"event_id": event_id
				},
				success: function (response) {
					callback(response);
				}
			})
		},
	},
	"formatter": {
		"format_dialog": function(data)
		{
			var message_time = ( (moment().format("X") - data.timestamp) > 86400 ) ? moment.unix(data.timestamp).calendar() : moment.unix(data.timestamp).calendar(),
					dialog_class = ( data.unreaded > 0 ) ? 'unreaded' : '',
					unreaded_row = ( data.unreaded > 0 ) ? '<div class="col text-right text-purple strong text-roboto-cond" style="max-width: 45px;">+'+data.unreaded+'</div>' : '';
			var dialog = ''
				+'<div class="row">'
				+'	<div class="col">'
				+'		<div class="dialog '+dialog_class+'" data-dialog_id="'+data.dialog_id+'">'
				// +'			<div class="col" style="max-width: 80px;"><img class="rounded-circle shadow" src="'+data.dialog_avatar_path+'" /></div>'
				+'			<div class="col" style="max-width: 80px;">'+data.dialog_avatar_path+'</div>'
				+'			<div class="col">'
				+'				<h6 class="text-purple">'+data.dialog_title+'</h6>'
				+'				<text class="text-truncate" style="max-width: 350px;">'+data.last_message_text+'</text>'
				+'			</div>'
				+'			'+unreaded_row
				+'			<div class="col text-right text-muted" style="max-width: 180px;">'+message_time+'</div>'
				+'		</div>'
				+'	</div>'
				+'</div>';
			return dialog;
		},
		"format_message": function(data)
		{
			var msg_time_title = moment.unix(data.message.timestamp).format("LLL");
			if ( (parseInt(moment().format("X")) - data.message.timestamp) > 86400 )
			{
				var msg_time = moment.unix(data.message.timestamp).calendar();
			}
			else
			{
				var msg_time = moment.unix(data.message.timestamp).fromNow();
			}
			var message = ''
			+'<div class="row">'
			+'	<div class="message">'
			+'	<div class="col" style="max-width: 80px;">'
			+'		<a href="/profile/id'+data.user.id+'#projects" class="wdo-link"><img class="rounded-circle shadow" src="'+data.user.avatar_path+'&w=50&h=50" /></a>'
			+'	</div>'
			+'	<div class="col">'
			+'		<span class="pull-right" title="'+msg_time_title+'">'+msg_time+'</span>'
			+'		<h6><a href="/profile/id'+data.user.id+'" class="wdo-link text-purple">'+data.user.real_user_name+'</a></h6>'
			+'		<text style="white-space: pre;">'+data.message.text+'</text>'
			+'	</div>'
			+'	</div>'
			+'</div>';
			return message;
		},
		"format_portfolio_preview": function(data)
		{
			var card = ''
			+'<div class="card">'
			+'	<a class="wdo-link" href="#portfolio" data-toggle="show-portfolio" data-portfolio_id="'+data.portfolio_id+'">'
			+'		<img class="card-img-top img-fluid" src="/get.Attach?attach_id='+data.cover_id+'&w=230&h=500" alt="'+data.title+'">'
			+'	</a>'
			+'	<div class="card-block">'
			+'		<h5 class="card-title">'
			+'			<a class="wdo-link text-purple" href="#portfolio" data-toggle="show-portfolio" data-portfolio_id="'+data.portfolio_id+'">'+data.title+'</a>'
			+'		</h5>'
			+'	</div>'
			+'	<div class="card-footer">'
			+'		<span class="pull-right text-yellow"><i class="fa fa-eye"></i> '+data.views+'</span>'
			+'		<small><a class="wdo-link text-muted" href="/projects/'+data.cat_name_translated+'/">'+data.cat_name+'</a> / <a class="wdo-link text-muted" href="/projects/'+data.cat_name_translated+'/'+data.subcat_name_translated+'/">'+data.subcat_name+'</a></small>'
			+'	</div>'
			+'</div>';
			return card;
		},
		"format_portfolio_attach": function(file,is_cover)
		{
			if ( file.error )
			{
				showAlert("error",file.error);
				return;
			}
			// console.log("formatting:",file);
			if ( file.attach_type == 'image' )
			{
				object = ''
				+'<a class="wdo-link" href="/get.Attach?attach_id='+file.attach_id+'&w=800&h=800">'
				+'	<img style="height: 100px; margin-bottom: 0.2rem;" class="img-thumbnail" src="/get.Attach?attach_id='+file.attach_id+'&w=150&h=150&force_resize=true" data-is_cover="'+is_cover+'" data-attach_id="'+file.attach_id+'"/>'
				+'</a>'
			}
			else if ( file.attach_type == 'video' )
			{
				object = ''
				+'<a class="wdo-link" href="'+file.url+'" title="" type="text/html" data-youtube="'+file.youtube_id+'" poster="http://img.youtube.com/vi/'+file.youtube_id+'/0.jpg">'
				+'	<img style="height: 100px; margin-bottom: 0.2rem;" class="img-thumbnail" src="http://img.youtube.com/vi/'+file.youtube_id+'/0.jpg" data-attach_id="'+file.attach_id+'"/>'
				+'</a>'
			}
			else if ( file.attach_type == 'document' )
			{
				object = ''
				+'<a class="wdo-link download" href="/get.Attach?attach_id='+file.attach_id+'">'
				+'	<img style="height: 50px; margin-bottom: 0.2rem;" class="img-thumbnail" src="/images/document.png" /> ' + file.file_title + '<br />'
				+'</a>'
			}
			return object;
		},
		"format_pf_edit_attach": function(file)
		{
			if ( file.error )
			{
				showAlert("error",file.error);
				return;
			}
			// console.log("formatting:",file);
			if ( file.attach_type == 'image' )
			{
				object = ''
				+'<div class="project-upload-attach" data-filename="'+file.name+'" alt="'+file.file_title+'">'
				+'	<a class="wdo-link" href="/get.Attach?attach_id='+file.attach_id+'&w=800&h=800">'
				+'		<img style="height: 80px;" class="img-thumbnail" src="/get.Attach?attach_id='+file.attach_id+'&w=150&h=150&force_resize=true" data-attach_id="'+file.attach_id+'"/>'
				+'	</a>'
				+'	<br /><a href="'+file.deleteUrl+'" data-filename="'+file.attach_id+'" data-attach_type="'+file.attach_type+'" data-attach_id="'+file.attach_id+'" class="delete" data-deleteType="'+file.deleteType+'">Удалить</a>'
				+'</div>';
			}
			else if ( file.attach_type == 'video' )
			{
				object = ''
				+'<div class="project-upload-attach" data-filename="'+file.name+'" alt="'+file.file_title+'">'
				+'	<a class="wdo-link" href="'+file.url+'" title="" type="text/html" data-youtube="'+file.youtube_id+'" poster="http://img.youtube.com/vi/'+file.youtube_id+'/0.jpg">'
				+'		<img style="height: 80px;" class="img-thumbnail" src="http://img.youtube.com/vi/'+file.youtube_id+'/0.jpg" data-attach_id="'+file.attach_id+'"/>'
				+'	</a>'
				+'	<br /><a href="'+file.deleteUrl+'" data-filename="'+file.attach_id+'" data-attach_type="'+file.attach_type+'" data-attach_id="'+file.attach_id+'" class="delete" data-deleteType="'+file.deleteType+'">Удалить</a>'
				+'</div>';
			}
			else if ( file.attach_type == 'document' )
			{
				object = ''
				+'<div class="project-upload-attach" data-filename="'+file.name+'" alt="'+file.file_title+'">'
				+'	<a class="wdo-link download" href="/get.Attach?attach_id='+file.attach_id+'">'
				+'		<img style="height: 80px;" class="img-thumbnail" src="/images/document.png" />'
				+'	</a>'
				+'	<br />'+file.file_title+'<br /><a href="'+file.deleteUrl+'" data-filename="'+file.attach_id+'" data-attach_type="'+file.attach_type+'" data-attach_id="'+file.attach_id+'" class="delete" data-deleteType="'+file.deleteType+'" href="">Удалить</a>'
				+'</div>';
			}
			else if ( /image/.test(file.type) )
			{
				if ( !file.thumbnailUrl ) return;
				object = ''
				+'<div class="project-upload-attach" data-filename="'+file.name+'" alt="'+file.name+'">'
				+'	<a class="wdo-link" href="'+file.url+'">'
				+'		<img style="height: 80px;" class="img-thumbnail" src="'+file.thumbnailUrl+'" />'
				+'	</a>'
				+'	<br /><a href="'+file.deleteUrl+'" data-filename="'+file.name+'" class="delete" data-deleteType="'+file.deleteType+'">Удалить</a>'
				+'</div>';
			}
			else
			{
				object = ''
				+'<div class="project-upload-attach just_uploaded" data-filename="'+file.name+'" alt="'+file.name+'">'
				+'	<a class="wdo-link download" href="'+file.url+'">'
				+'		<img style="height: 80px;" class="img-thumbnail" src="/images/document.png" />'
				+'	</a>'
				+'	<br />'+file.name+'<br /><a data-filename="'+file.name+'" href="'+file.deleteUrl+'" data-attach_id="'+file.attach_id+'" class="delete" data-deleteType="'+file.deleteType+'" href="">Удалить</a>'
				+'</div>';
			}
			return object;
		},
		"format_scenario_col": function(data)
		{
			var col = ''
			+'<div class="col-sm-12">'
			+'	<div class="card scenario-card" data-scenario_id="'+data.scenario_id+'">'
			+'		<h5 class="card-header scenario-header" data-scenario_id="'+data.scenario_id+'" onClick="showScenarioDetails(this);">'
			+'			<span class="pull-right"><i class="fa fa-arrow-circle-o-up text-muted" aria-hidden="true"></i></span>'
			+'			'+data.scenario_name+''
			+'		</h5>'
			+'		<div class="card-block">'
			+'			<small class="text-purple-dark">Для проведения этого мероприятия вам потребуется создать проект в следующих разделах:</small>'
			+'			<hr />'
			+'			<ul class="list-group">';
			$.each(data.scenario_subcats,function(i,ss){
				var li = ''
			+'				<li class="small list-group-item justify-content-between scenario-subcategory" data-scenario_id="'+data.scenario_id+'" data-subcat_id="'+ss.subcat_id+'">'
			+'					<label class="custom-control custom-radio custom-radio">'
			+'						<input name="radio-c-'+data.scenario_id+'-'+ss.subcat_id+'" type="radio" class="custom-control-input">'
			+'						<span class="custom-control-indicator"></span>'
			+'						<span class="custom-control-description">'+ss.subcat_name+'</span>'
			+'					</label>'
			+'				</li>';
				col += li;
			});
			col += ''
			+'			</ul>'
			+'			<hr />'
			+'			<div class="wdo-btn btn-sm bg-purple" onClick="app.scenario.start()">Старт</div>'
			+'		</div>'
			+'	</div>'
			+'</div>'
			return col;
		},
		"format_scenario_created_project": function(data)
		{
			var profile_link = ( data.performer.user_id > 0 ) 
			? '<a class="wdo-link" href="/profile/id'+data.performer.user_id+'">'+data.performer.real_user_name+'</a>' 
			: data.performer.real_user_name;
			var html = ''
			+'<div class="row event-project" data-project_id="'+data.project_id+'">'
			+'	<div class="col event-project-title">'
			+'		<a class="wdo-link underline" href="'+data.project_link+'">'+data.subcat_name+'</a>'
			+'	</div>'
			+'	<div class="col event-project-cost">'
			+'		'+data.cost_formatted+' р.'
			+'	</div>'
			+'	<div class="col event-project-performer">'
			+'		'+profile_link
			+'	</div>'
			+'	<div class="col event-add-chat">'
			+'		<a title="Добавить исполнителя в общий чат" onClick="addToEventDialog('+data.performer.user_id+')" class="wdo-link">+ <i class="fa fa-comments"></i></a>'
			+'	</div>'
			+'	<div class="col event-project-status">'
			+'		'+data.status_name+''
			+'	</div>'
			+'</div>'
			return html;
		},
		"format_scenario_projects_to_create": function(data)
		{
			var event_id = $(".event_id").data('event_id'),
					link = '/project/add?event_id='+event_id+'&subcat_id='+data.subcat_id,
					html = ''
			+'<div class="row">'
			+'	<div class="col">'
			+'		<a class="wdo-link underline" href="'+link+'">'+data.subcat_name+'</a>'
			+'	</div>'
			+'</div>';
			return html;
		},
		"format_transaction_info": function(data)
		{
			var child_row = ''
			+'<table cellpadding="3" cellspacing="0" border="0" style="padding-left:50px; min-width: 100%;">'
			+'	<tr>'
			+'		<td>'
			+'			Сумма:'
			+'		</td>'
			+'		<td>'
			+'			<span class="pull-right">'+data.amount+'</span>'
			+'		</td>'
			+'	</tr>';
			if ( data.project_title != "" )
			{
				child_row += ''
				+'	<tr>'
				+'		<td>'
				+'			Проект:'
				+'		</td>'
				+'		<td>'
				+'			<span class="pull-right"><a class="wdo-link underline" href="'+data.project_link+'" target="_blank">'+data.project_title+'</a></span>'
				+'		</td>'
				+'	</tr>';
			}
			child_row += '</table>';
			return child_row;
		},
		"format_warning_info": function(data)
		{
			var child_row = ''
			+'<table cellpadding="2" cellspacing="0" border="0" style="padding-left:50px; min-width: 100%;">'
			+'	<tr>'
			+'		<td>'
			+'			Проект:'
			+'		</td>'
			+'		<td>'
			+'			<span class="pull-right"><a href="'+data.project_link+'">'+data.subject_title+'</a></span>'
			+'		</td>'
			+'	</tr>';
			child_row += '</table>';
			return child_row;
		}
	}
}

try {
	var settings = JSON.parse(getCookie("config.projects.table"));
	config.projects.table = settings;
} catch (error) {}
try {
	var specs = JSON.parse(getCookie("config.projects.specs"));
	config.projects.specs = specs;
} catch (error) {}

$(function(){
})