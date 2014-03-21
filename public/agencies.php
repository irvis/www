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
  <title>Агентства недвижимости Великого Новгорода - Проект &laquo;Новгородская квартира&raquo; - Недвижимость Великого Новгорода</title>
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
  
  
  
  

  
  $query="SELECT *
  FROM  
     book_agent
  WHERE
    status='0' AND checked='1'
  ORDER BY
    special_id DESC, date_upped DESC 
   ;";
  
  $i=0;
  $res=$db->query($query); 
  $kolvo=$res->num_rows;
  
   ?>       
 
 
 
 <div class="content_cover">
    <div class="content_inner">
       
       
       
        
       <div class="r_date">
           <a href="./agentstvo_add.php" class="link"><img width="16" height="16" align="absmiddle" src="./pics/ico_add.png" border="0"></a> 
           <a href="./agentstvo_add.php" class="link">Добавить агентство</a>
       </div>
       
       <h2>Агентства Недвижимости Великого Новгорода</h2>
       <?php require "./_parts/adsense_tabl_verx.php";      ?>
	   <div class="clear"></div>
       
       <img src="./pics/ico_filter.gif" width="18" height="18" align="absmiddle" border="0">
       <b>Агентств в базе: <?php echo $kolvo; ?> шт.</b>
       
       <div class="clear" style="margin-top:10px;"></div>
       
       <!-- ТАБЛИЦА -->
       <table width="690" cellpadding="5" class="st" cellspacing="0">
       <tr class="tr_buy">
         <td align="center" width="80"><b>Агентство</b></td>
         <td align="center" width="260"><b>Описание</b></td>
         <td align="center"><b>Адрес</b></td>
         <td align="center"><b>Контакты</b></td>
       </tr>
       
      <?php 
      while (($ar=$res->fetch_assoc()) == true ) {
        $i=$i+1;

        if ($ar['special_id']==0) {
        // Обычная публикация:
      ?>
      <tr>
         <td align="center" valign="top"><?php echo $ar['ag_name']; ?></td>
         <td align="left" valign="top"><?php echo "<b>".$ar['ag_spec']."</b><br>".$ar['ag_descr']; ?></td>
         <td align="left" valign="top"><?php echo $ar['ag_adres']; ?></td>
         <td align="left" valign="top"><?php echo "<b>Телефон:</b><br>".$ar['ag_tel']."<br><b>Факс:</b><br>".$ar['ag_fax']."<br><b>Режим работы</b><br>".$ar['ag_rezhim']; ?></td>
      </tr>
      <?php
        } else {
        // Приоритетная публикация:
      ?>
      <tr>
         <td align="center" valign="top">
           
           <? if ($ar['special_link_u']!='') { ?>
           
           <a class="link" href="<?php echo $ar['special_link_u']; ?>" target="_blank"><img src="<?php echo $ar['special_logo']; ?>" style="border:0px solid #d6d6d6;margin-bottom:4px;" width="150"></a>
           <div class="clear"></div>
           
           <? } else { // если нет ссылки на свой сайт, тогда просто логотип ?>
           
           <img src="<?php echo $ar['special_logo']; ?>" style="border:0px solid #d6d6d6;margin-bottom:4px;" width="150">
           <div class="clear"></div>
           
           <? }; ?>
           
           
           <b><?php echo $ar['ag_name']; ?></b>
         </td>
         <td align="left" valign="top"><?php echo "<b>".$ar['ag_spec']."</b><br>".$ar['ag_descr']; ?>
           <? if ($ar['special_link_t']!='') { ?>
             <br><br><b>Сайт компании:</b> <a class="link" href="<?php echo $ar['special_link_u']; ?>" target="_blank"><?php echo $ar['special_link_t']; ?></a>
           <? }; ?>
         </td>
         <td align="left" valign="top"><?php echo $ar['ag_adres']; ?></td>
         <td align="left" valign="top"><?php echo "<b>Телефон:</b><br>".$ar['ag_tel']."<br><b>Факс:</b><br>".$ar['ag_fax']."<br><b>Режим работы</b><br>".$ar['ag_rezhim']; ?></td>
      </tr>
      <?php
        };
      
      };
       
      ?> 
       
      
       
       
       </table>
       <!-- / ТАБЛИЦА -->
      
      <?php require "./_parts/adsense_tabl_niz.php";      ?>

      
       
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