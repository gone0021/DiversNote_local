<!--PC用（801px以上端末）メニュー-->
<nav id="menubar" class="d nav-fix-pos">
   <ul class="">
      <li>
      <!-- <a href="./" class="" >HOME</a> -->
         <a href="<?= $url."/divers" ?>/">HOME</a>
      </li>
      <li>
         <a href="javascript:void(0)" class="">MY PHOTO</a>
         <ul class="ddmenu">
            <li><a href="./">全ての投稿写真</a></li>
            <li><a href="./">地域ごとの投稿写真</a></li>
         </ul>
      </li>
      <li>
         <a href="javascript:void(0)" class="">OTHER PHOTO</a>
         <ul class="ddmenu">
            <li><a href="./">全ての投稿写真</a></li>
            <li><a href="./">地域ごとの投稿写真</a></li>
         </ul>
      </li>
      <li>
      <a href="javascript:void(0)" class="">USER</a>
         <ul class="ddmenu">
            <li><a href="<?= $url."/divers" ?>/user">会員情報</a></li>
            <li><a href="<?= $url."/divers" ?>/logout.php">ログアウト</a></li>
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

      <li id="menubar_hdr2" class="close">MY PHOTO
         <ul class="menubar-s2">
         <li><a href="./">全ての投稿写真</a></li>
            <li><a href="./">地域ごとの投稿写真</a></li>
         </ul>
      </li>

      <li id="menubar_hdr2" class="close">OTHER PHOTO
         <ul class="menubar-s2">
         <li><a href="./">全ての投稿写真</a></li>
            <li><a href="./">地域ごとの投稿写真</a></li>
         </ul>
      </li>

      <li id="menubar_hdr2" class="close">USER
         <ul class="menubar-s2">
         <li><a href="<?= $url . "/divers" ?>/user">会員情報</a></li>
            <li><a href="<?= $url . "/divers" ?>/logout.php">ログアウト</a></li>
         </ul>
      </li>
   </ul>
</nav>