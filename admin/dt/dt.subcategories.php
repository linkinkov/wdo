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

$cat_id = get_var("cat_id","int",0);
$scenario_id = get_var("scenario_id","int",0);

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
		if ( !in_array($col,Array("subcat_name")) ) continue;
		$searchArr[] = sprintf("`%s` REGEXP '%s'",$col,$search);
	};
	$searchStr = '('.implode(" OR ",$searchArr).')';
}
else
{
	$searchStr = "1";
}
$parent_cat_id = ( $cat_id > 0 ) ? sprintf(" AND `parent_cat_id` = '%d'",$cat_id) : "";
// $include_scenario_id = ( $scenario_id != 0 ) ? sprintf(" AND FIND_IN_SET(`subcats`.`id`, (SELECT `scenario_subcats` FROM `scenario_templates` WHERE `scenario_id` = '%d'))",$scenario_id) : "";

$sql_main = "SELECT
	`subcats`.`id` as `subcat_id`,
	`subcats`.`sort`,
	`subcats`.`disabled`,
	`subcat_name`,
	(
		SELECT COUNT(`project`.`project_id`) 
		FROM `project` 
		WHERE `project`.`subcat_id` = `subcats`.`id`
	) as `projects_counter`,
	(
		SELECT COUNT(`portfolio`.`portfolio_id`) 
		FROM `portfolio` 
		WHERE `portfolio`.`subcat_id` = `subcats`.`id`
	) as `portfolio_counter`
	FROM `subcats`
	WHERE $searchStr $parent_cat_id
	ORDER BY $orderStr, subcat_id asc
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

$sql = "SELECT COUNT(`subcats`.`id`) as recordsTotal FROM `subcats` WHERE 1";
try {
	$tr = $db->queryRow($sql);
	$recordsTotal = $tr->recordsTotal;
} catch (Exception $e) {
	$response["error"] = $e->getMessage();
	echo json_encode($response);
	exit();
}


$sql = "SELECT COUNT(`subcats`.`id`) as recordsFiltered FROM `subcats` WHERE $searchStr $parent_cat_id";
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
	if ( $scenario_id > 0 )
	{
		$scenarios_subcats = $db->getValue("scenario_templates","scenario_subcats","scenario_subcats",Array("scenario_id"=>$scenario_id));
		if ( strlen($scenarios_subcats) > 0 )
		{
			$scenarios_subcats = explode(",",$scenarios_subcats);
		}
		else
		{
			$scenarios_subcats = Array();
		}
	}
	foreach ( $aaData as $row )
	{
		$row->DT_RowId = $row->subcat_id;
		$row->DT_RowClass = "";
		if ( $scenario_id == -1 )
		{
			$row->DT_RowClass .= "text-muted";
		}
		if ( $scenario_id > 0 )
		{
			$row->DT_RowClass = "pointer";
			if ( in_array($row->subcat_id,$scenarios_subcats) )
			{
				$row->DT_RowClass .= " selected";
			}
		}
		if ( $row->projects_counter == 0 && $row->portfolio_counter == 0 )
		{
			$row->subcat_name .= '<small class="pull-right"><a href="#" class="wdo-link" data-trigger="delete" data-type="subcategory" data-id="'.$row->subcat_id.'">Удалить</a></small>';
		}
		$row->disabled = ( $row->disabled == 1)
		? '<small class="pull-right"><a href="#" class="wdo-link" data-trigger="enable" data-type="subcategory" data-id="'.$row->subcat_id.'">Включить</a></small><text class="text-warning">Отключена</text>' 
		: '<small class="pull-right"><a href="#" class="wdo-link" data-trigger="disable" data-type="subcategory" data-id="'.$row->subcat_id.'">Отключить</a></small><text class="text-success">Активна</text>';

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