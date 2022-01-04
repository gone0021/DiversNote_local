<?php
require_once ('./index_util.php');
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
                  <h2 class="title">Register</h2>
                  <h3>新規登録</h3>
                  <!-- エラーメッセージ -->
                  <?php if (!empty($_SESSION["msg"]["error"])) : ?>
                     <p class="error">
                        <?= $_SESSION["msg"]["error"] ?>
                     </p>
                  <?php endif ?>

                  <!-- 送信フォーム -->
                  <form action="./check.php" method="post">
                     <!-- トークンの送信 -->
                     <input type="hidden" name="token" value="<?= $token ?>">

                     <!-- ユーザー名 -->
                     <div class="form-group col-6 mx-auto mt-3">
                        <!-- バリデーション -->
                        <?php if (isset($_SESSION['msg']['name'])) : ?>
                           <p class="error"><?= $_SESSION['msg']['name'] ?></p>
                        <?php endif ?>
                        <!-- 入力フォーム -->
                        <label for="name">ユーザー名</label>
                        <input type="search" name="name" value="<?= $name ?>" id="name" class="form-control" placeholder="ユーザー名" autocomplete="off" required>
                     </div>

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
                        <label for="birthday">誕生日（パスワードの再設定に使用）</label>
                        <input type="date" name="birthday" value="<?= $birthday ?>" id="birthday" class="form-control" autocomplete="off" required>
                     </div>

                     <!-- ※パスワード -->
                     <div class="form-group col-6 mx-auto">
                        <!-- バリデーション -->
                        <?php if (isset($_SESSION['msg']['pass1'])) : ?>
                           <p class="error"><?= $_SESSION['msg']['pass1'] ?></p>
                        <?php endif ?>
                        <!-- 入力フォーム -->
                        <label for="pass1">パスワード（半角英数字で8文字以上）</label>
                        <input type="password" name="pass1" id="pass1" class="form-control" placeholder="半角英数字で8文字以上" autocomplete="off" required>
                     </div>

                     <!-- ※確認用パスワード（送信対象） -->
                     <div class="form-group col-6 mx-auto">
                        <!-- バリデーション -->
                        <?php if (isset($_SESSION['msg']['pass2'])) : ?>
                           <p class="error"><?= $_SESSION['msg']['pass2'] ?></p>
                        <?php endif ?>
                        <!-- 入力フォーム -->
                        <label for="pass2">パスワード（確認用）</label>
                        <input type="password" name="pass2" id="pass2" class="form-control" placeholder="確認用" autocomplete="off" required>
                     </div>

                     <!-- ※ボタン -->
                     <div class="c mb-5">
                        <input type="submit" value="確認" class="btn mr-5" @click="onRegCheck()">
                        <input type="reset" value="リセット" class="btn">
                     </div>

                  </form>

                  <div class="c">
                     <a class="btn login" href="../login/">ログインはこちら</a>
                  </div>
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