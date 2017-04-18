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
	}
};

var app = {
	"user": {
		"userName": null,
		"userNote": null,
		"getUserName": function(user_id,callback) {
			app.user.userName = null;
			callback = callback || false;
			$.ajax({
				type: "POST",
				url: "/user.getUserName",
				data: {
					"user_id": user_id
				},
				dataType: "JSON",
				success: function (response) {
					if ( response.result == "true" )
					{
						app.user.userName = response.userName;
						if ( callback ) callback.call();
					}
				}
			})
		},
		"getUserNote": function(user_id,callback,error_callback) {
			app.user.userNote = null;
			callback = callback || false;
			error_callback = error_callback || false;
			$.ajax({
				type: "POST",
				url: "/user.getUserNote",
				data: {
					"user_id": user_id
				},
				dataType: "JSON",
				success: function (response) {
					if ( response.result == "true" )
					{
						app.user.userNote = response.userNote;
						if ( callback ) callback.call();
						return;
					}
					if ( error_callback ) error_callback(response);
				}
			})
		},
		"addNote": function(user_id,note_text,callback,error_callback) {
			callback = callback || false;
			error_callback = error_callback || false;
			$.ajax({
				type: "POST",
				url: "/user.addNote",
				data: {
					"user_id": user_id,
					"note_text": note_text
				},
				dataType: "JSON",
				success: function (response) {
					if ( response.result == "true" )
					{
						if ( callback ) callback.call();
						return;
					}
					if ( error_callback ) error_callback(response);
				}
			})
		},
		"sendMessage": function(user_id,message_text,callback) {
			callback = callback || false;
			$.ajax({
				type: "POST",
				url: "/user.sendMessage",
				data: {
					"user_id": user_id,
					"message_text": message_text
				},
				dataType: "JSON",
				success: function (response) {
					if ( response.result == "true" )
					{
						callback.call();
					}
				}
			})
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
