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
  <title>Наши информеры - Проект &laquo;Новгородская квартира&raquo;</title>
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
  <div class="content_box">
  <div class="content_header">
        <div class="content_inner">
        <b>Проект &laquo;Новгородская квартира&raquo;</b>
        </div>
  </div>
  <div class="clear"></div>
  <div class="content_cover">
    <div class="content_inner">
      
      <div class="otstup"> <!-- otstup --> 
      
      <h2>Наши информеры</h2>
       
      <p>
      
      <table cellpadding="5" cellspacing="0" border="0">
      
      
      
      <tr>
        <td valign="bottom">Информер стоимости 1 кв. метра<br>жилья в Великом Новгороде</td>
        <td valign="bottom">HTML-код для вставки информера на сайт:</td>
      </tr>
      
      <tr>
        <td valign="top">    
          <a href="./index.php" target="_blank"><img src="./inf/informer_kvam.php" width="200" height="200" title="Недвижимость Великого Новгорода - Проект Новгородская Квартира" alt="Стоимость 1 кв. метра жилья в Великом Новгороде - Проект Новгородская Квартира" border="0"></a>
        </td>
        <td valign="top">
          <textarea onclick="this.select()" style="width:450px;height:100px;"><a href="http://www.novkva.ru/" target="_blank"><img src="http://www.novkva.ru/inf/informer_kvam.php" width="200" height="200" title="Недвижимость Великого Новгорода - Проект Новгородская Квартира" alt="Стоимость 1 кв. метра жилья в Великом Новгороде - Проект Новгородская Квартира" border="0"></a></textarea>
        </td>
      </tr>
      </table>
      
      </p>
      
      </div> <!-- otstup --> 
      
    </div>
  </div>
  
  
  
  
  
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