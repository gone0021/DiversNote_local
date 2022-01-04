<?php
// jsで計算するだけのため当ファイルのみで処理する

// 共通ファイル
require_once('../app/config.php');

// スーツ
$suit = ['ワンピース', 'シーガル', 'ロンジョン', 'フードベスト', '水着',];

?>

<!DOCTYPE html>
<html lang="ja">
<?php include_once($root . '/head.php'); ?>

<body>
   <div id="app">
      <div id="container">
         <?php include_once($root . '/navi.php'); ?>

         <div id="contents">
            <div class="inner">
               <section id="calcweight">
                  <h2 class="title">About Weight</h2>
                  <h3>目安ウエイトの計算</h3>


                  <!-- 性別 -->
                  <div class="form-group col-6 mx-auto">
                     <!-- 入力フォーム -->
                     <label for="sex">性別</label>
                     <select name="sex" id="sex">
                        <option value="0">男</option>
                        <option value="1">女</option>
                     </select>
                  </div>

                  <!-- 身長 -->
                  <div class="form-group col-6 mx-auto mt-3">
                     <label for="height">身長</label>
                     <input type="number" name="height" value="" id="height" class="form-control" placeholder="cm">
                  </div>

                  <!-- 体重 -->
                  <div class="form-group col-6 mx-auto">
                     <!-- 入力フォーム -->
                     <label for="weight">体重</label>
                     <input type="number" name="weight" value="" id="weight" class="form-control" placeholder="kg">
                  </div>

                  <!-- 体脂肪率 -->
                  <div class="form-group col-6 mx-auto">
                     <!-- 入力フォーム -->
                     <label for="percentage">体脂肪率</label>
                     <input type="number" name="percentage" value="" id="percentage" class="form-control" placeholder="%">
                  </div>

                  <!-- タンク素材 -->
                  <div class="form-group col-6 mx-auto">
                     <!-- 入力フォーム -->
                     <label for="tank">タンク素材</label>
                     <select name="tank" id="tank">
                        <option value="0">スチール</option>
                        <option value="1">アルミ</option>
                     </select>
                  </div>

                  <!-- ウエットスーツ -->
                  <div class="form-group col-6 mx-auto">
                     <!-- 入力フォーム -->
                     <label for="suit">ウエットスーツ</label>
                     <select name="suit" id="suit">
                        <?php foreach ($suit as $k => $v) : ?>
                           <option value="<?= $k ?>"><?= $v ?></option>
                        <?php endforeach; ?>
                     </select>
                  </div>

                  <!-- スーツの厚み -->
                  <div class="form-group col-6 mx-auto mb-5">
                     <!-- 入力フォーム -->
                     <label for="suitSize">スーツの厚み</label>
                     <input type="number" name="suitSize" value="5" id="suitSize" class="form-control" placeholder="mm">
                  </div>

                  <h3 class="">体の浮力：
                     <span id="basicsWeight"></span>
                  </h3>
                  <h3 class="">目安のウエイト：
                     <span id="aboutWeight"></span>
                  </h3>


                  <!-- ※ボタン -->
                  <div class="c mt-4">
                     <button type="button" id="calc" class="btn mr-3">計算</button>
                     <button type="button" id="reset" class="btn mr-3">リセット</button>
                     <a href="./" class="btn">戻る</a>
                  </div>

               </section>

            </div>
            <!-- /#main -->

         </div>
         <!-- /#contents -->
         <?php include_once($root . '/footer.php'); ?>

      </div>
      <!-- /#container -->
      <!--メニュー開閉ボタン-->
      <div id="menubar_hdr" class="close"></div>
   </div>
   <!-- /#app -->
</body>

</html>