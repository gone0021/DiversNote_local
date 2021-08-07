let sch_flg = 0;
let dd_flg = 0;
$(function () {
   // 検索navi
   $('#navSch').on('click', function (e) {
      if (sch_flg == 0) {
         $(this).children().show();
         sch_flg = 1;
      } else if (sch_flg == 1) {
         $("#ddSch").hide();
         sch_flg = 0;
      }
   });
   // submitによるhidden
   $('#schBtn').on('click', function (e) {
         $("#ddSch").fadeOut();
         sch_flg = 0;
   });
   // 子要素への伝播を阻止
   $('#ddSch').on('click', function (e) {
      e.stopPropagation();
   });
   // hover時
   $('#navSch').on({
      'mouseenter': function () {
         $("#ddSch").show();
      },
      'mouseleave': function () {
         if (sch_flg == 0) {
            $(".ddmenu").hide();
         }
      }
   })

   // 全てのnavi
   $('.ddnav').on({
      'mouseenter': function () {
         $(this).children().show();
         $("#ddSch").hide();
         
         sch_flg = 0;
      },
      'mouseleave': function () {
         $(".ddmenu").hide();

      }
   })
});
