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
    */
   function naviForm(id, btn, flg, hide) {
      // click時
      onClickNaviForm(id, flg);
      // submit時
      onSubmitkNaviForm(btn);
      // hover時
      onHoverNaviForm(id, flg);
      // 異なるナビバーのFormにhoverした時
      onHoverOthereNaviForm(id, hide);
   }

   /**
    * ナビバーのForm箇所をクリックした時
    */
   function onClickNaviForm(id, flg) {
      // click時
      $(id).on('click', function (e) {
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
    */
   function onHoverNaviForm(id, flg) {
      $(id).on({
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
    */
   function onHoverOthereNaviForm(id, hide) {
      $(id).on('mouseenter', function () {
         $(hide).hide();
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
