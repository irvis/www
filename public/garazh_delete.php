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
    if (owner_of ('sell_gar',$db , $_SESSION['id'], intval($_GET['id']))) {
      // Если свою - значит удаляем
      $query="UPDATE sell_gar
              SET status='8' 
              WHERE id='".intval($_GET['id'])."';";
      $res=$db->query($query);
    };
    
    // Перенаправляем на страницу со списком объявлений    
    $url=URL."/garazh_v_velikom_novgorode.php";  
    header ("Location: $url");  
    exit; 
  }; // передан id через GET
  }; // юзер авторизован (glogged)
  
?>