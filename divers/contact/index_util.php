<?php
require_once('../../app/config.php');

use app\util\CommonUtil;

// ログインのチェック
$user = CommonUtil::isUser($_SESSION['user'], $urlError);
$_SESSION['user'] = $user;

// sessionに$tokenの値を保存
$_SESSION['token'] = $token;