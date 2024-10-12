<?php
require_once('../config.php');

use app\util\CommonUtil;
use app\controllers\ItemController;

// // CSRF対策）
CommonUtil::csrf($_SESSION['token'], $_POST['token']);

// echo '<pre>';
// var_export($_POST);
// echo '</pre>';

// 削除時にサインや写真も削除する予定のためcontrollerを経由させる
try {
   $conItem = new ItemController();
   $conItem->softDelete($_POST);
} catch (Exception $e) {
   // var_dump($e);exit;
   header('Location: ./');
}

