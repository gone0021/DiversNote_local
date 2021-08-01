<!--PC用（801px以上端末）メニュー-->
<nav id="menubar" class="nav-fix-pos">
   <ul class="inner">
      <li class="ddnav">
      <a href="javascript:void(0)" class="onHome">HOME<span>ホーム</span></a>
         <!-- <a href="<?= $url ?>/">HOME<span>ホーム</span></a> -->
      </li>
      <li class="ddnav">
         <a href="javascript:void(0)" class="onAbout">ABOUT<span>当サイトについて</span></a>
      </li>
      <li class="ddnav">
         <a href="javascript:void(0)" class="onNews">NEWS<span>更新情報</span></a>
      </li>
      <li class="ddnav">
         <a href="javascript:void(0)" class="onContact">CONTACT<span>お問い合わせ</span></a>
      </li>
      <li class="ddnav">
      <a href="javascript:void(0)" class="onEntry">ENTRY<span>ご利用</span></a>
         <ul class="ddmenu">
            <li><a href="./auth/register/">新規登録</a></li>
            <li><a href="./auth/login/">ログイン</a></li>
         </ul>
      </li>
   </ul>
</nav>


<!--小さな端末用（800px以下端末）メニュー-->
<nav id="menubar-s">
   <ul>
      <li>
         <a href="javascript:void(0)" class="onHome onClose">HOME<span>ホーム</span></a>
      </li>
      <li>
         <a href="javascript:void(0)" class="onAbout onClose">ABOUT<span>当サイトについて</span></a>
      </li>
      <li>
         <a href="javascript:void(0)" class="onNews onClose">NEWS<span>更新情報</span></a>
      </li>
      <li>
         <a href="javascript:void(0)" class="onContact onClose">CONTACT<span>お問い合わせ</span></a>
      </li>
      <li id="menubar_hdr2" class="close onEntry onClose">Entry<span>ご利用</span>
         <ul class="menubar-s2">
            <li><a href="./auth/register/">新規登録</a></li>
            <li><a href="./auth/login/">ログイン</a></li>
         </ul>
      </li>
   </ul>
</nav>