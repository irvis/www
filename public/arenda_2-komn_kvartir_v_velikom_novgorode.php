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
  <title>Снять 2-комн. квартиру в Великом Новгороде - Проект &laquo;Новгородская квартира&raquo; (Недвижимость Великого Новгорода)</title>
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
        <b>Аренда квартир в Великом Новгороде и Новгородской области</b>
        </div>
  </div>

  <div class="clear"></div>
  
  
  
  
  
  
  
  
  
   <?php
  
  //echo "7777777777777777";
  
  $sort="date_upped DESC";
  if ((isset($_GET['sort'])) && ($_GET['sort']=='data'))  { $sort="date_upped DESC"; };
  if ((isset($_GET['sort'])) && ($_GET['sort']=='type'))  { $sort="kva_rooms ASC, price ASC"; };
  if ((isset($_GET['sort'])) && ($_GET['sort']=='op'))    { $sort="kva_pl_ob ASC, price ASC"; };
  if ((isset($_GET['sort'])) && ($_GET['sort']=='zp'))    { $sort="kva_pl_zh ASC, price ASC"; };
  if ((isset($_GET['sort'])) && ($_GET['sort']=='pk'))    { $sort="kva_pl_kuh ASC, price ASC"; };
  if ((isset($_GET['sort'])) && ($_GET['sort']=='et'))    { $sort="kva_floor ASC, price ASC"; };
  if ((isset($_GET['sort'])) && ($_GET['sort']=='price')) { $sort="price ASC"; };
  
  $query="SELECT *
  FROM  
    rent_kva 
  WHERE
    status='0' AND kva_rooms='2'
  ORDER BY
   ".$sort.";";
  
  $i=0;
  $res=$db->query($query); 
  $kolvo=$res->num_rows;
  
   ?>       
 
 
 
 <div class="content_cover">
    <div class="content_inner">
       
       
       
        
       <div class="r_date">
           <a href="./arenda_kvartir_add.php" class="link"><img width="16" height="16" align="absmiddle" src="./pics/ico_add.png" border="0"></a> 
           <a href="./arenda_kvartir_add.php" class="link">Добавить объявление</a>
       </div>
       
       <h2>Снять 2-комн. квартиру в Великом Новгороде</h2>
       <?php require "./_parts/adsense_tabl_verx.php";      ?>
	   <div class="clear"></div>
       
       <p style="margin-top:0px;">Смотреть: &nbsp;&nbsp;&nbsp;
         <img width="16" height="16" align="absmiddle" src="./pics/ico_realty.png"> <a href="./arenda_kvartir_v_velikom_novgorode.php" class="link">Все квартиры</a>
       </p>
       <div class="clear"></div>
       
       <img src="./pics/ico_filter.gif" width="18" height="18" align="absmiddle" border="0">
       <b>Найдено <?php echo $kolvo; ?> объектов</b>
       
       <div class="clear" style="margin-top:10px;"></div>
       
       <!-- ТАБЛИЦА -->
       <table width="690" cellpadding="5" class="st" cellspacing="0">
       <tr class="tr_buy">
         <td align="center" width="75"><a href="./arenda_2-komn_kvartir_v_velikom_novgorode.php?sort=data" class="blink" title="Сортировать по дате (актуальные сверху)">Дата</a></td>
         <td align="center" width="80"><b>Квартира</b></td>
         <td align="center"><b>Адрес</b></td>
         <td align="center"><span title="Материал"><b>М</b></span></td>
         <td align="center"><a href="./arenda_2-komn_kvartir_v_velikom_novgorode.php?sort=op" class="blink" title="Сортировать по общей площади (по возр.)">O</a></td>
         <td align="center"><a href="./arenda_2-komn_kvartir_v_velikom_novgorode.php?sort=zp" class="blink" title="Сортировать по жилой площади (по возр.)">Ж</a></td>
         <td align="center"><a href="./arenda_2-komn_kvartir_v_velikom_novgorode.php?sort=pk" class="blink" title="Сортировать по площади кухни (по возр.)">К</a></td>
         <td align="center"><a href="./arenda_2-komn_kvartir_v_velikom_novgorode.php?sort=et" class="blink" title="Сортировать по этажу (по возр.)">Э</a></td>
         <td align="center"><b><span title="Балкон / лоджия">Б</span></b></td>
         <td align="center" width="90"><a href="./arenda_2-komn_kvartir_v_velikom_novgorode.php?sort=price" class="blink" title="Сортировать по цене (по возр.)">Цена</a></td>
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
           <?php if (isset($_SESSION['id']) && $ar['usr_id']==$_SESSION['id']) { ?>
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