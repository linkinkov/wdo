<?php

if ( isset($_SERVER["REQUEST_URI"]) && preg_match('/admin/',$_SERVER["REQUEST_URI"]) )
{
	if ( $current_user->user_id <= 0 || $current_user->template_id != 2 )
	{
		header("Location: ".HOST."/", 403);
		exit;
	}
}
?>