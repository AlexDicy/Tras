<?php
require_once "shared.php";
$username = $password = $email = $type = $newpassword = "";
$salt = "***REMOVED***";
$username = "***REMOVED***";
$password = "***REMOVED***";
$database = "***REMOVED***";
$host = "mysql.minehoster.us";
$conn = mysqli_connect($host, $username, $password, $database);
$sessionId = isset($_COOKIE['TrasID']) ? escape($_COOKIE['TrasID']) : "notLoggedIn";
$userId = isset($_COOKIE['userID']) ? escape($_COOKIE['userID']) : 0;

unset($host, $username, $password, $database);

loadUserData();

/*if (isset($_GET['type'])) {
    $type = $_GET['type'];
}*/
if (isset($_POST['type'])) {
    $type = $_POST['type'];
}
if (isset($_POST['username'])) {
    $username = $_POST['username'];
}
if (isset($_POST['password'])) {
    $password = $_POST['password'];
}
if (isset($_POST['email'])) {
    $email = $_POST['email'];
}
if (isset($_POST['newpassword'])) {
    $newpassword = $_POST['newpassword'];
}
if (isset($_GET['recover'])) {
    recoverPass($_GET['recover']);
}
if (isset($_GET['confirm'])) {
    $confirm = $_GET['confirm'];
    checkEmailConfirm();
}
switch ($type) {
    case "login":
        login(false);
        break;
    case "register":
        register();
        break;
    case "recover":
        if (isset($_POST['password'])) {
            recoverPassword();
        } else recover();
        break;
    case "logout":
        logout();
        break;
    case "changePassword":
        changePassword($password, $newpassword);
        break;
}

function loadUserData() {
    global $sessionId, $userId;
    if (isLoggedIn()) {
        query("INSERT INTO Sessions SET id = '" . $sessionId . "', user = '$userId' ON DUPLICATE KEY UPDATE last_access = NOW()");
        Shared::$USERDATA["info"] = mysqli_fetch_assoc(query("SELECT * FROM Members WHERE Members.id = (SELECT user FROM Sessions WHERE Sessions.user = '$userId' AND Sessions.id = '$sessionId')"));
    }
}

function verifyPassword($id, $pass) {
    global $salt;
    $id = escape($id);
    $hash = mysqli_fetch_assoc(query("SELECT password FROM Members WHERE (nick = '$id' OR id = '$id' OR email = '$id')"))['password'];
    //Accept both new and old hashes
    if (password_verify($pass, $hash) || $hash == md5($pass . $salt)) return true;
    else return false;
}

function login($reg) {
    global $username, $password, $sessionId, $userId;
    $username = escape($username);
    if (verifyPassword($username, $password)) {
        $id = mysqli_fetch_assoc(query("SELECT id FROM Members WHERE (nick = '$username' OR email = '$username')"))["id"];
        setcookie("Redirect", "Delete me", time()-60*60*24*30, "/");
        $userId = $id;
        $sessionId = randomText();
        loadUserData();
        setcookie("TrasID", $sessionId, time()+86400*30, "/");
        setcookie("userID", $userId, time()+86400*30, "/");
        if ($reg) {
            if (sendConfirmEmail(Shared::$USERDATA)) echo "{\"CODE\": 700}";
            else if (sendConfirmEmail(Shared::$USERDATA)) echo "{\"CODE\": 700}"; // Odd, quick retry
            else echo "{\"CODE\": 704}";
        } else echo "{\"CODE\": 700}";
    } else {
         echo "{\"CODE\": 703}";
    }
}

function sendConfirmEmail($info) {
    $email = $info['email'];
    $from = "info@tras.pw";
    $code = md5(uniqid().uniqid());
    $confirmurl = "https://tras.pw/session.php?confirm=" . $code;
    $query = query("INSERT INTO Confirm (id, code) VALUES ('". $info['id'] . "', '$code');");
    if ($query) {
        ob_start();
        include("con_email.php");
        $body = ob_get_clean();
        $subject = "Confirm your email - Tras";
        $headers = "From: Tras <$from>\r\n";
        $headers .= "Reply-To: ". strip_tags($from) . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        mail($email,$subject,$body,$headers);
        return true;
    } else {
        return false;
    }
}

function confirmEmail($id) {
    $confirm = query("UPDATE Members SET confirmed = 1 WHERE id = $id");
    query("DELETE FROM Confirm WHERE id = $id");
    if ($confirm) {
        Shared::$USERDATA['info']['confirmed'] = 1;
        return true;
    } return false;
}

