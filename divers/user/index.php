<?php
// クラスの読み込み
$root = $_SERVER['DOCUMENT_ROOT'];
$root .= "/data/DiversNote";
require_once($root . "/app/Util/SessionUtil.php");
require_once($root . "/app/util/CommonUtil.php");
require_once($root . "/app/controllers/UserController.php");
require_once($root . "/app/model/UserModel.php");
$divers = $root . '/divers';

// urlの指定
$rootUrl = $_SERVER['SERVER_NAME'];
$rootUrl .= "/data/DiversNote";
$url = 'http://' . $rootUrl;
// echo $url;

// セッションスタート
SessionUtil::sessionStart();

// セッションからユーザーidを変数に代入
$userId = $_SESSION['user']['id'];

// UserModelのインスタンス
$conUser = new UserController();
$dbUser = new UserModel();

// idからユーザーを取得
$user = $dbUser->getUserById($userId);

// トークンを変数に代入
// $token = $_SESSION['token'];
$token = bin2hex(openssl_random_pseudo_bytes(108));
$_SESSION['token'] = $token;

// var_dump($_SESSION);

// ※ SESSIONに保存したPOSTデータ（パスワードは保存しない）
// ユーザー名
$user_name = $user['user_name'];
if (!empty($_SESSION['post']['user_name'])) {
   $name =  $_SESSION['post']['user_name'];
}
// メールアドレス
$email = $user['email'];
if (!empty($_SESSION['post']['email'])) {
   $email = $_SESSION['post']['email'];
}
// 誕生日
$birthday = $user['birthday'];
if (!empty($_SESSION['post']['birthday'])) {
   $birthday = $_SESSION['post']['birthday'];
}

// var_dump($root);
// var_dump($_SESSION['post']);


?>

<!DOCTYPE html>
<html lang="ja">
<?php require_once($divers . "/head.php"); ?>

<body>
   <div id="app">
      <div id="container">
         <?php require_once($divers . "/navi.php"); ?>

         <div id="contents">
            <div class="inner">
               <section id="entry">
                  <h2 class="title">User Data</h2>
                  <h3>会員情報</h3>

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
                        <?php if (isset($_SESSION['msg']['user_name'])) : ?>
                           <p class="error"><?= $_SESSION['msg']['user_name'] ?></p>
                        <?php endif ?>
                        <!-- 入力フォーム -->
                        <label for="user_name">ユーザー名</label>
                        <input type="text" name="user_name" value="<?= $user_name ?>" id="user_name" class="form-control" placeholder="ユーザー名" autocomplete="off" required>
                     </div>

                     <!-- メールアドレス -->
                     <div class="form-group col-6 mx-auto">
                        <!-- バリデーション -->
                        <?php if (isset($_SESSION['msg']['email'])) : ?>
                           <p class="error"><?= $_SESSION['msg']['email'] ?></p>
                        <?php endif ?>
                        <!-- 入力フォーム -->
                        <label for="email">メールアドレス</label>
                        <input type="text" name="email" value="<?= $email ?>" id="email" class="form-control" placeholder="メールアドレス" autocomplete="off" required>
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

                     <!-- ※パスワード -->
                     <div class="form-group col-6 mx-auto mb-4">
                        <!-- バリデーション -->
                        <?php if (isset($_SESSION['msg']['check'])) : ?>
                           <p class="error"><?= $_SESSION['msg']['check'] ?></p>
                        <?php endif ?>
                        <!-- 入力フォーム -->
                        <label for="pass">現在のパスワード</label>
                        <input type="password" name="pass" id="pass" class="form-control" placeholder="半角英数字で8文字以上" autocomplete="off" required>
                     </div>


                     <div class="acdTitle mb-3">
                        <span class="">
                           パスワードを変更する場合
                        </span>
                     </div>
                     <div class="acdItem">
                        <!-- ※新しいパスワード -->
                        <div class="form-group col-6 mx-auto">
                           <!-- バリデーション -->
                           <?php if (isset($_SESSION['msg']['pass1'])) : ?>
                              <p class="error"><?= $_SESSION['msg']['pass1'] ?></p>
                           <?php endif ?>
                           <!-- 入力フォーム -->
                           <label for="pass1">新しいパスワード</label>
                           <input type="password" name="pass1" id="pass1" class="form-control new_pass" placeholder="半角英数字で8文字以上" autocomplete="off" disabled>
                        </div>

                        <!-- ※確認用パスワード（送信対象） -->
                        <div class="form-group col-6 mx-auto">
                           <!-- バリデーション -->
                           <?php if (isset($_SESSION['msg']['pass2'])) : ?>
                              <p class="error"><?= $_SESSION['msg']['pass2'] ?></p>
                           <?php endif ?>
                           <!-- 入力フォーム -->
                           <label for="pass2">パスワード（確認用）</label>
                           <input type="password" name="pass2" id="pass2" class="form-control new_pass" placeholder="確認用" autocomplete="off" disabled>
                        </div>
                     </div>

                     <!-- ※ボタン -->
                     <div class="c mt-4">
                        <input type="submit" value="更新" class="btn mr-3" @click="onRegCheck()">
                        <input type="reset" value="リセット" class="btn mr-3">
                        <!-- <a href="<?= $url . "/divers" ?>/" class="btn">戻る</a> -->
                        <button type="bottun" class="btn" onclick="history.back()">戻る</button>
                     </div>

                  </form>
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
   <!-- /#app -->
</body>

</html>