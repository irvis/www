<?php
require_once '../app/config.php';

// Подключаем авторизацию
require "./_parts/_auth.php";
// если пользователь авторизован, тогда наша переменная $glogged имеет значение
// '1';

// Запоминаем имя файла (для подсветки пунктов меню).
$fname = basename(__FILE__);

include APP_PATH . '/view/header.html';
?>





<table align="center" width="985" border="0" cellpadding="0"
	cellspacing="0">
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
			<!-- ========================================================================================= -->

			<div class="content_box">

				<div class="content_header">
					<div class="content_inner">
						<b>Продажа квартир в Великом Новгороде и Новгородской области</b>
					</div>
				</div>

				<div class="clear"></div>
  
   <?php

$page_url = "./kvartira.php";

// =====================================================
// Обработка принятых из GET параметров

// Значения по умолчанию = 0
$g_type = 0;
$g_price_ot = 0;
$g_price_do = 0;
$g_sort = 0;
$getStreet = '';
$street = 0;
if (count($_GET) > 0) { // Если в массиве GET что-то есть, тогда
                        // Тип квартир
    if ((isset($_GET['type'])) && ((int) $_GET['type'] > 0)) {
        $g_type = (int) $_GET['type'];
    }
    
    // Цена ОТ
    if ((isset($_GET['price_ot'])) && ((int) $_GET['price_ot'] > 0)) {
        $g_price_ot = (int) $_GET['price_ot'];
    }
    
    // Цена ДО
    if ((isset($_GET['price_do'])) && ((int) $_GET['price_do'] > 0)) {
        $g_price_do = (int) $_GET['price_do'];
    }
    
    // Инверсия ОТ и ДО если ЗАДАНЫ_ОБА, но перепутаны местами
    if (($g_price_ot != 0) && ($g_price_do != 0) && ($g_price_ot > $g_price_do)) {
        $g_tmp = $g_price_do;
        $g_price_do = $g_price_ot;
        $g_price_ot = $g_tmp;
    }
    
    
    // Сортировка
    if ((isset($_GET['sort'])) && ((int) $_GET['sort'] > 0)) {
        $g_sort = (int) $_GET['sort'];
    }
    
    // Улица
    if ((isset($_GET['street'])) && ((int) $_GET['street'] > 0)) {
        $street = (int) $_GET['street'];
        $getStreet = "&street=".$street;
    }
}


// =====================================================
// Формирование адреса страницы page.php?type=0&price_ot=12&price_do=12&sort=1
$page_url .= "?type=" . $g_type . "&price_ot=" . $g_price_ot . "&price_do=" .
         $g_price_do . "&sort=" . $g_sort . $getStreet;

// =====================================================
// Формирование запроса (для фильтра и т.д.)
$zapr = "FROM sell_kva WHERE status='0'";

// Тип квартиры (кол-во комнат)
if (($g_type >= 1) && ($g_type <= 3)) {
    $zapr .= "AND kva_rooms='" . $g_type . "' ";
}
;
if ($g_type == 4) {
    $zapr .= "AND kva_rooms>'3' ";
}


// Цена
if ($g_price_ot != 0) { // если задана цена ОТ
    $zapr .= "AND price>='" . $g_price_ot . "' ";
}

if ($g_price_do != 0) { // если задана цена ДО
    $zapr .= "AND price<='" . $g_price_do . "' ";
}

/*
 * Street
 */
if ($street >= 1) {
    $zapr .= "AND geo_street_id=$street ";
}

// Сортировка
$sort = "date_upped DESC"; // по умолчанию по дате
if ($g_sort != 0) { // если задана цена ОТ
    if ($g_sort == 1) {
        $sort = "date_upped ASC";
    }
    ; // старые сверху
    if ($g_sort == 2) {
        $sort = "price ASC";
    }
    ; // дешевые сверху
    if ($g_sort == 3) {
        $sort = "price DESC";
    }
    ; // дорогие сверху
}
;

