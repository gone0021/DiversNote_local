<?php
require_once('../app/config.php');

use app\util\CommonUtil;
use app\model\BaseModel;
use app\model\ItemModel;
use app\model\PhotoModel;

// --- ログインの確認 ---
// $user = $_SESSION['user'];
$user = CommonUtil::isUser($_SESSION['user'], $urlError);
// $_SESSION['user'] = $user;

// var_dump($user);

// sessionに$tokenの値を保存する
$_SESSION['token'] = $token;

// jsへ送る値
$toJs = [
   'user_id' => $user['id'],
   'price_plan' => $user['price_plan'],
   'token' => $token,
];

$db = BaseModel::getInstance();
$dbItem = new ItemModel($db);
$dbPhoto = new PhotoModel($db);

try {
   // itemの一覧を取得
   $items = $dbItem->getUserItem($user['id']);
   // 次のNoを取得
   $next_num = $dbItem->getMaxItemNum($user['id']);
} catch (Exception $e) {
   // var_dump($e);exit;
   header("Location: $urlError");
}

// echo '<pre>';
// var_export($_SESSION);
// echo '</pre>';

// var_dump($next_num);
// var_dump($_SESSION['user']);
