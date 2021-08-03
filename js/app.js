(function () {
   'use strict';

   let app = new Vue({
      el: '#app',
      data: {
         // phpからの受け取り
         user_id: user_id,
         // next_num: "次は" + next_num,
         next_num: "",

         // html属性
         dis: true,
         signeTitleOpen: false,

         // style
         border: "",

         // セレクトボックス用配列
         arrEntryType: ["ボート", "ビーチ"],
         arrTankMaterial: ["スチール", "アルミ",],
         arrIsEnriche: ["no", "yes",],
         arrWeather: ["晴れ", "曇り", "雨", "雪", "その他",],
         arrWind: ["弱", "中", "強",],
         arrCurrent: ["弱", "中", "強",],
         arrSuitType: ["ワンピース", "ツーピース", "ドライ", "セミドライ", "水着", "その他",],

         // v-model（edit）用
         mId: "",
         mTitle: "",
         mDiveNum: "",
         mDiveDate: "",
         mErea: "",
         mShopName: "",
         mPointName: "",
         mStartTime: "",
         mEndTime: "",
         mMaxDepth: "",
         mAvgDepth: "",
         mTankSize: "10",
         mStartAir: "",
         mEndAir: "",
         mWaterTemp: "",
         mTemp: "",
         mView: "",
         mWeight: "",
         mComment: "",
         mMap: "",
         mBuddy: "",
         mInstructor: "",
         mInstructorNum: "",
         mSigne: "",

         mEntryType: "",
         mTankMaterial: "0",
         mIsEnriche: "0",
         mWeather: "",
         mWind: "",
         mCurrent: "",
         mSuitType: "",

         mSub: "",

         // search
         schSelect: { 'all': '全てから', 'title': 'タイトル', 'dive_date': '日付', 'erea_name': '地域', 'point_name': 'ポイント名', 'shop_name': 'ショップ名', 'buddy_name': 'バディ名', 'instructor_name': 'イントラ名' },
         // schSelect: ['全て','タイトル', '日付', '地域', 'ポイント名', 'ショップ名', 'バディ名', 'イントラ名'],
         isSelect: "all",
         schType: "all",
         isSearch: "",

         // v-show, v-if
         dispGlay: false,
         dispModal: false,
         dispModalInput: false,

         btnNew: false,
         btnUpdate: false,
         btnEdit: false,
         btnDel: false,

         isNew: false,
         isEdit: false,
         isDetail: false,

         isImage: false,
         // デバッグ用
         // dispGlay: true,
         // dispModal: true,

         // ajax保存用
         items: [],
         itemById: [],

         root: "",



         canvas: null,
         context: null,
         is_draw: false,
         image: null,
         file: null,
         mSigne: '',

      },
      created: function () {
         console.log('--- created app.js ---');
         // console.log(next_num);
         // console.log(this.arrEntryType);
         this.getItem();
         this.getNextNum();
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
         onGlay: function () {
            // console.log("glay");
            if (!this.isDetail && (this.mTitle || this.mDiveDate || this.mDiveNum || this.mErea)) {
               var message = [
                  '保存しますか？'
               ].join('\n')
               if (!window.confirm(message)) {
                  this.resetDisplay();
               } else {
                  this.onSubmit();
               }
            } else {
               this.resetDisplay();
            }
         },
         onNew: function () {
            this.isNew = true;
            this.isEdit = false;
            this.isDetail = false;

            this.mSub = "new";
            this.resetVal();
            this.editBtn(true, false, false, false);
            this.dis = false;

            this.dispGlay = true;
            this.dispModalInput = true;

            this.border = "border-bottom : 1px solid #000; border-radius: 0;";
            // this.signeTitleOpen = true;
         },
         onItem: function (e) {
            // console.log(e);
            this.border = "";

            this.getItemByIdRet(e).then(() => {
               this.isNew = false;
               this.isEdit = false;
               this.isDetail = true;

               this.mSub = "edit";
               this.editBtn(false, false, true, true);
               this.dispGlay = true;
               // this.dispModal = true;
               this.dispModalInput = true;
            });
            // this.getItemById(this.itemById.id);
         },
         onStore: function () {

         },
         onEdit: function () {
            this.isNew = false;
            this.isEdit = true;
            this.isDetail = false;

            this.editBtn(false, true, false, false);
            this.dis = false;
            this.border = "border-bottom : 1px solid #000; border-radius: 0;";

            this.closeAccordion("#signeTitle");
         },
         onUpdate: function () {
            console.log("update");

            if (this.mTitle && this.mDiveDate && this.mDiveNum && this.mErea) {

               let params = new URLSearchParams();

               this.setParam(params);
               console.log(params);

               var url = "../app/api/update_item.php";
               // set params
               this.postAxios(url, params);

            } else {
               alert("入力に不備があります。");
            }
         },
         onSubmit: function () {
            var valid = this.validVal();

            if (valid) {
               let params = new URLSearchParams();
               this.setParam(params);

               if (this.mSub === "new") {
                  // insert
                  console.log("store");

                  var url = "../app/api/store_item.php";
                  // set params
                  this.postAxios(url, params);
               } else if (this.mSub === "edit") {
                  // update
                  console.log("update");

                  var url = "../app/api/update_item.php";
                  // set params
                  this.postAxios(url, params);
               }
               this.resetDisplay();
            }
         },
         onDel: function (e) {
            var message = ["削除してよろしいですか？"].join("\n")
            if (!window.confirm(message)) {
               e.preventDefault()
            } else {
               let params = new URLSearchParams();
               params.append("id", Number(this.mId))

               var url = "../app/api/delete_item.php";
               this.postAxios(url, params);
            }
         },

         onSigne: function () {
            if (!this.isDetail) {
               this.setCanvas();
            }
         },

         chgSearch: function () {
            if (this.isSelect === "all") {
               this.schType = "all";
            } else if (this.isSelect === "dive_date") {
               this.schType = "date";
            } else {
               this.schType = "text";
            }
            console.log(this.isSelect);
            console.log(this.schType);
         },

         onSearch: function () {
            console.log(this.isSelect);
            console.log(this.isSearch);

            axios.get(`../app/api/get_item_search.php`, {
               params: {
                  user_id: this.user_id,
                  search: this.isSelect,
                  val: this.isSearch,
               },
            }).then(
               function (res) {
                  this.items = res.data;
                  console.log(this.items);
               }.bind(this)
            ).catch(function (e) {
               console.log("error");
               console.error(e);
            });
            this.resetVal();
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
                  // 表示を戻す
                  this.resetDisplay();
                  // // アイテムの一覧を読み込んでから整列させる
                  this.getNextNum();
                  this.getItem();
               }.bind(this)
            ).catch(function (e) {
               console.error(e);
               alert("入力に不備がありました。");
               this.resetDisplay();
            });
         },

         /**
          * ユーザーに属するアイテムを取得
          */
         getItem: function () {
            axios.get(`../app/api/get_item.php`, {
               params: {
                  user_id: this.user_id,
               },
            }).then(
               function (res) {
                  this.items = res.data;
                  console.log(this.items);
               }.bind(this)
            ).catch(function (e) {
               console.error(e);
            });
         },
         /**
          * ユーザーに属するアイテムを取得
          * thenをreturnする
          * @returns 
          */
         getItemRet: function () {
            return axios.get(`../app/api/get_item.php`, {
               params: {
                  user_id: this.user_id,
               },
            }).then(
               function (res) {
                  this.items = res.data;
                  console.log(this.items);
               }.bind(this)
            ).catch(function (e) {
               console.error(e);
            });
         },

         /**
          * idに属するアイテムを取得
          */
         getItemById: function (id) {
            axios.get(`../app/api/get_item_by_id.php`, {
               params: {
                  user_id: this.user_id,
                  id: id,
               },
            }).then(
               function (res) {
                  var val = res.data[0]
                  this.changeBlankVal(val);
                  this.setVal(val);

                  // val.dive_date = val.dive_date.replace('-', '/');
                  // val.start_time = val.start_time.replace('-', '：');
                  // val.end_time = val.end_time.replace('-', '：');

                  this.itemById = val;

                  console.log(this.itemById);
               }.bind(this)
            ).catch(function (e) {
               console.error(e);
            });
         },
         /**
          * idに属するアイテムを取得
          * thenをreturnする
          * @returns 
          */
         getItemByIdRet: function (id) {
            return axios.get(`../app/api/get_item_by_id.php`, {
               params: {
                  user_id: this.user_id,
                  id: id,
               },
            }).then(
               function (res) {
                  var val = res.data[0]
                  console.log(val);
                  this.changeBlankVal(val);
                  this.setVal(val);
                  // val.dive_date = val.dive_date.replace('-', '/');
                  // val.start_time = val.start_time.replace('-', '：');
                  // val.end_time = val.end_time.replace('-', '：');

                  this.itemById = val;
                  // console.log(this.itemById);
               }.bind(this)
            ).catch(function (e) {
               console.error(e);
            });
         },

         /**
          * dive_numの最大値を取得
          * @param {*} id 
          */
         getNextNum: function () {
            axios.get(`../app/api/get_nextnum.php`, {
               params: {
                  user_id: this.user_id,
               },
            }).then(
               function (res) {
                  var val = res.data;
                  this.next_num = "次は" + val;
                  // console.log(val);
               }.bind(this)
            ).catch(function (e) {
               console.error(e);
            });
         },

         /**
          * 入力のバリデーション
          * @returns bool
          */
         validVal: function () {
            var ret = 0;
            var msg = [];
            var disp = "";

            // 空文字のバリデーション（NN項目）
            if (!this.mTitle) {
               msg["title"] = "・タイトルが入力されていません。 \n";
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
            if (!this.mErea) {
               msg["erea"] = "・地域が入力されていません。 \n";
               ret++;
            }

            // その他のバリデーション
            if (!this.mDiveNum.match(/^[0-9]*$/)) {
               msg["num"] = "・ナンバー（No.）は半角数字でで入力してください。 \n";
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
          * 表示を戻す
          * モーダル、アコーディオン、ボタン
          */
         resetDisplay: function () {
            this.dis = true;

            this.dispGlay = false;
            this.dispModal = false;
            this.dispModalInput = false;
            this.editBtn(false, false, false, false);
            this.closeAccordion(".acdTitle");
         },

         /**
          * btnの正否を編集する
          * @param {boolean}  n new
          * @param {boolean}  u update
          * @param {boolean}  e edit
          * @param {boolean}  d delete
          */
         editBtn: function (n, u, e, d) {
            this.btnNew = n;
            this.btnUpdate = u;
            this.btnEdit = e;
            this.btnDel = d;
         },

         /**
          * v-model用変数に値を代入
          * @param {Array} args 
          */
         setVal: function (args) {
            // v-model（edit）用
            // input text
            this.mId = args.id;
            this.mTitle = args.title;
            this.mDiveNum = args.dive_num;
            this.mDiveDate = args.dive_date;
            this.mErea = args.erea_name;

            this.mPointName = args.point_name;
            this.mShopName = args.shop_name;
            this.mStartTime = args.start_time;
            this.mEndTime = args.end_time;
            this.mMaxDepth = args.max_depth;
            this.mAvgDepth = args.avg_depth;

            this.mTankSize = args.tank_size;
            this.mStartAir = args.start_air;
            this.mEndAir = args.end_air;

            this.mTemp = args.temp;
            this.mWaterTemp = args.water_temp;
            this.mView = args.view;

            this.mWeight = args.weight;

            this.mComment = args.comment;
            this.mMap = args.map_link;
            this.mBuddy = args.buddy_name;
            this.mInstructor = args.instructor_name;
            this.mInstructorNum = args.instructor_num;
            this.mSigne = args.signe;

            // select
            this.mEntryType = args.entry_type;

            this.mTankMaterial = args.tank_material;
            this.mIsEnriche = args.is_enriche;

            this.mWeather = args.weather;
            this.mWind = args.wind;
            this.mCurrent = args.current;

            this.mSuitType = args.suit_type;
         },

         /**
          * v-model用変数の値を空にする
          */
         resetVal: function () {
            this.isNew = false;
            this.isDetail = false;
            this.isEdit = false;
            this.isImage = false;

            this.border = "";
            this.signeTitleOpen = false;

            this.mId = "";
            this.mTitle = "";
            this.mDiveNum = "";
            this.mDiveDate = "";
            this.mErea = "";

            this.mPointName = "";
            this.mShopName = "";
            this.mStartTime = "";
            this.mEndTime = "";
            this.mMaxDepth = "";
            this.mAvgDepth = "";

            this.mTankSize = "10";
            this.mStartAir = "";
            this.mEndAir = "";

            this.mTemp = "";
            this.mWaterTemp = "";
            this.mView = "";

            this.mWeight = "";

            this.mComment = "";
            this.mMap = "";
            this.mBuddy = "";
            this.mInstructor = "";
            this.mInstructorNum = "";
            this.mSigne = "";

            this.mEntryType = "";

            this.mTankMaterial = "0";
            this.mIsEnriche = "0";

            this.mWeather = "";
            this.mWind = "";
            this.mCurrent = "";

            this.mSuitType = "";

            this.isSelect = "all";
            this.schType = "all";
            this.isSearch = "";
         },

         /**
          * argsの値をチェックして変換する
          * @param {obj} args 
          */
         changeBlankVal: function (args) {
            // nullの設定
            // placeholderで対応
            // for (var v in args) {
            //    // console.log(args[v]);
            //    if (args[v] == null) {
            //       args[v] = "---";
            //    }
            // }
            if (args.entry_type == null) {
               args.entry_type = "";
            }
            if (args.tank_material == null) {
               args.tank_material = "";
            }
            if (args.is_enriche == null) {
               args.is_enriche = "";
            }
            if (args.weather == null) {
               args.weather = "";
            }
            if (args.wind == null) {
               args.wind = "";
            }
            if (args.current == null) {
               args.current = "";
            }
            if (args.suit_type == null) {
               args.suit_type = "";
            }
         },

         /**
          * パラメータをセット
          */
         setParam(params) {
            params.append("id", Number(this.mId))
            params.append("user_id", this.user_id)
            params.append("title", this.mTitle)
            params.append("dive_date", this.mDiveDate)
            params.append("dive_num", this.mDiveNum)
            params.append("erea_name", this.mErea)
            params.append("point_name", this.mPointName)
            params.append("shop_name", this.mShopName)
            params.append("entry_type", this.mEntryType)
            params.append("start_time", this.mStartTime)
            params.append("end_time", this.mEndTime)

            params.append("avg_depth", this.mAvgDepth)
            params.append("max_depth", this.mMaxDepth)

            params.append("tank_material", this.mTankMaterial)
            params.append("tank_size", this.mTankSize)
            params.append("start_air", this.mStartAir)
            params.append("end_air", this.mEndAir)
            params.append("is_enriche", this.mIsEnriche)

            params.append("temp", this.mTemp)
            params.append("water_temp", this.mWaterTemp)
            params.append("weather", this.mWeather)
            params.append("wind", this.mWind)
            params.append("current", this.mCurrent)
            params.append("view", this.mView)

            params.append("suit_type", this.mSuitType)
            params.append("weight", this.mWeight)
            params.append("comment", this.mComment)
            params.append("map_link", this.mMap)
            params.append("buddy_name", this.mBuddy)
            params.append("instructor_name", this.mInstructor)
            params.append("instructor_num", this.mInstructorNum)

            params.append("signe", this.mSigne)
         },

         /**
          * アコーディオンを全て閉じる
          * 開く設定は下部にjqueryで記述している：クラス名判定で楽
          */
         closeAccordion: function (element) {
            $(element).next().slideUp();
            $(".acdTitle").removeClass("open");
         },


         // --- canvas ---
         // org：初期設定
         setCanvas: function () {
            this.canvas = this.$refs.canvas;
            console.log(this.canvas);

            // let width = this.canvas.parentElement.clientWidth;
            let width = 640;
            let height = 150;
            this.canvas.width = width;
            this.canvas.height = height;

            // 描画設定
            this.context = this.canvas.getContext("2d");

            this.context.lineCap = "round";
            this.context.lineJoin = "round";
            this.context.lineWidth = 3;
            this.context.strokeStyle = "#000";

            this.image = new Image();
         },


         draw: function (e) {
            var x = e.layerX;
            var y = e.layerY;

            if (!this.is_draw) {
               return;
            }

            this.context.lineTo(x, y);
            this.context.stroke();
         },
         // 描画開始（mousestart）
         drawStart: function (e) {
            var x = e.layerX;
            var y = e.layerY;

            this.context.beginPath();
            this.context.lineTo(x, y);
            this.context.stroke();

            this.is_draw = true;
         },
         // 描画開始（touchstart）
         drawTouchStart: function (e) {
            let position = this.getPosition(e);

            this.context.beginPath();
            this.context.lineTo(position.x, position.y);
            this.context.stroke();

            this.is_draw = true;
         },
         drawTouch: function (e) {
            e.preventDefault();

            let position = this.getPosition(e);

            if (!this.is_draw) {
               return;
            }

            this.context.lineTo(position.x, position.y);
            this.context.stroke();
         },
         // 描画終了（mouseup, mouseout）
         drawEnd: function () {
            this.context.closePath();
            this.is_draw = false;
         },
         onClear: function () {
            this.isImage = false;
            let width = this.canvas.parentElement.clientWidth;
            let height = 220;
            this.context.clearRect(0, 0, this.canvas.width, this.canvas.height);

            this.file = null;
            this.mSigne = '';
         },
         onSave: function () {
            this.isImage = true;
            this.mSigne = this.canvas.toDataURL("image/png");
            console.log(this.mSigne);


            // いらん気がする
            // let canvas = this.canvas.toDataURL("image/png");
            // console.log(canvas);

            // // Data URLからBase64のデータ部分のみを取得
            // let base64Data = canvas.split(",")[1];
            // let data = window.atob(base64Data); // base64形式の文字列をデコード
            // let buff = new ArrayBuffer(data.length);
            // let arr = new Uint8Array(buff);
            // let dataLength = data.length;
            // for (let i = 0; i < dataLength; i++) {
            //    arr[i] = data.charCodeAt(i);
            // }
            // this.file = new File([arr], "draw-image.png", { type: "image/png" });
            // var reader = new FileReader();
            // var self = this;
            // reader.readAsDataURL(this.file),
            //    reader.onload = function (e) {
            //       let base="";
            //       base = reader.result;
            //       // self.mSigne = base;
            //       console.log(base);

            //    }

            // self.mSigne = base.replace(/^data:image\/png;base64,/, '');
            // this.mSigne = canvas.replace(canvas, 'testimg.png');
            // console.log(this.mSigne);


         },


         getPosition: function (event) {
            var mouseX =
               event.touches[0].clientX - event.target.getBoundingClientRect().left;
            var mouseY =
               event.touches[0].clientY - event.target.getBoundingClientRect().top;

            return {
               x: mouseX,
               y: mouseY
            };
         },


         // 画像のアップロード
         uploadFile: function (event) {
            var self = this;
            var file = event.target.files[0];

            var reader = new FileReader();
            reader.readAsDataURL(file),
               reader.onload = function (e) {
                  self.image.src = reader.result;
               }

            this.image.onload = function (event) {
               self.context.drawImage(
                  this,
                  0,
                  0,
                  self.canvas.width,
                  self.canvas.height
               );
            }
         },


         getBase64(file) {
            return new Promise((resolve, reject) => {
               const reader = new FileReader()
               reader.readAsDataURL(file)
               reader.onload = () => resolve(reader.result)
               reader.onerror = error => reject(error)
            })
         },
         onChgImg: function (e) {
            console.log(e);
            const images = e.target.files || e.dataTransfer.files
            this.getBase64(images[0])
               .then(image => this.avatar = image)
               .catch(error => this.setError(error, '画像のアップロードに失敗しました。'))
         },
         upload() {
            if (this.avatar) {
               /* postで画像を送る処理をここに書く */
               this.message = 'アップロードしました'
               this.error = ''
            } else {
               this.error = '画像がありません'
            }
         },

      },
   });
})();

// アコーディオン
$(function () {
   // toggle非推奨
   // var flg = 0;
   // $(".acdTitle").on("click", function () {
   //    if (flg == 0) {
   //       $(this).next().slideDown(200);
   //       $(this).addClass("open");
   //       flg = 1;
   //    } else {
   //       $(this).next().slideUp(200);
   //       $(this).removeClass("open");
   //       flg = 0;
   //    }
   // });

   $(".acdTitle").on("click", function () {
      console.log("toggle");
      $(this).next().slideToggle(200);
      $(this).toggleClass("open");
   });

   // $("#glayLayer").on("click", function () {
   //    $(".acdTitle").next().slideUp();
   //    $(".acdTitle").removeClass("open");
   // });
});