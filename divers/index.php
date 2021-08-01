<?php
$root = $_SERVER['DOCUMENT_ROOT'];
$root .= "/data/DiversNote";
require_once($root . "/app/util/SessionUtil.php");
require_once($root . "/app/util/CommonUtil.php");
require_once($root . "/app/controllers/ItemController.php");

$divers = $root . '/divers';

// urlの指定
$rootUrl = $_SERVER['SERVER_NAME'];
$rootUrl .= "/data/DiversNote";
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
               <div id="cardBox">
                  <template v-if="items">
                     <div class="cardItem" v-for="(item, i) in items" @click="onItem(item.id)">
                        <span>No.{{ item.dive_num }}</span>
                        <span>{{ item.title }}</span>
                        <div>{{ item.dive_date }}</div>
                        <div>{{ item.erea_name }}</div>
                        <div v-if="item.point_name">{{ item.point_name }}</div>
                        <div v-else>未入力</div>
                     </div>
                  </template>
               </div>

               <!-- modal -->
               <?php require_once($divers . "/modal.php"); ?>
            </div>
            <!--/.inner-->

         </div>
         <!--/#contents-->

      </div>
      <!--/#container-->

      <p id="toTop" class="nav-fix-pos-pagetop"><a href="javascript:void(0)">↑</a></p>

      <!-- メニュー開閉ボタン -->
      <div id="menubar_hdr" class="close"></div>

   </div>
   <!-- /#app -->

   <script>
      let user_id = <?php echo $user_id; ?>
   </script>
   <!-- <script>
      let next_num = <?php echo $next_num; ?>
   </script> -->

</body>

</html>