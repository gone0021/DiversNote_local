<?php
// クラスの読み込み
$root = $_SERVER['DOCUMENT_ROOT'];
$root .= "/data/DiversNote_local";
require_once($root . "/app/util/SessionUtil.php");
require_once($root . "/app/util/CommonUtil.php");
require_once($root . "/app/controllers/ListController.php");
require_once($root . "/app/model/ListModel.php");
$divers = $root . '/divers';

// urlの指定
$rootUrl = $_SERVER['SERVER_NAME'];
$rootUrl .= "/data/DiversNote_local";
$url = 'http://' . $rootUrl;
// echo $url;

// セッションスタート
SessionUtil::sessionStart();

// --- ログインの確認 ---
// $_SESSION['user']：ログイン時に取得したユーザー情報
if (empty($_SESSION['user'])) {
   // 未ログインのとき
   header('Location: ../');
} else {
   // ログイン済みのとき
   $user = $_SESSION['user'];
}

// トークンを変数に代入
$token = bin2hex(openssl_random_pseudo_bytes(108));
$_SESSION['token'] = $token;

$toJs = [
   'user_id' => $user['id'],
   'price_plan' => $user['price_plan'],
   'token' => $token,
];


// var_dump($_SESSION);

// echo '<pre>';
// var_export($list);
// echo '</pre>';