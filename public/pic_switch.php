<?php



    // Подключаем поддержку БД
    require "./_parts/_db.php";  //require "./_parts/_db.php";
    
    // Подключаем авторизацию
    require "./_parts/_auth.php";  //require "./_parts/_auth.php"; 
    // если пользователь авторизован, тогда наша переменная $glogged имеет значение '1';
  
    $pic_id=(int)$_GET['id'];
    
    // Сначала находим эту картинку в базе....
    $query="SELECT * FROM lib_pictures WHERE id='".$pic_id."' AND status='0'";
    $res=mysql_query($query,$db);
    $kolvo=mysql_num_rows($res);
    if ($kolvo=='1') {
      $ar=mysql_fetch_assoc($res);
      $user_id=$ar['usr_id'];
      $obj_type=$ar['pic_obj_type_id']; 
      $obj_id  =$ar['pic_obj_id'];
      
      $avtor=false; if ($user_id==$_SESSION['id']) { $avtor=true; }; // Флажок авторства
      $admin=false; if (check_admin($_SESSION['id'])) { $admin=true; }; // Флажок админства
      
      if ($ar['pic_type_id']=='1') { $temp='2'; }
      if ($ar['pic_type_id']=='2') { $temp='1'; }
      
      if ($avtor || $admin) {
        // Помечаем картинку как удаленную
        $query="UPDATE lib_pictures SET pic_type_id= '".$temp."' WHERE id = '".$pic_id."'";
        $res=mysql_query($query,$db); 
        
        // Записываем в журнал
        unilog_add_record (
          $db,
          $_SESSION['id'],
          "209",     // Действие - Переключение фотографии объекта план/фото - 209
          $obj_type, // Тип объекта - Комната в аренду - 22
          $obj_id,   // Номер объекта
          "Переключение фотографии (№".$pic_id.") объекта (type=".$obj_type.",id=".$obj_id."), новый тип фото = [".$temp."]",   // Описание - генерация текста объявления
          "", // Допинфа1
          ""  // Допинфа2
        );
        // Записали в журнал
        
        // Редиректим обратно
        header("Location: ".$_SERVER['HTTP_REFERER']);
        exit;
      } else {
        echo "Ошибка доступа. Чужое объявление.";
      };
      
    } else {
      echo "Ошибка доступа. Изображение в БД не найдено.";
    };






























                      


  
  
  
  

?>