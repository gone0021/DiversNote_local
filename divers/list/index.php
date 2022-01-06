<?php
require_once ('./list.php');
?>

<!DOCTYPE html>
<html lang="ja">
<?php include_once($divers . "/head_list.php"); ?>

<body>
   <div id="list">
      <div id="container">
         <?php include_once($divers . "/navi.php"); ?>

         <div id="contents">
            <div class="inner">
               <section id="">
                  <h2 class="title">Luggage List</h2>
                  <h3>持ち物リスト</h3>

                  <form @submit.prevent="submitList()">

                     <!-- 荷物 -->
                     <table class="mx-auto listTable">
                        <tr>
                           <th class="pl10">タグ</th>
                           <th class="pl10">持ち物</th>
                           <th class="px10 pointer" @click="onIsChecked" >状態</th>
                           <th class="pl10 w50" >削除</th>
                        </tr>

                        <!-- 保存されてる値 -->
                        <tr v-for="(val,i) of lists">
                           <td>
                              <input type="search" name="tag_name[]" v-model="val.tag_name">
                           </td>

                           <td>
                              <input type="search" name="list_name[]" v-model="val.list_name">
                           </td>

                           <td class="c">
                              <input type="checkbox" name="id_checked[]" v-model="val.v_checked" :checked="isChecked">
                           </td>

                           <td class="c">
                              <span class="splice" @click="onDel(i)">
                                 x
                              </span>
                           </td>
                        </tr>

                        <!-- 追加 -->
                        <tr>
                           <input type="hidden" name="" v-model="addNum[0]">
                           <td>
                              <input type="search" class="" name="tag_name[]" placeholder="タグを追加" v-model="addTags[0]" />
                           </td>
                           <td>
                              <input type="search" class="" name="list_name[]" placeholder="リストを追加" v-model="addLists[0]" />
                           </td>
                           <td class="c">
                              <input type="checkbox" class="" name="is_checked[]" v-model="addChecked[0]" />
                           </td>
                           <td class="c">
                              <span class="splice" @click="onDeladd(0)">
                                 x
                              </span>
                           </td>
                        </tr>
                        <!-- 追加があった場合 -->
                        <tr v-for="(add, i) in addLists">
                        <input type="hidden" name="" v-model="addNum[i+1]">
                           <td>
                              <input type="search" class="" name="tag_name[]" placeholder="タグを追加" v-model="addTags[i+1]" />
                           </td>
                           <td>
                              <input type="search" class="" name="list_name[]" placeholder="リストを追加" v-model="addLists[i+1]" />
                           </td>
                           <td class="c">
                              <input type="checkbox" class="" name="is_checked[]" v-model="addChecked[i+1]" />
                           </td>
                           <td class="c">
                              <span class="splice" @click="onDeladd(i+1)">
                                 x
                              </span>
                           </td>
                        </tr>

                     </table>

                     <!-- ※ボタン -->
                     <div class="c my-4">
                        <input type="submit" name="" id="" class="btn mr-3" value="更新">
                        <button type="button" id="reset" class="btn mr-3" @click="onReset()">リセット</button>

                        <a href="../" class="btn">戻る</a>
                     </div>

                  </form>

               </section>

            </div>
            <!-- /#main -->

         </div>
         <!-- /#contents -->
         <!-- <div class="push"></div> -->

      </div>
      <!-- /#container -->
      <!--メニュー開閉ボタン-->
      <div id="menubar_hdr" class="close"></div>

   </div>
   <!-- /#app -->

   <script>
      let php = <?= json_encode($toJs); ?>
   </script>
   <?php require_once $unsession; ?>
</body>

</html>