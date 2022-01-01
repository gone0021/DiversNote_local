<?php
require_once('../config.php');

use app\util\CommonUtil;
use app\controllers\ItemController;


// // CSRF対策）
CommonUtil::csrf($_SESSION['token'], $_POST['token']);

// サニタイズ
$post = CommonUtil::sanitaize($_POST);

// 
// $post['singe'] = $_POST['singe'];
// postからtokenを削除
unset($post['token']);

// var_dump($post);

// echo '<pre>';
// var_dump($post);
// echo '</pre>';
// echo '<pre>';
// var_dump($_POST);
// echo '</pre>';
// die;

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

try {
   $conItem = new ItemController();
   $conItem->update($_POST);
} catch (Exception $e) {
   // var_dump($e);exit;
   header('Location: ./');
}

// echo '<br />';
// var_dump($ret);
// return json_encode($ret);
