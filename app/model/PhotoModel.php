<?php
$root = $_SERVER['DOCUMENT_ROOT'];
$root .= '/data/DiversNote_local';
require_once($root . '/app/model/BaseModel.php');

/**
 * PhotoModel
 */
class PhotoModel extends BaseModel
{
   /**
    * コンストラクタ
    */
   public function __construct()
   {
      // 親クラスのコンストラクタを呼び出す
      parent::__construct();
   }

   /**
    * レコードを取得するselect文
    * @return string レコードを取得するselect文
    */
   public function selectPhoto($args = null)
   {
      $sql = '';
      $sql .= 'SELECT';
      $sql .= ' p.id';
      $sql .= ' ,p.item_id';
      $sql .= ' ,i.user_id';
      $sql .= ' ,i.dive_date';
      $sql .= ' ,i.erea_name';
      $sql .= ' ,i.point_name';
      $sql .= ' ,p.photo_name';
      $sql .= ' ,p.is_open';
      $sql .= ' FROM photos as p';
      $sql .= ' LEFT JOIN items as i ON p.item_id = i.id';

      return $sql;
   }

   /**
    * item_idからレコードを取得
    * @return array レコードの配列
    */
   public function getPhotoByItemId($item_id)
   {
      $this->checkId($item_id);

      $sql = "";
      // 登録済みのカラムをセレクトで取得
      $sql = $this->selectPhoto();
      $sql .= ' WHERE i.deleted_at IS NULL';
      $sql .= ' AND i.item_id = :item_id';
      $sql .= ' order by i.dive_num desc';

      $stmt = $this->dbh->prepare($sql);
      $stmt->bindParam(':item_id', $item_id, PDO::PARAM_INT);

      $stmt->execute();
      $ret = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $ret;
   }

   /**
    * 対象ユーザーの全てのレコードを取得
    * @return array レコードの配列
    */
   public function getPhotoByUserId($user_id)
   {
      $this->checkId($user_id);

      $sql = "";
      // 登録済みのカラムをセレクトで取得
      $sql = $this->selectPhoto();
      $sql .= ' WHERE i.deleted_at IS NULL';
      $sql .= ' AND i.user_id = :user_id';
      $sql .= ' order by i.dive_num desc';

      $stmt = $this->dbh->prepare($sql);
      $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

      $stmt->execute();
      $ret = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $ret;
   }

   // 検索：search
   /**
    * 対象ユーザーの全ての検索条件のレコードを取得
    * @return array レコードの配列
    */
   public function getSearchPhotoAll($user_id, $val)
   {
      $this->checkId($user_id);

      $sql = "";
      // 登録済みのカラムをセレクトで取得
      $sql = $this->selectPhoto();
      $sql .= ' WHERE i.deleted_at IS NULL';
      $sql .= ' AND i.user_id = :user_id';
      $sql .= ' AND i.erea_name LIKE :erea_name';
      $sql .= ' order by i.dive_num desc';

      $likeWord = "%$val%";

      $stmt = $this->dbh->prepare($sql);
      $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
      $stmt->bindParam(':erea_name', $likeWord, PDO::PARAM_STR);

      $stmt->execute();
      $ret = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $ret;
   }

   /**
    * 新規追加
    * @return array レコードの配列
    */
   public function insert($data)
   {
      // テーブルの構造でデフォルト値が設定されているカラムをinsert文で指定する必要はありません（特に理由がない限り）。
      $sql = '';
      $sql .= 'INSERT into photos (';
      $sql .= ' item_id';
      $sql .= ' ,photo_name';
      $sql .= ' ,is_open';
      $sql .= ') values (';
      $sql .= ' :item_id';
      $sql .= ' ,:photo_name';
      $sql .= ' ,:is_open';
      $sql .= ')';

      $stmt = $this->dbh->prepare($sql);
      $stmt->bindParam(':item_id', $data['item_id'], PDO::PARAM_INT);
      $stmt->bindParam(':photo_name', $data['photo_name'], PDO::PARAM_STR);
      $stmt->bindParam(':is_open', $data['is_open'], PDO::PARAM_STR);
      $ret = $stmt->execute();

      return $ret;
   }

   /**
    * 更新
    *
    * @param array $data 更新する作業項目の連想配列
    * @return bool 成功した場合:TRUE、失敗した場合:FALSE
    */
   public function update($data)
   {
      $this->checkId($data['id']);

      $sql = '';
      $sql .= 'UPDATE photos set';
      $sql .= ' item_id = :item_id';
      $sql .= ' ,photo_name = :photo_name';
      $sql .= ' ,is_open = :is_open';
      $sql .= ' ,updated_at = CURRENT_TIMESTAMP';
      $sql .= ' WHERE id = :id';

      $stmt = $this->dbh->prepare($sql);
      $stmt->bindParam(':item_id', $data['item_id'], PDO::PARAM_STR);
      $stmt->bindParam(':photo_name', $data['photo_name'], PDO::PARAM_STR);
      $stmt->bindParam(':is_open', $data['is_open'], PDO::PARAM_STR);
      $stmt->bindParam(':id', $data['id'], PDO::PARAM_INT);
      $ret = $stmt->execute();

      return $ret;
   }

