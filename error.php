<?php
require_once('./common.php');

session_destroy();
// header('refresh: 5; ./');
?>

<!DOCTYPE html>
<html lang="ja">
<?php require_once('./head.php'); ?>

<body>
   <div id="container">
      <header>
         <h1 class="c h1"></h1>
      </header>
      <div id="contents">
         <div class="inner c my-5">
            <p>申し訳ございませんがエラーが発生しました。</p>
            <p>５秒後にログアウトしてトップページに戻ります。</p>
            <p>トップページに戻らない場合は<a href="./">こちら</a>をクリックしてください。</p>
         </div>
         <!--/.inner-->

      </div>
      <!--/#contents-->

   </div>
   <!--/#container-->
   <?php require_once("./unsession.php"); ?>

</body>

</html>