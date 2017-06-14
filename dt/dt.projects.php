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
$user_id = get_var("user_id","int",0);
// $for_profile = get_var("for_profile","string",false);

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
$orderStr = isset($orderArr) ? implode(", ", $orderArr) : "`project`.`project_id` ASC";
$searchStr = ( $search ) ? '(
		`title` LIKE "%'.$search.'%"
		OR FROM_UNIXTIME(`start_date`,"%d.%m.%Y") LIKE "%'.$search.'%"
		OR cost LIKE "%'.$search.'%"
		)' : '1' ;
$cityStr = ( isset($_COOKIE["city_id"]) && intval($_COOKIE["city_id"]) > 0 ) ? sprintf(" AND `city_id` = '%d'",intval($_COOKIE["city_id"])) : sprintf(" AND `city_id` = '%d'",1);
$statusStr = ( $status_id > 0 ) ? sprintf(' AND `status_id` = "%d"',$status_id) : '';
$selectedStr = ( $selected != "" ) ? sprintf(' AND `subcat_id` IN (%s)',$selected) : '';
$timerange = sprintf(' AND (`start_date` >= "%d" AND `end_date` <= "%d")', $start_date, $end_date);
$for_user_id = sprintf(' AND (`user_id` = "%d" OR `for_user_id` = "0" OR `for_user_id` = "%d")',$current_user->user_id,$current_user->user_id);
if ( $user_id > 0 )
{
	$author_id = sprintf(' AND (`user_id` = "%d")',$user_id);
	$timerange = "";
}
else
{
	$author_id = "";
}

$select_status_name = "";
$select_performer_name = "";
// if ( $for_profile == "true" )
if ( $current_user->user_id == $user_id )
{
	$select_status_name = ", `status_name`";
	$select_performer_name = ", (SELECT `user_id` FROM `project_responds` WHERE `for_project_id` = `project_id` AND `status_id` IN (3,5) ) as performer_name";
}

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

$select_new_bids = ( $current_user->user_id > 0 )
	? ", (SELECT COUNT(`respond_id`) FROM `project_responds` WHERE `for_project_id` = `project_id` AND `respond_id` NOT IN (SELECT `id` FROM `user_readed_log` WHERE `type`='project_respond' AND `user_id` = '".$current_user->user_id."')) as bids_new"
	: ", 0 as `bids_new`";


$sql_main = "SELECT `project_id`,
	(SELECT COUNT(`respond_id`) FROM `project_responds` WHERE `for_project_id` = `project_id`) as bids
	$select_new_bids
	$select_status_name
	$select_performer_name
	FROM `project`
	LEFT JOIN `project_statuses` ON `project_statuses`.`id` = `project`.`status_id`
	WHERE $searchStr $statusStr $cityStr $selectedStr $timerange $for_user_id $safe_vip $author_id
	ORDER BY `project`.`vip` DESC, $orderStr
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

$sql = "SELECT COUNT(`project_id`) as recordsTotal FROM `project` WHERE 1 $statusStr $cityStr $for_user_id $author_id";
try {
	$tr = $db->queryRow($sql);
	$recordsTotal = $tr->recordsTotal;
} catch (Exception $e) {
	echo json_encode($response);
	exit();
}


$sql = "SELECT COUNT(`project_id`) as recordsFiltered 
	FROM `project` 
	WHERE $searchStr $statusStr $cityStr $selectedStr $timerange $for_user_id $safe_vip $author_id";
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
		$status_style = "";
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
				$status_style = "font-size: 65%;";
				break;
		}
		$project->status_name = sprintf('<text class="%s" style="%s">%s</text>',$status_class,$status_style,$project->status_name);
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