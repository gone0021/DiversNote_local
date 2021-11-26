<?php
require_once 'base_setting.php';

// クラスの読み込み
require_once($root . "/app/util/SessionUtil.php");

// セッションスタート
SessionUtil::sessionStart();

// トークンの生成
$token = bin2hex(openssl_random_pseudo_bytes(108));
$_SESSION['token'] = $token;