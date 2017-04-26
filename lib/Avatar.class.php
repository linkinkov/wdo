<?php

class Avatar
{
	public static function loadDefault($w,$h)
	{
		$user_id = 'default';
		$ext = '.png';
		$content_type = 'image/png';

		$requested = PD.'/users/avatars/'.$user_id.$ext;
		$cached = PD.'/users/avatars/cache/'.$user_id.'-'.$w.'-'.$h.$ext;
		// cached avatar exists
		if ( file_exists($cached) )
		{
			// echo $cached;
			// return;
			ob_clean();
			header('Content-Type: '.$content_type);
			header('Content-Length: ' . filesize($cached));
			readfile($cached);
			exit;
		}
		elseif ( file_exists($requested) )
		{
			$resizeObj = new resize($requested);
			$resizeObj->resizeImage($w, $h, 'crop');
			$resizeObj->saveImage($cached, 20);
			ob_clean();
			header('Content-Type: '.$content_type);
			header('Content-Length: ' . filesize($cached));
			readfile($cached);
			exit;
		}
		else
		{
			// echo "LOADING FALSE;";
			return false;
		}
	}

	public static function getByUserID($user_id = false, $w=35, $h=35)
	{
		$requested = glob(PD."/users/avatars/$user_id.{jpg,png,jpeg,gif}", GLOB_BRACE);
		if ( intval($user_id) == 0 || sizeof($requested) == 0 )
		{
			Avatar::loadDefault($w,$h);
			exit;
		}
		$ext = strtolower(pathinfo($requested[0], PATHINFO_EXTENSION));
		switch ($ext) {
			case 'jpeg':
			case 'jpg':
				$content_type = 'image/jpeg';
				break;
			case 'png':
				$content_type = 'image/png';
				break;
			case 'gif':
				$content_type = 'image/gif';
				break;
			default:
				exit;
		}
		$requested = PD."/users/avatars/$user_id.$ext";
		$cached = PD."/users/avatars/cache/$user_id-$w-$h.$ext";
		// cached avatar exists
		if ( file_exists($cached) )
		{
		// echo "\ncached: ".$cached;
		// exit;
			ob_clean();
			header('Content-Type: '.$content_type);
			header('Content-Length: ' . filesize($cached));
			readfile($cached);
			exit;
		}
		elseif ( file_exists($requested) )
		{
			ob_clean();
			$resizeObj = new resize($requested);
			$resizeObj->resizeImage($w, $h, 'auto');
			$resizeObj->saveImage($cached, 90);
			header('Content-Type: '.$content_type);
			header('Content-Length: ' . filesize($cached));
			readfile($cached);
			exit;
		}
		else
		{
			Avatar::loadDefault($w,$h);
		}
	}

}

?>