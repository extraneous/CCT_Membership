<?php
require_once '../includes/init.php';
use PragmaRX\Google2FA\Google2FA;

if(isset($_SESSION["user"])){
    header('Location:index.php');
}

if(!function_exists('hash_equals')) {
    function hash_equals($str1, $str2) {
        if(strlen($str1) != strlen($str2)) {
            return false;
        } else {
            $res = $str1 ^ $str2;
            $ret = 0;
            for($i = strlen($res) - 1; $i >= 0; $i--) $ret |= ord($res[$i]);
            return !$ret;
        }
    }
    require_once('../includes/password.php');
}
function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

$errMsg = '';
$username = '';
if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
    if (basename($_SERVER['HTTP_REFERER']) == basename($_SERVER['SCRIPT_NAME'])) {
        if (isset($_POST["email"])) {
            $email = filter_var($_POST["email"], FILTER_SANITIZE_STRING);
        } else {
            $email = '';
        }
        if (isset($_POST["password"])) {
            $password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);
        } else {
            $password = '';
        }
        if(isset($_POST["twofa"])){
            $twofa = filter_var($_POST["twofa"],FILTER_SANITIZE_STRING);
        } else {
            $twofa = '';
        }
        if (strlen($email) > 100) {
            $email = '';
        }
        if (strlen($password) > 128) {
            $password = '';
        }
        if (!empty($_POST["token"])) {
            if (hash_equals($_POST["token"], $_SESSION["token"])) {
                $strSQL = "SELECT U.id,U.firstname,U.surname,U.password,U.email,U.failedLogins,U.googleSecretKey
                        FROM users U 
                        WHERE email = ?
                        AND U.status = 1
                        AND U.failedLogins < 5";
                $stmt = $db->prepare($strSQL);
                $stmt->bindParam(1, $email, PDO::PARAM_STR);
                $stmt->execute();
                $users = $stmt->fetchAll(PDO::FETCH_OBJ);
                if (sizeof($users) > 0) {
                    $userFound = false;
                    foreach ($users as $user) {
                        if (password_verify($password, $user->password)) {
                            $google2fa = new Google2FA();
                            $valid = $google2fa->verifyKey($user->googleSecretKey, $twofa);
                            if ($valid) {
                                $userFound = true;
                                $sessionUser = new stdClass();
                                $sessionUser->id = $user->id;
                                $sessionUser->firstname = $user->firstname;
                                $sessionUser->surname = $user->surname;
                                $sessionUser->email = $user->email;

                                //Get Permissions
                                $userPerms = array();
                                $perms = Userpermission::find_all_by_userid($user->id);
                                foreach ($perms as $perm) {
                                    $userPerms[] = $perm->permissionid;
                                }
                                $sessionUser->perms = $userPerms;

                                session_regenerate_id(TRUE);
                                session_destroy();
                                unset($_SESSION);
                                session_id(sha1(mt_rand()));
                                session_start();

                                //Save good login to db
                                $login = new GoodLogin();
                                $login->userid = $user->id;
                                $login->ipaddress = get_client_ip();
                                $login->save();

                                $userObj = User::find_by_id($user->id);
                                $userObj->failedlogins = 0;
                                $userObj-> save();

                                $_SESSION["user"] = json_encode($sessionUser);
                                header('Location:index.php');
                                exit;
                            } else {
                                $badLogin = new BadLogin();
                                $badLogin->email = $email;
                                $badLogin->ipaddr =  get_client_ip();
                                $badLogin->reason = 'Bad Google 2FA';
                                $badLogin->save();
                                $userObj = User::find_by_id($user->id);
                                $userObj->failedlogins = $userObj->failedlogins + 1;
                                $userObj-> save();
                                $errMsg = 'Sorry you could not be logged in!? Please try again.';
                            }
                        } else {
                            $badLogin = new BadLogin();
                            $badLogin->email = $email;
                            $badLogin->ipaddr =  get_client_ip();
                            $badLogin->reason = 'Bad Password';
                            $badLogin->save();
                            $userObj = User::find_by_id($user->id);
                            $userObj->failedlogins = $userObj->failedlogins + 1;
                            $userObj-> save();
                            $errMsg = 'Sorry you could not be logged in!? Please try again.';
                        }
                    }
                } else {
                    $badLogin = new BadLogin();
                    $badLogin->email = $email;
                    $badLogin->ipaddr =  get_client_ip();
                    $badLogin->reason = 'User not found';
                    $badLogin->save();
                    $errMsg = 'Sorry you could not be logged in!? Please try again.';
                }
            }
        }
        $errMsg = 'Sorry you could not be logged in!? Please try again.';
    }
}

if(function_exists('mcrypt_create_iv')){
    $_SESSION['token'] = bin2hex(mcrypt_create_iv(32,MCRYPT_DEV_URANDOM));
} else {
    $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
}
$token = $_SESSION['token'];

$template = $twig->loadTemplate('login.twig');
header('X-Frame-Options: DENY');

$css = array();
$css[] = '/css/login.css';
$js = array();
$js[] = '/js/bootbox.min.js';
$js[] = '/js/login.js';

echo $template->render(array(
    'pageTitle' => 'Login',
    'pageHeading' => 'Login',
    'addCss' => $css,
    'addJs' => $js,
    'token' => $token,
    'username' => $username,
    'errMsg' => $errMsg
));