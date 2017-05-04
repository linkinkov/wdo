<?php
require_once('_global.php');
include_once('_includes.php');
require_once(PD.'/lib/Resize.class.php');
require_once(PD.'/lib/Avatar.class.php');
require_once(PD.'/lib/Attach.class.php');
$db = db::getInstance();
check_access($db,false);
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
	<div class="row real_user_name-container">
		<div class="col" style="flex: 0 0 180px; max-width: 180px; align-self: center;">
			Имя
		</div>
		<div class="col">
			<input type="text" class="form-control profile-data" data-name="real_user_name" placeholder="Ваше имя" />
		</div>
	</div>

	<div class="row"><div class="col"><hr /></div></div>
	<div class="row" style="align-items: center;">
		<div class="col" style="flex: 0 0 180px; max-width: 180px;">
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
					<a class="dropdown-item disabled"><input type="text" class="form-control profile-city-filter" placeholder="Поиск"></a>
					<?php echo sprintf('<a class="dropdown-item wdo-option profile-data" data-name="city_id" data-value="%d" generated>%s</a>',$user->city_id,$user->city_name);?>
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
	})
	</script>

<?php
} // end showing profile info

else if ( $job == "projects" )
{
	if ( $user->user_id == $current_user->user_id )
	{
		$ref = isset($_SESSION["LAST_PAGE"]) ? trim($_SESSION["LAST_PAGE"]) : false;
		if ( $ref == "profile/project-responds" )
		{
			$data["ts_project_responds"] = time();
			$current_user->update_profile_info($data);
		}
	}
	$_SESSION["LAST_PAGE"] = "profile/projects";
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
				{"data": "project.status_name","name":"status_id","class":"project-table-status text-center align-top"},
			],
			"order": [[0, 'asc']],
			"initComplete": function(table,data) {
			},
			"createdRow": function ( row, data, index ) {
				var title = $.sprintf('<a class="wdo-link word-break" href="%s">%s</a>',data.project_link,data.project.title);
				var category = $.sprintf('<br /><small><text class="text-purple strong">%s</text> / <text title="Был опубликован">%s</text></small>',data.project.cat_name,moment.unix(data.project.created).fromNow());
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
				$('td', row).eq(4).attr("title",extra_title.join("; "));
				if ( extra_title.length == 0 ) $('td', row).eq(4).removeClass('align-top');
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
	$_SESSION["LAST_PAGE"] = "profile/project-responds";
	?>

	<table class="table" id="project-responds-table">
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
		var respondsTable = $("#project-responds-table").DataTable({
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
			"initComplete": function(table,data) {
			},
			"createdRow": function ( row, data, index ) {
				var title = $.sprintf('<a class="wdo-link word-break" href="%s">%s</a>',data.project_link,data.project.title);
				var category = $.sprintf('<br /><small><text class="text-purple strong">%s</text> / <text title="Был опубликован">%s</text></small>',data.project.cat_name,moment.unix(data.project.created).fromNow());
				var username = '<div class="row"><div class="col" style="padding: 0;flex: 0 0 35px; max-width: 35px; min-width: 35px;"><a href="/profile/id'+data.project_user.user_id+'" class="wdo-link"><img class="rounded-circle shadow" src="'+data.project_user.avatar_path+'" /></a></div><div class="col"><a href="/profile/id'+data.project_user.user_id+'" class="wdo-link">'+data.project_user.real_user_name+'</a></div></div>';
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
} // end showing project-responds
else if ( $job == "messages" )
{
	$_SESSION["LAST_PAGE"] = "profile/messages";
?>
	<div class="wdo-scrollbar dialogs-container scrollable"></div>

	<div class="conversation-container">
		<div class="wdo-scrollbar conversation-messages scrollable" id="conversation-messages"></div>
		<div class="conversation-footer">
			<div class="row"><div class="col">
				<textarea class="form-control" id="conversation-message-text" placeholder="Текст сообщения" rows="1"></textarea>
			</div></div>
			<br />
			<div class="row"><div class="col">
				<div class="wdo-btn btn-sm bg-purple pull-right" data-trigger="send-message" id="conversation-message-send" data-ot="Отправить" data-lt="Отправка">Отправить</div>
			</div></div>
		</div>
	</div>

	<script>
	$(function(){
		$( '.scrollable' ).on( 'mousewheel DOMMouseScroll', function ( e ) {
			if ( $(this).hasClass("loading") )
			{
				e.preventDefault();
				e.stopPropagation();
				return false;
			}
			var e0 = e.originalEvent,
					delta = e0.wheelDelta || -e0.detail;
			this.scrollTop += ( delta < 0 ? 1 : -1 ) * 30;
			e.preventDefault();
		});

		app.im.getDialogs(function(response){
			if ( response.result == "true" )
			{
				$(".dialogs-container").html('');
				$.each(response.dialogs,function(){
					$(".dialogs-container").append(app.im.format_dialog(this));
				})
			}
		})
		var last_scroll = 0;
		$(".conversation-messages").scroll(_.debounce(function(){}, 150, { 'leading': true, 'trailing': false }));
		$(".conversation-messages").scroll(_.debounce(function(){
			var scrollTop = $(this).scrollTop(),
					topDistance = $(this).offset().top,
					dialog_id = $(".conversation-container").data('dialog_id'),
					container = this;
			if ( $(container).hasClass("loading") ) return;

			if ( scrollTop < 160 )
			{
				if ( $(".conversation-container").data('all_loaded') == true ) return;
				$(container).addClass("loading");
				var start = $(".conversation-container").data('loaded');
				last_scroll = scrollTop;
				app.im.getMessages(dialog_id,start,config.profile.messages_per_page,0,0,function(response){
					if ( response.result == "true" )
					{
						var now_loaded = $(".conversation-container").data('loaded')+config.profile.messages_per_page;
						$.each(response.messages,function(){
							$(".conversation-messages").prepend(app.im.format_message(this));
						})
						$(".conversation-container").data('loaded',now_loaded);
						$(".conversation-messages").scrollTop(last_scroll+response.messages.length*70);
					}
					else
					{
						$(".conversation-container").data('all_loaded',true);
					}
					setTimeout(function(){
						$(container).removeClass("loading");
					},250)
				})
			}
		}, 150));
		autosize($("#conversation-message-text"));
	})
	</script>
<?php
} // end showing messages

else if ( $job == "portfolio" )
{
	$_SESSION["LAST_PAGE"] = "profile/portfolio";

if ( $current_user->user_id == $user->user_id )
{
?>
<div class="row">
	<div class="col">
		<a class="wdo-btn btn-sm yellow-outline" data-toggle="tab" data-target="#portfolio-add" role="tab"><i class="fa fa-plus"></i> Добавить работу</a>
	</div>
</div>
<br />
<?php
}
?>
<div class="row">
	<div class="col" style="overflow-x: hidden;position: relative;">
		<div id="portfolio_single" style="display: none;position: absolute;width: 720px;height: 100%;background-color: rgba(243, 241, 241, 0.96);z-index: 5;">
			<div class="row">
				<div class="col">
					<span class="pull-left">
						<h4 class="text-purple-dark" id="portfolio-title"></h4>
					</span>
					<?php
					if ( $user->user_id == $current_user->user_id )
					{
					?>
					<span class="pull-right">
						<a class="wdo-link opacity"><i class="fa fa-trash"></i> Удалить</a>
						<a class="wdo-link opacity"><i class="fa fa-pencil"></i> Редактировать</a>
					</span>
					<?php
					}
					?>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<a class="wdo-link opacity" onClick="app.portfolio.hide();"><img src="/images/back-arrow.png" /> Вернуться</a>
				</div>
			</div>
			<div class="row"><div class="col"><hr /></div></div>
			<div class="row">
				<div class="col">
					<p id="portfolio-descr" class="text-justify">Описание</p>
				</div>
			</div>
			<div class="row"><div class="col"><hr /></div></div>
			<div class="row">
				<div class="col" style="max-width: 100px;">
					Фото
				</div>
				<div class="col" id="portfolio-photos"></div>
			</div>
		</div>
		<div class="card-columns" id="portfolio_list"></div>
	</div>
</div>
<script>
$(function(){
	app.portfolio.getList(function(response){
		if ( response.length > 0 )
		{
			$("#portfolio_list").html('');
			$.each(response,function(){
				$("#portfolio_list").append(app.portfolio.format_preview(this));
			})
		}
	})
})
</script>
<?php
}
elseif ( $job == "portfolio-add" )
{
?>
	<div class="row">
		<div class="col" style="flex: 0 0 280px; max-width: 280px; align-self: center;">
			<text class="text-muted">Выберите раздел</text>
		</div>
		<div class="col">
			<div class="btn-group" style="width: 100%;">
				<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" data-name="category" aria-haspopup="true" aria-expanded="false" style="width: 100%;">Категория</button>
				<div class="dropdown-menu cat-list" style="width: 100%;">
					<?php foreach ( Category::get_list() as $cat )
					{
						echo sprintf('<a class="dropdown-item wdo-option" data-name="category" data-value="%d">%s</a>',$cat->id,$cat->cat_name);
					}
					?>
				</div>
			</div>
		</div>
	</div>

	<div class="row"><div class="col"><hr /></div></div>
	<div class="row">
		<div class="col" style="flex: 0 0 280px; max-width: 280px; align-self: center;">
			<text class="text-muted">Выберите подраздел</text>
		</div>
		<div class="col">
			<div class="btn-group" style="width: 100%;">
				<button type="button" class="btn btn-secondary dropdown-toggle disabled" data-toggle="dropdown" data-name="subcategory" aria-haspopup="true" aria-expanded="false" style="width: 100%;">Подкатегория</button>
				<div class="dropdown-menu subcat-list" style="width: 100%;">
				</div>
			</div>
		</div>
	</div>

	<div class="row"><div class="col"><hr /></div></div>
	<div class="row">
		<div class="col" style="flex: 0 0 280px; max-width: 280px; align-self: center;">
			<text class="text-muted">Название</text>
		</div>
		<div class="col">
			<input type="text" class="form-control" data-name="title" placeholder="Название портфолио, например: Свадьба Алёны и Максима" />
		</div>
	</div>

	<div class="row"><div class="col"><hr /></div></div>
	<div class="row">
		<div class="col" style="flex: 0 0 280px; max-width: 280px; align-self: center;">
			<text class="text-muted">Описание</text>
		</div>
		<div class="col">
			<textarea class="form-control" rows="7" data-name="descr" placeholder="Детальное описание портфолио"></textarea>
		</div>
	</div>

	<div class="row"><div class="col"><hr /></div></div>
	<div class="row">
		<div class="col" style="flex: 0 0 280px; max-width: 280px; align-self: center;">
			<text class="text-muted">Фото и документы</text>
		</div>
		<div class="col">
			<div id="uploaded" style="display: none;">
				<div class="attaches-container gallery">
					<!--<a href="/get.Attach?attach_id=1&w=500"><img class="img-thumbnail" src="/get.Attach?attach_id=1&w=100&h=100" /></a>-->
				</div>
				<hr />
				<div class="progress">
					<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
				<br />
			</div>
			<label for="fileupload" class="wdo-btn bg-purple" data-lt="Загрузка..." data-ot="Выберите файлы">Выберите файлы (<small>Не более 10</small>)</label>
			<input id="fileupload" type="file" name="files[]" multiple style="display: none;" accept=".png,.jpg,.jpeg,.gif,.pdf,.xls,.xlsx,.doc,.docx">
		</div>
	</div>

	<div class="row"><div class="col"><hr /></div></div>
	<div class="row">
		<div class="col" style="flex: 0 0 280px; max-width: 280px; align-self: center;">
			<text class="text-muted">Видео</text>
		</div>
		<div class="col" id="yt_links">
			<small class="text-muted">Не более 6 ссылок</small>
			<input type="text" class="form-control empty" data-name="youtube-link" placeholder="Ссылка на ваше видео в YouTube" />
		</div>
	</div>

	<div class="row"><div class="col"><hr /></div></div>
	<div class="row">
		<div class="col text-center">
			<div class="wdo-btn btn-sm bg-purple" id="submit" data-lt="Загрузка" data-ot="Опубликовать портфолио">Опубликовать портфолио</div>
		</div>
	</div>

<script>
var current_links = [];
$(function(){
	var upload_btn = $("label[for='fileupload']");
	var total_files = 0;
	var max_files = 10;
	$.get("/upload/",function(response){
		try {
			var resp = $.parseJSON(response),
					files = resp.files;
			if ( files.length > 0 )
			{
				var $form = $('#fileupload');
				$form.fileupload();
				$form.fileupload('option', 'done').call($form, $.Event('done'), {result: {files: files}});
				total_files = files.length;
			}
		}
		catch (msg)
		{
			console.log(msg);
		}
	})
	$('#fileupload').fileupload({
		dataType: 'json',
		url: '/upload/',
		change : function (e, data) {
			if(total_files>=max_files){
				showAlert("error","Максимум "+max_files+" файлов");
				return false;
			}
		},
		submit:  function (e, data) {
			if(total_files>=max_files){
				showAlert("error","Максимум "+max_files+" файлов");
				return false;
			}
			$("#uploaded").show();
			$(".progress").show();
			set_btn_state(upload_btn,"loading");
		},
		done: function (e, data) {
			$("#uploaded").show();
			$.each(data.result.files, function (index, file) {
				if ( file.error )
				{
					showAlert("error",file.error);
					return;
				}
				var is_image = /image/ig;
				if ( is_image.test(file.type) )
				{
					$(".attaches-container").append('<div class="project-upload-attach" data-filename="'+file.name+'"><a href="'+file.url+'"><img class="img-thumbnail" src="'+file.thumbnailUrl+'" /></a><br /><a data-filename="'+file.name+'" class="delete" href="'+file.deleteUrl+'">Удалить</a></div>');
				}
				else
				{
					$(".attaches-container").append('<div class="project-upload-attach" data-filename="'+file.name+'"><a class="download" href="'+file.url+'"><img class="img-thumbnail" width="50px" src="/images/document.png" /></a><br /><a data-filename="'+file.name+'" class="delete" href="'+file.deleteUrl+'">Удалить</a></div>');
				}
				total_files++;
			});
			$(".download").click(function(e){
				e.stopPropagation();
				e.preventDefault();
				var href = $(this).attr("href");
				window.open(href,'_blank');
			})
			$(".delete").click(function(e){
				e.stopPropagation();
				e.preventDefault();
				var link = $(this),
						href = $(link).attr("href"),
						data = $(link).data(),
						obj = $("div[data-filename='"+data.filename+"']");
				$.ajax({
					url: href,
					type: 'DELETE',
					dataType: "JSON",
					success: function(result) {
						if ( result[data.filename] == true )
						{
							$(obj).remove();
							if ( $(".attaches-container").children().length == 0 ) $("#uploaded").hide();
							total_files--;
						}
						return false;
					}
				});
				return false;
			})
		},
		acceptFileTypes: /(\.|\/)(gif|jpe?g|png|docx?|xlsx?|pdf)$/i,
		maxFileSize: 16000000,
		stop: function(e, data) {
			set_btn_state(upload_btn,"reset");
			$(".progress").hide();
		},
		progressall: function (e, data) {
			var progress = parseInt(data.loaded / data.total * 100, 10);
			$('.progress .progress-bar').css(
				'width',
				progress + '%'
			);
		},
		processfail: function(e,data) {
			$.each(data.files, function (index, file) {
				if ( file.error )
				{
					showAlert("error","("+file.name+"): "+file.error);
				}
			})
		}
	});
	$(".gallery").click(function (event) {
		event = event || window.event;
		var target = event.target || event.srcElement,
				link = target.src ? target.parentNode : target,
				options = {index: link, event: event},
				links = $(this).find("a").not(".download").not(".delete");
		blueimp.Gallery(links, options);
	});
		$("#submit").click(function(){
		if ( $(this).hasClass("disabled") ) return false;
		var ar = [],
				btn = $(this);
		$("input[data-name='youtube-link']").each(function(){
			if ( $(this).val() != "" )
				ar.push($(this).val())
		})
		var data = {
				"cat_id": $(".wdo-option.active[data-name='category']").data('value'),
				"subcat_id": $(".wdo-option.active[data-name='subcategory']").data('value'),
				"title": $("input[data-name='title']").val(),
				"descr": $("textarea[data-name='descr']").val(),
				"youtube_links": ar,
			},
			error = 0,
			text = '';
			// https://www.youtube.com/watch?v=aJaRUYE3C-I
			// youtu.be/H9mNjb9XYy8
		$(".warning").removeClass("warning");
		if ( data.cat_id <= 0 || data.cat_id === undefined ) {
			$("button[data-name='category']").addClass("warning");
			text = 'Выберите категорию';
			error++;
		}
		if ( data.subcat_id <= 0 || data.subcat_id === undefined ) {
			$("button[data-name='subcategory']").addClass("warning");
			text = 'Выберите подкатегорию';
			error++;
		}
		if ( data.title == "" || data.title === undefined ) {
			$("[data-name='title']").addClass("warning");
			text = 'Введите название портфолио';
			error++;
		}
		if ( data.descr == "" || data.descr === undefined ) {
			$("[data-name='descr']").addClass("warning");
			text = 'Введите описание портфолио';
			error++;
		}
		if ( error > 0 ) {
			( error == 1 ) ? $(this).text(text) : $(this).text('Пожалуйста, проверьте данные');
			$('html, body').animate({
					scrollTop: $(".nav-tabs").offset().top
			}, 1000);
			return;
		}
		set_btn_state(btn,'loading');
		$.ajax({
			type: "POST",
			url: "/portfolio/publish",
			xhrFields: {withCredentials: true},
			data: {"data": data},
			dataType: "JSON",
			success: function (response) {
				console.log("response:",response);
				if ( response.message )
				{
					set_btn_state(btn,'reset',response.message);
				}
				else
				{
					set_btn_state(btn,'reset');
				}
				if ( response.result == "true" )
				{
					console.log("published!",response);
					$('.tab-pane#portfolio').removeClass("active");
					$('a[data-toggle="tab"][data-target="portfolio"]').removeClass("active").tab('show');
				}
			}
		})
	})
})
</script>
<?php
} // end showing portfolio add page
elseif ( $job == "portfolio-publish" )
{
	$data = get_var("data","array",Array());
	$response = Portfolio::publish($data);
	header('Content-Type: application/json');
	echo json_encode($response);
	exit;
}
elseif ( $job == "portfolio-update" )
{
	$portfolio_id = get_var("portfolio_id","int",0);
	$attach_id = get_var("attach_id","string","");
	$action = get_var("action","string","delete-cover");
	$response = ( $action == "delete-cover" ) ? Portfolio::update($portfolio_id,"cover_id","") : Portfolio::update($portfolio_id,"cover_id",$attach_id);
	header('Content-Type: application/json');
	echo json_encode($response);
	exit;
}
?>
<script>
$(function(){
	$(".loader").remove();
})
</script>