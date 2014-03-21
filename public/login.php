<?php
require_once '../app/config.php';

if (isset($_POST['auth_login'])) {
    $login=trim($_POST['auth_login']);
    $pass =trim($_POST['auth_pass']);
  
    // Ищем в базе такую пару tel+pass
    $query="SELECT * from tbl_users WHERE email='".$db->escape_string($login)."' AND password='".$db->escape_string($pass)."'";
    $res=$db->query($query);
    $ar=$res->fetch_assoc(); //Записываем в $ar данные о пользователе
    $num_rows = $res->num_rows;
    
    //echo "ZAPROS=[".$query."]";exit;
    
    // Если нашли в базе такую пару email+pass
    if ( $num_rows==1 ) {
        //ДОСТУП РАЗРЕШЕН, создаем НОВУЮ сессию
        $_SESSION['id']=$ar['id'];
        $_SESSION['status']=$ar['status'];
        $_SESSION['email']=$ar['email'];
        $_SESSION['name']=$ar['name'];
        $_SESSION['nickname']=$ar['nickname'];
        $_SESSION['phone']=$ar['phone'];
        $_SESSION['sid']=session_id(); // Записываем id новой сессии
        $_SESSION['logged']='1'; //ставим в сессии пометку "авторизован"
        
        // Добавляем в БД запись с данной сессией!
        $query="INSERT INTO tbl_sessions (id,created,user_id,user_ip)
                              VALUES ('".$_SESSION['sid']."','".time()."', '".$ar['id']."', '".$_SERVER['REMOTE_ADDR']."');";
        $res=$db->query($query);
      
        //Добавляем куки с ID новой созданной сессии
        setcookie('sid', $_SESSION['sid'], time()+86400); // ставим куку на 24 часа вперёд
        
        // Перенаправляем на страницу job.php
        //header("Location: http://".$_SERVER['HTTP_HOST']."/index.php");
        header("Location: ".$_SERVER['HTTP_REFERER']);
        exit;
    } else {
        //Не нашли в БД такие email+pass
        //echo "Ошибка ввода логина или пароля!";
        
        // Перенаправляем
        //header("Location: http://".$_SERVER['HTTP_HOST']."/index.php");
        //Не нашли в БД такие email+pass
        echo "Ошибка ввода Email и/или пароля! Вернуться <a href=\"".$_SERVER['HTTP_REFERER']."\">назад</a>.";
        
    };
  
};
if (isset($_GET['action']) AND $_GET['action']=="logout") {
    //Удаляем запись в БД с данным $_SESSION['sid']
    $query="DELETE FROM tbl_sessions WHERE id='".$_SESSION['sid']."';";
    $res=$db->query($query);
    
    // Удаляем сессию
    $_SESSION = array();// Unset all of the session variables.
    session_destroy();
    
    //Удаляем куки
    setcookie('sid', '', time()-100);
   
    //header("Location: http://".$_SERVER['HTTP_HOST']."/index.php");
    header("Location: ".$_SERVER['HTTP_REFERER']);
    exit;
};


?>