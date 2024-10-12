// --- items全体 ---
$(function () {
   // 計算ボタン
   $("#calc").on("click", function () {
      let s = $("#sex").val();
      let h = $("#height").val();
      let w = $("#weight").val();
      let p = $("#percentage").val() / 100;

      // --- 基礎ウエイト ---
      let lung = 0;
      if (s == 0) {
         lung = 4;
      } else {
         lung = 3;
      }
      let fat = w * p;  // 体脂肪の重さ
      let fat2 = fat * 1.1;  // 脂肪の体積
      let body = (w - fat) * 0.9;  // 脂肪以外の体積
      let seaWeight = fat2 + body * 1.03;  // 全体積＋海の比重
      let total = seaWeight + lung;  // 海中の体積＋肺の容量
      let selfloat = total - w;  // 自分の浮力
      let r1 = Math.round(selfloat * 10) / 10;
      // let fix1 = r1.toFixed(1);

      $("#basicsWeight").text(r1 + "Kg");

      // --- 機材の浮力 ---
      let tank = $("#tank").val();
      let suit = $("#suit").val();
      let suitSize = $("#suitSize").val() / 10;

      // 体の表面積：keisanより引用
      let bodyArea = h ** 0.725 * w ** 0.425 * 0.007184 * 10000;

      // スーツの浮力
      let suitArea = 0;
      if (suit == 0) {
         suitArea = bodyArea - bodyArea * 0.07;
      } else if (suit == 1) {
         suitArea = bodyArea - bodyArea * 0.21;
      } else if (suit == 2) {
         suitArea = bodyArea - bodyArea * 0.28;
      } else if (suit == 3) {
         suitArea = bodyArea - bodyArea * 0.35;
      } else {
         suitArea = 0;
      }

      let suitVolume = suitArea * suitSize;  // スーツの体積
      let suitWeight = suitVolume * 0.22;  // スーツの重さ
      let suitFloat = (suitVolume - suitWeight) * 1.03 / 1000;  // 海中のスーツの浮力
      let r2 = Math.round(suitFloat * 10) / 10;

      // タンクの重さ：3は機材の重量
      let tankWeight = 3;
      if (tank == 0) {
         tankWeight += 4;
      } else {
         tankWeight += 2;
      }

      let partsFloat = r2 - tankWeight;  // 機材の浮力
      let r3 = Math.round(partsFloat * 10) / 10;
      // 目安ウエイト：加減1キロで表示
      let aboutWeight = partsFloat + selfloat - 1;
      let r4 = Math.round(aboutWeight * 10) / 10;
      if (r4 < 0) {
         r4 = 0.0;
      }
      let r5 = Math.round((r4 + 2.0) * 10) / 10;

      $("#suitWeight").text(r2 + "Kg");
      $("#tankWeight").text(tankWeight + "Kg");
      $("#partsWeight").text(r3 + "Kg");
      $("#aboutWeight").text(r4 + "～" + r5 + "Kg");

   });

   // リセット用の値
   let rh = $("#height").val();
   let rw = $("#weight").val();
   let rp = $("#percentage").val();
   // リセットボタン
   $("#reset").on("click", function () {
      $("#height").val(rh);
      $("#weight").val(rw);
      $("#percentage").val(rp);
      $("#tank").val(0);
      $("#suit").val(0);
      $("#suitSize").val(5);
   });


});

