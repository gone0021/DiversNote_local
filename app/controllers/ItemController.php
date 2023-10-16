<?php

namespace app\controllers;

use app\model\BaseModel;
use app\model\ItemModel;
use app\model\PhotoModel;

/**
 * ItemContorollerクラス
 */
class ItemController
{
   /** @var object インスタンス */
   protected $dbItem;
   protected $dbPhoto;

   // クラスプロパティに関数は使えないためコンストラクタで作成する
   protected $root;
   protected $img_dir;
   protected $singe_dir;

   public function __construct()
   {
      $this->root = $_SERVER['DOCUMENT_ROOT'];
      $this->root .= "/php/DiversNote_local";
      $this->img_dir = $this->root . '/divers/img/';
      $this->singe_dir = $this->root . '/divers/signe/';

      $db = BaseModel::getInstance();
      $this->dbItem = new ItemModel($db);
      $this->dbPhoto = new PhotoModel($db);
   }

   /**
    * idに合致する写真の取得
    */
   public function getItemPhoto($item_id)
   {
      $ret = $this->dbPhoto->getPhotoByItemId($item_id);

      // echo '<pre>';
      // var_dump($ret);
      // echo '</pre>';
      // die;

      return $ret;
   }

   /**
    * 登録
    */
   public function store($req)
   {
      // echo '<pre>';
      // var_export($req);
      // echo '</pre>';
      // die;

      // nullの文字列をNULLへ変換
      $req = $this->changeNull($req);

      // 画像の保存
      if (!empty($req['new_img'])) {
         $this->insertImage($req);
      }
      // サインを保存して変数を上書き
      $req = $this->saveSigen($req);

      // dbの新規追加
      $this->dbItem->insert($req);

      return true;
   }

   /**
    * 更新
    */
   public function update($req)
   {
      // echo '<pre>';
      // var_export($req);
      // echo '</pre>';
      // die;

      // nullの文字列をNULLへ変換
      $req = $this->changeNull($req);

      // 画像の保存
      if (!empty($req['new_img'])) {
         $this->insertImage($req);
      }
      // 画像の更新
      if (!empty($req['edit_img'])) {
         $this->updateImage($req['edit_img']);
      }
      // 画像の削除
      if (!empty($req['del_img'])) {
         $this->deleteImage($req['del_img']);
      }

      // サインを保存して変数を上書き
      $req = $this->saveSigen($req);

      // dbの更新
      $this->dbItem->update($req);

      return true;
   }

   /**
    * 論理削除
    */
   public function softDelete($req)
   {
      // 削除のタイミングに悩む：物理削除の時に削除する方がいい
      // if (!empty($req['old_signe'])) {
      //    // 古いサインの削除
      //    unlink($this->singe_dir . $req['old_signe']);
      // }

      $this->dbItem->softDelete($req);
   }

   /**
    * 文字列からNULLへ変換
    * jsのURLSearchParams()では空だと文字列でnullが入るためNULLに置き換える
    */
   public function changeNull($data)
   {
      foreach ($data as $key => $val) {
         if ($val == '' || $val == "null") {
            $val = NULL;
         }
         $data[$key] = $val;
      }
      return $data;
   }

   /**
    * signeの保存、更新、削除
    */
   public function saveSigen($data)
   {
      // 保存名の作成
      $now = date("Ymd_His");
      $signe_name = $data['user_id'] . 'signe_' . $now . '.png';

      if (!empty($data['signe']) && empty($data['old_signe'])) {
         // 新規の保存
         // echo 'new';

         // 保存するイメージの取得
         $img = file_get_contents($data['signe']);

         // echo $this->singe_dir . '<br>';
         // echo $signe_name . '<br>';
         // echo $img . '<br>';
         // die;

         // 保存
         file_put_contents($this->singe_dir . $signe_name, $img);
         // 保存名を$dataに代入して返す
         $data['signe'] = $signe_name;
         // old_signeをなくす
         unset($data['old_signe']);
         return $data;
      } else if (!empty($data['signe']) && !empty($data['old_signe']) && $data['signe'] == 'delete') {
         // サインの削除
         // echo 'del';

         // 古いサインの削除
         unlink($this->singe_dir . $data['old_signe']);
         // old_signeをsigneに代入
         $data['signe'] = NULL;
         // old_signeをなくす
         unset($data['old_signe']);
         return $data;
      } else if (!empty($data['signe']) && !empty($data['old_signe'])) {
         // 新の保存＋旧の削除
         // echo 'update;

         // 保存するイメージの取得
         $img = file_get_contents($data['signe']);
         // 保存
         file_put_contents($this->singe_dir . $signe_name, $img);
         // 古いサインの削除
         unlink($this->singe_dir . $data['old_signe']);
         // 保存名を$dataに代入
         $data['signe'] = $signe_name;
         // old_signeをなくす
         unset($data['old_signe']);
         return $data;
      } else if (empty($data['signe']) && !empty($data['old_signe'])) {
         // 旧のみ保存（何もしない）
         // echo 'pt.4';

         // old_signeをsigneに代入
         $data['signe'] = $data['old_signe'];
         // old_signeをなくす
         unset($data['old_signe']);
         return $data;
      } else {
         return $data;
      }
   }


   /**
    * imageの保存
    */
   public function insertImage($data)
   {
      // $json_img = json_decode($data['img'], true);
      $json_img = $data['new_img'];

      $next_id = $this->dbItem->getNextId();
      $now = date("Ymd_His");

      foreach ($json_img as $key => $val) {
         $img_name = $_POST['user_id'] . 'photo_' . $now . $key . '.png';

         // 保存するイメージの取得
         $img = file_get_contents($val['url']);
         // 保存
         file_put_contents($this->img_dir . $img_name, $img);

         $arr = [];
         if (empty($data['id'])) {
            $arr['item_id'] = $next_id;
         } else if (!empty($data['id'])) {
            $arr['item_id'] = $data['id'];
         }
         $arr['photo_name'] = $img_name;
         $arr['is_open'] = $val['is_open'];

         $this->dbPhoto->insert($arr);
      }
   }

   /**
    * imageの更新
    */
   public function updateImage($data)
   {
      foreach ($data as $val) {
         $this->dbPhoto->updateIsOpen($val);
      }
   }

   /**
    * imageの削除
    */
   public function deleteImage($data)
   {
      if (!empty($data)) {
         foreach ($data as $val) {
            unlink($this->img_dir . $val['name']);
            $this->dbPhoto->hardDelete($val['id']);
         }
      }
   }

   /**
    * 検索でアイテムを取得
    */
   public function getSchItems($user_id, $select, $val)
   {
      if ((isset($select) && !empty($select)) && (isset($val) && !empty($val))) {
         if ($select == 'all') {
            // 全ての条件から検索
            $ret = $this->dbItem->getSearchItemAll($user_id, $val);
         } else {
            // 特定の条件から検索
            $ret = $this->dbItem->getSearchItem($user_id, $select, $val);
         }
      } else {
         // 検索に不備があった場合
         $ret = $this->dbItem->getUserItem($user_id);
      }
      return $ret;
   }



   /**
    * 連想配列の重複するidを削除：新しく追加されたものを優先
    */
   public function reversArrayById($arr)
   {
      $tmp = [];
      $unique = [];
      foreach ($arr as $val) {
         if (!in_array($val['id'], $tmp)) {
            $tmp['id'] = $val['id'];
            if (in_array($val['is_open'], $val)) {
               $tmp['is_open'] = $val['is_open'];
            }
            $unique[] = $val;
         }
      }
      return $unique;
   }
}
