<?php
require_once '../../includes/init.php';
require_once '../../includes/checkLoggedIn.php';

if(isset($_GET["query"])){
    $query = filter_var($_GET["query"],FILTER_SANITIZE_STRING);
    $strSQL = "SELECT DISTINCT P.LastName 
                FROM person P JOIN personmembership PM ON P.PersonId = PM.PersonId
                WHERE P.LastName LIKE ? 
                ORDER BY P.LastName
                LIMIT 10";
    $stmt = $db->prepare($strSQL);
    $search = '%' . $query . '%';
    $stmt->bindParam(1,$search,PDO::PARAM_STR);
    $stmt->execute();
    $result = array();
    while($row = $stmt->fetch(PDO::FETCH_OBJ)){
        $item = new stdClass();
        $item->id = $row->LastName;
        $item->label = $row->LastName;
        $result[] = $item;
    }
    echo json_encode($result);
}