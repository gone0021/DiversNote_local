<?php
$root = $_SERVER['DOCUMENT_ROOT'];
$root .= "/data/DiversNote_local";
require_once($root . "/app/model/PhotoModel.php");

$item_id = $_GET['item_id'];

$dbPhoto = new PhotoModel();
$ret = $dbPhoto->getPhotoByItemId($item_id);
$json = json_encode($ret);

echo $json;
return;


// echo '<br />';
// var_dump($ret);
// return json_encode($ret);

