<?php
require_once '../common_divers.php';

// クラスの読み込み
require_once($root . "/app/controllers/UserController.php");
require_once($root . "/app/model/UserModel.php");

// sessionに保存されているユーザーの情報を変数に保存
$user = $_SESSION['user'];

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