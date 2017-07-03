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

var conf = {
	"projects": {
		"table": null,
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
	im: {
		"poller":
		{
			"poller_id_msg": null,
			"poller_id_dlg": null,
			// "check_msgs": function(dialog_id,wait)
			// {
			// 	clearTimeout(app.im.poller.poller_id_msg);
			// 	var ms = 250;
			// 	app.im.poller.poller_id_msg = setTimeout(function(){
			// 		app.im.getMessages(dialog_id,0,0,app.im.lmts,wait,function(response){
			// 			if ( response.result == "true" )
			// 			{
			// 				if ( response.messages.length > 0 )
			// 				{
			// 					app.im.lmts = response.messages[0].message.timestamp;
			// 					app.im.append_messages(response.messages);
			// 					$.playSound('/sounds/message.ogg');
			// 				}
			// 				app.im.poller.check_msgs(dialog_id,response.wait);
			// 			}
			// 		})
			// 	},ms);
			// }
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
	}
}


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
			set_btn_state(submit_btn,"reset");
			$(modal).find("a[name='real_user_name']").attr("href","/profile/id"+recipient_id).text(real_user_name);
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

$('#warn-user-modal').on('show.bs.modal', function(e){
	var related = e.relatedTarget,
			recipient_id = $(related).data('recipient_id'),
			real_user_name = $(related).data('real_user_name'),
			project_title = $(related).data('project_title'),
			block_type = $(related).data('block_type'),
			modal = e.delegateTarget,
			submit_btn = $(modal).find("[data-trigger='send-message']");
	$(modal).find("img[name='userAvatar']").attr("src","/user.getAvatar?user_id="+recipient_id+"&w=35&h=35");
	$(modal).find("a[name='real_user_name']").attr("href","/profile/id"+recipient_id).text(real_user_name);
	$(modal).find("text[name='project_title']").text(project_title);
	( block_type == "project") ? $("#warn-user-modal-label").text("Заблокировать проект") : $("#warn-user-modal-label").text("Заблокировать пользователя");
	
})
$('#warn-user-modal').on('hidden.bs.modal', function(e){
	var modal = modal = e.delegateTarget;
	$(modal).find("textarea").data('dialog_id',0).attr('data-dialog_id',0);
})


$(function(){
	var hash = window.location.hash || "#projects";
	if ( hash ) loadPage(hash);
})