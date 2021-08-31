<section id="entry">
   <h2>ENTRY<span>ご利用</span></h2>
   <h3>お気軽にご利用ください</h3>

   <!-- 送信フォーム -->
   <form action="./auth/login/login.php" method="post" class="">
      <input type="hidden" class="ws" name="token" value="<?= $token ?>">

      <div class="form-group col-6 mx-auto mb-3">
         <input type="email" name="email" id="email" class="form-control" value="" placeholder="メールアドレス" autocomplete="off">
      </div>

      <div class="form-group col-6 mx-auto mb-4">
         <input type="password" name="password" id="password" class="form-control" placeholder="パスワード" autocomplete="off">
      </div>

      <div class="c mb-5">
         <input type="submit" value="ログイン" class="btn mr-5" @click="onRegCheck()">
         <input type="reset" value="リセット" class="btn">
      </div>
   </form>

   <p class="c">※ パスワードを忘れた方は<a href="./auth/password" class="url">こちら</a>から再設定してください。</p>
   <div class="c">
      <a class="btn btn_big" href="./auth/register/">登録はこちら</a>
   </div>

</section>