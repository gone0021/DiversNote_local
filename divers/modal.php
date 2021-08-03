<transition name="fade">
   <div id="glayLayer" v-show="dispGlay" @click="onGlay" transition="fade"></div>
</transition>

<transition name="fade">

   <form @submit.prevent="onSubmit()" enctype="multipart/form-data">
      <div class="mdlBox ui-widget-content" v-show="dispModalInput">
         <!-- タイトル部分 -->
         <div id="mdlTop">
            <div class="mdlTopGrid">
               <div class="mdlTitle">
                  <label>タイトル：
                     <input type="text" name="title" id="" class="mTitle" v-model="mTitle" :disabled="dis" placeholder="未入力" required>
                  </label>
               </div>

               <div class="mdlBtn">
                  <template v-if="btnNew">
                     <input type="submit" :name="mSub" class="btn" value="登録" />

                     <!-- <button type="button" class="btn mr-2" @click="onStore">登録</button> -->
                  </template>
                  <templatev v-if="btnUpdate">
                     <input type="submit" :name="mSub" class="btn" value="更新" />

                     <!-- <button type="button" class="btn mr-2" @click="onUpdate">更新</button> -->
                  </templatev>
                  <template v-if="btnEdit">
                     <button type="button" class="btn mr-2" @click="onEdit">編集</button>
                  </template>
                  <template v-if="btnDel">
                     <button type="button" class="btn" @click="onDel">削除</button>
                  </template>
               </div>
            </div>
         </div>
         <!-- 幅の調整 -->
         <div id="adjTop"></div>

         <!-- アイテム詳細 -->
         <div class="m2 mdlGroup">
            <div id="number" class="my-1">
               <label>No.
                  <input type="text" name="dive_num" id="" class="" v-model="mDiveNum" :disabled="dis" :style="border" :placeholder="next_num" required>
               </label>
            </div>

            <div id="date" class="my-1">
               <label>日付：
                  <input type="date" name="dive_date" id="" class="" v-model="mDiveDate" :disabled="dis" :style="border" required>
               </label>
            </div>
         </div>

         <div class="m2 mdlGroup">
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

         <!-- 最初から表示 -->
         <div class="acdTitle">基本情報</div>
         <div class="acdItem">
            <div class="m2 mdlGroup">

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

            <div class="m2 mdlGroup">
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
            <div class="m2 mdlGroup">
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
            <div class="m2 mdlGroup">
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
                     <input type="text" name="tank_size" id="" class="" v-model="mTankSize" :disabled="dis" :style="border" placeholder="未入力">
                  </label>
               </div>
            </div>

            <div class="m1 mdlGroup">
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

            <div class="m2 mdlGroup">
               <div id="startAir" class=" my-1">
                  <label>開始残圧 (bar)：
                     <input type="text" name="start_air" id="" class="" v-model="mStartAir" :disabled="dis" :style="border" placeholder="未入力">
                  </label>
               </div>

               <div id="entAir" class=" my-1">
                  <label>終了残圧 (bar)：
                     <input type="text" name="end_air" id="" class="" v-model="mEndAir" :disabled="dis" :style="border" placeholder="未入力">
                  </label>
               </div>
            </div>
         </div>

         <div class="acdTitle">気候・海峡</div>
         <div class="acdItem">
            <div class="m3 mdlGroup">

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

            <div class="m3 mdlGroup">
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
            <div class="m2 mdlGroup">
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
                     <input type="text" name="weight" id="" class="" v-model="mWeight" :disabled="dis" :style="border" placeholder="未入力">
                  </label>
               </div>
            </div>
         </div>


         <div class="acdTitle">コメント</div>
         <div class="acdItem">
            <div id="commnet" class="m1 mdlGroup">
               <textarea name="comment" id="" cols="1" rows="5" v-model="mComment" :disabled="dis"></textarea>
            </div>
         </div>

         <div class="acdTitle">地図</div>
         <div class="acdItem">
            <div id="map" class="m1 mdlGroup">
               <template v-if="isEdit || isNew">
                  <input type="text" name="map_link" id="" class="mMap" v-model="mMap" :disabled="dis" :style="border" placeholder="未入力">
                  <p><a href="https://www.google.co.jp/maps/" target="blank">GoogleMap</a>から「共有→地図を埋め込む」のURLを貼り付けてください</p>
               </template>
               <template v-if="isDetail">
                  <div v-html="mMap"></div>
               </template>
            </div>
         </div>

         <div class="acdTitle">仲間</div>
         <div class="acdItem">
            <div class="m2 mdlGroup">
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
            <div class="m1 mdlGroup">
               <div id="instructorNum" class="my-1">
                  <label>イントラ番号：
                     <input type="text" name="buddy_name" id="" class="" v-model="mInstructorNum" :disabled="dis" :style="border" placeholder="未入力">
                  </label>
               </div>
            </div>


         </div>

         <!-- <div id="signeTitle" :class="{ 'acdTitle': true, 'text-danger': signeTitleOpen }" @click="onSigne">サイン</div>
         <div id="signeBox" class="acdItem">
            <div id="signe" class="m1 mdlGroup">
               <template v-if="isEdit || isNew">
                  <div class="draw-canvas" id="canvas" width="640" height="150">
                     <canvas width="640" height="150" ref="canvas" v-on:mousedown="drawStart" v-on:mouseup="drawEnd" v-on:mouseout="drawEnd" v-on:mousemove="draw" v-on:touchstart="drawTouchStart" v-on:touchend="drawEnd" v-on:touchcancel="drawEnd" v-on:touchmove="drawTouch" v-on:gesturestart="drawTouchStart" v-on:gesturechange="drawEnd" v-on:gestureend="drawTouch"></canvas>
                  </div>

                  <div class="mdlBtn c">
                     <button type="button" id="" class="btn mr-4" @click="onClear">リセット</button>
                     <button type="button" id="" class="btn" @click="onSave">確認</button>
                  </div>
                  <div>
                     保存イメージ
                  </div>
               </template>

               <div v-if="isImage">
                  <div class="file-image">
                     <img v-if="mSigne" :src="mSigne">
                  </div>
               </div>
            </div>
         </div> -->

      </div>
   </form>
</transition>