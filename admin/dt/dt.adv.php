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

$status_id = get_var("status_id","string","");

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
$orderStr = isset($orderArr) ? implode(", ", $orderArr) : "`adv`.`created` DESC";

$searchStr = "";
if ( $search )
{
	foreach ( $orderColumns as $col )
	{
		// if ( !in_array($col,Array("cat_name","subcat_name")) ) continue;
		$searchArr[] = sprintf("`%s` REGEXP '%s'",$col,$search);
	};
	$searchStr = '('.implode(" OR ",$searchArr).')';
}
else
{
	$searchStr = "1";
}
$status_id = explode(",",$status_id);
// print_r($type);
$searchStr .= ( sizeof($status_id) > 0 && $status_id[0] != "" ) ? sprintf(" AND `status_id` IN ('%s')",implode("','",$status_id)) : "";
// echo $searchStr;
$sql_main = "SELECT
	`real_user_name`,
	`adv_id`,
	`title`,
	`descr`,
	`prolong_limit`,
	`prolong_days`,
	`created`,
	`modified`,
	`last_prolong`,
	`accepted`,
	`status_name`,
	`adv`.`status_id`
	FROM `adv`
	LEFT JOIN `users` ON `users`.`user_id` = `adv`.`user_id`
	LEFT JOIN `adv_statuses` ON `adv_statuses`.`status_id` = `adv`.`status_id`
	HAVING $searchStr
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
// echo $sql_main;
$recordsTotal = 0;
$recordsFiltered = 0;

$sql = "SELECT COUNT(`adv_id`) as recordsTotal FROM `adv` WHERE 1";
try {
	$tr = $db->queryRow($sql);
	$recordsTotal = $tr->recordsTotal;
} catch (Exception $e) {
	$response["error"] = $e->getMessage();
	echo json_encode($response);
	exit();
}


$sql = "SELECT
	`real_user_name`,
	`adv_id`,
	`title`,
	`descr`,
	`prolong_limit`,
	`prolong_days`,
	`created`,
	`modified`,
	`last_prolong`,
	`accepted`,
	`status_name`,
	`adv`.`status_id`
	FROM `adv`
	LEFT JOIN `users` ON `users`.`user_id` = `adv`.`user_id`
	LEFT JOIN `adv_statuses` ON `adv_statuses`.`status_id` = `adv`.`status_id`
	HAVING $searchStr";
try {
	// $tdr = $db->queryRow($sql);
	// $recordsFiltered = $tdr->recordsFiltered;
	$tdr = $db->query($sql);
	$recordsFiltered = $tdr->num_rows;
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
		$row->DT_RowId = $row->adv_id;
		$row->DT_RowClass = "";
		switch ( $row->status_id )
		{
			case "1":
				$row->status_name = sprintf('<text class="text-success">%s</text>',$row->status_name);
				break;
			case "2":
				$row->status_name = sprintf('<text class="text-warning">%s</text>',$row->status_name);
				break;
			case "3":
				$row->status_name = sprintf('<text class="text-muted">%s</text>',$row->status_name);
				break;
			case "4":
				$row->status_name = sprintf('<text class="text-muted">%s</text>',$row->status_name);
				break;
			case "5":
				$row->status_name = sprintf('<text class="text-danger">%s</text>',$row->status_name);
				break;
		}
		$row->adv_id = substr($row->adv_id,0,4) . '...' . substr($row->adv_id,-4,4);
		if ( in_array($row->status_id,Array('1','2','5')) )
		{
			$row->actions = '
			<div class="btn-group">
				<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" data-name="category" aria-haspopup="true" aria-expanded="false" style="width: 100%;"><i class="fa fa-cog"></i></button>
				<div class="dropdown-menu dropdown-menu-right">';
			if ( in_array($row->status_id,Array('2','5')) ) // if on moderate or declined
			{
				$row->actions .= '<a class="dropdown-item pointer" data-trigger="change_adv_status" data-value="1" style="width: auto;">Принять</a>';
			}
			if ( in_array($row->status_id,Array('1','2')) ) // if on moderate or active
			{
				$row->actions .= '<a class="dropdown-item pointer" data-trigger="change_adv_status" data-value="5" style="width: auto;">Отклонить</a>';
			}
			$row->actions .= '</div>
			</div>';
		}
		else
		{
			$row->actions = '';
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