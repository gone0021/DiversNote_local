<?php
require_once('../../app/config.php');

use app\util\CommonUtil;
use app\model\BaseModel;
use app\model\UserModel;

// サニタイズ
$post = CommonUtil::sanitaize($_POST);

// データベースに登録する内容を連想配列にする。
$data = array(
   'id' => $post['id'],
   'user_name' => $post['user_name'],
   'email' => $post['email'],
   'birthday' => $post['birthday'],
   'password' => $post['password'],
);

// ユーザー情報のアップデート
try {
   $db = BaseModel::getInstance();
   $dbUser = new UserModel($db);
   $dbUser->updateUser($data);
} catch (Exception $e) {
   // var_dump($e);exit;
   header("Location: $urlError");
}

// tokenのクリア
$post['token'] = '';
unset($post['token']);

// ユーザーページへ遷移
header("Location: ./");