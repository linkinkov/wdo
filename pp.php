<?php
require_once('_global.php');
include_once('_includes.php');
require_once(PD.'/lib/Resize.class.php');
require_once(PD.'/lib/Avatar.class.php');
require_once(PD.'/lib/Attach.class.php');
$db = db::getInstance();
$current_user = new User($_SESSION["user_id"]);
$job = get_var("job","string",false);
$user_id = get_var("user_id","int",$current_user->user_id);

if ( !$job ) echo "no data";

$user = new User($user_id);

if ( $job == "profile" )
{
	if ( $current_user->user_id != $user_id )
	{
		// exit("Access error");
		// header("Location: /",true,301);
		header('HTTP/1.0 401 Unauthorized',true,401);
	}
	?>
	<div class="row">
		<div class="col">
			<h3 class="text-purple">Общая информация</h3>
		</div>
	</div>
	<div class="row"><div class="col"><hr /></div></div>

	<div class="row">
		<div class="col" style="flex: 0 0 180px; max-width: 180px; align-self: center;">
			<text class="text-muted">Учетная запись</text>
		</div>
		<div class="col type_id-container">
			<label class="custom-control custom-radio custom-radio-type_id" data-name="type_id" data-value="1">
				<input name="type_id" type="radio" data-name="type_id" class="custom-control-input profile-data" data-value="1">
				<span class="custom-control-indicator"></span>
				<span class="custom-control-description">Юридическое лицо</span>
			</label>
			<label class="custom-control custom-radio custom-radio-type_id" data-name="type_id" data-value="2">
				<input name="type_id" type="radio" data-name="type_id" class="custom-control-input profile-data" data-value="2">
				<span class="custom-control-indicator"></span>
				<span class="custom-control-description">Физическое лицо</span>
			</label>
		</div>
	</div>

	<div class="row"><div class="col"><hr /></div></div>
	<div class="row as_performer-container">
		<div class="col" style="align-self: center;">
			<label class="custom-control custom-checkbox custom-checkbox-as_performer">
				<input type="checkbox" class="custom-control-input profile-data" id="as_performer_checkbox" data-name="as_performer" data-value="0">
				<span class="custom-control-indicator"></span>
				<span class="custom-control-description">
					<h6 class="text-purple">Я исполнитель</h6>
					<p class="text-muted">Если Вы хотите быть в списке исполнителей, то Вам необходимо создать хотя-бы одно портфолио в соответствующей категории</p>
				</span>
			</label>
		</div>
	</div>

	<div class="row"><div class="col"><hr /></div></div>
	<div class="row last_name-container">
		<div class="col" style="flex: 0 0 180px; max-width: 180px; align-self: center;">
			ФИО
		</div>
		<div class="col">
			<input type="text" class="form-control profile-data" data-name="last_name" placeholder="Фамилия" />
		</div>
		<div class="col">
			<input type="text" class="form-control profile-data" data-name="first_name" placeholder="Имя" />
		</div>
	</div>

	<div class="row"><div class="col"><hr /></div></div>
	<div class="row company_name-container">
		<div class="col" style="flex: 0 0 180px; max-width: 180px; align-self: center;">
			Название компании
		</div>
		<div class="col">
			<input type="text" class="form-control profile-data" data-name="company_name" placeholder="Название компании" />
		</div>
	</div>

	<div class="row"><div class="col"><hr /></div></div>
	<div class="row avatar-container">
		<div class="col" style="flex: 0 0 180px; max-width: 180px; align-self: center;">
			Фото
		</div>
		<div class="col text-center">
			<img class="rounded-circle" data-name="avatar" src="" />
		</div>
		<div class="col text-justify" style="align-self: center;">
			<p><a class="wdo-link underline" href="">Сменить фото</a></p>
			<p><a class="wdo-link underline" href="">Удалить фото</a></p>
			<p class="text-muted"><small>Не менее 150x150px<br />Не более 1500x1500px</small></p>
		</div>
	</div>

	<div class="row"><div class="col"><hr /></div></div>
	<div class="row birthday-container">
		<div class="col" style="flex: 0 0 180px; max-width: 180px; align-self: center;">
			Дата рождения
		</div>
		<div class="col">
			<input type="text" class="form-control profile-data" data-name="birthday" placeholder="ДД/ММ/ГГГГ" />
		</div>
	</div>

	<div class="row"><div class="col"><hr /></div></div>
	<div class="row signature-container">
		<div class="col" style="flex: 0 0 180px; max-width: 180px; align-self: center;">
			Подпись
		</div>
		<div class="col">
			<input type="text" class="form-control profile-data" data-name="signature" placeholder="Подпись, не более 140 знаков" />
		</div>
	</div>

	<div class="row"><div class="col"><hr /></div></div>
	<div class="row country_id-container">
		<div class="col" style="flex: 0 0 180px; max-width: 180px; align-self: center;">
			Страна
		</div>
		<div class="col">
			<div class="btn-group" style="width: 100%;">
				<button type="button" class="btn btn-secondary" style="text-align: left;width: 100%;" data-toggle="dropdown" data-name="country_id">Россия</button>
				<button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="flex: 0 1 30px;"></button>
				<div class="dropdown-menu" style="width: 100%;">
					<a class="dropdown-item wdo-option profile-data" data-name="country_id" data-value="1">Россия</a>
					<a class="dropdown-item wdo-option profile-data" data-name="country_id" data-value="2">Беларусь</a>
				</div>
			</div>
		</div>
	</div>

	<div class="row"><div class="col"><hr /></div></div>
	<div class="row city_id-container">
		<div class="col" style="flex: 0 0 180px; max-width: 180px; align-self: center;">
			Город
		</div>
		<div class="col">
			<div class="btn-group" style="width: 100%;">
				<button type="button" class="btn btn-secondary" style="text-align: left;width: 100%;" data-toggle="dropdown" data-name="city_id"></button>
				<button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="flex: 0 1 30px;"></button>
				<div class="dropdown-menu city-list" style="width: 100%;">
					<a class="dropdown-item wdo-option"><input type="text" class="form-control city-filter" placeholder="Поиск"></a>
					<?php echo sprintf('<a class="dropdown-item wdo-option profile-data" data-name="city_id" data-value="%d">%s</a>',$user->city_id,$user->city_name);?>
				</div>
			</div>
		</div>
	</div>

	<div class="row"><div class="col"><hr /></div></div>
	<div class="row rezume-container">
		<div class="col" style="flex: 0 0 180px; max-width: 180px; align-self: center;">
			Резюме
		</div>
		<div class="col">
			<textarea class="form-control profile-data" rows="10" data-name="rezume" placeholder="Несколько слов о себе"></textarea>
		</div>
	</div>

	<div class="row"><div class="col"><hr /></div></div>
	<div class="row">
		<div class="col">
			<h3 class="text-purple">Контактные данные</h3>
		</div>
	</div>

	<div class="row"><div class="col"><hr /></div></div>
	<div class="row phone-container">
		<div class="col" style="flex: 0 0 180px; max-width: 180px; align-self: center;">
			<i class="fa fa-mobile fa-fw"></i> Телефон
		</div>
		<div class="col">
			<input type="text" class="form-control profile-data" data-name="phone" placeholder="Телефон" />
		</div>
	</div>

	<div class="row"><div class="col"><hr /></div></div>
	<div class="row phone-container">
		<div class="col" style="flex: 0 0 180px; max-width: 180px; align-self: center;">
			<i class="fa fa-skype fa-fw"></i> Skype
		</div>
		<div class="col">
			<input type="text" class="form-control profile-data" data-name="skype" placeholder="Skype" />
		</div>
	</div>

	<div class="row"><div class="col"><hr /></div></div>
	<div class="row site-container">
		<div class="col" style="flex: 0 0 180px; max-width: 180px; align-self: center;">
			<i class="fa fa-home fa-fw"></i> Сайт
		</div>
		<div class="col">
			<input type="text" class="form-control profile-data" data-name="site" placeholder="http://www.example.com/" />
		</div>
	</div>


	<div class="rekvizity-container" style="display: none;">
		<div class="row"><div class="col"><hr /></div></div>
		<div class="row">
			<div class="col">
				<h3 class="text-purple">Реквизиты индивидуального предпринимателя</h3>
				<small class="text-muted">
					Реквизиты нам потребуются для автоматизированного выставления счетов в случае размещения платных рекламных материалов
				</small>
			</div>
		</div>
		<div class="row"><div class="col"><hr /></div></div>
		<div class="row">
			<div class="col" style="flex: 0 0 180px; max-width: 180px; align-self: center;">Фамилия</div>
			<div class="col"><input type="text" class="form-control profile-data" data-name="rek_last_name" placeholder="Фамилия" /></div>
		</div>
		<div class="row">
			<div class="col" style="flex: 0 0 180px; max-width: 180px; align-self: center;">Имя</div>
			<div class="col"><input type="text" class="form-control profile-data" data-name="rek_first_name" placeholder="Имя" /></div>
		</div>
		<div class="row">
			<div class="col" style="flex: 0 0 180px; max-width: 180px; align-self: center;">Отчество</div>
			<div class="col"><input type="text" class="form-control profile-data" data-name="rek_second_name" placeholder="Отчество" /></div>
		</div>
		<div class="row">
			<div class="col" style="flex: 0 0 180px; max-width: 180px; align-self: center;">ИНН</div>
			<div class="col"><input type="text" class="form-control profile-data" data-name="rek_inn" placeholder="ИНН" /></div>
		</div>
		<div class="row">
			<div class="col" style="flex: 0 0 180px; max-width: 180px; align-self: center;">ОГРНИП</div>
			<div class="col"><input type="text" class="form-control profile-data" data-name="rek_ogrnip" placeholder="ОГРНИП" /></div>
		</div>
		<div class="row">
			<div class="col" style="flex: 0 0 180px; max-width: 180px; align-self: center;">Расч. счёт №</div>
			<div class="col"><input type="text" class="form-control profile-data" data-name="rek_ras_schet" placeholder="Расч. счёт №" /></div>
		</div>
		<div class="row">
			<div class="col" style="flex: 0 0 180px; max-width: 180px; align-self: center;">Корр. счёт №</div>
			<div class="col"><input type="text" class="form-control profile-data" data-name="rek_kor_schet" placeholder="Корр. счёт №" /></div>
		</div>
		<div class="row">
			<div class="col" style="flex: 0 0 180px; max-width: 180px; align-self: center;">БИК</div>
			<div class="col"><input type="text" class="form-control profile-data" data-name="rek_bik" placeholder="БИК" /></div>
		</div>
	</div><!-- /.rekvizity-container -->

	<div class="map-container" style="display: none;">
		<div class="row"><div class="col"><hr /></div></div>
		<div class="row">
			<div class="col">
				<h3 class="text-purple">Местоположение</h3>
			</div>
		</div>
		<div class="row"><div class="col"><hr /></div></div>
		<div class="row">
			<div class="col">
				<div id="map" style="height: 400px;"></div>
			</div>
		</div>
	</div><!-- /.map-container -->

	<div class="row"><div class="col"><hr /></div></div>
	<div class="row">
		<div class="col">
			<div class="wdo-btn bg-purple" id="save_profile_info" data-lt="Сохранение" data-ot="Сохранить" style="width: 50%; margin: 0 auto;">Сохранить</div>
		</div>
	</div>
	<div class="row"><div class="col"><hr /></div></div>

	<script>
	$(function(){
		app.user.getProfileInfo(config.profile.user_id,function(response){
			if ( response.result == "true" )
			{
				$.each(response.user,function(key,value) {
					if ( key == "avatar_path" ) $("img[data-name='avatar']").attr("src",value+"&w=150&h=150");
					else if ( key == "type_id" ) $(".custom-control[data-name='"+key+"'][data-value='"+value+"']").click();
					else if ( key == "birthday" ) $("input[data-name='"+key+"']").val(moment.unix(value).format("DD/MM/YYYY")).data('timestamp',value);
					else if ( key == "country_id" ) $(".wdo-option[data-name='"+key+"'][data-value='"+value+"']").addClass("active").click();
					else if ( key == "city_id" ) $(".wdo-option[data-name='"+key+"'][data-value='"+value+"']").addClass("active").click();
					else if ( key == "rekvizity" ) $.each(value,function(field,val) {$("input[data-name='"+field+"']").val(val);})
					else if ( key == "as_performer" ) { if ( value == 1 ) $(".custom-checkbox-as_performer").click(); }
					else $("[data-name='"+key+"']").val(value);
				})
				$('input[data-name="birthday"]').daterangepicker(config.datePickerOptionsBirthday);
				$('input[data-name="birthday"]').on('apply.daterangepicker', function(ev, picker) {
					$(this).data('timestamp',picker.startDate.format("X"));
				});
			}
		});

		$(".custom-control").click(function(e){
			$(this).find(".custom-control-input").blur();
		})
		$(".custom-radio-type_id").click(function(e){
			if ( $(this).data('value') == 1 )
			{
				$(".last_name-container").hide(); $(".last_name-container").prev().hide();
				$(".company_name-container").show(); $(".company_name-container").prev().show();
				$(".rekvizity-container").show();
			}
			else
			{
				$(".company_name-container").hide(); $(".company_name-container").prev().hide();
				$(".last_name-container").show(); $(".last_name-container").prev().show();
				$(".rekvizity-container").hide();
			}
		})
		$("#as_performer_checkbox").on("change",function(){
			var checked = $(this).prop("checked");
			if ( checked )
			{
				$("#as_performer_checkbox").data('value',1)
				$(".map-container").show(); 
			}
			else
			{
				$("#as_performer_checkbox").data('value',0)
				$(".map-container").hide();
			}
			map.invalidateSize();
		})

		$(".city-filter").keyup(function(e){
			// var search = new RegExp(this.value,'ig');
			var search = this.value;
			if ( search == "" ) {$(".wdo-option[data-name='city_id']").remove();return;}
			app.getCityList(search,function(response){
				if ( response )
				{
					$(".city-list").find("[data-name='city_id']").remove();
					$.each(response,function(){
						$(".city-list").append($.sprintf('<a class="dropdown-item wdo-option profile-data" data-name="city_id" data-value="%d">%s</a>',this.id,this.city_name));
					})
				}
			})
			// $(".wdo-option[data-name='city_id']").each(function(){
			// 	(search.test($(this).text())) ? $(this).show() : $(this).hide();
			// })
		})

		$("#save_profile_info").click(function(){
			var btn = this;
			var profile = {};
			$.each($(".profile-data"),function(){
				var data = $(this).data(),
						name = data.name
						value = $(this).val();
				if ( $(this).attr("type") == "radio" && $(this).prop("checked") )
				{
					value = $(this).data('value');
				}
				else if ( $(this).attr("type") == "checkbox" )
				{
					value = $(this).data('value');
				}
				else if ( $(this).hasClass("wdo-option") )
				{
					value = ( $(this).hasClass("active") ) ? $(this).data('value') : "";
					if ( value == "" ) return;
				}
				else if ( name == "birthday" )
				{
					value = data.timestamp;
					if ( value == "" ) return;
				}
				if ( name == "type_id" && value == "on" ) return;
				profile[name] = value;
			})
			profile["gps"] = myPlaceCoords;
			set_btn_state(btn,"loading");
			app.user.updateProfileInfo(profile,function(response){
				if ( response.result == "true" )
				{
					$(btn).addClass("bg-yellow");
					set_btn_state(btn,"reset",response.message);
				}
				else
				{
					$(btn).addClass("bg-warning");
					set_btn_state(btn,"reset",response.message);
				}
			});
		})

		var myPlaceCoords = '<?php echo str_replace(" ",",",$user->gps);?>';

		ajaxRequest=getXmlHttpObject();
		if (ajaxRequest==null) {
			alert ("This browser does not support HTTP Request");
			return;
		}
		initmap(myPlaceCoords);
		//map.on('moveend', onMapMove);

		map.on("click", function(e){
			removeMarkers();
			var myIcon = L.icon({
				iconSize:    [25, 41],
				iconAnchor:  [12, 41],
				popupAnchor: [1, -34],
				tooltipAnchor: [16, -28],
				shadowSize:  [41, 41]
			});
			var marker = new L.marker(e.latlng);
			markers.addLayer(marker);
			markerList.push(marker);
			map.addLayer(markers);
			myPlaceCoords = e.latlng.lat + ' ' + e.latlng.lng;
		})

		if ( $(".weedo-checkbox[name='asPerformer']").hasClass("checked") )
		{
			$("#map-container").show();
			map.invalidateSize();
		}
		else
		{
			$("#map-container").hide();
			map.invalidateSize();
		}
		$(".loader").remove();
	})
	</script>

<?php
} // end showing profile info

