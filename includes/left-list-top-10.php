<ul class="list-group top-ten">
	<?php
	// $users = $db->queryRows("SELECT `user_id`,`real_user_name`,`rating` FROM `users` ORDER BY `rating` DESC LIMIT 10");
	$users = User::get_list("",$_COOKIE["city_id"],10);
	foreach ( $users as $r )
	{
		echo sprintf('<a href="%s" class="wdo-link list-group-item justify-content-between">
		<img class="rounded-circle shadow" src="%s" /> <div class="user-name">%s</div>
		<span class="badge bg-yellow badge-pill">%d</span>
		</a>',$r["user_link"],$r["avatar_path"].'&w=45&h=45',$r["real_user_name"],$r["rating"]);
	}
	?>
	<li class="list-group-item justify-content-between" style="align-self: center;"><a href="/performers/" class="wdo-link text-yellow">Все исполнители</a></li>
</ul>