<?php
namespace app\controllers;

use app\model\BaseModel;
use app\model\PhotoModel;

/**
 * ItemContorollerクラス
 */
class PhotoController
{
   /** @var object インスタンス */
   protected $dbPhoto;

   public function __construct()
   {
      $db = BaseModel::getInstance();
      $this->dbPhoto = new PhotoModel($db);
   }

   public function index($req = null)
   {
      global $url;
      global $divers_dir;

      $user = CommonUtil::checkVal($_SESSION['user']);

      $ret = $this->getSchPhoto($req['user_id'], $req['user_type'], $req['select'], $req['val']);

      $param = [
         'url' => $url,
         'user' => $user,
         'ret' => $ret,
      ];

      // var_dump($ret);

      return view('divetrs/photo/index.php', $param);
      // return view($divers_dir . '/phto/index.php', $param);
      // header('Location:' . $divers_dir . '/phto/index.php');
      // return $param;
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
      // code...
   }

   /**
    * 論理削除
    */
   public function soft_delete($req)
   {
      // code...
   }

   /**
    * 検索でアイテムを取得
    */
   public function getSchPhoto($user_id, $user_type, $select, $val)
   {
      global $dbPhoto;

      if ((isset($select) && !empty($select)) && (isset($val) && !empty($val))) {
         if ($user_type == 0) {
            // die("1");
            // 自分の写真
            if ($select == 'all') {
               // 全ての条件から検索
               // die("11");
               $ret = $this->dbPhoto->getPhotoAll($val, $user_id);
            } else {
               // 特定の条件から検索
               // die("12");
               $ret = $this->dbPhoto->getPhotoSelect($select, $val, $user_id);
            }
         } else {
            // die("2");
            // 全員の写真
            if ($select == 'all') {
               // 全ての条件から検索
               // die("21");
               $ret = $this->dbPhoto->getPhotoAll($val);
            } else {
               // 特定の条件から検索
               // die("22");
               $ret = $this->dbPhoto->getPhotoSelect($select, $val);
            }
         }
      } else {
         // 検索に不備があった場合：または検索値が空白の場合
         if ($user_type == 0) {
            $ret = $this->dbPhoto->getAllPhoto($user_id);
         } else {
            $ret = $this->dbPhoto->getAllPhoto();
         }
      }
      return $ret;
   }
}