   /**
    * 論理削除
    *
    * @param array $data 更新する作業項目の連想配列
    * @return bool 成功した場合:TRUE、失敗した場合:FALSE
    */
   public function soft_delete($data)
   {
      $this->checkId($data['id']);

      $sql = '';
      $sql .= 'UPDATE photos set';
      $sql .= ' deleted_at = CURRENT_TIMESTAMP';
      $sql .= ' WHERE id = :id';

      $stmt = $this->dbh->prepare($sql);
      $stmt->bindParam(':id', $data['id'], PDO::PARAM_INT);
      $ret = $stmt->execute();

      return $ret;
   }

   /**
    * IDの整合性チェック
    *
    * @return bool boool型
    */
   public function checkId($id)
   {
      // $data['id']が存在しなかったら、falseを返却
      if (!isset($id)) {
         return false;
      }

      // $idが数字でなかったら、falseを返却する。
      if (!is_numeric($id)) {
         return false;
      }

      // $idが0以下はありえないので、falseを返却
      if ($id <= 0) {
         return false;
      }
   }














   // 以下サンプル：最後に削除する

   /**
    * 作業項目を検索条件で抽出して取得します。（削除済みの作業項目は含みません）
    *
    * @param mixed $search 検索キーワード
    * @return array 作業項目の配列
    */
   public function getTripDiveBySearch($search)
   {
      $sql = '';
      $sql .= 'SELECT ';
      $sql .= 't.id,';
      $sql .= 't.user_id,';
      $sql .= 'u.name,';
      $sql .= 't.area,';
      $sql .= 't.point,';
      $sql .= 't.date,';
      $sql .= 't.is_went,';
      $sql .= 't.map_Dive,';
      $sql .= 't.comment ';
      $sql .= 'from trip_items as t ';
      $sql .= 'inner join users as u '; // inner join
      $sql .= 'on t.user_id = u.id ';
      $sql .= 'where t.is_deleted =0 '; // where
      $sql .= "AND (";
      $sql .= "u.name like :name ";
      $sql .= "OR t.area like :area ";
      $sql .= "OR t.point like :point ";
      $sql .= "OR t.date = :date ";
      // $sql .= "OR t.is_went like :is_went ";
      $sql .= ") ";
      $sql .= 'order by t.date asc'; // dateの順番に並べる

      // bindParam()の第2引数には値を直接入れることができないので
      // 下記のようにして、検索ワードを変数に入れる。
      $likeWord = "%$search%";

      // $is_went='';
      // if ($search == '行った') {
      //   $is_went = 1;
      // } else if ($search == '気になる') {
      //   $is_went = 0;
      // } else {
      //   $is_went = '';
      // }

      $stmt = $this->dbh->prepare($sql);
      $stmt->bindParam(':name', $likeWord, PDO::PARAM_STR);
      $stmt->bindParam(':area', $likeWord, PDO::PARAM_STR);
      $stmt->bindParam(':point', $likeWord, PDO::PARAM_STR);
      $stmt->bindParam(':date', $search, PDO::PARAM_STR);
      // $stmt->bindParam(':is_went', $is_swent, PDO::PARAM_INT);
      $stmt->execute();
      $ret = $stmt->fetchAll(PDO::FETCH_ASSOC);

      return $ret;
   }

   /**
    * 指定IDの作業項目を1件取得（削除済みの作業項目は含まない）
    * @param int $id 作業項目のID番号
    * @return array 項目の配列
    */
   public function getTripDiveById($id)
   {
      // $idが数字でなかったらfalseを返却する。
      $this->checkId($id);

      $sql = '';
      $sql .= 'SELECT ';
      $sql .= 't.id,';
      $sql .= 't.user_id,';
      $sql .= 'u.name,';
      $sql .= 't.area,';
      $sql .= 't.point,';
      $sql .= 't.date,';
      $sql .= 't.is_went,';
      $sql .= 't.map_Dive,';
      $sql .= 't.comment ';
      $sql .= 'from trip_items as t ';
      $sql .= 'inner join users as u '; // inner join
      $sql .= 'on t.user_id =u.id ';
      $sql .= 'where t.id =:id '; // where
      $sql .= 'AND t.is_deleted =0 '; // 論理削除されている作業項目は表示対象外

      $stmt = $this->dbh->prepare($sql);
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt->execute();
      $ret = $stmt->fetch(PDO::FETCH_ASSOC);

      return $ret;
   }

