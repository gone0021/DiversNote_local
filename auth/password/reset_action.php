<?php
$root = $_SERVER["DOCUMENT_ROOT"];
$root .= "/data/DiversNote_local";
require_once($root . "/app/util/SessionUtil.php");
require_once($root . "/app/util/CommonUtil.php");
require_once($root . "/app/util/ValidationUtil.php");
require_once($root . "/app/controllers/UserController.php");
require_once($root . "/app/model/UserModel.php");

// セッションスタート
SessionUtil::sessionStart();


// echo '<pre>';
// var_dump($_SESSION);
// echo '</pre>';
// die('die');

// CSRF対策）
CommonUtil::csrf($_SESSION['token'], $_POST['token']);

// サニタイズ
$post = CommonUtil::sanitaize($_POST);

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
// var_dump($data);
// echo '</pre>';
// die;

try {
   $db = new UserModel();
   $db->updatetUserPassword($data);

   // SESSIONに保存したデータを削除
   unset($_SESSION);
   header('Location: ../login');
} catch (Exception $e) {
   var_dump($e);
   exit;
   header('Location: ../../error.php');
}

// ページタイトル
$title = '再設定完了';
?>

<!DOCTYPE html>
<html lang="jp">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
   <title> <?= $title ?> </title>
   <link rel="stylesheet" href="../../css/normalize.css">
   <link rel="stylesheet" href="../../css/bootstrap.css">
   <link rel="stylesheet" href="../../css/main.css">
</head>

<body>
   <div class="container">
      <!-- body-header -->
      <?php require_once($root . "./account/header.php"); ?>

      <main>
         <table class="table">
            <tr>
               <th>再設定完了が完了しました</th>
            </tr>

            <tr>
               <td>
                  <a href="../../">ログイン画面へ</a>
               </td>
            </tr>
         </table>
      </main>

      <footer>
      </footer>
   </div>

   <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>

</html>