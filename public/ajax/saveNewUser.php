<?php
require_once '../../includes/init.php';
require_once '../../includes/checkLoggedIn.php';

use PragmaRX\Google2FA\Google2FA;


if(isset($_POST["firstName"])){
    $firstName = filter_var($_POST["firstName"],FILTER_SANITIZE_STRING);
} else {
    $firstName = '';
}
if(isset($_POST["surname"])){
    $surname = filter_var($_POST["surname"],FILTER_SANITIZE_STRING);
} else {
    $surname = '';
}
if(isset($_POST["email"])){
    $email = filter_var($_POST["email"],FILTER_SANITIZE_EMAIL);
} else {
    $email = '';
}
if(isset($_POST["password"])){
    $password = filter_var($_POST["password"],FILTER_SANITIZE_STRING);
} else {
    $password = '';
}
if(isset($_POST{"enabled"})){
    $enabled = filter_var($_POST["enabled"],FILTER_SANITIZE_NUMBER_INT);
} else {
    $enabled = 0;
}
if(isset($_POST["permStr"])){
    $permStr = filter_var($_POST["permStr"],FILTER_SANITIZE_STRING);
} else {
    $permStr = '';
}

$perArr = explode(',',$permStr);

if($enabled > 0){
    $enabled = 1;
} else {
    $enabled = 0;
}

$google2fa = new Google2FA();
$secret = $google2fa->generateSecretKey();

$userObj = new User();
$userObj->firstname         = $firstName;
$userObj->surname           = $surname;
$userObj->password          = password_hash($password, PASSWORD_DEFAULT);
$userObj->googlesecretkey   = $secret;
$userObj->status            = $enabled;
$userObj->email             = $email;
$userObj->created_by        = $user->id;
$userObj->save();

foreach($perArr as $per){
    $perId = filter_var($per,FILTER_SANITIZE_NUMBER_INT);
    if(is_numeric($perId)){
        $up = new Userpermission();
        $up->userid = $userObj->id;
        $up->permissionid = $perId;
        $up->save();
    }
}