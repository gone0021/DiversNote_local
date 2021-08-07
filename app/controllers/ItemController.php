<?php
$root = $_SERVER['DOCUMENT_ROOT'];
$root .= "/data/DiversNote_local";
require_once($root . "/app/model/ItemModel.php");

$dbItem = new ItemModel();

/**
 * ItemContorollerクラス
 */
class ItemController
{
   /**
    * idに合致するアイテムの取得
    */
   public function getItemById($user_id, $item_id)
   {
      // まだjoinしないように値を変えてる
      // 写真は写真で取得した方がいい気がしてる
      $args = ['photo none'];
      $dbItem = new ItemModel();
      $ret = $dbItem->getItemById($user_id, $item_id, $args);

      return $ret;
   }

   /**
    * memoの登録
    */
   public function store($req)
   {
      global $root;
      global $dbItem;

      // jsのURLSearchParams()では空だと文字列でnullが入るためNULLに置き換える
      foreach ($req as $key => $val) {
         if ($val == '' || $val == "null") {
            $val = NULL;
         }
         $req[$key] = $val;
      }

      // echo '<pre>';
      // var_export($req);
      // echo '</pre>';
      // die;

      // サインの保存
      if (!empty($req['signe'])) {
         // 保存先の設定
         $singe_dir = $root . '/divers/signe/';
         // 保存するイメージの取得
         $url = $req['signe'];
         $img = file_get_contents($url);
         // 保存名の設定
         $now = date("Ymd_His");
         $signe_name = $req['user_id'] . 'signe_' . $now . '.png';
         // 保存
         file_put_contents($singe_dir . $signe_name, $img);
         // 保存名を$reqに代入
         $req['signe'] = $signe_name;
      }

      $dbItem->insert($req);

      return true;
   }

   /**
    * memoの更新
    */
   public function update($req)
   {
      global $root;
      global $dbItem;

      // echo '<pre>';
      // var_export($req);
      // echo '</pre>';
      // die;

      // jsのURLSearchParams()では空だと文字列でnullが入るためNULLに置き換える

      foreach ($req as $key => $val) {
         if ($val == '' || $val == "null") {
            $val = NULL;
         }
         $req[$key] = $val;
      }


      // サインの保存
      $singe_dir = $root . '/divers/signe/';
      if (!empty($req['signe']) && !empty($req['old_signe'])) {
         // 新しいサイン、古いサインが共にある場合：新の保存＋旧の削除
         echo 'pt.1';
         // 保存するイメージの取得
         $url = $req['signe'];
         $img = file_get_contents($url);
         // 保存名の設定
         $now = date("Ymd_His");
         $signe_name = $req['user_id'] . 'signe_' . $now . '.png';
         // 保存
         file_put_contents($singe_dir . $signe_name, $img);

         // 保存名を$reqに代入
         $req['signe'] = $signe_name;
         // 古いサインの削除
         $old_img = $req['old_signe'];
         unlink($singe_dir . $old_img);

      } else if (!empty($req['signe']) && empty($req['old_signe'])) {
         // 新しいサインあり、古いサインなしの場合：新の保存のみ
         echo 'pt.2';
         // 保存するイメージの取得
         $url = $req['signe'];
         $img = file_get_contents($url);
         // 保存名の設定
         $now = date("Ymd_His");
         $signe_name = $req['user_id'] . 'signe_' . $now . '.png';
         // 保存
         file_put_contents($singe_dir . $signe_name, $img);
         $req['signe'] = $signe_name;
         
      } else if (empty($req['signe']) && !empty($req['old_signe'])) {
         // 新しいサインなし、古いサインありの場合：旧を保存（何もしない）
         echo 'pt.3';
         // 保存するイメージの取得
         $signe_name = $req['old_signe'];
         unset($req['old_signe']);
         $req['signe'] = $signe_name;
      }

      $dbItem->update($req);

      return true;
   }
}
