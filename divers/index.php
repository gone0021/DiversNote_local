<?php
$root = $_SERVER['DOCUMENT_ROOT'];
$root .= "/data/DiversNote_local";
require_once($root . "/app/util/SessionUtil.php");
require_once($root . "/app/util/CommonUtil.php");
require_once($root . "/app/controllers/ItemController.php");

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

// 検索キーワード
if (isset($_SESSION['search'])) {
   $search = $_SESSION['search'];
} else {
   $search = '';
}

$user_id = $_SESSION['user']['id'];
// echo $user_id;

$conItem = new ItemController();
$dbItem = new ItemModel();
$items = $dbItem->getUserItem($user_id);
$next_num = $dbItem->getMaxItemNum($user_id);

// echo '<pre>';
// var_export($items);
// echo '</pre>';

// var_dump($next_num);
// var_dump($_SESSION['user']);
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
               <template v-if="items">
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
               <div v-if="items.length == 0">ログはありません。</div>
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