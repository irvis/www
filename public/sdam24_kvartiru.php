<?php 

  // Подключаем поддержку БД
  require "./_parts/_db.php"; 
  
  // Подключаем авторизацию
  require "./_parts/_auth.php"; 
  // если пользователь авторизован, тогда наша переменная $glogged имеет значение '1';
  
  // Запоминаем имя файла (для подсветки пунктов меню).
  $fname= basename (__FILE__);
  
// Просмотр деталей по объекту
// ======================================================================
$ok=false;
$for_title="";
if (isset($_GET['id'])) {
  $kolvo=0;
  $query="SELECT * FROM rent24_kva WHERE status='0' AND id='".(int)($_GET['id'])."'";
  $res=mysql_query($query,$db); 
  $kolvo=mysql_num_rows($res);
  if ($kolvo!=0) {
    $ok=true; // пометка успешности поиска объекта недвижимости
    // Запись в массив информации по объекту
    // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    $ar=mysql_fetch_assoc($res);
    // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  };
};

// ======================================================================
        // Собираем адрес квартиры
        // Адрес: собираем адрес объекта + адрес для URL
        $sobr_adres="";
        $sobr_adres_url=""; // для ссылки
        // Если город вообще указан (либо выбран из списка, либо непустой свой вариант)
        if ( ($ar['geo_gorod_id']>0) || (($ar['geo_gorod_id']==-1) && (strlen($ar['geo_gorod'])!=0)) ){
               
          // Если город выбран из списка
          if ($ar['geo_gorod_id']>0)  {
            if ($ar['geo_gorod_id']!=1) { // не упоминаем в заголовке г. Великий Новгород (т.к. он по умолчанию)
              $sobr_adres.=gettitle($db, 'spr_geo_gorod', $ar['geo_gorod_id']).", ";
              $sobr_adres_url.=gettitle($db, 'spr_geo_gorod', $ar['geo_gorod_id']).", ";
            } else {
              $sobr_adres_url.=gettitle($db, 'spr_geo_gorod', $ar['geo_gorod_id']).", ";
            };
          }; 
        
          // Если город введен вручную
          if ($ar['geo_gorod_id']==-1)  {
            $sobr_adres.=$ar['geo_gorod'].", ";
            $sobr_adres_url.=$ar['geo_gorod'].", ";
          }; 
                
                    
          // Если улица вообще указана (либо выбрана из списка, либо непустой свой вариант)
          if ( ($ar['geo_street_id']>0) || (($ar['geo_street_id']==-1) && (strlen($ar['geo_street'])!=0)) ){
                  
            // Если улица выбрана из списка
            if ($ar['geo_street_id']>0)  {
              $sobr_adres.=gettitle_d($db, 'spr_geo_street', $ar['geo_street_id']);
              $sobr_adres_url.=gettitle_d($db, 'spr_geo_street', $ar['geo_street_id']);
            };  
                    
            // Если улица введена вручную
            if ($ar['geo_street_id']==-1)  {
              $sobr_adres.=$ar['geo_street'];
              $sobr_adres_url.=$ar['geo_street'];
            }; 
                
            // + номер дома
            if (strlen($ar['geo_n_doma'])!=0) {
              $sobr_adres.=", д. ".$ar['geo_n_doma'];
              $sobr_adres_url.=", ".$ar['geo_n_doma'];
              // + корпус
              if (strlen($ar['geo_n_korp'])!=0) {
                $sobr_adres.=", корп. ".$ar['geo_n_korp'];
                $sobr_adres_url.="к".$ar['geo_n_korp'];
              };
            };
          // (конец) если улица вообще указана
          };
        };
        $sobr_adres_url_full=$sobr_adres_url;   
        $sobr_adres_url="http://maps.yandex.ru/?text=".urlencode($sobr_adres_url);
// ======================================================================
  // Формируем заголовки
  $super_title="";
  $super_title.="Сдам <b class=\"red\">посуточно</b> ".$ar[kva_rooms]."-комн. квартиру ";
  $super_title.=$ar[kva_pl_ob]."/".$ar[kva_pl_zh]."/".$ar[kva_pl_kuh].", ";
  $super_title.="этаж ".$ar[kva_floor]."/".$ar[zd_floors]." (".gettitle_d($db, 'spr_zd_material', $ar['zd_material_id'])."), ";
  $super_title.=$sobr_adres." ";
  
  // Инфа для заголовка <TITLE> HTML-документа:
  $for_title.=strip_tags($super_title);
  $for_title.="за ".$ar[price]." руб./мес.";
  if ($ar['price_torg']!=0) {$for_title.=", ".gettitle_d($db, 'spr_price_torg', $ar['price_torg']);};
  // Копирайтилка
  $for_title.=" - Проект &laquo;Новгородская квартира&raquo; - Недвижимость Великого Новгорода";
// ============================================================

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <title><?php echo $for_title; ?></title>
  <?php require "./_parts/include_style.php"; ?>
  <?php require "./_parts/highslide.php"; ?>
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
  
  

<?php 
if ($ok) { 
?>


<div class="content_box">
  <div class="content_header">
        <div class="content_inner">
        <b>Аренда квартир в Великом Новгороде и Новгородской области</b>
        </div>
  </div>
  <div class="clear"></div>
  <div class="content_cover">
    <div class="content_inner" style="width:700px;">
      <div class="r_date">
          <img src="./pics/ico_date.gif" width="18" height="18" align="absmiddle">
          <?php 
            //echo date("d.m.Y, H:i", $ar['date_upped']);
            echo date("d.m.Y", $ar['date_upped']);
          ?>
      </div>
      
      <div class="l_date">
          <a href="./arenda24_kvartir_v_velikom_novgorode.php" class="link"><img width="16" height="16" align="absmiddle" src="./pics/ico_uplist.png" border="0"></a> 
          <a href="./arenda24_kvartir_v_velikom_novgorode.php" class="link">Назад к списку</a>
          
          <?php if ($ar['usr_id']==$_SESSION['id']) { ?>
             &nbsp;&nbsp;&nbsp;
            <a href="./arenda24_kvartir_edit.php?id=<?php echo $ar['id']; ?>" class="link"><img width="16" height="16" align="absmiddle" src="./pics/ico_edit.png"></a> 
            <a href="./arenda24_kvartir_edit.php?id=<?php echo $ar['id']; ?>" class="link">Редактировать</a>
            &nbsp;&nbsp;&nbsp;
            <a href="./arenda24_kvartir_delete.php?id=<?php echo $ar['id']; ?>" class="link" onclick="return confirmDelete();"><img width="16" height="16" align="absmiddle" src="./pics/ico_delete.png"></a> 
            <a href="./arenda24_kvartir_delete.php?id=<?php echo $ar['id']; ?>" class="link" onclick="return confirmDelete();">Удалить</a>
            &nbsp;&nbsp;&nbsp;
            <a href="./arenda24_kvartir_up.php?id=<?php echo $ar['id']; ?>" class="link"><img width="16" height="16" align="absmiddle" src="./pics/ico_up.png"></a> 
            <a href="./arenda24_kvartir_up.php?id=<?php echo $ar['id']; ?>" class="link">Поднять</a>
            &nbsp;&nbsp;&nbsp;
            <a href="./uslugi.php#paid" class="link"><img width="16" height="16" align="absmiddle" src="./pics/ico_promote.png"></a> 
            <a href="./uslugi.php#paid" class="link">Продвинуть</a>
          <?php }; ?>
          
          
          
          
      </div>
      <?php require "./_parts/adsense.php";      ?>  
      <div class="clear"></div>
    
      <?php echo "<h2>".$super_title."</h2>";?> 
         
      
         
      <div class="clear"></div>   
      <div class="part_left350">
        <?php
        echo "<b>Описание</b><br>";
        // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        
        echo"Адрес: ";
        echo $sobr_adres."<br>";
        
        echo"Материал дома: ";
        echo gettitle($db, 'spr_zd_material', $ar['zd_material_id'])."<br>";
        
        echo"Тип квартиры: ";
        echo $ar['kva_rooms']."-комн. квартира<br>";
        
        echo"Общая площадь: ";
        echo $ar['kva_pl_ob']." кв. м<br>";
        
        echo"Жилая площадь: ";
        echo $ar['kva_pl_zh']." кв. м<br>";
        
        echo"Площадь кухни: ";
        echo $ar['kva_pl_kuh']." кв. м<br>";
        
        echo"Этаж: ";
        echo $ar['kva_floor']."/".$ar['zd_floors']."<br>";
        
        if ($ar['kva_balkon']==1) {
          echo"Балкон/лоджия: есть<br>";
        };
        
        echo "<br><b>Цена:</b><br>";
        echo "<span style=\"font-size:20px;font-weight:bold;\">";
        echo $ar['price']." руб./сутки";
        if ($ar['price_torg']!=0) { echo ", ".gettitle_d($db, 'spr_price_torg', $ar['price_torg']); };
        echo "<br>";
        echo "</span>";
        
        if (strlen($ar['descr'])>0){
          echo "<br><b>Дополнительная информация</b><br>";
          // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
          //echo $ar['descr']."<br>";
          echo str_replace("\n", "<br>", $ar['descr'])."<br>";
        };
        
        if (strlen($ar['contacts'])>0){
          echo "<br><b>Контакты</b><br>";
          // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
          //echo $ar['contacts']."<br>";
          echo str_replace("\n", "<br>", $ar['contacts'])."<br>";
        };
        
        
        
        
        echo "<br><b>Постоянная ссылка на эту страницу:</b><br>";
        echo "<input value=http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']." style=\"border:1px solid #808080;width:280px;font-family:Arial;font-size:12px;color:#808080;\" onclick=\"this.select()\">";
        
        ?>
      </div>
         
      <div class="part_right340" style="border:0px solid red;">
           <?php
           // ========================================================================================
           // ========================================================================================
           // ========================================================================================
           
           $yamap_key = "AIHLn04BAAAAc9TAFQIACwCW5p4c00O6rNDl0_NT3woj3Q4AAAAAAAAAAAAj2IaZgvvbIKDNze36xTwWTGcqXw==";
           
           // +++++++++++++ Если в базе координат НЕТ, тогда.... вычисляем ++++++++++++++++++++
           if (strlen($ar['geo_yamap'])==0) {
             // +++++++++++++ Вычисляем геокоординаты ++++++++++++++++++++
             $yamap_adres = $sobr_adres_url_full;
             $yamap_file = simplexml_load_string(@file_get_contents("http://geocode-maps.yandex.ru/1.x/?geocode=".urlencode($yamap_adres)."&key=" . $yamap_key));
             $yamap_adress_up = iconv("windows-1251", "UTF-8//IGNORE", $yamap_file->GeoObjectCollection->featureMember->GeoObject->metaDataProperty->GeocoderMetaData->text);
             $yamap_coord=$yamap_file->GeoObjectCollection->featureMember->GeoObject->Point->pos;
             //$yamap_coord = explode(' ', $yamap_file->GeoObjectCollection->featureMember->GeoObject->Point->pos);
             // RESULT //'x' => $yamap_coord[0] //'y' => $yamap_coord[1]
             
             // +++++++++++++ Записываем вычисленные координаты в БД ++++++++++++++++++++
             $query="UPDATE sell_kmn 
                      SET geo_yamap='".mysql_real_escape_string($yamap_coord)."'
                      WHERE id='".(int)($_GET['id'])."';";
             $res=mysql_query($query,$db); //echo "<b style=\"color:red;\">ZAPROS=[".$query."]</b>"; //debug
             $yamap_coord = explode(' ', $yamap_coord);
           } else {  // Если в базе координаты ЕСТЬ, тогда.... сразу выводим
             // +++++++++++++ Получаем геокоординаты из БД ++++++++++++++++++++
             $yamap_coord=$ar['geo_yamap'];
             $yamap_coord = explode(' ', $yamap_coord);
           };
           
           // +++++++++++++ Генерируем код для вывода карты-схемы ++++++++++++++++++++
           $objectmap = "<script src=\"http://api-maps.yandex.ru/1.1/index.xml?key=".$yamap_key."\" type=\"text/javascript\"></script>
             <script type=\"text/javascript\">
                 YMaps.jQuery(function(){
                     var map = new YMaps.Map(YMaps.jQuery(\"#YMapsID\")[0]);
                     map.setCenter(new YMaps.GeoPoint(".$yamap_coord[0].", ".$yamap_coord[1]."), 16);
                     map.enableScrollZoom();
                 })
             </script>
             <div class=\"shema\" id=\"YMapsID\" style=\"width:312px;height:312px\"></div>";
           
           // +++++++++++++ Выводим карту-схему ++++++++++++++++++++
           echo "<b>Карта-схема</b><br>";
           echo "<div class=\"clear\" style=\"margin-top:5px;\"></div>";
           echo $objectmap;
           
           // ========================================================================================
           // ========================================================================================
           // ========================================================================================
           
           ?>

           
           

           <div class="clear"></div>
           <?php
             if ($sobr_adres_url!="") {
               echo "<img src=\"./pics/ico_filter.gif\" width=\"18\" height=\"18\" align=\"absmiddle\"> ".
               "<a class=\"link\" href=\"".$sobr_adres_url."\" target=\"_blank\" title=\"Откроется в новом окне\" rel=\"nofollow\">Показать объект на большой Яндекс-карте</a>";
             };
           ?>
           <div class="clear" style="margin-top:20px;"></div>
           <!--
           <b>Фотографии объекта</b><br>
           <div class="clear" style="margin-top:5px;"></div>
           <img src="<?php echo $ar['obj_pic']; ?>" class="pic">
           -->
       </div> 

	   
	 
	   
	   <?php require "./_parts/adsense2.php";      ?>
	   
        

       
    </div>
  </div>
</div>
  
  
  
<?php 
   
   
} else {  
// ========================================================================  
?>  


<div class="content_box">
  <div class="content_header">
        <div class="content_inner">
        <b>Объект недвижимости</b>
        </div>
  </div>
  <div class="clear"></div>
  <div class="content_cover">
    <div class="content_inner">
    <h2>Ошибка: объект не найден</h2>
    Объект не найден в базе данных. Проверьте правильность ссылки. Если Вы уверены, что ссылка верная - пожалуйста, сообщите об ошибке администратору сайта на email, указанный внизу страницы.
    </div>
  </div>
</div>




<?php 

// ========================================================================
};  
  
?>    
  
  
  
  
  
  
  
  

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