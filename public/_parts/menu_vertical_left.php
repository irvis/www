<!-- +++++++++ Дерево вертикального меню ++++++++++ -->
<div class="menu_box" style="margin-top: 10px;">
	<div class="menu_cover">
		<div class="menu_inner">

			<!-- ПРОДАЖА недвижимости -->
			<div style="margin: 4px;">
				<!-- marginer -->

				<img src="./pics/ico_realty_for_resident.gif" width="18" height="18"
					align="absmiddle"> <b>ПРОДАЖА жилой недвижимости</b><br> <img
					src="./pics/T.png" width="19" height="16" align="absmiddle"> 
       <?php if ($fname=="komnata_v_velikom_novgorode.php") { echo "<span style=\"background-color:#e5ffca;\">"; };?>
       <a class="link" href="./komnata_v_velikom_novgorode.php">Комнаты
					и КГТ</a> (<?php echo counter_tbl('sell_kmn',$db); ?>)
       <?php if ($fname=="komnata_v_velikom_novgorode.php") { echo "</span>"; };?><br>


				<img src="./pics/T.png" width="19" height="16" align="absmiddle"> 
       <?php if ($fname=="kvartira.php") { echo "<span style=\"background-color:#e5ffca;\">"; };?>
       <a class="link" href="./kvartira.php">Квартиры</a> (<?php echo counter_tbl('sell_kva',$db); ?>)
       <?php if ($fname=="kvartira.php") { echo "</span>"; };?><br> <img
					src="./pics/I.png" width="19" height="16" align="absmiddle"> <img
					src="./pics/T.png" width="19" height="16" align="absmiddle"> <a
					class="link"
					href="./kvartira.php?type=1&price_ot=&price_do=&sort=0">1-комн.
					квартиры</a> (<?php echo counter_tbl_usl('sell_kva',$db, 'kva_rooms=\'1\''); ?>)
       <br> <img src="./pics/I.png" width="19" height="16"
					align="absmiddle"> <img src="./pics/T.png" width="19" height="16"
					align="absmiddle"> <a class="link"
					href="./kvartira.php?type=2&price_ot=&price_do=&sort=0">2-комн.
					квартиры</a> (<?php echo counter_tbl_usl('sell_kva',$db, 'kva_rooms=\'2\''); ?>)
       <br> <img src="./pics/I.png" width="19" height="16"
					align="absmiddle"> <img src="./pics/T.png" width="19" height="16"
					align="absmiddle"> <a class="link"
					href="./kvartira.php?type=3&price_ot=&price_do=&sort=0">3-комн.
					квартиры</a> (<?php echo counter_tbl_usl('sell_kva',$db, 'kva_rooms=\'3\''); ?>)
       <br> <img src="./pics/I.png" width="19" height="16"
					align="absmiddle"> <img src="./pics/L.png" width="19" height="16"
					align="absmiddle"> <a class="link"
					href="./kvartira.php?type=4&price_ot=&price_do=&sort=0">Многокомн.
					квартиры</a> (<?php echo counter_tbl_usl('sell_kva',$db, 'kva_rooms>=\'4\''); ?>)
       <br> <img src="./pics/T.png" width="19" height="16"
					align="absmiddle"> 
       <?php if ($fname=="dom_v_velikom_novgorode.php") { echo "<span style=\"background-color:#e5ffca;\">"; };?>
       <a class="link" href="./dom_v_velikom_novgorode.php">Коттеджи,
					дома</a> (<?php echo counter_tbl('sell_dom',$db); ?>)
       <?php if ($fname=="dom_v_velikom_novgorode.php") { echo "</span>"; };?><br>

				<img src="./pics/L.png" width="19" height="16" align="absmiddle"> 
       <?php if ($fname=="uchastok_v_velikom_novgorode.php") { echo "<span style=\"background-color:#e5ffca;\">"; };?>
       <a class="link" href="./uchastok_v_velikom_novgorode.php">Участки,
					дачи</a> (<?php echo counter_tbl('sell_uch',$db); ?>)
       <?php if ($fname=="uchastok_v_velikom_novgorode.php") { echo "</span>"; };?><br>

				<!--<img src="./pics/L.png" width="19" height="16" align="absmiddle"> Гаражи (0)<br>-->

				<div class="clear1"></div>

		<img src="./pics/ico_realty_for_resident.gif" width="18" height="18"
					align="absmiddle"> <b>ПРОДАЖА коммерческой недвижимости</b><br>
		<?php
		
		$commerce = array (
				'Офис',
				'Торговля и сервис',
				'Производство и склады',
				'Здания и особняки',
				'Кафе, бары и рестораны',
				'Другое' 
		);
		$type = 0;
		foreach ($commerce as $item) {
			$corn = 'T';			
			if (count($commerce) - 1 == $type) { $corn = 'L'; }
			$type++;
			$img = "<img src=\"./pics/$corn.png\" width=\"19\" height=\"16\" align=\"absmiddle\">";
			$marker = "<span style=\"background-color:#e5ffca;\">";
			$markerEnd = "</span>";
			$link = "<a class=\"link\" href=\"./commerce.php?type=$type\">$item</a>";
			echo $img . $link . '<br>';
		}

		?>
