<?php
require_once '../common_divers.php';

// sessionに保存されているユーザーの情報を変数に保存
$user = $_SESSION['user'];

// sessionに$tokenの値を保存
$_SESSION['token'] = $token;