<?php
// rootの指定
$root = $_SERVER['DOCUMENT_ROOT'];
$root .= '/data/DiversNote_local';

// クラスの読み込み
require_once($root . '/app/model/BaseModel.php');