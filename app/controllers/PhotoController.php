<?php
$root = $_SERVER['DOCUMENT_ROOT'];
$root .= "/data/DiversNote_local";
require_once($root . "/app/util/SessionUtil.php");
require_once($root . "/app/util/CommonUtil.php");
require_once($root . "/app/model/ItemModel.php");
require_once($root . "/app/model/PhotoModel.php");
require_once($root . "/app/controllers/ItemController.php");
require_once($root . "/app/controllers/BaseController.php");

// use app\controllers\BaseController;


// ディレクトリの指定
$img_dir = $root . '/divers/img/';
$singe_dir = $root . '/divers/signe/';
$divers_dir = $root . '/divers';

// urlの指定
$rootUrl = $_SERVER['SERVER_NAME'];
$rootUrl .= "/data/DiversNote_local";
$url = 'http://' . $rootUrl;

// セッションスタート
SessionUtil::sessionStart();

$dbItem = new ItemModel();
$dbPhoto = new PhotoModel();
$conItem = new ItemController();

/**
 * ItemContorollerクラス
 */
class PhotoController extends BaseController
{
   public function __construct()
   {
      // 親クラスのコンストラクタを呼び出す
      parent::__construct();
      // echo 'filename is ParentModel.php' . PHP_EOL;
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
               $ret = $dbPhoto->getPhotoAll($val, $user_id);
            } else {
               // 特定の条件から検索
               // die("12");
               $ret = $dbPhoto->getPhotoSelect($select, $val, $user_id);
            }
         } else {
            // die("2");
            // 全員の写真
            if ($select == 'all') {
               // 全ての条件から検索
               // die("21");
               $ret = $dbPhoto->getPhotoAll($val);
            } else {
               // 特定の条件から検索
               // die("22");
               $ret = $dbPhoto->getPhotoSelect($select, $val);
            }
         }
      } else {
         // 検索に不備があった場合：または検索値が空白の場合
         if ($user_type == 0) {
            $ret = $dbPhoto->getAllPhoto($user_id);
         } else {
            $ret = $dbPhoto->getAllPhoto();
         }
      }
      return $ret;
   }
}
