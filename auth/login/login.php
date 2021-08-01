<?php
// クラスの読み込み
$root = $_SERVER["DOCUMENT_ROOT"];
$root .= "/data/DiversNote_local";
require_once($root . "/app/util/SessionUtil.php");
require_once($root . "/app/util/CommonUtil.php");
require_once($root . "/app/controllers/UserController.php");
require_once($root . "/app/model/UserModel.php");

// セッションスタート
SessionUtil::sessionStart();

// サニタイズ
$post = CommonUtil::sanitaize($_POST);
unset($post['token']);
try {
   // ユーザー情報の取得
   $conUser = new UserController();
   $dbUser = new UserModel();
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
