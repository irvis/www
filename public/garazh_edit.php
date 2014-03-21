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
  <title>Редактирование объявления о продаже гаража в Великом Новгороде - Проект &laquo;Новгородская квартира&raquo; (Недвижимость Великого Новгорода)</title>
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
  
  $found=false;
  if (isset($_GET['id'])) {
  
  $query="SELECT *
    FROM  
      sell_gar 
    WHERE
      status='0' AND 
      id='".intval($_GET['id'])."' AND
      usr_id='".$_SESSION['id']."';
    ";
    
    $i=0;
    $res=$db->query($query); 
    $kolvo=$res->num_rows;
    if ($kolvo>0) {
      $found=true;
      $ar=$res->fetch_assoc();
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
    // проверка параметров гаража (отправка формы)
    require "./_parts/check_garazh.php";
    
    
    if ($errorlist!="") {
      // Если были обнаружены ошибки при проверке формы
      echo "<div style=\"margin:7px;\"><b style=\"color:red;\">".$errorlist."</b></div>";
    } else {
      // Если ошибок нет
      // Обновляем объект в базе
      
      $query="UPDATE sell_gar SET ";
      //$query.="status='0',";
      //$query.="checked_fl='0',";
      $query.="usr_id='".$_SESSION['id']."',";
      $query.="usr_ip='".$_SERVER['REMOTE_ADDR']."',";
      $query.="usr_host='".$_SERVER['REMOTE_HOST']."',";
      $query.="date_edited='".time()."',";
      
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
      

      $query.="WHERE id='".intval($_GET['id'])."' AND usr_id='".$_SESSION['id']."';";
      
      $res=$db->query($query);
      
      echo "<h2>Поздравляем!</h2>";
      echo "<b style=\"color:green\">Ваше объявление успешно отредактировано!</b> Посмотреть отредактированное объявление можно <a href=\"./prodam_garazh.php?id=".intval($_GET['id'])."\" class=\"link\">здесь</a>.<br>"; 
      unset($_POST);
      $showme=false;
      
    }; // (список ошибок пуст)

    $ar=$_POST;
  }; // (в посте что-то есть, count($_POST)>0)
  
  
  if (($found) && ($showme)) {  ?>    
       <h2>Редактирование объявления о продаже гаража</h2>
       <div class="clear"></div>
       
       <form name="myform" action="garazh_edit.php?id=<?php echo intval($_GET['id']); ?>" method="post">
       <!-- ТАБЛИЦА -->
       <table width="690" cellpadding="5" cellspacing="0">
       <tr>
         <td>Населенный пункт * :</td>
         <td>
           <select name="geo_gorod_id" id="gorod_id" onchange="show_block_g('div_gorod',this.value);">
             <?php printselectsortdef($db, 'spr_geo_gorod', 'sort', 'ASC', $ar['geo_gorod_id']);?>
           </select>
           <div id="div_gorod" style="display:none;">
             <input style="display:inline;" size="15" name="geo_gorod" type="edit" value="<?php if (isset($ar['geo_gorod'])) { echo $ar['geo_gorod']; };?>" title="Введите название населенного пункта (если его нет в списке слева)">
           </div>
         </td>
       </tr>
       
       <tr>
         <td>Расположение * :</td>
         <td>
           <input name="geo_place" size="20" type="edit" maxlength="100" value="<?php if (isset($ar['geo_place'])) { echo $ar['geo_place']; };?>"> (Пример: Григоровский гаражный комплекс, пр. Корсунова)
         </td>
       </tr>
       
      
       
       <tr>
         <td>Площадь гаража (м<sup>2</sup>) * :</td>
         <td>
           <input name="gar_pl" size="4" type="edit" value="<?php if (isset($ar['gar_pl'])) { echo $ar['gar_pl']; };?>">
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
           <textarea title="Дополнительная информация по гаражу (Например: есть электричество, кессон)" name="descr" cols="30" rows="4"><?php if (isset($ar['descr'])) { echo $ar['descr']; }; ?></textarea>
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
         show_block_g('div_gorod',document.getElementById('gorod_id').value);
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