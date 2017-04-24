<?php

class Attach
{

	public static function getByID($attach_id = false, $w=35, $h=35)
	{
		global $db;
		$sql = sprintf("SELECT `attach_id`,`attach_type`,`for_project_id`,`for_respond_id`,`file_name`,`user_id` FROM `attaches` WHERE `attach_id` = '%d'",$attach_id);
		$info = $db->queryRow($sql);
		if ( sizeof($info) )
		{
			$info->file_name_no_ext = substr($info->file_name,0,strlen($info->file_name)-strrchr($info->file_name, '.'));
			$extension = strtolower(strrchr($info->file_name, '.'));
			$not_found = PD.'/images/image-not-found.png';
			$requested = PD.'/attaches/'.$info->user_id.'/'.$info->file_name;
			$cached = PD.'/attaches/'.$info->user_id.'/cache/'.$info->file_name_no_ext.'-'.$w.'-'.$h.$extension;
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
				if ( $extension == ".gif" )
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
				// echo "getting:".$requested.", cached:".$cached." / ".dirname($cached);
				// exit;
					ob_clean();
					$resizeObj = new resize($requested);
					$resizeObj->resizeImage($w, $h, 'auto');
					if ( !file_exists(dirname($cached)) ) @mkdir(dirname($cached));
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

	public static function get_by_for_type($for='for_project_id',$id=false)
	{
		global $db;
		if ( !$id ) return false;
		$sql = sprintf("SELECT `attach_id`,`attach_type`,`url` FROM `attaches` WHERE `%s` = '%d' ORDER BY `attach_type`, `attach_id` ASC",$for,$id);
		try {
			$list = $db->queryRows($sql);
			$idx = 0;
			foreach ( $list as $row )
			{
				if ( $row->attach_type == 'video' )
				{
					if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $row->url, $match)) {
						$row->youtube_id = $match[1];
					}
					else
					{
						unset($list[$idx]);
					}
				}
				else
				{
					unset($row->url);
				}
				$idx++;
			}
			return $list;
		}
		catch (Exception $e)
		{
			return Array();
		}
	}


	public static function save_from_user_upload_dir($for='for_project_id',$id = false,$urls = false)
	{
		global $db;
		global $current_user;
		$session = session_id();
		$upload_dir = PD."/upload/files/$session/";
		$target_dir = PD."/attaches/".$current_user->user_id."/";
		if ( !$id || $current_user->user_id == 0 ) return false;
		if ( is_array($urls) && sizeof($urls) )
		{
			$type = 'video';
			foreach ( $urls as $url )
			{
				$sql = sprintf("INSERT INTO `attaches` (`attach_type`,`%s`,`url`,`created`,`user_id`) VALUES ('%s','%d','%s',UNIX_TIMESTAMP(),'%d')",$for,$type,$id,$url,$current_user->user_id);
				try {
					$db->query($sql);
				}
				catch ( Exception $e )
				{
					return false;
				}
			}
		}
		foreach (new DirectoryIterator($upload_dir) as $file) {
			if( $file->isDot() || $file->isDir() ) continue;
			$filepath = $file->getPathname();
			$filename = $file->getFilename();
			$extension = $file->getExtension();
			$filename_new = md5($filename.microtime().$current_user->user_id).'.'.$extension;
			$type = ( preg_match('/(gif|jpe?g|png)$/i',$extension) ) ? 'image' : 'document';
			$sql = sprintf("INSERT INTO `attaches` (`attach_type`,`%s`,`file_name`,`created`,`user_id`) VALUES ('%s','%d','%s',UNIX_TIMESTAMP(),'%d')",$for,$type,$id,$filename_new,$current_user->user_id);
			$db->autocommit(false);
			try 
			{
				$db->query($sql);
				if ( !file_exists($target_dir) ) @mkdir($target_dir);
				if ( @rename($filepath,$target_dir.$filename_new) )
				{
					$db->commit();
					array_map('unlink', glob("$upload_dir/thumbnail/$filename"));
					rmdir("$upload_dir/thumbnail");
					rmdir("$upload_dir");
				}
				else
				{
					return false;
				}
			}
			catch ( Exception $e )
			{
				return false;
			}
		}
		return true;
	}
}

?>