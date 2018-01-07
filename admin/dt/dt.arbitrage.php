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
$showParams = get_var("showParams","array",Array());
$selected_subcategory = get_var("selected_subcategory","string","");
$selected_city = get_var("selected_city","string","");
$selected_status = get_var("selected_status","string","");

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
$orderStr = isset($orderArr) ? implode(", ", $orderArr) : "`arbitrage`.`timestamp` DESC";

$searchStr = "";
if ( $search )
{
	foreach ( $orderColumns as $col )
	{
		$searchArr[] = sprintf("`%s` REGEXP '%s'",$col,$search);
	};
	$searchStr = '('.implode(" OR ",$searchArr).')';
}
else
{
	$searchStr = "1";
}


$selectedSubcategoryStr = ( $selected_subcategory != "" ) ? sprintf(' AND `subcat_id` IN (%s)',$selected_subcategory) : '';
$selectedCityStr = ( $selected_city != "" ) ? sprintf(' AND `project`.`city_id` IN (%s)',$selected_city) : '';
$selectedStatusStr = ( $selected_status != "" ) ? sprintf(' AND `arbitrage`.`status_id` IN (%s)',$selected_status) : '';


$sql_main = "SELECT 
	`ticket_id`,
	`title`,
	`cat_name`,
	`subcat_name`,
	`city_name`,
	`real_user_name`,
	`timestamp`,
	`timestamp_modified`,
	`arbitrage_statuses`.`status_name`,
	`arbitrage`.`status_id`,
	`cats`.`translated` as `cat_name_translated`,
	`subcats`.`translated` as `subcat_name_translated`,
	`arbitrage`.`project_id`,
	`arbitrage`.`user_id`
	-- (
	-- 	SELECT COUNT(`respond_id`) 
	-- 	FROM `project_responds` 
	-- 	WHERE `for_project_id` = `project_id` 
	-- 		AND `respond_id` NOT IN (
	-- 			SELECT `id` 
	-- 			FROM `user_readed_log` 
	-- 			WHERE `type`='project_respond' 
	-- 				AND `user_id` = '".$current_user->user_id."'
	-- 		)
	-- ) as `bids_new`
	FROM `arbitrage`
	LEFT JOIN `users` ON `users`.`user_id` = `arbitrage`.`user_id`
	LEFT JOIN `project` ON `project`.`project_id` = `arbitrage`.`project_id`
	LEFT JOIN `arbitrage_statuses` ON `arbitrage_statuses`.`id` = `arbitrage`.`status_id`
	LEFT JOIN `cats` ON `cats`.`id` = `project`.`cat_id`
	LEFT JOIN `subcats` ON `subcats`.`id` = `project`.`subcat_id`
	LEFT JOIN `cities` ON `cities`.`id` = `project`.`city_id`
	WHERE $searchStr $selectedSubcategoryStr $selectedCityStr $selectedStatusStr
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

$sql = "SELECT COUNT(`ticket_id`) as recordsTotal FROM `arbitrage` WHERE 1";
try {
	$tr = $db->queryRow($sql);
	$recordsTotal = $tr->recordsTotal;
} catch (Exception $e) {
	$response["error"] = $e->getMessage();
	echo json_encode($response);
	exit();
}


$sql = "SELECT COUNT(`ticket_id`) as recordsFiltered 
	FROM `arbitrage` 
	LEFT JOIN `users` ON `users`.`user_id` = `arbitrage`.`user_id`
	LEFT JOIN `project` ON `project`.`project_id` = `arbitrage`.`project_id`
	LEFT JOIN `arbitrage_statuses` ON `arbitrage_statuses`.`id` = `arbitrage`.`status_id`
	LEFT JOIN `cats` ON `cats`.`id` = `project`.`cat_id`
	LEFT JOIN `subcats` ON `subcats`.`id` = `project`.`subcat_id`
	LEFT JOIN `cities` ON `cities`.`id` = `project`.`city_id`
	WHERE $searchStr $selectedSubcategoryStr $selectedCityStr $selectedStatusStr
";
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
		$row->DT_RowId = $row->ticket_id;
		$row->DT_RowClass = "ticket pointer";
		switch ( $row->status_id )
		{
			case 1:
				$status_class = "text-info";
				break;
			case 2:
				$status_class = "text-warning";
				break;
			case 3:
				$status_class = "text-success";
				break;
			default:
				$status_class = "text-muted";
				break;
		}
		$row->status_name = sprintf('<text class="%s">%s</text>',$status_class,$row->status_name);
		$title_tr = strtolower(r2t($row->title));
		$row->project_link = HOST.'/project/'.$row->cat_name_translated.'/'.$row->subcat_name_translated.'/p'.$row->project_id.'/'.$title_tr.'.html';
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