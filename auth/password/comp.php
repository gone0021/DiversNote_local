<?php
// 共通ファイル
require_once('./comp_util.php');
?>

<!DOCTYPE html>
<html lang="jp">
<?php include_once($auth . "/head.php"); ?>

<body>
   <div id="app">
      <div id="container">
         <?php include_once($auth . "../navi.php"); ?>

         <div id="contents">
            <div class="inner">
               <section id="entry">
                  <h2 class="title">Reset Password</h2>
                  <h3>パスワードの再設定</h3>
                  <p>再設定完了が完了しました</p>
                  <p>
                     <a href="../login/">ログイン画面へ</a>
                  </p>
               </section>
            </div>
         </div>
         <!-- /#contents -->
         <?php include_once($root . "/footer.php"); ?>
      </div>
   </div>
   <!-- /#container -->
   <!--メニュー開閉ボタン-->
   <div id="menubar_hdr" class="close"></div>
   <?php require_once("../../unsession.php"); ?>

</body>

</html>