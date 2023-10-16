$(function () {
   $(".onClose").click(function (e) {
      $("#menubar-s").hide();
      // e.preventDefault();
   });

   // 画面幅が変わった時
   $(window).resize(function () {
      //
   });

   // モーダル用アコーディオン
   var flg = 0;
   $(".acdTitle").on("click", function () {
      // if (flg == 0) {
      if (!$(this).hasClass('acdOpen')) {
         $(this).next().slideDown(200);
         $(this).addClass("acdOpen");
         flg = 1;
      } else {
         $(this).next().slideUp(200);
         $(this).removeClass("acdOpen");
         flg = 0;
      }
   });
   $(".acdTitleOpen").on("click", function () {
      // if (flg == 0) {
      if (!$(this).hasClass('acdOpen')) {
         $(this).next().slideDown(200);
         $(this).addClass("acdOpen");
         flg = 1;
      } else {
         $(this).next().slideUp(200);
         $(this).removeClass("acdOpen");
         flg = 0;
      }
   });


   // パスワード再設定ページのアコーディオン
   $(".editPass").on("click", function () {
      console.log("click");

      if (!$(this).hasClass('acdOpen')) {
         $(this).next().slideDown(200);
         $(this).addClass("acdOpen");
         $(".new_pass").prop("disabled", false);
         $(".new_pass").prop("required", true);
      } else {
         $(this).next().slideUp(200);
         $(this).removeClass("acdOpen");
         $(".new_pass").prop("disabled", true);
         $(".new_pass").prop("required", false);
      }
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