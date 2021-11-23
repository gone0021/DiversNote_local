<?php
$root = $_SERVER['DOCUMENT_ROOT'];
$root .= "/data/DiversNote_local";
require_once($root . "/app/controllers/ItemController.php");

// echo '<pre>';
// var_dump($_POST);
// echo '</pre>';
// die;

$_POST['new_img'] = json_decode($_POST['new_img'], true);

$conItem = new ItemController();
$conItem->store($_POST);

exit;

// echo '<br />';
// var_dump($ret);
// return json_encode($ret);
