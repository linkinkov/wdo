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
if ( !$job ) die("no data");

$user = new User($user_id);

if ( $job == "profile" )
{
if ( $current_user->user_id != $user_id ) exit("Access error");
?>
<!--<div class="row">
	<div class="col">
		<h3 class="strong text-purple-dark">Общая информация</h3>
	</div>
</div>
<div class="row"><div class="col"><hr /></div></div>-->

<div class="row">
	<div class="col" style="flex: 0 0 180px; max-width: 180px; align-self: center;">
		<text class="text-muted">Учетная запись</text>
	</div>
	<div class="col type_id-container">
		<label class="custom-control custom-radio custom-radio-profile-type" data-type_id="1">
			<input name="type_id" type="radio" class="custom-control-input">
			<span class="custom-control-indicator"></span>
			<span class="custom-control-description">Юридическое лицо</span>
		</label>
		<label class="custom-control custom-radio custom-radio-profile-type">
			<input name="type_id" type="radio" class="custom-control-input" data-type_id="2">
			<span class="custom-control-indicator"></span>
			<span class="custom-control-description">Физическое лицо</span>
		</label>
	</div>
</div>

<div class="row"><div class="col"><hr /></div></div>
<div class="row as_performer-container">
	<div class="col" style="flex: 0 0 180px; max-width: 180px; align-self: center;">
		CHECKBOX
	</div>
	<div class="col">
		<text class="text-purple">Я исполнитель</text>
		<p class="text-muted"><small>Если Вы хотите быть в списке исполнителей, то Вам необходимо создать хотя-бы одно портфолио в соответствующей категории</small></p>
	</div>
</div>

<div class="row"><div class="col"><hr /></div></div>
<div class="row last_name-container">
	<div class="col" style="flex: 0 0 180px; max-width: 180px; align-self: center;">
		ФИО
	</div>
	<div class="col">
		<input type="text" class="form-control" name="last_name" placeholder="Фамилия" />
	</div>
	<div class="col">
		<input type="text" class="form-control" name="first_name" placeholder="Имя" />
	</div>
</div>

<div class="row"><div class="col"><hr /></div></div>
<div class="row company_name-container">
	<div class="col" style="flex: 0 0 180px; max-width: 180px; align-self: center;">
		Название компании
	</div>
	<div class="col">
		<input type="text" class="form-control" name="company_name" placeholder="Название компании" />
	</div>
</div>

<div class="row"><div class="col"><hr /></div></div>
<div class="row avatar-container">
	<div class="col" style="flex: 0 0 180px; max-width: 180px; align-self: center;">
		Фото
	</div>
	<div class="col text-center">
		<img class="rounded-circle" name="avatar" src="" />
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
		<input type="text" class="form-control" name="birthday" placeholder="ДД/ММ/ГГГГ" />
	</div>
</div>

<div class="row"><div class="col"><hr /></div></div>
<div class="row signature-container">
	<div class="col" style="flex: 0 0 180px; max-width: 180px; align-self: center;">
		Подпись
	</div>
	<div class="col">
		<input type="text" class="form-control" name="signature" placeholder="Подпись, не более 140 знаков" />
	</div>
</div>

<div class="row"><div class="col"><hr /></div></div>
<div class="row country_id-container">
	<div class="col" style="flex: 0 0 180px; max-width: 180px; align-self: center;">
		Страна
	</div>
	<div class="col">
		Россия
	</div>
</div>

<div class="row"><div class="col"><hr /></div></div>
<div class="row city_id-container">
	<div class="col" style="flex: 0 0 180px; max-width: 180px; align-self: center;">
		Город
	</div>
	<div class="col">
		<select class="form-control" name="city_id">
		<?php
		foreach ( City::getList() as $r )
		{
			echo sprintf('<option value="%d">%s</option>',$r->id,$r->city_name);
		}
		?>
		</select>
	</div>
</div>

<div class="row"><div class="col"><hr /></div></div>
<div class="row rezume-container">
	<div class="col" style="flex: 0 0 180px; max-width: 180px; align-self: center;">
		Резюме
	</div>
	<div class="col">
		<textarea class="form-control" rows="10" name="rezume"></textarea>
	</div>
</div>

<div class="row"><div class="col"><hr /></div></div>
<div class="row">
	<div class="col">
		<h3>Контактные данные</h3>
	</div>
</div>

<div class="row"><div class="col"><hr /></div></div>
<div class="row phone-container">
	<div class="col" style="flex: 0 0 180px; max-width: 180px; align-self: center;">
		<i class="fa fa-mobile fa-fw"></i> Телефон
	</div>
	<div class="col">
		<input type="text" class="form-control" name="phone" placeholder="Телефон" />
	</div>
</div>

<div class="row"><div class="col"><hr /></div></div>
<div class="row phone-container">
	<div class="col" style="flex: 0 0 180px; max-width: 180px; align-self: center;">
		<i class="fa fa-skype fa-fw"></i> Skype
	</div>
	<div class="col">
		<input type="text" class="form-control" name="skype" placeholder="Skype" />
	</div>
</div>

<div class="row"><div class="col"><hr /></div></div>
<div class="row site-container">
	<div class="col" style="flex: 0 0 180px; max-width: 180px; align-self: center;">
		<i class="fa fa-home fa-fw"></i> Сайт
	</div>
	<div class="col">
		<input type="text" class="form-control" name="site" placeholder="http://www.example.com/" />
	</div>
</div>

<div class="row"><div class="col"><hr /></div></div>
<div class="row">
	<div class="col">
		<i class="fa fa-map-marker fa-fw"></i> Местоположение
	</div>
</div>
<div class="row gps-container">
	<div class="col">
		КАРТА
	</div>
</div>

<script>
$(".custom-radio-profile-type").click(function(e){
	$(this).find(".custom-control-input").blur();
})
	<?php echo sprintf('var user_id = "%d";',$user_id);?>
$(function(){
	app.user.get_profile_info(user_id,function(response){
		if ( response.result == "true" )
		{
			$.each(response.user,function(key,value) {
				console.log(key,value);
				if ( key == "avatar_path" ) $("img[name='avatar']").attr("src",value+"&w=150&h=150");
				else if ( key == "birthday" ) $("[name='birthday']").val(moment.unix(value).format("DD/MM/YYYY"));
				else $("[name='"+key+"']").val(value);
			})
			$('input[name="birthday"]').daterangepicker(config.datePickerOptionsBirthday);
		}
	});
})
</script>

<?php
} // end showing profile info
exit;
?>