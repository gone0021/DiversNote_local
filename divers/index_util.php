<?php
require_once('../app/config.php');

use app\util\CommonUtil;
use app\model\BaseModel;
use app\model\ItemModel;
use app\util\Paging;

// --- ログインの確認 ---
// $user = $_SESSION['user'];
$user = CommonUtil::isUser($_SESSION['user'], $urlError);
// $_SESSION['user'] = $user;

// var_dump($user);

// sessionに$tokenの値を保存する
$_SESSION['token'] = $token;

// ページング設定
$page = 1;
$row = 20;
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
   $page = (int)$_GET['page'];
}
if (!$page) {
   $page = 1;
}

// 日付：jsより楽なのでphpで設定
$date = date("Y-m-d");


try {
   $db = BaseModel::getInstance();
   $dbItem = new ItemModel($db);
   // itemの一覧を取得：ページングの総数計算用
   $allItems = $dbItem->getUserItem($user['id']);

   // 表示用のため使用しない：表示するカラムを取得
   // $items = $dbItem->getItemNum($user['id'], $page, $row);

   // 次のNoを取得：jsで取得しているけど、PHPの値を送るか悩んでる
   // $next_num = $dbItem->getMaxItemNum($user['id']);
} catch (Exception $e) {
   // var_dump($e);exit;
   header("Location: $urlError");
}

// ページング
$pageing = new Paging();
// オリジナル
// $pref = $pageing->usePafing($_GET['page']);
$pageing->count = $row;
$pageing->setHtml(count($allItems));


// jsへ送る値
$toJs = [
   'user_id' => $user['id'],
   'price_plan' => $user['price_plan'],
   'token' => $token,
   'page' => $page,
   'row' => $row,
   'date' => $date,
];

// echo '<pre>';
// var_export($_SESSION);
// echo '</pre>';

// var_dump($next_num);
// var_dump($_SESSION['user']);
