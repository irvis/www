<?php 
  
  ini_set("display_errors","1");
  ini_set("display_startup_errors","1");
  ini_set('error_reporting', E_ALL);
  
require_once '../app/config.php'; 
  
  // Подключаем авторизацию
  require "./_parts/_auth.php"; 
  // если пользователь авторизован, тогда наша переменная $glogged имеет значение '1';
  
  // Запоминаем имя файла (для подсветки пунктов меню).
  $fname= basename (__FILE__);
  
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <title>Журнал событий - Проект &laquo;Новгородская квартира&raquo;</title>
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
      
      <h2>Журнал событий</h2>
      
      <?php
      
      if ($glogged=='1') {
      // Если пользователь АВТОРИЗОВАН на сайте
        if (check_admin($_SESSION['id'])) {
        // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
          
          //echo "<p>Права администратора проверены: доступ открыт.</p>";
          
          
          // Дописка по узкому выбору
          $dopis="";
          if (
               ((count($_GET)>0) && (!(isset($_GET['page']))) )
               ||
               ((count($_GET)>1) && (isset($_GET['page'])) )
              )
          {
            $dopis.="<p>Применен фильтр по ";
            if (isset($_GET['user_id'])) { $dopis.="пользователю (user_id=".(int)$_GET['user_id'].")"; };
            if (isset($_GET['ip'])) { $dopis.="IP-адресу (".htmlspecialchars($_GET['ip']).")"; };
            if (isset($_GET['tip'])) { $dopis.="типу действий (tip=".(int)$_GET['tip'].")"; };
            if (isset($_GET['kod'])) { $dopis.="коду действий (kod=".(int)$_GET['kod'].")"; };
            //if (isset($_GET['subj'])) { $dopis.="объекту действий (subj=".(int)$_GET['subj'].")"; };
            $dopis.=" <a href=\"./adm_statistics.php\" class=\"link\">Смотреть все записи</a>";
            $dopis.="</p>";
          };
          
          echo $dopis;
          
          $add_zapr="";
          
          
          if (count($_GET)>0)  {
            if (isset($_GET['user_id'])) { $add_zapr="AND t.user_id='".(int)$_GET['user_id']."' "; };
            if (isset($_GET['ip'])) { $add_zapr="AND t.sec_ip='".mysql_real_escape_string($_GET['ip'])."' "; };
            if (isset($_GET['tip'])) { $add_zapr="AND t.action_id>='".((int)($_GET['tip'])+1)."' AND t.action_id<='".((int)($_GET['tip'])+99)."' "; };
            if (isset($_GET['kod'])) { $add_zapr="AND t.action_id='".(int)($_GET['kod'])."' "; };
          };
          
          //echo "add_zap=[".$add_zapr."]<br>";
          
          
          
          
          
          
          
          
          
          
          
          
          
          // =====================================================
          // =Подготовка к пагинатору ============================

          // вычисляем общее количество записей
          $query="SELECT COUNT(*)
                  FROM logs AS t, l_act_spr AS t1, tbl_users AS t2
                  WHERE t.action_id=t1.id AND
                        t.user_id=t2.id 
                        ".$add_zapr."
                  ORDER BY t.id DESC";  
            
          //echo "query={".$query."}<br>";
          $res = $db->query($query);
          $tmp=$res->fetch_array();
          $kolvo=$tmp[0]; 
          
          // задаем количество записей на страницу (ВНИМАНИЕ! Далее она используется в запросе SQL!!!!)
          $n=15;
          
          // задаем минимальный номер страницы (это всегда 1 в нашем случае)
          $p_min=1;
          
          // вычисляем максимальный номер страницы
          $p_max=floor($kolvo/$n);
          if ($kolvo%$n!=0) { $p_max=$p_max+1; };
          
          // считываем из GET номер текущей страницы
          $current=1; // по умолчанию = 1, если через GET ничего не пришло или пришла ересь.
          if (isset($_GET['page'])) {
            if (($_GET['page']>=$p_min) && ($_GET['page']<=$p_max)) {
              $current=$_GET['page'];
            } else {
              if ($_GET['page']>$p_max) $current=$p_max;
            };
          };
          
          
          // вычисляем номера страниц для пагинатора
          $p_r=$current-1; 
          $p_rr=$current-2; 
          $p_rrr=$current-3; 
          $p_rrrr=$current-4; 
          
          $p_n=$current+1; 
          $p_nn=$current+2; 
          $p_nnn=$current+3; 
          $p_nnnn=$current+4; 
          
          // =/Подготовка к пагинатору ===========================
          // =====================================================
          
          $page_url="./adm_statistics.php";
          // Добавляем параметры, если они есть в GET
          if (
               (isset($_GET['user_id'])) 
               || (isset($_GET['ip'])) 
               || (isset($_GET['tip']))
               || (isset($_GET['kod']))
             )
          {   
           $page_url.="?";
           if (isset($_GET['user_id'])) { $page_url.="user_id=".$_GET['user_id']."&"; };
           if (isset($_GET['ip'])) { $page_url.="ip=".$_GET['ip']."&"; };
           if (isset($_GET['tip'])) { $page_url.="tip=".$_GET['tip']."&"; };
           if (isset($_GET['kod'])) { $page_url.="kod=".$_GET['kod']."&"; };
          } else {
           $page_url.="?";
          
          };
                    
          $paginator="<div class=\"gr_s\"><div class=\"ot5_s\">Страницы:</div></div>\n";
          $paginator.="<div class=\"gr\"><div class=\"ot5\"><a class=\"pglink\" href=\"".$page_url."page=".$p_min."\" title=\"Перейти на первую страницу\"><</a></div></div>\n";
          if (($p_rrrr>=$p_min) && ($p_rrrr<$current)) $paginator.="<div class=\"gr\"><div class=\"ot5\"><a class=\"pglink\" href=\"".$page_url."page=".$p_rrrr."\">".$p_rrrr."</a></div></div>\n";
          if (($p_rrr>=$p_min) && ($p_rrr<$current)) $paginator.="<div class=\"gr\"><div class=\"ot5\"><a class=\"pglink\" href=\"".$page_url."page=".$p_rrr."\">".$p_rrr."</a></div></div>\n";
          if (($p_rr>=$p_min) && ($p_rr<$current)) $paginator.="<div class=\"gr\"><div class=\"ot5\"><a class=\"pglink\" href=\"".$page_url."page=".$p_rr."\">".$p_rr."</a></div></div>\n";
          if (($p_r>=$p_min) && ($p_r<$current)) $paginator.="<div class=\"gr\"><div class=\"ot5\"><a class=\"pglink\" href=\"".$page_url."page=".$p_r."\">".$p_r."</a></div></div>\n";
          $paginator.="<div class=\"gr_c\"><div class=\"ot5\">".$current."</div></div>";
          if (($p_n>$current) && ($p_n<=$p_max)) $paginator.="<div class=\"gr\"><div class=\"ot5\"><a class=\"pglink\" href=\"".$page_url."page=".$p_n."\">".$p_n."</a></div></div>\n";
          if (($p_nn>$current) && ($p_nn<=$p_max)) $paginator.="<div class=\"gr\"><div class=\"ot5\"><a class=\"pglink\" href=\"".$page_url."page=".$p_nn."\">".$p_nn."</a></div></div>\n";
          if (($p_nnn>$current) && ($p_nnn<=$p_max)) $paginator.="<div class=\"gr\"><div class=\"ot5\"><a class=\"pglink\" href=\"".$page_url."page=".$p_nnn."\">".$p_nnn."</a></div></div>\n";
          if (($p_nnnn>$current) && ($p_nnnn<=$p_max)) $paginator.="<div class=\"gr\"><div class=\"ot5\"><a class=\"pglink\" href=\"".$page_url."page=".$p_nnnn."\">".$p_nnnn."</a></div></div>\n";
          $paginator.="<div class=\"gr\"><div class=\"ot5\"><a class=\"pglink\" href=\"".$page_url."page=".$p_max."\" title=\"Перейти на последнюю страницу\">></a></div></div>\n";

          // =/Подготовка к пагинатору 2 ===========================
          // =====================================================
          
          
          
          // Выборка из базы данных
          $query="SELECT t.id, t.date_fixed, t.user_id, t.action_id, t.subject_id, t.descr, t.sec_ip, t.xtra1, t.xtra2,
                         t1.title AS act_title,
                         t2.email AS user_email,
                         t2.name AS user_name,
                         t2.nickname AS user_nickname,
                         t2.phone AS user_phone
                  FROM logs AS t, l_act_spr AS t1, tbl_users AS t2
                  WHERE t.action_id=t1.id AND
                        t.user_id=t2.id 
                        ".$add_zapr."
                  ORDER BY t.id DESC
                  LIMIT ".$n."
                  OFFSET ".(($current-1)*$n)." ";
          $res=$db->query($query);
          
          echo "<p>Найдено записей: ".$kolvo."</p>";
          
          echo "<div class=\"clear\"></div>";
          echo $paginator; 
          echo "<div class=\"clear\"></div>";
          
          echo "<noindex>";
          ?>
          
          <table border="0" align="left" cellspacing="3" cellpadding="4">
           <tr>
             <td align="center"><b>№+Дата</b></td>
             <td align="center"><b>User+IP</b></td>
             <td align="center"><b>Действие</b></td>
             <td align="center"><b>Субъект</b></td>
             <td align="center"><b>Текст описания</b></td>
           </tr>
          <?php
          
          $i=0;
          while ($ar=$res->fetch_array()) {
            //echo "<pre>";
            //print_r($ar);
            //echo "</pre>";
            $i=$i+1;
            $cl="";
            if ($i%2!=0) {
              $cl=" class=\"graybg\" ";
            };
                
            
            echo " ".
            "<tr>".
              "<td".$cl.">№".$ar['id'].", ".date("d.m.Y H:i",$ar['date_fixed'])."</td>".
              "<td".$cl."><a class=\"link\" href=\"./adm_statistics.php?user_id=".$ar['user_id']."\">".$ar['user_nickname']." (".$ar['user_name'].")</a>, ".$ar['user_email'].", ".$ar['user_phone'].", <a class=\"link\" href=\"./adm_statistics.php?ip=".$ar['sec_ip']."\">".$ar['sec_ip']."</a></td>".
              "<td".$cl."><a class=\"link\" href=\"./adm_statistics.php?kod=".$ar['action_id']."\">".$ar['act_title']."</a></td>";
              
            $tip=(int)(floor($ar['action_id']/100)*100);
            
            if ($tip==100)  { echo "<td".$cl.">".$ar['descr']." <a class=\"link\" href=\"./adm_statistics.php?tip=".$tip."\">Квартира</a> <a target=\"_blank\" href=\"./prodam_kvartiru.php?id=".$ar['subject_id']."\" class=\"link\" >№".$ar['subject_id']."</a></td>"; };
            if ($tip==200)  { echo "<td".$cl.">".$ar['descr']." <a class=\"link\" href=\"./adm_statistics.php?tip=".$tip."\">Комната</a>  <a target=\"_blank\" href=\"./prodam_komnatu.php?id=".$ar['subject_id']."\"  class=\"link\" >№".$ar['subject_id']."</a></td>"; };  
            if ($tip==300)  { echo "<td".$cl.">".$ar['descr']." <a class=\"link\" href=\"./adm_statistics.php?tip=".$tip."\">Дом</a>      <a target=\"_blank\" href=\"./prodam_dom.php?id=".$ar['subject_id']."\"      class=\"link\" >№".$ar['subject_id']."</a></td>"; };
            if ($tip==400)  { echo "<td".$cl.">".$ar['descr']." <a class=\"link\" href=\"./adm_statistics.php?tip=".$tip."\">Участок</a>  <a target=\"_blank\" href=\"./prodam_uchastok.php?id=".$ar['subject_id']."\" class=\"link\" >№".$ar['subject_id']."</a></td>"; };
              
            echo "<td".$cl.">";
            if ($ar['xtra1']!="") {
              echo "<b>Примечание</b><br>".$ar['xtra1']."<br>";
            };  
            echo "<b>Контакты</b><br>".$ar['xtra2']."</td>".
            "</tr>";
          };
           
          
          echo "</table>";
          echo "</noindex>";
          
          echo "<div class=\"clear\"></div>";
          echo $paginator; 
          echo "<div class=\"clear\"></div>";
          
        // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        } else {
          echo "<p>Права администратора не подтверждены: доступ заткрыт.</p>";
        
        };
      
      
      
      
      } else {
      // Если пользователь НЕ авторизован
        echo "<p>Войдите на сайт под своей учетной записью.</p>";
      
      
      
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
    <?php //require "./_parts/page_counters.php"; ?>
  </div>
  </div>
</td>
</tr>
<!-- /Подножие -->

</table>






<div class="clear"></div>









</body>
</html>