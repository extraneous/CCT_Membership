<?php
require_once '../../includes/init.php';
require_once '../../includes/checkLoggedIn.php';

if(isset($_GET["MemNo"])){
    $memno = filter_var($_GET["MemNo"],FILTER_SANITIZE_STRING);
} else {
    $memno = '';
}
if(isset($_GET["name"])){
    $name = filter_var($_GET["name"],FILTER_SANITIZE_STRING);
} else {
    $name = '';
}
if(isset($_GET["town"])){
    $town = filter_var($_GET["town"],FILTER_SANITIZE_STRING);
} else {
    $town = '';
}

$countSQL = "SELECT COUNT(DISTINCT M.MemNo)
                FROM person P JOIN personaddress PA ON P.`PersonId` = PA.`personid`
                JOIN address A ON PA.`addressid` = A.`AddressId`
                JOIN personmembership PM ON P.`PersonId` = PM.`PersonId`
                JOIN membership M ON PM.`MemNo` = M.`MemNo`
                WHERE 1 = 1";
if($memno != ''){
    $countSQL .= ' AND M.MemNo = :memno';
}
if($name != ''){
    $countSQL .= " AND P.LastName = :name";
}
if($town != ''){
    $countSQL .= " AND A.PostTown = :town";
}
$stmt = $db->prepare($countSQL);
if($memno != ''){
    $stmt->bindParam(':memno',$memno,PDO::PARAM_STR);
}
if($name != ''){
    $stmt->bindParam(':name',$name,PDO::PARAM_STR);
}
if($town != ''){
    $stmt->bindParam(':town',$town,PDO::PARAM_STR);
}
$stmt->execute();
$recCount = $stmt->fetchColumn();
$pageCount = ceil($recCount / 20);

$strSQL = "SELECT DISTINCT M.`MemNo`,P.Title,P.`FirstName`,P.`LastName`,A.`PostTown`,M.Status
            FROM person P JOIN personaddress PA ON P.`PersonId` = PA.`personid`
            JOIN address A ON PA.`addressid` = A.`AddressId`
            JOIN personmembership PM ON P.`PersonId` = PM.`PersonId`
            JOIN membership M ON PM.`MemNo` = M.`MemNo`
            WHERE 1 = 1";
if($memno != ''){
    $strSQL .= ' AND M.MemNo = :memno';
}
if($name != ''){
    $strSQL .= " AND P.LastName = :name";
}
if($town != ''){
    $strSQL .= " AND A.PostTown = :town";
}
$strSQL .= " ORDER BY M.`MemNo`,P.`LastName`
            LIMIT 20";
$stmt = $db->prepare($strSQL);
if($memno != ''){
    $stmt->bindParam(':memno',$memno,PDO::PARAM_STR);
}
if($name != ''){
    $stmt->bindParam(':name',$name,PDO::PARAM_STR);
}
if($town != ''){
    $stmt->bindParam(':town',$town,PDO::PARAM_STR);
}
$stmt->execute();
$members = array();
while($row = $stmt->fetch(PDO::FETCH_OBJ)){
    $member = new stdClass();
    $member->memNo = $row->MemNo;
    $member->name = $row->Title . ' ' . $row->FirstName . ' ' . $row->LastName;
    $member->PostTown = ucwords(strtolower($row->PostTown));
    $member->status = $row->Status;
    $members[] = $member;
}
$out = new stdClass();
$out->members = $members;
$out->pages = $pageCount;
echo json_encode($out);