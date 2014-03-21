<?php 

  // Подключаем поддержку БД
  require "./_parts/_db.php"; 
  
  // Подключаем авторизацию
  require "./_parts/_auth.php"; 
  // если пользователь авторизован, тогда наша переменная $glogged имеет значение '1';
  
  // Подключаем почтовые фишки
  require "./_parts/_mail.php"; 
  
  // Запоминаем имя файла (для подсветки пунктов меню).
  $fname= basename (__FILE__);
  
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <title>Восстановление пароля - Проект &laquo;Новгородская квартира&raquo;</title>
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
  <div class="content_box">
  <div class="content_header">
        <div class="content_inner">
        <b>Проект &laquo;Новгородская квартира&raquo;</b>
        </div>
  </div>
  <div class="clear"></div>
  <div class="content_cover">
    <div class="content_inner">
      
      <div class="otstup"> <!-- otstup --> 
      
      <h2>Восстановление пароля</h2>
       
       
<script language="JavaScript" type="text/JavaScript">
       // Проверка правильности заполнения формы восстановления пароля
function CheckForm() {


// =========== 1. Проверка Email 
p_email=document.forgot_pass.email.value.toString(); 
if (p_email!='') { 
  t1=p_email.indexOf('.');
  t2=p_email.indexOf('@');
  len=p_email.length;
  if ((t1==-1) || (t2==-1) || (len<7)) {
    alert('Некорректно указан E-mail!'); 
    document.forgot_pass.email.focus(); 
    return false;
  };
} else {
  alert('Не заполнено поле \"E-mail\".');
  document.forgot_pass.email.focus();
  return false;
};

return true;
};
</script>
       
       
       
       
       
       
       
       
       
       
       
  <?php 
       // ==========================================================================
       // Если в массиве POST пусто, значит выводим форму для восстановления пароля
       if (count($_POST)==0) { 
       ?>
          
          <p>Если Вы забыли свой пароль, указанный при регистрации на нашем сайте, данная форма поможем Вам его восстановить.</p>
          
          <noscript>
            <p><span style="color:red;font-weight:bold;">Для корректной работы регистрационной формы включите поддержку Javascript.</span></p>
          </noscript>
             
             <form method="POST" name="forgot_pass" action="./password.php" onsubmit="return CheckForm();">
             <table style="margin-bottom:30px;" align="left" border="0" cellpadding="4" cellspacing="0" width="650">
             
             <tr>
             <td align="left" valign="top" width="150">
               <b>Ваш E-mail *</b><br>
               <input name="email" value="" type="text">
             </td>
             
             <td align="left" valign="bottom">
               <input value="Восстановить пароль" name="retrieve" type="submit">
             </td>
             </tr>
             </table>
             </form>
          
       <?php 
       // =============================================
       // Если в массиве POST что-то есть, значит надо проверить информацию 
       } else {    
       
             // Считываем email из POST
             $mailadr=trim($_POST['email']); 
             if (get_magic_quotes_gpc()==0) $mailadr=addslashes($mailadr);            
             
             // Проверяем наличие такого email в нашей базе.
             $query="SELECT * from tbl_users WHERE email='".$mailadr."'";
             $res=mysql_query($query,$db);
             $num_rows = mysql_num_rows($res);
             
             if ($num_rows==0) {
                 echo "<p style=\"color:red;font-weight:bold;\">Ошибка: данный адрес электронной почты не проходил регистрации на нашем сайте.</p>\n";
                 echo "<p>Вы можете <a href=\"./password.php\">вернуться</a> к форме восстановления пароля.</p>";
             } else {
                 // Такой адрес найден, загружаем инфу о пользователе
                 $ar=mysql_fetch_assoc($res); //Записываем в $ar данные о пользователе        
                 
                 // Отсылаем письмо с паролем на Email
                 send_forgot_password($ar['name'],$ar['email'],$ar['password']);
                 
                 echo "<p>На Ваш электронный адрес отправлено письмо, содержащее дальнейшие указания.</p>";
             };


       // ==========================================================================
       };
       ?>      
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       

          
      

      
      </div> <!-- otstup --> 
      
    </div>
  </div>
  
  
  
  
  
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