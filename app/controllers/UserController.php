<?php
$root = $_SERVER['DOCUMENT_ROOT'];
$root .= "/data/DiversNote_local";
require_once($root . "/app/model/UserModel.php");

/**
 * ItemContorollerクラス
 */
class UserController
{
   public function isCurrentPass($id, $pass, &$msg)
   {
      $dbUser = new UserModel();
      $ret = $dbUser->getUserById($id);
      if (!password_verify($pass, $ret['password'])) {
         $msg = "パスワードが異なります";
         return false;
      }

      return true;
   }

   /**
    * メールアドレスからユーザーを検索してパスワードをチェック
    * @param string $email メールアドレス
    * @param string $password パスワード
    * @return array ユーザー情報の配列（該当のユーザーが見つからないときは空の配列）
    */
   public function checkPassEmail($email, $pass)
   {
      $dbUser = new UserModel();
      $ret = $dbUser->getUserByEmail($email);

      if (!password_verify($pass, $ret['password'])) {
         return array();
      }

      unset($ret['password']);

      return $ret;
   }
}
