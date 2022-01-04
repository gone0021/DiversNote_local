<?php
require_once('../../app/config.php');

use app\util\CommonUtil;
use app\util\ValidationUtil;
use app\model\BaseModel;
use app\model\UserModel;

// echo '<pre>';
// var_dump($_POST);
// echo '</pre>';
// die('die');

// CSRF対策）
CommonUtil::csrf($_SESSION['token'], $_POST['token']);

// サニタイズ
$post = CommonUtil::sanitaize($_POST);

// postされたtokenを削除
unset($post['token']);

// バリデーションチェック
$validityCheck = array();
// パスワードのバリデーション
$validityCheck[] = validationUtil::isValidPass(
   $post['pass1'],
   $_SESSION['msg']['pass1']
);
// ダブルチェック
$validityCheck[] = validationUtil::isDoubleCheck(
   $post['pass1'],
   $post['pass2'],
   $_SESSION['msg']['pass2']
);

// バリデーションで不備があった場合
foreach ($validityCheck as $k => $v) {
   // $vにnullが代入されている可能性があるので「===」で比較
   if ($v === false) {
      $_SESSION["msg"]["reset_pass"] = "入力が一致しません";

      // 再設定ページへリダイレクト
      header('Location: ./reset.php');
      exit;
   }
}

// パスワードの暗号化
$hash = password_hash($post['pass2'], PASSWORD_DEFAULT);

// セSESSIONに保存したエラーメッセージをクリアする
$_SESSION['msg']['reset_pass'] = '';
// データベースに登録する内容を連想配列にする
$data = array(
   'email' => $_SESSION['email'],
   'password' => $hash,
);

// echo '<pre>';
// var_dump($_SESSION);
// echo '</pre>';
// die;

try {
   $db = BaseModel::getInstance();
   $dbUser = new UserModel($db);
   $dbUser->updatetUserPassword($data);

   // SESSIONに保存したデータを削除
   unset($_SESSION);
   
   header('Location: ../login');
} catch (Exception $e) {
   // var_dump($e);exit;
   header("Location: $urlError");
}
