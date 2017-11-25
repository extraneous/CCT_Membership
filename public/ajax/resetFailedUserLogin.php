<?php
require_once '../../includes/init.php';
require_once '../../includes/checkLoggedIn.php';

if(isset($_POST["userId"])){
    $userId = filter_var($_POST["userId"],FILTER_SANITIZE_NUMBER_INT);
} else {
    $userId = '';
}
if(is_numeric($userId)){
    $userObj = User::find($userId);
    $userObj->failedlogins = 0;
    $userObj->save();
}