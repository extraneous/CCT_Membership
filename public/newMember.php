<?php
require_once('../includes/init.php');
require_once('../includes/checkLoggedIn.php');

$template = $twig->loadTemplate('newMember.twig');
header('X-Frame-Options: DENY');

$css = array();
$js = array();
$js[] = '/js/jquery.alphanum.js';
$js[] = '/js/bootbox.min.js';
$js[] = '/js/underscore.min.js';
$js[] = '/js/newMember.js';

echo $template->render(array(
    'pageTitle' => 'New Member',
    'pageHeading' => 'New Member',
    'user' => $user,
    'addCss' => $css,
    'addJs' => $js,
));