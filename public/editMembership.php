<?php
require_once('../includes/init.php');
require_once('../includes/checkLoggedIn.php');
require_once('../includes/encFunctions.php');

$template = $twig->loadTemplate('editMembership.twig');
header('X-Frame-Options: DENY');

if(isset($_GET["mid"])){
    $mid = $_GET["mid"];
    $mid = Decrypt($encVar,$mid);
} else {
    header('Location:memberAdmin.php');
}

$css = array();
$css[] = '/js/summernote/summernote.css';
$js = array();
$js[] = '/js/summernote/summernote.min.js';
$js[] = '/js/editMembership.js';

$strSQL = "SELECT ";

echo $template->render(array(
    'pageTitle' => 'Edit Membership',
    'pageHeading' => 'Edit Membership',
    'user' => $user,
    'addCss' => $css,
    'addJs' => $js,
));