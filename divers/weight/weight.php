<?php
require_once('../../app/config.php');

// ※dbテーブルを作成してデータを保存するか検討中

// 身長
$height = "";
if (!empty($_SESSION['post']['height'])) {
   $height =  $_SESSION['post']['height'];
}
// 体重
$weight = "";
if (!empty($_SESSION['post']['weight'])) {
   $weight = $_SESSION['post']['weight'];
}
// 体脂肪率
// $percentage = $user['birthday'];
$percentage = "";
if (!empty($_SESSION['post']['percentage'])) {
   $percentage = $_SESSION['post']['percentage'];
}

// タンク
$tank = ['スチール', 'アルミ',];
$tank_size = ['8' => '8', '10' => '10', '12' => '12'];

// スーツ
$suit = ['ワンピース', 'シーガル', 'ロンジョン', 'フードベスト', '水着',];
