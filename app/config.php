<?php
// パスの設定
$root = $_SERVER['DOCUMENT_ROOT'];
$root .= "/data/DiversNote_local";
$auth = $root . '/auth';
$divers = $root . '/divers';
$unsession = $root . '/unsession.php';

// urlの指定
$server = $_SERVER['SERVER_NAME'];
$server .= "/data/DiversNote_local";
$url = 'http://' . $server;
$urlHome = $url . '/';
$urlError = $url . '/error.php';
$urlDivers = $url . '/divers';

/**
 * db設定
 */
/** @var string データベース接続ユーザー名 */
define('DB_USER', 'root');

/** @var string データベース接続パスワード */
define('DB_PASS', '');

/** @var string データベース名 */
define('DB_NAME', 'divers_note');

/** @var string データベースホスト名 */
define('DB_HOST', 'localhost');


/** @var string データベース接続文字列 */
define('DSN', 'mysql:dbname=' . DB_NAME . ';host=' . DB_HOST . ';charset=utf8mb4');

/** セッション自動スタート */
session_start();
// session_regenerate_id(true);

/** ワンタイムトークンの作成 */ 
$token = bin2hex(openssl_random_pseudo_bytes(108));

/** クラスの自動読み込み */
spl_autoload_register(function ($class) {
   // useで読み込んだクラス名が自動的に$classに代入されるようになっている。
   // __DIR__はPHPの組み込み定数で、config.phpがあるディレクトリ名（絶対パス）が格納されている。
   // sprintf()を使って、「/絶対パス/クラスファイル.php」という文字列を作成する。
   // 「クラス名 = ファイル名」にする必要があることに注意。
   $file = sprintf(__DIR__ . '/%s.php', $class);
   // $file = sprintf($_SERVER['DOCUMENT_ROOT'] . '/data/oneday_kanji' . '/%s.php', $class);

   // 各クラスはappから始まる名前空間をつけているため、「/app/app」とパスが重なってしまうので、クラス名の区切り文字である\を/に変換する。
   $file = str_replace('\\', '/', $file);
   // 「/app/app」を「/app」に変換する。
   $file = str_replace('/app/app', '/app', $file);

   // echo $file . '</br>';

   if (file_exists($file)) {
      // ファイルが存在したら読み込む。ファイルは1回しか読み込まれないので、require()を使う。
      require($file);
   } else {
      // ファイルが存在しなかったら、エラー表示する。
      echo 'File not found: ' . $file . '</br>';
      exit;
   }
});
