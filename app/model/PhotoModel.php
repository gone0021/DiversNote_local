<?php
namespace app\model;

/**
 * PhotoModel
 */
class PhotoModel extends BaseModel
{
   /** @var \PDO $pdo \PDOクラスインスタンス */
   private $pdo;

   /**
    * コンストラクタ
    *
    * @param \PDO $pdo \PDOクラスインスタンス
    */
   public function __construct($pdo)
   {
      // 引数に指定した\\PDOクラスのインスタンスをプロパティに代入
      $this->pdo = $pdo;
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
      $sql .= ' ,i.title';
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
      $sql .= ' WHERE p.item_id = :item_id';
      $sql .= ' order by p.photo_name asc';

      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam(':item_id', $item_id, \PDO::PARAM_INT);

      $stmt->execute();
      $ret = $stmt->fetchAll(\PDO::FETCH_ASSOC);
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

      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam(':user_id', $user_id, \PDO::PARAM_INT);

      $stmt->execute();
      $ret = $stmt->fetchAll(\PDO::FETCH_ASSOC);
      return $ret;
   }

   // 検索：search
   /**
    * 対象ユーザーの全ての検索条件のレコードを取得
    * @return array レコードの配列
    */
   public function getAllPhoto($user_id = null)
   {
      if (!empty($user_id)) {
         // 自分の写真で検索する場合
         $this->checkId($user_id);
      }

      $sql = "";
      // 登録済みのカラムをセレクトで取得
      $sql = $this->selectPhoto();
      if (!empty($user_id)) {
         $sql .= ' WHERE i.user_id = :user_id';
      } else {
         $sql .= ' WHERE p.is_open = 0';
      }
      $sql .= ' order by i.dive_date desc';

      $stmt = $this->pdo->prepare($sql);

      if (!empty($user_id)) {
         $stmt->bindParam(':user_id', $user_id, \PDO::PARAM_INT);
      }
      $stmt->execute();
      $ret = $stmt->fetchAll(\PDO::FETCH_ASSOC);
      return $ret;
   }


   // 検索：photo
   /**
    * 対象ユーザーの全ての検索条件のレコードを取得
    * @return array レコードの配列
    */
   public function getPhotoAll($val, $user_id = null)
   {
      if (!empty($user_id)) {
         // 自分の写真で検索する場合
         $this->checkId($user_id);
      }

      $sql = "";
      // 登録済みのカラムをセレクトで取得
      $sql = $this->selectPhoto();
      if (!empty($user_id)) {
         // 自分の写真で検索する場合
         $sql .= ' WHERE i.user_id = :user_id';
      } else {
         $sql .= ' WHERE p.is_open = 0';
      }
      $sql .= ' AND (';
      $sql .= ' i.title LIKE :title';
      $sql .= ' OR i.dive_date LIKE :dive_date';
      $sql .= ' OR i.erea_name LIKE :erea_name';
      $sql .= ' OR i.point_name LIKE :point_name';
      $sql .= ' )';
      $sql .= ' order by i.dive_date desc';

      $likeWord = "%$val%";

      $stmt = $this->pdo->prepare($sql);
      if (!empty($user_id)) {
         $stmt->bindParam(':user_id', $user_id, \PDO::PARAM_INT);
      }
      $stmt->bindParam(':title', $likeWord, \PDO::PARAM_STR);
      $stmt->bindParam(':dive_date', $likeWord, \PDO::PARAM_STR);
      $stmt->bindParam(':erea_name', $likeWord, \PDO::PARAM_STR);
      $stmt->bindParam(':point_name', $likeWord, \PDO::PARAM_STR);

      $stmt->execute();
      $ret = $stmt->fetchAll(\PDO::FETCH_ASSOC);
      return $ret;
   }


   /**
    * 対象ユーザーの特定の検索条件のレコードを取得
    * @return array レコードの配列
    */
   public function getPhotoSelect($select, $val, $user_id = null)
   {
      if (!empty($user_id)) {
         // 自分の写真で検索する場合
         $this->checkId($user_id);
      }

      // echo '<pre>';
      // var_export($select);
      // echo '</pre>';
      // die;

      $sql = "";
      // 登録済みのカラムをセレクトで取得
      $sql = $this->selectPhoto();
      if (!empty($user_id)) {
         // 自分の写真で検索する場合
         $sql .= ' WHERE i.user_id = :user_id';
      } else {
         $sql .= ' WHERE p.is_open = 0';
      }

      if ($select == 'title') {
         $sql .= ' AND i.title LIKE :title';
      }
      if ($select == 'dive_date') {
         $sql .= ' AND i.dive_date LIKE :dive_date';
      }
      if ($select == 'erea_name') {
         $sql .= ' AND i.erea_name LIKE :erea_name';
      }
      if ($select == 'point_name') {
         $sql .= ' AND i.point_name LIKE :point_name';
      }
      $sql .= ' order by i.dive_date desc';

      $likeWord = "%$val%";

      $stmt = $this->pdo->prepare($sql);
      if (!empty($user_id)) {
         $stmt->bindParam(':user_id', $user_id, \PDO::PARAM_INT);
      }
      if ($select == 'title') {
         $stmt->bindParam(':title', $likeWord, \PDO::PARAM_STR);
      }
      if ($select == 'dive_date') {
         $stmt->bindParam(':dive_date', $likeWord, \PDO::PARAM_STR);
      }
      if ($select == 'erea_name') {
         $stmt->bindParam(':erea_name', $likeWord, \PDO::PARAM_STR);
      }
      if ($select == 'point_name') {
         $stmt->bindParam(':point_name', $likeWord, \PDO::PARAM_STR);
      }

      $stmt->execute();
      $ret = $stmt->fetchAll(\PDO::FETCH_ASSOC);
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

      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam(':item_id', $data['item_id'], \PDO::PARAM_INT);
      $stmt->bindParam(':photo_name', $data['photo_name'], \PDO::PARAM_STR);
      $stmt->bindParam(':is_open', $data['is_open'], \PDO::PARAM_STR);
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

      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam(':item_id', $data['item_id'], \PDO::PARAM_STR);
      $stmt->bindParam(':photo_name', $data['photo_name'], \PDO::PARAM_STR);
      $stmt->bindParam(':is_open', $data['is_open'], \PDO::PARAM_STR);
      $stmt->bindParam(':id', $data['id'], \PDO::PARAM_INT);
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

      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam(':is_open', $data['is_open'], \PDO::PARAM_STR);
      $stmt->bindParam(':id', $data['id'], \PDO::PARAM_INT);
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

      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
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

      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
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
