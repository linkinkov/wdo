<?php
require_once('_global.php');
include_once('_includes.php');
require_once('lib/Resize.class.php');
require_once('lib/Avatar.class.php');
require_once('lib/Attach.class.php');
$db = db::getInstance();

check_access($db,false);
$current_user = new User($_SESSION["user_id"]);
$job = isset($_GET["job"]) ? trim($_GET["job"]) : false;
if ( !$job ) die("no data");
switch ( $job )
{
	case "Attach":
		$attach_id = get_var("attach_id","string","");
		$w = get_var("w","int",35);
		$h = get_var("h","int",35);
		$force_resize = get_var("force_resize","string","");
		$method = get_var("method","string","auto");
		Attach::getByID($attach_id,$w,$h,$force_resize,$method);
		break;
	case "AttachList":
		$for = get_var("for","string",'for_project_id');
		$id = get_var("id","int",0);
		$list = Attach::get_by_for_type($for,$id);
		header('Content-Type: application/json');
		echo json_encode($list);		
		break;
	case "cityList":
		$search = get_var("search","string");
		$print_user_city = get_var("print_user_city","string","false");
		$limit = get_var("limit","int",30);
		$cities = City::get_list($search,$limit,$print_user_city);
		header('Content-Type: application/json');
		echo json_encode($cities);
		break;
	case "subCatList":
		$parent_id = get_var("parent_id","int",1);
		$list = SubCategory::get_list($parent_id);
		header('Content-Type: application/json');
		echo json_encode($list);
		break;
	case "UserList":
		$search = get_var("search","string","");
		$list = User::get_list($search);
		header('Content-Type: application/json');
		echo json_encode($list);
		break;
	case "PortfolioList":
		$user_id = get_var("user_id","int",0);
		$list = Portfolio::get_list($user_id);
		header('Content-Type: application/json');
		echo json_encode($list);
		break;
	case "Portfolio":
		$portfolio_id = get_var("portfolio_id","int",0);
		$list = Portfolio::get_portfolio($portfolio_id);
		header('Content-Type: application/json');
		echo json_encode($list);
		break;
}