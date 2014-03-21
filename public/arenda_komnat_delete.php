<?php 

  // Подключаем поддержку БД
  require "./_parts/_db.php"; 
  
  // Подключаем авторизацию
  require "./_parts/_auth.php"; 
  // если пользователь авторизован, тогда наша переменная $glogged имеет значение '1';
  
  // Запоминаем имя файла (для подсветки пунктов меню).
  //$fname= basename (__FILE__);
  
  if ($glogged=='1') {
  if ( (isset($_GET['id'])) && (strlen(($_GET['id']))>0) ) {
    // Проверяем авторство (свою ли объяву)
    if (owner_of ('rent_kmn',$db , $_SESSION['id'], intval($_GET['id']))) {
      // Если свою - значит удаляем
      $query="UPDATE rent_kmn
              SET status='8' 
              WHERE id='".intval($_GET['id'])."';";
      $res=mysql_query($query,$db);
	  
	  // Записываем в журнал
      unilog_add_record (
	     $db,
	     $_SESSION['id'],
		 "204", // Действие    - Удаление объекта  - 204
		 "22",  // Тип объекта - Комната в аренду - 22
		 (int)$_GET['id'], // Номер объекта
		 "Удаление объявления: ".get_kmn_rent_obyav_by_id($db,(int)$_GET['id']),   // Описание - генерация текста объявления
		 "Описание: ".get_kmn_rent_descr_by_id ($db, (int)$_GET['id']), // Допинфа1 - Описание
		 "Контакты: ".get_kmn_rent_conta_by_id ($db, (int)$_GET['id'])  // Допинфа2 - Контакты
	  );
	  // Записали в журнал
	  
	  
    };
    
    // Перенаправляем на страницу со списком объявлений    
    $url="http://www.novkva.ru/arenda_komnat_v_velikom_novgorode.php";  
    header ("Location: $url");  
    exit; 
  }; // передан id через GET
  }; // юзер авторизован (glogged)
  
?>