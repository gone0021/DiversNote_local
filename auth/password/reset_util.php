<?php
require_once('../../app/config.php');

use app\util\CommonUtil;
use app\util\ValidationUtil;
use app\controllers\UserController;

// echo '<pre>';
// var_dump($_POST);
// echo '</pre>';
// echo '<pre>';
// var_dump($_SESSION);
// echo '</pre>';
// die;


// CSRF対策）
CommonUtil::csrf($_SESSION['token'], $_POST['token']);

// サニタイズ
$post = CommonUtil::sanitaize($_POST);

// POSTされてきた値をSESSIONに代入（入力画面で再表示）
$_SESSION['post'] = $post;

// postされたtokenを削除
unset($post['token']);

// バリデーションチェック
$validityCheck = array();
// メールアドレス
$validityCheck[] = validationUtil::isValidEmail(
   $post['email'],
   $_SESSION['msg']['email']
);
// 誕生日
$validityCheck[] = validationUtil::isDate(
   $post['birthday'],
   $_SESSION['msg']['birthday']
);

// バリデーションで不備があった場合
foreach ($validityCheck as $k => $v) {
   // $vにnullが代入されている可能性があるので「===」で比較
   if ($v === false) {
      $_SESSION['msg']['error'] = '入力に不備があります。';
      header('Location: ./');
      exit;
   }
}

try {
   // ユーザーの検索とユーザー情報の取得
   $conUser = new UserController();

   // 入力フォームで入力されたemailとpasswordをgetUserの引数にpost
   $user = $conUser->checkBirthdayEmail($post["email"], $post["birthday"]);

   if (empty($user)) {
      // ユーザーの情報が取得できなかったとき
      // エラーメッセージをセッション変数に保存 → ログインページに表示
      $_SESSION["msg"]["error"] = "情報が一致しません";

      // ログインページへリダイレクト
      header("Location: ./");

   } else {
      // メールアドレスの情報が取得できたとき
      // sessionに保存されている値をクリア
      $arr = ['post', 'msg'];
      CommonUtil::unsession($arr);

      // POSTされてきたメールをセッションに保存→updateのwhereに使用
      $_SESSION["email"] = $post["email"];

      // sessionにトークンを保存
      $_SESSION['token'] = $token;

      // 作業一覧ページを表示
   }
} catch (Exception $e) {
   // var_dump($e);exit;
   header("Location: $urlError");
}
