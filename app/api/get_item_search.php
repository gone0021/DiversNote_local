<?php
$root = $_SERVER['DOCUMENT_ROOT'];
$root .= "/data/DiversNote";
require_once($root . "/app/model/ItemModel.php");

$user_id = $_GET['user_id'];

// echo '<pre>';
// var_export($_GET);
// echo '</pre>';
// die;

$dbItem = new ItemModel();

if ((isset($_GET['search']) && !empty($_GET['search'])) && (isset($_GET['val']) && !empty($_GET['val']))) {
   if ($_GET['search'] == 'all') {
      // 全ての条件から検索
      $ret = $dbItem->getSearchItemAll($user_id, null, $_GET['val']);
   } else {
      // 特定の条件から検索
      $ret = $dbItem->getSearchItem($user_id, null,  $_GET['search'], $_GET['val']);
   }
} else {
   // 検索に不備があった場合
   $ret = $dbItem->getUserItem($user_id);
}

$json = json_encode($ret);

echo $json;
return;


// echo '<br />';
// var_dump($ret);
// return json_encode($ret);
