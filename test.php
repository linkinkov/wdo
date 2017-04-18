<?php
ini_set("display_errors",1);
define('PD',DIRNAME(__FILE__));
$db = new mysqli("localhost","root","290233","wdo");
$db->query("set names utf8");

require_once('lib/mysqli.class.php');
$db = db::getInstance();
$url = 'https://www.youtube.com/watch?v=H9mNjb9XYy8&qwejozxcn';
$url = 'http://youtu.be/dQw4w9WgXcQ';
if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
	$video_id = $match[1];
}
// preg_match_all('/http[s]\:\/\/[www\.]youtube.com\/watch\?v=([a-zA-Z0-9]+)/',$url,$id);
print_r($video_id);

exit;

$r_id = 2;
$user_id = 1;

$filename = md5($r_id.$user_id.time());
echo $filename;

exit;
/*
$rows = $db->query("SELECT `project_id`,`project_cat_id` FROM `projects`");
while ( $row = $rows->fetch_object() )
{
	$subcat_id = ( $row->project_cat_id == 1 ) ? rand(1,3) : rand(4,6);
	$sql = "UPDATE `projects` SET `project_subcat_id` = '$subcat_id' WHERE `project_id` = '$row->project_id'";
	$db->query($sql);
	echo "set subcat = $subcat_id for project $row->project_id ($row->project_cat_id)\n";
}

*/
$rows = $db->queryRows("SELECT `id`,`subcat_name` FROM `subcats`");
foreach ( $rows as $row )
{
	$sql = sprintf("UPDATE `subcats` SET `transliterated` = '%s' WHERE `id` = '%d'",r2t($row->subcat_name),$row->id);
	$db->query($sql);
	// echo "set subcat = $subcat_id for project $row->project_id ($row->project_cat_id)\n";
}


exit;
for($i=131; $i<=200; $i++)
{
	$cost = rand(500,5000);
	$title = "project ".$i;
	$descr = "project $i descr";
	$created = time()-(86400*$i);
	$start_date = $created + (86400+rand(3,14)*$i);
	$end_date = $start_date;
	$cat_id = rand(1,2);
	$city_id = rand(1,4);
	if ( $i%3 == 0 ) $end_date = $start_date + (86400+rand(1,3)*$i);
	$str = sprintf("INSERT INTO `project` (`project_id`,`title`, `descr`, `cost`, `created`, `status_id`, `user_id`, `start_date`, `end_date`,`cat_id`,`city_id`)
	VALUES ($i, '%s', '%s', %d, %d, 1, 1, %d, %d, %d, %d);",$title,$descr,$cost,$created,$start_date,$end_date,$cat_id,$city_id);
	echo $str."\n";
	// $sql = sprintf("UPDATE `projects` SET `created` = '%d',`start_date` = '%d',`end_date` = '%d' WHERE `project_id` = '%d'",$created,$start_date,$end_date,$i);
	$db->query($str);
}