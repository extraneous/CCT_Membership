<?php
require_once('../includes/init.php');
require_once('../includes/checkLoggedIn.php');
require_once('../includes/encFunctions.php');

$template = $twig->loadTemplate('db-MembershipService.twig');
header('X-Frame-Options: DENY');

$css = array();
$css[] = 'https://cdn.datatables.net/v/bs/moment-2.18.1/dt-1.10.16/b-1.4.2/r-2.2.0/sl-1.2.3/datatables.min.css';
$css[] = '/css/generator-base.css';
$css[] = '/css/editor.bootstrap.min.css';
$js = array();
$js[] = 'https://cdn.datatables.net/v/bs/moment-2.18.1/dt-1.10.16/b-1.4.2/r-2.2.0/sl-1.2.3/datatables.min.js';
$js[] = '/js/dataTables.editor.min.js';
$js[] = '/js/editor.bootstrap.js';
$js[] = '/js/table.membership_service.js';

echo $template->render(array(
    'pageTitle' => 'Membership Service',
    'pageHeading' => 'Membership Service',
    'user' => $user,
    'addCss' => $css,
    'addJs' => $js,
));