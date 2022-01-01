<?php
require_once('../config.php');

use app\controllers\ItemController;

// 値を渡す側で処理させるため不使用：サンプルで残している
// $request_body = file_get_contents('php://input'); 
// $data = json_decode($request_body,true);

// echo '<pre>';
// var_export($_POST);
// echo '</pre>';
try {
   $conItem = new ItemController();
   $conItem->soft_delete($_POST);
} catch (Exception $e) {
   // var_dump($e);exit;
   header('Location: ./');
}
// echo '<br />';
// var_dump($ret);
// return json_encode($ret);
