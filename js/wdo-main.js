var config = {
	"city_id": getCookie("city_id") || 1,
	"projects":
	{
		"dt": null,
		"table": {
			"length": 10,
			"state": {},
		},
		"calendar": null
	},
	datePickerOptions: {
		ranges:{
			"Сегодня": [new Date,new Date],
			"След. 3 дня": [new Date,moment().add(3,"days")],
			"След. 7 дней": [new Date,moment().add(6,"days")],
			"След. 30 дней": [new Date,moment().add(30,"days")],
			"След. 6 месяцев": [new Date,moment().add(6,"months")],
		},
		opens:"left",
		locale:{
			format:"YYYY-MM-DD",
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
		startDate: moment().startOf("day").format("YYYY-MM-DD"),
		endDate: moment().add(6,"days").format("YYYY-MM-DD"),
		alwaysShowCalendars: true,
		showCustomRangeLabel: false,
	}
}
moment.locale("ru");

