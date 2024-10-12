<?php
require_once('../app/config.php');

// ログインユーザー情報をクリアしてログアウト処理とする
session_destroy();

// ログインページへリダイレクト
header("Location: ../");
