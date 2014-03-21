<?php
         // Показываем загруженные фотографии объекта
         
         // Планировки
         $query="SELECT * FROM lib_pictures WHERE status='0' AND pic_obj_type_id='".$obj_type."' AND pic_obj_id='".$obj_id."' AND pic_type_id='1' ORDER BY id ASC";
         $res=$db->query($query); 
         $kolvo=$res->num_rows;
         if ($kolvo!=0) {
             echo "<div class=\"clear\"></div>";
             echo "<h2>Планировка</h2>";
             echo "<div class=\"clear\"></div>";
             echo "<div class=\"highslide-gallery\">";
             while ($fotka=$res->fetch_assoc()) {
               echo "<div class=\"foto\">";
               echo "  <a  href=\"http://www.novkva.ru/pics/uploaded/".$fotka['pic_orig']."\" class=\"highslide\" onclick=\"return hs.expand(this, {slideshowGroup: 'group1', dimmingOpacity: .75, numberPosition: 'caption'})\">";
               echo "  <img src=\"http://www.novkva.ru/pics/uploaded/".$fotka['pic_thumb']."\" title=\"Щёлкните для увеличения\" /></a>";
               echo "  <div class=\"highslide-caption\">".$notice."</div>  ";
               if ($avtor) {
                 echo "  <div class=\"clear\"></div>";
                 echo "  <a href=\"./pic_switch.php?id=".$fotka['id']."\" class=\"link\" ><img title=\"Переместить к фотографиям\" src=\"./pics/ico_switch.png\" align=\"absmiddle\" height=\"16\" width=\"16\"></a>";
                 echo "  <a href=\"./pic_del.php?id=".$fotka['id']."\" class=\"link\" ><img title=\"Удалить изображение\" src=\"./pics/ico_delete.png\" align=\"absmiddle\" height=\"16\" width=\"16\"></a>";
               };
               echo "</div>";
             };
             echo "</div>";
         };
         
         // Фотографии
         $query="SELECT * FROM lib_pictures WHERE status='0' AND pic_obj_type_id='".$obj_type."' AND pic_obj_id='".$obj_id."' AND pic_type_id='2' ORDER BY id ASC";
         $res=$db->query($query); 
         $kolvo=$res->num_rows;
         if ($kolvo!=0) {
             echo "<div class=\"clear\"></div>";
             echo "<h2>Фотографии</h2>";
             echo "<div class=\"clear\"></div>";
             echo "<div class=\"highslide-gallery\">";
             while ($fotka=$res->fetch_assoc()) {
               echo "<div class=\"foto\">";
               echo "  <a  href=\"http://www.novkva.ru/pics/uploaded/".$fotka['pic_orig']."\" class=\"highslide\" onclick=\"return hs.expand(this, {slideshowGroup: 'group1', dimmingOpacity: .75, numberPosition: 'caption'})\">";
               echo "  <img src=\"http://www.novkva.ru/pics/uploaded/".$fotka['pic_thumb']."\" title=\"Щёлкните для увеличения\" /></a>";
               echo "  <div class=\"highslide-caption\">".$notice."</div>  ";
               if ($avtor) {
                 echo "  <div class=\"clear\"></div>";
                 echo "  <a href=\"./pic_switch.php?id=".$fotka['id']."\" class=\"link\" ><img title=\"Переместить к планировкам\" src=\"./pics/ico_switch.png\" align=\"absmiddle\" height=\"16\" width=\"16\"></a>";
                 echo "  <a href=\"./pic_del.php?id=".$fotka['id']."\" class=\"link\" ><img title=\"Удалить изображение\" src=\"./pics/ico_delete.png\" align=\"absmiddle\" height=\"16\" width=\"16\"></a>";
               };
               echo "</div>";
             };
             echo "</div>";
         };
         
      
         
         
         
         
         if ($avtor) { // для автора (начало)
             echo "<div class=\"clear\"></div>";
             ?>
             <table border="0" cellpadding="10" cellspacing="0">
             <tr>
             <td width="50%">
               <h2>Есть планировка? Загружай!</h2>
               <form enctype="multipart/form-data" method="post" action="./loader.php"> 
                 <input type="hidden" name="MAX_FILE_SIZE" value="1048576"> 
                 Загрузить планировку:<br>
                 <input name="uploadingfile" type="file"> 
                 <br>
                 <b>Требования к изображениям:</b> формат JPG/JPEG, размер не более 1 Мб, ширина не более 2500px, высота не более 1500px.
                 <br>
                 <input type="submit" value="Загрузить планировку"> 
                 <input name="pic_type" type="hidden" value="1">
                 <input name="obj_type" type="hidden" value="<?php echo $obj_type; ?>">
                 <input name="obj_id" type="hidden" value="<?php echo $obj_id; ?>">
               </form>
             </td>
             
             
             <td>
               <h2>Есть фотографии? Загружай!</h2>
               <form enctype="multipart/form-data" method="post" action="./loader.php"> 
                 <input type="hidden" name="MAX_FILE_SIZE" value="1048576"> 
                 Загрузить фотографию:<br>
                 <input name="uploadingfile" type="file"> 
                 <br>
                 <b>Требования к изображениям:</b> формат JPG/JPEG, размер не более 1 Мб, ширина не более 2500px, высота не более 1500px.
                 <br>
                 <input type="submit" value="Загрузить фотографию"> 
                 <input name="pic_type" type="hidden" value="2">
                 <input name="obj_type" type="hidden" value="<?php echo $obj_type; ?>">
                 <input name="obj_id" type="hidden" value="<?php echo $obj_id; ?>">
                 </form>
             </td>
             </tr>
             
             <tr>
             <td colspan="2">
               <b>Внимание!</b> Изображения не должны содержать никаких логотипов и любых других пометок от сторонних Интернет-ресурсов, а также никаких URL-адресов либо иных приглашений посетить сторонний сайт. Недопустимым считается загрузка изображений, не имеющих никакого отношения к объекту недвижимости, описанному в объявлении.
             </td>
             </tr>
             </table>
             
             <?php
             echo "<div class=\"clear\"></div>";
         }; // для автора (окончание)
?>