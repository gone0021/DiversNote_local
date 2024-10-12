<?php

namespace app\controllers;

use app\model\BaseModel;
use app\model\ListModel;

/**
 * ItemContorollerクラス
 */
class ListController
{
   /** @var object インスタンス */
   protected $dbList;

   public function __construct()
   {
      $db = BaseModel::getInstance();
      $this->dbList = new ListModel($db);
   }

   public function index($req = null)
   {
      // code...
   }

   /**
    * 登録
    */
   public function store($req)
   {
      // code...
   }

   /**
    * 更新
    */
   public function update($req)
   {
      // 物理削除してからinsertする
      if (!empty($req['list_name'])) {
         $this->dbList->hardDelete($req['user_id']);
      }

      // echo '<pre>';
      // var_export($req);
      // echo '</pre>';
      // die;

      $toSql = [];
      $cnt = count($req['list_name']);
      for ($i = 0; $i < $cnt; $i++) {
         $toSql['user_id'] = (int)$req['user_id'];
         $toSql['tag_name'] = $req['tag_name'][$i];
         $toSql['list_name'] = $req['list_name'][$i];
         $toSql['is_checked'] = $req['is_checked'][$i];

         // echo '<pre>';
         // var_export($toSql);
         // echo '</pre>';
         // die;
         $this->dbList->insert($toSql);
      }
   }

   /**
    * 論理削除
    */
   public function softDelete($req)
   {
      // code...
   }

   /**
    * 物理削除
    */
   public function hardDelete($req)
   {
      // code...
   }
}
