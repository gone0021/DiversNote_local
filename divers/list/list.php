<?php
require_once '../common_divers.php';

// クラスの読み込み
require_once($root . "/app/controllers/ListController.php");
require_once($root . "/app/model/ListModel.php");

// sessionに保存されているユーザーの情報を変数に保存
$user = $_SESSION['user'];

// sessionに$tokenの値を保存
$_SESSION['token'] = $token;

$toJs = [
   'user_id' => $user['id'],
   'price_plan' => $user['price_plan'],
   'token' => $token,
];


// var_dump($_SESSION);

// echo '<pre>';
// var_export($list);
// echo '</pre>';