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
		"user_id": 0
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
	"datePickerOptionsBirthday": {
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
							updateProfileCounter(key,value);
						})
					}
				}
			})
		},
		"getName": function(user_id,callback) {
			callback = callback || function(){};
			$.ajax({
				type: "POST",
				url: "/user.getName",
				data: {
					"user_id": user_id
				},
				dataType: "JSON",
				success: function (response) {
					callback(response);
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
		"sendMessage": function(user_id,message_text,callback) {
			callback = callback || function(){};
			$.ajax({
				type: "POST",
				url: "/user.sendMessage",
				data: {
					"user_id": user_id,
					"message_text": message_text
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
