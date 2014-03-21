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





<table align="center" width="980" border="0" cellpadding="0"
	cellspacing="0">
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
				<div class="content_cover">
					<div class="content_inner">

						<div class="otstup">
							<!-- otstup -->

							<table cellspacing="0" cellpadding="0" border="0" width="680"
								style="margin-top: 10px;">

								<!-- Первая строка -->
								<tr>
									<td colspan=2><h2 style="margin-top: 0px;">Продажа квартир в
											Великом Новгороде</h2></td>
								</tr>
								<tr>

									<td width="160" align="left" valign="top"><img
										src="./pics/large_icon_kvartira.jpg" width="156" height="156"
										alt="Продажа квартир в Великом Новгороде"
										style="display: inline; float: left; margin-right: 10px; margin-bottom: 10px; border: 1px solid #acabab;">
										<div class="clear"></div> <a href="./kvartira_add.php"
										class="link"><img border="0" align="absmiddle"
											src="./pics/ico_ob_plus.png"
											title="Добавить объявление (продажа квартир)"></a> <a
										href="./kvartira_add.php" class="link">Продать квартиру</a><br>

									</td>

									<td align="left" valign="top">

											
        
          
          
        <?php
        
        $typeFlats = array(
            array(
                'title' => 'Однокомнатные',
                'room' => 1,
                'lastDays' => 14),
            array(
                'title' => 'Двухкомнатные',
                'room' => 2,
                'lastDays' => 7),
            array(
                'title' => 'Трёхкомнатные',
                'room' => 3,
                'lastDays' => 7)
        );
        
        foreach ($typeFlats as $item) {
            $rowsCount = 0;
            $query = "select * from sell_kva where status=0 and date_created>='" .
                     (time() - $item['lastDays'] * 24 * 60 * 360) .
                     "' AND kva_rooms={$item['room']} ORDER BY date_created DESC LIMIT 5";
        
            $res = $db->query($query);
            $rowsCount = mysqli_num_rows($res);
            if ($rowsCount >= 1) {
                echo "<a class=blink href=\"/kvartira.php?type={$item['room']}\">{$item['title']} квартиры</a><br>";
                while ($ar = $res->fetch_assoc()) {
                    echo "<a href=/prodam_kvartiru.php?id={$ar['id']}>" . get_kv_obyav_by_id($db, $ar['id']) . "</a><br>";
                }
                echo "<a href=\"/kvartira.php?type={$item['room']}\" class=\"link\">Все {$item['room']}-комн. квартиры</a><p></p>";
            }
        }
        
        
        

        
        // ============================================================ ПРОДАЖА
        // МК-КВ. ============================
        $dn_cre = 14;
        $dn_upd = 7;
        // Соотношение 2 созданных раньше + 3 апнутых.
        
        $query = "(SELECT * 
                    FROM sell_kva  
                    WHERE date_created>='" .
                 (time() - $dn_cre * 24 * 60 * 360) .
                 "'
                          AND kva_rooms>='4'
                          AND status='0'
                    ORDER BY date_created DESC
                    LIMIT 2)
                    
                    UNION
                    
                    (SELECT * 
                    FROM sell_kva  
                    WHERE date_upped>='" .
                 (time() - $dn_upd * 24 * 60 * 360) . "'
                          AND kva_rooms>='4'
                          AND status='0'
                    ORDER BY date_upped DESC
                    LIMIT 3)
                    ;
                    ";
        $res = $db->query($query);
        $kv_kolvo = $res->num_rows;
        
        if ($kv_kolvo > 0) {
            echo "<a class=\"blink\" href=\"./kvartira.php?type=4&price_ot=&price_do=&sort=0\" style=\"font-size:16px;\">Многокомнатные квартиры</a><br>";
            while ($ar = $res->fetch_assoc()) {
                echo "<a href=\"./prodam_kvartiru.php?id=" . (int) $ar['id'] . "\">".get_kv_obyav_by_id($db, $ar['id'])."</a><br>";
            }
            ; // while
            
            echo "<a href=\"./kvartira.php?type=4&price_ot=&price_do=&sort=0\" class=\"link\">Все многокомн. квартиры</a>&nbsp;&nbsp;&nbsp;&nbsp;";
            echo "<br>";
        }
        ;
        // ============================================================ /ПРОДАЖА
        // МК-КВ. ===========================
        
        ?>
        <br> <br>
									</td>

								</tr>
								<!-- / Первая строка -->






								<!-- Вторая строка -->
								<tr>
									<td colspan=2><h2 style="margin-top: 0px;">Продажа комнат в
											Великом Новгороде</h2></td>
								</tr>
								<tr>

									<td width="160" align="left" valign="top"><img
										src="./pics/large_icon_komnata.jpg" width="156" height="156"
										alt="Продажа комнат в Великом Новгороде"
										style="display: inline; float: left; margin-right: 10px; margin-bottom: 10px; border: 1px solid #acabab;">
										<div class="clear"></div> <a href="./komnata_add.php"
										class="link"><img border="0" align="absmiddle"
											src="./pics/ico_ob_plus.png"
											title="Добавить объявление (продажа комнаты)"></a> <a
										href="./komnata_add.php" class="link">Продать комнату</a><br>
										<br> <br></td>

									<td align="left" valign="top">
          <?php
        
        // ============================================================ ПРОДАЖА
        // КОМНАТ ============================
        $dn_kmn = 14;
        $query = "SELECT * 
                    FROM sell_kmn  
                    WHERE status='0' AND date_created>='" .
                 (time() - $dn_kmn * 24 * 60 * 360) . "'
                    ORDER BY date_created DESC
                    LIMIT 10
                    ;
                    ";
        $res = $db->query($query);
        $kv_kolvo = $res->num_rows;
        
        if ($kv_kolvo > 0) {
            while ($ar = $res->fetch_assoc()) {
                echo " <a href=\"./prodam_komnatu.php?id=" . (int) $ar['id'] .  "\">".get_kmn_obyav_by_id($db, $ar['id'])."</a><br>";
            }
            echo "<a href=\"./komnata_v_velikom_novgorode.php\" class=\"link\">Все комнаты</a>";
            echo "<br>";
        }
        // ============================================================ /ПРОДАЖА
        // КОМНАТ ===========================
        
        ?>  
        
    
      
          
  
          
          
 
          
          
          
        <br> <br>
									</td>

								</tr>
								<!-- / Вторая строка -->









								<!-- Третья строка -->
								<tr>
									<td colspan=2><h2 style="margin-top: 0px;">Продажа домов и коттеджей в Великом Новгороде и Новгородской области</h2></td>
								</tr>
								<tr>

									<td width="160" align="left" valign="top"><img
										src="./pics/large_icon_dom.jpg" width="156" height="156"
										alt="Продажа домов, коттеджей в Великом Новгороде"
										style="display: inline; float: left; margin-right: 10px; margin-bottom: 10px; border: 1px solid #acabab;">
										<div class="clear"></div> <a href="./dom_add.php" class="link"><img
											border="0" align="absmiddle" src="./pics/ico_ob_plus.png"
											title="Добавить объявление (продажа дома)"></a> <a
										href="./dom_add.php" class="link">Продать дом/коттедж</a><br>

									</td>

									<td align="left" valign="top">
										<h2 style="margin-top: 0px; margin-bottom: 5px;"></h2>
          
          
          
          
          <?php
        
        // ============================================================ ПРОДАЖА
        // ДОМОВ ============================
        $dn_dom = 60;
        $query = "SELECT * 
                    FROM sell_dom  
                    WHERE status='0' AND date_created>='" .
                 (time() - $dn_dom * 24 * 60 * 360) . "'
                    ORDER BY date_created DESC
                    LIMIT 10
                    ;
                    ";
        $res = $db->query($query);
        $kv_kolvo = $res->num_rows;
        
        if ($kv_kolvo > 0) {
            while ($ar = $res->fetch_assoc()) {
                echo "<a href=\"./prodam_dom.php?id=" . (int) $ar['id'] . "\">".get_dom_obyav_by_id($db, $ar['id']) ."</a><br>";
            }
            echo "<a href=\"./dom_v_velikom_novgorode.php\" class=\"link\">Все дома и коттеджи</a>&nbsp;&nbsp;&nbsp;&nbsp;";
            echo "<br>";
        }
        ;
        // ============================================================ /ПРОДАЖА
        // ДОМОВ ===========================
        
        ?>  
        
          
          
        <br> <br>
									</td>

								</tr>
								<!-- / Третья строка -->
								<!-- Четвертая строка -->
								<tr>
									<td colspan=2><h2 style="margin-top: 0px;">Продажа участков и дач в Великом Новгороде и Новгородской области</h2></td>
								</tr>
								<tr>

									<td width="160" align="left" valign="top"><img
										src="./pics/large_icon_uchastok.jpg" width="156" height="156"
										alt="Продажа участков и дач в Великом Новгороде"
										style="display: inline; float: left; margin-right: 10px; margin-bottom: 10px; border: 1px solid #acabab;">
										<div class="clear"></div> <a href="./uchastok_add.php"
										class="link"><img border="0" align="absmiddle"
											src="./pics/ico_ob_plus.png"
											title="Добавить объявление (продажа участка, дачи)"></a> <a
										href="./uchastok_add.php" class="link">Продать участок/дачу</a><br>

									</td>

									<td align="left" valign="top">
          <?php
        
        // ============================================================ ПРОДАЖА
        // УЧАСТКОВ ============================
        $dn_uch = 30;
        $query = "SELECT * 
                    FROM sell_uch  
                    WHERE status='0' AND date_created>='" .
                 (time() - $dn_uch * 24 * 60 * 360) . "'
                    ORDER BY date_created DESC
                    LIMIT 10
                    ;
                    ";
        $res = $db->query($query);
        $kv_kolvo = $res->num_rows;
        
        if ($kv_kolvo > 0) {
            while ($ar = $res->fetch_assoc()) {
                echo " <a href=\"./prodam_uchastok.php?id=" . (int) $ar['id'] . "\">".get_uch_obyav_by_id($db, $ar['id']) ."</a><br>";
            }
            echo "<a href=\"./uchastok_v_velikom_novgorode.php\" class=\"link\">Все участки и дачи</a>&nbsp;&nbsp;&nbsp;&nbsp;";
            echo "<br>";
        }
        ;
        // ============================================================ /ПРОДАЖА
        // УЧАСТКОВ ===========================
        
        ?>  
        
          
          
        <br> <br>
									</td>

								</tr>
								<!-- / Четвертая строка -->









							</table>










							<div class="clear"></div>





							<h2 style="margin-top: 40px;">Полезные материалы</h2>

							<div class="clear"></div>

							<table celpadding="0" cellspacing="0" border="0" width="670">



								<tr>
									<td valign="top"><a href="./m04.php"><img
											src="./pics/pic_100x75_programma_zhilische.jpg" width="100"
											height="75" class="st_img_h"
											alt="Долгосрочная целевая программа Обеспечение жильем молодых семей в Великом Новгороде"></a>
									</td>
									<td valign="top">

										<div class="clear"></div> <a class="link"
										style="font-weight: bold;" href="./m04.php">ПРОСТО о СЛОЖНОМ:
											Долгосрочная целевая программа «Обеспечение жильем молодых
											семей в Великом Новгороде»</a>
										<div class="clear" style="margin-top: 5px;"></div> Наверняка
										многие из вас уже слышали о том, что в нашем славном Великом
										Новгороде действует муниципальная программа помощи в покупке
										жилья для молодых семей. Официально она называется так:
										долгосрочная целевая программа "Обеспечение жильем молодых
										семей в Великом Новгороде" на 2011 - 2015 годы...

									</td>
								</tr>




								<tr>
									<td valign="top">&nbsp;</td>
									<td valign="top">&nbsp;</td>
								</tr>



								<tr>
									<td valign="top"><a href="./m03.php"><img
											src="./pics/m/sm_pic_03_bez_posrednikov.jpg" width="100"
											height="75" class="st_img_h"
											alt="Как купить-продать квартиру без помощи агентства"></a></td>
									<td valign="top">

										<div class="clear"></div> <a class="link"
										style="font-weight: bold;" href="./m03.php">Как купить-продать
											квартиру без помощи агентства</a>
										<div class="clear" style="margin-top: 5px;"></div> Итак, это
										свершилось. Из «однушки» мы переехали в «трешку», убитенькую,
										далеко не новую квартирку , требующую солидных вложений. Но
										зато свою! Трехкомнатную! Весь процесс от принятия решения до
										собственно переезда занял чуть более полугода. Отсутствие
										посредников сэкономило нам до полуста тысяч рублей. Это как
										минимум...

									</td>
								</tr>

								<tr>
									<td valign="top">&nbsp;</td>
									<td valign="top">&nbsp;</td>
								</tr>

								<tr>
									<td valign="top"><a href="./m02.php"><img
											src="./pics/m/sm_pic_02_subsidii_na_zhilye.jpg" width="100"
											height="75" class="st_img_h"
											alt="Субсидии на жилье для молодых семей в Великом Новгороде"
											border="0"></a></td>
									<td valign="top">

										<div class="clear"></div> <a class="link"
										style="font-weight: bold;" href="./m02.php">Безвозмездные
											субсидии на жильё получат 412 молодых семей</a>
										<div class="clear" style="margin-top: 5px;"></div>
										Постановлением Администрации Великого Новгорода утверждена
										долгосрочная целевая программа «Обеспечение жильем молодых
										семей в Великом Новгороде» на 2011–2015 годы. Предполагается
										предоставление молодым семьям, признанным нуждающимися в
										улучшении жилищных условий, социальных выплат на приобретение
										или строительство жилья...

									</td>
								</tr>

								<tr>
									<td valign="top">&nbsp;</td>
									<td valign="top">&nbsp;</td>
								</tr>

								<tr>
									<td valign="top"><a href="./m01.php"><img
											src="./pics/m/sm_pic_01_zemlya_molodym_semyam.jpg"
											width="100" height="75" class="st_img_h"
											alt="Бесплатные участки под жилищную застройку молодым и многодетным семьям в Великом Новгороде"
											border="0"></a></td>
									<td valign="top">

										<div class="clear"></div> <a class="link"
										style="font-weight: bold;" href="./m01.php">В Новгородской
											области готовы выдавать бесплатные участки под жилищную
											застройку</a>
										<div class="clear" style="margin-top: 5px;"></div> В марте
										2011 года в Новгородской области, одном из первых регионов в
										стране, приняли закон о предоставлении молодым и многодетным
										семьям бесплатных земельных участков. К сегодняшнему дню в
										нашем регионе разработан порядок их предоставления, то есть
										прописаны правила и рекомендации для этих категорий граждан,
										желающих построить свой дом...

									</td>
								</tr>
							</table>















							<div class="clear"></div>

							<h2 style="margin-top: 40px;">Интересности</h2>


							<div class="clear"></div>

							<table celpadding="0" cellspacing="0" border="0" width="670">
								<tr>
									<td valign="top"><a href="./h01.php"><img
											src="./pics/sm_pic_h_01_kak_nayti_soseda.jpg" width="100"
											height="75" class="st_img_h"
											alt="Самый необычный способ найти соседа для совместной аренды жилья в Москве"></a>
									</td>
									<td valign="top">

										<div class="clear"></div> <a class="link"
										style="font-weight: bold;" href="./h01.php">Самый необычный
											способ найти соседа для совместной аренды жилья в Москве</a>
										<div class="clear" style="margin-top: 5px;"></div> Буквально
										на днях Александр, пользователь социальной сети ВКонтакте,
										вероятно, отчаявшись найти себе соседа для совместной аренды
										квартиры в Москве, взял и специфическим способом
										отредактировал текст своего объявления. Объявление мгновенно
										получило эффект вирусного распространения... <br> <br> <br> <br>

									</td>
								</tr>
							</table>

							<div class="clear"></div>












						</div>
						<!-- otstup -->

					</div>























				</div>
				<!-- content box -->
		
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