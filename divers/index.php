<?php
$root = $_SERVER['DOCUMENT_ROOT'];
$root .= "/data/DiversNote_local";
require_once($root . "/app/util/SessionUtil.php");
require_once($root . "/app/util/CommonUtil.php");
require_once($root . "/app/model/ItemModel.php");
require_once($root . "/app/model/PhotoModel.php");

$divers = $root . '/divers';

// urlの指定
$rootUrl = $_SERVER['SERVER_NAME'];
$rootUrl .= "/data/DiversNote_local";
$url = 'http://' . $rootUrl;

// セッションスタート
SessionUtil::sessionStart();

// --- ログインの確認 ---
// $_SESSION['user']：ログイン時に取得したユーザー情報
if (empty($_SESSION['user'])) {
   // 未ログインのとき
   header('Location: ../');
} else {
   // ログイン済みのとき
   $user = $_SESSION['user'];
}

$token = bin2hex(openssl_random_pseudo_bytes(108));
$_SESSION['token'] = $token;

$user_id = $_SESSION['user']['id'];
// echo $user_id;

?>

<!DOCTYPE html>
<html lang="ja">
<?php require_once($divers . "/head_home.php"); ?>

<body>
   <div id="app">
      <div id="container">
         <?php require_once($divers . "/navi_home.php"); ?>

         <div id="contents">
            <div class="inner">
               <template v-if="!dispPhoto">
                  <h3>Diving・Log</h3>
                  <div id="cardBox">
                     <div class="cardItem" v-for="(item, i) in items" @click="onItem(item.id)">
                        <span>No.{{ item.dive_num }}</span>
                        <span>{{ item.title }}</span>
                        <div>{{ item.dive_date }}</div>
                        <div>{{ item.erea_name }}</div>
                        <div v-if="item.point_name" key="point_name">{{ item.point_name }}</div>
                        <div v-else key="point_name">未入力</div>
                     </div>
               </template>

               <template v-if="dispPhoto">
                  <h3>Photo</h3>
                  <div id="cardBox">
                     <div class="cardItem" v-for="(photo, i) in photos" @click="onItem(item.id)">
                        <p>
                           <a :href="url + '/img/' + photo.photo_name" target=”_blank”><img class="" :src="'./img/' + photo.photo_name"></a>
                        </p>
                        <span>{{ photo.title }}</span>
                        <span>{{ photo.erea_name }}</span>
                        <span v-if="photo.point_name" key="point_na me">{{ photo.point_name }}</span>
                        <span v-else key="point_name">未入力</span>
                        <span>{{ photo.dive_date }}</span>
                     </div>
               </template>
               <div v-if="items.length == 0 && !dispPhoto">ログはありません。</div>
               <div v-if="photos.length == 0 && dispPhoto">写真はありません。</div>
            </div>
            <!-- cardBox -->

         </div>
         <!--/.inner-->

      </div>
      <!--/#contents-->
      <?php require_once($divers . "/item-modal.php"); ?>

      <p id="toTop" class="nav-fix-pos-pagetop"><a href="javascript:void(0)">↑</a></p>

      <!-- メニュー開閉ボタン -->
      <div id="menubar_hdr" class="close"></div>
   </div>
   <!--/#container-->
   </div>
   <!-- /#app -->

   <script>
      let user_id = <?= $user_id ?>
   </script>
   <script>
      let user_name = <?= json_encode($_SESSION['user']['user_name']) ?>
   </script>
   <script>
      let price_plan = <?= $_SESSION['user']['price_plan'] ?>
   </script>

</body>

</html>