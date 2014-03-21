<div class="content_box">
  
  <div class="content_header">
        <div class="content_inner">
        <b>Недвижимость Великого Новгорода: Комнаты и КГТ</b>
        </div>
  </div>

  <div class="clear"></div>
  
  
  
  
  
  
  
  
  
  <?php
  
  //echo "7777777777777777";
  
  
  $query="SELECT *
  FROM  
    tbl_objects AS t1 
  WHERE
    status='0' AND 
    obj_type_id='1'
  ORDER BY
   date_upped DESC,
   obj_price_sell ASC
  ";
  
  $i=0;
  $res=mysql_query($query,$db); 
  $kolvo=mysql_num_rows($res);
  
   ?>     
 
 
 
 <div class="content_cover">
    <div class="content_inner">
       
       <h2>Продажа комнат в Великом Новгороде</h2>
       <div class="clear"></div>
       
       <img src="./pics/ico_filter.gif" width="18" height="18" align="absmiddle">
       <b>Найдено <?php echo $kolvo; ?> объектов</b>
       
       <div class="clear" style="margin-top:10px;"></div>
       
       <!-- ТАБЛИЦА -->
       
       <table width="690" cellpadding="5" class="st" cellspacing="0">
       <tr class="tr_buy">
         <td align="center" width="155"><b>Фото</b></td>
         <td align="center"><b>Описание</b></td>
         <td align="center" width="130"><b>Адрес</b></td>
         <td align="center" width="85"><b>Стоимость</b></td>
         <td align="center" width="85"><b>Подробнее</b></td>
       </tr>
 
 
      
 <?php 
  
  while (($ar=mysql_fetch_assoc($res)) == true ) {
      $i=$i+1;

      if ($i%2==0) {
        $class_tr=" class=\"even_buy\" ";
      } else {
        $class_tr="";
      };
    
//echo "<pre>";
//print_r($ar);
//echo "</pre>";
      
      
      // ===============================================================
      
      echo "<tr ".$class_tr.">";
      
      // Фотография
      echo "<td align=\"center\" valign=\"top\" align=\"center\"><img src=".$ar['obj_pic']." width=\"150\"></td>";
      
      
      
      
      // ====================================================== Собираем описание объекта
      $sobr_note="";
      
      // Продам комнату
      $sobr_note.="<b>".gettitle_d($db, 'spr_obj_type', $ar['obj_type_id'])."</b>, ";
      
      // Площадь
      $sobr_note.=$ar['room_s_obsh']." м<sup>2</sup>, ";
      
      // Здание
      $sobr_note.=$ar['room_floor']."/".$ar['zd_floors']." ".gettitle_d($db, 'spr_zd_material', $ar['zd_material_id']);
      
      $sobr_note.=". ";
      
      
      $ar['obj_descr']=trim($ar['obj_descr']);
      if ($ar['obj_descr']!="") {
        $ar['obj_descr']=mb_strtoupper(substr($ar['obj_descr'],0,1)).substr($ar['obj_descr'],1,strlen($ar['obj_descr'])-1);
        $sobr_note.=$ar['obj_descr'];
        if (substr($ar['obj_descr'],strlen($ar['obj_descr'])-1,1)!=".") {
          $sobr_note.=". ";
        };
      };
      
      
      echo "<td valign=\"top\">".$sobr_note."</td>";
      
      // ====================================================== Собираем адрес объекта + адрес для URL
      
      // Адрес: собираем адрес объекта + адрес для URL
      $sobr_adres_url="";
      $sobr_adres="";
         
      // Если город вообще указан (либо выбран из списка, либо непустой свой вариант)
      if ( ($ar['geo_gorod_id']>0) || (($ar['geo_gorod_id']==-1) && (strlen($ar['geo_gorod'])!=0)) ){
             
        // Если город выбран из списка
        if ($ar['geo_gorod_id']>0)  {
          $sobr_adres.=gettitle($db, 'spr_geo_gorod', $ar['geo_gorod_id']);
          $sobr_adres_url.=gettitle($db, 'spr_geo_gorod', $ar['geo_gorod_id']);
        }; 
      
        // Если город введен вручную
        if ($ar['geo_gorod_id']==-1)  {
          $sobr_adres.=$ar['geo_gorod'];
          $sobr_adres_url.=$ar['geo_gorod'];
        }; 
              
                  
        // Если улица вообще указана (либо выбрана из списка, либо непустой свой вариант)
        if ( ($ar['geo_street_id']>0) || (($ar['geo_street_id']==-1) && (strlen($ar['geo_street'])!=0)) ){
                
          // Если улица выбрана из списка
          if ($ar['geo_street_id']>0)  {
            $sobr_adres.=", ".gettitle_d($db, 'spr_geo_street', $ar['geo_street_id']);
            $sobr_adres_url.=", ".gettitle_d($db, 'spr_geo_street', $ar['geo_street_id']);
          };  
                  
          // Если улица введена вручную
          if ($ar['geo_street_id']==-1)  {
            $sobr_adres.=", ".$ar['geo_street'];
            $sobr_adres_url.=", ".$ar['geo_street'];
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
            // + номер квартиры
            if (($ar['geo_n_kv_show_fl']=='1') && (strlen($ar['geo_n_kv'])!=0)) {
              $sobr_adres.=", кв. ".$ar['geo_n_kv'];
            };
          };
              
        // (конец) если улица вообще указана
        };
           
        $sobr_adres_url="http://maps.yandex.ru/?text=".urlencode($sobr_adres_url);
        //echo "<a href=\"".$sobr_adres_url."\" target=\"_blank\" class=\"link\">".$sobr_adres."</a><br>";
      
      };
      

      if ($sobr_adres_url!="") {
        //echo "<td align=\"center\" valign=\"top\"><a class=\"link\" href=\"".$sobr_adres_url."\" target=\"_blank\">".$sobr_adres."</a></td>";
        echo "<td align=\"center\" valign=\"top\">".$sobr_adres."</td>";
      } else {
        echo "<td align=\"center\" valign=\"top\">".$sobr_adres."</td>";
      };
      
      
      // ====================================================== Собираем стоимость
      $sobr_price="";
      if ($ar['obj_price_sell']!=0) {
        $sobr_price.=$ar['obj_price_sell']." тыс. руб.";
        if ($ar['obj_price_torg_id']!=0) { // возможен торг
          $sobr_price.=", ".gettitle_d($db, 'spr_obj_price_torg', $ar['obj_price_torg_id']);
        };
      } else {
        $sobr_price="Цена не указана";
      };
        
        
      echo "<td align=\"center\" valign=\"top\">".$sobr_price."</td>";
      // ===============================================================
      
      
      echo "<td align=\"center\" valign=\"top\"><a href=\"./view_realty.php?id=".$ar['id']."\" class=\"link\">Подробнее</a></td>";
      echo "</tr>";
      
      
  };
  
  
  
  ?>
  
  

       
      
       
       </table>
       
       
       
       <!-- / ТАБЛИЦА -->
       
       
       
       
    </div>
  </div>
  
  
</div>

