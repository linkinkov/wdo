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
$status = get_var("status_id","int",0);
$search = isset($_REQUEST["search"]["value"]) ? htmlspecialchars($_REQUEST["search"]["value"]) : "";
$order = get_var("order","array",Array());
$for_project_id = get_var("for_project_id","int",0);
// $status_id = get_var("status_id","int",0);

if ( intval($for_project_id) == 0 ) exit;

$orderStr = ( Project::get_accepted_respond($for_project_id) > 0 ) ? "`project_responds`.`status_id` DESC, `project_responds`.`created` DESC" : "`project_responds`.`created` DESC";
$searchStr = ( $search ) ? '(
		OR cost LIKE "%'.$search.'%"
		)' : '1' ;
$projectStr = ( $for_project_id != "" ) ? sprintf(' AND `for_project_id` = "%d"',$for_project_id) : '';
$statusStr = ( $status ) ? sprintf(' AND `status_id` IN (%s)',$status) : '';
$status_not_blocked = sprintf(' AND `status_id` != 4');
$sql_main = "SELECT `respond_id`
	FROM `project_responds`
	WHERE 1 $projectStr $statusStr $status_not_blocked
	ORDER BY $orderStr
	LIMIT $start, $length";
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

$sql = "SELECT COUNT(`respond_id`) as recordsTotal FROM `project_responds` WHERE 1 $projectStr $status_not_blocked";
try {
	$tr = $db->queryRow($sql);
	$recordsTotal = $tr->recordsTotal;
} catch (Exception $e) {
	$response["error"] = $e->getMessage();
	echo json_encode($response);
	exit();
}


$sql = "SELECT COUNT(`respond_id`) as recordsFiltered 
	FROM `project_responds` 
	WHERE 1 $projectStr $statusStr $status_not_blocked";
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
		$row->user->get_counters();
		$project_author_id = $db->getValue("project","user_id","user_id",Array("project_id"=>$respond->for_project_id));
		$row->is_project_author = ( $project_author_id == $current_user->user_id ) ? 1 : 0;
		if ( $row->is_project_author != 1 )
		{
			unset($row->respond->cost);
			unset($row->respond->status_id);
		}
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

echo json_encode($response);
exit();
?>