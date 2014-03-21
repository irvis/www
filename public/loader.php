<?
  // Подключаем поддержку БД
  require "./_parts/_db.php";  //require "./_parts/_db.php";
  
  // Подключаем авторизацию
  require "./_parts/_auth.php";  //require "./_parts/_auth.php"; 
  // если пользователь авторизован, тогда наша переменная $glogged имеет значение '1';
  
// Параметры НА ВХОДЕ (объект, пользователь) - принимаем из POST
$obj_type=(int)$_POST['obj_type']; // Тип объекта, сделки - 1 продажа кв, 2 аренда кв., ...
$obj_id=(int)$_POST['obj_id'];     // ID объекта
$pic_type=(int)$_POST['pic_type']; // Тип картинки (планировка / фото)
$user_id=(int)$_SESSION['id'];     // ID пользователя


// Параметры для картинок
$upload_dir="/home/n/nifestofil/novkva/public_html/pics/uploaded/"; // Папка для загруженных картинок

$max_image_width  = 2500;
$max_image_height  = 1500;
$max_image_size    = 1024 * 1024; // предел 1 Мб
$valid_types     =  array("jpg", "jpeg");
$new_h=120; // высота в пикселах для превьюшки.

// Инициализация переменной со списком ошибок
$errorlist="";












if (isset($_FILES["uploadingfile"])) {
  if (is_uploaded_file($_FILES['uploadingfile']['tmp_name'])) {
    // Создаем указатель на файл (полный путь + имя)
    $filename = $_FILES['uploadingfile']['tmp_name'];
    $ext = strtolower(substr($_FILES['uploadingfile']['name'], 1 + strrpos($_FILES['uploadingfile']['name'], ".")));
    
    // Проверяем загружаемое изображение
    if (filesize($filename) >= $max_image_size) { // Проверка размера файла
      echo "<h3 style=\"color:red;\">Ошибка! Превышен допустимый размер файла (1 Мб)!</h3>"; exit;
    } elseif (!in_array($ext, $valid_types)) { // Проверка типа файла
      echo "<h3 style=\"color:red;\">Ошибка! Неверный тип файла! Разрешена загрузка только формата JPG/JPEG</h3>"; exit;
    } else {
       $size = GetImageSize($filename);
       if ((!$size) || ($size[0] > $max_image_width) || ($size[1] > $max_image_height)) { // Проверка размеров картинки в пискселях
         echo "<h3 style=\"color:red;\">Ошибка! Неверные размеры файла (ширина не более 2500, высота не более 1500 пикселей)!</h3>"; exit;
       } else {
       // ЕСЛИ ВСЕ OKAY
       // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
         $up_name=time()."_".date("Y.m.d_H.i",time()); // Имя файла (без расширения)
         $up_fname=$upload_dir.$up_name;               // Путь к файлу + имя файла (без расширения)
         $up_fext=$ext;                                // Расширение файла
         
         $uploadfile = $up_fname.".".$up_fext;
         $uploadfile_pre = $up_fname."_pre.".$up_fext;
         
         // проверка авторизации (начало)
         if (($glogged=='1') && (check_object_avtor($db, $user_id, $obj_type, $obj_id)) ) {
         
           if (copy($_FILES['uploadingfile']['tmp_name'], $uploadfile)) {
             //echo "<h3>Файл успешно загружен на сервер</h3>";
             
             // 1. Создаем и сохраняем превьюшку.
             make_thumb($uploadfile,$uploadfile_pre,$new_h);
             
             // 2. Добавляем запись в БД
             
             $query="INSERT INTO lib_pictures SET ";
             //$query.="status='0',";
             //$query.="checked_fl='0',";
             $query.="usr_id='".$_SESSION['id']."',";
             $query.="usr_ip='".$_SERVER['REMOTE_ADDR']."',";
             $query.="pic_type_id='".$pic_type."',";
            
            
             $query.="pic_obj_type_id='".$obj_type."',";
             $query.="pic_obj_id='".$obj_id."',";
            
             $query.="pic_orig='".$up_name.".".$up_fext."',";
             $query.="pic_thumb='".$up_name."_pre.".$up_fext."',";
            
             $query.="pic_old_filename='".mysql_real_escape_string($_FILES['uploadingfile']['name'])."'";
          
             $query.=";";
      
             $res=mysql_query($query,$db);
             $last_id=mysql_insert_id($db);
      
             // Записываем в журнал
             unilog_add_record (
               $db,
               $_SESSION['id'],
               "207", // Действие    - Загрузка фотографии к объекту  - 207
               $obj_type,  // Тип объекта - Комната в аренду - 22
               $obj_id,   // Номер объекта
               "Загрузка фотографии (№".$last_id.") к объекту (type=".$obj_type.",id=".$obj_id.")",   // Описание - генерация текста объявления
               "", // Допинфа1
               ""  // Допинфа2
              );
              // Записали в журнал
           
             // Редиректим на страницу с объектом (там увидим наше загруженное фото)
             redirector($db, $obj_type, $obj_id);
           
           } else {
             echo "<h3 style=\"color:red;\">Ошибка! Не удалось загрузить файл на сервер!</h3>"; exit;  
           };
         
         } else { // проверка авторзации (конец)
           echo "<h3 style=\"color:red;\">Ошибка авторизации: не авторизованы / нет такого объявления / вы не являетесь автором объявления</h3>"; exit;  
         };
       // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 
       
       
       };
    }
  } else {
    echo "<h3 style=\"color:red;\">Ошибка! Превышено максимально допустимое время загрузки (попробуйте уменьшить размер файла)!</h3>"; exit;
    //echo "Error: empty file.";
  };
}; // Если загружаем файл
?>