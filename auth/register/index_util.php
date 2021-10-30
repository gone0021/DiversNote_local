<?php
// 共通ファイル
require_once("../common.php");

// トークンの生成
$token = bin2hex(openssl_random_pseudo_bytes(108));
$_SESSION['token'] = $token;

// ※ SESSIONに保存したPOSTデータ（パスワードは保存しない）
// ユーザー名
$name = "";
if (!empty($_SESSION['post']['name'])) {
   $name =  $_SESSION['post']['name'];
}
// メールアドレス
$email = "";
if (!empty($_SESSION['post']['email'])) {
   $email = $_SESSION['post']['email'];
}
// 誕生日
$birthday = date("2000-01-01");
if (!empty($_SESSION['post']['birthday'])) {
   $birthday = $_SESSION['post']['birthday'];
}

// var_dump($root);
// var_dump($_SESSION['post']);
