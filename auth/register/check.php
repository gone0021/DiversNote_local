<?php
require_once './check_util.php';
?>

<!DOCTYPE html>
<html lang="jp">
<?php require_once($auth . "/head.php"); ?>

<body>
   <div id="app">
      <div id="container">
         <?php include_once($root . '/header.php'); ?>
         <?php include_once($root . '/navi.php'); ?>

         <div id="contents">
            <div class="inner">
               <section id="entry">
                  <h2 class="title">Register</h2>
                  <h3>登録内容の確認</h3>

                  <form action="./register.php" method="post">
                     <input type="hidden" name="token" value="<?= $token ?>">

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