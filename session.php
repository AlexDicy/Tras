<?php
session_name("TrasID");
session_start();
$username = $password = $email = $type = $newpassword = "";
$salt = "***REMOVED***";
$username = "***REMOVED***";
$password = "***REMOVED***";
$database = "***REMOVED***";
$host = "mysql.minehoster.us";
$conn = mysqli_connect($host, $username, $password, $database);
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

function verifyPassword($id, $pass){
    global $salt;
    $id = escape($id);
    $hash = mysqli_fetch_assoc(query("SELECT Password FROM Members WHERE (Nick = '$id' OR id = '$id' OR Email = '$id')"))['Password'];
    //Accept both new and old hashes
    if (password_verify($pass, $hash) || $hash == md5($pass . $salt)) return true;
    else return false;
}

function login($reg)  {
    global $username;
    global $password;
    $token = md5(uniqid() . uniqid() . $password);
    $username = escape($username);
    if (verifyPassword($username, $password)) {
        $data = query("SELECT * FROM Members WHERE (Nick = '$username' OR Email = '$username')");
        setcookie("Redirect", "Delete me", time()-60*60*24*30, '/');
        session_regenerate_id(true);
        $_SESSION["ID"] = session_id();
        $_SESSION["info"] = $info = mysqli_fetch_assoc($data);
        $tquery = query("UPDATE Members SET Token = '$token' WHERE id = " . $_SESSION['info']['id']);
        if ($tquery) if (isset($_POST['remember']) && $_POST['remember'] == "true") {
            setcookie("RM", $token, time()+60*60*24*30, '/');
        }
        $_SESSION['Token'] = $token;
        if ($reg) {
            if (sendConfirmEmail($info)) echo "{\"CODE\": 700}";
            else if (sendConfirmEmail($info)) echo "{\"CODE\": 700}";
            else echo "{\"CODE\": 704}";
        } else echo "{\"CODE\": 700}";
    } else {
         echo "{\"CODE\": 703}";
    }
}

function sendConfirmEmail($info) {
    $email = $info['Email'];
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

function reloadInfo() {
    if (isLoggedIn()) {
        $info = query("SELECT * FROM Members WHERE id = '" . $_SESSION['info']['id'] . "'");
        if (mysqli_num_rows($info) > 0) {
            $_SESSION['info'] = mysqli_fetch_assoc($info);
            $_SESSION["ID"] = session_id();
            if (isset($_COOKIE['RM']) && !headers_sent()) {
                setcookie("RM", $_SESSION['info']['Token'], time()+60*60*24*30, '/');
            }
        }
    } else {
        $_SESSION['info'] = array();
    }
}

function reloadFromToken() {
    $info = query("SELECT * FROM Members WHERE Token = '" . $_COOKIE['RM'] . "'");
    if (mysqli_num_rows($info) > 0) {
        $_SESSION['info'] = mysqli_fetch_assoc($info);
        $_SESSION["ID"] = session_id();
        return true;
    } return false;
}

function confirmEmail($id) {
    $confirm = query("UPDATE Members SET Confirmed = 1 WHERE id = $id");
    query("DELETE FROM Confirm WHERE id = $id");
    if ($confirm) {
        $_SESSION['info']['Confirmed'] = 1;
        return true;
    } return false;
}

function checkEmailConfirm() {
    if (isset($_SESSION['info']['Confirmed']) && $_SESSION['info']['Confirmed'] == 1) {
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
            $check = query("SELECT * FROM Members WHERE (Nick = '$username') OR (Email = '$email')");
            if (mysqli_num_rows($check) == 0) {
                $rs = query("INSERT INTO Members (Nick, Password, Email) VALUES ('$username', '" . password_hash($password, PASSWORD_DEFAULT) . "', '$email')");
                reloadInfo();
                login(true);
            } else echo "{\"CODE\":  603}";
        }
    } else echo "{\"CODE\":  604}";
}

function recover()  {
    global $username;
    $username = escape($username);
    $data = query("SELECT * FROM Members WHERE Nick = '$username' OR Email = '$username'");
    if (mysqli_num_rows($data) == 0) {
        echo "{\"CODE\": 703}";
    } else {
        $info = mysqli_fetch_assoc($data);
        $email = $info['Email'];
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
        $id = mysqli_fetch_assoc($id)['id'];
        $_SESSION['recover']['id'] = $id;
        $_SESSION['recover']['code'] = $code;
        header("Location: https://tras.pw/page/recover");
    } else echo "{\"CODE\": 703}</br><p>This link is not valid. Request another reset.</p>";
}

function recoverPassword() {
    global $password;
    if (isset($_SESSION['recover']) && isCodeValid($_SESSION['recover']['code'])) {
        if (strlen($password) > 3) {
            if (strlen($password) < 200) {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $query = query("UPDATE Members SET Password = '$hash' WHERE id = " . $_SESSION['recover']['id']);
                $remove = query("DELETE FROM Recover WHERE code = '" . $_SESSION['recover']['code'] . "'");
                if ($query && $remove) {
                    unset($_SESSION['recover']);
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
        if (verifyPassword($_SESSION['info']['id'], $old)) {
            $hash = password_hash($new, PASSWORD_DEFAULT);
            $query = query("UPDATE Members SET Password = '$hash' WHERE id = " . $_SESSION['info']['id']);
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
    $query = query("SELECT Friends.To FROM Friends WHERE Friends.From = " . $_SESSION['info']['id']);
    while ($row = mysqli_fetch_array($query)) {
        $array[] = $row;
    }
    return array_column($array, 'To');
}

function getFriendsCount($id) {
    if (!isset($id)) {
        $id = $_SESSION['info']['id'];
    }
    $sql = query("SELECT COUNT(Friends.To) FROM Friends WHERE Friends.To = $id");
    return mysqli_fetch_array($sql)[0];
}

function logout()  {
    $token = md5(uniqid() . session_id() . uniqid());
    $query = true;
    $cookie = false;
    if (isset($_COOKIE['RM'])) {
        $query = query("UPDATE Members SET Token = '$token' WHERE id = ". $_SESSION['info']['id'] ." AND Token = '" . $_COOKIE['RM'] ."'");
        $cookie = true;
    }
    if ($query) {
        if ($cookie) setcookie("RM", "Delete me", time()-60*60*24*30, '/');
        echo "{\"CODE\": 500}";
        $_SESSION['ID'] = "";
        $_SESSION = array();
        session_destroy();
    }
}

function isLoggedIn() {
    if (isset($_SESSION['ID'])) {
        return true;
    } else {
        if(isset($_COOKIE["RM"])) {
            return reloadFromToken();
        }
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
  return strtr($unescaped,$replacements);
}
include_once('notificationengine.php');
?>
