<?php 
require_once '../app/config.php';
  
  // Подключаем авторизацию
  require "./_parts/_auth.php"; 
  // если пользователь авторизован, тогда наша переменная $glogged имеет значение '1';
  
  // Запоминаем имя файла (для подсветки пунктов меню).
  $fname= basename (__FILE__);
  
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <title>Подать объявление о продаже гаража в Великом Новгороде - Проект &laquo;Новгородская квартира&raquo; (Недвижимость Великого Новгорода)</title>
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
        <b>Продажа гаражей в Великом Новгороде и Новгородской области</b>
        </div>
  </div>

  <div class="clear"></div>
  
  
  
  
  
  
  
  
  
  <?php
  
  //echo "7777777777777777";
  
  
  $query="SELECT *
  FROM  
    tbl_objects AS t1 
  WHERE
    status='0' AND 
    obj_type_id='1'
  ORDER BY
   date_upped DESC,
   obj_price_sell ASC
  ";
  
  $i=0;
  $res=$db->query($query); 
  $kolvo=$res->num_rows;
  
   ?>     
 
 
 
 <div class="content_cover">
    <div class="content_inner">
       

<?php

    
    
if ($glogged==1) { // Пользователь авторизован
  $showme=true;

  if (count($_POST)>0) {
  // Если что-то передано через POST - проверка на вшивость!
    
    $errorlist="";
    // здесь вставляется проверка параметров (добавление гаража)
    require "./_parts/check_garazh.php";
    
    
    if ($errorlist!="") {
    // Если были обнаружены ошибки при проверке формы
      echo "<div style=\"margin:7px;\"><b style=\"color:red;\">".$errorlist."</b></div>";
    } else {
    // Если ошибок нет
      // Добавляем объект в базу
      
      $query="INSERT INTO sell_gar SET ";
      //$query.="status='0',";
      //$query.="checked_fl='0',";
      $query.="usr_id='".$_SESSION['id']."',";
      $query.="usr_ip='".$_SERVER['REMOTE_ADDR']."',";
      $query.="usr_host='".$_SERVER['REMOTE_HOST']."',";
      $query.="date_created='".time()."',";
      $query.="date_upped='".time()."',";
      //$query.="date_edited='0',";
      //$query.="date_deleted='0',";
      
      $query.="geo_gorod_id='".$db->escape_string($_POST['geo_gorod_id'])."',";
      if (($_POST['geo_gorod_id']=="-1") && (strlen(trim($_POST['geo_gorod']))>0) ) {
        $query.="geo_gorod='".$db->escape_string($_POST['geo_gorod'])."',";
      };
      
      // Для гаража
      // +++++++++++++++++++++++++
      $query.="geo_place='".$db->escape_string($_POST['geo_place'])."',";
      $query.="gar_pl='".$db->escape_string(str_replace(",", ".", $_POST['gar_pl']))."',";
      // +++++++++++++++++++++++++
      
      $query.="descr='".$db->escape_string($_POST['descr'])."',";
      
      $query.="price='".$db->escape_string($_POST['price'])."',";
      $query.="price_torg='".$db->escape_string($_POST['price_torg'])."',";
      
      $query.="contacts='".$db->escape_string($_POST['contacts'])."'"; // конец запроса - без запятой
      

      $query.=";";
      
      $res=$db->query($query);
      
      echo "<h2>Поздравляем!</h2>";
      echo "<b style=\"color:green\">Ваше объявление добавлено!</b> Посмотреть опубликованное объявление можно <a href=\"./prodam_garazh.php?id=".mysql_insert_id($db)."\" class=\"link\">здесь</a>.<br>"; 
      unset($_POST);
      $showme=false;
      
    }; // (список ошибок пуст)

  
  }; // (в посте что-то есть, count($_POST)>0)
  
  
  if ($showme) {
?>    
    


       <h2>Продать гараж в Великом Новгороде</h2>
       <div class="clear"></div>
       
       <form name="myform" action="garazh_add.php" method="post">
       <!-- ТАБЛИЦА -->
       <table width="690" cellpadding="5" cellspacing="0">
       
       <tr>
         <td>Населенный пункт * :</td>
         <td>
           <select name="geo_gorod_id" id="gorod_id" onchange="show_block_g('div_gorod',this.value);">
             <?php printselectsortdef($db, 'spr_geo_gorod', 'sort', 'ASC', $_POST['geo_gorod_id']);?>
           </select>
           <div id="div_gorod" style="display:none;">
             <input style="display:inline;" size="15" name="geo_gorod" type="edit" value="<?php if (isset($_POST['geo_gorod'])) { echo $_POST['geo_gorod']; };?>" title="Введите название населенного пункта (если его нет в списке слева)">
           </div>
         </td>
       </tr>
       
       
       <tr>
         <td>Расположение * :</td>
         <td>
           <input name="geo_place" size="20" type="edit" maxlength="100" value="<?php if (isset($_POST['geo_place'])) { echo $_POST['geo_place']; };?>"> (Пример: Григоровский гаражный комплекс, пр. Корсунова)
         </td>
       </tr>
       

       <tr>
         <td>Площадь гаража (м<sup>2</sup>) * :</td>
         <td>
           <input name="gar_pl" size="4" type="edit" value="<?php if (isset($_POST['gar_pl'])) { echo $_POST['gar_pl']; };?>">
         </td>
       </tr>
       
       <tr>
         <td>Стоимость (тыс. руб.) * :</td>
         <td>
           <input name="price" size="8" type="edit" value="<?php if (isset($_POST['price'])) { echo $_POST['price']; };?>"> (ВНИМАНИЕ! Стоимость в тыс. руб., не рисуйте лишних нулей!!!)
         </td>
       </tr>
       
       <tr>
         <td>Торг:</td>
         <td>
           <select name="price_torg">
           <?php printselectdef($db, 'spr_obj_price_torg', $_POST['price_torg']); ?>
           </select>
         </td>
       </tr>
       
       <tr>
         <td>Примечание:</td>
         <td>
           <textarea title="Дополнительная информация по комнате (Например: сделан евроремонт, установлены стеклопакеты)" name="descr" cols="30" rows="4"><?php if (isset($_POST['descr'])) { echo $_POST['descr']; }; ?></textarea>
         </td>
       </tr>
       
       <?php
             $prepared_phone='';
             if (strlen($_SESSION['phone'])==6)  { 
               $prepared_phone="(8162) ".$_SESSION['phone'];  
             }; 
             if (strlen($_SESSION['phone'])==10) { 
               $prepared_phone="+7".$_SESSION['phone'];      
             }; 
       ?>
         
       <tr>
         <td>Контакты * :</td>
         <td>
           <textarea title="Укажите контактный данные" name="contacts" cols="30" rows="4"><?php 
            if (isset($_POST['contacts'])) {
               echo $_POST['contacts']; 
            } else {
               if (strlen($prepared_phone)>0) {
                 echo "Тел. ".$prepared_phone;
               }; 
            };
             ?></textarea>
         </td>
       </tr>
       
       <tr>
         <td></td>
         <td><input type="submit" value="Опубликовать объявление"></td>
       </tr>
         
         
         
       <script language="javascript">
         show_block_g('div_gorod',document.getElementById('gorod_id').value);
       </script>
       
       </table>
       <!-- / ТАБЛИЦА -->
       </form>
       <div class="clear"></div>
    
    
<?php   
  };


 
} else { //($glogged==1)
?>         


<h2>Ошибка доступа</h2>
<p>
Добавление объявлений доступно только <a href="./register.php" class="link">зарегистрированным</a> пользователям.
</p>

         
         
<?php
}; //($glogged==1)
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