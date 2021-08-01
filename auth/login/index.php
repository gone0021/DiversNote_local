<?php
// クラスの読み込み
$root = $_SERVER['DOCUMENT_ROOT'];
$root .= "/data/DiversNote";
require_once($root . "/app/util/SessionUtil.php");
$auth = $root . '/auth';

// urlの指定
$rootUrl = $_SERVER['SERVER_NAME'];
$rootUrl .= "/data/DiversNote";
$url = 'http://' . $rootUrl;

// セッションスタート
SessionUtil::sessionStart();

// トークンの生成
$token = bin2hex(openssl_random_pseudo_bytes(108));
$_SESSION['token'] = $token;

// SESSIONに保存したPOSTデータ（パスワードは保存しない）
// メールアドレス
$email = "";
if (!empty($_SESSION['post']['email'])) {
   $email = $_SESSION['post']['email'];
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
                  <h2 class="title">Login</h2>
                  <h3>ログイン</h3>

                  <!-- エラーメッセージ -->
                  <?php if (!empty($_SESSION["msg"]["error"])) : ?>
                     <p class="error">
                        <?= $_SESSION["msg"]["error"] ?>
                     </p>
                  <?php endif ?>

                  <!-- 送信フォーム -->
                  <form action="./login.php" method="post" class="">
                     <input type="hidden" class="ws" name="token" value="<?= $token ?>">

                     <div class="form-group col-6 mx-auto mb-3">
                        <input type="email" name="email" id="email" class="form-control" value="<?= $email ?>" placeholder="メールアドレス" autocomplete="off">
                     </div>

                     <div class="form-group col-6 mx-auto mb-4">
                        <input type="password" name="password" id="password" class="form-control" placeholder="パスワード" autocomplete="off">
                     </div>

                     <div class="c mb-5">
                        <input type="submit" value="ログイン" class="btn mr-5" @click="onRegCheck()">
                        <input type="reset" value="リセット" class="btn">
                     </div>
                  </form>

                  <div class="c mb-4">※ パスワードを忘れた方は<span class="url">こちら</span>から再設定してください。</div>
                  <div class="c">
                     <a class="btn login" href="../register/">登録はこちら</a>
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