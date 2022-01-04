<!--PC用（801px以上端末）メニュー-->
<nav id="menubar" class="nav-fix-pos homeOther">
   <ul class="inner">
      <li class="ddnav">
         <!-- <a href="javascript:void(0)" class="onHome">HOME<span>ホーム</span></a> -->
         <a href="<?= $url ?>" class="">HOME<span>ホーム</span></a>
      </li>
      <li class="ddnav">
         <a href="javascript:void(0)" class="onEntry">ENTRY<span>ご利用</span></a>
         <ul class="ddmenu">
            <li><a href="<?= $url ?>/auth/register/">新規登録</a></li>
            <li><a href="<?= $url ?>/auth/login/">ログイン</a></li>
         </ul>
      </li>
      <li class="ddnav">
         <a href="javascript:void(0)" class="">OTHERE<span>その他機能</span></a>
         <ul class="ddmenu">
            <li><a href="<?= $url ?>/other/contact.php">お問い合わせ</a></li>
            <li><a href="<?= $url ?>/other/weight.php">目安ウエイト</a></li>
         </ul>
      </li>
   </ul>
</nav>


<!--小さな端末用（800px以下端末）メニュー-->
<nav id="menubar-s">
   <ul>
      <li>
         <!-- <a href="javascript:void(0)" class="onHome onClose">HOME<span>ホーム</span></a> -->
         <a href="<?= $url ?>" class="">HOME<span>ホーム</span></a>
      </li>
      <li>
         <a href="javascript:void(0)" class="onContact onClose">CONTACT<span>お問い合わせ</span></a>
      </li>
      <li id="menubar_hdr2" class="close onEntry onClose">Entry<span>ご利用</span>
         <ul class="menubar-s2">
            <li><a href="<?= $url ?>/auth/register/">新規登録</a></li>
            <li><a href="<?= $url ?>/auth/login/">ログイン</a></li>
         </ul>
      </li>
      <li id="menubar_hdr2" class="close onClose">Other<span>その他機能</span>
         <ul class="menubar-s2">
            <li><a href="<?= $url ?>/other/contact.php">お問い合わせ</a></li>
            <li><a href="<?= $url ?>/other/weight.php">目安ウエイト</a></li>
         </ul>
      </li>
   </ul>
</nav>