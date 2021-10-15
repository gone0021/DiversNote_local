<?php
// ユーザー情報以外のセッションをクリア
$_SESSION['post'] = '';
unset($_SESSION['post']);
$_SESSION['msg'] = '';
unset($_SESSION['msg']);
$_SESSION['user']['password'] = '';
unset($_SESSION['user']['password']);
