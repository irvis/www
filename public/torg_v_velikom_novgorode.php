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
  <title>Торговые помещения в Великом Новгороде (в аренду и на продажу) - Проект &laquo;Новгородская квартира&raquo; (Недвижимость Великого Новгорода)</title>
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
        <b>Аренда и продажа торговых помещений в Великом Новгороде</b>
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
       <h2>Аренда и продажа ТОРГОВЫХ помещений в Великом Новгороде</h2>
       <div class="clear"></div>
       
       
       <!--
       <a href="./pics/realty/kn_office_662x120_001_big.jpg" target="_blank"><img width="662" height="120" style="display:inline;float:left;margin-right:20px;margin-bottom:20px;border:1px solid #acabab;" alt="Сдам помещение в Великом Новгороде по ул. Ломоносова, д.8" title="Просмотр увеличенной фотографии (откроется в новом окне)" src="./pics/realty/kn_office_662x120_001.jpg"></a>
       -->
       
    
       <img height="120" width="320" style="display:inline;float:left;margin-right:20px;margin-bottom:20px;border:1px solid #acabab;" alt="Аренда помещения под магазин в Великом Новгороде" src="./pics/realty/320x120_office_002.jpg"/>
       
       <img height="120" width="320" style="display:inline;float:left;margin-right:20px;margin-bottom:20px;border:1px solid #acabab;" alt="Аренда торговых помещений в Великом Новгороде" src="./pics/realty/320x120_torg_004.jpg"/>
       
       
      
      

      
       
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