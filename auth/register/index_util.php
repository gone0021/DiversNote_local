<?php
require_once('../../app/config.php');

use app\util\CommonUtil;

// 戻るボタンで戻ってきた時対策
$arr = ['user'];
CommonUtil::unsession($arr);

// tokenをsessionに保存
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
