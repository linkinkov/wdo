<?php

// check_access($db,false);
if ( $current_user->user_id <= 0 || $current_user->template_id != 2 )
{
	header("Location: ".HOST."/", 403);
	exit;
}
?>