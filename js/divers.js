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

   var flg = 0;
   $(".acdTitle").on("click", function () {
      if (flg == 0) {
         $(this).next().slideDown(200);
         $(".new_pass").prop("disabled", false);
         $(".new_pass").prop("required", true);
         flg = 1;
      } else {
         $(this).next().slideUp(200);
         $(".new_pass").prop("disabled", true);
         $(".new_pass").prop("required", false);
         flg = 0;
      }


      // $(this).next().slideToggle(200);
      // $(this).toggleClass("open");

      // if ($(".acdItem").is(':hidden')) {
      //    console.log("none");
      //    $(".new_pass").prop("disabled", true);
      // } else {
      //    console.log("block");
      //    $(".new_pass").prop("disabled", false);
      // }

   });
   // $("#glayLayer").on("click", function () {
   //    $(".acdTitle").next().slideUp();
   //    $(".acdTitle").removeClass("open");
   // });


   /**
    * ヘッダーの高さを取得してcontentsマージンを設定する
    */
   function adjHeigt() {
      let header_height = document.querySelector('.site_header').scrollHeight;
      // console.log(header_height);
      $(".contents").css("margin-top", header_height);
   }

});