<?php
require_once('../config.php');

use app\model\BaseModel;
use app\model\PhotoModel;

// $root = $_SERVER['DOCUMENT_ROOT'];
// $root .= "/data/DiversNote_local";
// require_once($root . "/app/model/PhotoModel.php");

$item_id = $_GET['item_id'];

try {
   $db = BaseModel::getInstance();
   $dbPhoto = new PhotoModel($db);
   $ret = $dbPhoto->getPhotoByItemId($item_id);

   $json = json_encode($ret);
   echo $json;

} catch (Exception $e) {
   // var_dump($e);exit;
   header('Location: ./');
}

// echo '<br />';
// var_dump($ret);
// return json_encode($ret);
