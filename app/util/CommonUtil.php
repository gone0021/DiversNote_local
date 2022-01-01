<?php

namespace app\util;

/**
 * 共通関数クラス
 */
class CommonUtil
{
   /**
    * POSTされたデータをサニタイズする
    *
    * @param array $before サニタイズ前のPOST配列
    * @return array サニタイズ後のPOST配列
    */
   public static function sanitaize($before)
   {
      $after = array();

      // postされたデータを
      foreach ($before as $k => $v) {
         $after[$k] = htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
      }

      // GoogleMapのiframeのみデコード
      if (!empty($after['map_item']) && preg_match("/&lt;iframe src=\&quot;https:\/\/www.google\.com\/maps(.*?)&lt;\/iframe&gt;/s", $after['map_item'])) {
         $after['map_item'] = htmlspecialchars_decode($after['map_item'], ENT_QUOTES);
      }
      return $after;
   }
   // googleMapのiframe文字列の参考
   // https://ja.stackoverflow.com/questions/28159/iframe%E3%82%92%E6%AD%A3%E8%A6%8F%E8%A1%A8%E7%8F%BE%E3%81%A7%E5%88%A4%E5%88%A5%E3%81%99%E3%82%8B%E6%96%B9%E6%B3%95


   /**
    * postされた値とsessionに保存された値のチェック
    * @param int $session sessionに保存された値
    * @param int $post postで受け取った値
    * @return void
    */
   public static function csrf($session, $post)
   {
      if (!isset($session) || $session !== $post) {
         $_SESSION['msg']['error'] = "不正な処理が行われました。";
         header('Location: ./');
         exit;
      } else {
         // unset($post);
      }
   }

   /**
    * セッションのクリア
    * @param array $arr 
    */
   public static function unsession($arr)
   {
      foreach ($arr as $v) {
         $_SESSION[$v] = '';
         unset($_SESSION[$v]);
      }
   }

   /**
    * ログインのチェック  
    * 引数に値があればそのまま返す
    * @param array 保存されている値
    * @return array 保存されている値
    */
   public static function isUser($session, $redirect)
   {
      $ret = '';
      if (empty($session)) {
         // 未ログインのとき
         header("Location: $redirect");
      } else {
         // ログイン済みのとき
         $ret = $session;
      }
      return $ret;
   }
}
