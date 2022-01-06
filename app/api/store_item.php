<?php
require_once('../config.php');

use app\util\CommonUtil;
use app\controllers\ItemController;

// // CSRF対策）
CommonUtil::csrf($_SESSION['token'], $_POST['token']);

// サニタイズ
$post = CommonUtil::sanitaize($_POST);

// echo '<pre>';
// var_dump($post);
// echo '</pre>';
// die;

// 画像はjsonをデコードしてから保存
$post['new_img'] = json_decode($_POST['new_img'], true);

try {
   $conItem = new ItemController();
   $conItem->store($post);
} catch (Exception $e) {
   // var_dump($e);exit;
   header('Location: ./');
}
// echo '<br />';
// var_dump($ret);
// return json_encode($ret);
