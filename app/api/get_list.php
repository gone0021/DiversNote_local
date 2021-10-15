<?php
$root = $_SERVER['DOCUMENT_ROOT'];
$root .= "/data/DiversNote_local";
require_once($root . "/app/model/ListModel.php");

$user_id = $_GET['user_id'];

$dbList = new ListModel();
$ret = $dbList->getList($user_id);
$json = json_encode($ret);

echo $json;
return;


// echo '<br />';
// var_dump($ret);
// return json_encode($ret);

