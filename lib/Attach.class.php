<?php

class Attach
{

	public static function load_not_found($w,$h)
	{
		$requested = PD.'/images/image-not-found.png';
		$cached = PD.'/images/cache/image-not-found-'.$w.'-'.$h.'.png';
		$content_type = "image/png";
		if ( !file_exists(dirname($cached)) ) { @mkdir(dirname($cached)); };
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
			switch ( $w )
			{
				case ($w <= 150):
					$quality = 45;
					break;
				case ($w <= 300):
					$quality = 65;
					break;
				default:
					$quality = 90;
					break;
			}
			ob_clean();
			$resizeObj = new resize($requested);
			$resizeObj->resizeImage($w, $h, 'auto');
			$resizeObj->saveImage($cached, $quality);
			header('Content-Type: '.$content_type);
			header('Content-Length: ' . filesize($cached));
			readfile($cached);
			exit;
		}

	}

	public static function getByID($attach_id = false, $w=35, $h=35, $force_resize = "false", $method = "auto")
	{
		global $db;
		$sql = sprintf("SELECT `attach_id`,`attach_type`,`for_project_id`,`for_respond_id`,`file_name`,`file_title`,`user_id` FROM `attaches` WHERE `attach_id` = '%s'",$attach_id);
		$info = $db->queryRow($sql);
		if ( sizeof($info) )
		{
			$info->file_name_no_ext = substr($info->file_name,0,strlen($info->file_name)-strrchr($info->file_name, '.'));
			$extension = strtolower(strrchr($info->file_name, '.'));
			$requested = PD.'/attaches/'.$info->user_id.'/'.$info->file_name;
			$cached = PD.'/attaches/'.$info->user_id.'/cache/'.$info->file_name_no_ext.'-'.$w.'-'.$h.$extension;
			if ( !file_exists(dirname($cached)) ) {@mkdir(dirname($cached));};
			if ( $info->attach_type == "document" )
			{
				if ( file_exists($requested) )
				{
					ob_clean();
					header('Content-Description: File Transfer');
					header('Content-Type: application/octet-stream');
					header('Content-Disposition: attachment; filename='.trim($info->file_title));
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
				if ( $extension == ".gif" && $force_resize != "true" )
				{
					if ( !file_exists($requested) )
					{
						// $requested = $not_found;
						Attach::load_not_found($w,$h);
						exit;
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
					$resizeObj->resizeImage($w, $h, $method);
					if ( !file_exists(dirname($cached)) ) @mkdir(dirname($cached));
					switch ( $w )
					{
						case ($w <= 150):
							$quality = 45;
							break;
						case ($w <= 300):
							$quality = 65;
							break;
						default:
							$quality = 90;
							break;
					}
					$resizeObj->saveImage($cached, $quality);
					header('Content-Type: '.$content_type);
					header('Content-Length: ' . filesize($cached));
					readfile($cached);
					exit;
				}
				else
				{
					Attach::load_not_found($w,$h);
					exit;
				}
			}
			else
			{
				Attach::load_not_found($w,$h);
				// echo "<h1>Content error</h1><p>Unknown content type!</p>";
				exit;
			}
		}
		else
		{
			// echo "Loading not found";
			// exit;
			Attach::load_not_found($w,$h);
			exit;
		}
	}

	private static function get_owner_id($type="for_project_id",$id=false)
	{
		global $db;
		switch ( $type )
		{
			case "for_project_id":
				$table = "project";
				$col = "project_id";
				break;
			case "for_respond_id":
				$table = "project_responds";
				$col = "respond_id";
				break;
			case "for_portfolio_id":
				$table = "portfolio";
				$col = "portfolio_id";
				break;
			default:
				$table = "project";
				$col = "project_id";
		}
		return $db->getValue($table,"user_id","user_id",Array($col=>$id));
	}

	public static function get_by_for_type($for='for_project_id',$id=false,$with_filesize=false)
	{
		global $db;
		if ( !$id ) return false;
		$attach_owner = Attach::get_owner_id($for,$id);
		$sql = sprintf("SELECT `attach_id`,`attach_type`,`url`,`file_name`,`file_title` FROM `attaches` WHERE `%s` = '%d' AND `user_id` = '%d' ORDER BY `attach_type` DESC, `attach_id` ASC",$for,$id,$attach_owner);
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
				unset($row->file_name);
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
			$urls = array_unique($urls);
			$type = 'video';
			$db->autocommit(false);
			foreach ( $urls as $url )
			{
				$attach_id = md5($url.microtime().$current_user->user_id);
				$sql = sprintf("INSERT INTO `attaches` (`attach_id`,`attach_type`,`%s`,`url`,`created`,`user_id`) 
				VALUES ('%s','%s','%d','%s',UNIX_TIMESTAMP(),'%d')",$for,$attach_id,$type,$id,$url,$current_user->user_id);
				try {
					$db->query(sprintf("DELETE FROM `attaches` WHERE `%s` = '%d' AND `user_id` = '%d' AND `attach_type` = 'video'",$for,$id,$current_user->user_id));
					$db->query($sql);
					// $db->commit();
				}
				catch ( Exception $e )
				{
					// echo $e->getMessage();
					return false;
				}
			}
		}
		if ( file_exists($upload_dir) )
		foreach (new DirectoryIterator($upload_dir) as $file) {
			if( $file->isDot() || $file->isDir() ) continue;
			$filepath = $file->getPathname();
			$filename = $file->getFilename();
			$extension = $file->getExtension();
			$filename_new = md5($filename.microtime().$current_user->user_id).'.'.$extension;
			$attach_id = md5($filename_new.microtime().$current_user->user_id);
			$type = ( preg_match('/(gif|jpe?g|png)$/i',$extension) ) ? 'image' : 'document';
			$sql = sprintf("INSERT INTO `attaches` (`attach_id`,`attach_type`,`%s`,`file_name`,`file_title`,`created`,`user_id`) 
			VALUES ('%s','%s','%d','%s','%s',UNIX_TIMESTAMP(),'%d')",$for,$attach_id,$type,$id,$filename_new,$filename,$current_user->user_id);
			$db->autocommit(false);
			try 
			{
				$db->query($sql);
				if ( !file_exists($target_dir) ) @mkdir($target_dir);
				if ( rename($filepath,$target_dir.$filename_new) )
				{
					// $db->commit();
				}
				else
				{
					// echo "rename failed";
					return false;
				}
			}
			catch ( Exception $e )
			{
				// echo $e->getMessage();
				return false;
			}
		}
		// $db->commit();
		array_map('unlink', glob("$upload_dir/thumbnail/*.*"));
		@rmdir("$upload_dir/thumbnail");
		@rmdir("$upload_dir");
		return true;
	}

	public static function delete($attach_id,$type="image")
	{
		global $db;
		global $current_user;
		if ( $current_user->user_id == 0 || strlen($attach_id) != 32 ) return false;
		$sql_info = sprintf("SELECT `for_portfolio_id`,`for_project_id`,`for_respond_id`,`file_name` FROM `attaches` WHERE `attach_id` = '%s' AND `user_id` = '%d'",$attach_id,$current_user->user_id);
		$sql = sprintf("DELETE FROM `attaches` WHERE `attach_id` = '%s' AND `user_id` = '%d'",$attach_id,$current_user->user_id);
		$is_cover = "";
		try {
			$info = $db->queryRow($sql_info);
			if ( is_object($info) && $info->for_portfolio_id > 0 )
			{
				$is_cover = $db->getValue("portfolio","cover_id","cover_id",Array("portfolio_id"=>$info->for_portfolio_id,"cover_id"=>$attach_id));
			}
			$db->autocommit(false);
			if ( in_array($type,Array("image","document")) && isset($info->file_name) && strlen($info->file_name) > 32 )
			{
				array_map('unlink', glob(PD."/attaches/".$current_user->user_id."/".$info->file_name, GLOB_BRACE));
				array_map('unlink', glob(PD."/attaches/".$current_user->user_id."/cache/".$info->file_name."*", GLOB_BRACE));
			}
			if ( $db->query($sql) && $db->affected_rows == 1 )
			{
				if ( strlen($is_cover) == 32 )
				{
					$db->query(sprintf("UPDATE `portfolio` SET `cover_id` = '' WHERE `portfolio_id` = '%d'",$info->for_portfolio_id));
				}
				$db->commit();
				return true;
			}
		}
		catch ( Exception $e )
		{
			// echo $e->getMessage();
		}
		return false;
	}
}

?>