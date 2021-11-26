<?php
// api、modelは別で作成
// rootの指定
$root = $_SERVER['DOCUMENT_ROOT'];
$root .= "/data/DiversNote_local";

// ディレクトリの指定
$img_dir = $root . '/divers/img/';
$singe_dir = $root . '/divers/signe/';
$divers_dir = $root . '/divers';

// urlの指定
$rootUrl = $_SERVER['SERVER_NAME'];
$rootUrl .= "/data/DiversNote_local";
$url = 'http://' . $rootUrl;