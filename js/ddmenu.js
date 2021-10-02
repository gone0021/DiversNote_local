// 同じForm内では0以外の値が入る
let show_flg = 0;

$(function () {
   // 全てのnavi
   $('.ddnav').on({
      'mouseenter': function () {
         $(this).children().show();
         show_flg = 0;
         restElem();
      },
      'mouseleave': function () {
         $(".ddmenu").hide();
      }
   })

   // Formを含むnavi
   naviForm("#navSch", "#schBtn", 1, "#ddPht");
   naviForm("#navPhoto", "#phtBtn", 2, "#ddSch");


   /**
    * ナビバーのform表示：複数のメソッドを入れてる
    * 
    * @param {*} id1 
    * @param {*} btn 
    * @param {*} flg 
    * @param {*} hide1 
    */
   function naviForm(id1, btn, flg, hide1) {
      // click時
      onClickNaviForm(id1, flg);
      // submit時
      onSubmitkNaviForm(btn);
      // hover時
      onHoverNaviForm(id1, flg);
      // 異なるナビバーのFormにhoverした時
      onHoverOthereNaviForm(id1, hide1);
   }

   /**
    * ナビバーのForm箇所をクリックした時
    * 
    * @param {*} id1 
    * @param {*} flg 
    */
   function onClickNaviForm(id1, flg) {
      // click時
      $(id1).on('click', function (e) {
         if (show_flg == 0) {
            $(this).children().show();
            // $(id2).css({ background: "#dd6b3d" });
            $(".ddmenu").css({ background: "rgba(200,106,67,0.8)" });

            show_flg = flg;
         } else {
            $(".ddmenu").hide();
            // $(id2).css({background: "#5876a3"});
            $(".ddmenu").css({ background: "rgba(63,148,227,0.8)" });
            show_flg = 0;
         }
      });

      // 子要素への伝播を阻止：クリック判定時のみ
      $(".ddmenu").on('click', function (e) {
         if (show_flg !== 0) {
            e.stopPropagation();
         }
      });
   }

   /**
    * ナビバーのFormを送信した時
    * 
    * @param {*} btn 
    */
   function onSubmitkNaviForm(btn) {
      $(btn).on('click', function (e) {
         $(".ddmenu").fadeOut();
         show_flg = 0;
      });
   }

   /**
    * ナビバーのFormをhoverした時
    * 
    * @param {*} id1 
    * @param {*} flg 
    */
   function onHoverNaviForm(id1, flg) {
      $(id1).on({
         'mouseenter': function () {
            // console.log("enter");
            $(this).children().show();
            if (show_flg !== flg) {
               // 異なるFormに入った場合はshow_flgを0に戻す
               show_flg = 0;
            }
         },
         'mouseleave': function () {
            // console.log("leave");
            if (show_flg !== 0) {
               return false;
            } else {
               $(".ddmenu").hide();
               $(".ddmenu").css({ background: "rgba(63,148,227,0.8)" });
               show_flg = 0;
            }
         }
      })
   }

   /**
    * 異なるナビバーのFormにhoverした際のリセット
    * 
    * @param {*} id1 
    * @param {*} hdie1 
    */
   function onHoverOthereNaviForm(id1, hide1) {
      $(id1).on('mouseenter', function () {
         $(hide1).hide();
         if (show_flg == 0) {
            // show_flgが0（異なるナビメニュー）に移動した時は色を戻す
            $(".ddmenu").css({ background: "rgba(63,148,227,0.8)" });
         }
      });
   }

   /**
    * 表示のリセット
    * 
    */
   function restElem() {
      $("#ddSch").hide();
      $("#ddPht").hide();
      $(".ddmenu").css({ background: "rgba(63,148,227,0.8)" });
   }
});
