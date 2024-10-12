<?php
require_once('../../app/config.php');

use app\util\CommonUtil;
use app\model\BaseModel;
use app\model\UserModel;
use app\controllers\UserController;

require_once($root . "/app/util/CommonUtil.php");
require_once($root . "/app/util/ValidationUtil.php");
require_once($root . "/app/controllers/UserController.php");
require_once($root . "/app/model/UserModel.php");

// CSRF対策）
CommonUtil::csrf($_SESSION['token'], $_POST['token']);

// サニタイズ
$post = CommonUtil::sanitaize($_POST);

// postされたtokenを削除
unset($post['token']);

// echo '<pre>';
// var_dump($post);
// echo '</pre>';
// die;

// パスワードの暗号化
$hash = password_hash($post['password'], PASSWORD_DEFAULT);

// データベースに登録する内容を連想配列にする。
$data = array(
   'user_name' => $post['name'],
   'email' => $post['email'],
   'birthday' => $post['birthday'],
   'password' => $hash,
);

// ユーザーの登録
try {
   $db = BaseModel::getInstance();
   $dbUser = new UserModel($db);
   $dbUser->insertUser($data);
} catch (Exception $e) {
   // var_dump($e);exit;
   header("Location: $urlError");
}

// ユーザー情報を取得してログイン
try {
   // ユーザー情報の取得
   $conUser = new UserController();
   $user = $conUser->checkPassEmail($post["email"], $post["password"]);

   if (empty($user)) {
      // --- ユーザーの情報が取得できなかったとき ---
      // エラーメッセージをSESSIONに保存
      $_SESSION["msg"]["error"] = "情報が一致しません";

      // POSTされてきたメールアドレスをSESSIONに保存
      $_SESSION["post"]["email"] = $post["email"];

      // ログインページへリダイレクト
      header('Location:' . $root . "auth/login");
   } else {
      // --- ユーザー情報が取得できたとき ---
      // ユーザー情報をSESSIONに保存
      $_SESSION["user"] = $user;
      $dbUser->updateUserLastLogin($user['id']);

      // sessionに保存されている値をクリア
      $arr = ['post', 'msg', 'token'];
      CommonUtil::unsession($arr);

      // itemsページへリダイレクト
      header("Location: $urlDivers");
      // header("Location: ../../divers/");
   }
} catch (Exception $e) {
   // var_dump($e);exit;
   header("Location: $urlError");
}