// =====================================================
// =Подготовка к пагинатору ============================

// вычисляем общее количество квартир
$query = "SELECT COUNT(*) " . $zapr;
$res = $db->query($query);
$tmp = $res->fetch_array();
$kolvo = $tmp[0];

// задаем количество объявлений на страницу (ВНИМАНИЕ! Далее она используется в
// запросе SQL!!!!)
$n = 20;

// задаем минимальный номер страницы (это всегда 1 в нашем случае)
$p_min = 1;

// вычисляем максимальный номер страницы
$p_max = floor($kolvo / $n);
if ($kolvo % $n != 0) {
    $p_max = $p_max + 1;
}
;

// считываем из GET номер текущей страницы
$current = 1; // по умолчанию = 1, если через GET ничего не пришло или пришла
              // ересь.

if (isset($_GET['page'])) {
    if (($_GET['page'] >= $p_min) && ($_GET['page'] <= $p_max)) {
        $current = (int) $_GET['page'];
    } else {
        if ($_GET['page'] > $p_max)
            $current = $p_max;
    }
    ;
}
;

// вычисляем номера страниц для пагинатора
$p_r = $current - 1;
$p_rr = $current - 2;
$p_rrr = $current - 3;
$p_rrrr = $current - 4;

$p_n = $current + 1;
$p_nn = $current + 2;
$p_nnn = $current + 3;
$p_nnnn = $current + 4;

// =/Подготовка к пагинатору ===========================
// =====================================================

$query = "SELECT * 
          " . $zapr . " 
          ORDER BY special_id DESC, " . $sort . "
          LIMIT " . $n . "
          OFFSET " . (($current - 1) * $n) . " ";

$i = 0;
$res = $db->query($query);

// Вычисление значения ОТ
$kv_ot = ($current - 1) * $n + 1;
// Вычисление значения ДО
$kv_do = $current * $n;
if ($kv_do > $kolvo) {
    $kv_do = $kolvo;
}
;

?>       
 
 
 
 <div class="content_cover">
					<div class="content_inner">






						<h2>Продажа квартир в Великом Новгороде</h2>
       <?php require "./_parts/adsense_tabl_verx.php";      ?>
	   <div class="clear"></div>





						<form action="./kvartira.php" method="get">
							<table align="left" cellpadding="0" cellspacing="5" border="0">
								<tr>
									<td width="70">Квартиры *</td>
									<td width="128">Цена <b>ОТ</b>, в тыс. руб.
									</td>
									<td width="128">Цена <b>ДО</b>, в тыс. руб.
									</td>
									<td width="215">Порядок *</td>
								</tr>
								<tr>
									<td><select class="pole_sort" name="type">
											<option value="0"
												<?php if ($g_type=="0") { echo "selected"; }; ?>>Все</option>
											<option value="1"
												<?php if ($g_type=="1") { echo "selected"; }; ?>>1к.кв.</option>
											<option value="2"
												<?php if ($g_type=="2") { echo "selected"; }; ?>>2к.кв.</option>
											<option value="3"
												<?php if ($g_type=="3") { echo "selected"; }; ?>>3к.кв.</option>
											<option value="4"
												<?php if ($g_type=="4") { echo "selected"; }; ?>>мн.кв.</option>
									</select></td>

									<td><input type="text" name="price_ot" style="width: 120px;"
										<?php if ($g_price_ot>0) { echo "value=\"".$g_price_ot."\""; }; ?>></td>
									<td><input type="text" name="price_do" style="width: 120px;"
										<?php if ($g_price_do>0) { echo "value=\"".$g_price_do."\""; }; ?>></td>
									<td><select class="pole_sort" name="sort">
											<option value="0"
												<?php if ($g_sort=="0") { echo "selected"; }; ?>>По дате:
												актуальные сверху</option>
											<option value="1"
												<?php if ($g_sort=="1") { echo "selected"; }; ?>>По дате:
												старые сверху</option>
											<option value="2"
												<?php if ($g_sort=="2") { echo "selected"; }; ?>>По цене:
												дешевые сверху</option>
											<option value="3"
												<?php if ($g_sort=="3") { echo "selected"; }; ?>>По цене:
												дорогие сверху</option>
									</select></td>


								</tr>
								<tr>
									<td>Улица:</td>
									<td><select name=street><option value=0>Отображать все</option><?php
        
        $res1 = $db->query('select id, title from spr_geo_street');
        $rows = array();
        while ($row = $res1->fetch_assoc()) {
            $rows[] = $row;
        }
        foreach ($rows as $row) {
            echo "<option value={$row['id']}>{$row['title']}</option>";
        }
        
        ?></select></td>
								</tr>
								<tr>
									<td colspan=4><input type="submit" value="Искать"></td>
								</tr>
							</table>
						</form>



						<div class="clear"></div>
						<div class="clear" style="margin-top: 30px;"></div>

						<img src="./pics/ico_filter.gif" width="18" height="18"
							align="absmiddle" border="0">
       Показаны квартиры с <?php echo $kv_ot; ?> по <?php echo $kv_do; ?>, всего по запросу найдено <?php echo $kolvo; ?> квартир
       
       <div class="clear" style="margin-top: 10px;"></div>
       
       
       
       
       
