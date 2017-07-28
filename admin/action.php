<?php
opcache_reset();
require_once('../_global.php');
require_once('../_includes.php');
require(PD.'/admin/check_admin.php');
check_access($db,true);

// print_r($current_user);
// exit;

if ( $current_user->user_id <= 0 ) exit("Access denied");

$job = get_var("job","string",false);
$type = get_var("type","string",false);

if ( $job == "block" )
{
	$message_text = get_var("message_text","string",false);
	$id = get_var("id","int",false);
	$recipient_id = get_var("recipient_id","int",false);
	if ( !$type || !$id || !$recipient_id || !$message_text ) die("no data");

	switch ( $type )
	{
		case "project":
			$response = Project::block($id,$recipient_id,$message_text);
			header('Content-Type: application/json');
			echo json_encode($response);
			break;
		case "user":
			$response = User::block($id,$recipient_id,$message_text);
			header('Content-Type: application/json');
			echo json_encode($response);
			break;
	}
}

if ( $job == "add" )
{
	$value = get_var("value","string","");
	switch ( $type )
	{
		case "category":
			$response = Category::add($value);
			header('Content-Type: application/json');
			echo json_encode($response);
			break;
		case "subcategory":
			$parent_cat_id = get_var("parent_cat_id","int",false);
			$response = SubCategory::add($parent_cat_id,$value);
			header('Content-Type: application/json');
			echo json_encode($response);
			break;
		case "scenario":
			$response = Scenario::add($value);
			header('Content-Type: application/json');
			echo json_encode($response);
			break;
	}
}

if ( $job == "update" )
{
	$name = get_var("name","string","");
	$value = ( in_array($name, Array("scenario_subcats")) ) ? get_var("value","array",Array()) : get_var("value","string","");
	$id = get_var("pk","int",0);
	switch ( $type )
	{
		case "scenario":
			$response = Scenario::update($id,$name,$value);
			header('Content-Type: application/json');
			echo json_encode($response);
			break;
		case "user":
			$user = new User($id);
			$data = Array(
				$name => $value
			);
			$response = $user->update_profile_info($data);
			header('Content-Type: application/json');
			echo json_encode($response);
			break;
	}
}

if ( $job == "disable" )
{
	$id = get_var("id","int",0);
	switch ( $type )
	{
		case "category":
			$response = Category::disable($id);
			header('Content-Type: application/json');
			echo json_encode($response);
			break;
		case "subcategory":
			$response = SubCategory::disable($id);
			header('Content-Type: application/json');
			echo json_encode($response);
			break;
		case "user":
			$response = User::disable($id);
			header('Content-Type: application/json');
			echo json_encode($response);
			break;
		case "scenario":
			$response = Scenario::disable($id);
			header('Content-Type: application/json');
			echo json_encode($response);
			break;
	}
}

if ( $job == "enable" )
{
	$id = get_var("id","int",0);
	switch ( $type )
	{
		case "category":
			$response = Category::enable($id);
			header('Content-Type: application/json');
			echo json_encode($response);
			break;
		case "subcategory":
			$response = SubCategory::enable($id);
			header('Content-Type: application/json');
			echo json_encode($response);
			break;
		case "user":
			$response = User::enable($id);
			header('Content-Type: application/json');
			echo json_encode($response);
			break;
		case "scenario":
			$response = Scenario::enable($id);
			header('Content-Type: application/json');
			echo json_encode($response);
			break;
	}
}

if ( $job == "delete" )
{
	$id = get_var("id","int",0);
	switch ( $type )
	{
		case "category":
			$response = Category::delete($id);
			header('Content-Type: application/json');
			echo json_encode($response);
			break;
		case "subcategory":
			$response = SubCategory::delete($id);
			header('Content-Type: application/json');
			echo json_encode($response);
			break;
		case "scenario":
			$response = Scenario::delete($id);
			header('Content-Type: application/json');
			echo json_encode($response);
			break;
	}
}
