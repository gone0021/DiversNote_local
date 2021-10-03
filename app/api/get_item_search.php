<?php
$root = $_SERVER['DOCUMENT_ROOT'];
$root .= "/data/DiversNote_local";
require_once($root . "/app/controllers/ItemController.php");

$user_id = $_GET['user_id'];

// echo '<pre>';
// var_export($_GET);
// echo '</pre>';
// die;

$conItem = new ItemController();
$ret = $conItem->getSchItems($user_id, $_GET['select'], $_GET['val']);

$json = json_encode($ret);

echo $json;
return;


// echo '<br />';
// var_dump($ret);
// return json_encode($ret);
