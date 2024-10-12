<?php
require_once('../../app/config.php');

use app\util\CommonUtil;
use app\util\ValidationUtil;

// echo '<pre>';
// var_export($_POST);
// echo '</pre>';

// CSRF対策）
CommonUtil::csrf($_SESSION['token'], $_POST['token']);

// サニタイズ
$post = CommonUtil::sanitaize($_POST);

// POSTされてきた値をSESSIONに代入（入力画面で再表示）
$_SESSION['post'] = $post;

// ログインのチェック
$user = CommonUtil::isUser($_SESSION['user'], $urlError);
$_SESSION['user'] = $user;

// バリデーションチェック
$validityCheck = array();

// ユーザー名
// 重複
if ($post['user_name'] !== $user['user_name']) {
   $validityCheck[] = validationUtil::isUsedName(
      $post['user_name'],
      $_SESSION['msg']['user_name']
   );
}
// 入力
if (empty($_SESSION['msg']['user_name'])) {
   $validityCheck[] = validationUtil::isValidName(
      $post['user_name'],
      $_SESSION['msg']['user_name']
   );
}

// メールアドレス
// 重複
if ($post['email'] !== $user['email']) {
   $validityCheck[] = validationUtil::isUsedEmail(
      $post['email'],
      $_SESSION['msg']['email']
   );
}
// 入力
if (empty($_SESSION['msg']['email'])) {
   $validityCheck[] = validationUtil::isValidEmail(
      $post['email'],
      $_SESSION['msg']['email']
   );
}
// 誕生日
if ($post['birthday'] !== $user['birthday']) {
   $validityCheck[] = validationUtil::isDate(
      $post['birthday'],
      $_SESSION['msg']['birthday']
   );
}

// 現在のパスワード
// パスワードチェック
$validityCheck[] = validationUtil::isCurrentPass($user['id'], $post['pass'], $_SESSION['msg']['pass']);
// 入力
if (empty($_SESSION['msg']['pass'])) {

   $validityCheck[] = validationUtil::isValidPass(
      $post['pass'],
      $_SESSION['msg']['pass']
   );
}

// postするパスワード：パスワードを変える場合があるため変数に保存する
$post_pass = $post['pass'];

// 新しいパスワード
// ダブルチェック
if (!empty($post['pass1']) || !empty($post['pass2'])) {
   $validityCheck[] = validationUtil::isDoubleCheck(
      $post['pass1'],
      $post['pass2'],
      $_SESSION['msg']['pass2']
   );
   $post_pass = $post['pass2'];
}

// バリデーションで不備があった場合
foreach ($validityCheck as $k => $v) {
   // $vにnullが代入されている可能性があるので「===」で比較
   if ($v === false) {
      header('Location: ./');
      exit;
   }
}

// パスワードを伏せ字にする：使うか検討中
$pass = str_repeat('*', strlen($post_pass));

// パスワードの暗号化
$hash = password_hash($post_pass, PASSWORD_DEFAULT);

// エラーメッセージをクリア
$_SESSION['msg'] = '';
unset($_SESSION['msg']);
