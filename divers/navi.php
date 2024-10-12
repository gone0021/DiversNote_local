<!--PC用（801px以上端末）メニュー-->
<nav id="menubar" class="d nav-fix-pos">
   <ul class="">
      <li>
         <!-- <a href="./" class="" >HOME</a> -->
         <a href="<?= $url . "/divers" ?>/">HOME</a>
      </li>

      <li class="ddnav">
         <a href="javascript:void(0)" class="">USER</a>
         <ul class="ddmenu">
            <li><a href="<?= $url . "/divers" ?>/user">会員情報</a></li>
            <li><a href="<?= $url . "/divers" ?>/logout.php">ログアウト</a></li>
         </ul>
      </li>

      <li class="ddnav">
         <a href="javascript:void(0)" class="">OTHER</a>
         <ul class="ddmenu">
            <li><a href="<?= $url . "/divers" ?>/weight">適正ウエイト</a></li>
            <li><a href="<?= $url . "/divers" ?>/list">持ち物リスト</a></li>
            <li><a href="<?= $url . "/divers" ?>/contact">お問い合わせ</a></li>
         </ul>
      </li>
   </ul>
</nav>


<!--小さな端末用（800px以下端末）メニュー-->
<nav id="menubar-s">
   <ul>
      <li>
         <a href="<?= $url . "/divers" ?>/">HOME</a>
      </li>

      <li id="menubar_hdr2" class="close">USER
         <ul class="menubar-s2">
            <li><a href="<?= $url . "/divers" ?>/user">会員情報</a></li>
            <li><a href="<?= $url . "/divers" ?>/logout.php">ログアウト</a></li>
         </ul>
      </li>

      <li id="menubar_hdr2" class="close">OTHERE
         <ul class="menubar-s2">
            <li><a href="<?= $url . "/divers" ?>/weight">適正ウエイト</a></li>
            <li><a href="<?= $url . "/divers" ?>/list">持ち物リスト</a></li>
            <li><a href="<?= $url . "/divers" ?>/contact">お問い合わせ</a></li>
         </ul>
      </li>
   </ul>
</nav>