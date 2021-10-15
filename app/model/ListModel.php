<?php
$root = $_SERVER['DOCUMENT_ROOT'];
$root .= '/data/DiversNote_local';
require_once($root . '/app/model/BaseModel.php');

/**
 * ListModel
 */
class ListModel extends BaseModel
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
   public function selectList()
   {
      $sql = '';
      $sql .= 'SELECT';
      $sql .= ' l.id';
      // $sql .= ' ,u.id';
      $sql .= ' ,l.tag_name';
      $sql .= ' ,l.list_name';
      $sql .= ' ,l.is_checked';
      $sql .= ' FROM lists as l';
      $sql .= ' LEFT JOIN users as u ON l.user_id = u.id';

      return $sql;
   }

   /**
    * 対象ユーザーのレコードを取得
    * @return array レコードの配列
    */
   public function getList($user_id)
   {
      $this->checkId($user_id);

      $sql = "";
      // 登録済みのカラムをセレクトで取得
      $sql = $this->selectList();
      $sql .= ' WHERE l.user_id = :user_id';
      $sql .= ' order by l.tag_name IS NULL ASC, l.tag_name';

      $stmt = $this->dbh->prepare($sql);
      $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

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
      $sql .= 'INSERT into lists (';
      $sql .= ' user_id';
      $sql .= ' ,tag_name';
      $sql .= ' ,list_name';
      $sql .= ' ,is_checked';
      $sql .= ') values (';
      $sql .= ' :user_id';
      $sql .= ' ,:tag_name';
      $sql .= ' ,:list_name';
      $sql .= ' ,:is_checked';
      $sql .= ')';

      $stmt = $this->dbh->prepare($sql);
      $stmt->bindParam(':user_id', $data['user_id'], PDO::PARAM_INT);
      $stmt->bindParam(':tag_name', $data['tag_name'], PDO::PARAM_STR);
      $stmt->bindParam(':list_name', $data['list_name'], PDO::PARAM_STR);
      $stmt->bindParam(':is_checked', $data['is_checked'], PDO::PARAM_STR);
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
      $sql .= 'UPDATE lists set';
      $sql .= ' user_id = :user_id';
      $sql .= ' ,tag_name = :tag_name';
      $sql .= ' ,list_name = :list_name';
      $sql .= ' ,is_checked = :is_checked';
      $sql .= ' ,updated_at = CURRENT_TIMESTAMP';
      $sql .= ' WHERE id = :id';

      $stmt = $this->dbh->prepare($sql);
      $stmt->bindParam(':user_id', $data['user_id'], PDO::PARAM_STR);
      $stmt->bindParam(':tag_name', $data['tag_name'], PDO::PARAM_STR);
      $stmt->bindParam(':list_name', $data['list_name'], PDO::PARAM_STR);
      $stmt->bindParam(':is_checked', $data['is_checked'], PDO::PARAM_STR);
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
   public function soft_delete($user_id)
   {
      $this->checkId($user_id);

      $sql = '';
      $sql .= 'UPDATE lists set';
      $sql .= ' deleted_at = CURRENT_TIMESTAMP';
      $sql .= ' WHERE user_id = :user_id';

      $stmt = $this->dbh->prepare($sql);
      $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
      $ret = $stmt->execute();

      return $ret;
   }

   /**
    * 物理削除
    *
    * @param array $data 更新する作業項目の連想配列
    * @return bool 成功した場合:TRUE、失敗した場合:FALSE
    */
   public function hard_delete($user_id)
   {
      $this->checkId($user_id);

      $sql = '';
      $sql .= 'DELETE FROM lists';
      $sql .= ' WHERE user_id = :user_id';

      $stmt = $this->dbh->prepare($sql);
      $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
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
