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
  <title>Продажа трёхкомнатных квартир Великого Новгорода по улицам города - Проект &laquo;Новгородская квартира&raquo; - Недвижимость Великого Новгорода.</title>
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
      
      
      
      <table cellspacing="0" cellpadding="0" border="0" width="680" style="margin-top:10px;">
      
      <!-- Первая строка -->
      <tr>
      
        <td width="160" align="left" valign="top">
          <img src="./pics/large_icon_kvartira.jpg" width="156" height="156" alt="Продажа квартир в Великом Новгороде" style="display:inline;float:left;margin-right:10px;margin-bottom:10px;border:1px solid #acabab;">
          <div class="clear"></div>
          <a href="./kvartira_add.php" class="link"><img border="0" align="absmiddle" src="./pics/ico_ob_plus.png" title="Добавить объявление (продажа квартир)"></a>
          <a href="./kvartira_add.php" class="link">Продать квартиру</a><br>
          
        </td>
        
        <td align="left" valign="top">
        
        <h2 style="margin-top:0px;">Продажа трёхкомнатных квартир по улицам города</h2>
        
        <p>
        На данной странице в удобном виде представлен список объявлений о продаже трёхкомнатных квартир в Великом Новгороде, опубликованных на сайте проекта &laquo;Новгородская квартира&raquo; за последние 30 дней. Улицы следуют в алфавитном порядке, а квартиры по каждой улице расположены в порядке увеличения стоимости. 
        </p>
          
          
        <?php
            
            
            
            
            // ========================================================================================
            $dn=30;
            $query="SELECT t1.id,t2.id AS street_id, t2.title_d 
                    FROM sell_kva AS t1, spr_geo_street AS t2
                    WHERE     t1.status='0'
                          AND t1.geo_gorod_id='1'
                          AND t1.date_upped>='".(time()-$dn*24*60*60)."'
                          AND t1.geo_gorod_id='1'
                          AND t1.geo_street_id=t2.id
                          
                          AND t1.geo_street_id!='-1'
                          AND t1.geo_street_id!='0'
                          
                          AND t1.kva_rooms='3'
                      
                    ORDER BY t2.title ASC, t1.price ASC
                    ;
                    ";
            $res=mysql_query($query,$db);
            $kv_kolvo=mysql_num_rows($res);
            
            if ($kv_kolvo>0) {
              $old_street=0; // для разделения по улицам
              while ($ar=mysql_fetch_assoc($res)) {
                if ($old_street!=$ar['street_id'])  {
                  echo "<h2 style=\"margin-bottom:0px;color:#66b7ec;\">".get_street_by_id2 ($db, $ar['street_id'])."</h2>";
                  $old_street=$ar['street_id'];
                };
                echo get_kv_obyav_by_id($db,$ar['id'])." <a href=\"./prodam_kvartiru.php?id=".(int)$ar['id']."\" class=\"link\"><img border=\"0\" align=\"absmiddle\" src=\"./pics/ico_arrow.png\" width=\"16\" height=\"16\" title=\"Подробнее\"></a><br>";
              
              }; //while
            };
            // ======================================================================================
          ?>
        <br><br>
        </td>
      
      </tr>
      <!-- / Первая строка -->


      
      
      
      
      
      </table>
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      <div class="clear"></div>
      
      
      
      
      
      
      
      
      
      
      </div> <!-- otstup --> 
      
    </div>
    
    
    
  
  
  

  



  
  
  
  
  
  
    
    
    
    
    
    
  </div> <!-- content box -->
  
  
  
  
  
  
  
  
  
  
  
  
  
  
 
  
  
  
  
  
  
  
  
  
  
  
  
  

  
  
  
  
  
  
  
  
  
  
  
  
  
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