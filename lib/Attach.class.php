<?php

class Attach
{

	public static function getByID($attach_id = false, $w=35, $h=35)
	{
		global $db;
		$sql = sprintf("SELECT `attach_id`,`attach_type`,`for_respond_id`,`file_name` FROM `attaches` WHERE `attach_id` = '%d'",$attach_id);
		$info = $db->queryRow($sql);
		if ( sizeof($info) )
		{
			$info->file_name_no_ext = substr($info->file_name,0,strlen($info->file_name)-strrchr($info->file_name, '.'));
			$extension = strtolower(strrchr($info->file_name, '.'));
			$requested = PD.'/attaches/'.$info->file_name;
			$cached = PD.'/attaches/cache/'.$info->file_name_no_ext.'-'.$w.'-'.$h.$extension;

			if ( $info->attach_type == "image" )
			{
				$content_type = 'image/gif';
				// exit;
				if ( $extension == ".gif" && $h == 35 && file_exists($requested) )
				{
					// echo "showing original: $requested";
					// exit;
					ob_clean();
					header('Content-Type: '.$content_type);
					header('Content-Length: ' . filesize($requested));
					readfile($requested);
					exit;
				}
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
					$resizeObj->resizeImage($w, $h, 'auto');
					$resizeObj->saveImage($cached, 50);
					header('Content-Type: '.$content_type);
					header('Content-Length: ' . filesize($cached));
					readfile($cached);
					exit;
				}
			}
		}
		else
		{
			return false;
		}
	}
	
}

?>