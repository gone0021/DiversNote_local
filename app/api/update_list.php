<?php
require_once('../config.php');

use app\util\CommonUtil;
use app\controllers\ListController;

// echo '<pre>';
// var_dump($_POST);
// echo '</pre>';
// die;

// CSRF対策）
CommonUtil::csrf($_SESSION['token'], $_POST['token']);

// サニタイズ
// 値の並び替えはControllerで処理している
$post['tag_name'] = CommonUtil::sanitaize($_POST['tag_name']);
$post['list_name'] = CommonUtil::sanitaize($_POST['list_name']);
$post['is_checked'] = CommonUtil::sanitaize($_POST['is_checked']);

// postする変数名と合わせるための代入
$post['user_id'] = $_POST['user_id'];


// echo '<pre>';
// var_dump($post);
// echo '</pre>';
// die;

try {
   $conList = new ListController();
   $conList->update($post);
} catch (Exception $e) {
   // var_dump($e);exit;
   header('Location: ./');
}
// echo '<br />';
// var_dump($ret);
// return json_encode($ret);
