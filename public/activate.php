<?php

  // Подключаем поддержку БД
  require "./_parts/_db.php"; 
  
  if (isset($_GET['code'])) {
      $code=trim($_GET['code']);
      if (get_magic_quotes_gpc()==0) $code=addslashes($code);
      $code=mysql_real_escape_string($code);
  } else {
      //Если не передали код, редиректим на главную
      $url="http://".$_SERVER['HTTP_HOST']."/";
      header("Location: ".$url);
      exit;  
  };


  // Проверяем наличие такого хеша в нашей базе.
  $query="SELECT * from tbl_users WHERE hash='".$code."' AND status='0'";
  $res=mysql_query($query,$db);
 
  $num_rows = mysql_num_rows($res);
 
  if ($num_rows==1) {
      
      // Активируем пользователя (ставим статус:=1)
      $query="UPDATE tbl_users SET 
              status = '1'
              WHERE hash   = '".$code."'";
      $res=mysql_query($query,$db);
      echo "<div style=\"font-family:Arial;\">";
      echo "<h2 style=\"color:green;\">Активация завершена</h2>\n";
      echo "<p>Поздравляем! Регистрация успешно завершена. Теперь Вы можете <a href=\"http://".$_SERVER['HTTP_HOST']."/\">войти на сайт</a>, используя свой логин (номер телефона) и пароль, указанные при регистрации.</p>\n";
      echo "</div>\n";
      
  } else {
      echo "<div style=\"font-family:Arial;\">";
      echo "<h2 style=\"color:red;\">Ошибка активации</h2>\n";
      echo "<p>Проверьте правильность активационной ссылки.<br>Возможно, это Ваш повторный заход по ссылке и Ваша учетная запись уже активирована.</p>";
      echo "</div>\n";
      
  };




?>