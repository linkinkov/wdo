<?php
require_once('_global.php');
include_once('_includes.php');
require_once(PD.'/lib/Resize.class.php');
require_once(PD.'/lib/Avatar.class.php');
require_once(PD.'/lib/Attach.class.php');
$db = db::getInstance();
check_access($db,false);
$current_user = new User($_SESSION["user_id"]);
$job = get_var("job","string",false);
$user_id = get_var("user_id","int",$current_user->user_id);

if ( !$job ) echo "no data";

$user = new User($user_id);

$pp = Array("profile","projects","project-responds","messages","portfolio","portfolio-add","portfolio-edit");
$pp_actions = Array("portfolio-publish","portfolio-update","portfolio-delete_item");

if ( in_array($job,$pp) )
{
	include(PD."/profile_pages/$job.php");
}
else if ( in_array($job,$pp_actions) )
{
	if ( $job == "portfolio-publish" )
	{
		$data = get_var("data","array",Array());
		$response = Portfolio::publish($data);
		header('Content-Type: application/json');
		echo json_encode($response);
		exit;
	}
	elseif ( $job == "portfolio-update" )
	{
		$portfolio_id = get_var("portfolio_id","int",0);
		$attach_id = get_var("attach_id","string","");
		$action = get_var("action","string","delete-cover");
		$response = ( $action == "delete-cover" ) ? Portfolio::update($portfolio_id,"cover_id","") : Portfolio::update($portfolio_id,"cover_id",$attach_id);
		header('Content-Type: application/json');
		echo json_encode($response);
		exit;
	}
	elseif ( $job == "portfolio-delete_item" )
	{
		$portfolio_id = get_var("portfolio_id","int",0);
		$attach_id = get_var("attach_id","string","");
		$type = get_var("type","string","image");
		$response = Attach::delete($portfolio_id,$attach_id,$type);
		header('Content-Type: application/json');
		echo json_encode($response);
		exit;
	}
}
?>
<script>
$(function(){
	$(".loader").remove();
})
</script>