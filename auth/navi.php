<!--PC用（801px以上端末）メニュー-->
<nav id="menubar" class="nav-fix-pos auth">
   <ul class="inner">
      <li class="ddnav">
         <a href="<?= $url ?>/">HOME<span>ホーム</span></a>
      </li>
      <li class="ddnav">
         <a href="<?= $url ?>/auth/register/">Register<span>新規登録</span></a>
      </li>
      <li class="ddnav">
         <a href="<?= $url ?>/auth/login/">Login<span>ログイン</span></a>
      </li>
   </ul>
</nav>


<!--小さな端末用（800px以下端末）メニュー-->
<nav id="menubar-s">
   <ul>
      <li>
         <a href="<?= $url ?>/">HOME<span>ホーム</span></a>
      </li>
      <li>
         <a href="<?= $url ?>/auth/register/">Register<span>新規登録</span></a>
      </li>
      <li>
         <a href="<?= $url ?>/auth/login/">Login<span>ログイン</span></a>
      </li>
   </ul>
</nav>