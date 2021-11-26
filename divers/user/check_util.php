<?php
require_once '../common_divers.php';

// クラスの読み込み
require_once($root . "/app/util/ValidationUtil.php");
require_once($root . "/app/controllers/UserController.php");
require_once($root . "/app/model/UserModel.php");

// echo '<pre>';
// var_export($_POST);
// echo '</pre>';

// CSRF対策）
CommonUtil::csrf($_SESSION['token'], $_POST['token']);

// サニタイズ
$post = CommonUtil::sanitaize($_POST);

// POSTされてきた値をSESSIONに代入（入力画面で再表示）
$_SESSION['post'] = $post;

// sessionに保存されているユーザーの情報を変数に保存
$user = $_SESSION['user'];

// インスタンス
$conUser = new UserController();
$dbUser = new UserModel();

// バリデーションチェック
$validityCheck = array();

// パスワードの整合性をチェック
$validityCheck[] = $conUser->isCurrentPass($user['id'], $post['pass'], $_SESSION['msg']['check']);

// ユーザー名
if ($post['user_name'] !== $user['user_name']) {
   $validityCheck[] = validationUtil::isValidName(
      $post['user_name'],
      $_SESSION['msg']['user_name']
   );
}
// ユーザー名の重複
if ($user['user_name'] != $post['user_name']) {
   $validityCheck[] = $dbUser->isUsedName(
      $post['user_name'],
      $_SESSION['msg']['user_name']
   );
}

// メールアドレス
if ($post['email'] !== $user['email']) {
   $validityCheck[] = validationUtil::isValidEmail(
      $post['email'],
      $_SESSION['msg']['email']
   );
}
// メールアドレスの重複
if ($user['email'] != $post['email']) {
   $validityCheck[] = $dbUser->isUsedEmail(
      $post['email'],
      $_SESSION['msg']['email']
   );
}

// 誕生日
if ($post['birthday'] !== $user['birthday']) {
   $validityCheck[] = validationUtil::isBirthday(
      $post['birthday'],
      $_SESSION['msg']['birthday']
   );
}

// 現在のパスワード
$validityCheck[] = validationUtil::isValidPass(
   $post['pass'],
   $_SESSION['msg']['pass']
);
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
