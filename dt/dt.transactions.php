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

$start_date = get_var("start_date","int",time()-86400);
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
$orderStr = isset($orderArr) ? implode(", ", $orderArr) : "`wallet_transactions`.`timestamp` ASC";
$timerange = sprintf(' AND (`timestamp` >= "%d" AND `timestamp` <= "%d")', $start_date, $end_date);

$sql_main = "SELECT *
	FROM `wallet_transactions`
	LEFT JOIN `project` ON `project`.`project_id` = `wallet_transactions`.`for_project_id`
	WHERE 1 AND $searchStr $timerange AND `wallet_id` = (SELECT `wallet_id` FROM `user_wallets` WHERE `user_id` = '".$current_user->user_id."')
	ORDER $orderStr
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

$sql = "SELECT COUNT(`transaction_id`) as recordsTotal FROM `wallet_transactions` WHERE `wallet_id` = (SELECT `wallet_id` FROM `user_wallets` WHERE `user_id` = '".$current_user->user_id."')";
try {
	$tr = $db->queryRow($sql);
	$recordsTotal = $tr->recordsTotal;
} catch (Exception $e) {
	echo json_encode($response);
	exit();
}


$sql = "SELECT COUNT(`transaction_id`) as recordsFiltered 
	FROM `wallet_transactions` 
	WHERE $searchStr $timerange ";
try {
	$tdr = $db->queryRow($sql);
	$recordsFiltered = $tdr->recordsFiltered;
} catch (Exception $e) {
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
			// echo $project->error;
			unset($aaData[$idx]);
			$recordsFiltered--;
			$recordsTotal--;
			continue;
		}
		$project->cost = number_format($project->cost,0,","," ");
		$row->user = new User($project->user_id);
		// $title_tr = strtolower(r2t($project->title));
		if ( $project->vip == 1 ) $row->DT_RowClass .= " vip";
		if ( $current_user->user_id == $user_id )
		{
			$row->DT_RowClass .= " no-pointer";
			$row->performer_id = $row->performer_name;
			$row->performer_name = User::get_real_user_name($row->performer_id);
			if ( is_array($row->performer_name) ) $row->performer_name = '<small class="text-muted">Не выбран</small>';
		}
		switch ( $project->status_id )
		{
			case 1:
				$status_class = "text-success";
				break;
			case 2:
				$status_class = "text-info";
				break;
			case 3:
				$status_class = "text-purple";
				break;
			case 4:
				$status_class = "text-warning";
				break;
			case 5:
				$status_class = "text-danger";
				break;
			default:
				$status_class = "text-muted";
				break;
		}
		$project->status_name = sprintf('<text class="%s">%s</text>',$status_class,$project->status_name);
		if ( $row->bids_new > 0 ) $row->bids .= ' <text class="text-purple">(+'.$row->bids_new.')</text>';
		$row->project = $project;
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
?>