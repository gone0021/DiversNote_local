(function () {
   'use strict';

   let list = new Vue({
      el: '#list',
      data: {
         // phpからの受け取り：メモ代わり
         user_id: php.user_id,
         price_plan: php.plice_plan,
         token: php.token,

         // ajax保存用
         getLists: [],
         // v-model用
         lists: [],

         // 追加用
         addChecked: [],
         addTags: [],
         addLists: [],
      },
      created: function () {
         console.log('--- created app.js ---');
         // console.log(this.url);
         this.getList();
      },
      mouted: function () {
         console.log('--- mounted app.js ---');
         // console.log(token);
         // console.log(root);
      },
      updated: function () {
         console.log('--- updated app.js ---');
      },
      methods: {
         /**
          * 対象の配列を削除
          */
         onDel: function (n) {
            this.lists.splice(n, 1);
            // console.log(this.lists);
         },
         /**
          * 対象の配列を削除
          */
         onDeladd: function (n) {
            this.addTags.splice(n, 1);
            this.addLists.splice(n, 1);
            this.addChecked.splice(n, 1);
         },

         /**
          * 値をリセット
          */
         onReset: function () {
            this.getList();
            this.resetVal();
         },

         /**
          * submit
          */
         submitList: function () {
            var valid;
            // for (var val, i of this.lists) {
            //    valid = this.validVal(i);
            // }

            // if (valid) {
            const params = new URLSearchParams();

            params.append("token", this.token);
            params.append("user_id", this.user_id);
            for (var i = 0; i < this.lists.length; i++) {
               if (this.lists[i].v_checked === false) {
                  this.lists[i].is_checked = 0;
               } else {
                  this.lists[i].is_checked = 1;
               }
               // dbに不要なキーを削除
               delete this.lists[i].v_checked;

               this.setParam(params, i);
            }

            // 追加分
            var tagName = [];
            var checked = [];
            if (this.addLists.length) {
               // console.log("is new todo");
               for (var i = 0; i < this.addLists.length; i++) {
                  // tag_nameの値
                  if (this.addTags[i] === undefined) {
                     // alert("non");
                     tagName[i] = "なし";
                  } else {
                     tagName[i] = this.addTags[i];
                  }

                  // is_checkedの値
                  if (this.addChecked[i] === true) {
                     checked[i] = 1;
                  } else {
                     checked[i] = 0;
                  }

                  params.append("tag_name[]", tagName[i]);
                  params.append("list_name[]", this.addLists[i]);
                  params.append("is_checked[]", checked[i]);
               }
            } else {
               // 何もしない：デバッグ用の出力
               // console.log("non new todo");
            }

            var url = "../../app/api/update_list.php";
            this.postAxios(url, params);
            this.resetVal();
            alert("更新されました");
            // }
         },


         // --- method ---
         /**
          * axiosでpostする
          * @returns axios
          */
         postAxios: function (url, params) {
            axios.post(url, params).then(
               function (res) {
                  // console.log(res.data);
                  // 値の再取得
                  this.getList();
               }.bind(this)
            ).catch(function (e) {
               console.error(e);
               alert("入力に不備がありました。");
            });
         },

         /**
          * ユーザーに属するアイテムを取得
          */
         getList: function () {
            axios.get(`../../app/api/get_list.php`, {
               params: {
                  user_id: this.user_id,
               },
            }).then(
               function (res) {
                  this.getLists = res.data;
                  this.lists = res.data;

                  for (var i = 0; i < this.lists.length; i++) {
                     // is_checkedの変換
                     if (this.lists[i].is_checked === "0") {
                        this.lists[i].v_checked = false;
                     } else {
                        this.lists[i].v_checked = true;
                     }
                     // tag_nameの変換
                     if (this.lists[i].tag_name == null) {
                        this.lists[i].tag_name = "なし";
                     }
                  }
                  // console.log(this.lists);

               }.bind(this)
            ).catch(function (e) {
               console.error(e);
            });
         },

         /**
          * 入力のバリデーション
          * @returns bool
          */
         validVal: function (i) {
            var ret = 0;
            var msg = [];
            var disp = "";

            // 空文字のバリデーション（NN項目）
            if (this.lists[i].tag_name.length > 2) {
               msg["title"] = "・50文字以内で入力してください。 \n";
               ret++;
            }
            if (!this.mDiveDate) {
               msg["date"] = "・日付が入力されていません。 \n";
               ret++;
            }
            if (!this.mDiveNum) {
               msg["num"] = "・ナンバー（No.）が入力されていません。 \n";
               ret++;
            }

            // msg配列を表示する文字列にまとめる
            for (var key in msg) {
               disp += msg[key];
            }

            // バリデーションを出力
            if (!ret) {
               // alert("true");
               return true;
            } else {
               alert(disp);
               return false;
            }
         },

         /**
          * v-model用変数の値を空にする
          */
         resetVal: function () {
            this.addTags = [];
            this.addLists = [];
            this.addChecked = [];
         },

         /**
          * パラメータをセット
          */
         setParam(params, i) {
            params.append("tag_name[]", this.lists[i].tag_name);
            params.append("list_name[]", this.lists[i].list_name);
            params.append("is_checked[]", this.lists[i].is_checked);
         },
      },
   });
})();