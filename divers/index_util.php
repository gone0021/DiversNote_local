<?php
require_once 'common_divers.php';

// クラスの読み込み
require_once($root . "/app/model/ItemModel.php");
require_once($root . "/app/model/PhotoModel.php");

// --- ログインの確認 ---
// $_SESSION['user']：ログイン時に取得したユーザー情報
if (empty($_SESSION['user'])) {
   // 未ログインのとき
   header('Location: ../');
} else {
   // ログイン済みのとき
   $user = $_SESSION['user'];
}

// sessionに$tokenの値を保存する
$_SESSION['token'] = $token;

// jsへ送る値
$toJs = [
   'user_id' => $user['id'],
   'price_plan' => $user['price_plan'],
   'token' => $token,
];

$dbItem = new ItemModel();
$dbPhoto = new PhotoModel();

try {
   // itemの一覧を取得
   $items = $dbItem->getUserItem($user['id']);
   // 次のNoを取得
   $next_num = $dbItem->getMaxItemNum($user['id']);
} catch (Exception $e) {
   // var_dump($e);exit;
   header('Location: ../error.php');
}

// echo '<pre>';
// var_export($_SESSION);
// echo '</pre>';

// var_dump($next_num);
// var_dump($_SESSION['user']);
