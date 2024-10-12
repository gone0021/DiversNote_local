<?php
require_once('../config.php');

use app\util\CommonUtil;
use app\controllers\ItemController;

// サニタイズ
$get = CommonUtil::sanitaize($_GET);

try {
   $conItem = new ItemController();
   $ret = $conItem->getSchItems($get['user_id'], $get['select'], $get['val']);

   $json = json_encode($ret);
   echo $json;
} catch (Exception $e) {
   // var_dump($e);exit;
   header('Location: ./');
}

// echo '<br />';
// var_dump($ret);
// return json_encode($ret);
