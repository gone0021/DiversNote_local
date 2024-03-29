(function () {
   'use strict';

   let app = new Vue({
      el: '#app',
      data: {
         // ページングの判定
         flg_page: false,

         // 表示画面に値を送る用
         next_num: "",
         placeholder_num: "",

         // 画像を取得する際に使用
         url: location.pathname,
         // url: "",

         // price_planから計算
         imgCunt: [],
         imgNum: 0,
         imgNumMax: 0,

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
         mAirRate: "",

         mWaterTemp: "",
         mTemp: "",
         mView: "",
         mWeight: "",

         mComment: "",
         mMap: "",
         mBuddy: "",
         mInstructor: "",
         mInstructorNum: "",
         mNewSigne: "",
         mOldSigne: "",

         mIsOpen: [],
         mOldImg: [],
         mNewImg: [],
         mEditImg: [],
         mDelImg: [],
         mNewImgJson: "",
         mEditImgJson: "",
         mDelImgJson: "",

         mEntryType: "",
         mTankMaterial: "0",
         mIsEnriche: "0",
         mWeather: "",
         mWind: "",
         mCurrent: "",
         mSuitType: "",

         // 値の配列番号：順不同のためインデントでは保存できない
         cntEditImg: 0,
         cntDelImg: 0,
         // submitの状態を保存する変数：送信時の判定に使用
         mSub: "",

         // searchのselect
         schSelect: { "all": "全てから", "title": "タイトル", "dive_date": "日付", "erea_name": "地域", "point_name": "ポイント名", "shop_name": "ショップ名", "buddy_name": "バディ名", "instructor_name": "イントラ名" },
         // schSelect: ["全て","タイトル", "日付", "地域", "ポイント名", "ショップ名", "バディ名", "イントラ名"],

         // searchの検索タイプ
         isSchSelect: "all",
         schType: "all",
         // searchの入力される検索の値
         isSearch: "",

         // photoのselect
         phtUser: { "0": "自分の写真", "1": "全員の公開写真" },
         // phtUser: ["自分の写真", "全員の写真"],
         phtSelect: { "all": "全てから", "title": "タイトル", "dive_date": "日付", "erea_name": "地域", "point_name": "ポイント名" },
         // photoの検索タイプ
         isPhtUser: 0,
         isPhtSelect: "all",
         phtType: "all",
         // photoの入力される検索の値
         isPhoto: "",

         // v-show, v-if
         dispGlay: false,
         dispModal: false,
         dispModalInput: false,
         dispPhoto: false,

         btnNew: false,
         btnUpdate: false,
         btnEdit: false,
         btnDel: false,

         isNew: false,
         isEdit: false,
         isDetail: false,

         isSigne: false,
         // デバッグ用
         // dispGlay: true,
         // dispModal: true,

         // ajax保存用
         items: [],
         itemById: [],
         photos: [],

         // signe（canvas）用
         canvas: null,
         context: null,
         is_draw: false,
         image: null,
         file: null,

      },
      computed: {
         mNewImg() {
            // console.log("--- computed app.js ---");
            return this.mNewImg;
         }
      },

      created: function () {
         // console.log('--- created app.js ---');
         // console.log(php);

         this.getItemPage();
         this.getNextNum();

         this.setImgNummax();
      },
      mouted: function () {
         // console.log('--- mounted app.js ---');
         // console.log(token);
      },
      updated: function () {
         // console.log('--- updated app.js ---');
      },
      methods: {
         // onEsc: function () {
         //    this.resetDisplay();
         //    this.resetVal();
         // },
         onGlay: function () {
            // if (!this.isDetail && (this.mTitle || this.mErea || this.mDiveNum || this.mDiveDate)) {
            // dive_numとdive_dateを自動にしたため条件から削除
            if (!this.isDetail && (this.mTitle || this.mErea)) {
               var msg = ['保存していませんが編集を終了しますか？'].join('\n');
               if (window.confirm(msg)) {
                  this.resetDisplay();
               } else {
                  return false;
               }
            } else {
               // 表示のリセット
               this.resetDisplay();
            }
            // 値のリセット
            this.resetVal();

            // console.log(this.mNewImg);
         },
         onItem: function (e) {
            // console.log(e);
            this.border = "";
            // モーダル出現時に背景をスクロールさせない設定：実行
            this.closeScrollbar();

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
         onNew: function () {
            this.resetVal();
            this.mDiveNum = this.next_num;
            this.mDiveDate = php.date;

            this.isNew = true;
            this.isEdit = false;
            this.isDetail = false;

            this.editBtn(true, false, false, false);
            this.mSub = "new";
            this.dis = false;

            this.dispGlay = true;
            this.dispModalInput = true;

            // inputに下線を入れる
            this.border = "border-bottom : 1px solid #000; border-radius: 0;";
            // this.signeTitleOpen = true;

            // モーダル出現時に背景をスクロールさせない設定：実行
            this.closeScrollbar();
         },
         onColse: function () {
            this.resetDisplay();
            this.resetVal();
         },
         onCancel: function () {
            this.resetDisplay();
            this.resetVal();
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
         onDel: function (e) {
            var msg = "削除してよろしいですか？";
            if (!window.confirm(msg)) {
               e.preventDefault()
            } else {
               const params = new URLSearchParams();
               params.append("token", php.token);
               params.append("id", Number(this.mId));
               params.append("old_signe", this.mOldSigne);

               var url = "../app/api/delete_item.php";
               this.postAxios(url, params);
               this.resetVal();
            }
         },

         /**
          * 画像をリサイズしてアップロードの準備（変数に保存）する
          * @param {*} e 
          * @param {*} i 
          * @returns 
          */
         onFileChange: async function (e, i) {
            // 配列の中身をオブジェクトに指定
            // ionChgIsOpenで設定済の可能性があるためifで変数の有無を見る
            if (!this.mNewImg[i]) {
               this.mNewImg[i] = {};
            }
            // イベントの取得
            let files = e.target.files;

            // ファイルの有無をチェック
            if (files.length === 0) {
               // ファイルがなければ処理を終了
               return
            }

            let file = files[0];
            // console.log(file);

            // 即時関数内で処理するためthisを代入
            let vm = this;
            // filereaderをインスタンス
            const reader = new FileReader()
            const img = new Image();
            let width = 2000;
            reader.onload = async (e) => {
               // imgを読み込んでから画像をリサイズ
               img.onload = () => {
                  // 画像の情報を取得
                  let imgWidth = img.width;
                  let imgHeight = img.height;
                  let imgType = img.src.substring(5, img.src.indexOf(';'));

                  if (imgWidth > width) {
                     // 画像のサイズが大きかったらリサイズして保存
                     imgHeight = Math.round(imgHeight * width / imgWidth);
                     imgWidth = width;

                     // 設定・計算した寸法でcanvasで再描画
                     const imgCanvas = document.createElement('canvas');
                     imgCanvas.width = imgWidth;
                     imgCanvas.height = imgHeight;
                     const ctx = imgCanvas.getContext('2d');
                     ctx.drawImage(img, 0, 0, imgWidth, imgHeight);

                     // 画像をmNewImgに格納
                     this.mNewImg[i].url = imgCanvas.toDataURL(imgType);
                     // this.mNewImg[i].url = imgCanvas.toDataURL("image/png");
                  } else {
                     // 画像のサイズが小さければそのまま保存
                     this.mNewImg[i].url = reader.result;
                  }

                  // numの増減でプレビューが見えるようになる
                  this.imgNum++;
                  this.imgNum--;
               }
               img.src = reader.result;
               // 変数に値を保存
               this.mNewImg[i].name = file.name;
               this.mNewImg[i].type = file.type;
               // 画像が変わった時点でもis_openを取得する
               this.mNewImg[i].is_open = this.mIsOpen[i];

               // vm.mNewImg[i].url = e.target.result;
               // vm.mNewImg[i].url2 = reader.result;
            }

            // FileAPIの起動
            reader.readAsDataURL(file);
            // this.mNewImg = vm.mNewImg;

            // console.log(this.mNewImg);
         },
         /**
          * 新規で登録する画像のis_openを編集
          * @param {*} i 
          */
         onChgIsOpen: function (i) {
            // onFileChangeで設定済の可能性があるためifで変数の有無を見る
            if (!this.mNewImg[i]) {
               this.mNewImg[i] = {};
            }
            this.mNewImg[i].is_open = this.mIsOpen[i];
         },
         /**
          * 保存されている画像のis_openを編集
          * @param {*} id 
          * @param {*} isOpen 
          */
         onEditImage: function (id, isOpen) {
            // 編集する値の配列番号を代入
            // 順不同のためインデントでは保存できない
            let i = this.cntEditImg;
            // 配列の中身をオブジェクトに指定
            this.mEditImg[i] = {};

            // 値を代入
            this.mEditImg[i].id = id;
            this.mEditImg[i].is_open = isOpen;

            // 編集する値の配列番号を+1する
            this.cntEditImg++;

            // console.log(this.mEditImg);
         },
         /**
          * 保存されている画像の削除
          * @param {*} id 
          * @param {*} name 
          */
         onDelImage: function (id, name) {
            // 保存している画像分のmaxが減少しているため削除時にmaxを追加
            this.imgNumMax++;

            // 削除する値の配列番号を代入
            // 順不同のためインデントでは保存できない
            let i = this.cntDelImg;
            // 配列の中身をオブジェクトに指定
            this.mDelImg[i] = {};

            // 保存と削除する値のid一致する配列を削除
            for (var [key, val] of this.mOldImg.entries()) {
               if (val.id == id) {
                  this.mOldImg.splice(key, 1);
                  // console.log(this.mOldImg);
               }
            }

            // 値を代入
            this.mDelImg[i].id = id;
            // 保存している画像を削除する用
            this.mDelImg[i].name = name;

            // 削除する値の配列番号を+1する
            this.cntDelImg++;

            // console.log(this.mDelImg);
         },
         cntUpImg: function () {
            let max = this.imgNumMax;
            // 公開・非公開の値を追加
            this.mIsOpen.push(0);
            // console.log(this.mIsOpen);
            // console.log(this.imgNum);
            // console.log(max);
            if (php.price_plan == 0 || php.price_plan == 1) {
               if (this.imgNum >= max) {
                  alert(
                     "これ以上追加できません。 \n" +
                     "プランを変更してください。"
                  );
                  return false;
               } else {
                  this.imgNum++;
               }
            } else if (php.price_plan == 2) {
               if (this.imgNum >= max) {
                  alert(
                     "これ以上追加できません。 \n" +
                     "プランを変更してください。"
                  );
                  return false;
               } else {
                  this.imgNum++;
               }
            }
            // console.log(this.imgNum);
            // console.log(this.imgNumMax);
         },

         cntDownImg: function () {
            console.log(this.mIsOpen);
            console.log(this.imgNum);

            if (this.imgNum < 1) {
               // console.log("false");
               return false;
            } else {
               this.imgNum--;
               this.mNewImg.splice(this.imgNum, 1);
            }
            // console.log(this.imgNum);
            // console.log(this.mNewImg);
         },
         checkImg: function () {
            this.imgNum++;
            this.imgNum--;
            // console.log(this.mNewImg);
         },

         /**
          * 空気消費率の計算
          * @returns 
          */
         onCalcAirRate: function () {
            console.log("calc");
            let flg = 0;
            if (!this.mStartAir) {
               alert("開始残圧の入力がありません。");
               flg = 1;
            }
            if (!this.mEndAir) {
               alert("終了残圧の入力がありません。");
               flg = 1;
            }
            if (!this.mTankSize) {
               alert("タンク容量が選択されていません。");
               flg = 1;
            }
            if (!this.mTankSize) {
               alert("タンク容量が選択されていません。");
               flg = 1;
            }
            if (!this.mStartTime) {
               alert("開始時間の入力がありません。");
               flg = 1;
            }
            if (!this.mEndTime) {
               alert("終了時間の入力がありません。");
               flg = 1;
            }
            if (!this.mAvgDepth) {
               alert("平均深度の入力がありません。");
               flg = 1;
            }

            if (flg == 0) {
               let [from_hour, from_minute] = this.mStartTime.split(':')
               let [to_hour, to_minute] = this.mEndTime.split(':')
               let time = (to_hour - from_hour) * 60 + (to_minute - from_minute);

               let cal1 = (this.mStartAir - this.mEndAir) * this.mTankSize;
               let cal2 = time * (this.mAvgDepth * 0.1 + 1)

               this.mAirRate = Math.round(cal1 / cal2 * 100) / 100;
            } else {
               return false;
            }
         },

         /**
          * 空気消費率のリセット（ボタン）
          */
         onResetAirRate: function () {
            this.mAirRate = "";
         },

         onSubmit: function () {
            var valid = this.validVal();

            if (valid) {
               const params = new URLSearchParams();

               // mEditImgの配列を逆順にしてから重複を削除
               // filterで重複を検索してfilterIndexの値を返している
               this.mEditImg = this.mEditImg.reverse().filter((val, index, arr) => {
                  return arr.findIndex(v => val.id === v.id) === index
               });

               // imgファイルをjson形式に整形して変数に保存
               // ：setParamでxxxJsonをセットしている
               this.mNewImgJson = JSON.stringify(this.mNewImg);
               this.mEditImgJson = JSON.stringify(this.mEditImg);
               this.mDelImgJson = JSON.stringify(this.mDelImg);

               // console.log(this.mNewImgJson);
               // console.log(this.mEditImgJson);
               // console.log(this.mDelImgJson);

               // パラメータをセット
               this.setParam(params);

               if (this.mSub === "new") {
                  // insert
                  // console.log("store");

                  var url = "../app/api/store_item.php";
                  // set params
                  this.postAxios(url, params);
               } else if (this.mSub === "edit") {
                  // update
                  // console.log("update");

                  var url = "../app/api/update_item.php";
                  // set params
                  this.postAxios(url, params);
               }
               // 値をリセット
               this.resetVal();
            }
         },

         onSigne: function () {
            if (!this.isDetail) {
               this.setCanvas();
            }
         },

         // 検索
         chgSearch: function () {
            if (this.isSchSelect === "all") {
               this.schType = "all";
            } else if (this.isSchSelect === "dive_date") {
               this.schType = "date";
            } else {
               this.schType = "text";
            }
            // console.log(this.isSchSelect);
            // console.log(this.schType);
         },

         onSearch: function () {
            // console.log(this.isSchSelect);
            // console.log(this.isSearch);
            this.dispPhoto = false;

            this.photos = [];
            axios.get(`../app/api/get_item_search.php`, {
               params: {
                  user_id: php.user_id,
                  select: this.isSchSelect,
                  val: this.isSearch,
               },
            }).then(
               function (res) {
                  this.items = res.data;
                  // console.log(this.items);
               }.bind(this)
            ).catch(function (e) {
               // console.log("error");
               console.error(e);
            });

            this.resetVal();
            this.flg_page = false;

         },

         // --- 写真検索 ---
         chgPhtSelect: function () {
            if (this.isPhtSelect === "all") {
               this.phtType = "all";
            } else if (this.isPhtSelect === "dive_date") {
               this.phtType = "date";
            } else {
               this.phtType = "text";
            }
            // console.log(this.isPhtSelect);
            // console.log(this.phtType);
         },

         onPhoto: function () {
            console.log("photo");
            // console.log(this.isSchSelect);
            this.dispPhoto = true;
            // console.log(this.phtUser);

            this.items = [];
            axios.get(`../app/api/get_photo.php`, {
               params: {
                  user_type: this.isPhtUser,
                  user_id: php.user_id,
                  select: this.isPhtSelect,
                  val: this.isPhoto,
               },
            }).then(
               function (res) {
                  this.photos = res.data;
                  // console.log(this.items);
               }.bind(this)
            ).catch(function (e) {
               // console.log("error");
               console.error(e);
            });
            this.resetVal();
            this.flg_page = false;
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
                  this.getItemPage();
               }.bind(this)
            ).catch(function (e) {
               console.error(e);
               alert("申し訳ございませんがエラーが発生しました。\n処理を中断してログインし直してください。");
               this.resetDisplay();
            });
         },

         /**
          * ユーザーに属するアイテムを取得
          * ページング用
          */
         getItemPage: function () {
            axios.get(`../app/api/get_item_page.php`, {
               params: {
                  user_id: php.user_id,
                  page: php.page,
                  row: php.row,
               },
            }).then(
               function (res) {
                  this.items = res.data;
                  // console.log(this.items);
                  this.flg_page = true;
               }.bind(this)
            ).catch(function (e) {
               console.error(e);
            });
         },

         /**
          * ユーザーに属するアイテムを取得
          */
         getItem: function () {
            axios.get(`../app/api/get_item.php`, {
               params: {
                  user_id: php.user_id,
               },
            }).then(
               function (res) {
                  this.items = res.data;
                  // console.log(this.items);
                  this.flg_page = false;
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
                  user_id: php.user_id,
               },
            }).then(
               function (res) {
                  this.items = res.data;
                  // console.log(this.items);
               }.bind(this)
            ).catch(function (e) {
               console.error(e);
            });
         },

         /**
          * idに属するアイテムを取得
          */
         getItemById: function (item_id) {
            axios.get(`../app/api/get_item_by_id.php`, {
               params: {
                  user_id: php.user_id,
                  id: item_id,
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

                  // console.log(this.itemById);
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
         getItemByIdRet: function (item_id) {
            return axios.get(`../app/api/get_item_by_id.php`, {
               params: {
                  user_id: php.user_id,
                  id: item_id,
               },
            }).then(
               function (res) {
                  var val = res.data[0]
                  // console.log(val);
                  this.changeBlankVal(val);
                  this.setVal(val);
                  // val.dive_date = val.dive_date.replace('-', '/');
                  // val.start_time = val.start_time.replace('-', '：');
                  // val.end_time = val.end_time.replace('-', '：');

                  this.itemById = val;
                  // console.log(this.itemById);
                  this.getItemPhoto(item_id);
               }.bind(this)
            ).catch(function (e) {
               console.error(e);
            });
         },

         /**
          * dive_numの最大値を取得
          * @param {*} item_id 
          */
         getItemPhoto: function (item_id) {
            axios.get(`../app/api/get_item_photo.php`, {
               params: {
                  item_id: item_id,
               },
            }).then(
               function (res) {
                  var val = res.data;
                  // console.log(val);
                  this.mOldImg = val;

                  for (var num of this.mOldImg) {
                     this.imgNumMax--;
                  }
                  // console.log(this.imgNum);
               }.bind(this)
            ).catch(function (e) {
               console.error(e);
            });
         },

         /**
          * dive_numの最大値を取得
          */
         getNextNum: function () {
            axios.get(`../app/api/get_nextnum.php`, {
               params: {
                  user_id: php.user_id,
               },
            }).then(
               function (res) {
                  var val = res.data;
                  this.next_num = val;
                  this.placeholder_num = "次は" + val;
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
            // 日付
            if (this.mDiveDate) {
               var date = this.mDiveDate.split("-");
               if (date[0] > 3000) {
                  msg["date"] = "正しい日付を入力してください。 \n";
                  ret++;
               }
            }


            // dive_num
            // if (!this.mDiveNum.match(/^[0-9]*$/)) {
            //    msg["num"] = "・ナンバー（No.）は半角数字でで入力してください。 \n";
            //    ret++;
            // }

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
          * imgNummaxを計算する
          * @returns {void}
          */
         setImgNummax: function () {
            let plan = php.price_plan;
            if (plan == 0) {
               this.imgNumMax = 2;
            } else if (plan == 2) {
               this.imgNumMax = 5;
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
            this.openAccordion(".acdTitleOpen");
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
          * @param {obj} args 
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
            this.mAirRate = args.air_rate;

            this.mTemp = args.temp;
            this.mWaterTemp = args.water_temp;
            this.mView = args.view;

            this.mWeight = args.weight;

            this.mComment = args.comment;
            this.mMap = args.map_link;
            this.mBuddy = args.buddy_name;
            this.mInstructor = args.instructor_name;
            this.mInstructorNum = args.instructor_num;
            if (args.signe == null) {
               this.mOldSigne = null;
            } else {
               this.mOldSigne = args.signe;
            }

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
            this.isSigne = false;

            this.border = "";
            this.signeTitleOpen = false;

            this.mId = "";
            // this.mTitle = "test";
            // this.mDiveNum = "50";
            // this.mDiveDate = "2021-08-08";
            // this.mErea = "test";

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
            this.mAirRate = "";

            this.mTemp = "";
            this.mWaterTemp = "";
            this.mView = "";

            this.mWeight = "";

            this.mComment = "";
            this.mMap = "";
            this.mBuddy = "";
            this.mInstructor = "";
            this.mInstructorNum = "";
            this.mNewSigne = "";
            this.mOldSigne = "";

            this.mIsOpen = [];
            this.mNewImg = [];
            this.mOldImg = [];
            this.mEditImg = [];
            this.mDelImg = [];

            this.cntEditImg = 0;
            this.cntDelImg = 0;

            this.mNewImgJson = "";
            this.mEditImgJson = "";
            this.mDelImgJson = "";

            this.mEntryType = "";

            this.mTankMaterial = "0";
            this.mIsEnriche = "0";

            this.mWeather = "";
            this.mWind = "";
            this.mCurrent = "";

            this.mSuitType = "";

            this.isSchSelect = "all";
            this.schType = "all";
            this.isSearch = "";

            this.imgNum = 0;

            // プランごとの保存imgの最大数を計算
            this.setImgNummax();
            // モーダル出現時に背景をスクロールさせない設定を解除
            this.openScrollbar();

         },

         /**
          * argsの値をチェックして変換する
          * @param {obj} args 
          */
         changeBlankVal: function (args) {
            // nullの設定：個別に対応
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
            params.append("token", php.token);
            params.append("user_id", php.user_id)
            params.append("id", this.mId)
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
            params.append("air_rate", this.mAirRate)
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

            params.append("signe", this.mNewSigne)
            params.append("old_signe", this.mOldSigne)

            params.append('new_img', this.mNewImgJson);
            params.append('edit_img', this.mEditImgJson);
            params.append('del_img', this.mDelImgJson);

            // 変数を上書きせずにxxxJsonで送信する
            // params.append('new_img', this.mNewImg);
            // params.append('del_img', this.mEditImg);
            // params.append('edit_img', this.mDelImg);
         },

         /**
          * アコーディオンを閉じる
          * 開く設定は下部にjqueryで記述している：クラス名判定で楽
          */
         closeAccordion: function (element) {
            $(element).next().slideUp();
            $(element).removeClass("acdOpen");
         },

         /**
          * アコーディオンを開く
          * 開く設定は下部にjqueryで記述している：クラス名判定で楽
          */
         openAccordion: function (element) {
            $(element).next().slideDown();
            $(element).addClass("acdOpen");
         },

         /**
          * スクロールバーを非表示
          */
         closeScrollbar: function () {
            $("html,body").css({
               overflow: "hidden",
               // padding: "0 8px 0 0"
            });
         },

         /**
          * スクロールバーを表示
          */
         openScrollbar: function () {
            $("html,body").css({
               overflow: "visible",
               // padding: "0"
            });
         },

         // --- canvas ---
         // org：初期設定
         setCanvas: function () {
            this.canvas = this.$refs.canvas;
            // console.log(this.canvas);

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
         // canvas部分
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
         // 描画終了（mouseup, mouseout）
         drawEnd: function () {
            this.context.closePath();
            this.is_draw = false;
         },

         // ボタン操作：リセット
         onClear: function () {
            this.isSigne = false;
            this.mNewSigne = "";

            this.context.clearRect(0, 0, this.canvas.width, this.canvas.height);
            this.file = null;
         },
         // ボタン操作：確定
         onSave: function () {
            this.isSigne = true;
            this.mNewSigne = this.canvas.toDataURL("image/png");
            // console.log(this.mNewSigne);
         },
         // ボタン操作：削除
         delSigne: function () {
            this.isSigne = false;
            this.mNewSigne = "delete";

            this.context.clearRect(0, 0, this.canvas.width, this.canvas.height);
            this.file = null;
         },



      },
   });
})();