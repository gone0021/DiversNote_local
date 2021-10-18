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
               <form @submit.prevent="onSearch()" id="">
                  <select name="select" id="isSchSelect" class="schSelect mr-3" v-model="isSchSelect" @change="chgSearch">
                     <option v-for="(key, val) in schSelect" :value="val">
                        {{ key }}
                     </option>
                  </select>

                  <template v-if="schType=='all'">
                     <input type="search" name="val" id="" class="schInput mr-3" v-model="isSearch" placeholder="日付は「-」区切りで入力">
                  </template>

                  <template v-else-if="schType=='text'">
                     <input type="search" name="val" id="" class="schInput mr-3" v-model="isSearch" placeholder="検索文字を入力">
                  </template>

                  <template v-else-if="schType=='date'">
                     <input type="date" name="val" id="" class="schInput mr-3" v-model="isSearch" placeholder="">
                  </template>
                  <input type="submit" id="schBtn" class="btn btn-sch" value="検索">
               </form>
            </li>
         </ul>
      </li>

      <li id="navPhoto" class="">
         <a href="javascript:void(0)" id="" class="">PHOTO</a>
         <ul id="ddPht" class="ddmenu">
            <li>
               <form @submit.prevent="onPhoto()">
                  <!-- あとで使う：最初の写真表示のみディレクトリを移動させる -->
                  <!-- <form action="<?= $url ?>/divers/photo/index.php" method="GET"> -->
                  <!-- <form action="<?= $url ?>/divers/photo/photo.php" method="GET"> -->
                  <!-- <input type="hidden" name="" id="" value="<?= $token; ?>"> -->
                  <select name="user_type" id="isPhtUser" class="schSelect mr-3" v-model="isPhtUser">
                     <option v-for="(key, val) in phtUser" :value="val">
                        {{ key }}
                     </option>
                  </select>
                  <select name="select" id="isPhtSelect" class="schSelect mr-3" v-model="isPhtSelect" @change="chgPhtSelect">
                     <option v-for="(key, val) in phtSelect" :value="val">
                        {{ key }}
                     </option>
                  </select>

                  <template v-if="phtType=='all'">
                     <input type="search" name="val" id="" class="schInput mr-3" v-model="isPhoto" placeholder="日付は「-」区切りで入力">
                  </template>

                  <template v-else-if="phtType=='text'">
                     <input type="search" name="val" id="" class="schInput mr-3" v-model="isPhoto" placeholder="検索文字を入力">
                  </template>

                  <template v-else-if="phtType=='date'">
                     <input type="date" name="val" id="" class="schInput mr-3" v-model="isPhoto" placeholder="">
                  </template>
                  <input type="submit" id="phtBtn" class="btn btn-sch" value="検索">
               </form>
            </li>
         </ul>
      </li>
      <li class="ddnav">
         <a href="javascript:void(0)" class="">USER</a>
         <ul class="ddmenu">
            <li><a href="<?= $url . "/divers" ?>/user">会員情報</a></li>
            <li><a href="<?= $url . "/divers" ?>/logout.php">ログアウト</a></li>
         </ul>
      </li>
      
      <li class="ddnav">
         <a href="javascript:void(0)" class="">OTHER</a>
         <ul class="ddmenu">
            <li><a href="<?= $url . "/divers" ?>/weight">適正ウエイト</a></li>
            <li><a href="<?= $url . "/divers" ?>/list">持ち物リスト</a></li>
            <li><a href="<?= $url . "/divers" ?>/contact">お問い合わせ</a></li>
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
               <form @submit.prevent="onSearch()" class="isSearch">
                  <div class="mb-2">
                     <select name="entry_type" id="" class="schSelect mr-3" v-model="isSchSelect" @change="chgSearch">

                        <!-- <option value="all">全て</option> -->
                        <option v-for="(key, val) in schSelect" :value="val">
                           {{ key }}
                        </option>
                     </select>
                  </div>

                  <div class="mb-2">
                     <template v-if="schType == 'all'">
                        <input type="text" name="search" id="" class="schInput mr-3" v-model="isSearch" placeholder="日付は「-」区切りで入力">
                     </template>

                     <template v-else-if="schType == 'text'">
                        <input type="text" name="search" id="" class="schInput mr-3" v-model="isSearch" placeholder="検索文字を入力">
                     </template>

                     <template v-else-if="schType == 'date'">
                        <input type="date" name="search" id="" class="schInput mr-3" v-model="isSearch" placeholder="">
                     </template>
                  </div>

                  <div>
                     <input type="submit" id="schBtn" class="btn btn-sch onClose" value="検索">
                  </div>

               </form>
            </li>
         </ul>
      </li>

      <li id="menubar_hdr2" class="close">PHOTO
         <ul id="ddSch" class="menubar-s2">
            <li class="clsSearch">
               <form @submit.prevent="onPhoto()" class="isSearch">
                  <div class="mb-2">
                     <select name="user_type" id="" class="schSelect mr-3" v-model="isPhtUser">
                        <option v-for="(key, val) in phtUser" :value="val">
                           {{ key }}
                        </option>
                     </select>
                  </div>

                  <div class="mb-2">
                     <select name="select" id="" class="schSelect mr-3" v-model="isPhtSelect" @change="chgPhtSelect">
                        <option v-for="(key, val) in phtSelect" :value="val">
                           {{ key }}
                        </option>
                     </select>
                  </div>

                  <div class="mb-2">
                     <template v-if="phtType == 'all'">
                        <input type="search" name="search" id="" class="schInput mr-3" v-model="isPhoto" placeholder="日付は「-」区切りで入力">
                     </template>

                     <template v-else-if="phtType == 'text'">
                        <input type="search" name="search" id="" class="schInput mr-3" v-model="isPhoto" placeholder="検索文字を入力">
                     </template>

                     <template v-else-if="phtType == 'date'">
                        <input type="date" name="search" id="" class="schInput mr-3" v-model="isPhoto" placeholder="">
                     </template>
                  </div>

                  <div>
                     <input type="submit" id="schBtn" class="btn btn-sch onClose" value="検索">
                  </div>

               </form>
            </li>
         </ul>
      </li>

      <li id="menubar_hdr2" class="close">USER
         <ul class="menubar-s2">
            <li><a href="<?= $url . "/divers" ?>/user">会員情報</a></li>
            <li><a href="<?= $url . "/divers" ?>/logout.php">ログアウト</a></li>
         </ul>
      </li>

      <li id="menubar_hdr2" class="close">OTHERE
         <ul class="menubar-s2">
            <li><a href="<?= $url . "/divers" ?>/weight">適正ウエイト</a></li>
            <li><a href="<?= $url . "/divers" ?>/list">持ち物リスト</a></li>
            <li><a href="<?= $url . "/divers" ?>/contact">お問い合わせ</a></li>
         </ul>
      </li>
   </ul>
</nav>