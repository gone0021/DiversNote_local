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
   public function selectPhoto()
   {
      $sql = '';
      $sql .= 'SELECT';
      $sql .= ' p.id';
      $sql .= ' ,p.item_id';
      // $sql .= ' ,i.user_id';
      // $sql .= ' ,i.dive_date';
      // $sql .= ' ,i.erea_name';
      // $sql .= ' ,i.point_name';
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
      $sql .= ' WHERE p.item_id = :item_id';
      $sql .= ' order by p.photo_name asc';

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
    * is_openの更新
    *
    * @param array $data 更新する作業項目の連想配列
    * @return bool 成功した場合:TRUE、失敗した場合:FALSE
    */
   public function updateIsOpen($data)
   {
      $this->checkId($data['id']);

      $sql = '';
      $sql .= 'UPDATE photos set';
      $sql .= ' is_open = :is_open';
      $sql .= ' ,updated_at = CURRENT_TIMESTAMP';
      $sql .= ' WHERE id = :id';

      $stmt = $this->dbh->prepare($sql);
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
   public function soft_delete($id)
   {
      $this->checkId($id);

      $sql = '';
      $sql .= 'UPDATE photos set';
      $sql .= ' deleted_at = CURRENT_TIMESTAMP';
      $sql .= ' WHERE id = :id';

      $stmt = $this->dbh->prepare($sql);
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $ret = $stmt->execute();

      return $ret;
   }

   /**
    * 物理削除
    *
    * @param array $data 更新する作業項目の連想配列
    * @return bool 成功した場合:TRUE、失敗した場合:FALSE
    */
   public function hard_delete($id)
   {
      $this->checkId($id);

      $sql = '';
      $sql .= 'DELETE FROM photos';
      $sql .= ' WHERE id = :id';

      $stmt = $this->dbh->prepare($sql);
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
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

}
