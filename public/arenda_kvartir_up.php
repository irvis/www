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
    if (owner_of ('rent_kva',$db , $_SESSION['id'], intval($_GET['id']))) {
      // Если свою - значит поднимаем
      
      // ====================== Условие по времени (начало)
        $query="UPDATE rent_kva
                SET date_upped='".time()."' 
                WHERE id='".intval($_GET['id'])."';";
        $res=mysql_query($query,$db);
		
		// Записываем в журнал
      unilog_add_record (
	     $db,
	     $_SESSION['id'],
		 "203", // Действие    - Поднятие объекта  - 203
		 "12",  // Тип объекта - Квартира в аренду - 12
		 (int)$_GET['id'], // Номер объекта
		 "Поднятие объявления: ".get_kv_rent_obyav_by_id($db,(int)$_GET['id']),   // Описание - генерация текста объявления
		 "Описание: ".get_kv_rent_descr_by_id ($db, (int)$_GET['id']), // Допинфа1 - Описание
		 "Контакты: ".get_kv_rent_conta_by_id ($db, (int)$_GET['id'])  // Допинфа2 - Контакты
	  );
	  // Записали в журнал
		
      // ====================== Условие по времени (конец)
      
    };
    
    // Перенаправляем на страницу со списком объявлений    
    $url="http://www.novkva.ru/arenda_kvartir_v_velikom_novgorode.php";  
    header ("Location: $url");  
    exit; 
  }; // передан id через GET
  }; // юзер авторизован (glogged)
  
?>