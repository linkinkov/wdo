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
$orderStr = isset($orderArr) ? implode(", ", $orderArr) : "`wallet_transactions`.`timestamp` ASC";
$timerange = sprintf(' AND (`timestamp` >= "%d" AND `timestamp` <= "%d")', $start_date, $end_date);


$sql_main = "SELECT `wallet_transactions`.`transaction_id`,
		`wallet_transactions`.`reference_id`,
		`wallet_transactions`.`type`,
		`wallet_transactions`.`amount`,
		`wallet_transactions`.`timestamp`,
		`wallet_transactions`.`descr`,
		`project`.`title` as `project_title`,
		`wallet_transactions`.`for_project_id`
	FROM `wallet_transactions`
	LEFT JOIN `project` ON `project`.`project_id` = `wallet_transactions`.`for_project_id`
	WHERE `wallet_id` = (
			SELECT `wallet_id` 
			FROM `user_wallets` 
			WHERE `user_id` = '".$current_user->user_id."'
		)
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

$sql = "SELECT COUNT(`transaction_id`) as recordsTotal 
	FROM `wallet_transactions` 
	WHERE `wallet_id` = (
			SELECT `wallet_id` 
			FROM `user_wallets` 
			WHERE `user_id` = '".$current_user->user_id."'
		)";
try {
	$tr = $db->queryRow($sql);
	$recordsTotal = $tr->recordsTotal;
} catch (Exception $e) {
	echo json_encode($response);
	exit();
}


$sql = "SELECT COUNT(`transaction_id`) as recordsFiltered 
	FROM `wallet_transactions` 
	WHERE `wallet_id` = (
			SELECT `wallet_id` 
			FROM `user_wallets` 
			WHERE `user_id` = '".$current_user->user_id."'
		)";
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
		$row->DT_RowId = $row->transaction_id;
		$row->DT_RowClass = "pointer";
		switch ( $row->type )
		{
			case "WITHDRAWAL":
				$row->type = sprintf('<text class="text-danger">%s</text>','Списание');
				break;
			case "HOLD":
				$row->type = sprintf('<text class="text-warning">%s</text>','Удержание');
				break;
			case "PAYMENT":
				$row->type = sprintf('<text class="text-success">%s</text>','Пополнение');
				break;
		}
		if ( $row->for_project_id > 0 )
		{
			$project = new Project($row->for_project_id);
			$row->project_link = $project->project_link;
		}
		else
		{
			$row->project_title = "";
			$row->project_link = "";
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