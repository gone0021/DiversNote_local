<?php
require_once('../config.php');

use app\controllers\ItemController;

try {
   $conItem = new ItemController();
   $ret = $conItem->getSchItems($_GET['user_id'], $_GET['select'], $_GET['val']);

   $json = json_encode($ret);
   echo $json;
} catch (Exception $e) {
   // var_dump($e);exit;
   header('Location: ./');
}

// echo '<br />';
// var_dump($ret);
// return json_encode($ret);
