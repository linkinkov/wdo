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

// uploading user avatar
if ( isset($_FILES["avatar"]) )
{
	$response = $current_user->avatar_update();
	header('Content-Type: application/json');
	echo json_encode($response);
	exit;
}

$opts = array(
	'user_dirs' => true,
	'correct_image_extensions' => true,
	'access_control_allow_credentials' => true,
	'accept_file_types' => '/\.(gif|jpe?g|png|docx?|xlsx?|pdf)$/i',
	'max_file_size' => 4000000,
	'max_number_of_files' => 11,
	'param_name' => 'files'
);

// uploading advertisment logo
if ( isset($_FILES["adv_logo"]) )
{
	$opts["max_number_of_files"] = 2;
	$opts["accept_file_types"] = '/\.(gif|jpe?g|png)$/i';
	$opts["param_name"] = 'adv_logo';
	$opts["image_versions"] = array(
		'' => array(
			'auto_orient' => true
		),
		'thumbnail' => array(
			'max_width' => 180,
			'max_height' => 180
		)
	);
	$upload_dir = sprintf(PD.'/upload/files/%s/',session_id());
	delTree($upload_dir);
}

// uploading attaches
$upload_handler = new UploadHandler($opts);