function checkEmailConfirm() {
    if (isset(Shared::$USERDATA['info']['confirmed']) && Shared::$USERDATA['info']['confirmed'] == 1) {
        setcookie("Confirm", "602", time()+60);
        header("Location: /page/confirm-email");
        echo "{\"CODE\": 602}";
    } else {
        global $confirm;
        if (!empty($confirm)) {
            $confirm = escape($confirm);
            $code = query("SELECT id FROM Confirm WHERE code = '$confirm'");
            if (mysqli_num_rows($code) > 0) {
                $code = mysqli_fetch_array($code);
                if (confirmEmail($code['id'])) {
                    setcookie("Confirm", "600", time()+60);
                    header("Location: /page/confirm-email");
                    echo "{\"CODE\": 600}";
                } else {
                    setcookie("Confirm", "604", time()+60);
                    header("Location: /page/confirm-email");
                    echo "{\"CODE\": 604}";
                }
            } else {
                setcookie("Confirm", "603", time()+60);
                header("Location: /page/confirm-email");
                echo "{\"CODE\": 603}";
            }
        }
    }
}

function register() {
    global $username;
    global $password;
    global $email;
    if (preg_match('/^[a-z0-9\040\_]+$/i', $username)) {
        if (3 < strlen($username) && 3 < strlen($password) && 4 < strlen($email) && (20 > strlen($username) && 200 > strlen($password) && 100 > strlen($email))) {
            $username = escape($username);
            $email = escape($email);
            $check = query("SELECT * FROM Members WHERE (nick = '$username') OR (email = '$email')");
            if (mysqli_num_rows($check) == 0) {
                $rs = query("INSERT INTO Members (nick, password, email) VALUES ('$username', '" . password_hash($password, PASSWORD_DEFAULT) . "', '$email')");
                reloadInfo();
                login(true);
            } else echo "{\"CODE\":  603}";
        }
    } else echo "{\"CODE\":  604}";
}

function recover() {
    global $username;
    $username = escape($username);
    $data = query("SELECT * FROM Members WHERE nick = '$username' OR email = '$username'");
    if (mysqli_num_rows($data) == 0) {
        echo "{\"CODE\": 703}";
    } else {
        $info = mysqli_fetch_assoc($data);
        $email = $info['email'];
        $from = "info@tras.pw";
        $code = md5(uniqid().uniqid());
        $reseturl = "https://tras.pw/session.php?recover=" . $code;
        $query = query("INSERT INTO Recover (id, code) VALUES ('". $info['id'] . "', '$code');");
        if ($query) {
            ob_start();
            include("rec_email.php");
            $body = ob_get_clean();
            $subject = "Tras - Password recover";
            $headers = "From: Tras <$from>\r\n";
            $headers .= "Reply-To: ". strip_tags($from) . "\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
            mail($email,$subject,$body,$headers);
            echo "{\"CODE\": 706}";
        } else {
            echo "{\"CODE\": 704}";
        }
    }
}

function sendMail($subject, $body, $to, $preheader) {
    $from = "info@tras.pw";
    $subject = "Tras - $subject";
    $headers = "From: Tras <$from>".PHP_EOL;
    $headers .= "Reply-To: ". strip_tags($from) .PHP_EOL;
    $headers .= "MIME-Version: 1.0".PHP_EOL;
    $headers .= "Content-Type: text/html; charset=ISO-8859-1".PHP_EOL;
    ob_start();
    include("gen_mail.php");
    $body = ob_get_clean();
    mail($to,$subject,$body,$headers);
}

function recoverPass($code) {
    $code = escape($code);
    $id = query("SELECT id FROM Recover WHERE code = '$code'");
    if (mysqli_num_rows($id) > 0) {
        setcookie("Recover-Code", $code);
        header("Location: https://tras.pw/page/recover");
    } else echo "<p>This link is not valid. Request another reset.</p>";
}

function recoverPassword() {
    global $password;
    if (isset($_COOKIE['Recover-Code']) && isCodeValid($_COOKIE['Recover-Code'])) {
        if (strlen($password) > 3) {
            if (strlen($password) < 200) {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $id =  mysqli_fetch_assoc(query("SELECT id FROM Recover WHERE code = '$code'"))['id'];
                $query = query("UPDATE Members SET password = '$hash' WHERE id = " . $id);
                $remove = query("DELETE FROM Recover WHERE code = '" . $_COOKIE['Recover-Code'] . "'");
                if ($query && $remove) {
                    setcookie("Recover-Code", "Delete me", time()-3600);
                    echo "{\"CODE\": 706}";
                } else echo "{\"CODE\": 704}";
            } else echo "{\"CODE\": 701}";
        } else echo "{\"CODE\": 702}";
    } else  echo "{\"CODE\": 703}";
}

