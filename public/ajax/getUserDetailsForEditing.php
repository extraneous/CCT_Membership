<?php
require_once '../../includes/init.php';
require_once '../../includes/checkLoggedIn.php';

if(isset($_GET["userId"])){
    $userId = filter_var($_GET["userId"],FILTER_SANITIZE_NUMBER_INT);
} else {
    $userId = '';
}
if(is_numeric($userId)){
    $userObj = User::find_by_id($userId);
    $out = new stdClass();

    $out->firstname = $userObj->firstname;
    $out->surname   = $userObj->surname;
    $out->status    = $userObj->status;
    $out->email     = $userObj->email;

    $permissions = array();

    $permisObjs = Userpermission::find_all_by_userid($userId);
    foreach($permisObjs as $permis){
        $permissions[] = $permis->permissionid;
    }

    $out->permissions = $permissions;
    echo json_encode($out);
}