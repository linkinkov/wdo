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

$type = get_var("type","string","");

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
$orderStr = isset($orderArr) ? implode(", ", $orderArr) : "`transactions`.`timestamp` DESC";

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
$type = explode(",",$type);
// print_r($type);
$searchStr .= ( sizeof($type) > 0 && $type[0] != "" ) ? sprintf(" AND `type` IN ('%s')",implode("','",$type)) : "";
// echo $searchStr;
$sql_main = "SELECT
	(SELECT `real_user_name` FROM `users` WHERE `user_id` = (SELECT `user_id` FROM `user_wallets` WHERE `wallet_id` = `wallet_transactions`.`wallet_id` LIMIT 1)) as `real_user_name`,
	`transaction_id`,
	`reference_id`,
	`wallet_transactions`.`wallet_id`,
	`amount`,
	`type`,
	IF(`type`='PAYMENT','Зачисление',IF(`type`='HOLD','Удержание','Списание')) as `type_name`,
	`timestamp`,
	`descr`
	FROM `wallet_transactions`
	HAVING $searchStr
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

$sql = "SELECT COUNT(`transaction_id`) as recordsTotal FROM `wallet_transactions` WHERE 1";
try {
	$tr = $db->queryRow($sql);
	$recordsTotal = $tr->recordsTotal;
} catch (Exception $e) {
	$response["error"] = $e->getMessage();
	echo json_encode($response);
	exit();
}


$sql = "SELECT
	(SELECT `real_user_name` FROM `users` WHERE `user_id` = (SELECT `user_id` FROM `user_wallets` WHERE `wallet_id` = `wallet_transactions`.`wallet_id` LIMIT 1)) as `real_user_name`,
	`transaction_id`,
	`reference_id`,
	`wallet_transactions`.`wallet_id`,
	`amount`,
	`type`,
	IF(`type`='PAYMENT','Зачисление',IF(`type`='HOLD','Удержание','Списание')) as `type_name`,
	`timestamp`,
	`descr`
	FROM `wallet_transactions`
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
		$row->DT_RowId = $row->transaction_id;
		$row->DT_RowClass = "";
		switch ( $row->type )
		{
			case "PAYMENT":
				$row->type_name = sprintf('<text class="text-success">%s</text>',$row->type_name);
				break;
			case "HOLD":
				$row->type_name = sprintf('<text class="text-warning">%s</text>',$row->type_name);
				break;
			case "WITHDRAWAL":
				$row->type_name = sprintf('<text class="text-danger">%s</text>',$row->type_name);
				break;
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