   /**
    * 作業項目を登録
    *
    * @param array $data 作業項目の連想配列
    * @return bool 成功した場合:TRUE、失敗した場合:FALSE
    */
   public function insertTripDive($data)
   {
      // テーブルの構造でデフォルト値が設定されているカラムをinsert文で指定する必要はありません（特に理由がない限り）。
      $sql = '';
      $sql .= 'INSERT into trip_items (';
      $sql .= 'user_id,';
      $sql .= 'area,';
      $sql .= 'point,';
      $sql .= 'date,';
      $sql .= 'is_went,';
      $sql .= 'map_Dive,';
      $sql .= 'comment ';
      $sql .= ') values (';
      $sql .= ':user_id,';
      $sql .= ':area,';
      $sql .= ':point,';
      $sql .= ':date,';
      $sql .= ':is_went,';
      $sql .= ':map_Dive,';
      $sql .= ':comment ';
      $sql .= ')';

      $stmt = $this->dbh->prepare($sql);
      $stmt->bindParam(':user_id', $data['user_id'], PDO::PARAM_INT);
      $stmt->bindParam(':area', $data['area'], PDO::PARAM_STR);
      $stmt->bindParam(':point', $data['point'], PDO::PARAM_STR);
      $stmt->bindParam(':date', $data['date'], PDO::PARAM_STR);
      $stmt->bindParam(':is_went', $data['is_went'], PDO::PARAM_STR);
      $stmt->bindParam(':map_Dive', $data['map_Dive'], PDO::PARAM_STR);
      $stmt->bindParam(':comment', $data['comment'], PDO::PARAM_STR);
      $ret = $stmt->execute();

      return $ret;
   }

   /**
    * 指定IDの項目を更新
    *
    * @param array $data 更新する作業項目の連想配列
    * @return bool 成功した場合:TRUE、失敗した場合:FALSE
    */
   public function updateTripDiveById($data)
   {
      $this->checkId($data['id']);

      $sql = '';
      $sql .= 'UPDATE trip_items set ';
      $sql .= 'user_id =:user_id,';
      $sql .= 'area =:area,';
      $sql .= 'point =:point,';
      $sql .= 'date =:date,';
      $sql .= 'is_went =:is_went,';
      $sql .= 'map_Dive =:map_Dive,';
      $sql .= 'comment =:comment,';
      $sql .= 'is_deleted =:is_deleted ';  // 現状の仕様では「削除フラグ」をアップデートする必要はないが、今後の仕様追加のために実装しておく。
      $sql .= 'where id =:id'; // where

      $stmt = $this->dbh->prepare($sql);
      $stmt->bindParam(':user_id', $data['user_id'], PDO::PARAM_INT);
      $stmt->bindParam(':area', $data['area'], PDO::PARAM_STR);
      $stmt->bindParam(':point', $data['point'], PDO::PARAM_STR);
      $stmt->bindParam(':date', $data['date'], PDO::PARAM_STR);
      $stmt->bindParam(':is_went', $data['is_went'], PDO::PARAM_STR);
      $stmt->bindParam(':map_Dive', $data['map_Dive'], PDO::PARAM_STR);
      $stmt->bindParam(':comment', $data['comment'], PDO::PARAM_STR);
      $stmt->bindParam(':is_deleted', $data['is_deleted'], PDO::PARAM_INT);
      $stmt->bindParam(':id', $data['id'], PDO::PARAM_INT);
      $ret = $stmt->execute();

      return $ret;
   }

   /**
    * 指定IDの項目を行った→行きたいを変更
    *
    * @param int $id 項目ID
    * @return bool 成功した場合:TRUE、失敗した場合:FALSE
    */
   public function updateToWant($id)
   {
      $this->checkId($id);

      $sql = '';
      $sql .= 'UPDATE trip_items set ';
      $sql .= 'is_went =1 ';
      $sql .= 'where id =:id '; // where
      $sql .= 'AND is_went =0 '; // 念の為にdbでも状態を確認する

      $stmt = $this->dbh->prepare($sql);
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $ret = $stmt->execute();

      return $ret;
   }

   /**
    * 指定IDの項目を行きたい→行ったを変更
    *
    * @param int $id 項目ID
    * @return bool 成功した場合:TRUE、失敗した場合:FALSE
    */
   public function updateToWent($id)
   {
      $this->checkId($id);

      $sql = '';
      $sql .= 'UPDATE trip_items set ';
      $sql .= 'is_went =0 ';
      $sql .= 'where id =:id '; // where
      $sql .= 'AND is_went =1 ';

      $stmt = $this->dbh->prepare($sql);
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $ret = $stmt->execute();

      return $ret;
   }

   /**
    * 指定IDの項目を論理削除
    *
    * @param int $id 作業項目ID
    * @return bool 成功した場合:TRUE、失敗した場合:FALSE
    */
   public function deleteTripDiveById($id)
   {
      $this->checkId($id);

      $sql = '';
      $sql .= 'UPDATE trip_items set ';
      $sql .= 'is_deleted =1 ';
      $sql .= 'where id =:id'; // where

      $stmt = $this->dbh->prepare($sql);
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $ret = $stmt->execute();

      return $ret;
   }
}
