<?php
require_once('../config.php');

use app\util\CommonUtil;
use app\controllers\ItemController;

// // CSRF対策）
CommonUtil::csrf($_SESSION['token'], $_POST['token']);

// サニタイズ
$post = CommonUtil::sanitaize($_POST);

// postからtokenを削除
unset($post['token']);

// echo '<pre>';
// var_dump($_POST);
// echo '</pre>';
// die;

// 画像はjsonをデコードしてから保存
$post['new_img'] = json_decode($_POST['new_img'], true);
$post['edit_img'] = json_decode($_POST['edit_img'], true);
$post['del_img'] = json_decode($_POST['del_img'], true);

// echo '<pre>';
// var_dump($_POST['new_img']);
// var_dump($_POST['edit_img']);
// var_dump($_POST['del_img']);
// echo '</pre>';
// die;

try {
   $conItem = new ItemController();
   $conItem->update($post);
} catch (Exception $e) {
   // var_dump($e);exit;
   header('Location: ./');
}

// echo '<br />';
// var_dump($ret);
// return json_encode($ret);
