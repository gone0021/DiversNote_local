<?php
require_once('../../app/config.php');

use app\util\CommonUtil;

// 戻るボタンで戻ってきた時対策
$arr = ['user'];
CommonUtil::unsession($arr);

// tokenをsessionに保存
$_SESSION['token'] = $token;

// SESSIONに保存したPOSTデータ
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
