<?php
$root = $_SERVER["DOCUMENT_ROOT"];
$root .= "/data/DiversNote_local";
require_once($root . "/app/util/SessionUtil.php");
require_once($root . "/app/util/CommonUtil.php");
require_once($root . "/app/util/ValidationUtil.php");
require_once($root . "/app/controllers/UserController.php");
require_once($root . "/app/model/UserModel.php");
$divers = $root . '/divers';

// urlの指定
$rootUrl = $_SERVER['SERVER_NAME'];
$rootUrl .= "/data/DiversNote_local";
$url = 'http://' . $rootUrl;

// セッションスタート
SessionUtil::sessionStart();

// フォームで送信されてきたトークンが正しいかどうか確認（CSRF対策）
if (!isset($_SESSION['token']) || $_SESSION['token'] !== $_POST['token']) {
   $_SESSION['msg']['err'] = "不正な処理が行われました。";
   header('Location: ./');
   exit;
}
// サニタイズ
$post = CommonUtil::sanitaize($_POST);

// POSTされてきた値をSESSIONに代入（入力画面で再表示）
$_SESSION['post'] = $post;
// セッションからユーザーidを変数に代入
$userId = $_SESSION['user']['id'];

// インスタンス
$conUser = new UserController();
$dbUser = new UserModel();

// idからユーザーを取得
$user = $dbUser->getUserById($userId);

unset($_SESSION['msg']);

// echo '<pre>';
// var_export($post);
// echo '</pre>';


// バリデーションチェック
$validityCheck = array();

// パスワードのチェック
$validityCheck[] = $conUser->isCurrentPass($userId, $post['pass'], $_SESSION['msg']['check']);

// ユーザー名
if ($post['user_name'] !== $user['user_name']) {
   $validityCheck[] = validationUtil::isValidName(
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
unset($_SESSION['msg']);
$_SESSION['msg'] = null;

//  var_dump($hide);

?>

<!DOCTYPE html>
<html lang="jp">
<?php require_once($divers . "/head.php"); ?>

<body>
   <div id="app">
      <div id="container">
         <?php require_once($divers . "/navi.php"); ?>

         <div id="contents">
            <div class="inner">
               <section id="entry">
                  <h2 class="title">Check Update</h2>
                  <h3>更新内容の確認</h3>

                  <form action="./update.php" method="post">
                     <input type="hidden" name="token" value="<?= $token ?>">
                     <input type="hidden" name="id" value="<?= $userId ?>">

                     <table class="ta1">
                        <tr>
                           <th>ユーザー名</th>
                           <td>
                              <?= $post['user_name'] ?>
                              <input type="hidden" name="user_name" value="<?= $post['user_name'] ?>">
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
                              <?= $post_pass ?>
                              <input type="hidden" name="password" value="<?= $hash ?>">
                           </td>

                        </tr>
                     </table>

                     <div class="c">
                        <input type="submit" value="送信" class="btn mr-3">
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
         <?php require_once($root . "../footer.php"); ?>

      </div>
      <!-- /#container -->
      <!--メニュー開閉ボタン-->
      <div id="menubar_hdr" class="close"></div>

   </div>

   </div>
   <!-- /#app -->
</body>

</html>