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
      <li class="ddnav">
         <a href="javascript:void(0)" class="">OTHERE<span>その他機能</span></a>
         <ul class="ddmenu">
            <li><a href="../../other/contact.php">お問い合わせ</a></li>
            <li><a href="../../other/weight.php">目安ウエイト</a></li>
         </ul>
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
      <li id="menubar_hdr2" class="close">Other<span>その他機能</span>
         <ul class="menubar-s2">
            <li><a href="../../other/contact.php">お問い合わせ</a></li>
            <li><a href="../../other/weight.php">目安ウエイト</a></li>
         </ul>
      </li>
   </ul>
</nav>