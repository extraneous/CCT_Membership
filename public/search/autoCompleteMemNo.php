<?php
require_once '../../includes/init.php';
require_once '../../includes/checkLoggedIn.php';

if(isset($_GET["query"])){
    $query = filter_var($_GET["query"],FILTER_SANITIZE_STRING);
    $strSQL = "SELECT MemNo FROM membership WHERE MemNo LIKE ? ORDER BY MemNo";
    $stmt = $db->prepare($strSQL);
    $search = '%' . $query . '%';
    $stmt->bindParam(1,$search,PDO::PARAM_STR);
    $stmt->execute();
    $result = array();
    while($row = $stmt->fetch(PDO::FETCH_OBJ)){
        $item = new stdClass();
        $item->id = $row->MemNo;
        $item->label = $row->MemNo;
        $result[] = $item;
    }
    echo json_encode($result);
}