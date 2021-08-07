$(function () {
   // 読み込み時
   $(window).on('load', function (e) {
      //
   });

   $(".onClose").click(function (e) {
      $("#menubar-s").hide();
      // e.preventDefault();
   });

   // 画面幅が変わった時
   $(window).resize(function () {
      //
   });

   /**
    * ヘッダーの高さを取得してcontentsマージンを設定する
    */
   function adjHeigt() {
      let header_height = document.querySelector('.site_header').scrollHeight;
      // console.log(header_height);
      $(".contents").css("margin-top", header_height);
   }

});