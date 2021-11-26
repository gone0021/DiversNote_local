<?php
// 基礎設定
// rootの指定
$root = $_SERVER['DOCUMENT_ROOT'];
$root .= "/data/DiversNote_local";
$rootDivers = $root . '/divers';

// urlの指定
$rootUrl = $_SERVER['SERVER_NAME'];
$rootUrl .= "/data/DiversNote_local";
$url = 'http://' . $rootUrl;

// クラスの読み込み
require_once($root . "/app/util/SessionUtil.php");
require_once($root . "/app/util/CommonUtil.php");

// セッションスタート
SessionUtil::sessionStart();

// トークンの生成
$token = bin2hex(openssl_random_pseudo_bytes(108));