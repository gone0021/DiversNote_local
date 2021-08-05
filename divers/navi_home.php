<!--PC用（801px以上端末）メニュー-->
<nav id="menubar" class="d menu_home nav-fix-pos">
   <ul class="">
      <li class="ddnav">
         <!-- <a href="./" class="" >HOME</a> -->
         <a href="<?= $url . "/divers" ?>/">HOME</a>
      </li>
      <li class="ddnav">
         <a href="javascript:void(0)" id="navNew" class="" @click="onNew">NEW</a>
      </li>
      <li id="navSch" class="">
         <a href="javascript:void(0)" id="" class="">SEARCH</a>
         <ul id="ddSch" class="ddmenu">
            <li>
               <form @submit.prevent="onSearch()">
                  <select name="entry_type" id="" class="schSelect mr-3" v-model="isSelect" @change="chgSearch">

                     <!-- <option value="all">全て</option> -->
                     <option v-for="(key, val) in schSelect" :value="val">
                        {{ key }}
                     </option>
                  </select>

                  <template v-if="schType=='all'">
                     <input type="text" name="search" id="" class="schInput mr-3" v-model="isSearch" placeholder="日付は「-」区切りで入力" required>
                  </template>

                  <template v-else-if="schType=='text'">
                     <input type="text" name="search" id="" class="schInput mr-3" v-model="isSearch" placeholder="検索文字を入力" required>
                  </template>

                  <template v-else-if="schType=='date'">
                     <input type="date" name="search" id="" class="schInput mr-3" v-model="isSearch" placeholder="" required>
                  </template>
                  <input type="submit" id="schBtn" class="btn btn-sch" value="検索">
               </form>
            </li>
         </ul>
      </li>
      <li class="ddnav">
         <a href="javascript:void(0)" class="">MY PHOTO</a>
         <ul class="ddmenu">
            <li><a href="./">全ての投稿写真</a></li>
            <li><a href="./">地域ごとの投稿写真</a></li>
         </ul>
      </li>
      <li class="ddnav">
         <a href="javascript:void(0)" class="">OTHER PHOTO</a>
         <ul class="ddmenu">
            <li><a href="./">全ての投稿写真</a></li>
            <li><a href="./">地域ごとの投稿写真</a></li>
         </ul>
      </li>
      <li class="ddnav">
         <a href="javascript:void(0)" class="">USER</a>
         <ul class="ddmenu">
            <li><a href="<?= $url . "/divers" ?>/user">会員情報</a></li>
            <li><a href="<?= $url . "/divers" ?>/logout.php">ログアウト</a></li>
         </ul>
      </li>
   </ul>
</nav>


<!--小さな端末用（800px以下端末）メニュー-->
<nav id="menubar-s">
   <ul>
      <li>
         <a href="<?= $url . "/divers" ?>/">HOME</a>
      </li>

      <li>
         <a href="javascript:void(0)" id="navNew" class="onClose" @click="onNew">NEW</a>
      </li>

      <li id="menubar_hdr2" class="close">SEARCH
         <ul id="ddSch" class="menubar-s2">
            <li class="clsSearch">
               <form @submit.prevent="onSearch()" id="idSearch">
                  <div class="mb-2">
                     <select name="entry_type" id="" class="schSelect mr-3" v-model="isSelect" @change="chgSearch">

                        <!-- <option value="all">全て</option> -->
                        <option v-for="(key, val) in schSelect" :value="val">
                           {{ key }}
                        </option>
                     </select>
                  </div>

                  <div class="mb-2">
                     <template v-if="schType == 'all'">
                        <input type="text" name="search" id="" class="schInput mr-3" v-model="isSearch" placeholder="日付は「-」区切りで入力" required>
                     </template>

                     <template v-else-if="schType == 'text'">
                        <input type="text" name="search" id="" class="schInput mr-3" v-model="isSearch" placeholder="検索文字を入力" required>
                     </template>

                     <template v-else-if="schType == 'date'">
                        <input type="date" name="search" id="" class="schInput mr-3" v-model="isSearch" placeholder="" required>
                     </template>
                  </div>
                  <div>
                     <input type="submit" id="schBtn" class="btn btn-sch onClose" value="検索">
                  </div>

               </form>
            </li>
         </ul>

      </li>

      <li id="menubar_hdr2" class="close">MY PHOTO
         <ul class="menubar-s2">
            <li><a href="./">全ての投稿写真</a></li>
            <li><a href="./">地域ごとの投稿写真</a></li>
         </ul>
      </li>
      <li id="menubar_hdr2" class="close">OTHER PHOTO
         <ul class="menubar-s2">
            <li><a href="./">全ての投稿写真</a></li>
            <li><a href="./">地域ごとの投稿写真</a></li>
         </ul>
      </li>

      <li id="menubar_hdr2" class="close">USER
         <ul class="menubar-s2">
            <li><a href="<?= $url . "/divers" ?>/user">会員情報</a></li>
            <li><a href="<?= $url . "/divers" ?>/logout.php">ログアウト</a></li>
         </ul>
      </li>
   </ul>
</nav>