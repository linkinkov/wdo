 <?php
require_once('_global.php');
require_once(PD.'/lib/User.class.php');
// sec_session_start();
header('Content-Type: application/json');
sleep(1);
$response["result"] = false;
$response["message"] = "Ошибка авторизации";
if (isset($_POST['username'], $_POST['p'])) {
	$username = $_POST['username'];
	$password = $_POST['p'];
	if (login($username, $password, $db) == true) {
		$user = new User($_SESSION["user_id"]);
		$response["result"] = true;
		$response["message"] = "Authorized";
		// header('Location: /');
	} else {
		// Login failed 
	}
} else {
	// The correct POST variables were not sent to this page.
	$response["message"] = "Invalid data";
}

echo json_encode($response);