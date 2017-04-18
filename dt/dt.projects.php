<?php
require_once('../_global.php');
require_once('../_includes.php');
check_access($db,false);

$current_user = new User($_SESSION["user_id"]);

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
$showParams = get_var("showParams","array",Array());
$selected = get_var("selected","string","");
$status_id = get_var("status_id","int",1);
$start_date = get_var("start_date","int",time());
$end_date = get_var("end_date","int",time()+(86400*3));
$only_vip = get_var("vip","string",false);
$only_safe = get_var("safe_deal","string",false);
// print_r($only_vip);
// print_r($only_safe);
if (sizeof($columns) > 0)
{
	foreach($columns as $idx=>$col)
	{
		$orderColumns[] = $col["data"];
	}
}
if (sizeof($order) > 0)
{
	foreach($order as $ord)
	{
		if ($ord["dir"])
		{
			$orderArr[] = $orderColumns[$ord["column"]] . " " . $ord["dir"];
		}
	}
}
$orderStr = isset($orderArr) ? implode(", ", $orderArr) : "`project`.`project_id` ASC";
$searchStr = ( $search ) ? '(
		`title` LIKE "%'.$search.'%"
		OR FROM_UNIXTIME(`start_date`,"%d.%m.%Y") LIKE "%'.$search.'%"
		OR cost LIKE "%'.$search.'%"
		)' : '1' ;
$cityStr = ( isset($_COOKIE["city_id"]) && intval($_COOKIE["city_id"]) > 0 ) ? sprintf(" AND `city_id` = '%d'",intval($_COOKIE["city_id"])) : sprintf(" AND `city_id` = '%d'",1);
$statusStr = ( $status_id ) ? sprintf(' AND `status_id` = "%d"',$status_id) : '';
$selectedStr = ( $selected != "" ) ? sprintf(' AND `subcat_id` IN (%s)',$selected) : '';
$timerange = sprintf(' AND (`start_date` >= "%d" AND `end_date` <= "%d")', $start_date, $end_date);
$for_user_id = sprintf(' AND (`for_user_id` = "%d" OR `for_user_id` = "%d")',0,$current_user->user_id);

$safe_vip = "";
if ( $only_safe == "true" && $only_vip == "true" )
{
	$safe_vip = sprintf(' AND (`safe_deal` = 1 OR `vip` = 1)');
}
else if ( $only_safe == "true" )
{
	$safe_vip = sprintf(' AND `safe_deal` = 1');
}
else if ( $only_vip == "true" )
{
	$safe_vip = sprintf(' AND `vip` = 1');
}

$sql_main = "SELECT `project_id`,(SELECT COUNT(`respond_id`) FROM `project_responds` WHERE `for_project_id` = `project_id`) as bids
	FROM `project`
	WHERE $searchStr $statusStr $cityStr $selectedStr $timerange $for_user_id $safe_vip
	ORDER BY `project`.`vip` DESC, $orderStr
	LIMIT $start, $length";
try {
	$aaData = $db->queryRows($sql_main);
} catch (Exception $e) {
	$response["error"] = $e->getMessage();
	// echo $sql_main;
	header('Content-Type: application/json');
	echo json_encode($response);
	exit();
}
$recordsTotal = 0;
$recordsFiltered = 0;

$sql = "SELECT COUNT(`project_id`) as recordsTotal FROM `project` WHERE 1 $statusStr $cityStr $for_user_id";
try {
	$tr = $db->queryRow($sql);
	$recordsTotal = $tr->recordsTotal;
} catch (Exception $e) {
	header('Content-Type: application/json');
	echo json_encode($response);
	exit();
}


$sql = "SELECT COUNT(`project_id`) as recordsFiltered 
	FROM `project` 
	WHERE $searchStr $statusStr $cityStr $selectedStr $timerange $for_user_id $safe_vip";
try {
	$tdr = $db->queryRow($sql);
	$recordsFiltered = $tdr->recordsFiltered;
} catch (Exception $e) {
	header('Content-Type: application/json');
	echo json_encode($response);
	exit();
}

if ( sizeof ($aaData) )
{
	$idx = 0;
	foreach ( $aaData as $row )
	{
		$row->DT_RowId = $row->project_id;
		$row->DT_RowClass = "project-entry";
		$project = new Project($row->project_id);
		if ( $project->error ) {
			unset($aaData[$idx]);
			continue;
		}
		$project->cost = number_format($project->cost,0,","," ");
		$row->project = $project;
		$row->user = new User($project->user_id);
		$cat_tr = strtolower(r2t($project->cat_name));
		$subcat_tr = strtolower(r2t($project->subcat_name));
		$title_tr = strtolower(r2t($project->title));
		$row->project_link = HOST.'/project/'.$cat_tr.'/'.$subcat_tr.'/p'.$row->project_id.'/'.$title_tr.'.html';
		if ( $project->vip == 1 ) $row->DT_RowClass .= " vip";
		$idx++;
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

header('Content-Type: application/json');
echo json_encode($response);
exit();
?>