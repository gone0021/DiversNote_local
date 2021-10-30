<?php
// 共通ファイル
require_once("../common.php");

// トークンの生成
$token = bin2hex(openssl_random_pseudo_bytes(108));
$_SESSION['token'] = $token;

// POSTされてきた値をSESSIONに代入（入力画面で再表示）
$email = "";
if (!empty($_SESSION['post']['email'])) {
   $email = $_SESSION['post']['email'];
}
