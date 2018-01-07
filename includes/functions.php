 <?php
require_once(PD.'/lib/User.class.php');

date_default_timezone_set("GMT");
function sec_session_start($regen = true) {
	$domain = "/";
	$session_name = 'wdo_session_id';
	$secure = true;
	$httponly = true;
	if (ini_set('session.use_only_cookies', 1) === FALSE) {
		header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
		exit();
	}
	$cookieParams = session_get_cookie_params();
	session_set_cookie_params($cookieParams["lifetime"],
		$cookieParams["path"], 
		$cookieParams["domain"],
		$secure,
		$httponly);
	session_name($session_name);
	@session_start();
	if ( $regen ) session_regenerate_id(true);
}

function r2t($string) {
	$converter = array(
		'а' => 'a',   'б' => 'b',   'в' => 'v',
		'г' => 'g',   'д' => 'd',   'е' => 'e',
		'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
		'и' => 'i',   'й' => 'y',   'к' => 'k',
		'л' => 'l',   'м' => 'm',   'н' => 'n',
		'о' => 'o',   'п' => 'p',   'р' => 'r',
		'с' => 's',   'т' => 't',   'у' => 'u',
		'ф' => 'f',   'х' => 'h',   'ц' => 'c',
		'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
		'ь' => 'j',  'ы' => 'y',   'ъ' => '',
		'э' => 'ye',   'ю' => 'yu',  'я' => 'ya',
		
		'А' => 'A',   'Б' => 'B',   'В' => 'V',
		'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
		'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
		'И' => 'I',   'Й' => 'Y',   'К' => 'K',
		'Л' => 'L',   'М' => 'M',   'Н' => 'N',
		'О' => 'O',   'П' => 'P',   'Р' => 'R',
		'С' => 'S',   'Т' => 'T',   'У' => 'U',
		'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
		'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
		'Ь' => 'J',  'Ы' => 'Y',   'Ъ' => '',
		'Э' => 'Ye',   'Ю' => 'Yu',  'Я' => 'Ya',
		' ' => '_'
	);
	return strtr($string, $converter);
}
function get_var($var_name = false, $type="string", $default = false, $method="REQUEST")
{
	$var = "";
	switch ( $type )
	{
		case "string":
			switch ( $method )
			{
				case "REQUEST":
					$var = ( isset($_REQUEST[$var_name]) && trim($_REQUEST[$var_name]) != "" ) ? trim($_REQUEST["$var_name"]) : $default;
					break;
				case "GET":
					$var = ( isset($_GET[$var_name]) && trim($_GET[$var_name]) != "" ) ? trim($_GET["$var_name"]) : $default;
					break;
				case "POST":
					$var = ( isset($_POST[$var_name]) && trim($_POST[$var_name]) != "" ) ? trim($_POST["$var_name"]) : $default;
					break;
			}
			break;
		case "int":
			switch ( $method )
			{
				case "REQUEST":
					$var = ( isset($_REQUEST[$var_name]) ) ? intval($_REQUEST["$var_name"]) : $default;
					break;
				case "GET":
					$var = ( isset($_GET[$var_name]) ) ? intval($_GET["$var_name"]) : $default;
					break;
				case "POST":
					$var = ( isset($_POST[$var_name]) ) ? intval($_POST["$var_name"]) : $default;
					break;
			}
			break;
		case "array":
			switch ( $method )
			{
				case "REQUEST":
					$var = ( isset($_REQUEST[$var_name]) && is_array($_REQUEST[$var_name]) > 0 ) ? ($_REQUEST["$var_name"]) : $default;
					break;
				case "GET":
					$var = ( isset($_GET[$var_name]) && is_array($_GET[$var_name])  > 0 ) ? ($_GET["$var_name"]) : $default;
					break;
				case "POST":
					$var = ( isset($_POST[$var_name]) && is_array($_POST[$var_name])  > 0 ) ? ($_POST["$var_name"]) : $default;
					break;
			}
			break;
	}
	return $var;
}
function isValidEmail($email) {
	return filter_var($email, FILTER_VALIDATE_EMAIL) 
		&& preg_match('/@.+\./', $email);
}
function filter_string($string,$dir='in')
{
	return ($dir == 'in')
	? mb_ereg_replace("[^\r\na-zA-Zа-яА-Я0-9Ёё_ <>&\'\"\[\]()!\/:,.?@;-]+","",htmlspecialchars($string, ENT_QUOTES, 'utf-8')) 
	: html_entity_decode(htmlspecialchars($string));
}