<div class="clear1"></div>

				<img src="./pics/ico_realty_for_resident.gif" width="18" height="18"
					align="absmiddle"> <b>ПРОДАЖА: прочее</b><br> <img
					src="./pics/L.png" width="19" height="16" align="absmiddle"> 
       <?php if ($fname=="garazh_v_velikom_novgorode.php") { echo "<span style=\"background-color:#e5ffca;\">"; };?>
       <a class="link" href="./garazh_v_velikom_novgorode.php">Гаражи</a> (<?php echo counter_tbl('sell_gar',$db); ?>)
       <?php if ($fname=="garazh_v_velikom_novgorode.php") { echo "</span>"; };?><br>



				<div class="clear1"></div>





				<img src="./pics/ico_realty_for_resident.gif" width="18" height="18"
					align="absmiddle"> <b>АРЕНДА жилой недвижимости</b><br> <img
					src="./pics/T.png" width="19" height="16" align="absmiddle"> 
       <?php if ($fname=="arenda_komnat_v_velikom_novgorode.php") { echo "<span style=\"background-color:#e5ffca;\">"; };?>
       <a class="link" href="./arenda_komnat_v_velikom_novgorode.php">Комнаты
					и КГТ</a> (<?php echo counter_tbl('rent_kmn',$db); ?>)
       <?php if ($fname=="arenda_komnat_v_velikom_novgorode.php") { echo "</span>"; };?><br>

				<img src="./pics/L.png" width="19" height="16" align="absmiddle"> 
       <?php if ($fname=="arenda_kvartir_v_velikom_novgorode.php") { echo "<span style=\"background-color:#e5ffca;\">"; };?>
       <a class="link" href="./arenda_kvartir_v_velikom_novgorode.php">Все
					квартиры</a> (<?php echo counter_tbl('rent_kva',$db); ?>)
       <?php if ($fname=="arenda_kvartir_v_velikom_novgorode.php") { echo "</span>"; };?><br>

				<img style="margin-left: 22px;" src="./pics/T.png" width="19"
					height="16" align="absmiddle"> 
       <?php if ($fname=="arenda_1-komn_kvartir_v_velikom_novgorode.php") { echo "<span style=\"background-color:#e5ffca;\">"; };?>
       <a class="link"
					href="./arenda_1-komn_kvartir_v_velikom_novgorode.php">1-комн.
					квартиры</a> (<?php echo counter_tbl_usl('rent_kva',$db, 'kva_rooms=\'1\''); ?>)
       <?php if ($fname=="arenda_1-komn_kvartir_v_velikom_novgorode.php") { echo "</span>"; };?><br>

				<img style="margin-left: 22px;" src="./pics/T.png" width="19"
					height="16" align="absmiddle"> 
       <?php if ($fname=="arenda_2-komn_kvartir_v_velikom_novgorode.php") { echo "<span style=\"background-color:#e5ffca;\">"; };?>
       <a class="link"
					href="./arenda_2-komn_kvartir_v_velikom_novgorode.php">2-комн.
					квартиры</a> (<?php echo counter_tbl_usl('rent_kva',$db, 'kva_rooms=\'2\''); ?>)
       <?php if ($fname=="arenda_2-komn_kvartir_v_velikom_novgorode.php") { echo "</span>"; };?><br>

				<img style="margin-left: 22px;" src="./pics/T.png" width="19"
					height="16" align="absmiddle"> 
       <?php if ($fname=="arenda_3-komn_kvartir_v_velikom_novgorode.php") { echo "<span style=\"background-color:#e5ffca;\">"; };?>
       <a class="link"
					href="./arenda_3-komn_kvartir_v_velikom_novgorode.php">3-комн.
					квартиры</a> (<?php echo counter_tbl_usl('rent_kva',$db, 'kva_rooms=\'3\''); ?>)
       <?php if ($fname=="arenda_3-komn_kvartir_v_velikom_novgorode.php") { echo "</span>"; };?><br>

				<img style="margin-left: 22px;" src="./pics/L.png" width="19"
					height="16" align="absmiddle"> 
       <?php if ($fname=="arenda_n-komn_kvartir_v_velikom_novgorode.php") { echo "<span style=\"background-color:#e5ffca;\">"; };?>
       <a class="link"
					href="./arenda_n-komn_kvartir_v_velikom_novgorode.php">Многокомн.
					квартиры</a> (<?php echo counter_tbl_usl('rent_kva',$db, 'kva_rooms>=\'4\''); ?>)
       <?php if ($fname=="arenda_n-komn_kvartir_v_velikom_novgorode.php") { echo "</span>"; };?><br>

				<div class="clear1"></div>

				<img src="./pics/ico_realty_for_resident.gif" width="18" height="18"
					align="absmiddle"> <b>АРЕНДА коммерческой недвижимости</b><br>
		<?php
		
		$commerce = array (
				'Офис',
				'Торговля и сервис',
				'Производство и склады',
				'Здания и особняки',
				'Кафе, бары и рестораны',
				'Другое' 
		);
		$type = 6;
		foreach ($commerce as $item) {
			$corn = 'T';			
			if (11 == $type) { $corn = 'L'; }
			$type++;
			$img = "<img src=\"./pics/$corn.png\" width=\"19\" height=\"16\" align=\"absmiddle\">";
			$marker = "<span style=\"background-color:#e5ffca;\">";
			$markerEnd = "</span>";
			$link = "<a class=\"link\" href=\"./commerce.php?type=$type\">$item</a>";
			echo $img . $link . '<br>';
		}

		?>
				<div class="clear1"></div>




			</div>
			<!-- marginer -->







		</div>
	</div>
</div>
<!-- +++++++++ /Дерево вертикального меню ++++++++++ -->