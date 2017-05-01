var current_date = new Date;

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
	"profile":
	{
		"user_id": 0,
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
		"updateProfileCounters": function() {
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
		"getNote": function(user_id,callback) {
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
		"saveNote": function(user_id,note_text,callback) {
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
		"getProfileInfo": function(user_id,callback) {
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
		"updateProfileInfo": function(data,callback) {
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
		"getCalendar": function(user_id,callback) {
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
		"saveCalendar": function(dates,callback) {
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
	"getCityList": function(search,limit,callback){
			callback = callback || function(){};
			limit = limit || 3;
			$.ajax({
				type: "POST",
				url: "/get.cityList",
				data: {
					"search": search,
					"limit": limit,
					"print_user_city": "true"
				},
				dataType: "JSON",
				success: function (response) {
					callback(response);
				}
			})
	},
	"getSubCategories": function(parent_id,callback){
			callback = callback || function(){};
			$.ajax({
				type: "POST",
				url: "/get.subCatList",
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
			"poller_id": null,
			"start": function(dialog_id,wait) {
				clearTimeout(app.im.poller.poller_id);
				var ms = 250;
				app.im.poller.poller_id = setTimeout(function(){
					app.im.getMessages(dialog_id,0,0,app.im.lmts,wait,function(response){
						if ( response.result == "true" )
						{
							if ( response.messages.length > 0 )
							{
								app.im.lmts = response.messages[0].message.timestamp;
								app.im.append_messages(response.messages);
							}
							app.im.poller.start(dialog_id,response.wait);
						}
					})
				},ms);

			}
		},
		"getDialogId": function(recipient_id,callback) {
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
		"getDialogs": function(callback) {
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
		"getMessages": function(dialog_id,start,limit,timestamp,wait,callback) {
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
		"sendMessage": function(dialog_id,message_text,callback) {
			callback = callback || function(){};
			if ( dialog_id.length < 32 ) return;
			if ( app.im.getMessagesAjax != null ) app.im.getMessagesAjax.abort();
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
		"format_dialog": function(data)
		{
			var message_time = ( (moment().format("X") - data.timestamp) > 86400 ) ? moment.unix(data.timestamp).calendar() : moment.unix(data.timestamp).calendar(),
					dialog_class = ( data.unreaded > 0 ) ? 'unreaded' : '',
					unreaded_row = ( data.unreaded > 0 ) ? '<div class="col text-right text-purple strong text-roboto-cond" style="max-width: 45px;">+'+data.unreaded+'</div>' : '';
			var dialog = ''
				+'<div class="row">'
				+'	<div class="col">'
				+'		<div class="dialog '+dialog_class+'" data-dialog_id="'+data.dialog_id+'">'
				+'			<div class="col" style="max-width: 80px;"><img class="rounded-circle shadow" src="'+data.dialog_avatar_path+'&w=50&h=50" /></div>'
				+'			<div class="col">'
				+'				<h6 class="text-purple">'+data.real_user_name+'</h6>'
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
			var message = ''
			+'<div class="row">'
			+'	<div class="message">'
			+'	<div class="col" style="max-width: 80px;">'
			+'		<a href="/profile/id'+data.user.id+'" class="wdo-link"><img class="rounded-circle shadow" src="'+data.user.avatar_path+'&w=50&h=50" /></a>'
			+'	</div>'
			+'	<div class="col">'
			+'		<span class="pull-right">'+moment.unix(data.message.timestamp).calendar()+'</span>'
			+'		<h6><a href="/profile/id'+data.user.id+'" class="wdo-link text-purple">'+data.user.real_user_name+'</a></h6>'
			+'		<text>'+data.message.text+'</text>'
			+'	</div>'
			+'	</div>'
			+'</div>';
			return message;
		},
		"append_messages": function(messages)
		{
			if ( messages.length == 0 ) return;
			$.each(messages,function(){
				$(".conversation-messages").append(app.im.format_message(this));
			});
			var d = $('#conversation-messages');
			setTimeout(function(){
				d.scrollTop(d.prop("scrollHeight"));
			},250);
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

moment.locale("ru");
