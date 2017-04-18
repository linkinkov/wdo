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
		"getUserName": function(user_id,callback) {
			app.user.userName = null;
			callback = callback || false;
			$.ajax({
				type: "POST",
				url: "/get.getUserName",
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
		"sendMessage": function(user_id,message_text,input,btn) {
			set_btn_state(btn,"loading","Отправка...");
			$.ajax({
				type: "POST",
				url: "/user/sendMessage",
				data: {
					"user_id": user_id,
					"message_text": message_text
				},
				dataType: "JSON",
				success: function (response) {
					if ( response.result == "true" )
					{
						console.log(response);
					}
					set_btn_state(btn,"reset","Отправить");
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
