<?php

namespace app\model;

/**
 * db設定クラス
 */
class BaseModel
{
   /** @var \PDO PDOクラスインスタンス */
   private static $pdo;

   /**
    * PDOクラスのインスタンスを生成して返す
    *
    * @return \PDO PDOクラスのインスタンス
    */
   public static function getInstance()
   {
      // インスタンスが生成されていなかったら新しく生成
      // すでに生成済みであれば、生成済みのインスタンスを返す
      if (!isset(self::$pdo)) {
         // echo 'true <br>';
         // namespaceを設定しているので、PHPの組み込みクラスは「\」をつけて呼び出す
         self::$pdo = new \PDO(DSN, DB_USER, DB_PASS);
         // エラーモードを例外する
         self::$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
         // カラム名をキーとした連想配列としてレコードを取得する
         self::$pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
      }
      // echo 'false <br>';
      return self::$pdo;
   }

   /**
    * トランザクションの開始
    */
   public static function begin()
   {
      self::$pdo->beginTransaction();
   }

   /**
    * トランザクションのコミット
    */
   public static function commit()
   {
      self::$pdo->commit();
   }

   /**
    * トランザクションのロールバック
    */
   public static function rollback()
   {
      self::$pdo->rollback();
   }
}