function determine_user_city()
{
	include_once(PD.'/includes/ipgeobase/ipgeobase.php');
	$gb = new IPGeoBase();
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	if ( $ip == "127.0.0.1" )
	{
		// $ip = "85.143.184.138";
	}
	// $ip = "193.169.111.6";
	// $ip = "188.242.136.98";
	// echo "checking ip:".$ip;
	setcookie("city_id", "1",0,"/");
	setcookie("city_name", "Москва",0,"/");
	$_COOKIE["city_id"] = "1";
	$_COOKIE["city_name"] = "Москва";

	if ( $data = $gb->getRecord($ip) ) // found record in geo base
	{
		if (isset($data["city"]) && $data["city"] != "")
		{
			$city = iconv("windows-1251", "utf-8", $data["city"]);
			$city_info = City::get_list($city);
			if ( sizeof($city_info) ) // found detected city in db
			{
				$city_id = $city_info[0]->id;
				$city_name = $city_info[0]->city_name;
				setcookie("city_id", $city_id,0,"/");
				setcookie("city_name", $city_name,0,"/");
				$_COOKIE["city_id"] = $city_id;
				$_COOKIE["city_name"] = $city_name;
			}
		}
	}
}

function delTree($dir)
{
	if ( !file_exists($dir) ) return;
	$files = array_diff(scandir($dir), array('.','..'));
	foreach ($files as $file) {
		(is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
	}
	return rmdir($dir);
}

function is_timestamp($timestamp)
{
	return ($timestamp >= 1000000000) && (strlen($timestamp) == 10);
}

function login($username, $password, $db) 
{
	$sql = "SELECT `username`, `password`, `salt`, `status_id`, `template_id`,`user_id`
					FROM `users`
					WHERE `username` = ? AND `status_id` != 4
					LIMIT 1";
	if ($stmt = $db->prepare($sql)) 
	{
		$stmt->bind_param('s', $username);
		$stmt->execute();
		$stmt->store_result();

		// $stmt->bind_result($username, $db_password, $salt, $last_name, $first_name, $phone, $last_ip, $template_id, $templateName,$user_id);
		$stmt->bind_result($username, $db_password, $salt, $status_id, $template_id, $user_id);
		$stmt->fetch();

		if (!empty($_SERVER['HTTP_CLIENT_IP'])) 
		{
			$user_ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$user_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$user_ip = $_SERVER['REMOTE_ADDR'];
		}
		$_SESSION["user_ip"] = $user_ip;
		$password = hash('sha512', $password . $salt);
		if ($stmt->num_rows == 1) {
			if (checkbrute($username, $db) == true) 
			{
				// Account is locked 
				return false;
			}
			else if ( $status_id == 3 )
			{
				return false;
			}
			else 
			{
				// Check if the password in the database matches
				// the password the user submitted.
				if ($db_password == $password) {
					// Password is correct!
					// Get the user-agent string of the user.
					$user_browser = $_SERVER['HTTP_USER_AGENT'];
					$current_user = new User(false,$username,true);
					$_SESSION['user_id'] = $current_user->user_id;
					$_SESSION['username'] = $current_user->username;
					$_SESSION['login_string'] = hash('sha512',$password . $user_browser);
					$now = time();

					$db->query("INSERT INTO `login_attempts`(`username`, `time`, `ip`)
											VALUES ('$username', '$now','".$_SESSION["user_ip"]."')");
					$sql = "UPDATE `users` SET `last_ip` = '$user_ip' WHERE `username` = '$username'";
					$db->query($sql);
					// Login successful.
					return true;
				} 
				else // Password is not correct
				{
					$now = time();
					$db->query("INSERT INTO `login_attempts` (`username`, `time`, `ip`)
											VALUES ('$username', '$now','".$_SESSION["user_ip"]."')");
					return false;
				}
			}
		} 
		else // No user exists.
		{
			return false;
		}
	}
}

function send_activation_key($email,$key)
{
	require_once PD.'/lib/SendMailSmtpClass.php';
	$mailSMTP = new SendMailSmtpClass('support@weedo.ru', 'disinte1575', 'ssl://smtp.yandex.ru', 'WeeDo Support', 465);
	// 										_construct($smtp_username, $smtp_password, $smtp_host, $smtp_from, $smtp_port = 25, $smtp_charset = "utf-8")
	// $mailSMTP = new SendMailSmtpClass('логин', 'пароль', 'хост', 'имя отправителя');
		
	// заголовок письма
	$headers= "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=utf-8\r\n"; // кодировка письма
	$headers .= "From: support <support@weedo.ru>\r\n"; // от кого письмо
	$headers .= "To: <".$email.">\r\n"; // кому
	$body = "
	<table border='0' width='100%'>
		<tbody>
			<tr><td>Регистрация на портале WeeDo.RU</td></tr>
			<tr><td>
			Здравствуйте!<br />
			Вы получили это письмо, так как Ваш почтовый адрес был указан в качестве учетной записи на сайте http://weedo.ru<br /><br />
			Что-бы продолжить регистрацию, пожалуйста, пройдите по ссылке:<br /><br />
			<a href='".HOST."/?action=activate&activation_key=".$key."'>".HOST."/?action=activate&activation_key=".$key."</a>
			</td></tr>
		</tbody>
	</table>
	";
	$result =  $mailSMTP->send($email, 'Активация аккаунта', $body, $headers); // отправляем письмо
	// $result =  $mailSMTP->send('Кому письмо', 'Тема письма', 'Текст письма', 'Заголовки письма');
	if($result === true)
	{
		// echo "Письмо успешно отправлено";
		return true;
	}
	else
	{
		// echo "Письмо не отправлено. Ошибка: " . $result;
		return false;
	}
	return false;
}

function replace_array(&$item, $key, $prefix)
{
	$item = preg_replace('/'.$prefix.'/','',$item);
}

function sqlize_array(&$item)
{
	$item = "`".$item."`";
}

function check_access($db,$regen = true)
{
	if ( session_status() != PHP_SESSION_ACTIVE ) sec_session_start($regen);
	else if ( $regen && $_SESSION["user_id"] > 0 )
	{
		delTree(PD."/upload/files/".session_id());
		session_regenerate_id($regen);
	}
	if(!login_check($db))
	{
		$_SESSION["user_id"] = 0;
		return false;
	}
}

function checkbrute($username, $db) {
	// Get timestamp of current time 
	$now = time();

	// All login attempts are counted from the past 2 hours. 
	$valid_attempts = $now - (2 * 60 * 60);

	if ($stmt = $db->prepare("SELECT `time`
														FROM `login_attempts`
														WHERE `username` = ? 
													AND `time` > '$valid_attempts'")) {
			$stmt->bind_param('i', $username);

			// Execute the prepared query. 
			$stmt->execute();
			$stmt->store_result();

			// If there have been more than 25 failed logins 
			if ($stmt->num_rows > 25) {
					return true;
			} else {
					return false;
			}
	}
}


function login_check($db) {
	// Check if all session variables are set 
	if (isset($_SESSION['username'], $_SESSION['login_string'])) 
	{
		$login_string = $_SESSION['login_string'];
		$username = $_SESSION['username'];

		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
				$user_ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				$user_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
				$user_ip = $_SERVER['REMOTE_ADDR'];
		}
		$_SESSION["user_ip"] = $user_ip;

		// Get the user-agent string of the user.
		$user_browser = $_SERVER['HTTP_USER_AGENT'];

		if ($stmt = $db->prepare("SELECT `password`
															FROM `users`
															WHERE `username` = ? LIMIT 1")) 
		{
			// Bind "$user_id" to parameter. 
			$stmt->bind_param('s', $username);
			$stmt->execute();   // Execute the prepared query.
			$stmt->store_result();

			if ($stmt->num_rows == 1) 
			{
				// If the user exists get variables from result.
				$stmt->bind_result($password);
				$stmt->fetch();
				$login_check = hash('sha512', $password . $user_browser);

				if ($login_check == $login_string ) {
				// Logged In!!!! 
					$sql = "UPDATE `users` SET `last_login` = UNIX_TIMESTAMP() WHERE `username` = '$username'";
					$db->query($sql);
					return true;
				} else {
					// Not logged in 
					return false;
				}
			} else 
			{
				// Not logged in 
				return false;
			}
		} else 
		{
			// Not logged in 
			return false;
		}
	} else 
	{
		// Not logged in 
		return false;
	}
}
