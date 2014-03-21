<?php 

  // Подключаем поддержку БД
  require "./_parts/_db.php"; 
  
  // Подключаем авторизацию
  require "./_parts/_auth.php"; 
  // если пользователь авторизован, тогда наша переменная $glogged имеет значение '1';
  
  // Поддержка отправки почты
  require "./_parts/_mail.php"; 
  
  // Запоминаем имя файла (для подсветки пунктов меню).
  $fname= basename (__FILE__);
  
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <title>Регистрация на сайте проекта "Новгородская квартира"</title>
  <?php require "./_parts/include_style.php"; ?>
</head>
<body>




<table align="center" width="985" border="0" cellpadding="0" cellspacing="0">
<!-- Шапка -->
<tr>
<td colspan="2">
  <?php require "./_parts/page_header.php"; ?>
</td>
</tr>
<!-- /Шапка -->

<!-- Меню -->
<tr>
<td colspan="2">
  <?php require "./_parts/menu_horisontal_top.php"; ?>
</td>
</tr>
<!-- /Меню -->

<!-- Баннер -->
<tr>
<td colspan="2">
  <?php require "./_parts/banner_horisontal_big.php"; ?>
</td>
</tr>
<!-- /Баннер -->



<!-- Тело -->
<tr>
<!-- +++++++++++++++++++++++++++++++++++++++++++ ЛЕВАЯ ЧАСТЬ -->
<td valign="top">

  <?php require "./_parts/menu_vertical_left.php"; ?>
  <div class="clear"></div>
  
  <?php require "./_parts/page_blok_news.php"; ?>
  <div class="clear"></div>
  
  <?php require "./_parts/page_blok_labels.php"; ?>
  <div class="clear"></div>
  
</td>
<!-- +++++++++++++++++++++++++++++++++++++++++++ ЛЕВАЯ ЧАСТЬ -->




<!-- Правая часть-->
<td valign="top">





<form name="regform" action="register.php" method="post">
<div class="content_box">
  <div class="content_header">
        <div class="content_inner">
        <b>Регистрация</b>
        </div>
  </div>
  <div class="clear"></div>
  <div class="content_cover">
    <div class="content_inner">
    
    <?php
    //echo "<pre>";
    //print_r($_POST);
    //echo "</pre>";
    //echo "<div class=\"clear\"></div>";
    
    
    
    
