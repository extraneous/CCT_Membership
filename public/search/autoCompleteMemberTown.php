<?php
require_once '../../includes/init.php';
require_once '../../includes/checkLoggedIn.php';

if(isset($_GET["query"])){
    $query = filter_var($_GET["query"],FILTER_SANITIZE_STRING);
    $strSQL = "SELECT DISTINCT A.PostTown
                FROM address A JOIN personaddress PA ON PA.`addressid` = A.`AddressId`
                JOIN person P ON PA.`personid` = P.`PersonId`
                JOIN personmembership PM ON P.`PersonId` = PM.`PersonId`
                WHERE A.`PostTown` LIKE ?
                ORDER BY A.`PostTown`";
    $stmt = $db->prepare($strSQL);
    $search = '%' . $query . '%';
    $stmt->bindParam(1,$search,PDO::PARAM_STR);
    $stmt->execute();
    $result = array();
    while($row = $stmt->fetch(PDO::FETCH_OBJ)){
        $item = new stdClass();
        $item->id = ucwords(strtolower($row->PostTown));
        $item->label = ucwords(strtolower($row->PostTown));
        $result[] = $item;
    }
    echo json_encode($result);
}