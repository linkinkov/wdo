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

$script_start = microtime(true);

$sEcho = get_var("draw","int",0);
$start = get_var("start","int",0);
$length = get_var("length","int",10);
$search = isset($_REQUEST["search"]["value"]) ? htmlspecialchars($_REQUEST["search"]["value"]) : "";
$order = get_var("order","array",Array());
$order_by = get_var("order_by","array",Array());
$selected = get_var("selected","string","");

$cityStr = ( isset($_COOKIE["city_id"]) && intval($_COOKIE["city_id"]) > 0 ) ? sprintf(" AND `city_id` = '%d'",intval($_COOKIE["city_id"])) : sprintf(" AND `city_id` = '%d'",1);
$selectedStr = ( $selected != "" ) ? sprintf(' AND `subcat_id` IN (%s)',$selected) : '';

$sql_main = "SELECT `user_id`,`real_user_name`,
	(SELECT COUNT(`id`) FROM `user_responds` WHERE `user_id` = `users`.`user_id`) as `user_responds`
	FROM `users`
	WHERE `status_id` = 1 AND `as_performer` = 1 $cityStr
	ORDER BY `users`.`rating` DESC
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

$sql = "SELECT COUNT(`user_id`) as recordsTotal FROM `users` WHERE `status_id` = 1 AND `as_performer` = 1 $cityStr";
try {
	$tr = $db->queryRow($sql);
	$recordsTotal = $tr->recordsTotal;
} catch (Exception $e) {
	echo json_encode($response);
	exit();
}


$sql = "SELECT COUNT(`user_id`) as recordsFiltered 
	FROM `users` 
	WHERE `status_id` = 1 AND `as_performer` = 1 $cityStr";
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
		$row->DT_RowId = $row->user_id;
		$row->DT_RowClass = "performer-entry";
		$user = new User($row->user_id);
		if ( isset($user->error) && $user->error == true ) {
			// echo $project->error;
			unset($aaData[$idx]);
			$recordsFiltered--;
			$recordsTotal--;
			continue;
		}
		$user->get_counters();
		$row->user = $user;
		$row->portfolios = $user->get_portfolio_list();
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