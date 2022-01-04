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
         addNum: [], // 追加分の数を数える値

         // checkboxのbind
         isChecked: false,
      },
      created: function () {
         // console.log('--- created app.js ---');
         // console.log(this.url);
         this.getList();
      },
      mouted: function () {
         // console.log('--- mounted app.js ---');
         // console.log(token);
         // console.log(root);
      },
      updated: function () {
         // console.log('--- updated app.js ---');
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
          * 登録済のリストのチェックを一括で反転させる
          * @param {*} e 
          */
         onIsChecked: function (e) {
            // v_checkedの値を編集
            // 記録用にkey,valueの書き方で書いてるだけで意味はない
            for (var [key, val] of this.lists.entries()) {
               if (!this.isChecked) {
                  val.v_checked = true;
               } else {
                  val.v_checked = false;
               }
            }

            // isCheckedの値を編集
            if (!this.isChecked) {
               this.isChecked = true
            } else {
               this.isChecked = false
            }
         },

         /**
          * submit
          */
         submitList: function (e) {
            var valid;
            // for (var val, i of this.lists) {
            //    valid = this.validVal(i);
            // }

            // if (valid) {
            const params = new URLSearchParams();

            // tokenとuser_idを保存
            params.append("token", this.token);
            params.append("user_id", this.user_id);

            // 既存の値（更新分）
            for (var i = 0; i < this.lists.length; i++) {
               // 空のtag_nameを編集
               if (this.lists[i].tag_name === "") {
                  // alert("non");
                  this.lists[i].tag_name = "未記入";
               } else {
                  this.lists[i].tag_name = this.lists[i].tag_name;
               }

               // is_checkedの値をdbに保存する値に編集
               if (this.lists[i].v_checked === false) {
                  this.lists[i].is_checked = 0;
               } else {
                  this.lists[i].is_checked = 1;
               }

               // dbに不要なキーを削除
               delete this.lists[i].v_checked;

               // 更新分の値をセット
               // メソッドを作成しているが一度しか使用していないため一旦は使わない
               params.append("tag_name[]", this.lists[i].tag_name);
               params.append("list_name[]", this.lists[i].list_name);
               params.append("is_checked[]", this.lists[i].is_checked);
               // this.setParam(params, i);
            }

            // 追加分
            // 追加されたリストの数
            var count = this.addLists.length;

            // 代入に使用する変数：dbに保存する値に編集するのに使用
            var tagName = [];
            var listName = [];
            var checked = [];

            // エラーメッセージ
            var msg = ["リストが入力されていません。\n新しいタグは追加されませんがよろしいですか？"].join("\n");

            // タイトルのみ入力された場合はアラート：addListsに追加があった場合：追加がないとcountは0のままのためわざわざ作成する
            if (this.addTags[0] !== undefined && this.addLists[0] === undefined) {
               if (!window.confirm(msg)) {
                  e.preventDefault()
               }
            }

            // 追加があった場合
            if (count) {
               // console.log("is new list");
               for (var i = 0; i < count; i++) {
                  // 空のtag_nameを編集
                  if (this.addTags[i] === undefined) {
                     // alert("non");
                     tagName[i] = "未記入";
                  } else {
                     tagName[i] = this.addTags[i];
                  }

                  // 空のlist_nameを編集
                  if (this.addLists[i] === undefined) {
                     // alert("non");
                     listName[i] = "未記入";
                  } else {
                     listName[i] = this.addLists[i];
                  }

                  // is_checkedの値をdbに保存する値に編集
                  if (this.addChecked[i] === true) {
                     checked[i] = 1;
                  } else {
                     checked[i] = 0;
                  }

                  // タイトルのみ入力された場合はアラート：addListsに追加があった場合
                  if (this.addTags[i + 1] !== undefined && this.addLists[i + 1] === undefined) {
                     // alert("bbb");
                     if (!window.confirm(msg)) {
                        e.preventDefault()
                     }
                  }

                  // 追加分の値をセット
                  params.append("tag_name[]", tagName[i]);
                  params.append("list_name[]", listName[i]);
                  params.append("is_checked[]", checked[i]);
               }
            } else {
               // 何もしない：デバッグ用の出力を記述する
               // console.log("non new todo");
            }

            var url = "../../app/api/update_list.php";
            this.postAxios(url, params);
            this.resetVal();
            alert("更新されました");
            // location.reload();
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
               // console.error(e);
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

                  for (var val of this.lists) {
                     // is_checkedの変換
                     if (val.is_checked === "0") {
                        val.v_checked = false;
                     } else {
                        val.v_checked = true;
                     }
                     // tag_nameの変換
                     if (val.tag_name == null) {
                        val.tag_name = "なし";
                     }
                  }

                  // isCheckedの値を編集
                  // 0があればisCheckedをfalseで保存するためbrakeを入れる
                  // 全てが1の場合のみisCheckedをtrueにする
                  for (var val of this.lists) {
                     if (val.is_checked === "0") {
                        this.isChecked = false;
                        break;
                     } else {
                        this.isChecked = true;
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
            this.isChecked = false;
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