<?php
$root = $_SERVER['DOCUMENT_ROOT'];
$root .= "/data/DiversNote_local";
require_once($root . "/app/controllers/ItemController.php");
// require_once($root . "/app/model/ItemModel.php");

// var_dump($_GET);
$id = $_GET['id'];
$user_id = $_GET['user_id'];

$conItem = new ItemController();
$ret = $conItem->getItemById($user_id, $id);
$json = json_encode($ret);

echo $json;
return;


// echo '<br />';
// var_dump($ret);
// return json_encode($ret);