else if ( $job == "projects" )
{
?>

	<table class="table" id="projects-table">
		<thead>
			<th>Наименование</th>
			<th>Бюджет</th>
			<th>Заявки</th>
	<?php
		if ( $current_user->user_id == $user->user_id )
			echo '<th>Исполнитель</th>';
	?>
			<th>Статус</th>
		</thead>
		<tbody>
		</tbody>
	</table>

	<script>
	$(function(){
		var projectsTable = $("#projects-table").DataTable({
			"language": {"url": "/js/dataTables/dataTables.russian.lang"},
			"dom": 'tr<"row"<"col"p>><"row"<"col"i>>',
			"bProcessing": true,
			"bServerSide": true,
			"pagingType": "full_numbers",
			"ajax": {
				"url": "/dt/projects",
				"type": "POST",
				"data": function( d ) {
					d.for_profile = true;
					d.user_id = config.profile.user_id;
					d.status_id = "-1";
				}
			},
			"columns": [
				{"data": "project.title","class":"project-table-title","width":"300px"},
				{"data": "project.cost","class":"project-table-cost"},
				{"data": "bids","class":"project-table-bids"},
		<?php
			if ( $current_user->user_id == $user->user_id )
			echo '{"data": "performer_name","class":"project-table-performer"},';
		?>
				{"data": "project.status_name","name":"status_id","class":"project-table-status"},
			],
			"order": [[0, 'asc']],
			"initComplete": function(table,data) {
			},
			"createdRow": function ( row, data, index ) {
				var title = $.sprintf('<a class="wdo-link word-break" href="%s">%s</a>',data.project_link,data.project.title);
				var category = $.sprintf('<br /><br /><small><text class="text-purple strong">%s</text> / <text title="Был опубликован">%s</text></small>',data.project.cat_name,moment.unix(data.project.created).fromNow());
				var cost = data.project.cost + ' <i class="fa fa-rouble"></i>';
				if ( data.performer_id ) $('td', row).eq(3).html('<a class="wdo-link" href="/profile/id'+data.performer_id+'">'+data.performer_name+'</a>');
				$('td', row).eq(0).html(title+category);
				$('td', row).eq(1).html(cost);
				var extra_title = [];
				if ( data.project.safe_deal == 1 )
				{
					$('td', row).eq(4).addClass('safe-deal');
					extra_title.push("Безопасная сделка");
				}
				if ( data.project.vip == 1 )
				{
					$('td', row).eq(4).attr("title","VIP проект").addClass('vip');
					extra_title.push("VIP проект");
				}
				$('td', row).eq(4).attr("title",extra_title.join("; "))
			},
			"drawCallback": function( settings ) {
				$(".paginate_button > a").on("focus", function() {
					$(this).blur();
				});
			}
		})

		$(".loader").remove();
	})
	</script>
<?php
} // end showing projects

