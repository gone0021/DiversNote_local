<?php
$root = $_SERVER['DOCUMENT_ROOT'];
$root .= "/data/DiversNote_local";
require_once($root . "/app/model/ItemModel.php");

// 値を渡す側で処理させるため不使用：サンプルで残している
// $request_body = file_get_contents('php://input'); 
// $data = json_decode($request_body,true);

// echo '<pre>';
// var_export($_POST);
// echo '</pre>';

$dbItem = new ItemModel();
$dbItem->soft_delete($req);

exit;

// echo '<br />';
// var_dump($ret);
// return json_encode($ret);

