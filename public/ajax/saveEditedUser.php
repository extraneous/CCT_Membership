<?php
require_once '../../includes/init.php';
require_once '../../includes/checkLoggedIn.php';

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
    require_once('../../includes/password.php');
}

if(isset($_POST["userId"])){
    $userId = filter_var($_POST["userId"],FILTER_SANITIZE_NUMBER_INT);
} else {
    $userId = '';
}
if(isset($_POST["firstname"])){
    $firstname = filter_var($_POST["firstname"],FILTER_SANITIZE_STRING);
} else {
    $firstname = '';
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
if(isset($_POST["status"])){
    $status = filter_var($_POST["status"],FILTER_SANITIZE_NUMBER_INT);
} else {
    $status = 0;
}
if(isset($_POST["permStr"])){
    $permStr = filter_var($_POST["permStr"],FILTER_SANITIZE_STRING);
} else {
    $permStr = '';
}
$perArr = explode(',',$permStr);

if($status > 0){
    $status = 1;
} else {
    $status = 0;
}
if(is_numeric($userId)){
    $userObj = User::find_by_id($userId);
    $userObj->firstname = $firstname;
    $userObj->surname = $surname;
    $userObj->email = $email;
    if($password != ''){
        $userObj->password =  password_hash($password, PASSWORD_DEFAULT);
    }
    $userObj->status = $status;
    $userObj->updated_by = $user->id;
    $userObj->save();
    $strSQL = "DELETE FROM userPermissions WHERE userId = ?";
    $stmt = $db->prepare($strSQL);
    $stmt->bindParam(1,$userId,PDO::PARAM_INT);
    $stmt->execute();
    foreach($perArr as $per){
        $perId = filter_var($per,FILTER_SANITIZE_NUMBER_INT);
        if(is_numeric($perId)){
            $up = new Userpermission();
            $up->userid = $userId;
            $up->permissionid = $perId;
            $up->save();
        }
    }
}