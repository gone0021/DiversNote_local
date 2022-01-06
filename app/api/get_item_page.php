<?php
require_once('../config.php');

use app\model\BaseModel;
use app\model\ItemModel;

try {
   $db = BaseModel::getInstance();
   $dbItem = new ItemModel($db);
   // $ret = $dbItem->getUserItem($_GET['user_id']);
   // ページング用
   $ret = $dbItem->getItemNum($_GET['user_id'], $_GET['page'], $_GET['row']);

   $json = json_encode($ret);
   echo $json;

} catch (Exception $e) {
   // var_dump($e);exit;
   header('Location: ./');
}

// echo '<br />';
// var_dump($ret);
// return json_encode($ret);
