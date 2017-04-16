<ul class="list-group top-ten">
	<?php
	$users = $db->queryRows("SELECT `user_id`,`rating` FROM `users` ORDER BY `rating` DESC LIMIT 10");
	foreach ( $users as $r )
	{
		$userName = User::getRealUserName($r->user_id);
		if ( !is_array($userName) && $userName != "" )
			echo sprintf('<li class="list-group-item justify-content-between">
			<img class="rounded-circle" src="%s" /> <div style="max-width: 90px; word-wrap: break-word;">%s</div>
			<span class="badge bg-yellow badge-pill">%d</span>
			</li>',HOST.'/get.UserAvatar?user_id='.$r->user_id.'&w=45&h=45',$userName,$r->rating);
	}
	?>
</ul>