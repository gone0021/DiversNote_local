<?php
/**
 * セッション関連ユーティリティクラスです。
 */
class PhotoUtil
{
	/**
	 * セッションスタート
	 *
	 * @return void
	 */
	public static function sessionStart() {
      if (!isset($_SESSION)) {
         session_start();
         session_regenerate_id(true);
      }
	}
}