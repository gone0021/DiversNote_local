<transition name="fadeGlay">
   <div id="glayLayer" v-show="dispGlay" @click="onGlay" transition="fade" @keyup.esc="onEsc()"></div>
</transition>

<transition name="fade">

   <form @submit.prevent="onSubmit()" enctype="multipart/form-data">
      <div class="mdlBox ui-widget-content" v-show="dispModalInput" @keyup.esc="onEsc()">
         <!-- タイトル部分 -->
         <div id="mdlTop">
            <div class="mdlTopGrid">
               <div class="mdlBtn">
                  <template v-if="btnNew">
                     <input type="submit" :name="mSub" class="btn mr-2 my-2" value="登録" />
                  </template>

                  <templatev v-if="btnUpdate">
                     <input type="submit" :name="mSub" class="btn mr-2 my-2" value="更新" />
                  </templatev>

                  <template v-if="btnNew || btnUpdate">
                     <button type="button" class="btn mr-2 my-2" @click="onCancel">キャンセル</button>
                  </template>

                  <template v-if="btnEdit">
                     <button type="button" class="btn mr-2 my-2" @click="onEdit">編集</button>
                  </template>
                  <template v-if="btnDel">
                     <button type="button" class="btn mr-2 my-2" @click="onDel">削除</button>
                  </template>
               </div>

               <div class="mdlTitle">
                  <label>タイトル：
                     <input type="text" name="title" id="" class="mTitle" v-model="mTitle" :disabled="dis" placeholder="未入力" required>
                  </label>
               </div>
            </div>
         </div>

         <!-- 幅の調整 -->
         <div id="adjTop"></div>

         <!-- アイテム詳細 -->
         <div class="acdTitleOpen acdOpen">基本情報1</div>
         <div class="acdOpen">
            <div class="mdlGroup">
               <div id="number" class="my-1">
                  <label>No.
                     <input type="number" name="dive_num" id="" class="" v-model="mDiveNum" :disabled="dis" :style="border" :placeholder="next_num" required>
                  </label>
               </div>

               <div id="date" class="my-1">
                  <label>日付：
                     <input type="date" name="dive_date" id="" class="" v-model="mDiveDate" :disabled="dis" :style="border" required>
                  </label>
               </div>
            </div>

            <div class="mdlGroup">
               <div id="number" class="my-1">
                  <label>地域：
                     <input type="text" name="erea_name" id="" class="" v-model="mErea" :disabled="dis" :style="border" placeholder="未入力" required>
                  </label>
               </div>
               <div id="poit" class=" my-1">
                  <label>ポイント名：
                     <input type="text" name="point_name" id="" class="" v-model="mPointName" :disabled="dis" :style="border" placeholder="未入力">
                  </label>
               </div>
            </div>
         </div>

         <!-- 最初から表示 -->
         <div class="acdTitle">基本情報2</div>
         <div class="acdItem">
            <div class="mdlGroup">

               <div id="shop" class="">
                  <label>ショップ名：
                     <input type="text" name="shop_name" id="" class="" v-model="mShopName" :disabled="dis" :style="border" placeholder="未入力">
                  </label>
               </div>
               <div id="entryType">
                  <label>エントリー：
                     <select name="entry_type" id="" class="" v-model="mEntryType" :disabled="dis" :style="border">
                        <option value="" selected>---</option>
                        <option v-for="(entry,i) in arrEntryType" :value="i">
                           {{ entry }}
                        </option>
                     </select>
                  </label>
               </div>
            </div>

            <div class="mdlGroup">
               <div id="startTime" class=" my-1">
                  <label>開始時間：
                     <input type="time" name="start_time" id="" class="" v-model="mStartTime" :disabled="dis" :style="border">
                  </label>
               </div>
               <div id="endtime" class=" my-1">
                  <label>終了時間：
                     <input type="time" name="end_time" id="" class="" v-model="mEndTime" :disabled="dis" :style="border">
                  </label>
               </div>
            </div>
            <div class="mdlGroup">
               <div id="startTime" class=" my-1">
                  <label>最大水深 (m)：
                     <input type="text" name="max_depth" id="" class="" v-model="mMaxDepth" :disabled="dis" :style="border" placeholder="未入力">
                  </label>
               </div>
               <div id="endtime" class=" my-1">
                  <label>平均水深 (m)：
                     <input type="text" name="avg_depth" id="" class="" v-model="mAvgDepth" :disabled="dis" :style="border" placeholder="未入力">
                  </label>
               </div>
            </div>
         </div>

         <div class="acdTitle">タンク類</div>
         <div class="acdItem">
            <div class="mdlGroup">
               <div id="tankMaterial" class=" my-1">
                  <label>タンク素材：
                     <select name="tank_material" id="" class="" v-model="mTankMaterial" :disabled="dis" :style="border">
                        <option value="" selected>---</option>
                        <option v-for="(tank,i) in arrTankMaterial" :value="i">
                           {{ tank }}
                        </option>
                     </select>
                  </label>
               </div>

               <div id="tankSize" class=" my-1">
                  <label>タンク容量 (L)：
                     <input type="number" name="tank_size" id="" class="" v-model="mTankSize" :disabled="dis" :style="border" placeholder="未入力">
                  </label>
               </div>
            </div>

            <div class="mdlGroup">
               <div id="enrche" class=" my-1">
                  <label>エンリッチ：
                     <select name="is_enriche" id="" class="" v-model="mIsEnriche" :disabled="dis" :style="border">
                        <option value="" selected>---</option>
                        <option v-for="(enriche,i) in arrIsEnriche" :value="i">
                           {{ enriche }}
                        </option>
                     </select>
                  </label>
               </div>
            </div>

            <div class="mdlGroup">
               <div id="startAir" class=" my-1">
                  <label>開始残圧 (bar)：
                     <input type="number" name="start_air" id="" class="" v-model="mStartAir" :disabled="dis" :style="border" placeholder="未入力">
                  </label>
               </div>

               <div id="entAir" class=" my-1">
                  <label>終了残圧 (bar)：
                     <input type="number" name="end_air" id="" class="" v-model="mEndAir" :disabled="dis" :style="border" placeholder="未入力">
                  </label>
               </div>
            </div>

            <div class="mdlGroup">
               <div id="enrche" class=" my-1">
                  <label>空気消費率：
                     <input type="text" name="air_rate" id="" class="" v-model="mAirRate" disabled :style="border" placeholder="計算ボタンで自動計算">
                  </label>
                  <button type="button" class="btn btn_s" :disabled="dis" @click="onCalcAirRate" >計算</button>
               </div>
            </div>
         </div>

         <div class="acdTitle">気候・海峡</div>
         <div class="acdItem">
            <div class="mdlGroup">

               <div id="temp" class=" my-1">
                  <label>気温： (℃)：
                     <input type="text" name="temp" id="" class="" v-model="mTemp" :disabled="dis" :style="border" placeholder="未入力">
                  </label>
               </div>

               <div id="watarTemp" class=" my-1">
                  <label>水温 (℃)：
                     <input type="text" name="water_temp" id="" class="" v-model="mWaterTemp" :disabled="dis" :style="border" placeholder="未入力">
                  </label>
               </div>

               <div id="view" class=" my-1">
                  <label>透視度 (m)：
                     <input type="text" name="view" id="" class="" v-model="mView" :disabled="dis" :style="border" placeholder="未入力">
                  </label>
               </div>
            </div>

            <div class="mdlGroup">
               <div id="weather" class=" my-1">
                  <label>天候：
                     <select name="weather" id="" class="" v-model="mWeather" :disabled="dis" :style="border">
                        <option value="" selected>---</option>
                        <option v-for="(weather,i) in arrWeather" :value="i">
                           {{ weather }}
                        </option>
                     </select>
                  </label>
               </div>

               <div id="wind" class=" my-1">
                  <label>風：
                     <select name="wind" id="" class="" v-model="mWind" :disabled="dis" :style="border">
                        <option value="" selected>---</option>
                        <option v-for="(wind,i) in arrWind" :value="i">
                           {{ wind }}
                        </option>
                     </select>
                  </label>
               </div>

               <div id="current" class=" my-1">
                  <label>流れ：
                     <select name="current" id="" class="" v-model="mCurrent" :disabled="dis" :style="border">
                        <option value="" selected>---</option>
                        <option v-for="(current,i) in arrCurrent" :value="i">
                           {{ current }}
                        </option>
                     </select>
                  </label>
               </div>


            </div>
         </div>

         <div class="acdTitle">その他器材</div>
         <div class="acdItem">
            <div class="mdlGroup">
               <div id="suitType" class=" my-1">
                  <label>スーツ：
                     <select name="suit_type" id="" class="" v-model="mSuitType" :disabled="dis" :style="border">
                        <option value="" selected>---</option>
                        <option v-for="(suit,i) in arrSuitType" :value="i">
                           {{ suit }}
                        </option>
                     </select>
                  </label>
               </div>

               <div id="weight" class=" my-1">
                  <label>ウエイト (kg)：
                     <input type="number" name="weight" id="" class="" v-model="mWeight" :disabled="dis" :style="border" placeholder="未入力">
                  </label>
               </div>
            </div>
         </div>


         <div class="acdTitle">コメント</div>
         <div class="acdItem">
            <div id="commnet" class="mdlGroup">
               <textarea name="comment" id="" cols="1" rows="5" v-model="mComment" :disabled="dis"></textarea>
            </div>
         </div>

         <div class="acdTitle">地図</div>
         <div class="acdItem">
            <template v-if="isNew || isEdit">
               <div id="map" class="mdlGroup">
                  <input type="text" name="map_link" id="" class="mMap" v-model="mMap" :disabled="dis" :style="border" placeholder="未入力">
               </div>
               <div id="map" class="mdlGroup">
                  <p><a href="https://www.google.co.jp/maps/" target="blank" class="url">GoogleMap</a>から「共有→地図を埋め込む」のURLを貼り付けてください</p>
               </div>
            </template>
            <template v-if="isDetail">
               <div id="map" class="mdlGroup">
                  <div v-if="mMap" v-html="mMap"></div>
                  <div v-else>地図登録がありません</div>
               </div>
            </template>
         </div>

         <div class="acdTitle">仲間</div>
         <div class="acdItem">
            <div class="mdlGroup">
               <div id="buddyName" class="my-1">
                  <label>バディ名：
                     <input type="text" name="buddy_name" id="" class="" v-model="mBuddy" :disabled="dis" :style="border" placeholder="未入力">
                  </label>
               </div>

               <div id="instructorName" class="my-1">
                  <label>イントラ名：
                     <input type="text" name="instructor_name" id="" class="" v-model="mInstructor" :style="border" :disabled="dis" placeholder="未入力">
                  </label>
               </div>
            </div>
            <div class="mdlGroup">
               <div id="instructorNum" class="my-1">
                  <label>イントラ番号：
                     <input type="text" name="buddy_name" id="" class="" v-model="mInstructorNum" :disabled="dis" :style="border" placeholder="未入力">
                  </label>
               </div>
            </div>
         </div>

         <div id="signeTitle" :class="{ 'acdTitle': true, 'text-danger': signeTitleOpen }" @click="onSigne">サイン</div>
         <div id="signeBox" class="acdItem">
            <div id="signe" class="signeGroup">
               <template v-if="isEdit || isNew">
                  <div class="draw-canvas" id="canvas">
                     <canvas width="640" height="150" ref="canvas" v-on:mousedown="drawStart" v-on:mouseup="drawEnd" v-on:mouseout="drawEnd" v-on:mousemove="draw" v-on:touchstart="drawTouchStart" v-on:touchend="drawEnd" v-on:touchcancel="drawEnd" v-on:touchmove="drawTouch" v-on:gesturestart="drawTouchStart" v-on:gesturechange="drawEnd" v-on:gestureend="drawTouch">
                     </canvas>
                  </div>

                  <div class="mdlGroupmdlBtn c">
                     <button type="button" id="" class="btn mr-3" @click="onClear">リセット</button>
                     <button type="button" id="" class="btn mr-3" @click="onSave">確定</button>
                     <button type="button" id="" class="btn" @click="delSigne">削除</button>
                  </div>

                  <div class="">保存イメージ</div>
               </template>

               <div v-if="isSigne" class="file-image">
                  <img v-if="mNewSigne" :src="mNewSigne">
               </div>
               <div v-if="(!mOldSigne && !isSigne) || mNewSigne === 'delete'">サインはありません</div>
               <div v-else-if="mOldSigne && !isSigne" class="file-image">
                  <img :src="'./signe/' + mOldSigne">
               </div>

            </div>
         </div>



         <!-- <div class="acdTitle">写真</div>
         <div class="acdItem"> -->
         <div class="acdTitleOpen acdOpen">写真</div>
         <div class="acdOpen">
            <template v-if="isEdit || isNew">
               <div class="imgBtn c my-3">
                  <button type="button" @click="cntUpImg" class="btn mr-3 w100">＋</button>
                  <button type="button" @click="cntDownImg" class="btn mr-3 w100">－</button>
                  <!-- <button type="button" @click="checkImg" class="btn">確認</button> -->
               </div>

               <div v-for="(num, i) of imgNum">
                  <div class="imgGroup">
                     <select name="is_open" id="" class="imgSelect" v-model="mIsOpen[i]" :disabled="dis" :style="border">
                        <option value="0">公開しない</option>
                        <option value="1">公開する</option>
                     </select>
                     <input ref="upfile" type="file" accept="image/*" id="" class="imgInput" @change="onFileChange($event,i)" multiple="multiple" required>

                     <template v-if="mNewImg[i]">
                        <img class="prevImg" :src="mNewImg[i].url">
                     </template>
                  </div>
               </div>
            </template>

            <div class="mdlText" v-if="mOldImg.length == 0" key="img">保存している写真はありません</div>

            <template v-else-if="mOldImg.length > 0" key="img">
               <div class="mdlText">保存済の写真</div>
               <div class="mdlGroup">
                  <div class="" v-for="(img, i) of mOldImg">
                     <select name="is_open" id="" class="" v-model="img.is_open" :disabled="dis" :style="border" @change="onEditImage(img.id, img.is_open)">
                        <option value="0">公開しない</option>
                        <option value="1">公開する</option>
                     </select>
                     <div>
                        <a :href="url + '/img/' + img.photo_name" target=”_blank”><img class="photo" :src="'./img/' + img.photo_name"></a>
                     </div>

                     <template v-if="isEdit || isNew">
                        <div>
                           <button type="button" id="" class="btn delImgBtn" @click="onDelImage(img.id, img.photo_name)">del</button>
                        </div>
                     </template>

                  </div>
               </div>

            </template>

         </div>

      </div>
   </form>
</transition>