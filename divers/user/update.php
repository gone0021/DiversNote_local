<?php
require_once '../common_divers.php';

// クラスの読み込み
require_once($root . "/app/model/UserModel.php");

// サニタイズ
$post = CommonUtil::sanitaize($_POST);

//   var_dump($post); exit;

// データベースに登録する内容を連想配列にする。
$data = array(
   'id' => $post['id'],
   'user_name' => $post['user_name'],
   'email' => $post['email'],
   'birthday' => $post['birthday'],
   'password' => $post['password'],
);

// ユーザー情報のアップデート
try {
   $db = new UserModel();
   $db->updateUser($data);
} catch (Exception $e) {
   // var_dump($e);exit;
   header('Location: ../../error.php');
}

// tokenのクリア
$post['token'] = '';
unset($post['token']);

// ユーザーページへ遷移
header("Location: ./");