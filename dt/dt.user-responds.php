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
$order = get_var("order","array",Array());
$columns = get_var("columns","array",Array());

$user_id = get_var("user_id","int",0);

$orderStr = "`user_responds`.`created` DESC";
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

$sql_main = "SELECT `id`,`project_id`,(SELECT `real_user_name` FROM `users` WHERE `user_id` = `author_id`) as `author_user_name`,`user_responds`.`descr`,`user_responds`.`created`,`grade`
	FROM `user_responds`
	WHERE `user_responds`.`user_id` = '$user_id'
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

$sql = "SELECT COUNT(`id`) as recordsTotal 
	FROM `user_responds`
	WHERE `user_responds`.`user_id` = '$user_id'";
try {
	$tr = $db->queryRow($sql);
	$recordsTotal = $tr->recordsTotal;
} catch (Exception $e) {
	$response["error"] = $e->getMessage();
	echo json_encode($response);
	exit();
}


$sql = "SELECT COUNT(`id`) as recordsFiltered 
	FROM `user_responds`
	WHERE `user_responds`.`user_id` = '$user_id'";
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
		$row->DT_RowId = $row->id;
		$row->DT_RowClass = "bg-white row-bordered";
		$row->user_name = User::get_real_user_name($user_id);
		// $row->author_user_name = User::get_real_user_name($row->author_id);
		$row->project = new Project($row->project_id);
		if ( $row->project->error ) {
			// echo $project->error;
			unset($aaData[$idx]);
			$recordsFiltered--;
			$recordsTotal--;
			continue;
		};
		$row->project->url = sprintf('
			<h6 style="font-weight: 800;"><a class="wdo-link text-purple" href="%s">%s</a></h6>
			<small><a class="wdo-link" href="%s">%s</a></small> / <small><a class="wdo-link" href="%s">%s</a></small> | <small class="text-muted timestamp" data-timestamp="%d"></small>
			',
			HOST.'/project/'.$row->project->cat_name_translated.'/'.$row->project->subcat_name_translated.'/p'.$row->project_id.'/'.strtolower(r2t($row->project->title)).'.html',$row->project->title, // project href link
			HOST.'/projects/'.$row->project->cat_name_translated.'/',$row->project->cat_name, // category href link
			HOST.'/projects/'.$row->project->cat_name_translated.'/'.$row->project->subcat_name_translated.'/',$row->project->subcat_name, $row->created // subcategory href link
		);
		if ( !$current_user->is_readed('user_respond',$row->id) )
		{
			$current_user->add_readed("user_respond",$row->id);
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
exit();
?>