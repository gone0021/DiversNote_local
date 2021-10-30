<?php
// 共通ファイル
require_once("../common.php");

// クラスの読み込み
require_once($root . "/app/util/CommonUtil.php");
require_once($root . "/app/controllers/UserController.php");
require_once($root . "/app/model/UserModel.php");

// CSRF対策）
CommonUtil::csrf($_SESSION['token'], $_POST['token']);

// サニタイズ
$post = CommonUtil::sanitaize($_POST);

// POSTされてきた値をSESSIONに代入（入力画面で再表示）
$_SESSION['post'] = $post;

unset($post['token']);

try {
   // ユーザー情報の取得
   $conUser = new UserController();
   $dbUser = new UserModel();
   $user = $conUser->checkPassEmail($post["email"], $post["password"]);

   if (empty($user)) {
      // --- ユーザーの情報が取得できなかったとき ---
      // エラーメッセージをSESSIONに保存
      $_SESSION["msg"]["login"] = "情報が一致しません";

      // POSTされてきたメールアドレスをSESSIONに保存
      $_SESSION["post"]["email"] = $post["email"];

      // ログインページへリダイレクト
      header("Location: ./");
   } else {
      // --- ユーザー情報が取得できたとき ---
      // ユーザー情報をSESSIONに保存
      // session_destroy();

      $_SESSION["user"] = $user;
      $dbUser->updateUserLastLogin($user['id']);

      // SESSIONに保存されているエラーメッセージをクリア
      $_SESSION["msg"] = "";
      unset($_SESSION["msg"]);

      // SESSIONに保存されているPOSTされてきたデータをクリア
      $_SESSION["post"] = "";
      unset($_SESSION["post"]);

      $_SESSION["token"] = "";
      unset($_SESSION["token"]);

      // var_dump($_SESSION);die;

      // itemsページへリダイレクト
      header("Location: ../../divers/");
   }
} catch (Exception $e) {
   // echo '<pre>';
   // var_dump($e);exit;
   // echo '</pre>';
   header("Location: ../../error.php");
}
