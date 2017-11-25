<?php
require_once('../includes/init.php');
require_once('../includes/checkLoggedIn.php');

$template = $twig->loadTemplate('userAdmin.twig');
header('X-Frame-Options: DENY');

$css = array();
$css[] = '/css/summernote.css';
$js = array();
$js[] = '/js/underscore.min.js';
$js[] = '/js/bootstrap-checkbox.js';
$js[] = '/js/bootbox.min.js';
$js[] = '/js/summernote.min.js';
$js[] = '/js/userAdmin.js';

$strSQL = "SELECT id,firstName,surname,email,status,failedLogins
            FROM users ORDER BY surname";
$stmt = $db->prepare($strSQL);
$stmt->execute();
$users = array();
while($row = $stmt->fetch(PDO::FETCH_OBJ)){
    $lastLogin = '';
    $strSQL = "SELECT DATE_FORMAT(created_at,'%d/%m/%Y %H:%i') AS login 
                FROM goodLogins WHERE userid = ?
                ORDER BY id DESC LIMIT 1";
    $stmt2 = $db->prepare($strSQL);
    $stmt2->bindParam(1,$row->id,PDO::PARAM_INT);
    $stmt2->execute();
    $lastLogin = $stmt2->fetchColumn();

    $suser           = new stdClass();
    $suser->id       = $row->id;
    $suser->fname    = $row->firstName;
    $suser->surname  = $row->surname;
    $suser->email    = $row->email;
    $suser->status   = $row->status;
    $suser->failedLogins = $row->failedLogins;
    $suser->lastLogin = $lastLogin;
    $users[] = $suser;
}
$strSQL = "SELECT P.id, P.name
                FROM permissions P JOIN userPermissions UP ON P.id = UP.`permissionId`
                WHERE UP.`userId` = ?
                ORDER BY P.name";
$stmt = $db->prepare($strSQL);
$stmt->bindParam(1,$user->id,PDO::PARAM_INT);
$stmt->execute();
$permissionArr = array();
while($row = $stmt->fetch(PDO::FETCH_OBJ)){
    $permission         = new stdClass();
    $permission->id     = $row->id;
    $permission->name   = $row->name;
    $permissionArr[]    = $permission;
}

echo $template->render(array(
    'pageTitle' => 'User Admin',
    'pageHeading' => 'User Admin',
    'user' => $user,
    'addCss' => $css,
    'addJs' => $js,
    'users' => $users,
    'permissions' => $permissionArr,
));