<?php

namespace app\controllers;

use app\util\CommonUtil;
use app\model\BaseModel;
use app\model\UserModel;

/**
 * ItemContorollerクラス
 */
class UserController
{
   /** @var object インスタンス */
   protected $dbUser;

   public function __construct()
   {
      $db = BaseModel::getInstance();
      $this->dbUser = new UserModel($db);
   }

   /**
    * メールアドレスからユーザーを検索してパスワードをチェック
    * @param string $email メールアドレス
    * @param string $password パスワード
    * @return array パスワードを除いたユーザー情報の配列（ユーザーが見つからないときは空の配列）
    */
   public function checkPassEmail($email, $pass)
   {
      $rec = $this->dbUser->getUserByEmail($email);

      if (!password_verify($pass, $rec['password'])) {
         return array();
      }
      // パスワードを削除
      unset($rec['password']);

      return $rec;
   }

   /**
    * メールアドレスからユーザーを検索して誕生日をチェック
    * @param string $email メールアドレス
    * @param string $password パスワード
    * @return array ユーザー情報の配列（該当のユーザーが見つからないときは空の配列）
    */
   public function checkBirthdayEmail($email, $birthday)
   {
      $rec = $this->dbUser->getUserByEmail($email);

      if ($birthday != $rec['birthday']) {
         return array();
      }

      unset($rec['password']);

      return $rec;
   }


   public function login(Type $var = null)
   {
      # code...
   }
}
