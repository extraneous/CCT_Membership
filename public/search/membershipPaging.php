<?php
require_once '../../includes/init.php';
require_once '../../includes/checkLoggedIn.php';

if(isset($_GET["num"])){
    $num = filter_var($_GET["num"],FILTER_SANITIZE_NUMBER_INT);
} else {
    $num = 1;
}
if(isset($_GET["number"])){
    $memNo = filter_var($_GET["number"],FILTER_SANITIZE_STRING);
} else {
    $memNo = '';
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

if(is_numeric($num)) {
    $offset = ($num -1) * 20;
    $strSQL = "SELECT DISTINCT M.`MemNo`,P.Title,P.`FirstName`,P.`LastName`,A.`PostTown`,M.Status
            FROM person P JOIN personaddress PA ON P.`PersonId` = PA.`personid`
            JOIN address A ON PA.`addressid` = A.`AddressId`
            JOIN personmembership PM ON P.`PersonId` = PM.`PersonId`
            JOIN membership M ON PM.`MemNo` = M.`MemNo`
            WHERE 1 = 1";
    if ($memNo != '') {
        $strSQL .= ' AND M.MemNo = :memno';
    }
    if ($name != '') {
        $strSQL .= " AND P.LastName = :name";
    }
    if ($town != '') {
        $strSQL .= " AND A.PostTown = :town";
    }
    $strSQL .= " ORDER BY M.`MemNo`,P.`LastName`
            LIMIT :offset,20";
    $stmt = $db->prepare($strSQL);
    if($memNo != ''){
        $stmt->bindParam(':memno',$memNo,PDO::PARAM_STR);
    }
    if($name != ''){
        $stmt->bindParam(':name',$name,PDO::PARAM_STR);
    }
    if($town != ''){
        $stmt->bindParam(':town',$town,PDO::PARAM_STR);
    }
    $stmt->bindParam(':offset',$offset,PDO::PARAM_INT);
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
    echo json_encode($out);
}