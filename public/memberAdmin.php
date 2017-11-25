<?php
require_once('../includes/init.php');
require_once('../includes/checkLoggedIn.php');
require_once('../includes/encFunctions.php');

$template = $twig->loadTemplate('memberAdmin.twig');
header('X-Frame-Options: DENY');

$css = array();
$css[] = '/css/bootcomplete.css';
$js = array();
$js[] = '/js/jquery.alphanum.js';
$js[] = '/js/bootbox.min.js';
$js[] = '/js/underscore.min.js';
$js[] = '/js/jquery.bootpag.min.js';
$js[] = '/js/jquery.bootcomplete.js';
$js[] = '/js/memberAdmin.js';

$countSQL = "SELECT COUNT(DISTINCT M.MemNo)
                FROM person P JOIN personaddress PA ON P.`PersonId` = PA.`personid`
                JOIN address A ON PA.`addressid` = A.`AddressId`
                JOIN personmembership PM ON P.`PersonId` = PM.`PersonId`
                JOIN membership M ON PM.`MemNo` = M.`MemNo`";
$stmt = $db->prepare($countSQL);
$stmt->execute();
$recCount = $stmt->fetchColumn();
$pageCount = ceil($recCount / 20);

$strSQL = "SELECT DISTINCT M.`MemNo`,P.Title,P.`FirstName`,P.`LastName`,A.`PostTown`,M.Status
            FROM person P JOIN personaddress PA ON P.`PersonId` = PA.`personid`
            JOIN address A ON PA.`addressid` = A.`AddressId`
            JOIN personmembership PM ON P.`PersonId` = PM.`PersonId`
            JOIN membership M ON PM.`MemNo` = M.`MemNo`
            ORDER BY M.`MemNo`,P.`LastName`
            LIMIT 20";
$stmt = $db->prepare($strSQL);
$stmt->execute();
$members = array();
while($row = $stmt->fetch(PDO::FETCH_OBJ)){
    $member = new stdClass();
    $member->memNo = $row->MemNo;
    $member->memNoEnc = urlencode(Encrypt($encKey,$row->MemNo));
    $member->name = $row->Title . ' ' . $row->FirstName . ' ' . $row->LastName;
    $member->PostTown = ucwords(strtolower($row->PostTown));
    $member->status = $row->Status;
    $members[] = $member;
}

echo $template->render(array(
    'pageTitle' => 'Membership Admin',
    'pageHeading' => 'Membership Admin',
    'user' => $user,
    'addCss' => $css,
    'addJs' => $js,
    'members' => $members,
    'pageCount' => $pageCount,
));