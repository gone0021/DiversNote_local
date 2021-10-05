<?php
$root = $_SERVER["DOCUMENT_ROOT"];
$root .= "/data/DiversNote_local";
require_once($root . "/app/util/SessionUtil.php");
require_once($root . "/app/util/CommonUtil.php");
require_once($root . "/app/model/UserModel.php");

// セッションスタート
SessionUtil::sessionStart();

// サニタイズ
$post = CommonUtil::sanitaize($_POST);

// データベースに登録する内容を連想配列にする。
$data = array(
   'id' => $post['id'],
   'user_name' => $post['user_name'],
   'email' => $post['email'],
   'birthday' => $post['birthday'],
   'password' => $post['password'],
);

//   var_dump($post); exit;

// ユーザー情報のアップデート
try {
   $db = new UserModel();
   $db->updateUser($data);
} catch (Exception $e) {
   // var_dump($e);exit;
   header('Location: ../../error.php');
}

unset($post['token']);

// ユーザーページへ遷移
header("Location: ./");

?>