<?php
// クラスの読み込み
$root = $_SERVER['DOCUMENT_ROOT'];
$root .= "/data/DiversNote_local";
require_once($root . "/app/util/SessionUtil.php");
$auth = $root . '/auth';

// urlの指定
$rootUrl = $_SERVER['SERVER_NAME'];
$rootUrl .= "/data/DiversNote_local";
$url = 'http://' . $rootUrl;

// セッションスタート
SessionUtil::sessionStart();

// authの他ページのセッションをクリア
unset($_SESSION["msg"]['name']);
unset($_SESSION["msg"]['email']);
unset($_SESSION["msg"]['birthday']);
unset($_SESSION["msg"]['pass1']);
unset($_SESSION["msg"]['pass2']);
unset($_SESSION["msg"]['login']);

// トークンの生成
$token = bin2hex(openssl_random_pseudo_bytes(108));
$_SESSION['token'] = $token;

// SESSIONに保存したPOSTデータ（パスワードは保存しない）
// メールアドレス
$email = "";
if (!empty($_SESSION['post']['email'])) {
   $email = $_SESSION['post']['email'];
}
// 誕生日
$birthday = date("2000-01-01");
if (!empty($_SESSION['post']['birthday'])) {
   $birthday = $_SESSION['post']['birthday'];
}

// echo $url;
?>

<!DOCTYPE html>
<html lang="ja">
<?php require_once($auth . "/head.php"); ?>

<body>
   <div id="app">
      <div id="container">
         <?php require_once($root . "/header.php"); ?>
         <?php require_once($auth . "/navi.php"); ?>

         <div id="contents">
            <div class="inner">
               <section id="entry">
                  <h2 class="title">Forget Password</h2>
                  <h3>パスワードを忘れた</h3>

                  <!-- エラーメッセージ -->
                  <?php if (!empty($_SESSION["msg"]["reset"])) : ?>
                     <p class="error">
                        <?= $_SESSION["msg"]["reset"] ?>
                     </p>
                  <?php endif ?>

                  <!-- 送信フォーム -->
                  <form action="./index_action.php" method="post" class="">
                     <input type="hidden" class="ws" name="token" value="<?= $token ?>">

                     <!-- メールアドレス -->
                     <div class="form-group col-6 mx-auto">
                        <!-- バリデーション -->
                        <?php if (isset($_SESSION['msg']['email'])) : ?>
                           <p class="error"><?= $_SESSION['msg']['email'] ?></p>
                        <?php endif ?>
                        <!-- 入力フォーム -->
                        <label for="email">メールアドレス</label>
                        <input type="search" name="email" value="<?= $email ?>" id="email" class="form-control" placeholder="メールアドレス" autocomplete="off" required>
                     </div>

                     <!-- 誕生日 -->
                     <div class="form-group col-6 mx-auto">
                        <!-- バリデーション -->
                        <?php if (isset($_SESSION['msg']['birthday'])) : ?>
                           <p class="error"><?= $_SESSION['msg']['birthday'] ?></p>
                        <?php endif ?>
                        <!-- 入力フォーム -->
                        <label for="birthday">誕生日</label>
                        <input type="date" name="birthday" value="<?= $birthday ?>" id="birthday" class="form-control" autocomplete="off" required>
                     </div>

                     <div class="c mb-5">
                        <input type="submit" value="送信" class="btn mr-5" @click="onRegCheck()">
                        <input type="reset" value="リセット" class="btn">
                     </div>
                  </form>

                  <div class="c">
                     <a class="btn login mr-3" href="../register/">登録はこちら</a>
                  </div>
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