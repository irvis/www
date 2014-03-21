<?php 


function get_data($smtp_conn)
{
    $data="";
    while($str = fgets($smtp_conn,515))
    {
        $data .= $str;
        if(substr($str,3,1) == " ") { break; }
    };
    return $data;
};


function send_activation($m_to_name,$m_to_adr,$m_actcode)
{
    
    // Задаем параметры отправки письма:
    
    // ====== Это должно передаваться в процедуру:
    //$m_to_name='Константин';
    //$m_to_adr ='turboworld@gmail.com';
    //$m_actcode  ='1234567890';
    // ===========================================

    $m_subject  ='Проект "Новгородская квартира": Активация учётной записи';
    $m_actlink  ='http://www.novkva.ru/activate.php?code='.$m_actcode;
    
    $m_from_name='Проект "Новгородская квартира"';
    $m_from_adr ='noreply@novkva.ru';

    
    // Параметры доступа к серверу SMTP
    $smtp_server  ="smtp.timeweb.ru";
    $smtp_port    =25;
    $smtp_login   ="noreply@novkva.ru";
    $smtp_password="8887790123";
    
    $header ="Date: ".date("D, j M Y G:i:s")." +0700\r\n";
    $header.="From: =?windows-1251?Q?".str_replace("+","_",str_replace("%","=",urlencode($m_from_name)))."?= <".$m_from_adr.">\r\n";
    $header.="X-Mailer: The Bat! (v3.99.3) Professional\r\n";
    $header.="Reply-To: =?windows-1251?Q?".str_replace("+","_",str_replace("%","=",urlencode($m_from_name)))."?= <".$m_from_adr.">\r\n";
    $header.="X-Priority: 3 (Normal)\r\n";
    $header.="Message-ID: <172562218.".date("YmjHis")."@mail.ru>\r\n";
    $header.="To: =?windows-1251?Q?".str_replace("+","_",str_replace("%","=",urlencode($m_to_name)))."?= <".$m_to_adr.">\r\n";
    $header.="Subject: =?windows-1251?Q?".str_replace("+","_",str_replace("%","=",urlencode($m_subject)))."?=\r\n";
    $header.="MIME-Version: 1.0\r\n";
    $header.="Content-Type: text/plain; charset=windows-1251\r\n";
    $header.="Content-Transfer-Encoding: 8bit\r\n";

    $text="Здравствуйте.\r\n\r\n".
    
    "Кто-то указал этот адрес электронной почты при регистрации на сайте http://www.novkva.ru/ (Проект \"Новгородская квартира\". Недвижимость Великого Новгорода.).\r\n\r\n".
    
    "Для завершения процесса регистрации, пожалуйста, пройдите по ссылке:\r\n".
    $m_actlink."\r\n\r\n".
    
    "С уважением,\r\n".
    "Администрация NOVKVA.RU";

    $smtp_conn = fsockopen($smtp_server, 2525,$errno, $errstr, 10);
    if(!$smtp_conn) {print "соединение с серверов не прошло"; fclose($smtp_conn); exit;}
    $data = get_data($smtp_conn);
    fputs($smtp_conn,"EHLO novkva\r\n");
    $code = substr(get_data($smtp_conn),0,3);
    if($code != 250) {print "ошибка приветсвия EHLO"; fclose($smtp_conn); exit;}
    fputs($smtp_conn,"AUTH LOGIN\r\n");
    $code = substr(get_data($smtp_conn),0,3);
    if($code != 334) {print "сервер не разрешил начать авторизацию"; fclose($smtp_conn); exit;}

    fputs($smtp_conn,base64_encode($smtp_login)."\r\n");
    $code = substr(get_data($smtp_conn),0,3);
    if($code != 334) {print "ошибка доступа к такому юзеру"; fclose($smtp_conn); exit;}
  

    fputs($smtp_conn,base64_encode($smtp_password)."\r\n");
    $full=get_data($smtp_conn);
    $code = substr($full,0,3);
    if($code != 235) {print "не правильный пароль"; fclose($smtp_conn); exit;}

    $size_msg=strlen($header."\r\n".$text);

    fputs($smtp_conn,"MAIL FROM:<".$m_from_adr."> SIZE=".$size_msg."\r\n");
    $code = substr(get_data($smtp_conn),0,3);
    if($code != 250) {print "сервер отказал в команде MAIL FROM"; fclose($smtp_conn); exit;}
    
    
    // Реальный получатель тут: (а не в заголовках)
    fputs($smtp_conn,"RCPT TO:<".$m_to_adr.">\r\n");
    $code = substr(get_data($smtp_conn),0,3);
    if($code != 250 AND $code != 251) {print "Сервер не принял команду RCPT TO"; fclose($smtp_conn); exit;}

    fputs($smtp_conn,"DATA\r\n");
    $code = substr(get_data($smtp_conn),0,3);
    if($code != 354) {print "сервер не принял DATA"; fclose($smtp_conn); exit;}

    fputs($smtp_conn,$header."\r\n".$text."\r\n.\r\n");
    $full=get_data($smtp_conn);
    $code = substr($full,0,3);
    //echo "=".$full."=<br>";
    if($code != 250) {print "ошибка отправки письма"; fclose($smtp_conn); exit;}

    fputs($smtp_conn,"QUIT\r\n");
    fclose($smtp_conn);
};






// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

// Отправка пароля на почту
function send_forgot_password($m_to_name,$m_to_adr,$m_pwd)
{
    
    // Задаем параметры отправки письма:
    
    // ====== Это должно передаваться в процедуру:
    //$m_to_name='';
    //$m_to_adr ='';
    //$m_pwd  ='';
    // ===========================================

    $m_subject  ='Восстановление пароля NOVKVA.RU';
    
    $m_from_name='Администрация NOVKVA.RU';
    $m_from_adr ='noreply@novkva.ru';

    
    // Параметры доступа к серверу SMTP
    $smtp_server  ="smtp.timeweb.ru";
    $smtp_port    =25;
    $smtp_login   ="noreply@novkva.ru";
    $smtp_password="8887790123";
    
    $header ="Date: ".date("D, j M Y G:i:s")." +0700\r\n";
    $header.="From: =?windows-1251?Q?".str_replace("+","_",str_replace("%","=",urlencode($m_from_name)))."?= <".$m_from_adr.">\r\n";
    $header.="X-Mailer: The Bat! (v3.99.3) Professional\r\n";
    $header.="Reply-To: =?windows-1251?Q?".str_replace("+","_",str_replace("%","=",urlencode($m_from_name)))."?= <".$m_from_adr.">\r\n";
    $header.="X-Priority: 3 (Normal)\r\n";
    $header.="Message-ID: <172562218.".date("YmjHis")."@mail.ru>\r\n";
    $header.="To: =?windows-1251?Q?".str_replace("+","_",str_replace("%","=",urlencode($m_to_name)))."?= <".$m_to_adr.">\r\n";
    $header.="Subject: =?windows-1251?Q?".str_replace("+","_",str_replace("%","=",urlencode($m_subject)))."?=\r\n";
    $header.="MIME-Version: 1.0\r\n";
    $header.="Content-Type: text/plain; charset=windows-1251\r\n";
    $header.="Content-Transfer-Encoding: 8bit\r\n";

    $text="Здравствуйте.\r\n\r\n".
    
    "На сайте http://www.novkva.ru/ (Новгородская квартира) Вы запросили восстановление пароля.\r\n\r\n".
    
    "Ваши параметры для доступа на сайт:\r\n".
    "===================================\r\n".
    "E-mail: ".$m_to_adr."\r\n".
    "Пароль: ".$m_pwd."\r\n".
    "===================================\r\n\r\n".
    
    "С уважением,\r\n".
    "Администрация NOVKVA.RU";

    $smtp_conn = fsockopen($smtp_server, $smtp_port,$errno, $errstr, 10);
    if(!$smtp_conn) {print "соединение с серверов не прошло"; fclose($smtp_conn); exit;}
    $data = get_data($smtp_conn);
    fputs($smtp_conn,"EHLO novkva\r\n");
    $code = substr(get_data($smtp_conn),0,3);
    if($code != 250) {print "ошибка приветсвия EHLO"; fclose($smtp_conn); exit;}
    fputs($smtp_conn,"AUTH LOGIN\r\n");
    $code = substr(get_data($smtp_conn),0,3);
    if($code != 334) {print "сервер не разрешил начать авторизацию"; fclose($smtp_conn); exit;}

    fputs($smtp_conn,base64_encode($smtp_login)."\r\n");
    $code = substr(get_data($smtp_conn),0,3);
    if($code != 334) {print "ошибка доступа к такому юзеру"; fclose($smtp_conn); exit;}
  

    fputs($smtp_conn,base64_encode($smtp_password)."\r\n");
    $full=get_data($smtp_conn);
    $code = substr($full,0,3);
    if($code != 235) {print "не правильный пароль"; fclose($smtp_conn); exit;}

    $size_msg=strlen($header."\r\n".$text);

    fputs($smtp_conn,"MAIL FROM:<".$smtp_login."> SIZE=".$size_msg."\r\n");
    $code = substr(get_data($smtp_conn),0,3);
    if($code != 250) {print "сервер отказал в команде MAIL FROM"; fclose($smtp_conn); exit;}
    
    
    // Реальный получатель тут: (а не в заголовках)
    fputs($smtp_conn,"RCPT TO:<".$m_to_adr.">\r\n");
    $code = substr(get_data($smtp_conn),0,3);
    if($code != 250 AND $code != 251) {print "Сервер не принял команду RCPT TO"; fclose($smtp_conn); exit;}

    fputs($smtp_conn,"DATA\r\n");
    $code = substr(get_data($smtp_conn),0,3);
    if($code != 354) {print "сервер не принял DATA"; fclose($smtp_conn); exit;}

    fputs($smtp_conn,$header."\r\n".$text."\r\n.\r\n");
    $full=get_data($smtp_conn);
    $code = substr($full,0,3);
    //echo "=".$full."=<br>";
    if($code != 250) {print "ошибка отправки письма"; fclose($smtp_conn); exit;}

    fputs($smtp_conn,"QUIT\r\n");
    fclose($smtp_conn);
};

?>