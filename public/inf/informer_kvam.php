<?php

  // Подключаем поддержку БД
  require "../_parts/_db.php"; 
  
  // Задаем параметры
  $days=30; // Глубина выборки в днях (смотрим все апнутые/запосченые квартиры за указанный период)
  $procent_correction=0.95; // Корректировка на процент от агентов (3-5%) и торг - считаем порядка 10% 
                            // Далее будем использовать для флажков коридор в 15-20% от вычисленных средних значений
  
  // Проверяем - был ли на сегодняшнюю дату расчет средних значений стоимости кв. метра
  $query="SELECT * 
          FROM inf_kvam 
          WHERE date='".date("d.m.Y", time())."'
          ;";
  $res=mysql_query($query,$db);
  $kolvo=mysql_num_rows($res);
  
  if ($kolvo==0) {
  // Значит еще не обсчитывалось, следовательно, БУДЕМ СЧИТАТЬ СЕЙЧАС!
    //echo "Еще не считано! Сейчас посчитаем-с...<br>";
    // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    
    // ================================== комната ===================
    $query="SELECT * FROM sell_kmn WHERE
              status='0' AND date_upped>='".(time()-60*60*24*$days)."' AND geo_gorod_id='1' AND price<='2000'
            ORDER BY date_upped DESC;";
    $res=mysql_query($query,$db); 
    $kolvo=mysql_num_rows($res);
    
    $sum=0;    // сумма цен
    $pl_sum=0; // сумма общей площади в метрах
    $kvam=0;   // стоимость 1 квадратного метра (инициализация)
    while (($ar=mysql_fetch_assoc($res)) == true ) {
      $sum=$sum+$ar['price'];
      $pl_sum=$pl_sum+$ar['kmn_pl'];
    };
    $kvam=round($sum/$pl_sum*1000*$procent_correction,0);
    //$l=strlen($kvam);
    //$kvam=substr($kvam,0,$l-3)."'".substr($kvam,$l-3,3); // ставим разделитель тысяч
    $kvam_k=$kvam;
    //echo "kvam_k=[".$kvam_k."]<br>";
    
    // ================================== 1 комн. кв. ===================
    $query="SELECT * FROM sell_kva WHERE
              status='0' AND kva_rooms='1' AND date_upped>='".(time()-60*60*24*$days)."' AND geo_gorod_id='1' AND price<='3000'
            ORDER BY date_upped DESC;";
    $res=mysql_query($query,$db); 
    $kolvo=mysql_num_rows($res);
    
    $sum=0;    // сумма цен
    $pl_sum=0; // сумма общей площади в метрах
    $kvam=0;   // стоимость 1 квадратного метра (инициализация)
    while (($ar=mysql_fetch_assoc($res)) == true ) {
      $sum=$sum+$ar['price'];
      $pl_sum=$pl_sum+$ar['kva_pl_ob'];
    };
    $kvam=round($sum/$pl_sum*1000*$procent_correction,0);
    //$l=strlen($kvam);
    //$kvam=substr($kvam,0,$l-3)."'".substr($kvam,$l-3,3); // ставим разделитель тысяч
    $kvam1=$kvam;
    //echo "kvam1=[".$kvam1."]<br>";
    
    // ================================== 2 комн. кв. ===================
    $query="SELECT * FROM sell_kva WHERE
              status='0' AND kva_rooms='2' AND date_upped>='".(time()-60*60*24*$days)."' AND geo_gorod_id='1' AND price<='4000'
            ORDER BY date_upped DESC;";
    $res=mysql_query($query,$db); 
    $kolvo=mysql_num_rows($res);
    
    $sum=0;    // сумма стоимостей
    $pl_sum=0; // сумма общей площади в метрах
    $kvam=0;   // стоимость 1 квадратного метра (инициализация)
    while (($ar=mysql_fetch_assoc($res)) == true ) {
      $sum=$sum+$ar['price'];
      $pl_sum=$pl_sum+$ar['kva_pl_ob'];
    };
    $kvam=round($sum/$pl_sum*1000*$procent_correction,0);
    //$l=strlen($kvam);
    //$kvam=substr($kvam,0,$l-3)."'".substr($kvam,$l-3,3); // ставим разделитель тысяч
    $kvam2=$kvam;
    //echo "kvam2=[".$kvam2."]<br>";
    
    // ================================== 3 комн. кв. ===================
    $query="SELECT * FROM sell_kva WHERE
              status='0' AND kva_rooms='3' AND date_upped>='".(time()-60*60*24*$days)."' AND geo_gorod_id='1' AND price<='5000'
            ORDER BY date_upped DESC;";
    $res=mysql_query($query,$db); 
    $kolvo=mysql_num_rows($res);
    
    $sum=0;    // сумма стоимостей
    $pl_sum=0; // сумма общей площади в метрах
    $kvam=0;   // стоимость 1 квадратного метра (инициализация)
    while (($ar=mysql_fetch_assoc($res)) == true ) {
      $sum=$sum+$ar['price'];
      $pl_sum=$pl_sum+$ar['kva_pl_ob'];
    };
    $kvam=round($sum/$pl_sum*1000*$procent_correction,0);
    //$l=strlen($kvam);
    //$kvam=substr($kvam,0,$l-3)."'".substr($kvam,$l-3,3); // ставим разделитель тысяч
    $kvam3=$kvam;
    //echo "kvam3=[".$kvam3."]<br>";
    
    // ================================== МНОГО комн. кв. ===================
    $query="SELECT * FROM sell_kva WHERE
              status='0' AND kva_rooms>='4' AND date_upped>='".(time()-60*60*24*$days)."' AND geo_gorod_id='1'
            ORDER BY date_upped DESC;";
    $res=mysql_query($query,$db); 
    $kolvo=mysql_num_rows($res);
    
    $sum=0;    // сумма стоимостей
    $pl_sum=0; // сумма общей площади в метрах
    $kvam=0;   // стоимость 1 квадратного метра (инициализация)
    while (($ar=mysql_fetch_assoc($res)) == true ) {
      $sum=$sum+$ar['price'];
      $pl_sum=$pl_sum+$ar['kva_pl_ob'];
    };
    $kvam=round($sum/$pl_sum*1000*$procent_correction,0);
    //$l=strlen($kvam);
    //$kvam=substr($kvam,0,$l-3)."'".substr($kvam,$l-3,3); // ставим разделитель тысяч
    $kvam4=$kvam;
    //echo "kvam4=[".$kvam4."]<br>";
    
    // ================================== СРЕДНЕЕ по кв. ===================
    $query="SELECT * FROM sell_kva WHERE
              status='0' AND date_upped>='".(time()-60*60*24*$days)."' AND geo_gorod_id='1'
            ORDER BY date_upped DESC;";
    $res=mysql_query($query,$db); 
    $kolvo=mysql_num_rows($res);
    
    $sum=0;    // сумма стоимостей
    $pl_sum=0; // сумма общей площади в метрах
    $kvam=0;   // стоимость 1 квадратного метра (инициализация)
    while (($ar=mysql_fetch_assoc($res)) == true ) {
      $sum=$sum+$ar['price'];
      $pl_sum=$pl_sum+$ar['kva_pl_ob'];
    };
    $kvam=round($sum/$pl_sum*1000*$procent_correction,0);
    //$l=strlen($kvam);
    //$kvam=substr($kvam,0,$l-3)."'".substr($kvam,$l-3,3); // ставим разделитель тысяч
    $kvam_sr=$kvam;
    //echo "kvam_sr=[".$kvam_sr."]<br>";
    
    // Записываем всё вычисленное в БД с соответствующей датировкой
    $query="INSERT INTO inf_kvam SET 
       datestamp='".time()."',
       date='".date("d.m.Y", time())."',
       kvam1='".$kvam1."',
       kvam2='".$kvam2."',
       kvam3='".$kvam3."',
       kvam4='".$kvam4."',
       kvam_sr='".$kvam_sr."',
       kvam_k='".$kvam_k."';";
    $res=mysql_query($query,$db); 
    //echo "Записано в БД! :)<br>";
    
    // Вставка разделителя разрядов
    $l=strlen($kvam1);
    $kvam1=substr($kvam1,0,$l-3)."'".substr($kvam1,$l-3,3); // ставим разделитель тысяч
    
    $l=strlen($kvam2);
    $kvam2=substr($kvam2,0,$l-3)."'".substr($kvam2,$l-3,3); // ставим разделитель тысяч
    
    $l=strlen($kvam3);
    $kvam3=substr($kvam3,0,$l-3)."'".substr($kvam3,$l-3,3); // ставим разделитель тысяч
    
    $l=strlen($kvam_sr);
    $kvam_sr=substr($kvam_sr,0,$l-3)."'".substr($kvam_sr,$l-3,3); // ставим разделитель тысяч
    
    // Генерация и вывод самого информера
    $img = ImageCreateFromJPEG('./informer_blank.jpg');   // Создаем рисунок
    $TextColor = ImageColorAllocate($img, 0, 0, 0);       // Цвет текста - черный
    ImageString($img, 2, 134, 57, $kvam1, $TextColor);    // 1 комн. квартиры
    ImageString($img, 2, 134, 76, $kvam2, $TextColor);    // 2 комн. квартиры
    ImageString($img, 2, 134, 95, $kvam3, $TextColor);    // 3 комн. квартиры
    ImageString($img, 3, 100, 148, $kvam_sr, $TextColor); // Среднее по квартирам
    $TextColor = ImageColorAllocate($img, 181, 181, 181); // Цвет текста - серый
    ImageString($img, 2, 138, 168, date("d.m.Y", time()), $TextColor); // Дата актуальности
    if (Function_Exists("ImageGIF")) {
      Header("Content-type: image/gif");
      ImageGIF($img);
    };
    ImageDestroy($img);
    
    // ====================================================================+++++++++++++++++++++++++++    
  } else { // $kolvo!=0
  // Значит УЖЕ посчитано, нужно просто вывести из БД
  
    //echo "Уже есть посчитанное! Загружаем значения из БД...<br>";
    // Вытаскиваем необходимые для информера данные
    $ar=mysql_fetch_assoc($res);
    $kvam1=$ar['kvam1'];
    $kvam2=$ar['kvam2'];
    $kvam3=$ar['kvam3'];
    $kvam_sr=$ar['kvam_sr'];
    
    // Вставка разделителя разрядов
    $l=strlen($kvam1);
    $kvam1=substr($kvam1,0,$l-3)."'".substr($kvam1,$l-3,3); // ставим разделитель тысяч
    
    $l=strlen($kvam2);
    $kvam2=substr($kvam2,0,$l-3)."'".substr($kvam2,$l-3,3); // ставим разделитель тысяч
    
    $l=strlen($kvam3);
    $kvam3=substr($kvam3,0,$l-3)."'".substr($kvam3,$l-3,3); // ставим разделитель тысяч
    
    $l=strlen($kvam_sr);
    $kvam_sr=substr($kvam_sr,0,$l-3)."'".substr($kvam_sr,$l-3,3); // ставим разделитель тысяч
    
    // Выводим значения, подготовленные для информера
    //echo "kvam1=[".$kvam1."]<br>";
    //echo "kvam2=[".$kvam2."]<br>";
    //echo "kvam3=[".$kvam3."]<br>";
    //echo "kvam_sr=[".$kvam_sr."]<br>";
    
    // Генерация и вывод самого информера
    $img = ImageCreateFromJPEG('./informer_blank.jpg');   // Создаем рисунок
    $TextColor = ImageColorAllocate($img, 0, 0, 0);       // Цвет текста - черный
    ImageString($img, 2, 134, 57, $kvam1, $TextColor);    // 1 комн. квартиры
    ImageString($img, 2, 134, 76, $kvam2, $TextColor);    // 2 комн. квартиры
    ImageString($img, 2, 134, 95, $kvam3, $TextColor);    // 3 комн. квартиры
    ImageString($img, 3, 100, 148, $kvam_sr, $TextColor); // Среднее по квартирам
    $TextColor = ImageColorAllocate($img, 181, 181, 181); // Цвет текста - серый
    ImageString($img, 2, 138, 168, date("d.m.Y", time()), $TextColor); // Дата актуальности
    if (Function_Exists("ImageGIF")) {
      Header("Content-type: image/gif");
      ImageGIF($img);
    };
    ImageDestroy($img);

  }; // $kolvo!=0;

?>