else if ( $job == "project-responds" )
{
?>

<table class="table" id="projects-table">
	<thead>
		<th>Наименование</th>
		<th>Заказчик</th>
		<th>Бюджет</th>
		<th>Статус</th>
	</thead>
	<tbody>
	</tbody>
</table>

<script>
$(function(){
	var respondsTable = $("#projects-table").DataTable({
		"language": {"url": "/js/dataTables/dataTables.russian.lang"},
		"dom": 'tr<"row"<"col"p>><"row"<"col"i>>',
		"bProcessing": true,
		"bServerSide": true,
		"pagingType": "full_numbers",
		"ajax": {
			"url": "/dt/project-responds",
			"type": "POST",
			"data": function( d ) {
				d.for_profile = true;
				d.status_id = "-1";
			}
		},
		"columns": [
			{"data": "project.title","class":"project-table-title","width":"300px"},
			{"data": "project_user.user_id","name":"project.user_id","class":"project-table-user"},
			{"data": "respond.cost","name":"project_responds.cost","class":"project-table-cost"},
			{"data": "respond.status_id","name":"project_responds.status_id","class":"project-table-status"},
		],
		"order": [[0, 'asc']],
		"initComplete": function(table,data) {
		},
		"createdRow": function ( row, data, index ) {
			var title = $.sprintf('<a class="wdo-link word-break" href="%s">%s</a>',data.project_link,data.project.title);
			var category = $.sprintf('<br /><small><text class="text-purple strong">%s</text> / <text title="Был опубликован">%s</text></small>',data.project.cat_name,moment.unix(data.project.created).fromNow());
			var username = '<div class="row"><div class="col" style="padding: 0;flex: 0 0 35px; max-width: 35px; min-width: 35px;"><a href="/profile/id'+data.project_user.user_id+'" class="wdo-link"><img class="rounded-circle" src="'+data.project_user.avatar_path+'" /></a></div><div class="col"><a href="/profile/id'+data.project_user.user_id+'" class="wdo-link">'+data.project_user.realUserName+'</a></div></div>';
			var cost = data.respond.cost + ' <i class="fa fa-rouble"></i>';
			$('td', row).eq(0).html(title+category);
			$('td', row).eq(1).html(username);
			$('td', row).eq(2).html(cost);
			$('td', row).eq(3).html('<img src="'+data.respond.image_path+'" title="'+data.respond.status_name+'" />');
		},
		"drawCallback": function( settings ) {
			$(".paginate_button > a").on("focus", function() {
				$(this).blur();
			});
		}
	})

	$(".loader").remove();
})
</script>
<?php
} // end showing self responds
?>