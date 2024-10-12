<?php
// クラスの読み込み
$root = $_SERVER['DOCUMENT_ROOT'];
$root .= "/php/DiversNote_local";
require_once($root . "/app/util/SessionUtil.php");

// urlの指定
$rootUrl = $_SERVER['SERVER_NAME'];
$rootUrl .= "/php/DiversNote_local";
$url = 'http://' . $rootUrl;

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

         <?php require_once($root . "/navi.php"); ?>

         <div id="contents">

            <div class="inner">
               <section id="contact">
                  <h2>PLAN<span>料金プラン</span></h2>
                  <h3>料金プラン一覧</h3>
                  <input type="hidden" name="token" id="" value="<?= $token ?>">

                     <table class="ta1">
                        <tr>
                           <th>無料</th>
                           <th>ライト</th>
                           <th>スタンダード</th>
                           <th>プレミアム</th>
                        </tr>
                        <tr>
                           <th>お名前</th>
                           <td><input type="text" name="name" size="30" class="ws" disabled></td>
                        </tr>
                        <tr>
                           <th>メールアドレス</th>
                           <td><input type="text" name="email" size="30" class="ws" disabled></td>
                        </tr>
                        <tr>
                           <th>お問い合わせ内容</th>
                           <td><textarea name="message" cols="30" rows="10" class="wl" disabled></textarea></td>
                        </tr>
                     </table>

               </section>
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