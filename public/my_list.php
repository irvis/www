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
  <title>Мои объявления - Проект &laquo;Новгородская квартира&raquo; - Недвижимость Великого Новгорода.</title>
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
        <b>Недвижимость в Великом Новгороде и Новгородской области</b>
        </div>
  </div>

  <div class="clear"></div>
  


 <div class="content_cover">
    <div class="content_inner">
       
  <?php
  
  if ($glogged==1) { // Пользователь авторизован
  
  // Продажа КОМНАТ 
  // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

       $sort="date_upped DESC";
       $query="SELECT *
               FROM  
                 sell_kmn 
               WHERE
                 status='0' AND usr_id='".$_SESSION['id']."'
               ORDER BY
               ".$sort.";";
       $i=0;
       $res=$db->query($query); 
       $kolvo=$res->num_rows;
  
  if ($kolvo>0) {
  
  ?> 
       
       
       <h2>Мои объявления: продам комнату</h2>
       <div class="clear"></div>
       
       <img src="./pics/ico_filter.gif" width="18" height="18" align="absmiddle" border="0">
       <b>Найдено <?php echo $kolvo; ?> объектов</b>
       
       <div class="clear" style="margin-top:10px;"></div>
       
       <!-- ТАБЛИЦА -->
       <table width="690" cellpadding="5" class="st" cellspacing="0">
       <tr class="tr_buy">
         <td align="center" width="75"><b>Дата</b></td>
         <td align="center"><b>Объект</b></td>
         <td align="center"><b>Адрес</b></td>
         <td align="center"><span title="Материал"><b>М</b></span></td>
         <td align="center"><span title="Площадь"><b>Пл.</b></td>
         <td align="center"><b><span title="Этаж">Э</span></b></td>
         <td align="center"><b><span title="Балкон / лоджия">Б</span></b></td>
         <td align="center" width="90"><b>Цена</b></td>
         <td align="center" width="90"></td>
       </tr>
       
      <?php 
      while (($ar=$res->fetch_assoc()) == true ) {
        $i=$i+1;
        if ($i%2==0) {
          $class_tr=" class=\"even_buy\" ";
        } else {
          $class_tr="";
        };
        
        // ======================================================================
        // Собираем адрес комнаты
      
        // Адрес: собираем адрес объекта + адрес для URL
        $sobr_adres="";
           
        // Если город вообще указан (либо выбран из списка, либо непустой свой вариант)
        if ( ($ar['geo_gorod_id']>0) || (($ar['geo_gorod_id']==-1) && (strlen($ar['geo_gorod'])!=0)) ){
               
          // Если город выбран из списка
          if ($ar['geo_gorod_id']>0)  {
            $sobr_adres.=gettitle($db, 'spr_geo_gorod', $ar['geo_gorod_id']);
          }; 
        
          // Если город введен вручную
          if ($ar['geo_gorod_id']==-1)  {
            $sobr_adres.=$ar['geo_gorod'];
          }; 
                
                    
          // Если улица вообще указана (либо выбрана из списка, либо непустой свой вариант)
          if ( ($ar['geo_street_id']>0) || (($ar['geo_street_id']==-1) && (strlen($ar['geo_street'])!=0)) ){
                  
            // Если улица выбрана из списка
            if ($ar['geo_street_id']>0)  {
              $sobr_adres.=", ".gettitle_d($db, 'spr_geo_street', $ar['geo_street_id']);
            };  
                    
            // Если улица введена вручную
            if ($ar['geo_street_id']==-1)  {
              $sobr_adres.=", ".$ar['geo_street'];
            }; 
                
            // + номер дома
            if (strlen($ar['geo_n_doma'])!=0) {
              $sobr_adres.=", д. ".$ar['geo_n_doma'];
              // + корпус
              if (strlen($ar['geo_n_korp'])!=0) {
                $sobr_adres.=", корп. ".$ar['geo_n_korp'];
              };
            };
          // (конец) если улица вообще указана
          };
           
          
      
        };
        // ======================================================================
      ?>
      
      <tr <?php echo $class_tr; ?>>
         <td align="center" valign="top">
           <?php echo date("d.m.Y",$ar['date_upped']); ?>
           <?php if ($ar['usr_id']==$_SESSION['id']) { ?>
             <br>
             <a href="./komnata_edit.php?id=<?php echo $ar['id']; ?>" class="link"><img width="16" height="16" align="absmiddle" src="./pics/ico_edit.png" title="Редактировать объявление" border="0"></a> 
             <a href="./komnata_delete.php?id=<?php echo $ar['id']; ?>" class="link" onclick="return confirmDelete();"><img width="16" height="16" align="absmiddle" src="./pics/ico_delete.png" title="Удалить объявление" border="0"></a>
             <a href="./komnata_up.php?id=<?php echo $ar['id']; ?>" class="link"><img width="16" height="16" align="absmiddle" src="./pics/ico_up.png" title="Поднять объявление" border="0"></a>
             <a href="./uslugi.php#paid" class="link"><img width="16" height="16" align="absmiddle" src="./pics/ico_promote.png" title="Продвинуть объявление" border="0"></a>
           <?php }; ?>
         </td>
         <td align="center" valign="top"><span title="<?php echo gettitle($db, 'spr_kmn_type', $ar['kmn_type_id']); ?>"><?php echo gettitle_d($db, 'spr_kmn_type', $ar['kmn_type_id']); ?></span></td>
         <td align="center" valign="top"><?php echo $sobr_adres; ?></td>
         <td align="center" valign="top"><span title="<?php echo gettitle($db, 'spr_zd_material', $ar['zd_material_id']);?>"><?php echo gettitle_d($db, 'spr_zd_material', $ar['zd_material_id']);?></span></td>
         <td align="center" valign="top"><?php echo $ar['kmn_pl']; ?></td>
         <td align="center" valign="top"><?php echo $ar['kmn_floor']; ?>/<?php echo $ar['zd_floors']; ?></td>
         <td align="center" valign="top"><?php if ($ar['kmn_balkon']=='1') { ?><img width="16" height="16" align="absmiddle" title="Балкон/лоджия" src="./pics/ico_tick_green.png" border="0"><?php } else { echo "-"; }; ?></td>
         <td align="center" valign="top"><?php echo $ar['price']; ?> тыс. руб.<?php if (($ar['price_torg']=='4') || ($ar['price_torg']=='5')) { echo ", ".gettitle_d($db, 'spr_price_torg', $ar['price_torg']); }; ?></td>
         <td align="left"   valign="middle">
           <a href="./prodam_komnatu.php?id=<?php echo $ar['id']; ?>" class="link"><img width="16" height="16" align="absmiddle" src="./pics/ico_arrow.png" border="0"></a> 
           <a href="./prodam_komnatu.php?id=<?php echo $ar['id']; ?>" class="link">Подробнее</a>
         </td>
       </tr>

      
      <?php
      };
       
      ?> 
       
      
       
       
       </table>
       <!-- / ТАБЛИЦА -->
      
      
  <?php
  
  }; // kolvo >0
  // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  ?>    
      
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  <?php
  // Продажа КВАРТИР
  // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

       $sort="date_upped DESC";
       $query="SELECT *
               FROM  
                 sell_kva 
               WHERE
                 status='0' AND usr_id='".$_SESSION['id']."'
               ORDER BY
               ".$sort.";";
       $i=0;
       $res=$db->query($query); 
       $kolvo=$res->num_rows;
  
  if ($kolvo>0) {
  
  ?> 
       
       
       <h2>Мои объявления: продам квартиру</h2>
       <div class="clear"></div>
       
       <img src="./pics/ico_filter.gif" width="18" height="18" align="absmiddle" border="0">
       <b>Найдено <?php echo $kolvo; ?> объектов</b>
       
       <div class="clear" style="margin-top:10px;"></div>
       
       <!-- ТАБЛИЦА -->
       <table width="690" cellpadding="5" class="st" cellspacing="0">
       <tr class="tr_buy">
         <td align="center" width="75"><b>Дата</b></td>
         <td align="center" width="80"><b>Квартира</b></td>
         <td align="center"><b>Адрес</b></td>
         <td align="center"><span title="Материал"><b>М</b></span></td>
         <td align="center"><span title="Общая площадь"><b>O</b></span></td>
         <td align="center"><span title="Жилая площадь"><b>Ж</b></span></td>
         <td align="center"><span title="Площадь кухни"><b>К</b></span></td>
         <td align="center"><span title="Этаж"><b>Э</b></span></td>
         <td align="center"><b><span title="Балкон / лоджия">Б</span></b></td>
         <td align="center" width="90"><b>Цена</b></td>
         <td align="center" width="90"></td>
       </tr>
       
      <?php 
      while (($ar=$res->fetch_assoc()) == true ) {
        $i=$i+1;
        if ($i%2==0) {
          $class_tr=" class=\"even_buy\" ";
        } else {
          $class_tr="";
        };
        
        // ======================================================================
        // Собираем адрес квартиры
      
        // Адрес: собираем адрес объекта + адрес для URL
        $sobr_adres="";
           
        // Если город вообще указан (либо выбран из списка, либо непустой свой вариант)
        if ( ($ar['geo_gorod_id']>0) || (($ar['geo_gorod_id']==-1) && (strlen($ar['geo_gorod'])!=0)) ){
               
          // Если город выбран из списка
          if ($ar['geo_gorod_id']>0)  {
            $sobr_adres.=gettitle($db, 'spr_geo_gorod', $ar['geo_gorod_id']);
          }; 
        
          // Если город введен вручную
          if ($ar['geo_gorod_id']==-1)  {
            $sobr_adres.=$ar['geo_gorod'];
          }; 
                
                    
          // Если улица вообще указана (либо выбрана из списка, либо непустой свой вариант)
          if ( ($ar['geo_street_id']>0) || (($ar['geo_street_id']==-1) && (strlen($ar['geo_street'])!=0)) ){
                  
            // Если улица выбрана из списка
            if ($ar['geo_street_id']>0)  {
              $sobr_adres.=", ".gettitle_d($db, 'spr_geo_street', $ar['geo_street_id']);
            };  
                    
            // Если улица введена вручную
            if ($ar['geo_street_id']==-1)  {
              $sobr_adres.=", ".$ar['geo_street'];
            }; 
                
            // + номер дома
            if (strlen($ar['geo_n_doma'])!=0) {
              $sobr_adres.=", д. ".$ar['geo_n_doma'];
              // + корпус
              if (strlen($ar['geo_n_korp'])!=0) {
                $sobr_adres.=", корп. ".$ar['geo_n_korp'];
              };
            };
          // (конец) если улица вообще указана
          };
           
          
      
        };
        // ======================================================================
      ?>
      
      <tr <?php echo $class_tr; ?>>
         <td align="center" valign="top">
           <?php echo date("d.m.Y",$ar['date_upped']); ?>
           <?php if ($ar['usr_id']==$_SESSION['id']) { ?>
             <br>
             <a href="./kvartira_edit.php?id=<?php echo $ar['id']; ?>" class="link"><img width="16" height="16" align="absmiddle" src="./pics/ico_edit.png" title="Редактировать объявление" border="0"></a> 
             <a href="./kvartira_delete.php?id=<?php echo $ar['id']; ?>" class="link" onclick="return confirmDelete();"><img width="16" height="16" align="absmiddle" src="./pics/ico_delete.png" title="Удалить объявление" border="0"></a>
             <a href="./kvartira_up.php?id=<?php echo $ar['id']; ?>" class="link"><img width="16" height="16" align="absmiddle" src="./pics/ico_up.png" title="Поднять объявление" border="0"></a>
             <a href="./uslugi.php#paid" class="link"><img width="16" height="16" align="absmiddle" src="./pics/ico_promote.png" title="Продвинуть объявление" border="0"></a>
           <?php }; ?>
         </td>
         <td align="center" valign="top"><?php echo $ar['kva_rooms']; ?>-комн. кв.</td>
         <td align="center" valign="top"><?php echo $sobr_adres; ?></td>
         <td align="center" valign="top"><span title="<?php echo gettitle($db, 'spr_zd_material', $ar['zd_material_id']);?>"><?php echo gettitle_d($db, 'spr_zd_material', $ar['zd_material_id']);?></span></td>
         <td align="center" valign="top"><?php echo $ar['kva_pl_ob']; ?></td>
         <td align="center" valign="top"><?php echo $ar['kva_pl_zh']; ?></td>
         <td align="center" valign="top"><?php echo $ar['kva_pl_kuh']; ?></td>
         <td align="center" valign="top"><?php echo $ar['kva_floor']; ?>/<?php echo $ar['zd_floors']; ?></td>
         <td align="center" valign="top"><?php if ($ar['kva_balkon']=='1') { ?><img width="16" height="16" align="absmiddle" title="Балкон/лоджия" src="./pics/ico_tick_green.png" border="0"><?php } else { echo "-"; }; ?></td>
         <td align="center" valign="top"><?php echo $ar['price']; ?> тыс. руб.<?php if (($ar['price_torg']=='4') || ($ar['price_torg']=='5')) { echo ", ".gettitle_d($db, 'spr_price_torg', $ar['price_torg']); }; ?></td>
         <td align="left"   valign="top">
           <a href="./prodam_kvartiru.php?id=<?php echo $ar['id']; ?>" class="link"><img width="16" height="16" align="absmiddle" src="./pics/ico_arrow.png" border="0"></a> 
           <a href="./prodam_kvartiru.php?id=<?php echo $ar['id']; ?>" class="link">Подробнее</a>
         </td>
       </tr>
       
       
      
      
      
      
      <?php
      };
       
      ?> 
       
      
       
       
       </table>
       <!-- / ТАБЛИЦА -->
      
      
  <?php
  
  }; // kolvo >0
  // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  ?>    
  
  
  
  
  
  
  
  
  
  
  
  
  <?php
  // Продажа ДОМОВ
  // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

       $sort="date_upped DESC";
       $query="SELECT *
               FROM  
                 sell_dom 
               WHERE
                 status='0' AND usr_id='".$_SESSION['id']."'
               ORDER BY
               ".$sort.";";
       $i=0;
       $res=$db->query($query); 
       $kolvo=$res->num_rows;
  
  if ($kolvo>0) {
  
  ?> 
       
       
       <h2>Мои объявления: продам коттедж / дом</h2>
       <div class="clear"></div>
       
       <img src="./pics/ico_filter.gif" width="18" height="18" align="absmiddle" border="0">
       <b>Найдено <?php echo $kolvo; ?> объектов</b>
       
       <div class="clear" style="margin-top:10px;"></div>
       
       <!-- ТАБЛИЦА -->
       <table width="690" cellpadding="5" class="st" cellspacing="0">
       <tr class="tr_buy">
         <td align="center" width="75"><b>Дата</b></td>
         <td align="center" width="80"><b>Объект</b></td>
         <td align="center"><b>Адрес</b></td>
         <td align="center"><span title="Материал"><b>М</b></span></td>
         <td align="center"><span title="Количество этажей"><b>Э</b></span></td>
         <td align="center"><span title="Общая площадь"><b>О</b></span></td>
         <td align="center"><span title="Жилая лощадь"><b>Ж</b></span></td>
         <td align="center" width="90"><b>Цена</b></td>
         <td align="center" width="90"></td>
       </tr>
       
      <?php 
      while (($ar=$res->fetch_assoc()) == true ) {
        $i=$i+1;
        if ($i%2==0) {
          $class_tr=" class=\"even_buy\" ";
        } else {
          $class_tr="";
        };
        
        // ======================================================================
        // Собираем адрес дома
      
        // Адрес: собираем адрес объекта + адрес для URL
        $sobr_adres="";
           
        // Если город вообще указан (либо выбран из списка, либо непустой свой вариант)
        if ( ($ar['geo_gorod_id']>0) || (($ar['geo_gorod_id']==-1) && (strlen($ar['geo_gorod'])!=0)) ){
               
          // Если город выбран из списка
          if ($ar['geo_gorod_id']>0)  {
            $sobr_adres.=gettitle($db, 'spr_geo_gorod', $ar['geo_gorod_id']);
          }; 
        
          // Если город введен вручную
          if ($ar['geo_gorod_id']==-1)  {
            $sobr_adres.=$ar['geo_gorod'];
          }; 
                
                    
          // Если улица вообще указана (либо выбрана из списка, либо непустой свой вариант)
          if ( ($ar['geo_street_id']>0) || (($ar['geo_street_id']==-1) && (strlen($ar['geo_street'])!=0)) ){
                  
            // Если улица выбрана из списка
            if ($ar['geo_street_id']>0)  {
              $sobr_adres.=", ".gettitle_d($db, 'spr_geo_street', $ar['geo_street_id']);
            };  
                    
            // Если улица введена вручную
            if ($ar['geo_street_id']==-1)  {
              $sobr_adres.=", ".$ar['geo_street'];
            }; 
                
            // + номер дома
            if (strlen($ar['geo_n_doma'])!=0) {
              $sobr_adres.=", д. ".$ar['geo_n_doma'];
              // + корпус
              if (strlen($ar['geo_n_korp'])!=0) {
                $sobr_adres.=", корп. ".$ar['geo_n_korp'];
              };
            };
          // (конец) если улица вообще указана
          };
           
          
      
        };
        // ======================================================================
      ?>
      
      <tr <?php echo $class_tr; ?>>
         <td align="center" valign="top">
           <?php echo date("d.m.Y",$ar['date_upped']); ?>
           <?php if ($ar['usr_id']==$_SESSION['id']) { ?>
             <br>
             <a href="./dom_edit.php?id=<?php echo $ar['id']; ?>" class="link"><img width="16" height="16" align="absmiddle" src="./pics/ico_edit.png" title="Редактировать объявление" border="0"></a> 
             <a href="./dom_delete.php?id=<?php echo $ar['id']; ?>" class="link" onclick="return confirmDelete();"><img width="16" height="16" align="absmiddle" src="./pics/ico_delete.png" title="Удалить объявление" border="0"></a>
             <a href="./dom_up.php?id=<?php echo $ar['id']; ?>" class="link"><img width="16" height="16" align="absmiddle" src="./pics/ico_up.png" title="Поднять объявление" border="0"></a>
             <a href="./uslugi.php#paid" class="link"><img width="16" height="16" align="absmiddle" src="./pics/ico_promote.png" title="Продвинуть объявление" border="0"></a>
           <?php }; ?>
         </td>
         <td align="center" valign="top"><?php echo gettitle($db, 'spr_dom_type', $ar['dom_type']); ?></td>
         <td align="center" valign="top"><?php echo $sobr_adres; ?></td>
         <td align="center" valign="top"><span title="<?php echo gettitle($db, 'spr_zd_material', $ar['dom_material_id']);?>"><?php echo gettitle_d($db, 'spr_zd_material', $ar['dom_material_id']);?></span></td>
         <td align="center" valign="top"><?php echo $ar['dom_floors']; ?></td>
         <td align="center" valign="top"><?php echo $ar['dom_pl_ob']; ?></td>
         <td align="center" valign="top"><?php if ($ar['dom_pl_zh']!=0){ echo $ar['dom_pl_zh']; } else { echo "-"; }; ?></td>
         <td align="center" valign="top"><?php echo $ar['price']; ?> тыс. руб.<?php if (($ar['price_torg']=='4') || ($ar['price_torg']=='5')) { echo ", ".gettitle_d($db, 'spr_price_torg', $ar['price_torg']); }; ?></td>
         <td align="left"   valign="top">
           <a href="./prodam_dom.php?id=<?php echo $ar['id']; ?>" class="link"><img width="16" height="16" align="absmiddle" src="./pics/ico_arrow.png" border="0"></a> 
           <a href="./prodam_dom.php?id=<?php echo $ar['id']; ?>" class="link">Подробнее</a>
         </td>
       </tr>
       
       
      
      
      
      
      <?php
      };
       
      ?> 
       
      
       
       
       </table>
       <!-- / ТАБЛИЦА -->
      
      
  <?php
  
  }; // kolvo >0
  // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  ?>
  
  
  
  
  
  
  <?php
  // Продажа УЧАСТКОВ
  // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

       $sort="date_upped DESC";
       $query="SELECT *
               FROM  
                 sell_uch 
               WHERE
                 status='0' AND usr_id='".$_SESSION['id']."'
               ORDER BY
               ".$sort.";";
       $i=0;
       $res=$db->query($query); 
       $kolvo=$res->num_rows;
  
  if ($kolvo>0) {
  
  ?> 
       
       
       <h2>Мои объявления: продам участок</h2>
       <div class="clear"></div>
       
       <img src="./pics/ico_filter.gif" width="18" height="18" align="absmiddle" border="0">
       <b>Найдено <?php echo $kolvo; ?> объектов</b>
       
       <div class="clear" style="margin-top:10px;"></div>
       
       <!-- ТАБЛИЦА -->
       <table width="690" cellpadding="5" class="st" cellspacing="0">
       <tr class="tr_buy">
         <td align="center" width="75"><a href="./uchastok_v_velikom_novgorode.php?sort=data" class="blink" title="Сортировать по дате (актуальные сверху)">Дата</a></td>
         <td align="center" width="80"><a href="./uchastok_v_velikom_novgorode.php?sort=type" class="blink" title="Сортировать по типу объекта (участок/дача)">Объект</a></td>
         <td align="center"><b>Расположение</b></td>
         <td align="center"><a href="./uchastok_v_velikom_novgorode.php?sort=pl" class="blink" title="Сортировать по виду площади">Площадь</a></td>
         <td align="center"><a href="./uchastok_v_velikom_novgorode.php?sort=str" class="blink" title="Сортировать по наличию строений">Стр</a></td>
         <td align="center" width="90"><a href="./uchastok_v_velikom_novgorode.php?sort=price" class="blink" title="Сортировать по цене (по возр.)">Цена</a></td>
         <td align="center" width="90"></td>
       </tr>
       
      <?php 
      while (($ar=$res->fetch_assoc()) == true ) {
        $i=$i+1;
        if ($i%2==0) {
          $class_tr=" class=\"even_buy\" ";
        } else {
          $class_tr="";
        };
        
        // ======================================================================
        // Собираем адрес участка
      
        // Адрес: собираем адрес объекта + адрес для URL
        $sobr_adres="";
           
        // Если город вообще указан (либо выбран из списка, либо непустой свой вариант)
        if ( ($ar['geo_gorod_id']>0) || (($ar['geo_gorod_id']==-1) && (strlen($ar['geo_gorod'])!=0)) ){
               
          // Если город выбран из списка
          if ($ar['geo_gorod_id']>0)  {
            $sobr_adres.=gettitle($db, 'spr_geo_gorod', $ar['geo_gorod_id']);
          }; 
        
          // Если город введен вручную
          if ($ar['geo_gorod_id']==-1)  {
            $sobr_adres.=$ar['geo_gorod'];
          }; 
                
                    
          // Если улица вообще указана (либо выбрана из списка, либо непустой свой вариант)
          if ( ($ar['geo_street_id']>0) || (($ar['geo_street_id']==-1) && (strlen($ar['geo_street'])!=0)) ){
                  
            // Если улица выбрана из списка
            if ($ar['geo_street_id']>0)  {
              $sobr_adres.=", ".gettitle_d($db, 'spr_geo_street', $ar['geo_street_id']);
            };  
                    
            // Если улица введена вручную
            if ($ar['geo_street_id']==-1)  {
              $sobr_adres.=", ".$ar['geo_street'];
            }; 
                
            // + номер дома
            if (strlen($ar['geo_n_doma'])!=0) {
              $sobr_adres.=", д. ".$ar['geo_n_doma'];
              // + корпус
              if (strlen($ar['geo_n_korp'])!=0) {
                $sobr_adres.=", корп. ".$ar['geo_n_korp'];
              };
            };
          // (конец) если улица вообще указана
          };
           
          
      
        };
        // ======================================================================
      ?>
      
      <tr <?php echo $class_tr; ?>>
         <td align="center" valign="top">
           <?php echo date("d.m.Y",$ar['date_upped']); ?>
           <?php if ($ar['usr_id']==$_SESSION['id']) { ?>
             <br>
             <a href="./uchastok_edit.php?id=<?php echo $ar['id']; ?>" class="link"><img width="16" height="16" align="absmiddle" src="./pics/ico_edit.png" title="Редактировать объявление" border="0"></a> 
             <a href="./uchastok_delete.php?id=<?php echo $ar['id']; ?>" class="link" onclick="return confirmDelete();"><img width="16" height="16" align="absmiddle" src="./pics/ico_delete.png" title="Удалить объявление" border="0"></a>
             <a href="./uchastok_up.php?id=<?php echo $ar['id']; ?>" class="link"><img width="16" height="16" align="absmiddle" src="./pics/ico_up.png" title="Поднять объявление" border="0"></a>
             <a href="./uslugi.php#paid" class="link"><img width="16" height="16" align="absmiddle" src="./pics/ico_promote.png" title="Продвинуть объявление" border="0"></a>
           <?php }; ?>
         </td>
         <td align="center" valign="top"><?php echo gettitle($db, 'spr_uch_type', $ar['uch_type']); ?></td>
         <td align="center" valign="top"><?php echo $sobr_adres; ?></td>
         <td align="center" valign="top"><?php 
           
           if ($ar['uch_pl']<100) {
             echo $ar['uch_pl']." соток"; 
           } else {
             echo $ar['uch_pl']/100;
             echo " гектар";
           };
            
            
         ?></td>
         
         <td align="center" valign="top"><?php if ($ar['uch_stroen']=='1') { ?><img width="16" height="16" align="absmiddle" title="Наличие строений на участке" src="./pics/ico_tick_green.png" border="0"><?php } else { echo "-"; }; ?></td>
         
         <td align="center" valign="top"><?php echo $ar['price']; ?> тыс. руб.<?php if (($ar['price_torg']=='4') || ($ar['price_torg']=='5')) { echo ", ".gettitle_d($db, 'spr_price_torg', $ar['price_torg']); }; ?></td>
         <td align="left"   valign="top">
           <a href="./prodam_uchastok.php?id=<?php echo $ar['id']; ?>" class="link"><img width="16" height="16" align="absmiddle" src="./pics/ico_arrow.png" border="0"></a> 
           <a href="./prodam_uchastok.php?id=<?php echo $ar['id']; ?>" class="link">Подробнее</a>
         </td>
       </tr>
       
       
      
      
      
      
      <?php
      };
       
      ?> 
       
      
       
       
       </table>
       <!-- / ТАБЛИЦА -->
      
      
  <?php
  
  }; // kolvo >0
  // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  ?>
  
  
  
  
  
  
  
  
  
    
  <?php
  // АРЕНДА комнат
  // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

       $sort="date_upped DESC";
       $query="SELECT *
               FROM  
                 rent_kmn 
               WHERE
                 status='0' AND usr_id='".$_SESSION['id']."'
               ORDER BY
               ".$sort.";";
       $i=0;
       $res=$db->query($query); 
       $kolvo=$res->num_rows;
  
  if ($kolvo>0) {
  
  ?> 
       
       
       <h2>Мои объявления: сдам комнату</h2>
       <div class="clear"></div>
       
       <img src="./pics/ico_filter.gif" width="18" height="18" align="absmiddle" border="0">
       <b>Найдено <?php echo $kolvo; ?> объектов</b>
       
       <div class="clear" style="margin-top:10px;"></div>
       
       <!-- ТАБЛИЦА -->
       <table width="690" cellpadding="5" class="st" cellspacing="0">
       <tr class="tr_buy">
         <td align="center" width="75"><b>Дата</b></td>
         <td align="center"><b>Объект</b></td>
         <td align="center"><b>Адрес</b></td>
         <td align="center"><span title="Материал"><b>М</b></span></td>
         <td align="center"><b><span title="Площадь">Пл.</span></b></td>
         <td align="center"><b><span title="Этаж">Э</span></b></td>
         <td align="center"><b><span title="Балкон / лоджия">Б</span></b></td>
         <td align="center" width="90"><b>Цена</b></td>
         <td align="center" width="90"></td>
       </tr>
       
      <?php 
      while (($ar=$res->fetch_assoc()) == true ) {
        $i=$i+1;
        if ($i%2==0) {
          $class_tr=" class=\"even_buy\" ";
        } else {
          $class_tr="";
        };
        
        // ======================================================================
        // Собираем адрес комнаты
      
        // Адрес: собираем адрес объекта + адрес для URL
        $sobr_adres="";
           
        // Если город вообще указан (либо выбран из списка, либо непустой свой вариант)
        if ( ($ar['geo_gorod_id']>0) || (($ar['geo_gorod_id']==-1) && (strlen($ar['geo_gorod'])!=0)) ){
               
          // Если город выбран из списка
          if ($ar['geo_gorod_id']>0)  {
            $sobr_adres.=gettitle($db, 'spr_geo_gorod', $ar['geo_gorod_id']);
          }; 
        
          // Если город введен вручную
          if ($ar['geo_gorod_id']==-1)  {
            $sobr_adres.=$ar['geo_gorod'];
          }; 
                
                    
          // Если улица вообще указана (либо выбрана из списка, либо непустой свой вариант)
          if ( ($ar['geo_street_id']>0) || (($ar['geo_street_id']==-1) && (strlen($ar['geo_street'])!=0)) ){
                  
            // Если улица выбрана из списка
            if ($ar['geo_street_id']>0)  {
              $sobr_adres.=", ".gettitle_d($db, 'spr_geo_street', $ar['geo_street_id']);
            };  
                    
            // Если улица введена вручную
            if ($ar['geo_street_id']==-1)  {
              $sobr_adres.=", ".$ar['geo_street'];
            }; 
                
            // + номер дома
            if (strlen($ar['geo_n_doma'])!=0) {
              $sobr_adres.=", д. ".$ar['geo_n_doma'];
              // + корпус
              if (strlen($ar['geo_n_korp'])!=0) {
                $sobr_adres.=", корп. ".$ar['geo_n_korp'];
              };
            };
          // (конец) если улица вообще указана
          };
           
          
      
        };
        // ======================================================================
      ?>
      
      <tr <?php echo $class_tr; ?>>
         <td align="center" valign="top">
           <?php echo date("d.m.Y",$ar['date_upped']); ?>
           <?php if ($ar['usr_id']==$_SESSION['id']) { ?>
             <br>
             <a href="./arenda_komnat_edit.php?id=<?php echo $ar['id']; ?>" class="link"><img width="16" height="16" align="absmiddle" src="./pics/ico_edit.png" title="Редактировать объявление" border="0"></a> 
             <a href="./arenda_komnat_delete.php?id=<?php echo $ar['id']; ?>" class="link" onclick="return confirmDelete();"><img width="16" height="16" align="absmiddle" src="./pics/ico_delete.png" title="Удалить объявление" border="0"></a>
             <a href="./arenda_komnat_up.php?id=<?php echo $ar['id']; ?>" class="link"><img width="16" height="16" align="absmiddle" src="./pics/ico_up.png" title="Поднять объявление" border="0"></a>
             <a href="./uslugi.php#paid" class="link"><img width="16" height="16" align="absmiddle" src="./pics/ico_promote.png" title="Продвинуть объявление" border="0"></a>
           <?php }; ?>
         </td>
         <td align="center" valign="top"><span title="<?php echo gettitle($db, 'spr_kmn_type', $ar['kmn_type_id']); ?>"><?php echo gettitle_d($db, 'spr_kmn_type', $ar['kmn_type_id']); ?></span></td>
         <td align="center" valign="top"><?php echo $sobr_adres; ?></td>
         <td align="center" valign="top"><span title="<?php echo gettitle($db, 'spr_zd_material', $ar['zd_material_id']);?>"><?php echo gettitle_d($db, 'spr_zd_material', $ar['zd_material_id']);?></span></td>
         <td align="center" valign="top"><?php echo $ar['kmn_pl']; ?></td>
         <td align="center" valign="top"><?php echo $ar['kmn_floor']; ?>/<?php echo $ar['zd_floors']; ?></td>
         <td align="center" valign="top"><?php if ($ar['kmn_balkon']=='1') { ?><img width="16" height="16" align="absmiddle" title="Балкон/лоджия" src="./pics/ico_tick_green.png" border="0"><?php } else { echo "-"; }; ?></td>
         <td align="center" valign="top"><?php echo $ar['price']; ?> руб./мес.<?php if (($ar['price_torg']=='4') || ($ar['price_torg']=='5')) { echo ", ".gettitle_d($db, 'spr_price_torg', $ar['price_torg']); }; ?></td>
         <td align="left"   valign="middle">
           <a href="./sdam_komnatu.php?id=<?php echo $ar['id']; ?>" class="link"><img width="16" height="16" align="absmiddle" src="./pics/ico_arrow.png" border="0"></a> 
           <a href="./sdam_komnatu.php?id=<?php echo $ar['id']; ?>" class="link">Подробнее</a>
         </td>
       </tr>
       
       
      
      
      
      
      <?php
      };
       
      ?> 
       
      
       
       
       </table>
       <!-- / ТАБЛИЦА -->
      
      
  <?php
  
  }; // kolvo >0
  // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  ?>  
  
  
  
  
  
    <?php
  // АРЕНДА квартир
  // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

       $sort="date_upped DESC";
       $query="SELECT *
               FROM  
                 rent_kva 
               WHERE
                 status='0' AND usr_id='".$_SESSION['id']."'
               ORDER BY
               ".$sort.";";
       $i=0;
       $res=$db->query($query); 
       $kolvo=$res->num_rows;
  
  if ($kolvo>0) {
  
  ?> 
       
       
       <h2>Мои объявления: сдам квартиру</h2>
       <div class="clear"></div>
       
       <img src="./pics/ico_filter.gif" width="18" height="18" align="absmiddle" border="0">
       <b>Найдено <?php echo $kolvo; ?> объектов</b>
       
       <div class="clear" style="margin-top:10px;"></div>
       
       <!-- ТАБЛИЦА -->
       <table width="690" cellpadding="5" class="st" cellspacing="0">
       <tr class="tr_buy">
         <td align="center" width="75"><b>Дата</b></td>
         <td align="center" width="80"><b>Квартира</b></td>
         <td align="center"><b>Адрес</b></td>
         <td align="center"><span title="Материал"><b>М</b></span></td>
         <td align="center"><b><span title="Общая площадь">O</span></b></td>
         <td align="center"><b><span title="Жилая площадь">Ж</span></b></td>
         <td align="center"><b><span title="Площадь кухни">К</span></b></td>
         <td align="center"><b><span title="Этаж">Э</span></b></td>
         <td align="center"><b><span title="Балкон / лоджия">Б</span></b></td>
         <td align="center" width="90"><b>Цена</b></td>
         <td align="center" width="90"></td>
       </tr>
       
      <?php 
      while (($ar=$res->fetch_assoc()) == true ) {
        $i=$i+1;
        if ($i%2==0) {
          $class_tr=" class=\"even_buy\" ";
        } else {
          $class_tr="";
        };
        
        // ======================================================================
        // Собираем адрес квартиры
      
        // Адрес: собираем адрес объекта + адрес для URL
        $sobr_adres="";
           
        // Если город вообще указан (либо выбран из списка, либо непустой свой вариант)
        if ( ($ar['geo_gorod_id']>0) || (($ar['geo_gorod_id']==-1) && (strlen($ar['geo_gorod'])!=0)) ){
               
          // Если город выбран из списка
          if ($ar['geo_gorod_id']>0)  {
            $sobr_adres.=gettitle($db, 'spr_geo_gorod', $ar['geo_gorod_id']);
          }; 
        
          // Если город введен вручную
          if ($ar['geo_gorod_id']==-1)  {
            $sobr_adres.=$ar['geo_gorod'];
          }; 
                
                    
          // Если улица вообще указана (либо выбрана из списка, либо непустой свой вариант)
          if ( ($ar['geo_street_id']>0) || (($ar['geo_street_id']==-1) && (strlen($ar['geo_street'])!=0)) ){
                  
            // Если улица выбрана из списка
            if ($ar['geo_street_id']>0)  {
              $sobr_adres.=", ".gettitle_d($db, 'spr_geo_street', $ar['geo_street_id']);
            };  
                    
            // Если улица введена вручную
            if ($ar['geo_street_id']==-1)  {
              $sobr_adres.=", ".$ar['geo_street'];
            }; 
                
            // + номер дома
            if (strlen($ar['geo_n_doma'])!=0) {
              $sobr_adres.=", д. ".$ar['geo_n_doma'];
              // + корпус
              if (strlen($ar['geo_n_korp'])!=0) {
                $sobr_adres.=", корп. ".$ar['geo_n_korp'];
              };
            };
          // (конец) если улица вообще указана
          };
           
          
      
        };
        // ======================================================================
      ?>
      
      <tr <?php echo $class_tr; ?>>
         <td align="center" valign="top">
           <?php echo date("d.m.Y",$ar['date_upped']); ?>
           <?php if ($ar['usr_id']==$_SESSION['id']) { ?>
             <br>
             <a href="./arenda_kvartir_edit.php?id=<?php echo $ar['id']; ?>" class="link"><img width="16" height="16" align="absmiddle" src="./pics/ico_edit.png" title="Редактировать объявление" border="0"></a> 
             <a href="./arenda_kvartir_delete.php?id=<?php echo $ar['id']; ?>" class="link" onclick="return confirmDelete();"><img width="16" height="16" align="absmiddle" src="./pics/ico_delete.png" title="Удалить объявление" border="0"></a>
             <a href="./arenda_kvartir_up.php?id=<?php echo $ar['id']; ?>" class="link"><img width="16" height="16" align="absmiddle" src="./pics/ico_up.png" title="Поднять объявление" border="0"></a>
             <a href="./uslugi.php#paid" class="link"><img width="16" height="16" align="absmiddle" src="./pics/ico_promote.png" title="Продвинуть объявление" border="0"></a>
           <?php }; ?>
         </td>
         <td align="center" valign="top"><?php echo $ar['kva_rooms']; ?>-комн. кв.</td>
         <td align="center" valign="top"><?php echo $sobr_adres; ?></td>
         <td align="center" valign="top"><span title="<?php echo gettitle($db, 'spr_zd_material', $ar['zd_material_id']);?>"><?php echo gettitle_d($db, 'spr_zd_material', $ar['zd_material_id']);?></span></td>
         <td align="center" valign="top"><?php echo $ar['kva_pl_ob']; ?></td>
         <td align="center" valign="top"><?php echo $ar['kva_pl_zh']; ?></td>
         <td align="center" valign="top"><?php echo $ar['kva_pl_kuh']; ?></td>
         <td align="center" valign="top"><?php echo $ar['kva_floor']; ?>/<?php echo $ar['zd_floors']; ?></td>
         <td align="center" valign="top"><?php if ($ar['kva_balkon']=='1') { ?><img width="16" height="16" align="absmiddle" title="Балкон/лоджия" src="./pics/ico_tick_green.png" border="0"><?php } else { echo "-"; }; ?></td>
         <td align="center" valign="top"><?php echo $ar['price']; ?> руб./мес.<?php if (($ar['price_torg']=='4') || ($ar['price_torg']=='5')) { echo ", ".gettitle_d($db, 'spr_price_torg', $ar['price_torg']); }; ?></td>
         <td align="left"   valign="top">
           <a href="./sdam_kvartiru.php?id=<?php echo $ar['id']; ?>" class="link"><img width="16" height="16" align="absmiddle" src="./pics/ico_arrow.png" border="0"></a> 
           <a href="./sdam_kvartiru.php?id=<?php echo $ar['id']; ?>" class="link">Подробнее</a>
         </td>
       </tr>
       
       
      
      
      
      
      <?php
      };
       
      ?> 
       
      
       
       
       </table>
       <!-- / ТАБЛИЦА -->
      
      
  <?php
  
  }; // kolvo >0
  // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
?>  
  
  
  
  
  
  
  
  
  
  
  
  <?php
  // ПРОДАЖА гаражей
  // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

       $sort="date_upped DESC";
       $query="SELECT *
               FROM  
                 sell_gar 
               WHERE
                 status='0' AND usr_id='".$_SESSION['id']."'
               ORDER BY
               ".$sort.";";
       $i=0;
       $res=$db->query($query); 
       $kolvo=$res->num_rows;
  
  if ($kolvo>0) {
  
  ?> 
       
       
       <h2>Мои объявления: продам гараж</h2>
       <div class="clear"></div>
       
       <img src="./pics/ico_filter.gif" width="18" height="18" align="absmiddle" border="0">
       <b>Найдено <?php echo $kolvo; ?> объектов</b>
       
       <div class="clear" style="margin-top:10px;"></div>
       
       <!-- ТАБЛИЦА -->
       <table width="690" cellpadding="5" class="st" cellspacing="0">
       <tr class="tr_buy">
         <td align="center" width="75"><a href="./garazh_v_velikom_novgorode.php?sort=data" class="blink" title="Сортировать по дате (актуальные сверху)">Дата</a></td>
         <td align="center"><b>Объект</b></td>
         <td align="center"><b>Расположение</b></td>
         <td align="center"><a href="./garazh_v_velikom_novgorode.php?sort=s" class="blink" title="Сортировать по площади (по возр.)">Пл.</a></td>
         <td align="center" width="90"><a href="./garazh_v_velikom_novgorode.php?sort=price" class="blink" title="Сортировать по цене (по возр.)">Цена</a></td>
         <td align="center" width="90"></td>
       </tr>
       
      <?php 
      while (($ar=$res->fetch_assoc()) == true ) {
        $i=$i+1;
        if ($i%2==0) {
          $class_tr=" class=\"even_buy\" ";
        } else {
          $class_tr="";
        };
        
        // ======================================================================
        // Собираем адрес комнаты
      
        // Адрес: собираем адрес объекта + адрес для URL
        $sobr_adres="";
           
        // Если город вообще указан (либо выбран из списка, либо непустой свой вариант)
        if ( ($ar['geo_gorod_id']>0) || (($ar['geo_gorod_id']==-1) && (strlen($ar['geo_gorod'])!=0)) ){
               
          // Если город выбран из списка
          if ($ar['geo_gorod_id']>0)  {
            $sobr_adres.=gettitle($db, 'spr_geo_gorod', $ar['geo_gorod_id']);
          }; 
        
          // Если город введен вручную
          if ($ar['geo_gorod_id']==-1)  {
            $sobr_adres.=$ar['geo_gorod'];
          }; 
        };
        $sobr_adres.=", ".$ar['geo_place'];
        
        // ======================================================================
      ?>
      
      <tr <?php echo $class_tr; ?>>
         <td align="center" valign="top">
           <?php echo date("d.m.Y",$ar['date_upped']); ?>
           <?php if ($ar['usr_id']==$_SESSION['id']) { ?>
             <br>
             <a href="./garazh_edit.php?id=<?php echo $ar['id']; ?>" class="link"><img width="16" height="16" align="absmiddle" src="./pics/ico_edit.png" title="Редактировать объявление" border="0"></a> 
             <a href="./garazh_delete.php?id=<?php echo $ar['id']; ?>" class="link" onclick="return confirmDelete();"><img width="16" height="16" align="absmiddle" src="./pics/ico_delete.png" title="Удалить объявление" border="0"></a>
             <a href="./garazh_up.php?id=<?php echo $ar['id']; ?>" class="link"><img width="16" height="16" align="absmiddle" src="./pics/ico_up.png" title="Поднять объявление" border="0"></a>
             <a href="./uslugi.php" class="link"><img width="16" height="16" align="absmiddle" src="./pics/ico_promote.png" title="Продвинуть объявление" border="0"></a>
           <?php }; ?>
         </td>
         <td align="center" valign="top">Гараж</td>
         <td align="center" valign="top"><?php echo $sobr_adres; ?></td>
         <td align="center" valign="top"><?php echo $ar['gar_pl']; ?></td>
         <td align="center" valign="top"><?php echo $ar['price']; ?> тыс. руб.<?php if (($ar['price_torg']=='4') || ($ar['price_torg']=='5')) { echo ", ".gettitle_d($db, 'spr_price_torg', $ar['price_torg']); }; ?></td>
         <td align="left"   valign="middle">
           <a href="./prodam_garazh.php?id=<?php echo $ar['id']; ?>" class="link"><img width="16" height="16" align="absmiddle" src="./pics/ico_arrow.png" border="0"></a> 
           <a href="./prodam_garazh.php?id=<?php echo $ar['id']; ?>" class="link">Подробнее</a>
         </td>
       </tr>
       
       
      
      
      
      
      <?php
      };
       
      ?> 
       
      
       
       
       </table>
       <!-- / ТАБЛИЦА -->
      
      
  <?php
  
  }; // kolvo >0
  // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
?>  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
<?php  
  } else { //($glogged==1)
?>         


<h2>Ошибка доступа</h2>
<p>
Информация на этой странице доступна только <a href="./register.php" class="link">зарегистрированным</a> пользователям.
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