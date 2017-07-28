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
		if ( !in_array($col,Array("cat_name","subcat_name")) ) continue;
		$searchArr[] = sprintf("`%s` REGEXP '%s'",$col,$search);
	};
	$searchStr = '('.implode(" OR ",$searchArr).')';
}
else
{
	$searchStr = "1";
}


$sql_main = "SELECT
	`cats`.`id` as `cat_id`,
	`cats`.`sort`,
	`cats`.`disabled`,
	`cat_name`,
	(
		SELECT COUNT(`subcats`.`id`) 
		FROM `subcats` 
		WHERE `parent_cat_id` = `cats`.`id` 
	) as `subcats_counter`,
	(
		SELECT COUNT(`project`.`project_id`) 
		FROM `project` 
		WHERE `cats`.`id` = `cat_id` 
	) as `projects_counter`,
	(
		SELECT COUNT(`portfolio`.`portfolio_id`) 
		FROM `portfolio` 
		WHERE `cats`.`id` = `cat_id` 
	) as `portfolio_counter`
	FROM `cats`
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

$sql = "SELECT COUNT(`cats`.`id`) as recordsTotal FROM `cats` WHERE 1";
try {
	$tr = $db->queryRow($sql);
	$recordsTotal = $tr->recordsTotal;
} catch (Exception $e) {
	$response["error"] = $e->getMessage();
	echo json_encode($response);
	exit();
}


$sql = "SELECT COUNT(`cats`.`id`) as recordsFiltered 
	FROM `cats` 
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
		$row->DT_RowId = $row->cat_id;
		$row->DT_RowClass = "";
		if ( $row->projects_counter == 0 && $row->portfolio_counter == 0 )
		{
			$row->cat_name .= '<small class="pull-right"><a href="#" class="wdo-link" data-trigger="delete" data-type="category" data-id="'.$row->cat_id.'">Удалить</a></small>';
		}
		$row->disabled = ( $row->disabled == 1)
		? '<small class="pull-right"><a href="#" class="wdo-link" data-trigger="enable" data-type="category" data-id="'.$row->cat_id.'">Включить</a></small><text class="text-warning">Отключена</text>' 
		: '<small class="pull-right"><a href="#" class="wdo-link" data-trigger="disable" data-type="category" data-id="'.$row->cat_id.'">Отключить</a></small><text class="text-success">Активна</text>';
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