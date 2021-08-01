<?php
$root = $_SERVER['DOCUMENT_ROOT'];
$root .= "/data/DiversNote_local";
require_once($root . "/app/controllers/ItemController.php");

// 値を渡す側（vue）で処理させるため不使用：サンプルで残している
// $request_body = file_get_contents('php://input'); 
// $data = json_decode($request_body,true);

// echo '<pre>';
// var_export($_POST);
// echo '</pre>';

$conItem = new ItemController();
$conItem->update($_POST);

exit;
// return 1;


// echo '<br />';
// var_dump($ret);
// return json_encode($ret);

