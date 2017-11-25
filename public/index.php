<?php
require_once '../includes/init.php';
require_once '../includes/checkLoggedIn.php';

$template = $twig->loadTemplate('index.twig');
header('X-Frame-Options: DENY');

$css = array();
$js = array();
$js[] = '/js/index.js';

echo $template->render(array(
    'pageTitle' => 'Home Page',
    'pageHeading' => 'Welcome',
    'addCss' => $css,
    'addJs' => $js,
    'user' => $user
));