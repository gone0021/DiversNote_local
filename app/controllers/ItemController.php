<?php
$root = $_SERVER['DOCUMENT_ROOT'];
$root .= "/data/DiversNote_local";
require_once($root . "/app/model/ItemModel.php");

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
      $dbItem = new ItemModel();

      // jsのURLSearchParams()では空だとnullが入る
      foreach ($req as $val => $key) {
         if ($key == '' || $key == "null") {
            $key = NULL;
            var_dump($val . ' : ' . $key);
         }
         $req[$val] = $key;
         var_dump($val . ' : ' . $key);
      }

      // echo '<pre>';
      // var_export($req);
      // echo '</pre>';
      // die;

      $img_name = "";
      move_uploaded_file($req['upimg']['tmp_name'], './upload/' . $img_name);
      $dbItem->insert($req);

      return true;
   }

   /**
    * memoの更新
    */
   public function update($req)
   {
      $dbItem = new ItemModel();

      // jsのURLSearchParams()では空だとnullが入る
      foreach ($req as $val => $key) {
         if ($key == '' || $key == "null") {
            $key = NULL;
            // var_dump($val . ' : ' . $key);
         }
         $req[$val] = $key;
         // var_dump($val . ' : ' . $key);
      }

      // サイン画像の保存はやめる
      // 保存方法に悩む：画像ファイルまたはblobでデータベースに入れるか
      // 手順：とりあえずbase64をデコード
      // $dec_signe = base64_decode($req['signe']);

      // echo '<pre>';
      // var_export($req['signe']);
      // echo '</pre>';

      $dbItem->update($req);

      return true;
   }
}
