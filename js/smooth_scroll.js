$(function () {
   let adj = 0;
   let pageTop = 0;
   let home = 0;
   let entry = 0;

   // DOM読み込み時
   calcAdj();
   setSize();

   // ウインドウがリサイズされた時
   $(window).resize(function () {
      calcAdj();
      setSize();
      // console.log(entry);
   });

   let time = 500;

   // top
   $('#toTop').click(function () {
      // console.log("top");
      $("html").animate({ scrollTop: pageTop }, time);
   });

   // home
   $('.onHome').click(function () {
      console.log("home");
      console.log(adj);
      console.log(home);
      $("html").animate({ scrollTop: pageTop }, time);
   });

   // entry
   $('.onEntry').click(function () {
      console.log("entry");
      $("html").animate({ scrollTop: entry }, time);
   });


   /**
    * adjのサイズを計算
    * void
    */
   function calcAdj() {
      var wx = window.innerWidth;
      if (wx < 800) {
         adj = 40;
      } else {
         adj = 100;
      }
   }

   /**
    * scrollTopに仕様する値を取得
    * void
    */
   function setSize() {
      pageTop = $('html').offset().top;
      // home = $('#news').offset().top - adj;
      entry = $('#entry').offset().top - adj;
   }
});
