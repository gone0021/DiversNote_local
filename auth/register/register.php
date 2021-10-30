<?php
// 共通ファイル
require_once("../common.php");

// クラスの読み込み
require_once($root . "/app/util/CommonUtil.php");
require_once($root . "/app/util/ValidationUtil.php");
require_once($root . "/app/controllers/UserController.php");
require_once($root . "/app/model/UserModel.php");

// サニタイズ
$post = CommonUtil::sanitaize($_POST);

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

// インスタンス
$dbUser = new UserModel();

// ユーザーの登録
try {
   $dbUser->insertUser($data);
   echo 'ok';
} catch (Exception $e) {
   var_dump($e);
   exit;
   header('Location: ../../error.php');
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
      header("Location: ../login");
   } else {
      // --- ユーザー情報が取得できたとき ---
      // SESSIONのクリア：destroyするとsession自体がなくなるためNG
      // SESSIONに保存されているエラーメッセージをクリア
      $_SESSION["msg"] = "";
      unset($_SESSION["msg"]);

      // SESSIONに保存されているPOSTされてきたデータをクリア
      $_SESSION["post"] = "";
      unset($_SESSION["post"]);

      $_SESSION["token"] = "";
      unset($_SESSION["token"]);

      
      // ユーザー情報をSESSIONに保存
      $_SESSION["user"] = $user;
      $dbUser->updateUserLastLogin($user['id']);

      // itemsページへリダイレクト
      header("Location: ../../divers/");
   }
} catch (Exception $e) {
   header("Location: ../../error.php");
}
