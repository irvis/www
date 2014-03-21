<!-- Шапка -->
  
  <div class="shapka_box">
  <div class="shapka_cover">
    <div class="shapka_inner" style="width:963px;">
    
       <div style="float:left;display:inline;margin-top:10px;margin-left:10px;margin-bottom:10px;">
       <table width="400" border="0" cellpadding="0" cellspacing="0">
       <tr>
         <td width="110" rowspan="3" align="left" valign="middle">
           <a href="http://www.novkva.ru/index.php"><img src="./pics/novkva_logo_frog.gif" border="0" width="102" height="85" alt="Недвижимость Великого Новгорода. Проект Новгородская квартира"></a>
         </td>
         <td><a href="http://www.novkva.ru/" class="link">Проект &laquo;Новгородская квартира&raquo;</a></td>
       </tr>
       
       <tr>
         <td><a href="http://www.novkva.ru/index.php"><img src="./pics/novkva_logo_text.gif" border="0" width="280" height="44" alt="Недвижимость Великого Новгорода: покупка, продажа, аренда квартир, комнат, домов, коттеджей, участков в Великом Новгороде и Новгородской области"></a></td>
       </tr>
       
       <tr>
         <td><a href="http://www.novkva.ru/" class="link">Недвижимость Великого Новгорода</a></td>
       </tr>
       
       </table>
       </div>
       
       <div class="shapka_inner" style="border:0px solid red;float:right;display:inline;margin:0px;">
       <!--
         <img src="./pics/ico_favorites.gif" width="18" height="18" align="absmiddle">
         <a class="link" href="#">Добавить в избранное</a>
       -->
       
       
      <?php if ($glogged=='0') {
      //Если еще не авторизован
      ?> 
       
       
       <form method="post" action="./login.php">
       <table cellspacing="0" cellpadding="0" border="0">
       <tr>
         <td align="right">
         <input title="Введите свой Email, указанный при регистрации на сайте:" id="auth_l" class="pole" type="edit" onblur="onBlurThis(this.id);" onclick="onClickThis(this.id);" value="Ваш Email" style="width:90px;" name="auth_login">
         </td>
         <td align="right">
         <input title="Введите свой пароль" id="auth_p" class="pole" type="password" onblur="onBlurThis(this.id);" onclick="onClickThis(this.id);" value="Пароль" style="width:90px;" name="auth_pass">
         </td>
         <td align="right">
         <input class="knopka" type="submit" value="Войти">
         </td>
       </tr>
       <tr>
         <td align="right" colspan="4">
           <div style="margin-top:5px;">
           <a title="Пройдите несложную процедуру регистрации!" class="link" href="./register.php" rel="nofollow">Регистрация</a>
           /
           <!-- <a class="link" href="#">Забыли пароль?</a>-->
           
           <a title="Забыли пароль? Не беда! Его можно восстановить." class="link" href="./password.php" rel="nofollow">Забыли пароль?</a>
           
           </div>
           </td>
       </tr>
       </table>
       </form>
       <?php
       } else {
       
       //Если уже  авторизован
         echo $_SESSION['name']; 
         echo " (<b style=\"color:green\">".$_SESSION['nickname']."</b>) ";
         
         $prepared_phone='';
         if (strlen($_SESSION['phone'])==6)  { 
           $prepared_phone="(8162) ".$_SESSION['phone'];  
         }; 
         if (strlen($_SESSION['phone'])==10) { 
           $prepared_phone="+7".$_SESSION['phone'];      
         }; 
         
         echo ", тел. <b>".$prepared_phone."</b>";
         
         echo ", Email <b>".$_SESSION['email']."</b>";
         
         echo " [ <a class=\"link\" href=\"./login.php?action=logout\" title=\"Выйти\">Выйти</a> ]";
         
         
         if (active_db_id ($db , $_SESSION['id'])) {
           if (check_admin($_SESSION['id'])) {
             // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
             echo "<br><b style=\"color:orange;\">Учетная запись активна.</b>";
             echo "<br><a href=\"./adm_statistics.php\" class=\"link\">Журнал событий</a> ";
             // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
           } else {
             echo "<br><b style=\"color:green;\">Учетная запись активна.</b> ";
           };
           
         } else {
           echo "<br><b style=\"color:red;\">Ошибка: учётная запись не активирована!</b> ";
         };
         
       };
       ?>

       </div>
        
        
       
       
    </div>
  </div>
  
  </div>
  
  <!-- /Шапка -->