if (count($_POST)>0) {
// Если что-то передано через POST - проверка на вшивость!
    
    $errorlist="";
    
    //if ((!isset($_POST['obj_type_id'])) || ($_POST['obj_type_id']<=0) ) {$errorlist.="Не указан тип объекта!<br>";};
    
    
    // Проверка имени и фамилии
    if (isset($_POST['name'])) { 
      $fname=trim($_POST['name']);
      if (strlen($fname)<3) $errorlist.="Значение поля \"Ваши имя и фамилия\" не должно быть короче 5 символов.<br>";
      if (get_magic_quotes_gpc()==0) $fname=addslashes($fname);
    } else {
      $errorlist.="Не заполнено поле \"Ваши имя и фамилия\"<br>"; 
    };
    
    // Проверка отображаемого имени
    if (isset($_POST['nickname'])) { 
      $fnickname=trim($_POST['nickname']);
      if (strlen($fnickname)<2) $errorlist.="Значение поля \"Отображаемое имя (ник)\" не должно быть короче 2 символов.<br>";
      if (get_magic_quotes_gpc()==0) $fnickname=addslashes($fnickname);
    } else {
      $errorlist.="Не заполнено поле \"Отображаемое имя (ник)\"<br>"; 
    };
    
    
    $fprefix=trim($_POST['prefix']);
    $fprefix=htmlspecialchars($fprefix);
    // Проверка телефона
    if (isset($_POST['phone'])) { 
      $fphone=trim($_POST['phone']);
      if (get_magic_quotes_gpc()==0) $fphone=addslashes($fphone);
      if (($fprefix==1) || ($fprefix==2)) { 
        if (($fprefix==1) && (strlen($fphone)!=6)) {
          $errorlist.="Номер городского телефона должен состоять из 6 цифр.<br>";
        };
        if (($fprefix==2) && (strlen($fphone)!=10))  {
          $errorlist.="Номер мобильного телефона должен состоять из 10 цифр.<br>";
        };
      } else {
           $errorlist.="Проверьте корректность заполнения обязательного поля \"Телефон\".<br>";
      };
    
    } else {
      $errorlist.="Не заполнено обязательное поле \"Телефон\".<br>";
    };
    
         
    // Проверка Email
    if (isset($_POST['email'])) { 
      $femail=trim($_POST['email']);
      if (strlen($femail)<7) $errorlist.="Значение поля \"E-mail\" не должно быть короче 7 символов.<br>";
      if (get_magic_quotes_gpc()==0) $femail=addslashes($femail);
    } else {
      $errorlist.="Не заполнено поле \"E-mail\"<br>"; 
    };
         
    // Проверка пароля 
    if (isset($_POST['pwd1'])) { 
      $fpwd1=trim($_POST['pwd1']);
      if (strlen($fpwd1)<6) $errorlist.="Значение поля \"Пароль\" не должно быть короче 6 символов.<br>";
      if (get_magic_quotes_gpc()==0) $fpwd1=addslashes($fpwd1);
    } else {
      $fpwd1="";
      $errorlist.="Не заполнено поле \"Пароль\"<br>"; 
    };
         
    // Проверка повтора пароля 
    if (isset($_POST['pwd2'])) { 
      $fpwd2=trim($_POST['pwd2']);
      if (strlen($fpwd2)<6) $errorlist.="Значение поля \"Повтор пароля\" не должно быть короче 6 символов.<br>";
      if (get_magic_quotes_gpc()==0) $fpwd2=addslashes($fpwd2); 
    } else {
      $fpwd2="";
      $errorlist.="Не заполнено поле \"Повтор пароля\"<br>"; 
    };
         
    // Проверка соответствия паролей  
    if ($fpwd1!=$fpwd2) { 
      $errorlist.="Значения полей \"Пароль\" и \"Повтор пароля\" не совпадают<br>"; 
    };
    
    $fhash=md5('novkva.ru_novgorod'.$fpwd1.$femail.$fphone); // исправлен косяк с активацией (был хэш только от пароля)
    
    if (exist_db_email($db , $femail)) {
      $errorlist.="Такой email-адрес ранее уже проходил регистрацию на нашем сайте.<br>"; 
    };
    
    /*
    if (exist_db_phone($db , $fphone)) {
      $errorlist.="Такой телефон ранее уже проходил регистрацию на нашем сайте.<br>"; 
    };
    */
    
    
    
    
    
   

    
    // Проверка закончена
      
    if ($errorlist!="") {
      echo "<div style=\"margin:7px;\"><b style=\"color:red;\">".$errorlist."</b></div>";
    } else {
      // Добавляем объект в базу
      
      $query="INSERT INTO tbl_users SET ";
      $query.="status='0', ";
      $query.="date_register='".time()."', ";
      $query.="usr_ip='".$_SERVER['REMOTE_ADDR']."', ";
      $query.="usr_host='".$_SERVER['REMOTE_HOST']."', ";
      $query.="email='".$femail."', ";
      $query.="password='".$fpwd1."', ";
      $query.="md5_pwd='".md5($fpwd1)."', ";
      $query.="hash='".$fhash."', ";
      $query.="name='".$fname."', ";
      $query.="nickname='".$fnickname."', ";
      if ($fprefix==6) {
        $fprefix="(8162)";
      };
      if ($fprefix==10) {
        $fprefix="+7";
      };
      $query.="prefix='".$fprefix."', ";
      $query.="phone='".$fphone."'";
      $query.=";";
      
      $res=mysql_query($query,$db);
      
      
      
      
      // Отсылаем активационное письмо
      send_activation($fname, $femail, $fhash);
      
      echo "<b style=\"color:green\">Регистрация прошла успешно!</b><br>
      Письмо с активационной ссылкой было отправлено на Ваш электронный почтовый ящик <a class=\"link\" href=\"mailto:".htmlspecialchars($femail)."\">".htmlspecialchars($femail)."</a>.<br>"; 
      unset($_POST);
      
      //echo "Запрос=[".$query."]<br>";
    };
    
    

    
    
    
    
    
    
    
};
    
