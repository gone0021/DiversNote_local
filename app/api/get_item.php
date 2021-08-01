<?php
$root = $_SERVER['DOCUMENT_ROOT'];
$root .= "/data/DiversNote";
require_once($root . "/app/model/ItemModel.php");

$user_id = $_GET['user_id'];

$dbItem = new ItemModel();
$ret = $dbItem->getUserItem($user_id);
$json = json_encode($ret);

echo $json;
return;


// echo '<br />';
// var_dump($ret);
// return json_encode($ret);

