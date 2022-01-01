<?php
require_once('../config.php');

use app\controllers\PhotoController;

// echo '<pre>';
// var_export($_GET);
// echo '</pre>';
// die;
try {
   $conPhoto = new PhotoController();
   $ret = $conPhoto->getSchPhoto($_GET['user_id'], $_GET['user_type'], $_GET['select'], $_GET['val']);

   $json = json_encode($ret);
   echo $json;

} catch (Exception $e) {
   // var_dump($e);exit;
   header('Location: ./');
}
// echo '<br />';
// var_dump($ret);
// return json_encode($ret);
