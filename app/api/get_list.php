<?php
require_once('../config.php');

use app\model\BaseModel;
use app\model\ListModel;

try {
   $db = BaseModel::getInstance();
   $dbList = new ListModel($db);
   $ret = $dbList->getList($_GET['user_id']);

   $json = json_encode($ret);
   echo $json;

} catch (Exception $e) {
   // var_dump($e);exit;
   header('Location: ./');
}
// echo '<br />';
// var_dump($ret);
// return json_encode($ret);
