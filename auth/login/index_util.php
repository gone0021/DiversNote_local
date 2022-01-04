<?php
require_once('../../app/config.php');

use app\util\CommonUtil;

// 戻るボタンで戻ってきた時対策
$arr = ['user'];
CommonUtil::unsession($arr);

// tokenをsessionに保存
$_SESSION['token'] = $token;

// POSTされてきた値をSESSIONに代入（入力画面で再表示）
$email = "";
if (!empty($_SESSION['post']['email'])) {
   $email = $_SESSION['post']['email'];
}
