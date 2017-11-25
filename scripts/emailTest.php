<?php

$email = filter_var('richard.dicker@sky.com#mailto:richard.dicker@sky.com#',FILTER_SANITIZE_EMAIL);
$pos = strpos($email,'#');
if($pos !== FALSE){
	$email = substr($email,0,($pos));
}
echo $email;