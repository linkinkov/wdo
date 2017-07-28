<?php
require_once('../../_global.php');
require_once('../../_includes.php');
require(PD.'/admin/check_admin.php');

header('Content-Type: application/json');
$response = Array(
	"sEcho"=>0, 
	"fDBGenerated"=>0,
	"recordsTotal"=>0, 
	"recordsFiltered"=>0,
	"aaData"=>Array(),
	"message" => ""
);

$select_cols = Array();

$script_start = microtime(true);

$sEcho = get_var("draw","int",0);
$start = get_var("start","int",0);
$length = get_var("length","int",10);
$search = isset($_REQUEST["search"]["value"]) ? htmlspecialchars($_REQUEST["search"]["value"]) : "";
$order = get_var("order","array",Array());
$columns = get_var("columns","array",Array());

$city_id = get_var("city_id","string","");
$status_id = get_var("status_id","string","");
$type_id = get_var("type_id","string","");
$as_performer = get_var("as_performer","string","");
$template_id = get_var("template_id","string","");


if (sizeof($columns) > 0)
{
	foreach($columns as $idx=>$col)
	{
		$orderColumns[] = isset($col["name"]) && $col["name"] != ""  ? $col["name"] : $col["data"];
	}
}
if (sizeof($order) > 0)
{
	foreach($order as $ord)
	{
		if ($ord["dir"] && isset($ord["column"]) && $ord["column"] != "")
		{
			$orderArr[] = $orderColumns[$ord["column"]] . " " . $ord["dir"];
		}
	}
}
$orderStr = isset($orderArr) ? implode(", ", $orderArr) : "`cats`.`sort` ASC";

$searchStr = "";
if ( $search )
{
	foreach ( $orderColumns as $col )
	{
		// if ( !in_array($col,Array("cat_name","subcat_name")) ) continue;
		$searchArr[] = sprintf("`%s` REGEXP '%s'",$col,$search);
	};
	$searchStr = '('.implode(" OR ",$searchArr).')';
}
else
{
	$searchStr = "1";
}
$searchStr .= ( $city_id != "" ) ? sprintf(" AND `users`.`city_id` IN (%s)",$city_id) : "";
$searchStr .= ( $status_id != "" ) ? sprintf(" AND `users`.`status_id` IN (%s)",$status_id) : "";
$searchStr .= ( $type_id != "" ) ? sprintf(" AND `users`.`type_id` IN (%s)",$type_id) : "";
$searchStr .= ( $as_performer != "" ) ? sprintf(" AND `users`.`as_performer` IN (%s)",$as_performer) : "";
$searchStr .= ( $template_id != "" ) ? sprintf(" AND `users`.`template_id` IN (%s)",$template_id) : "";

$sql_main = "SELECT
	`users`.`user_id` as `user_id`,
	`username`,
	`city_name`,
	`real_user_name`,
	`registered`,
	`last_login`,
	IF(`type_id`=2,'Физ. лицо','Юр. лицо') as `type_name`,
	IF(`as_performer`=0,'Заказчик','Исполнитель') as `performer`,
	`status_name`,
	`rating`,
	`users`.`city_id`,
	`users`.`type_id`,
	`users`.`status_id`,
	`users`.`as_performer`,
	`users`.`template_id`,
	(SELECT COUNT(`project_id`) FROM `project` WHERE `project`.`user_id` = `users`.`user_id`) as `projects_counter`,
	(SELECT COUNT(`respond_id`) FROM `project_responds` WHERE `project_responds`.`user_id` = `users`.`user_id`) as `responds_counter`,
	(SELECT COUNT(`id`) FROM `user_responds` WHERE `user_id` = `users`.`user_id`) as `user_responds_counter`,
	(SELECT COUNT(`warning_id`) FROM `warnings` WHERE `for_user_id` = `users`.`user_id`) as `warnings_counter`,
	`balance`
	FROM `users`
	LEFT JOIN `cities` ON `cities`.`id` = `users`.`city_id`
	LEFT JOIN `user_wallets` ON `user_wallets`.`user_id` = `users`.`user_id`
	LEFT JOIN `user_statuses` ON `user_statuses`.`status_id` = `users`.`status_id`
	HAVING $searchStr
	ORDER BY $orderStr
	LIMIT $start, $length";
