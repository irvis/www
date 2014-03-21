<?php 

  // Подключаем поддержку БД
  require "./_parts/_db.php"; 
  
  // Подключаем авторизацию
  require "./_parts/_auth.php"; 
  // если пользователь авторизован, тогда наша переменная $glogged имеет значение '1';
  
  // Запоминаем имя файла (для подсветки пунктов меню).
  $fname= basename (__FILE__);
  
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <title>Редактирование объявления о продаже коттеджа / дома в Великом Новгороде - Проект &laquo;Новгородская квартира&raquo; (Недвижимость Великого Новгорода)</title>
  <?php require "./_parts/include_style.php"; ?>
</head>
<body>




<table align="center" width="985" border="0" cellpadding="0" cellspacing="0">
<!-- Шапка -->
<tr>
<td colspan="2">
  <?php require "./_parts/page_header.php"; ?>
</td>
</tr>
<!-- /Шапка -->

<!-- Меню -->
<tr>
<td colspan="2">
  <?php require "./_parts/menu_horisontal_top.php"; ?>
</td>
</tr>
<!-- /Меню -->

<!-- Баннер -->
<tr>
<td colspan="2">
  <?php require "./_parts/banner_horisontal_big.php"; ?>
</td>
</tr>
<!-- /Баннер -->



<!-- Тело -->
<tr>
<!-- +++++++++++++++++++++++++++++++++++++++++++ ЛЕВАЯ ЧАСТЬ -->
<td valign="top">

  <?php require "./_parts/menu_vertical_left.php"; ?>
  <div class="clear"></div>
  
  <?php require "./_parts/page_blok_news.php"; ?>
  <div class="clear"></div>
  
  <?php require "./_parts/page_blok_labels.php"; ?>
  <div class="clear"></div>
  
</td>
<!-- +++++++++++++++++++++++++++++++++++++++++++ ЛЕВАЯ ЧАСТЬ -->




<!-- Правая часть-->
<td valign="top">
  

<!-- ========================================================================================= -->
<div class="content_box">
  
  <div class="content_header">
        <div class="content_inner">
        <b>Продажа коттеджей / домов в Великом Новгороде и Новгородской области</b>
        </div>
  </div>

  <div class="clear"></div>
  
  
  
  
  
  
  
  
  
  <?php
  
  $found=false;
  if (isset($_GET['id'])) {
  
  $query="SELECT *
    FROM  
      sell_dom 
    WHERE
      status='0' AND 
      id='".intval($_GET['id'])."' AND
      usr_id='".$_SESSION['id']."';
    ";
    
    $i=0;
    $res=mysql_query($query,$db); 
    $kolvo=mysql_num_rows($res);
    if ($kolvo>0) {
      $found=true;
      $ar=mysql_fetch_assoc($res);
    };
  }
   ?>     
 
 
 
 <div class="content_cover">
    <div class="content_inner">
       

