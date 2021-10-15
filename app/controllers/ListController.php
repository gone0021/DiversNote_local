<?php
$root = $_SERVER['DOCUMENT_ROOT'];
$root .= "/data/DiversNote_local";
require_once($root . "/app/util/SessionUtil.php");
require_once($root . "/app/util/CommonUtil.php");
require_once($root . "/app/model/ListModel.php");

// use app\controllers\BaseController;

$dbList = new ListModel();

/**
 * ItemContorollerクラス
 */
class ListController
{
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
      SessionUtil::sessionStart();
      // CSRF対策）
      CommonUtil::csrf($_SESSION['token'], $req['token']);

      global $dbList;
      // 物理削除してからinsertする
      if (!empty($req['list_name'])) {
         $dbList->hard_delete($req['user_id']);
      }

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
         $dbList->insert($toSql);
      }
   }

   /**
    * 論理削除
    */
   public function soft_delete($req)
   {
      // code...
   }

   /**
    * 物理削除
    */
   public function hard_delete($req)
   {
      // code...
   }
}
