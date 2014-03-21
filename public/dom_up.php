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
    if (owner_of ('sell_dom',$db , $_SESSION['id'], (int)$_GET['id'])) {
      // Если свою - значит поднимаем
      
      // ====================== Условие по времени (начало)
        $query="UPDATE sell_dom
                SET date_upped='".time()."' 
                WHERE id='".(int)$_GET['id']."';";
        $res=mysql_query($query,$db);
        
        // Записываем в журнал
        loging_add_domrecord ($db, $_SESSION['id'], "302", (int)$_GET['id'], get_dom_obyav_by_id($db,(int)$_GET['id']), get_dom_descr_by_id ($db, (int)$_GET['id']), get_dom_conta_by_id ($db, (int)$_GET['id']) );
      
        
      // ====================== Условие по времени (конец)
      
    };
    
    // Перенаправляем на страницу со списком объявлений    
    $url="http://www.novkva.ru/dom_v_velikom_novgorode.php";  
    header ("Location: $url");  
    exit; 
  }; // передан id через GET
  }; // юзер авторизован (glogged)
  
?>