<?php
require_once 'common_home.php';
?>

<!DOCTYPE html>
<html lang="ja">
<?php include_once($root . "/head.php"); ?>

<body>
   <div id="app">
      <div id="container">

         <?php include_once($root . "/header.php"); ?>
         <?php include_once($root . "/navi.php"); ?>

         <div id="contents">

            <div class="inner">
               <?php include_once($root . "/about.php"); ?>
               <?php include_once($root . "/news.php"); ?>
               <?php include_once($root . "/entry.php"); ?>
            </div>
            <!--/.inner-->

         </div>
         <!--/#contents-->
         <?php include_once($root . "/footer.php"); ?>
         
      </div>
      <!--/#container-->
      
      <!-- <p class="nav-fix-pos-pagetop"><a href="#">↑</a></p> -->
      <p id="toTop" class="nav-fix-pos-pagetop"><a href="javascript:void(0)">↑</a></p>
      
      <!-- メニュー開閉ボタン -->
      <div id="menubar_hdr" class="close"></div>
      <?php require_once("./unsession.php"); ?>

   </div>
   <!-- /#app -->
</body>

</html>