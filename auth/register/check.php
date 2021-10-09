<?php
$root = $_SERVER["DOCUMENT_ROOT"];
$root .= "/data/DiversNote_local";
require_once($root . "/app/util/SessionUtil.php");
require_once($root . "/app/util/CommonUtil.php");
require_once($root . "/app/util/ValidationUtil.php");
$auth = $root . '/auth';

// urlの指定
$rootUrl = $_SERVER['SERVER_NAME'];
$rootUrl .= "/data/DiversNote_local";
$url = 'http://' . $rootUrl;

// セッションスタート
SessionUtil::sessionStart();

// CSRF対策）
CommonUtil::csrf($_SESSION['token'], $_POST['token']);
// サニタイズ
$post = CommonUtil::sanitaize($_POST);

// POSTされてきた値をSESSIONに代入（入力画面で再表示）
$_SESSION['post'] = $post;

// バリデーションチェック
$validityCheck = array();
// ユーザー名
$validityCheck[] = validationUtil::isValidName(
   $post['name'],
   $_SESSION['msg']['name']
);
// ユーザー名の重複
$validityCheck[] = validationUtil::isUsedName(
   $post['name'],
   $_SESSION['msg']['name']
);
// メールアドレス
$validityCheck[] = validationUtil::isValidEmail(
   $post['email'],
   $_SESSION['msg']['email']
);
// メールアドレスの重複
$validityCheck[] = validationUtil::isUsedEmail(
   $post['email'],
   $_SESSION['msg']['email']
);
// 誕生日
$validityCheck[] = validationUtil::isBirthday(
   $post['birthday'],
   $_SESSION['msg']['birthday']
);
// パスワード
$validityCheck[] = validationUtil::isValidPass(
   $post['pass1'],
   $_SESSION['msg']['pass1']
);
// パスワード（確認用）
$validityCheck[] = validationUtil::isValidPass(
   $post['pass2'],
   $_SESSION['msg']['pass2']
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
      header('Location: ./');
      exit;
   }
}

// パスワードを伏せ字に
$pass = str_repeat('*', strlen($post["pass2"]));
// $hide = $post["pass2"];

// // パスワードの暗号化：パスワードチェックを行うため登録時に実行する
// $hash = password_hash($post['pass2'], PASSWORD_DEFAULT);

// エラーメッセージをクリア
unset($_SESSION['msg']);
$_SESSION['msg'] = null;

//  var_dump($hide);

?>

<!DOCTYPE html>
<html lang="jp">
<?php require_once($auth . "/head.php"); ?>

<body>
   <div id="app">
      <div id="container">
         <?php require_once($root . "/header.php"); ?>
         <?php require_once($auth . "/navi.php"); ?>

         <div id="contents">
            <div class="inner">
               <section id="entry">
                  <h2 class="title">Register</h2>
                  <h3>登録内容の確認</h3>

                  <form action="./register.php" method="post">
                     <!-- <input type="hidden" name="token" value="<?= $token ?>"> -->

                     <table class="ta1">
                        <tr>
                           <th>ユーザー名</th>
                           <td>
                              <?= $post['name'] ?>
                              <input type="hidden" name="name" value="<?= $post['name'] ?>">
                           </td>
                        </tr>

                        <tr>
                           <th>メールアドレス</th>
                           <td>
                              <?= $post['email'] ?>
                              <input type="hidden" name="email" value="<?= $post['email'] ?>">
                           </td>
                        </tr>

                        <tr>
                           <th>誕生日</th>
                           <td>
                              <?= $post['birthday'] ?>
                              <input type="hidden" name="birthday" value="<?= $post['birthday'] ?>">
                           </td>
                        </tr>

                        <tr>
                           <th>パスワード</th>
                           <td>
                              <?= $post["pass2"] ?>
                              <input type="hidden" name="password" value="<?= $post['pass2'] ?>">
                           </td>

                        </tr>
                     </table>

                     <div class="c">
                        <input type="submit" value="送信" class="btn ">
                        <!-- <button onclick="location.href='./';"> 戻る</button> -->
                        <input type="button" value="戻る" class="btn " onclick="location.href='./';">
                     </div>
                  </form>
                  <!-- <home-home></home-home> -->
               </section>

            </div>
            <!-- /#main -->

         </div>
         <!-- /#contents -->
         <!-- <div class="push"></div> -->
         <?php require_once($root . "/footer.php"); ?>

      </div>
      <!-- /#container -->
      <!--メニュー開閉ボタン-->
      <div id="menubar_hdr" class="close"></div>

   </div>
   <!-- /#app -->
</body>

</html>