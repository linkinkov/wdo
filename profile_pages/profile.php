<?php
if ( $current_user->user_id == 0 || $current_user->user_id != $user_id )
{
	header('HTTP/1.0 401 Unauthorized',true,401);
	exit;
}
$action = get_var("action","string","");
$password = get_var("password","string","");
if ( $action == "change_password" )
{

}
$ref = isset($_SESSION["LAST_PAGE"]) ? trim($_SESSION["LAST_PAGE"]) : false;
if ( $ref == "profile/project-responds" )
{
	$data["ts_project_responds"] = time();
	$current_user->update_profile_info($data);
}

$_SESSION["LAST_PAGE"] = "profile/profile-info";
?>
<div class="row">
	<div class="col">
		<h3 class="text-purple">Общая информация</h3>
	</div>
</div>
<div class="row"><div class="col"><hr /></div></div>
<div class="row">
	<div class="col" style="max-width: 180px; align-self: center;">
		<text class="text-muted">Учетная запись</text>
	</div>
	<div class="col">
		<text class="text-muted"><?php echo $current_user->username;?></text>
		<span class="pull-right">
			<a class="wdo-link text-muted" data-toggle="modal" data-target="#change_password-modal">
				<i class="fa fa-user-secret"></i> Сменить пароль
			</a>
		</span>
	</div>
</div>

<div class="row"><div class="col"><hr /></div></div>

<div class="row">
	<div class="col" style="max-width: 180px; align-self: center;">
		<text class="text-muted">Тип</text>
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
<div class="row real_user_name-container">
	<div class="col" style="max-width: 180px; align-self: center;">
		Имя
	</div>
	<div class="col">
		<input type="text" class="form-control profile-data" data-name="real_user_name" placeholder="Ваше имя" />
	</div>
</div>

<div class="row"><div class="col"><hr /></div></div>
<div class="row" style="align-items: center;">
	<div class="col" style="max-width: 180px;">
		Фото
	</div>
	<div class="col text-center">
		<img class="rounded-circle shadow" data-name="avatar" src="" />
	</div>
	<div class="col text-justify">
		<p>
			<label for="avatar_upload" class="wdo-link underline" data-lt="Загрузка..." data-ot="Сменить фото">Сменить фото</label>
			<input id="avatar_upload" type="file" name="avatar[]" style="display: none;" accept=".jpg,.jpeg,.png,.gif">
		</p>
		<p>
			<label class="wdo-link underline" id="avatar_delete">Удалить фото</label>
		</p>
		<p class="text-muted"><small>Не менее 150x150px<br />Не более 1500x1500px</small></p>
	</div>
</div>

<div class="row"><div class="col"><hr /></div></div>
<div class="row birthday-container">
	<div class="col" style="max-width: 180px; align-self: center;">
		Дата рождения
	</div>
	<div class="col">
		<input type="text" class="form-control profile-data" data-name="birthday" placeholder="ДД/ММ/ГГГГ" />
	</div>
</div>

<div class="row"><div class="col"><hr /></div></div>
<div class="row signature-container">
	<div class="col" style="max-width: 180px; align-self: center;">
		Подпись
	</div>
	<div class="col">
		<input type="text" class="form-control profile-data" data-name="signature" placeholder="Подпись, не более 140 знаков" />
	</div>
</div>

<div class="row"><div class="col"><hr /></div></div>
<div class="row country_id-container">
	<div class="col" style="max-width: 180px; align-self: center;">
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
	<div class="col" style="max-width: 180px; align-self: center;">
		Город
	</div>
	<div class="col">
		<div class="btn-group" style="width: 100%;">
			<button type="button" class="btn btn-secondary" style="text-align: left;width: 100%;" data-toggle="dropdown" data-name="city_id"></button>
			<button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="flex: 0 1 30px;"></button>
			<div class="dropdown-menu city-list" style="width: 100%;">
				<a class="dropdown-item disabled"><input type="text" class="form-control profile-city-filter" placeholder="Поиск"></a>
				<?php echo sprintf('<a class="dropdown-item wdo-option profile-data" data-name="city_id" data-value="%d" generated>%s</a>',$user->city_id,$user->city_name);?>
			</div>
		</div>
	</div>
</div>