?>
    
    
    
    
    
         <table cellpadding="5">
         
         <tr>
           <td>Ваши имя и фамилия * :</td>
           <td>
             <input size="25" name="name" type="edit" value="<?php if (isset($_POST['name'])) { echo htmlspecialchars($_POST['name']); };?>" title="Введите Ваши имя и фамилию (на сайте не публикуются). <b>Указание недостоверных данных запрещено.</b>">
           </td>
         </tr> 
         
         <tr>
           <td>Отображаемое имя (ник) * :</td>
           <td>
             <input size="15" name="nickname" type="edit" value="<?php if (isset($_POST['nickname'])) { echo htmlspecialchars($_POST['nickname']); };?>" title="Введите Ваше отображаемое имя (ник). <b>Оно будет отображаться в оставленных Вами сообщениях, комментариях и т.п.</b>">
           </td>
         </tr> 
         
         <tr>
           <td>Телефон * :</td>
           <td>
           
             <select name="prefix">
             <?php printselectsort_title_d($db, 'spr_phone_prefix', $_POST['prefix']); ?>
             </select>
             
             <input size="15" name="phone" type="edit" value="<?php if (isset($_POST['phone'])) { echo htmlspecialchars($_POST['phone']); };?>" title="Введите Ваш номер телефона (ТОЛЬКО цифры: 6 цифр для городского, 10 цифр для мобильного). <b>Он будет служить Вашим логином для авторизации на сайте. Указание недостоверных данных запрещено.</b>">
             
           </td>
         </tr> 
         
         <tr>
           <td>Ваш e-mail * :</td>
           <td>
             <input size="25" name="email" type="edit" value="<?php if (isset($_POST['email'])) { echo htmlspecialchars($_POST['email']); };?>" title="Введите Ваш действующий e-mail. <b>На него будет отправлено письмо с активационной ссылкой.</b>">
           </td>
         </tr> 
         
         
         
         <tr>
           <td>Пароль * :</td>
           <td>
             <input size="10" name="pwd1" type="password" value="" title="Введите Ваш пароль (не менее 6 символов - только цифры и латинские буквы). Максимальная длина пароля 15 символов.">
           </td>
         </tr> 
         
         <tr>
           <td>Повтор пароля * :</td>
           <td>
             <input size="10" name="pwd2" type="password" value="" title="Введите Ваш пароль повторно.">
           </td>
         </tr> 
         
         
          
         
         
         
         
         
         
         
         
         
         
         <tr>
           <td colspan="2">&nbsp;</td>
         </tr>
         
         <tr>
           <td colspan="2"><input type="submit" value="Отправить форму"></td>
         </tr>
         
         
         
        
         
         
         </table>
         <div class="clear"></div>
       
    </div>
  </div>
</div>
</form>












  <div class="clear"></div>

</td>
<!-- /Правая часть-->

</tr>
<!-- /Тело -->





<!-- Меню -->
<tr>
<td colspan="2">
  <?php require "./_parts/menu_horisontal_bottom.php"; ?>
</td>
</tr>
<!-- /Меню -->

<!-- Подножие -->
<tr>
<td colspan="2">
  <div class="shapka_box" style="margin-top:0px;">
  <div class="shapka_cover">
    <?php require "./_parts/page_copyright.php"; ?>
    <?php require "./_parts/page_counters.php"; ?>
  </div>
  </div>
</td>
</tr>
<!-- /Подножие -->

</table>






<div class="clear"></div>









</body>
</html>