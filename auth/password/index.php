<?php
require_once ('./index_util.php');

// var_dump($_SESSION);
?>

<!DOCTYPE html>
<html lang="ja">
<?php include_once($auth . '/head.php'); ?>

<body>
   <div id="app">
      <div id="container">
         <?php include_once($root . '/navi.php'); ?>

         <div id="contents">
            <div class="inner">
               <section id="entry">
                  <h2 class="title">Forget Password</h2>
                  <h3>パスワードを忘れた</h3>

                  <!-- エラーメッセージ -->
                  <?php if (!empty($_SESSION["msg"]["error"])) : ?>
                     <p class="error">
                        <?= $_SESSION["msg"]["error"] ?>
                     </p>
                  <?php endif ?>

                  <!-- 送信フォーム -->
                  <form action="./reset.php" method="post" class="">
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
         <?php include_once($root . '/footer.php'); ?>

      </div>
      <!-- /#container -->
      <!--メニュー開閉ボタン-->
      <div id="menubar_hdr" class="close"></div>
      <?php require_once $unsession; ?>
   </div>
   <!-- /#app -->
</body>

</html>