<div class="row"><div class="col"><hr /></div></div>
<div class="row rezume-container">
	<div class="col" style="max-width: 180px; align-self: center;">
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
	<div class="col" style="max-width: 180px; align-self: center;">
		<i class="fa fa-mobile fa-lg fa-fw text-purple"></i> Телефон
	</div>
	<div class="col">
		<input type="text" class="form-control profile-data" data-name="phone" placeholder="Телефон" />
	</div>
</div>

<div class="row"><div class="col"><hr /></div></div>
<div class="row telegram-container">
	<div class="col" style="max-width: 180px; align-self: center;">
		<i class="fa fa-telegram fa-lg fa-fw text-purple"></i> Telegram
	</div>
	<div class="col">
		<input type="text" class="form-control profile-data" data-name="telegram" placeholder="t.me/profile_id" />
	</div>
</div>

<div class="row"><div class="col"><hr /></div></div>
<div class="row site-container">
	<div class="col" style="max-width: 180px; align-self: center;">
		<i class="fa fa-globe fa-lg fa-fw text-purple"></i> Сайт
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
	<div class="col text-center">
		<div class="wdo-btn btn-sm bg-purple" id="save_profile_info" data-lt="Сохранение" data-ot="Сохранить">Сохранить</div>
	</div>
</div>
<div class="row"><div class="col"><hr /></div></div>

<script>
$(function(){
	var last_search = "-1";
	$(".profile-city-filter").keyup(function(e){
		var search = this.value;
		if ( search == last_search ) return;
		// if ( search == "" ) {$(".wdo-option[data-name='city_id']").remove();return;}
		last_search = search;
		app.getCityList(search,6,function(response){
			if ( response )
			{
				$(".city-list").find("[data-name='city_id']").remove();
				$.each(response,function(){
					$(".city-list").append($.sprintf('<a class="dropdown-item wdo-option profile-data" data-name="city_id" data-value="%d">%s</a>',this.id,this.city_name));
				})
			}
		},"false");
	})
	$(".profile-city-filter").trigger("keyup");

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
				else $("[data-name='"+key+"']").val(_.unescape(value));
			})
			var cty = $(".wdo-option[data-name='city_id'][data-value='2']");

			$('input[data-name="birthday"]').daterangepicker(config.datePickerOptionsSingle);
			$('input[data-name="birthday"]').on('apply.daterangepicker', function(ev, picker) {
				$(this).data('timestamp',picker.startDate.format("X"));
			});
		}
	});

	var upload_btn = $("label[for='avatar_upload']");
	$('#avatar_upload').fileupload({
		dataType: 'JSON',
		url: '/upload/',
		submit:  function (e, data) {
			set_btn_state(upload_btn,"loading");
		},
		done: function (e, data) {
			var response = data.result;
			if ( response.result == "true" )
			{
				$("img[data-name='avatar']").attr("src",response.avatar_path);
			}
			else if ( response.message )
			{
				showAlert('error',response.message);
			}
		},
		acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
		maxFileSize: 8000000,
		stop: function(e, data) {
			set_btn_state(upload_btn,"reset");
		}
	});
	$("#avatar_delete").click(function(){
		$.ajax({
			type: "POST",
			url: "/user.deleteAvatar",
			xhrFields: {withCredentials: true},
			dataType: "JSON",
			success: function (response) {
				if ( response.true )
				{
					$("img[data-name='avatar']").attr("src",response.avatar_path);
				}
				else
				{
					showAlert("error","Ошибка");
				}
			}
		});
	})
	$(".custom-control").click(function(e){
		$(this).find(".custom-control-input").blur();
	})
	$(".custom-radio-type_id").click(function(e){
		( $(this).data('value') == 1 ) ? $(".rekvizity-container").show() : $(".rekvizity-container").hide();
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

	$("#change_password_btn").on("click",function(){
		var btn = $(this),
				modal = $("#change_password-modal"),
				input = $(modal).find("input[name='password']"),
				input2 = $(modal).find("input[name='password_2']");
		if ( $(input).val() != $(input2).val() )
		{
			$(btn).text("Пароли не совпадают");
			return;
		}
		set_btn_state(btn,"loading");
		var profile = {};
		profile["password"] = hex_sha512($(input).val());
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
	$('[data-name="phone"]').mask('+7 (000) 0000000');
})


</script>
