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
			echo "LOADING FALSE;";
			return false;
		}
	}

	public static function getByUserID($user_id = false, $w=35, $h=35)
	{
		$ext = '.jpg';
		$content_type = 'image/jpeg';
		if ( intval($user_id) == 0 )
		{
			Avatar::loadDefault($w,$h);
		}
		$requested = PD.'/users/avatars/'.$user_id.$ext;
		$cached = PD.'/users/avatars/cache/'.$user_id.'-'.$w.'-'.$h.$ext;

		// cached avatar exists
		if ( file_exists($cached) )
		{
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
			$resizeObj->resizeImage($w, $h, 'crop');
			$resizeObj->saveImage($cached, 80);
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