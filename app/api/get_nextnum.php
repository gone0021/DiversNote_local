<?php
require_once('../config.php');

use app\model\BaseModel;
use app\model\ItemModel;

try {
   $db = BaseModel::getInstance();
   $dbItem = new ItemModel($db);
   $ret = $dbItem->getMaxItemNum($_GET['user_id']);

   $json = json_encode($ret);
   echo $json;

} catch (Exception $e) {
   // var_dump($e);exit;
   header('Location: ./');
}
// echo '<br />';
// var_dump($ret);
// return json_encode($ret);
