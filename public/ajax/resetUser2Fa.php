<?php
require_once '../../includes/init.php';
require_once '../../includes/checkLoggedIn.php';

use PragmaRX\Google2FA\Google2FA;

if(isset($_POST["userId"])){
    $userId = filter_var($_POST["userId"],FILTER_SANITIZE_NUMBER_INT);
} else {
    $userId = '';
}
if(is_numeric($userId)){
    $google2fa = new Google2FA();
    $secret = $google2fa->generateSecretKey();

    $user = User::find_by_id($userId);
    $user->googlesecretkey = $secret;
    $user->save();
    $name = $user->firstname . ' ' . $user->surname;
    $out = new stdClass();
    $out->result = 'good';
    $out->name = $name;
    echo json_encode($out);
}