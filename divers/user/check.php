<?php
require_once ('./check_util.php');
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

      </div>
      <!-- /#container -->
      <!--メニュー開閉ボタン-->
      <div id="menubar_hdr" class="close"></div>

   </div>

   </div>
   <!-- /#app -->
</body>

</html>