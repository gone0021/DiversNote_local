<?php
// クラスの読み込み
$root = $_SERVER['DOCUMENT_ROOT'];
$root .= "/data/DiversNote_local";
require_once($root . "/app/util/SessionUtil.php");

// urlの指定
$rootUrl = $_SERVER['SERVER_NAME'];
$rootUrl .= "/data/DiversNote_local";
$url = 'http://' . $rootUrl;

// --- contact用 ---
// セッションスタート
SessionUtil::sessionStart();

// トークンの生成
$token = bin2hex(openssl_random_pseudo_bytes(108));
$_SESSION['token'] = $token;

// echo $url;
?>

<!DOCTYPE html>
<html lang="ja">
<?php require_once($root . "/head.php"); ?>

<body>
   <div id="app">
      <div id="container">

         <?php require_once($root . "/header.php"); ?>
         <?php require_once($root . "/navi.php"); ?>

         <div id="contents">

            <div class="inner">
               <?php require_once($root . "/about.php"); ?>
               <?php require_once($root . "/news.php"); ?>
               <?php require_once($root . "/entry.php"); ?>
            </div>
            <!--/.inner-->

         </div>
         <!--/#contents-->
         <?php require_once($root . "/footer.php"); ?>

      </div>
      <!--/#container-->

      <!-- <p class="nav-fix-pos-pagetop"><a href="#">↑</a></p> -->
      <p id="toTop" class="nav-fix-pos-pagetop"><a href="javascript:void(0)">↑</a></p>

      <!-- メニュー開閉ボタン -->
      <div id="menubar_hdr" class="close"></div>

   </div>
   <!-- /#app -->
</body>

</html>