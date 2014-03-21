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
  <title>Добавить агентство по недвижимости Великого Новгорода - Проект &laquo;Новгородская квартира&raquo; - Недвижимость Великого Новгорода</title>
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
        <b>Организации по работе с недвижимостью в Великом Новгороде и Новгородской области</b>
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
    // здесь вставляется проверка параметров (добавление комнаты)
    require "./_parts/check_agentstvo.php";
    
    
    if ($errorlist!="") {
    // Если были обнаружены ошибки при проверке формы
      echo "<div style=\"margin:7px;\"><b style=\"color:red;\">".$errorlist."</b></div>";
    } else {
    // Если ошибок нет
      // Добавляем объект в базу
      
      
      if (get_magic_quotes_gpc()==0) {
        $f_ag_name=addslashes($_POST['ag_name']);
        $f_ag_spec=addslashes($_POST['ag_spec']);
        $f_ag_adres=addslashes($_POST['ag_adres']);
        $f_ag_tel=addslashes($_POST['ag_tel']);
        $f_ag_fax=addslashes($_POST['ag_fax']);
        $f_ag_rezhim=addslashes($_POST['ag_rezhim']);
        $f_ag_descr=addslashes($_POST['ag_descr']);
        $f_p_name=addslashes($_POST['p_name']);
        $f_p_worker=addslashes($_POST['p_worker']);
        $f_p_tel=addslashes($_POST['p_tel']);
        // mysql_real_escape_string()
      };
      
      
      
      $query="INSERT INTO book_agent SET ";
      //$query.="status='0',";
      //$query.="checked_fl='0',";
      $query.="usr_id='".$_SESSION['id']."',";
      $query.="usr_ip='".$_SERVER['REMOTE_ADDR']."',";
      $query.="usr_host='".$_SERVER['REMOTE_HOST']."',";
      $query.="date_created='".time()."',";
      $query.="date_upped='".time()."',";
      //$query.="date_edited='0',";
      //$query.="date_deleted='0',";
      $query.="ag_name='".$f_ag_name."',";
      $query.="ag_spec='".$f_ag_spec."',";
      $query.="ag_adres='".$f_ag_adres."',";
      $query.="ag_tel='".$f_ag_tel."',";
      $query.="ag_fax='".$f_ag_fax."',";
      $query.="ag_rezhim='".$f_ag_rezhim."',";
      $query.="ag_descr='".$f_ag_descr."',";
      $query.="p_name='".$f_p_name."',";
      $query.="p_worker='".$f_p_worker."',";
      $query.="p_tel='".$f_p_tel."'"; // конец запроса - без запятой

      $query.=";";
      
      $res=$db->query($query);
      
      
      // создаем наше сообщение
      $mess = '
Дата: '.date("d.m.Y, H:i",time()).'
IP-адрес: '.$_SERVER['REMOTE_ADDR'].'

Название агентства: '.$f_ag_name.'
Специфика: '.$f_ag_spec.'
Адрес: '.$f_ag_adres.'
Телефоны: '.$f_ag_tel.'
Факс: '.$f_ag_fax.'
Режим работы: '.$f_ag_rezhim.'
Краткое описание: '.$f_ag_descr.'

Имя: '.$f_p_name.'
Должность: '.$f_p_worker.'
Телефон для связи: '.$f_p_tel;

        // $to - кому отправляем
        $to = 'admin@novkva.ru';
        // $from - от кого
        $from=$_SESSION['email'];
        mail($to, "Новое агентство на сайт NOVKVA.RU", $mess, "From:".$from);
        //echo 'Спасибо! Ваше письмо отправлено.';
      
      
      echo "<h2>Поздравляем!</h2>";
      echo "<b style=\"color:green\">Заявка №".$db->insert_id." отправлена на модерацию!</b> Если форма заполнена верно, в ближайшее время информация о Вашем агентстве должна будет появиться на нашем сайте в разделе <a class=\"link\" href=\"./agentstva_nedvizhimosti_velikogo_novgoroda.php\">&laquo;Агентства Недвижимости Великого Новгорода&raquo;</a>. Если этого не произойдет, пожалуйста, свяжитесь с нами по телефону или электронной почте, указанным внизу страницы.<br>"; 
      unset($_POST);
      $showme=false;
      
    }; // (список ошибок пуст)

  
  }; // (в посте что-то есть, count($_POST)>0)
  
  
  if ($showme) {
?>    
    


       <h2>Добавить агентство по недвижимости Великого Новгорода</h2>
       <div class="clear"></div>
       
       <form name="myform" action="agentstvo_add.php" method="post">
       <!-- ТАБЛИЦА -->
       <table width="500" cellpadding="5" cellspacing="0">
       
       <tr>
         <td>Название агентства * :</td>
         <td>
           <input name="ag_name" maxlength="100" type="edit" size="30" value="<?php if (isset($_POST['ag_name'])) { echo htmlspecialchars($_POST['ag_name']); };?>" title="Полное название агентства, без сокращений. <br>Например: Агентство недвижимости &laquo;Дом&raquo;">
         </td>
       </tr>
       
       
       <tr>
         <td>Специфика * :</td>
         <td>
           <input name="ag_spec" maxlength="200" type="edit" size="30" value="<?php if (isset($_POST['ag_spec'])) { echo htmlspecialchars($_POST['ag_spec']); };?>" title="Специфика сферы деятельности агентства. <br>Например: только аренда посуточно / только продажа загородной недвижимости">
         </td>
       </tr>
       
       <tr>
         <td>Адрес * :</td>
         <td>
           <input name="ag_adres" maxlength="150" type="edit" size="30" value="<?php if (isset($_POST['ag_adres'])) { echo htmlspecialchars($_POST['ag_adres']); };?>">
         </td>
       </tr>
       
       <tr>
         <td>Телефоны * :</td>
         <td>
           <input name="ag_tel" maxlength="150" type="edit" size="20" value="<?php if (isset($_POST['ag_tel'])) { echo htmlspecialchars($_POST['ag_tel']); };?>">
         </td>
       </tr>
       
       <tr>
         <td>Факс * :</td>
         <td>
           <input name="ag_fax" maxlength="100" type="edit" size="15" value="<?php if (isset($_POST['ag_fax'])) { echo htmlspecialchars($_POST['ag_fax']); };?>">
         </td>
       </tr>
       
       <tr>
         <td>Режим работы * :</td>
         <td>
           <input name="ag_rezhim" maxlength="100" type="edit" size="30" value="<?php if (isset($_POST['ag_rezhim'])) { echo htmlspecialchars($_POST['ag_rezhim']); };?>" title="Режим работы агентства. <br>Например: ПН-ПТ с 10:00 до 20:00; СБ,ВС - выходной.">
         </td>
       </tr>
       
       
      
      
       
       <tr>
         <td>Краткое описание * :</td>
         <td>
           <textarea title="Краткое описание агентства (до 200 символов)" name="ag_descr" cols="30" rows="4"><?php if (isset($_POST['ag_descr'])) { echo htmlspecialchars($_POST['ag_descr']); }; ?></textarea>
         </td>
       </tr>
       
       
       
       
       <tr>
         <td colspan="2">&nbsp;</td>
       </tr>
       
       <tr>
         <td colspan="2"><b>Сведения о подателе информации</b></td>
       </tr>
       
       <tr>
         <td>Имя * :</td>
         <td>
           <input name="p_name" maxlength="150" type="edit" size="30" value="<?php if (isset($_POST['p_name'])) { echo htmlspecialchars($_POST['p_name']); };?>">
         </td>
       </tr>
       
       <tr>
         <td>Должность * :</td>
         <td>
           <input name="p_worker" maxlength="100" type="edit" size="15" value="<?php if (isset($_POST['p_worker'])) { echo htmlspecialchars($_POST['p_worker']); };?>">
         </td>
       </tr>
       
       <tr>
         <td>Телефон для связи * :</td>
         <td>
           <input name="p_tel" maxlength="100" type="edit" size="15" value="<?php if (isset($_POST['p_tel'])) { echo htmlspecialchars($_POST['p_tel']); };?>">
         </td>
       </tr>
       
       
       
         
       <tr>
         <td colspan="2">&nbsp;</td>
       </tr>
       
       <tr>
         <td></td>
         <td><input type="submit" value="Отправить данные"></td>
       </tr>
         
         
         
      
       
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