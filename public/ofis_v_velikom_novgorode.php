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
  <title>Помещения под офис в Великом Новгороде (в аренду и на продажу) - Проект &laquo;Новгородская квартира&raquo; (Недвижимость Великого Новгорода)</title>
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
        <b>Аренда и продажа офисных помещений в Великом Новгороде</b>
        </div>
  </div>

  <div class="clear"></div>
  
  
  
  
  
  
  
  
  
     
 
 
 
 <div class="content_cover">
    <div class="content_inner" style="width:690px;">
       
       
       
        
       <div class="r_date">
           <a href="./uslugi.php" class="link"><img width="16" height="16" align="absmiddle" src="./pics/ico_add.png" border="0"></a> 
           <a href="./uslugi.php" class="link" onclick="return confirmRealty();">Добавить объявление</a>
       </div>
       
       <div class="clear"></div>
       <h2>Аренда и продажа ОФИСНЫХ помещений в Великом Новгороде</h2>
       <div class="clear"></div>
       
       <img height="120" width="662" style="display:inline;float:left;margin-right:20px;margin-bottom:20px;border:1px solid #acabab;" alt="Сдам офисные помещения в Великом Новгороде по ул. Нехинская" src="./pics/realty/660x120_office_003.jpg"/>
       
       <img height="120" width="320" style="display:inline;float:left;margin-right:20px;margin-bottom:20px;border:1px solid #acabab;" alt="Аренда офисных помещений в Великом Новгороде" src="./pics/realty/320x120_office_001.jpg"/>
       
       <img height="120" width="320" style="display:inline;float:left;margin-right:20px;margin-bottom:20px;border:1px solid #acabab;" alt="Аренда помещений под офис в Великом Новгороде" src="./pics/realty/320x120_office_002.jpg"/>
       
       
      
      

      
       
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