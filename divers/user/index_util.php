<?php
require_once('../../app/config.php');

use app\util\CommonUtil;

// ログインのチェック
$user = CommonUtil::isUser($_SESSION['user'], $urlError);
$_SESSION['user'] = $user;

// sessionに$tokenの値を保存する
$_SESSION['token'] = $token;

// ※SESSIONに保存したPOSTデータ（パスワードは保存しない）
// ユーザー名
$user_name = $user['user_name'];
if (!empty($_SESSION['post']['user_name'])) {
   $user_name =  $_SESSION['post']['user_name'];
}
// メールアドレス
$email = $user['email'];
if (!empty($_SESSION['post']['email'])) {
   $email = $_SESSION['post']['email'];
}
// 誕生日
$birthday = $user['birthday'];
if (!empty($_SESSION['post']['birthday'])) {
   $birthday = $_SESSION['post']['birthday'];
}