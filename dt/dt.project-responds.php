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
$columns = get_var("columns","array",Array());
$for_project_id = get_var("for_project_id","int",0);
$for_profile = get_var("for_profile","string",false);

if ( !$for_profile && intval($for_project_id) == 0 ) exit;
$respond_user_id = "";

$orderStr = ( Project::get_accepted_respond($for_project_id) > 0 ) ? "`project_responds`.`status_id` DESC, `project_responds`.`created` DESC" : "`project_responds`.`created` DESC";
$searchStr = ( $search ) ? '(
		OR cost LIKE "%'.$search.'%"
		)' : '1' ;
$projectStr = ( $for_project_id ) ? sprintf(' AND `for_project_id` = "%d"',$for_project_id) : '';
$statusStr = ( $status > 0 ) ? sprintf(' AND `status_id` IN (%s)',$status) : '';
$status_not_blocked = sprintf(' AND `status_id` != 4');
$join = '';
if ( $for_profile )
{
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
			if ($ord["dir"])
			{
				$orderArr[] = $orderColumns[$ord["column"]] . " " . $ord["dir"];
			}
		}
	}
	$orderStr = isset($orderArr) ? implode(", ", $orderArr) : "`project`.`modified_timestamp` ASC";
	$respond_user_id = sprintf(' AND `project_responds`.`user_id` = "%d"',$current_user->user_id);
	$status_not_blocked = '';
	$join = 'LEFT JOIN `project` ON `project`.`project_id` = `project_responds`.`for_project_id`';
}
$sql_main = "SELECT `respond_id`
	FROM `project_responds`
	$join
	WHERE 1 $projectStr $statusStr $status_not_blocked $respond_user_id
	ORDER BY $orderStr
	LIMIT $start, $length";
	// echo $sql_main;
try {
	$aaData = $db->queryRows($sql_main);
} catch (Exception $e) {
	$response["error"] = $e->getMessage();
	echo json_encode($response);
	exit();
}
$recordsTotal = 0;
$recordsFiltered = 0;

$sql = "SELECT COUNT(`respond_id`) as recordsTotal 
	FROM `project_responds` 
	$join
	WHERE 1 $projectStr $status_not_blocked $respond_user_id";
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
	$join
	WHERE 1 $projectStr $statusStr $status_not_blocked $respond_user_id";
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
	$idx = -1;
	foreach ( $aaData as $row )
	{
		$idx++;
		$row->DT_RowId = $row->respond_id;
		$row->DT_RowClass = "";
		$respond = new ProjectRespond($row->respond_id);
		if ( $respond->error == true ) {
			unset($aaData[$idx]);
			$recordsTotal--;
			$recordsFiltered--;
			continue;
		}
		if ( isset($respond->cost) ) $respond->cost = number_format($respond->cost,0,","," ");
		$row->respond = $respond;
		$row->user = new User($respond->user_id);
		$row->user->get_counters();
		$project_author_id = $db->getValue("project","user_id","user_id",Array("project_id"=>$respond->for_project_id));
		$row->is_project_author = ( $project_author_id == $current_user->user_id ) ? 1 : 0;
		
		if ( $for_profile )
		{
			$row->DT_RowClass = "project-respond-entry no-pointer";
			$row->project = new Project($respond->for_project_id);
			if ( $row->project->error == 1 )
			{
				unset($aaData[$idx]);
				$recordsTotal--;
				$recordsFiltered--;
				continue;
			}
			$row->project_user = new User($row->project->user_id);
			if ( $row->respond->status_id == 1 ) $row->respond->status_name = 'Рассматривается';
			$row->respond->image_path = HOST.'/images/respond-status-'.$row->respond->status_id.'.png';
			// $cat_tr = strtolower(r2t($row->project->cat_name));
			// $subcat_tr = strtolower(r2t($row->project->subcat_name));
			$title_tr = strtolower(r2t($row->project->title));
			$row->project_link = HOST.'/project/'.$row->project->cat_name_translated.'/'.$row->project->subcat_name_translated.'/p'.$row->project->project_id.'/'.$title_tr.'.html';
			if ( $row->respond->modify_timestamp >= $current_user->ts_project_responds )
			{
				$row->DT_RowClass .= " unreaded";
			}
		}
		// else if ( $row->is_project_author != 1 )
		// {
		// 	unset($row->respond->cost);
		// 	unset($row->respond->status_id);
		// }
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