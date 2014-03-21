<?php 
require_once '../app/config.php';
  
  // Подключаем авторизацию
  require "./_parts/_auth.php"; 
  // если пользователь авторизован, тогда наша переменная $glogged имеет значение '1';
  
  // Запоминаем имя файла (для подсветки пунктов меню).
  //$fname= basename (__FILE__);
  
  if ($glogged=='1') {
  if ( (isset($_GET['id'])) && (strlen(($_GET['id']))>0) ) {
    // Проверяем авторство (свою ли объяву)
    if (owner_of ('sell_kmn',$db , $_SESSION['id'], (int)$_GET['id'])) {
      // Если свою - значит поднимаем
      
      // ====================== Условие по времени (начало)
        $query="UPDATE sell_kmn
                SET date_upped='".time()."' 
                WHERE id='".(int)$_GET['id']."';";
        $res=$db->query($query);
        
        // Записываем в журнал
        loging_add_kmnrecord ($db, $_SESSION['id'], "202", (int)$_GET['id'], get_kmn_obyav_by_id($db,(int)$_GET['id']), get_kmn_descr_by_id ($db, (int)$_GET['id']), get_kmn_conta_by_id ($db, (int)$_GET['id']) );
		
		// Записываем в журнал
      unilog_add_record (
	     $db,
	     $_SESSION['id'],
		 "203", // Действие    - Поднятие объекта  - 203
		 "21",  // Тип объекта - Комната на продажу - 21
		 (int)$_GET['id'], // Номер объекта
		 "Поднятие объявления: ".get_kmn_obyav_by_id($db,(int)$_GET['id']),   // Описание - генерация текста объявления
		 "Описание: ".get_kmn_descr_by_id ($db, (int)$_GET['id']), // Допинфа1 - Описание
		 "Контакты: ".get_kmn_conta_by_id ($db, (int)$_GET['id'])  // Допинфа2 - Контакты
	  );
	  // Записали в журнал
		
      
      // ====================== Условие по времени (конец)
      
    };
    
    // Перенаправляем на страницу со списком объявлений    
    $url="http://www.novkva.ru/komnata_v_velikom_novgorode.php";  
    header ("Location: $url");  
    exit; 
  }; // передан id через GET
  }; // юзер авторизован (glogged)
  
?>