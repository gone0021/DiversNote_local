<?php
require_once('../../app/config.php');

use app\util\CommonUtil;
use app\model\BaseModel;
use app\model\UserModel;
use app\controllers\UserController;

// CSRF対策）
CommonUtil::csrf($_SESSION['token'], $_POST['token']);

// サニタイズ
$post = CommonUtil::sanitaize($_POST);

// POSTされてきた値をSESSIONに代入（入力画面で再表示）
$_SESSION['post'] = $post;

// postされたtokenを削除
unset($post['token']);

try {
   // ユーザー情報の取得
   $db = BaseModel::getInstance();
   $dbUser = new UserModel($db);
   $conUser = new UserController();
   $user = $conUser->checkPassEmail($post["email"], $post["password"]);

   if (empty($user)) {
      // --- ユーザーの情報が取得できなかったとき ---
      // エラーメッセージをSESSIONに保存
      $_SESSION["msg"]["error"] = "情報が一致しません";

      // POSTされてきたメールアドレスをSESSIONに保存
      $_SESSION["post"]["email"] = $post["email"];

      // ログインページへリダイレクト
      header("Location: ./");
   } else {
      // --- ユーザー情報が取得できたとき ---
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
