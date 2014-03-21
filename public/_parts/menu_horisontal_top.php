<!-- Меню (верхнее) -->
  
  <div class="shapka_box" style="margin-top:0px;">
  <div class="shapka_cover" style="border-top:0px;">
    <div class="shapka_inner"style="  width:963px;">
    
    <table align="left" border="0" cellpadding="0" cellspacing="0">
    <tr>   
    
    <td class="hormenu"><div class="margmen"><a class="linkh" href="./index.php"   >Главная</a></div></td>
    <td class="hormenu"><div class="margmen"><a class="linkh" href="./useful.php"  >Материалы</a></div></td>
    <td class="hormenu"><div class="margmen"><a class="linkh" href="./agencies.php">Агентства</a></div></td>
    <td class="hormenu"><div class="margmen"><a class="linkh" href="./vacancies.php">Вакансии</a> <sup><b style="color:red;">NEW</b></sup></div></td>
    <td class="hormenu"><div class="margmen"><a class="linkh" href="./uslugi.php" >Услуги</a></div></td>
    <td class="hormenu"><div class="margmen"><a class="linkh" href="./informers.php" >Информеры</a></div></td>
    <td class="hormenu"><div class="margmen"><a class="linkh" href="./catalog.php">Каталог компаний</a></div></td>
    
    
    </tr>
    </table>
    
    <?php
      if ($glogged=='1') {
    ?>
      <table align="right" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td class="hormenu1"><div class="margmen1"><a class="linkh" href="./my_list.php">Мои объявления</a> (<?php echo 
        my_counter_tbl('sell_kmn', $db, $_SESSION['id']) +
        my_counter_tbl('sell_kva', $db, $_SESSION['id']) +
        my_counter_tbl('sell_dom', $db, $_SESSION['id']) +
        my_counter_tbl('sell_uch', $db, $_SESSION['id']) +
        my_counter_tbl('rent_kmn', $db, $_SESSION['id']) +
        my_counter_tbl('rent_kva', $db, $_SESSION['id']) +
        my_counter_tbl('sell_gar', $db, $_SESSION['id'])
        ; ?>)</div></td>
      </tr>
      </table>
    
    <?php
      };
    
    ?>
    
    
       
    </div>
  </div>
  
  </div>
  
  <!-- /Меню (верхнее) -->