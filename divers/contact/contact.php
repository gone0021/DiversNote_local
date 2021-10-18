<?php
// クラスの読み込み
$root = $_SERVER['DOCUMENT_ROOT'];
$root .= "/data/DiversNote_local";
require_once($root . "/app/util/SessionUtil.php");
require_once($root . "/app/util/CommonUtil.php");
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
// $token = $_SESSION['token'];
$token = bin2hex(openssl_random_pseudo_bytes(108));
$_SESSION['token'] = $token;

// var_dump($_SESSION);
