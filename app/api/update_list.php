<?php
$root = $_SERVER['DOCUMENT_ROOT'];
$root .= "/data/DiversNote_local";
require_once($root . "/app/controllers/ListController.php");

// echo '<pre>';
// var_dump($_POST);
// echo '</pre>';
// die;

$conList = new ListController();
$conList->update($_POST);

exit;

// echo '<br />';
// var_dump($ret);
// return json_encode($ret);