<?php
if (!($glogged==1)) { // Пользователь не авторизован
  //($glogged!=1)?>         
  <h2>Ошибка доступа</h2>
  <p>Редактирование объявлений доступно только <a href="./register.php" class="link">зарегистрированным</a> пользователям.</p>
  <?php
} else {
  //($glogged==1) // Пользователь авторизован
  $showme=true;
  if (count($_POST)>0) {
  // Если что-то передано через POST - проверка на вшивость!
  
    $errorlist="";
    // проверка параметров дома (отправка формы)
    require "./_parts/check_dom.php";
    
    
    if ($errorlist!="") {
      // Если были обнаружены ошибки при проверке формы
      echo "<div style=\"margin:7px;\"><b style=\"color:red;\">".$errorlist."</b></div>";
    } else {
      // Если ошибок нет
      // Обновляем объект в базе
      
      $query="UPDATE sell_dom SET ";
      //$query.="status='0',";
      //$query.="checked_fl='0',";
      $query.="usr_id='".$_SESSION['id']."',";
      $query.="usr_ip='".$_SERVER['REMOTE_ADDR']."',";
      $query.="usr_host='".$_SERVER['REMOTE_HOST']."',";
      $query.="date_edited='".time()."',";
      
      $query.="geo_gorod_id='".mysql_real_escape_string($_POST['geo_gorod_id'])."',";
      if (($_POST['geo_gorod_id']=="-1") && (strlen(trim($_POST['geo_gorod']))>0) ) {
        $query.="geo_gorod='".mysql_real_escape_string($_POST['geo_gorod'])."',";
      };
      
      $query.="geo_rayon_id='".mysql_real_escape_string($_POST['geo_rayon_id'])."',";
      if (($_POST['geo_rayon_id']=="-1") && (strlen(trim($_POST['geo_rayon']))>0) ) {
        $query.="geo_rayon='".mysql_real_escape_string($_POST['geo_rayon'])."',";
      };
      
      $query.="geo_street_id='".mysql_real_escape_string($_POST['geo_street_id'])."',";
      if (($_POST['geo_street_id']=="-1") && (strlen(trim($_POST['geo_street']))>0) ) {
        $query.="geo_street='".mysql_real_escape_string($_POST['geo_street'])."',";
      };
      
      if (strlen(trim($_POST['geo_n_doma'])>0) ) {
        $query.="geo_n_doma='".mysql_real_escape_string($_POST['geo_n_doma'])."',";
        $query.="geo_n_korp='".mysql_real_escape_string($_POST['geo_n_korp'])."',";
      };
      
      
      // Для дома
      // +++++++++++++++++++++++++
      $query.="dom_type='".mysql_real_escape_string($_POST['dom_type'])."',";
      $query.="dom_floors='".mysql_real_escape_string($_POST['dom_floors'])."',";
      $query.="dom_material_id='".mysql_real_escape_string($_POST['dom_material_id'])."',";
      $query.="dom_pl_ob='".mysql_real_escape_string(str_replace(",", ".", $_POST['dom_pl_ob']))."',";
      $query.="dom_pl_zh='".mysql_real_escape_string(str_replace(",", ".", $_POST['dom_pl_zh']))."',";
      // +++++++++++++++++++++++++
      
      $query.="descr='".mysql_real_escape_string($_POST['descr'])."',";
      
      $query.="price='".mysql_real_escape_string($_POST['price'])."',";
      $query.="price_torg='".mysql_real_escape_string($_POST['price_torg'])."',";
      
      $query.="contacts='".mysql_real_escape_string($_POST['contacts'])."'"; // конец запроса - без запятой
      

      $query.="WHERE id='".intval($_GET['id'])."' AND usr_id='".$_SESSION['id']."';";
      
      // Записываем в журнал СТАРЫЕ ДАННЫЕ
      loging_add_domrecord ($db, $_SESSION['id'], "303", (int)$_GET['id'], get_dom_obyav_by_id($db,(int)$_GET['id']), get_dom_descr_by_id ($db, (int)$_GET['id']), get_dom_conta_by_id ($db, (int)$_GET['id']) );
      
      $res=mysql_query($query,$db);
      
      // Записываем в журнал НОВЫЕ ДАННЫЕ
      loging_add_domrecord ($db, $_SESSION['id'], "303", (int)$_GET['id'], get_dom_obyav_by_id($db,(int)$_GET['id']), get_dom_descr_by_id ($db, (int)$_GET['id']), get_dom_conta_by_id ($db, (int)$_GET['id']) );
      
      echo "<h2>Поздравляем!</h2>";
      echo "<b style=\"color:green\">Ваше объявление успешно отредактировано!</b> Посмотреть отредактированное объявление можно <a href=\"./prodam_dom.php?id=".(int)$_GET['id']."\" class=\"link\">здесь</a>.<br>"; 
      unset($_POST);
      $showme=false;
      
    }; // (список ошибок пуст)

    $ar=$_POST;
  }; // (в посте что-то есть, count($_POST)>0)
  
  
  if (($found) && ($showme)) {  ?>    
       <h2>Редактирование объявления о продаже коттеджа / дома</h2>
       <div class="clear"></div>
       
       <form name="myform" action="dom_edit.php?id=<?php echo intval($_GET['id']); ?>" method="post">
       <!-- ТАБЛИЦА -->
       <table width="690" cellpadding="5" cellspacing="0">
       <tr>
         <td>Тип объекта * :</td>
         <td>
           <select name="dom_type">
             <?php printselectsortdef($db, 'spr_dom_type', 'sort', 'ASC', $ar['dom_type']);?>
           </select>
         </td>
       </tr>
       
       <tr>
         <td>Населенный пункт * :</td>
         <td>
           <select name="geo_gorod_id" id="gorod_id" onchange="show_block_r('div_gorod',this.value);">
             <?php printselectsortdef($db, 'spr_geo_gorod', 'sort', 'ASC', $ar['geo_gorod_id']);?>
           </select>
           <div id="div_gorod" style="display:none;">
             <input style="display:inline;" size="15" name="geo_gorod" type="edit" value="<?php if (isset($ar['geo_gorod'])) { echo $ar['geo_gorod']; };?>" title="Введите название населенного пункта (если его нет в списке слева)">
           </div>
         </td>
       </tr>
       
       <tr>
         <td>Район города:</td>
         <td>
           <select name="geo_rayon_id" id="rayon_id" onchange="show_block('div_rayon',this.value);" <?php if ($ar['geo_gorod_id']!=1) { echo "disabled"; };?>>
             <?php printselectsortdef($db, 'spr_geo_rayon', 'sort', 'ASC', $ar['geo_rayon_id']); ?>
           </select>
           <div id="div_rayon" style="display:none;">
             <input style="display:inline" name="geo_rayon" type="edit" value="<?php if (isset($ar['geo_rayon'])) { echo $ar['geo_rayon']; };?>" title="Введите название района гороа (если его нет в списке слева)">
           </div>
         </td>
       </tr>
       
       <tr>
         <td>Улица :</td>
         <td>
           <select name="geo_street_id" id="street_id" onchange="show_block('div_street',this.value);">
           <?php printselectsortdef($db, 'spr_geo_street', 'sort', 'ASC', $ar['geo_street_id']); ?>
           </select>
           <div id="div_street" style="display:none;">
             <input style="display:inline" size="17" name="geo_street" type="edit" value="<?php if (isset($ar['geo_street'])) { echo $ar['geo_street']; };?>" title="Введите название улицы (если ее нет в списке слева)">
           </div>
         </td>
       </tr>
         
       <tr>
         <td>&nbsp;</td>
         <td>
           дом <input name="geo_n_doma" size="3" type="edit" value="<?php if (isset($ar['geo_n_doma'])) { echo $ar['geo_n_doma']; };?>">
           &nbsp; корп. <input name="geo_n_korp" size="1" type="edit" value="<?php if (isset($ar['geo_n_korp'])) { echo $ar['geo_n_korp']; };?>">
         </td>
       </tr>
       
       
       <tr>
         <td>Материал дома * :</td>
         <td>
           <select name="dom_material_id">
             <?php printselectdef($db, 'spr_zd_material', $ar['dom_material_id']); ?>
           </select>
         </td>
       </tr>
       
       <tr>
         <td>Этажность * :</td>
         <td>
           <input name="dom_floors" type="edit" size="3" value="<?php if (isset($ar['dom_floors'])) { echo $ar['dom_floors']; };?>">
         </td>
       </tr>
       
       
       <tr>
         <td>Общая площадь (м<sup>2</sup>) * :</td>
         <td>
           <input name="dom_pl_ob" size="4" type="edit" value="<?php if (isset($ar['dom_pl_ob'])) { echo $ar['dom_pl_ob']; };?>">
         </td>
       </tr>
       
       <tr>
         <td>Жилая площадь (м<sup>2</sup>) :</td>
         <td>
           <input name="dom_pl_zh" size="4" type="edit" value="<?php if (isset($ar['dom_pl_zh'])) { echo $ar['dom_pl_zh']; };?>">
         </td>
       </tr>
       
       
       
       
     
       
       <tr>
         <td>Стоимость (тыс. руб.) * :</td>
         <td>
           <input name="price" size="8" type="edit" value="<?php if (isset($ar['price'])) { echo $ar['price']; };?>"> (ВНИМАНИЕ! Стоимость в тыс. руб., не рисуйте лишних нулей!!!)
         </td>
       </tr>
       
       <tr>
         <td>Торг:</td>
         <td>
           <select name="price_torg">
           <?php printselectdef($db, 'spr_obj_price_torg', $ar['price_torg']); ?>
           </select>
         </td>
       </tr>
       
       <tr>
         <td>Примечание:</td>
         <td>
           <textarea title="Дополнительная информация по коттеджу / дому (Например: сделан евроремонт, установлены стеклопакеты)" name="descr" cols="30" rows="4"><?php if (isset($ar['descr'])) { echo $ar['descr']; }; ?></textarea>
         </td>
       </tr>
       

       <tr>
         <td>Контакты:</td>
         <td>
           <textarea title="Укажите контактный данные" name="contacts" cols="30" rows="4"><?php echo $ar['contacts']; ?></textarea>
         </td>
       </tr>
       
       <tr>
         <td></td>
         <td><input type="submit" value="Сохранить изменения"></td>
       </tr>
         
         
         
       <script language="javascript">
         show_block_r('div_gorod',document.getElementById('gorod_id').value);
         show_block('div_rayon',document.getElementById('rayon_id').value);
         show_block('div_street',document.getElementById('street_id').value);
       </script>
       
       </table>
       <!-- / ТАБЛИЦА -->
       </form>
       <div class="clear"></div><?php   
  } else {
  // ![ (($showme) && ($found)) ]
    if (!($found)) {
      echo "<h2>Ошибка доступа</h2>";
      echo "<p>В доступе отказано: объект с таким номером не найден, либо попытка редактирования чужого объявления.</p>";
    };
  };


//($glogged==1) 
}; 
?> 
       
       

       
       
       
    </div>
  </div>
  
  
  
  
  
</div> <!-- /content_box -->
<!-- ========================================================================================= -->


</td>
<!-- /Правая часть-->

</tr>
<!-- /Тело -->





<!-- Меню -->
<tr>
<td colspan="2">
  <?php require "./_parts/menu_horisontal_bottom.php"; ?>
</td>
</tr>
<!-- /Меню -->

<!-- Подножие -->
<tr>
<td colspan="2">
  <div class="shapka_box" style="margin-top:0px;">
  <div class="shapka_cover">
    <?php require "./_parts/page_copyright.php"; ?>
    <?php require "./_parts/page_counters.php"; ?>
  </div>
  </div>
</td>
</tr>
<!-- /Подножие -->

</table>






<div class="clear"></div>









</body>
</html>