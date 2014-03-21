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
  <title>Каталог компаний - Недвижимость, строительство, ремонт, дизайн, мебель на заказ в Великом Новгороде - Проект &laquo;Новгородская квартира&raquo;</title>
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
      
      <div class="r_date">
           <a href="http://www.novspravka.ru/price.php" class="link"><img width="16" height="16" align="absmiddle" src="./pics/ico_add.png" border="0"></a> 
           <a href="http://www.novspravka.ru/price.php" class="link">Добавить компанию в справочник</a>
       </div>
      
      <div class="otstup"> <!-- otstup --> 
      
      <h2><!--Каталог компаний: <br>-->
      Недвижимость, строительство, ремонт, дизайн, <br>
      мебель на заказ в Великом Новгороде и Новгородской области</h2>
       
      <p>
      <script type="text/javascript" src="http://www.novspravka.ru/novspravka_companies_vn.js.php"></script>      
      </p>
      
      <p>
      Информация предоставлена проектом <a class="link" href="http://www.novspravka.ru/" target="_blank">&laquo;Новгородская справка&raquo;</a>. &laquo;Новгородская справка&raquo; - это иллюстрированный справочник товаров и услуг Великого Новгорода и Новгородской области.
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