// echo $sql_main;
try {
	$aaData = $db->queryRows($sql_main);
} catch (Exception $e) {
	$response["error"] = $e->getMessage();
	// echo $sql_main;
	echo json_encode($response);
	exit();
}
$recordsTotal = 0;
$recordsFiltered = 0;

$sql = "SELECT COUNT(`user_id`) as recordsTotal FROM `users` WHERE 1";
try {
	$tr = $db->queryRow($sql);
	$recordsTotal = $tr->recordsTotal;
} catch (Exception $e) {
	$response["error"] = $e->getMessage();
	echo json_encode($response);
	exit();
}


$sql = "SELECT
	`users`.`user_id` as `user_id`,
	`username`,
	`city_name`,
	`real_user_name`,
	`registered`,
	`last_login`,
	IF(`type_id`=2,'Физ. лицо','Юр. лицо') as `type_name`,
	IF(`as_performer`=0,'Заказчик','Исполнитель') as `performer`,
	`status_name`,
	`rating`,
	`users`.`city_id`,
	`users`.`type_id`,
	`users`.`status_id`,
	`users`.`as_performer`,
	`users`.`template_id`,
	(SELECT COUNT(`project_id`) FROM `project` WHERE `project`.`user_id` = `users`.`user_id`) as `projects_counter`,
	(SELECT COUNT(`respond_id`) FROM `project_responds` WHERE `project_responds`.`user_id` = `users`.`user_id`) as `responds_counter`,
	(SELECT COUNT(`id`) FROM `user_responds` WHERE `user_id` = `users`.`user_id`) as `user_responds_counter`,
	(SELECT COUNT(`warning_id`) FROM `warnings` WHERE `for_user_id` = `users`.`user_id`) as `warnings_counter`,
	`balance`
	FROM `users`
	LEFT JOIN `cities` ON `cities`.`id` = `users`.`city_id`
	LEFT JOIN `user_wallets` ON `user_wallets`.`user_id` = `users`.`user_id`
	LEFT JOIN `user_statuses` ON `user_statuses`.`status_id` = `users`.`status_id`
	HAVING $searchStr";
try {
	// $tdr = $db->queryRow($sql);
	// $recordsFiltered = $tdr->recordsFiltered;
	$tdr = $db->query($sql);
	$recordsFiltered = $tdr->num_rows;
} catch (Exception $e) {
	$response["error"] = $e->getMessage();
	echo json_encode($response);
	exit();
}
if ( sizeof ($aaData) )
{
	$idx = 0;
	foreach ( $aaData as $row )
	{
		$row->DT_RowId = $row->user_id;
		$row->DT_RowClass = "";
		switch ( $row->status_id )
		{
			case "1":
				$row->status_name = sprintf('<text class="text-success">%s</text>',$row->status_name);
				break;
			case "2":
				$row->status_name = sprintf('<text class="text-muted">%s</text>',$row->status_name);
				break;
			case "3":
				$row->status_name = sprintf('<text class="text-warning">%s</text>',$row->status_name);
				break;
			case "4":
				$row->status_name = sprintf('<text class="text-danger">%s</text>',$row->status_name);
				break;
		}
		if ( $row->template_id == 2 )
		{
			$row->performer = '<text class="text-primary" style="font-weight: 800;">Администратор</text>';
		}
	}
}

$response = Array(
	"sEcho"=>$sEcho, 
	"fDBGenerated"=>number_format((microtime(true) - $script_start),2),
	"recordsTotal"=>$recordsTotal, 
	"recordsFiltered"=>$recordsFiltered,
	"data"=>$aaData,
	"lastUpdate"=>time()
);

echo json_encode($response);
?>