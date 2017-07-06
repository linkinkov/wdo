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
$vip = get_var("vip","string","");
$safe_deal = get_var("safe_deal","string","");

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
$orderStr = isset($orderArr) ? implode(", ", $orderArr) : "`project`.`created` DESC";

$searchStr = "";
if ( $search )
{
	foreach ( $orderColumns as $col )
	{
		if ( in_array($col,Array("bids")) ) continue;
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
$selectedStatusStr = ( $selected_status != "" ) ? sprintf(' AND `project`.`status_id` IN (%s)',$selected_status) : '';


$safe_vip = "";
if ( $safe_deal == "1" && $vip == "1" )
{
	$safe_vip = sprintf(' AND (`safe_deal` = 1 AND `vip` = 1)');
}
else if ( $safe_deal == "1" )
{
	$safe_vip = sprintf(' AND `safe_deal` = 1');
}
else if ( $vip == "1" )
{
	$safe_vip = sprintf(' AND `vip` = 1');
}

$sql_main = "SELECT 
	`project_id`,
	`real_user_name`,
	`title`,`cat_name`,
	`subcat_name`,
	`city_name`,
	`created`,
	`cost`,
	`status_name`,
	`safe_deal`,
	`vip`,
	`project`.`status_id`,
	`project`.`user_id`,
	`cats`.`translated` as `cat_name_translated`,
	`subcats`.`translated` as `subcat_name_translated`,
	(
		SELECT COUNT(`respond_id`) 
		FROM `project_responds` 
		WHERE `for_project_id` = `project_id`
	) as `bids`,
	(
		SELECT COUNT(`respond_id`) 
		FROM `project_responds` 
		WHERE `for_project_id` = `project_id` 
			AND `respond_id` NOT IN (
				SELECT `id` 
				FROM `user_readed_log` 
				WHERE `type`='project_respond' 
					AND `user_id` = '".$current_user->user_id."'
			)
	) as `bids_new`
	FROM `project`
	LEFT JOIN `users` ON `users`.`user_id` = `project`.`user_id`
	LEFT JOIN `project_statuses` ON `project_statuses`.`id` = `project`.`status_id`
	LEFT JOIN `cats` ON `cats`.`id` = `project`.`cat_id`
	LEFT JOIN `subcats` ON `subcats`.`id` = `project`.`subcat_id`
	LEFT JOIN `cities` ON `cities`.`id` = `project`.`city_id`
	WHERE $searchStr $safe_vip $selectedSubcategoryStr $selectedCityStr $selectedStatusStr
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

$sql = "SELECT COUNT(`project_id`) as recordsTotal FROM `project` WHERE 1";
try {
	$tr = $db->queryRow($sql);
	$recordsTotal = $tr->recordsTotal;
} catch (Exception $e) {
	$response["error"] = $e->getMessage();
	echo json_encode($response);
	exit();
}


$sql = "SELECT COUNT(`project_id`) as recordsFiltered 
	FROM `project` 
	LEFT JOIN `users` ON `users`.`user_id` = `project`.`user_id`
	LEFT JOIN `project_statuses` ON `project_statuses`.`id` = `project`.`status_id`
	LEFT JOIN `cats` ON `cats`.`id` = `project`.`cat_id`
	LEFT JOIN `subcats` ON `subcats`.`id` = `project`.`subcat_id`
	LEFT JOIN `cities` ON `cities`.`id` = `project`.`city_id`
	WHERE $searchStr $safe_vip $selectedSubcategoryStr $selectedCityStr $selectedStatusStr
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
		$row->DT_RowId = $row->project_id;
		$row->DT_RowClass = "project pointer";
		$row->cost = number_format($row->cost,0,","," ");
		switch ( $row->status_id )
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
			case 6:
				$status_class = "text-warning";
				break;
			default:
				$status_class = "text-muted";
				break;
		}
		$row->flags = Array(
			"safe_deal" => $row->safe_deal,
			"vip" => $row->vip
		);
		$row->status_name = sprintf('<text class="%s">%s</text>',$status_class,$row->status_name);
		if ( $row->bids_new > 0 ) $row->bids .= ' <text class="text-purple">(+'.$row->bids_new.')</text>';
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