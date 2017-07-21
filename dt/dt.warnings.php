<?php
require_once('../_global.php');
require_once('../_includes.php');

header('Content-Type: application/json');
$response = Array(
	"sEcho"=>0, 
	"fDBGenerated"=>0,
	"recordsTotal"=>0, 
	"recordsFiltered"=>0,
	"aaData"=>Array(),
	"message" => ""
);

$script_start = microtime(true);

$sEcho = get_var("draw","int",0);
$start = get_var("start","int",0);
$length = get_var("length","int",10);
$search = isset($_REQUEST["search"]["value"]) ? htmlspecialchars($_REQUEST["search"]["value"]) : "";
$order = get_var("order","array",Array());
$columns = get_var("columns","array",Array());

$start_date = get_var("start_date","int",time()-86400*7);
$end_date = get_var("end_date","int",time()+(86400*3));

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
$searchStr = "1";
$orderStr = isset($orderArr) ? implode(", ", $orderArr) : "`warnings`.`timestamp` ASC";
$timerange = sprintf(' AND (`timestamp` >= "%d" AND `timestamp` <= "%d")', $start_date, $end_date);


$sql_main = "SELECT `warnings`.`warning_id`,
		`warnings`.`timestamp`,
		`warnings`.`message`,
		`warnings`.`for_project_id`,
		`warnings`.`for_respond_id`
	FROM `warnings`
	WHERE `warnings`.`for_user_id` = '".$current_user->user_id."'
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

$sql = "SELECT COUNT(`warning_id`) as recordsTotal 
	FROM `warnings` 
	WHERE `for_user_id` = '".$current_user->user_id."'";
try {
	$tr = $db->queryRow($sql);
	$recordsTotal = $tr->recordsTotal;
} catch (Exception $e) {
	echo json_encode($response);
	exit();
}


$sql = "SELECT COUNT(`warning_id`) as recordsFiltered 
	FROM `warnings` 
	WHERE `for_user_id` = '".$current_user->user_id."'";
try {
	$tdr = $db->queryRow($sql);
	$recordsFiltered = $tdr->recordsFiltered;
} catch (Exception $e) {
	echo json_encode($response);
	exit();
}

if ( sizeof ($aaData) )
{
	foreach ( $aaData as $row )
	{
		$row->DT_RowId = $row->warning_id;
		$row->DT_RowClass = "pointer";
		if ( $row->for_project_id > 0 )
		{
			$project = new Project($row->for_project_id);
			$row->project_link = $project->project_link;
			$row->subject_title = mb_strimwidth($project->title,0,10,"...");
		}
		else if ( $row->for_respond_id > 0 )
		{
			$project_id = $db->getValue("project_responds","for_project_id","for_project_id",Array("respond_id"=>$row->for_respond_id));
			$subject_title = mb_strimwidth($db->getValue("project_responds","descr","descr",Array("respond_id"=>$row->for_respond_id)),0,10,"...");
			$project = new Project($project_id);
			$row->project_link = $project->project_link;
		}
		else
		{
			$row->subject_title = "";
			$row->project_link = "";
		}
		if ( !$current_user->is_readed('warning',$row->warning_id) )
		{
			$current_user->add_readed("warning",$row->warning_id);
			$row->DT_RowClass .= " unreaded";
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