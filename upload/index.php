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

require_once('../_global.php');
include_once(PD.'/_includes.php');
require_once(PD.'/lib/Resize.class.php');
require_once(PD.'/lib/Avatar.class.php');
require_once(PD.'/lib/Attach.class.php');
require_once(PD.'/upload/UploadHandler.php');

$db = db::getInstance();
check_access($db,false);
$current_user = new User($_SESSION["user_id"]);

if ( isset($_FILES["avatar"]) ) // uploading user avatar
{
	$response = $current_user->avatar_update();
	header('Content-Type: application/json');
	echo json_encode($response);
	exit;
}

// uploading attaches
$upload_handler = new UploadHandler(array(
	'user_dirs' => true,
	'correct_image_extensions' => true,
	'access_control_allow_credentials' => true,
	'accept_file_types' => '/\.(gif|jpe?g|png|docx?|xlsx?|pdf)$/i',
	'max_file_size' => 4000000,
	'max_number_of_files' => 11
));
