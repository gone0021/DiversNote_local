// --- items全体 ---
$(function () {
   // DOM読み込み時：jq3移行だとready()は不要
   $(function () {
      // console.log("--- positionb ---");
      mdlPositon();
      // console.log("--- height ---");
      mdlHeigt();
   });

   // ウインドウがリサイズされた時
   $(window).resize(function () {
      // console.log("--- positionb ---");
      mdlPositon();
      // console.log("--- height ---");
      mdlHeigt();
      // console.log("--- mTop ---");
      // mdlTopWidth();
      // console.log(adj);
   });

   // モーダルが呼び出された時
   $(".cardItem").on("click", function () {
      // $(".mdlBox").on("load", function () {
      // console.log("card-item");
      // console.log("--- positionb ---");
      mdlPositon();
      // console.log("--- height ---");
      mdlHeigt();
   });
   $("#navNew").on("click", function () {
      // console.log("nav-new");

      // $(".mdlBox").on("load", function () {
      // console.log("--- positionb ---");
      mdlPositon();
      // console.log("--- height ---");
      mdlHeigt();
   });

   /**
    * モーダルの幅を取得してmdlTopの幅を決める
    * cssで対応：不使用
    */
   function mdlTopWidth() {
      var mtw = 720;

      var mdl = document.querySelector(".mdlBox");
      var mw1 = mdl.clientWidth;
      mtw = mw1 - 40;

      $("#mdlTop").css("width", mtw);
      console.log(mtw);
   }

   /**
    * 画面の高さを取得してmdlのmax-heightを決める
    */
   function mdlHeigt() {
      var wh = window.innerHeight;
      var ww = window.innerWidth;
      if (ww < 840) {
         var maxh = wh - 100;
      } else {
         var maxh = wh - 200;
      }

      // console.log(mHeight);
      $(".mdlBox").css("max-height", maxh);
      // console.log(maxh);
   }

   /**
    * モーダルウィンドウを中央配置するための配置場所を計算する
    */
   function mdlPositon() {
      var mdlBox = $(".mdlBox");
      var ww = $(window).width();
      var mw = mdlBox.outerWidth();
      var ml = (ww - mw) / 2;

      // 今のところtop（mt）はcssの決め打ち(@media)でcssに記述：とりあえず残してる
      var wh = $(window).height();
      var mh = mdlBox.outerHeight();
      var mt = (wh - mh) / 3;

      mdlBox.css({
         // 'top': mt + 'px',
         'left': ml + 'px',
         // 'margin-top': 0,
         'margin-left': 0
      });
      // console.log("top : " + mt);
      // console.log("left : " + ml);
   }
});

