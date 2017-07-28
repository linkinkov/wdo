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
		if ( !in_array($col,Array("scenario_name")) ) continue;
		$searchArr[] = sprintf("`%s` REGEXP '%s'",$col,$search);
	};
	$searchStr = '('.implode(" OR ",$searchArr).')';
}
else
{
	$searchStr = "1";
}


$sql_main = "SELECT `scenario_id`,
`scenario_name`,
`sort`,`disabled`,
(SELECT COUNT(`event_id`) FROM `user_scenarios` WHERE `scenario_id` = `scenario_templates`.`scenario_id` AND `archive` = 0) as `active_events`,
(SELECT COUNT(`event_id`) FROM `user_scenarios` WHERE `scenario_id` = `scenario_templates`.`scenario_id`) as `total_events`,
LENGTH(`scenario_subcats`)-(FLOOR(LENGTH(`scenario_subcats`)/2)) as `scenario_subcats_counter`
FROM `scenario_templates`
WHERE $searchStr
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

$sql = "SELECT COUNT(`scenario_id`) as recordsTotal FROM `scenario_templates` WHERE 1";
try {
	$tr = $db->queryRow($sql);
	$recordsTotal = $tr->recordsTotal;
} catch (Exception $e) {
	$response["error"] = $e->getMessage();
	echo json_encode($response);
	exit();
}


$sql = "SELECT COUNT(`scenario_id`) as recordsFiltered 
	FROM `scenario_templates` 
	WHERE $searchStr";
try {
	$tdr = $db->queryRow($sql);
	$recordsFiltered = $tdr->recordsFiltered;
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
		$row->DT_RowId = $row->scenario_id;
		$row->DT_RowClass = "";
		$row->disabled = ( $row->disabled == 1)
		? '<small class="pull-right"><a href="#" class="wdo-link" data-trigger="enable" data-type="scenario" data-id="'.$row->scenario_id.'">Включить</a></small><text class="text-warning">Отключена</text>' 
		: '<small class="pull-right"><a href="#" class="wdo-link" data-trigger="disable" data-type="scenario" data-id="'.$row->scenario_id.'">Отключить</a></small><text class="text-success">Активна</text>';
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
