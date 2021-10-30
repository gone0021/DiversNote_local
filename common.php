<?php
// クラスの読み込み
$root = $_SERVER['DOCUMENT_ROOT'];
$root .= "/data/DiversNote_local";
require_once($root . "/app/util/SessionUtil.php");

// urlの指定
$rootUrl = $_SERVER['SERVER_NAME'];
$rootUrl .= "/data/DiversNote_local";
$url = 'http://' . $rootUrl;

// --- contact用 ---
// セッションスタート
SessionUtil::sessionStart();

// トークンの生成
$token = bin2hex(openssl_random_pseudo_bytes(108));
$_SESSION['token'] = $token;

// echo $url;