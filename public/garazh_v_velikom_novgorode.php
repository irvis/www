<?php 
require_once '../app/config.php';
  
  // Подключаем авторизацию
  require "./_parts/_auth.php"; 
  // если пользователь авторизован, тогда наша переменная $glogged имеет значение '1';
  
  // Запоминаем имя файла (для подсветки пунктов меню).
  $fname= basename (__FILE__);
  
  include APP_PATH . '/view/header.html';
?>




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
        <b>Продажа гаражей в Великом Новгороде и Новгородской области</b>
        </div>
  </div>

  <div class="clear"></div>
  
  
  
  
  
  
  
  
  
   <?php
  
  //echo "7777777777777777";
  
  $sort="date_upped DESC";
  if ((isset($_GET['sort'])) && ($_GET['sort']=='s'))     { $sort="gar_pl ASC"; };
  if ((isset($_GET['sort'])) && ($_GET['sort']=='price')) { $sort="price ASC"; };
  if ((isset($_GET['sort'])) && ($_GET['sort']=='data'))  { $sort="date_upped DESC"; };
  
  $query="SELECT *
  FROM  
    sell_gar 
  WHERE
    status='0'
  ORDER BY
   ".$sort.";";
  
  $i=0;
  $res=$db->query($query); 
  $kolvo=$res->num_rows;
  
   ?>       
 
 
 
 <div class="content_cover">
    <div class="content_inner">
       
       
       
        
       <div class="r_date">
           <a href="./garazh_add.php" class="link"><img width="16" height="16" align="absmiddle" src="./pics/ico_add.png" border="0"></a> 
           <a href="./garazh_add.php" class="link">Добавить объявление</a>
       </div>
       
       <h2>Купить гараж в Великом Новгороде</h2>
       <?php require "./_parts/adsense_tabl_verx.php";      ?>
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
           <?php if (isset($_SESSION['id']) && $ar['usr_id']==$_SESSION['id']) { ?>
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