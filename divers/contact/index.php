<?php
require_once ('./index_util.php');
?>

<!DOCTYPE html>
<html lang="ja">
<?php include_once($divers . "/head.php"); ?>

<body>
   <div id="app">
      <div id="container">
         <?php include_once($divers . "/navi.php"); ?>

         <div id="contents">

            <div class="inner">
               <section id="contact">
                  <h2>CONTACT<span>お問い合わせ</span></h2>
                  <h3>お問い合わせ内容をご入力ください</h3>
                  <form action="">
                     <input type="hidden" name="token" id="" value="<?= $token ?>">
                     <input type="hidden" name="user_id" id="" value="<?= $user['id'] ?>">
                     <table class="ta1">
                        <tr>
                           <th>お名前</th>
                           <td><input type="text" name="user_name" size="30" class="ws" value="<?= $user['user_name'] ?>" disabled></td>
                        </tr>
                        <tr>
                           <th>メールアドレス</th>
                           <td><input type="text" name="email" size="30" class="ws" value="<?= $user['email'] ?>" disabled></td>
                        </tr>
                        <tr>
                           <th>お問い合わせ内容</th>
                           <td><textarea name="message" cols="30" rows="10" class="wl" disabled></textarea></td>
                        </tr>
                     </table>

                     <p class="c">
                        <input type="submit" value="内容を確認する" class="btn" disabled>
                     </p>
                  </form>

                  <p class="c">※ 現在ご利用頂けません</p>

               </section>
            </div>
            <!-- /#inner -->

         </div>
         <!-- /#contents -->
         <!-- <div class="push"></div> -->

      </div>
      <!-- /#container -->
      <!--メニュー開閉ボタン-->
      <div id="menubar_hdr" class="close"></div>

   </div>
   <!-- /#app -->
   <?php require_once $unsession; ?>
</body>

</html>