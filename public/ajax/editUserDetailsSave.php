<?php
require_once '../../includes/init.php';
require_once '../../includes/checkLoggedIn.php';
$save = true;
if(isset($_POST["firstName"])){
    $firstName = filter_var($_POST["firstName"],FILTER_SANITIZE_STRING);
} else {
    $firstName = '';
    $save = false;
}
if(isset($_POST["surname"])){
    $surname = filter_var($_POST["surname"],FILTER_SANITIZE_STRING);
} else {
    $surname = '';
    $save = false;
}
if(isset($_POST["email"])){
    $email = filter_var($_POST["email"],FILTER_SANITIZE_EMAIL);
} else {
    $email = '';
    $save = false;
}
if(isset($_POST["password"])){
    $password = filter_var($_POST["password"],FILTER_SANITIZE_STRING);
} else {
    $password = '';
}
$password = trim($password);

if($save){
    $userObj = User::find($user->id);
    $userObj->firstname = $firstName;
    $userObj->surname   = $surname;
    if($password != '') {
        $userObj->password = password_hash($password, PASSWORD_DEFAULT);
    }
    $userObj->email     = $email;
    $userObj->save();

    //Update the session details of user.
    $user->firstname    = $firstName;
    $user->surname      = $surname;
    $user->username     = $username;
    $user->email        = $email;
    $_SESSION["user"] = null;
    $_SESSION["user"]   = json_encode($user);
}