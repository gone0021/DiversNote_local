<?php
  $root = $_SERVER["DOCUMENT_ROOT"];
  $root .= "/data/DiversNote";
  require_once($root."/app/util/SessionUtil.php");

  // セッションスタート
  SessionUtil::sessionStart();

  // ログインユーザー情報をクリアしてログアウト処理とする
  session_destroy();

  // ログインページへリダイレクト
  header("Location: ../");
