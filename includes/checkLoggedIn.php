<?php
if(!isset($_SESSION)) {
    session_start();
}
if((isset($_SESSION['user']) == false || $_SESSION['user'] == '')){
    header ("Location: /login.php");
    exit;
} else {
    $user = json_decode($_SESSION["user"]);
}