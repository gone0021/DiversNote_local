<?php
$root = $_SERVER['DOCUMENT_ROOT'];
$root .= "/data/DiversNote_local";
require_once($root . "/app/controllers/ItemController.php");

// 値を渡す側（vue）で処理させるため不使用：サンプルで残している
// $request_body = file_get_contents('php://input'); 
// $data = json_decode($request_body,true);

// jsonをデコードして代入
$_POST['new_img'] = json_decode($_POST['new_img'], true);
$_POST['edit_img'] = json_decode($_POST['edit_img'], true);
$_POST['del_img'] = json_decode($_POST['del_img'], true);

// echo '<pre>';
// var_dump($_POST['new_img']);
// var_dump($_POST['edit_img']);
// var_dump($_POST['del_img']);
// echo '</pre>';
// die;

$conItem = new ItemController();
$conItem->update($_POST);

exit;
// return 1;


// echo '<br />';
// var_dump($ret);
// return json_encode($ret);

