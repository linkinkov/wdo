<?php
ini_set("display_errors",1);
define('PD',DIRNAME(__FILE__));
$db = new mysqli("localhost","root","290233","wdo");
$db->query("set names utf8");

require_once('lib/mysqli.class.php');
$db = db::getInstance();

function r2t($string) {
	$converter = array(
		'а' => 'a',   'б' => 'b',   'в' => 'v',
		'г' => 'g',   'д' => 'd',   'е' => 'e',
		'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
		'и' => 'i',   'й' => 'y',   'к' => 'k',
		'л' => 'l',   'м' => 'm',   'н' => 'n',
		'о' => 'o',   'п' => 'p',   'р' => 'r',
		'с' => 's',   'т' => 't',   'у' => 'u',
		'ф' => 'f',   'х' => 'h',   'ц' => 'c',
		'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
		'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
		'э' => 'ye',   'ю' => 'yu',  'я' => 'ya',
		
		'А' => 'A',   'Б' => 'B',   'В' => 'V',
		'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
		'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
		'И' => 'I',   'Й' => 'Y',   'К' => 'K',
		'Л' => 'L',   'М' => 'M',   'Н' => 'N',
		'О' => 'O',   'П' => 'P',   'Р' => 'R',
		'С' => 'S',   'Т' => 'T',   'У' => 'U',
		'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
		'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
		'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
		'Э' => 'Ye',   'Ю' => 'Yu',  'Я' => 'Ya',
		' ' => '_'
	);
	return strtr($string, $converter);
}
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