<?php
require_once('../_global.php');
require_once('../_includes.php');
require(PD.'/admin/check_admin.php');

check_access($db,true);
$job = get_var("job","string",false);
if ( $job == "get_settings" )
{
	$response = $db->queryRows("SELECT * FROM `settings`");
	header('Content-Type: application/json');
	echo json_encode($response);
}
if ( $job == "set_setting" )
{
	$param_name = get_var("param_name","string",false);
	$param_value = get_var("param_value","string",false);
	$response = Array(
		"result" => "false",
		"message" => "Ошибка"
	);
	if ( $param_name != "" && $param_value != "" )
	{
		if ( $db->query(sprintf("UPDATE `settings` SET `param_value` = '%s' WHERE `param_name` = '%s'",$param_value,$param_name)) )
		{
			$response["result"] = "true";
			$response["message"] = "Сохранено";
		}
	}
	header('Content-Type: application/json');
	echo json_encode($response);
}
if ( $job != "" ) exit();
?>
<div class="row">
	<div class="col">
		<h5>Настройки</h5>
	</div>
</div>
<hr />
<div class="row">
	<div class="col">
		<label for="vip_cost">Стоимость VIP проекта</label>
		<div class="input-group">
			<input id="vip_cost" type="number" class="form-control" data-setting="vip_cost" data placeholder="Стоимость VIP проекта" />
			<div class="input-group-btn">
				<button class="btn btn-success" data-trigger="save-setting" data-setting="vip_cost"><i class="fa fa-check"></i> Сохранить</button>
			</div>
		</div>
	</div>
</div>

<script>
$(function(){
	$.ajax({
		"url": "/admin/settings",
		"type": "POST",
		"dataType": "JSON",
		"data": {
			"job": "get_settings"
		},
		"success": function(response){
			if ( response.length > 0 )
			{
				$.each(response,function(){
					$("[data-setting='"+this.param_name+"']").val(this.param_value);
				})
			}
		}
	})
})
</script>