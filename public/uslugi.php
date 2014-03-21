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
  <title>Проект &laquo;Новгородская квартира&raquo; - Реклама на сайте.</title>
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
      
      <h2>Наши услуги</h2>
      
      <p>Добро пожаловать к нам на сайт! :) Наш проект предлагает Вам воспользоваться бесплатным доступом к сайту либо приобрести платный доступ. Что лучше, и в чем заключаются различия - читайте ниже.</p>
      
      <h2 style="margin-top:40px;">Бесплатный доступ: возможности и ограничения</h2>
       
      <p>
      Собственники недвижимости и агенты могут размещать объявления о продаже или аренде жилых помещений на нашем сайте совершенно бесплатно. Поднимать объявление можно не чаще одного раза в три дня. Например, если объявление было опубликовано Вами в понедельник, поднять его можно будет не раньше четверга. Также у бесплатного доступа отсутствует возможность публикации объявлений в разделе коммерческой недвижимости. Указанные ограничения снимаются при заказе платного доступа.</p>
      
     
      
      <a name="paid" href=""></a> 
      <h2 style="margin-top:40px;">Платный доступ: расценки, подарки и бонусы</h2>
      
      <style>
      .bigga {
        font-family:Arial;
        font-size:22px;
      }
      </style>
      
      <!-- ТАБЛИЦА -->
       <table width="540" cellpadding="5" class="st" cellspacing="0">

       <tr class="tr_buy">
         <td align="center" width="110"><b>Период</b></td>
         <td align="center" width="110"><b>Стоимость</b></td>
         <td align="center"><b>Подарки и бонусы</b></td>
       </tr>
       
       
       <!-- Первая строка -->
       <tr>
         <td align="center"><b class="bigga">1</b> месяц</td>
         <td align="center"><b class="bigga">500</b> руб.</td>
         <td align="center">Пробный доступ: без бонусов и подарков :(</td>
       </tr>
       
       <!-- Вторая строка -->
       <tr>
         <td align="center"><b class="bigga">3</b> месяца</td>
         <td align="center"><b class="bigga">1400</b> руб.</td>
         <td align="center">
           <img src="./pics/podarok_cup.jpg" width="150" height="134" title="При оплате периода от 3 месяцев - кружка с логотипом проекта &laquo;Новгородская квартира&raquo; в подарок! :)">
         </td>
       </tr>
       

       <!-- Третья строка -->
       <tr>
         <td align="center"><b class="bigga">6</b> месяцев</td>
         <td align="center"><b class="bigga">2600</b> руб.</td>
         <td align="center">
           <img src="./pics/podarok_cup.jpg" width="150" height="134" title="При оплате периода от 3 месяцев - кружка с логотипом проекта &laquo;Новгородская квартира&raquo; в подарок! :)">
         </td>
       </tr>
       
       <!-- Четвертая строка -->
       <tr>
         <td align="center"><b class="bigga">12</b> месяцев</td>
         <td align="center"><b class="bigga">5000</b> руб.</td>
         <td align="center">
           <img src="./pics/podarok_cup.jpg" width="150" height="134" title="При оплате периода от 3 месяцев - кружка с логотипом проекта &laquo;Новгородская квартира&raquo; в подарок! :)">
         </td>
       </tr>
       
      
       </table>
       
       
       <h2 style="margin-top:40px;">Преимущества платного доступа</h2>
      
      <table width="560" cellpadding="3" cellspacing="0">
      
      <tr>
        <td valign="top" align="center"><img src="./pics/ico_tick_green.png" align="absmiddle" border="0" width="16" height="16"></td>
        <td valign="top">Возможность включения <b>автоматического поднятия</b> для всех Ваших объявлений: объявления будут автоматически подниматься 1 раз в сутки;</td>
      </tr>
      
      <tr>
        <td valign="top" align="center"><img src="./pics/ico_tick_green.png" align="absmiddle" border="0" width="16" height="16"></td>
        <td valign="top">Возможность публикации объявлений по <b>коммерческой недвижимости</b>;</td>
      </tr>
      
      <tr>
        <td valign="top" align="center"><img src="./pics/ico_tick_green.png" align="absmiddle" border="0" width="16" height="16"></td>
        <td valign="top">Для агентств: <b>добавление логотипа и ссылки на сайт</b> для Вашего агентства в нашем списке <a href="./agentstva_nedvizhimosti_velikogo_novgoroda.php" class="link">агентств недвижимости Великого Новгорода</a>, приоритетное позиционирование в списке. Смотреть <a href="./pics/demo_agentstvo_logo.jpg" target="_blank" class="link">пример</a>;</td>
      </tr>
       
      <tr>
        <td valign="top" align="center"><img src="./pics/ico_tick_green.png" align="absmiddle" border="0" width="16" height="16"></td>
        <td valign="top">Если Вам чего-либо не хватает на нашем сайте, мы готовы разработать для Вас недостающий функционал! ;)</td>
      </tr>
      
      
      </table>
       
       
      
      
      
      
      
      
      <h2 style="margin-top:40px;">Мы собираем для Вас целевую аудиторию</h2>
       
       <p>
       Большую долю средств мы направляем на продвижение проекта <a href="http://www.novkva.ru/" class="link">&laquo;Новгородская квартира&raquo;</a>, а, следовательно, на привлечение Вашей новой целевой аудитории. Тем самым мы повышаем эффективность работы нашего ресурса как для обычных посетителей, так и для агентов и собственников недвижимости.</p>
       
       <div class="clear"></div>       
       <img src="./pics/reklama_novkva_06.jpg" class="reklama_demopic" alt="Поисковое продвижение и SEO-оптимизация" title="Поисковое продвижение и SEO-оптимизация" width="210" height="160">
       <img src="./pics/reklama_novkva_03.jpg" class="reklama_demopic" alt="Реклама в общественном транспорте" title="Реклама в общественном транспорте" width="210" height="160">
       <img src="./pics/reklama_novkva_01.jpg" class="reklama_demopic" alt="Печать листовок и флаеров" title="Печать листовок и флаеров" width="210" height="160">
       <img src="./pics/reklama_novkva_02.jpg" class="reklama_demopic" alt="Реклама в печатных изданиях" title="Реклама в печатных изданиях" width="210" height="160">
       
       <img src="./pics/reklama_novkva_04.jpg" class="reklama_demopic" alt="Реклама на транспорте" title="Реклама на транспорте" width="210" height="160">
       <img src="./pics/reklama_novkva_05.jpg" class="reklama_demopic" alt="Реклама на спортивных мероприятиях" title="Реклама на спортивных мероприятиях" width="210" height="160">
       
       
       <div class="clear"></div>
       
       <p>Продвижение включает в себя (но этим не ограничивается): печать листовок, флаеров и их раздачу на улицах, изготовление и размещение баннеров на посещаемых новгородских интернет-площадках, размещение рекламы в сети Интернет: в социальных сетях и сетях контекстной рекламы; изготовление сувенирной продукции с нашим логотипом и адресом проекта <a href="http://www.novkva.ru/" class="link">&laquo;Новгородская квартира&raquo;</a> в сети Интернет и т. д. и т. п.</p>
       
       
      
      
      
      

      
      
      
      
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
    <?php require "./_parts/page_counters.php"; 
    ?>
  </div>
  </div>
</td>
</tr>
<!-- /Подножие -->

</table>






<div class="clear"></div>









</body>
</html>