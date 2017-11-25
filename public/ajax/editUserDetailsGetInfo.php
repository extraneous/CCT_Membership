<?php
require_once '../../includes/init.php';
require_once '../../includes/checkLoggedIn.php';

$out = new stdClass();
$out->firstname = $user->firstname;
$out->surname   = $user->surname;
$out->email     = $user->email;

echo json_encode($out);