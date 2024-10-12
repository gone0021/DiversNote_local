<?php
require_once('../config.php');

use app\model\BaseModel;
use app\model\ItemModel;

// var_dump($_GET);
try {

   $db = BaseModel::getInstance();
   $dbItem = new ItemModel($db);
   $ret = $dbItem->getItemById($_GET['user_id'], $_GET['id']);

   $json = json_encode($ret);
   echo $json;

} catch (Exception $e) {
   // var_dump($e);exit;
   header('Location: ./');
}


// echo '<br />';
// var_dump($ret);
// return json_encode($ret);
