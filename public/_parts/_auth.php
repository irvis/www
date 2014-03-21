<?php

  $glogged='0';
  $debug='1';
  
  //$gg="";
  //$gg.="<pre>BEFORE";
  //$gg.=print_r($_SESSION,true);
  //$gg.="</pre><br><br>";
  //$gg.="<div class=\"clear\"></div>";
  
  
  
  
  // 1. Сначала смотрим в сессии, есть ли пометка авторизации:
  if ( (isset($_SESSION['logged'])) && ($_SESSION['logged']=='1') ) {
      $debug.='Нашли пометку в сессии, значит авторизовали сразу<br>';
      // Если пометка есть, значит сразу ставим глобальный флажок авторизации
      $glogged='1';
  } else {
      $debug.='Не нашли пометки в сессии, смотрим в куках<br>';
      //Если пометки в сессии нет, идём дальше - 
      //смотрим есть ли в кукисах идентификатор сессии:
      if (isset($_COOKIE['sid'])) {
          $debug.='Нашли в куках ID сессии, будем смотреть такую сессию в БД<br>';
          // Если в куках нашли идентификатор
          // Пробиваем его по базе данных (по таблице со сессиями)
          $query="SELECT * from tbl_sessions WHERE id='".$_COOKIE['sid']."'";
          $res=$db->query($query);
          $ar=$res->fetch_assoc(); //Записываем в $ar данные о сессии из БД  
          $num_rows = $res->num_rows();
          // Если поиск по БД успешен и если IP тот же самый - тогда авторизуем человека!   
          if (($num_rows>=1) && ($ar['user_ip']==$_SERVER['REMOTE_ADDR'])) {
              
              $_SESSION['sid']=$ar['id']; // Записываем id сессии (из БД)
              
              $debug.='Есть такая сессия в БД, IP правильный, значит извлекаем данные о пользователе из БД<br>';
              $query="SELECT * from tbl_users WHERE id='".$ar['user_id']."'";
              $res=$db->query($query);
              $ar=$res->fetch_assoc(); //Записываем в $ar данные о пользователе
              
              $debug.='Записываем данные о посетителе в сессию<br>';
              $_SESSION['name']=$ar['name'];
              $_SESSION['nickname']=$ar['nickname'];
              $_SESSION['email']=$ar['email'];
              $_SESSION['id']=$ar['id'];
              $_SESSION['special_id']=$ar['special_id'];
              $_SESSION['status']=$ar['status'];
              $_SESSION['phone']=$ar['phone']; // то, чего не хватало для счастья :)
              $_SESSION['logged']='1'; //ставим в сессии пометку "авторизован"
              
              $debug.='Авторизуем<br>';
              
              $glogged='1'; 
          } else {
              $debug.='Не нашли совпадений в БД (либо не с того IP адреса), авторизовывать не будем<br>';
          };
      } else {
          $debug.='Не нашли в куках ID сессии, авторизовывать не будем<br>';
          // Если в куках идентификатора нет
          // Ничего не делаем, glogged итак изначально = 0
      };
  };
  
  //$gg.="<pre>AFTER";
  //$gg.=print_r($_SESSION,true);
  //$gg.="</pre><br><br>";
  //$gg.="<div class=\"clear\"></div>";


?>