<?php
require_once('../../_global.php');
require_once('../../_includes.php');
require(PD.'/admin/check_admin.php');

$script_start = microtime(true);
$aaData = $db->queryRows("SELECT * FROM `banners` ORDER BY `timestamp` DESC");

foreach ( $aaData as &$banner )
{
	$files = glob(sprintf("%s/banners/%s.{jpg,png,jpeg,gif}",PD,$banner->id),GLOB_BRACE);
	foreach ( $files as &$file )
	{
		$file = str_replace(PD,'',$file);
	}
	if ( sizeof($files) ) $banner->files = $files;
}

$response = Array(
	"fDBGenerated"=>number_format((microtime(true) - $script_start),2),
	"recordsTotal"=>sizeof($aaData), 
	"data"=>$aaData,
);

header('Content-Type: application/json');
echo json_encode($response);
?>