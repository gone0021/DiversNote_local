<?php
require_once('./app/config.php');

// session自体を削除してログアウト処理とする
session_destroy();

// ホームへリダイレクト
header("Location: $urlHome");