<?php
$paginator = "<div class=\"gr_s\"><div class=\"ot5_s\">Страницы:</div></div>\n";
$paginator .= "<div class=\"gr\"><div class=\"ot5\"><a class=\"pglink\" href=\"" .
         $page_url . "&page=" . $p_min .
         "\" title=\"Перейти на первую страницу\"><</a></div></div>\n";
if (($p_rrrr >= $p_min) && ($p_rrrr < $current))
    $paginator .= "<div class=\"gr\"><div class=\"ot5\"><a class=\"pglink\" href=\"" .
             $page_url . "&page=" . $p_rrrr . "\">" . $p_rrrr .
             "</a></div></div>\n";
if (($p_rrr >= $p_min) && ($p_rrr < $current))
    $paginator .= "<div class=\"gr\"><div class=\"ot5\"><a class=\"pglink\" href=\"" .
             $page_url . "&page=" . $p_rrr . "\">" . $p_rrr .
             "</a></div></div>\n";
if (($p_rr >= $p_min) && ($p_rr < $current))
    $paginator .= "<div class=\"gr\"><div class=\"ot5\"><a class=\"pglink\" href=\"" .
             $page_url . "&page=" . $p_rr . "\">" . $p_rr . "</a></div></div>\n";
if (($p_r >= $p_min) && ($p_r < $current))
    $paginator .= "<div class=\"gr\"><div class=\"ot5\"><a class=\"pglink\" href=\"" .
             $page_url . "&page=" . $p_r . "\">" . $p_r . "</a></div></div>\n";
$paginator .= "<div class=\"gr_c\"><div class=\"ot5\">" . $current .
         "</div></div>";
if (($p_n > $current) && ($p_n <= $p_max))
    $paginator .= "<div class=\"gr\"><div class=\"ot5\"><a class=\"pglink\" href=\"" .
             $page_url . "&page=" . $p_n . "\">" . $p_n . "</a></div></div>\n";
if (($p_nn > $current) && ($p_nn <= $p_max))
    $paginator .= "<div class=\"gr\"><div class=\"ot5\"><a class=\"pglink\" href=\"" .
             $page_url . "&page=" . $p_nn . "\">" . $p_nn . "</a></div></div>\n";
if (($p_nnn > $current) && ($p_nnn <= $p_max))
    $paginator .= "<div class=\"gr\"><div class=\"ot5\"><a class=\"pglink\" href=\"" .
             $page_url . "&page=" . $p_nnn . "\">" . $p_nnn .
             "</a></div></div>\n";
