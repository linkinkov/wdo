<?php
/*
 * jQuery File Upload Plugin PHP Example
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * https://opensource.org/licenses/MIT
 */
define('HOST','https://'.$_SERVER["HTTP_HOST"]);
error_reporting(E_ALL | E_STRICT);
require('UploadHandler.php');
if ( isset($_POST["getExisting"]) )
{
/*
	$response = Array("files"=>Array());
	session_name('wdo_session_id');
	@session_start();
	$session = session_id();
	// echo $session;
	$path = './files/'.$session;
	if ( !file_exists($path) ) exit(json_encode($response));
	foreach (new DirectoryIterator($path) as $fileInfo) {
		if($fileInfo->isDot()) continue;
		if ( preg_match('/(gif|jpe?g|png|docx?|xlsx?|pdf)$/i',$fileInfo->getExtension()) )
		{
			if ( preg_match('/(gif|jpe?g|png)$/i',$fileInfo->getExtension()) ) {
				$extensions = array('png');
				if ( function_exists('exif_imagetype') ) {
					switch (@exif_imagetype($fileInfo->getPathname())){
						case IMAGETYPE_JPEG:
							$extensions = array('jpg', 'jpeg');
							break;
						case IMAGETYPE_PNG:
							$extensions = array('png');
							break;
						case IMAGETYPE_GIF:
							$extensions = array('gif');
							break;
					}
				}
				$type = 'image/'.$extensions[0];
			}
			else
			{
				$type = 'application/'.$fileInfo->getExtension();
			}
			// echo $fileInfo->getFilename();
			$response["files"][] = Array(
				"deleteType" => "DELETE",
				"deleteUrl" => HOST."/upload/index.php?file=".$fileInfo->getFilename(),
				"deleteWithCredentials" => true,
				"name" => $fileInfo->getFilename(),
				"size" => filesize($fileInfo->getPathname()),
				"thumbnailUrl" => HOST."/upload/files/$session/thumbnail/".$fileInfo->getFilename(),
				"type" => $type,
				"url" => HOST."/upload/files/$session/".$fileInfo->getFilename()
			);
		}
	}
	header('Content-Type: application/json');
	echo json_encode($response);
	exit;
	*/
}
else
{
	$upload_handler = new UploadHandler(array(
		'user_dirs' => true,
		'access_control_allow_credentials' => true,
		'accept_file_types' => '/\.(gif|jpe?g|png|docx?|xlsx?|pdf)$/i'
	));
}
