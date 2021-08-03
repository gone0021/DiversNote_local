<?php
$root = $_SERVER['DOCUMENT_ROOT'];
$root .= '/data/DiversNote_local';
require_once($root . '/app/model/BaseModel.php');

/**
 * ItemModel
 */
class ItemModel extends BaseModel
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
    * itemsの最後のidを取得
    * @return array レコードの配列
    */
   public function getMaxId()
   {
      $sql = '';
      $sql .= 'SELECT';
      $sql .= ' MAX(id) as max_id';
      $sql .= ' FROM items';

      $stmt = $this->dbh->prepare($sql);
      $stmt->execute();
      $ret = $stmt->fetch(PDO::FETCH_ASSOC);
      return $ret;
   }

   /**
    * dive_numの最大値を取得
    */
   public function getMaxItemNum($user_id)
   {
      $sql = '';
      $sql .= 'SELECT';
      $sql .= ' MAX(dive_num) as dive_num';
      $sql .= ' FROM items';
      $sql .= ' WHERE user_id = :user_id ';

      $stmt = $this->dbh->prepare($sql);
      $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
      $stmt->execute();
      $ret = $stmt->fetch(PDO::FETCH_ASSOC);

      return (int)$ret['dive_num'] + 1;
   }

   /**
    * レコードを取得するselect文
    * @return string レコードを取得するselect文
    */
   public function selectItem($args = null)
   {
      $sql = '';
      $sql .= 'SELECT';
      $sql .= ' i.id';
      $sql .= ' ,i.user_id';
      $sql .= ' ,i.title';
      $sql .= ' ,i.dive_date';
      $sql .= ' ,i.dive_num';
      $sql .= ' ,i.erea_name';

      $sql .= ' ,i.point_name';
      $sql .= ' ,i.entry_type';
      $sql .= ' ,i.shop_name';
      $sql .= ' ,i.start_time';
      $sql .= ' ,i.end_time';

      $sql .= ' ,i.avg_depth';
      $sql .= ' ,i.max_depth';

      $sql .= ' ,i.temp';
      $sql .= ' ,i.water_temp';
      $sql .= ' ,i.weather';
      $sql .= ' ,i.wind';
      $sql .= ' ,i.current';
      $sql .= ' ,i.view';

      $sql .= ' ,i.tank_material';
      $sql .= ' ,i.tank_size';
      $sql .= ' ,i.start_air';
      $sql .= ' ,i.end_air';
      $sql .= ' ,i.is_enriche';

      $sql .= ' ,i.suit_type';
      $sql .= ' ,i.weight';

      $sql .= ' ,i.map_link';
      $sql .= ' ,i.comment';
      $sql .= ' ,i.signe';
      $sql .= ' ,i.buddy_name';
      $sql .= ' ,i.instructor_name';
      $sql .= ' ,i.instructor_num';
      $sql .= ' ,i.signe';

      // joinした場合
      // if (isset($args) && in_array('photo', $args)) {
      //    $sql .= ' ,p.id as p_id';
      //    $sql .= ' ,p.photo_name';
      //    $sql .= ' ,p.is_open';
      // }

      $sql .= ' FROM items as i';

      // joinした場合
      // if (isset($args) && in_array('photo', $args)) {
      //    $sql .= ' LEFT JOIN photo as p ON i.id = p.item_id';
      // }

      return $sql;
   }

   /**
    * 対象ユーザーの全てのレコードを取得
    * @return array レコードの配列
    */
   public function getUserItem($user_id, $args = null)
   {
      $this->checkId($user_id);

      $sql = "";
      // 登録済みのカラムをセレクトで取得
      $sql = $this->selectItem($args);
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
   public function getSearchItemAll($user_id, $args = null, $val)
   {
      $this->checkId($user_id);

      $sql = "";
      // 登録済みのカラムをセレクトで取得
      $sql = $this->selectItem($args);
      $sql .= ' WHERE i.deleted_at IS NULL';
      $sql .= ' AND i.user_id = :user_id';

      $sql .= ' AND (';
      $sql .= ' i.title LIKE :title';
      $sql .= ' OR i.dive_date LIKE :dive_date';
      $sql .= ' OR i.erea_name LIKE :erea_name';
      $sql .= ' OR i.point_name LIKE :point_name';
      $sql .= ' OR i.shop_name LIKE :shop_name';
      $sql .= ' OR i.buddy_name LIKE :buddy_name';
      $sql .= ' OR i.instructor_name LIKE :instructor_name';
      $sql .= ' )';
      $sql .= ' order by i.dive_num desc';

      $likeWord = "%$val%";

      $stmt = $this->dbh->prepare($sql);
      $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

      $stmt->bindParam(':title', $likeWord, PDO::PARAM_STR);
      $stmt->bindParam(':dive_date', $likeWord, PDO::PARAM_STR);
      $stmt->bindParam(':erea_name', $likeWord, PDO::PARAM_STR);
      $stmt->bindParam(':point_name', $likeWord, PDO::PARAM_STR);
      $stmt->bindParam(':shop_name', $likeWord, PDO::PARAM_STR);
      $stmt->bindParam(':buddy_name', $likeWord, PDO::PARAM_STR);
      $stmt->bindParam(':instructor_name', $likeWord, PDO::PARAM_STR);

      $stmt->execute();
      $ret = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $ret;
   }

   /**
    * 対象ユーザーの特定の検索条件のレコードを取得
    * @return array レコードの配列
    */
   public function getSearchItem($user_id, $args = null, $search, $val)
   {
      $this->checkId($user_id);

      $sql = "";
      // 登録済みのカラムをセレクトで取得
      $sql = $this->selectItem($args);
      $sql .= ' WHERE i.deleted_at IS NULL';
      $sql .= ' AND i.user_id = :user_id';

      if ($search == 'title') {
         $sql .= ' AND i.title LIKE :title';
      }
      if ($search == 'dive_date') {
         $sql .= ' AND i.dive_date LIKE :dive_date';
      }
      if ($search == 'erea_name') {
         $sql .= ' AND i.erea_name LIKE :erea_name';
      }
      if ($search == 'point_name') {
         $sql .= ' AND i.point_name LIKE :point_name';
      }
      if ($search == 'shop_name') {
         $sql .= ' AND i.shop_name LIKE :shop_name';
      }
      if ($search == 'buddy_name') {
         $sql .= ' AND i.buddy_name LIKE :buddy_name';
      }
      if ($search == 'instructor_name') {
         $sql .= ' AND i.instructor_name LIKE :instructor_name';
      }
      $sql .= ' order by i.dive_num desc';

      $likeWord = "%$val%";

      $stmt = $this->dbh->prepare($sql);
      $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

      if ($search == 'title') {
         $stmt->bindParam(':title', $likeWord, PDO::PARAM_STR);
      }
      if ($search == 'dive_date') {
         $stmt->bindParam(':dive_date', $likeWord, PDO::PARAM_STR);
      }
      if ($search == 'erea_name') {
         $stmt->bindParam(':erea_name', $likeWord, PDO::PARAM_STR);
      }
      if ($search == 'point_name') {
         $stmt->bindParam(':point_name', $likeWord, PDO::PARAM_STR);
      }
      if ($search == 'shop_name') {
         $stmt->bindParam(':shop_name', $likeWord, PDO::PARAM_STR);
      }
      if ($search == 'buddy_name') {
         $stmt->bindParam(':buddy_name', $likeWord, PDO::PARAM_STR);
      }
      if ($search == 'instructor_name') {
         $stmt->bindParam(':instructor_name', $likeWord, PDO::PARAM_STR);
      }

      $stmt->execute();
      $ret = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $ret;
   }

   /**
    * 対象ユーザーのレコードを取得
    * @return array レコードの配列
    */
   public function getItemById($user_id, $id, $args = null)
   {
      $this->checkId($user_id);

      $sql = "";
      // 登録済みのカラムをセレクトで取得
      $sql = $this->selectItem($args);
      $sql .= ' WHERE i.deleted_at IS NULL ';
      $sql .= ' AND i.id = :id ';
      $sql .= ' AND i.user_id = :user_id ';
      $sql .= ' order by i.dive_num desc';

      // var_dump($sql);die;

      $stmt = $this->dbh->prepare($sql);
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
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
      $sql .= 'INSERT into items (';
      $sql .= ' user_id';
      $sql .= ' ,title';
      $sql .= ' ,dive_date';
      $sql .= ' ,dive_num';
      $sql .= ' ,erea_name';
      $sql .= ' ,point_name';
      $sql .= ' ,shop_name';
      $sql .= ' ,entry_type';
      $sql .= ' ,start_time';
      $sql .= ' ,end_time';
      $sql .= ' ,avg_depth';
      $sql .= ' ,max_depth';
      $sql .= ' ,tank_material';
      $sql .= ' ,tank_size';
      $sql .= ' ,start_air';
      $sql .= ' ,end_air';
      $sql .= ' ,is_enriche';
      $sql .= ' ,temp';
      $sql .= ' ,water_temp';
      $sql .= ' ,view';
      $sql .= ' ,weather';
      $sql .= ' ,wind';
      $sql .= ' ,current';
      $sql .= ' ,suit_type';
      $sql .= ' ,weight';
      $sql .= ' ,comment';
      $sql .= ' ,map_link';
      $sql .= ' ,buddy_name';
      $sql .= ' ,instructor_name';
      $sql .= ' ,instructor_num';
      $sql .= ' ,signe';
      $sql .= ') values (';
      $sql .= ' :user_id';
      $sql .= ' ,:title';
      $sql .= ' ,:dive_date';
      $sql .= ' ,:dive_num';
      $sql .= ' ,:erea_name';
      $sql .= ' ,:point_name';
      $sql .= ' ,:shop_name';
      $sql .= ' ,:entry_type';
      $sql .= ' ,:start_time';
      $sql .= ' ,:end_time';
      $sql .= ' ,:avg_depth';
      $sql .= ' ,:max_depth';
      $sql .= ' ,:tank_material';
      $sql .= ' ,:tank_size';
      $sql .= ' ,:start_air';
      $sql .= ' ,:end_air';
      $sql .= ' ,:is_enriche';
      $sql .= ' ,:temp';
      $sql .= ' ,:water_temp';
      $sql .= ' ,:view';
      $sql .= ' ,:weather';
      $sql .= ' ,:wind';
      $sql .= ' ,:current';
      $sql .= ' ,:suit_type';
      $sql .= ' ,:weight';
      $sql .= ' ,:comment';
      $sql .= ' ,:map_link';
      $sql .= ' ,:buddy_name';
      $sql .= ' ,:instructor_name';
      $sql .= ' ,:instructor_num';
      $sql .= ' ,:signe';
      $sql .= ')';

      $stmt = $this->dbh->prepare($sql);
      $stmt->bindParam(':user_id', $data['user_id'], PDO::PARAM_INT);
      $stmt->bindParam(':title', $data['title'], PDO::PARAM_STR);
      $stmt->bindParam(':dive_date', $data['dive_date'], PDO::PARAM_STR);
      $stmt->bindParam(':dive_num', $data['dive_num'], PDO::PARAM_STR);
      $stmt->bindParam(':erea_name', $data['erea_name'], PDO::PARAM_STR);
      $stmt->bindParam(':point_name', $data['point_name'], PDO::PARAM_STR);
      $stmt->bindParam(':shop_name', $data['shop_name'], PDO::PARAM_STR);
      $stmt->bindParam(':entry_type', $data['entry_type'], PDO::PARAM_STR);
      $stmt->bindParam(':start_time', $data['start_time'], PDO::PARAM_STR);
      $stmt->bindParam(':end_time', $data['end_time'], PDO::PARAM_STR);

      $stmt->bindParam(':avg_depth', $data['avg_depth'], PDO::PARAM_STR);
      $stmt->bindParam(':max_depth', $data['max_depth'], PDO::PARAM_STR);

      $stmt->bindParam(':tank_material', $data['tank_material'], PDO::PARAM_STR);
      $stmt->bindParam(':tank_size', $data['tank_size'], PDO::PARAM_STR);
      $stmt->bindParam(':start_air', $data['start_air'], PDO::PARAM_STR);
      $stmt->bindParam(':end_air', $data['end_air'], PDO::PARAM_STR);
      $stmt->bindParam(':is_enriche', $data['is_enriche'], PDO::PARAM_STR);

      $stmt->bindParam(':temp', $data['temp'], PDO::PARAM_STR);
      $stmt->bindParam(':water_temp', $data['water_temp'], PDO::PARAM_STR);
      $stmt->bindParam(':view', $data['view'], PDO::PARAM_STR);
      $stmt->bindParam(':weather', $data['weather'], PDO::PARAM_STR);
      $stmt->bindParam(':wind', $data['wind'], PDO::PARAM_STR);
      $stmt->bindParam(':current', $data['current'], PDO::PARAM_STR);

      $stmt->bindParam(':suit_type', $data['suit_type'], PDO::PARAM_STR);
      $stmt->bindParam(':weight', $data['weight'], PDO::PARAM_STR);
      $stmt->bindParam(':comment', $data['comment'], PDO::PARAM_STR);
      $stmt->bindParam(':map_link', $data['map_link'], PDO::PARAM_STR);
      $stmt->bindParam(':buddy_name', $data['buddy_name'], PDO::PARAM_STR);
      $stmt->bindParam(':instructor_name', $data['instructor_name'], PDO::PARAM_STR);
      $stmt->bindParam(':instructor_num', $data['instructor_num'], PDO::PARAM_STR);
      $stmt->bindParam(':signe', $data['instructor_name'], PDO::PARAM_STR);
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
      $sql .= 'UPDATE items set';
      $sql .= ' title = :title';
      $sql .= ' ,dive_date = :dive_date';
      $sql .= ' ,dive_num = :dive_num';
      $sql .= ' ,erea_name = :erea_name';
      $sql .= ' ,point_name = :point_name';
      $sql .= ' ,shop_name = :shop_name';
      $sql .= ' ,entry_type = :entry_type';
      $sql .= ' ,start_time = :start_time';
      $sql .= ' ,end_time = :end_time';

      $sql .= ' ,max_depth = :max_depth';
      $sql .= ' ,avg_depth = :avg_depth';

      $sql .= ' ,tank_material = :tank_material';
      $sql .= ' ,tank_size = :tank_size';
      $sql .= ' ,start_air = :start_air';
      $sql .= ' ,end_air = :end_air';
      $sql .= ' ,is_enriche = :is_enriche';

      $sql .= ' ,temp = :temp';
      $sql .= ' ,water_temp = :water_temp';
      $sql .= ' ,weather = :weather';
      $sql .= ' ,wind = :wind';
      $sql .= ' ,current = :current';
      $sql .= ' ,view = :view';

      $sql .= ' ,suit_type = :suit_type';
      $sql .= ' ,weight = :weight';
      $sql .= ' ,comment = :comment';
      $sql .= ' ,map_link = :map_link';
      $sql .= ' ,buddy_name = :buddy_name';
      $sql .= ' ,instructor_name = :instructor_name';
      $sql .= ' ,instructor_num = :instructor_num';
      $sql .= ' ,signe = :signe';


      $sql .= ' ,updated_at = CURRENT_TIMESTAMP';
      $sql .= ' WHERE id = :id';

      $stmt = $this->dbh->prepare($sql);
      $stmt->bindParam(':title', $data['title'], PDO::PARAM_STR);
      $stmt->bindParam(':dive_date', $data['dive_date'], PDO::PARAM_STR);
      $stmt->bindParam(':dive_num', $data['dive_num'], PDO::PARAM_STR);
      $stmt->bindParam(':erea_name', $data['erea_name'], PDO::PARAM_STR);
      $stmt->bindParam(':point_name', $data['point_name'], PDO::PARAM_STR);
      $stmt->bindParam(':shop_name', $data['shop_name'], PDO::PARAM_STR);
      $stmt->bindParam(':entry_type', $data['entry_type'], PDO::PARAM_STR);
      $stmt->bindParam(':start_time', $data['start_time'], PDO::PARAM_STR);
      $stmt->bindParam(':end_time', $data['end_time'], PDO::PARAM_STR);

      $stmt->bindParam(':avg_depth', $data['avg_depth'], PDO::PARAM_STR);
      $stmt->bindParam(':max_depth', $data['max_depth'], PDO::PARAM_STR);

      $stmt->bindParam(':tank_material', $data['tank_material'], PDO::PARAM_STR);
      $stmt->bindParam(':tank_size', $data['tank_size'], PDO::PARAM_STR);
      $stmt->bindParam(':start_air', $data['start_air'], PDO::PARAM_STR);
      $stmt->bindParam(':end_air', $data['end_air'], PDO::PARAM_STR);
      $stmt->bindParam(':is_enriche', $data['is_enriche'], PDO::PARAM_STR);

      $stmt->bindParam(':temp', $data['temp'], PDO::PARAM_STR);
      $stmt->bindParam(':water_temp', $data['water_temp'], PDO::PARAM_STR);
      $stmt->bindParam(':view', $data['view'], PDO::PARAM_STR);
      $stmt->bindParam(':weather', $data['weather'], PDO::PARAM_STR);
      $stmt->bindParam(':wind', $data['wind'], PDO::PARAM_STR);
      $stmt->bindParam(':current', $data['current'], PDO::PARAM_STR);

      $stmt->bindParam(':suit_type', $data['suit_type'], PDO::PARAM_STR);
      $stmt->bindParam(':weight', $data['weight'], PDO::PARAM_STR);
      $stmt->bindParam(':comment', $data['comment'], PDO::PARAM_STR);
      $stmt->bindParam(':map_link', $data['map_link'], PDO::PARAM_STR);
      $stmt->bindParam(':buddy_name', $data['buddy_name'], PDO::PARAM_STR);
      $stmt->bindParam(':instructor_name', $data['instructor_name'], PDO::PARAM_STR);
      $stmt->bindParam(':instructor_num', $data['instructor_num'], PDO::PARAM_STR);
      $stmt->bindParam(':signe', $data['signe'], PDO::PARAM_STR);
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
      $sql .= 'UPDATE items set';
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