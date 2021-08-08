<?php
$root = $_SERVER['DOCUMENT_ROOT'];
$root .= "/data/DiversNote_local";
require_once($root . "/app/model/ItemModel.php");

$tmp = $root . '/divers/tmp/';
$img_dir = $root . '/divers/img/';
$singe_dir = $root . '/divers/signe/';
$tmp = $root . '/divers/tmp/';

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
      global $img_dir;
      global $tmp;
      global $singe_dir;
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


      // 画像の保存


      // サインを保存して変数を上書き
      $req = $this->saveSigen($req);

      // dbの新規追加
      $dbItem->insert($req);

      return true;
   }

   /**
    * memoの更新
    */
   public function update($req)
   {
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

      // サインを保存して変数を上書き
      $req = $this->saveSigen($req);

      // dbの更新
      $dbItem->update($req);

      return true;
   }

   /**
    * 論理削除
    */
   public function soft_delete($req)
   {
      global $img_dir;
      global $singe_dir;
      global $dbItem;

      echo '<pre>';
      var_export($req);
      echo '</pre>';
      // die;

      // 削除のタイミングに悩む：物理削除の時に削除する方がいい
      // if (!empty($req['old_signe'])) {
      //    // 古いサインの削除
      //    unlink($singe_dir . $req['old_signe']);
      // }

      $dbItem->soft_delete($req);
   }

   /**
    * signeの保存、更新、削除
    */
   public function saveSigen($data)
   {
      global $singe_dir;

      // 保存名の作成
      $now = date("Ymd_His");
      $signe_name = $data['user_id'] . 'signe_' . $now . '.png';

      if (!empty($data['signe']) && empty($data['old_signe'])) {
         // 新の保存
         echo 'pt.1';

         // 保存するイメージの取得
         $img = file_get_contents($data['signe']);
         // 保存
         file_put_contents($singe_dir . $signe_name, $img);
         // 保存名を$dataに代入して返す
         $data['signe'] = $signe_name;
         // old_signeをなくす
         unset($data['old_signe']);
         return $data;
      } else if (!empty($data['signe']) && !empty($data['old_signe']) && $data['signe'] == 'delete') {
         // サインの削除
         echo 'pt.2';

         // 古いサインの削除
         unlink($singe_dir . $data['old_signe']);
         // old_signeをsigneに代入
         $data['signe'] = NULL;
         // old_signeをなくす
         unset($data['old_signe']);
         return $data;
      } else if (!empty($data['signe']) && !empty($data['old_signe'])) {
         // 新の保存＋旧の削除
         echo 'pt.3';

         // 保存するイメージの取得
         $img = file_get_contents($data['signe']);
         // 保存
         file_put_contents($singe_dir . $signe_name, $img);
         // 古いサインの削除
         unlink($singe_dir . $data['old_signe']);
         // 保存名を$dataに代入
         $data['signe'] = $signe_name;
         // old_signeをなくす
         unset($data['old_signe']);
         return $data;
      } else if (empty($data['signe']) && !empty($data['old_signe'])) {
         // 旧のみ保存（何もしない）
         echo 'pt.4';

         // old_signeをsigneに代入
         $data['signe'] = $data['old_signe'];
         // old_signeをなくす
         unset($data['old_signe']);
         return $data;
      }
   }

   /**
    * imageの保存、更新、削除
    * 仮作成
    */
   public function saveImage($data)
   {
      // global $tmp;
      // global $img_dir;


      // if (!empty($req['img'])) {
      //    $obj_img = $req['img'];
      //    echo '<pre>';
      //    var_export($obj_img);
      //    echo '</pre>';
      //    foreach ($obj_img as $key => $val) {
      //       echo '<pre>';
      //       var_export($val);
      //       echo '</pre>';

      //       foreach ($val as $k => $v) {
      //          echo '<pre>';
      //          var_export($v);
      //          echo '</pre>';

      //          move_uploaded_file($tmp, $img_dir . $v['name']);
      //       }
      //    }
      // }
   }
}
