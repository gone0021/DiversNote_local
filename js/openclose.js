$(function () {
   // ハンバーガーメニューのクリック
   $("#menubar_hdr").on("click", function (e) {
      // メニューの開閉
      $("#menubar-s").fadeToggle();

      // クラス名の変更
      var cl = $("#menubar_hdr").attr("class");
      if (cl === "open") {
         // console.log("open");
         $(".open").removeClass().addClass("close");
      } else {
         // console.log("close");
         $(".close").removeClass().addClass("open");
      }
      // e.preventDefault();
   });

   // メニューをクリックした再
   $(".onClose").on("click", function (e) {
      // メニューを閉じる
      $("#menubar-s").fadeOut();
      // クラス名を変更
      $(".open").removeClass().addClass("close");
      // e.preventDefault();
   });
});