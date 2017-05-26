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

$pp = Array("profile","projects","project-responds","messages","portfolio","portfolio-add","portfolio-edit","user-responds","scenarios");

if ( in_array($job,$pp) )
{
	$from_include = true;
	include(PD."/profile_pages/$job.php");
}
?>
<script>
$(function(){
	$(".loader").remove();
})
</script>