if (($p_nnnn > $current) && ($p_nnnn <= $p_max))
    $paginator .= "<div class=\"gr\"><div class=\"ot5\"><a class=\"pglink\" href=\"" .
             $page_url . "&page=" . $p_nnnn . "\">" . $p_nnnn .
             "</a></div></div>\n";
$paginator .= "<div class=\"gr\"><div class=\"ot5\"><a class=\"pglink\" href=\"" .
         $page_url . "&page=" . $p_max .
         "\" title=\"Перейти на последнюю страницу\">></a></div></div>\n";
// собственно вывод пагинатора
echo $paginator;
?>


<div class="r_date">
							<a href="./kvartira_add.php" class="link"><img width="16"
								height="16" align="absmiddle" src="./pics/ico_add.png"
								border="0"></a> <a href="./kvartira_add.php" class="link">Добавить
								объявление</a>
						</div>










						<!-- ТАБЛИЦА -->
						<table width="690" cellpadding="5" class="st" cellspacing="0">
							<tr class="tr_buy">
								<td align="center" width="75"><b>Дата</b></td>
								<td align="center" width="80"><b>Квартира</b></td>
								<td align="center"><b>Адрес</b></td>
								<td align="center"><b><span title="Материал">М</span></b></td>
								<td align="center"><b><span title="Общая площадь">O</span></b></td>
								<td align="center"><b><span title="Жилая площадь">Ж</span></b></td>
								<td align="center"><b><span title="Площадь кухни">К</span></b></td>
								<td align="center"><b><span title="Этаж">Э</span></b></td>
								<td align="center"><b><span title="Балкон / лоджия">Б</span></b></td>
								<td align="center" width="90"><b>Цена</b></td>
								<td align="center" width="90"></td>
							</tr>
       
      <?php
    while (($ar = $res->fetch_assoc()) == true) {
        $i = $i + 1;
        if ($i % 2 == 0) {
            $class_tr = " class=\"even_buy\" ";
        } else {
            $class_tr = "";
        }
        ;
        
        // ======================================================================
        // Собираем адрес квартиры
        
        // Адрес: собираем адрес объекта + адрес для URL
        $sobr_adres = "";
        // Если город вообще указан (либо выбран из списка, либо непустой свой
        // вариант)
        if (($ar['geo_gorod_id'] > 0) ||
                 (($ar['geo_gorod_id'] == - 1) && (strlen($ar['geo_gorod']) != 0))) {
            
            // Если город выбран из списка
            if ($ar['geo_gorod_id'] > 0) {
                $sobr_adres .= gettitle($db, 'spr_geo_gorod', 
                        $ar['geo_gorod_id']);
            }
            ;
            
            // Если город введен вручную
            if ($ar['geo_gorod_id'] == - 1) {
                $sobr_adres .= $ar['geo_gorod'];
            }
            ;
            
            // Если улица вообще указана (либо выбрана из списка, либо непустой
            // свой вариант)
            if (($ar['geo_street_id'] > 0) || (($ar['geo_street_id'] == - 1) &&
                     (strlen($ar['geo_street']) != 0))) {
                
                // Если улица выбрана из списка
                if ($ar['geo_street_id'] > 0) {
                    $sobr_adres .= ", " .
                     gettitle_d($db, 'spr_geo_street', $ar['geo_street_id']);
        }
        
        
        // Если улица введена вручную
        if ($ar['geo_street_id'] == - 1) {
            $sobr_adres .= ", " . $ar['geo_street'];
        }
        
        
        // + номер дома
        if (strlen($ar['geo_n_doma']) != 0) {
            $sobr_adres .= ", д. " . $ar['geo_n_doma'];
            // + корпус
            if (strlen($ar['geo_n_korp']) != 0) {
                $sobr_adres .= ", корп. " . $ar['geo_n_korp'];
            }
            ;
        }
        ;
        // (конец) если улица вообще указана
    }
    ;
}
;
// ======================================================================
?>
      
      <tr <?php echo $class_tr; ?>>
								<td align="center" valign="top">
           <?php

if ($ar['special_id'] != '88') {
    echo date("d.m.Y", $ar['date_upped']);
} else {
    echo "<b style=\"color:green;\">закреплено</b>";
}

if (isset($_SESSION['id']) && $ar['usr_id'] == $_SESSION['id']) {
    ?>
             <br> <nobr>
										<a href="./kvartira_edit.php?id=<?php echo $ar['id']; ?>"
											class="link"><img width="16" height="16" align="absmiddle"
											src="./pics/ico_edit.png" title="Редактировать объявление"
											border="0"></a> <a
											href="./kvartira_delete.php?id=<?php echo $ar['id']; ?>"
											class="link" onclick="return confirmDelete();"><img
											width="16" height="16" align="absmiddle"
											src="./pics/ico_delete.png" title="Удалить объявление"
											border="0"></a> <a
											href="./kvartira_up.php?id=<?php echo $ar['id']; ?>"
											class="link"><img width="16" height="16" align="absmiddle"
											src="./pics/ico_up.png" title="Поднять объявление" border="0"></a>
										<a href="./uslugi.php#paid" class="link"><img width="16"
											height="16" align="absmiddle" src="./pics/ico_promote.png"
											title="Продвинуть объявление" border="0"></a>
									</nobr>
           <?php } ?>
         </td>
								<td align="center" valign="top"><?php echo $ar['kva_rooms']; ?>-комн. кв.</td>
								<td align="center" valign="top"><?php echo $sobr_adres; ?></td>
								<td align="center" valign="top"><span
									title="<?php echo gettitle($db, 'spr_zd_material', $ar['zd_material_id']);?>"><?php echo gettitle_d($db, 'spr_zd_material', $ar['zd_material_id']);?></span></td>
								<td align="center" valign="top"><?php echo $ar['kva_pl_ob']; ?></td>
								<td align="center" valign="top"><?php echo $ar['kva_pl_zh']; ?></td>
								<td align="center" valign="top"><?php echo $ar['kva_pl_kuh']; ?></td>
								<td align="center" valign="top"><?php echo $ar['kva_floor']; ?>/<?php echo $ar['zd_floors']; ?></td>
								<td align="center" valign="top"><?php if ($ar['kva_balkon']=='1') { ?><img
									width="16" height="16" align="absmiddle" title="Балкон/лоджия"
									src="./pics/ico_tick_green.png" border="0"><?php } else { echo "-"; }; ?></td>
								<td align="center" valign="top"><?php echo $ar['price']; ?> тыс. руб.<?php if (($ar['price_torg']=='4') || ($ar['price_torg']=='5')) { echo ", ".gettitle_d($db, 'spr_price_torg', $ar['price_torg']); }; ?></td>
								<td align="left" valign="top"><nobr>
										<a href="./prodam_kvartiru.php?id=<?php echo $ar['id']; ?>"
											class="link"><img width="16" height="16" align="absmiddle"
											src="./pics/ico_arrow.png" border="0"></a> <a
											href="./prodam_kvartiru.php?id=<?php echo $ar['id']; ?>"
											class="link">Подробнее</a>
									</nobr></td>
							</tr>
       
       
      
      
      
      
      <?php
}

?> 
       
      
       
       
       </table>
						<!-- / ТАБЛИЦА -->


						<div class="clear" style="margin-top: 30px;"></div>

<?php
// собственно вывод пагинатора
echo $paginator;
?>
      
       <?php require "./_parts/adsense_tabl_niz.php";      ?>
    </div>
				</div>





			</div> <!-- /content_box --> <!-- ========================================================================================= -->

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
			<div class="shapka_box" style="margin-top: 0px;">
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