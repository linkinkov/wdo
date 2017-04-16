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
$status = get_var("status","string","");
$search = isset($_REQUEST["search"]["value"]) ? htmlspecialchars($_REQUEST["search"]["value"]) : "";
$order = get_var("order","array",Array());
$for_project_id = get_var("for_project_id","int",0);

if ( intval($for_project_id) == 0 ) exit;

$orderStr = isset($orderArr) ? implode(", ", $orderArr) : "`project_responds`.`created` DESC";
$searchStr = ( $search ) ? '(
		OR cost LIKE "%'.$search.'%"
		)' : '1' ;
$projectStr = ( $for_project_id != "" ) ? sprintf(' AND `for_project_id` = "%d"',$for_project_id) : '';
$statusStr = ( $status != "" ) ? sprintf(' AND `status_id` IN (%s)',$status) : '';

$sql_main = "SELECT `respond_id`
	FROM `project_responds`
	WHERE 1 $projectStr $statusStr
	ORDER BY $orderStr
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

$sql = "SELECT COUNT(`respond_id`) as recordsTotal FROM `project_responds` WHERE 1 $projectStr";
try {
	$tr = $db->queryRow($sql);
	$recordsTotal = $tr->recordsTotal;
} catch (Exception $e) {
	$response["error"] = $e->getMessage();
	header('Content-Type: application/json');
	echo json_encode($response);
	exit();
}


$sql = "SELECT COUNT(`respond_id`) as recordsFiltered 
	FROM `project_responds` 
	WHERE 1 $projectStr $statusStr";
try {
	$tdr = $db->queryRow($sql);
	$recordsFiltered = $tdr->recordsFiltered;
} catch (Exception $e) {
	$response["error"] = $e->getMessage();
	header('Content-Type: application/json');
	echo json_encode($response);
	exit();
}

if ( sizeof ($aaData) )
{
	$idx = 0;
	foreach ( $aaData as $row )
	{
		$row->DT_RowId = $row->respond_id;
		$row->DT_RowClass = "";
		$respond = new ProjectRespond($row->respond_id);
		if ( $respond->error ) {
			unset($aaData[$idx]);
			continue;
		}
		$respond->cost = number_format($respond->cost,0,","," ");
		$row->respond = $respond;
		$row->user = new User($respond->user_id);
		$row->user->getRespondsCounters();
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