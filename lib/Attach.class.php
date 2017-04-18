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
			$not_found = PD.'/images/image-not-found.png';
			$requested = PD.'/attaches/'.$info->file_name;
			$cached = PD.'/attaches/cache/'.$info->file_name_no_ext.'-'.$w.'-'.$h.$extension;
			if ( $info->attach_type == "document" )
			{
				if ( file_exists($requested) )
				{
					ob_clean();
					header('Content-Description: File Transfer');
					header('Content-Type: application/octet-stream');
					header('Content-Disposition: attachment; filename='.basename($requested));
					header('Content-Transfer-Encoding: binary');
					header('Expires: 0');
					header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
					header('Pragma: public');
					header('Content-Length: ' . filesize($requested));
					readfile($requested);
					exit;
				}
				else
				{
					echo "<h1>Content error</h1><p>The file does not exist!</p>";
				}
			}
			else if ( $info->attach_type == "image" )
			{
				$content_type = 'image/'.substr($extension,1);
				// exit;
				if ( $extension == ".gif" && $h == 35 )
				{
					if ( !file_exists($requested) )
					{
						$requested = $not_found;
					}
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
				else
				{
					ob_clean();
					header('Content-Type: image/png');
					header('Content-Length: ' . filesize($not_found));
					readfile($not_found);
					exit;
				}
			}
			else
			{
				echo "<h1>Content error</h1><p>Unknown content type!</p>";
				exit;
			}
		}
		else
		{
			return false;
		}
	}
	
}

?>