function changePassword($old, $new) {
    $old = escape($old);
    $new = escape($new);
    if (strlen($new) > 3 && strlen($new) < 200 && isLoggedIn()) {
        if (verifyPassword(Shared::$USERDATA['info']['id'], $old)) {
            $hash = password_hash($new, PASSWORD_DEFAULT);
            $query = query("UPDATE Members SET password = '$hash' WHERE id = " . Shared::$USERDATA['info']['id']);
            echo "{\"CODE\": 700}";
        } else echo "{\"CODE\": 703}";
    } else echo "{\"CODE\": 702}";
}

function isCodeValid($code) {
    $date = strtotime(date('Y-m-d H:i:s') . ' -1 day');
    $date = date('Y-m-d H:i:s', $date);
    $code = escape($code);
    $id = query("SELECT * FROM Recover WHERE code = '$code' AND time >=  '$date'");
    if (mysqli_num_rows($id) > 0) return true ;
    else return false;
}

function getFriendsList() {
    $array = array();
    $query = query("SELECT Friends.To FROM Friends WHERE Friends.From = " . Shared::$USERDATA['info']['id']);
    while ($row = mysqli_fetch_array($query)) {
        $array[] = $row;
    }
    return array_column($array, 'To');
}

function getFriendsCount($id) {
    if (!isset($id)) {
        $id = Shared::$USERDATA['info']['id'];
    }
    $sql = query("SELECT COUNT(Friends.To) FROM Friends WHERE Friends.To = $id");
    return mysqli_fetch_array($sql)[0];
}

function logout() {
    global $sessionId, $userId;
    setcookie("TrasID", "Delete me", time()-3600);
    setcookie("userID", "Delete me", time()-3600);
    echo "{\"CODE\": 500}";
    Shared::$USERDATA = array();
    query("DELETE FROM Sessions WHERE id = '" . $sessionId . "' AND user = '$userId'");
}

function isLoggedIn() {
    global $sessionId, $userId;
    if ($sessionId != "notLoggedIn" && $userId != 0) {
        return true;
    }
    return false;
}

function query($sql) {
    global $conn;
    if (!$conn) {
        return false;
    }
    $result = mysqli_query($conn, $sql);
    return $result;
}

function escape($unescaped) {
  $replacements = array(
     "\x00"=>'\x00',
     "\n"=>'\n',
     "\r"=>'\r',
     "\\"=>'\\\\',
     "'"=>"\'",
     '"'=>'\"',
     "\x1a"=>'\x1a'
  );
  return strtr($unescaped, $replacements);
}

function unsafeEscape($unescaped) {
  $replacements = array(
     "\x00"=>'\x00',
     "\\"=>'\\\\',
     '"'=>'\"',
     "\x1a"=>'\x1a'
  );
  return strtr($unescaped, $replacements);
}

function safeUnescape($escaped) {
  $replacements = array(
     '\n'=>"\n",
     '\r'=>"\r",
     //"\\"=>'\\\\',
     "\'"=>"'",
     //'"'=>'\"',
     //"\x1a"=>'\x1a'
  );
  return strtr($escaped, $replacements);
}

function randomText($length = 40, $type = 'alnum') {
	switch ( $type ) {
		case 'alnum':
			$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			break;
		case 'alpha':
			$pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			break;
		case 'hexdec':
			$pool = '0123456789abcdef';
			break;
		case 'numeric':
			$pool = '0123456789';
			break;
		case 'nozero':
			$pool = '123456789';
			break;
		case 'distinct':
			$pool = '2345679ACDEFHJKLMNPRSTUVWXYZ';
			break;
		default:
			$pool = (string) $type;
			break;
	}

	$cryptoRandSecure = function ($min, $max) {
		$range = $max - $min;
		if ($range < 0) return $min; // not so random...
		$log = log($range, 2);
		$bytes = (int) ($log / 8) + 1; // length in bytes
		$bits = (int) $log + 1; // length in bits
		$filter = (int) (1 << $bits) - 1; // set all lower bits to 1
		do {
			$rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
			$rnd = $rnd & $filter; // discard irrelevant bits
		} while ($rnd >= $range);
		return $min + $rnd;
	};

	$token = "";
	$max = strlen($pool);
	for ($i = 0; $i < $length; $i++) {
		$token .= $pool[$cryptoRandSecure(0, $max)];
	}
	return $token;
}

include_once('notificationengine.php');
?>
