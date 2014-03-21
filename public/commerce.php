<?php
require_once '../app/config.php';
require "./_parts/_auth.php";
$fname = '';
/**
 *
 * @author Dmitry Gavriloff <irvis@imega.ru>
 *        
 */
class Commerce {
	/**
	 * Город
	 */
     protected $city;
	/**
	 * Объекты
	 */
    protected $commerce = array (
        'Офис',
        'Торговля и сервис',
        'Производство и склады',
        'Здания и особняки',
        'Кафе, бары и рестораны',
        'Другое'
    );
	/**
	 * Запрос БД
	 *
	 * @var string
	 */
	protected $query;
	/**
	 * Коннектор БД
	 *
	 * @var mysqli
	 */
	protected $mysqli;
	/**
	 * Место
	 */
	protected $place;
	/**
	 * Request params
	 *
	 * @var array
	 */
	protected $params;
	/**
	 * Заголовок страницы
	 */
	protected $title = 'Коммерческие помещения в Великом Новгороде (в аренду и на продажу)';
	/**
	 * Тип недвижимости
	 *
	 * @var int
	 */
	protected $type;
	/**
	 * Конструктор
	 */
	function __construct() {
		$this->connect ();
	}
	/**
	 * Подключение к БД
	 */
	function connect() {
		$this->mysqli = new mysqli ( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
		if ($this->mysqli->connect_errno) {
			echo $this->mysqli->connect_error;
		}
		if (! $this->mysqli->query ( 'SET NAMES ' . DB_CHARSET )) {
			// $this->error = $this->mysqli->connect_error;
			return;
		}
	}
	/**
	 * Детальный обзор объекта
	 * @param int $id
	 */
	function detail($id)
	{
		$detail = $this->getQuery("select ce.type,ce.descr, ce.contacts, ce.date_created, sgg.title city, ce.geo_place, ce.gar_pl, spt.title auction, ce.price from commerce_estate ce left join spr_geo_gorod sgg on sgg.id = ce.geo_gorod_id left join spr_price_torg spt on spt.id=ce.price_torg where ce.id=".$id);

		$result = '';
		
		if ($detail['numrows'] >= 1) {
		    $object = $detail['rows'][0];
		    
		    $this->city = $object['city'];
		    $this->place = $object['geo_place'];
		    
	        $this->title = $this->commerce[$object['type'] - 1] . ', '.$object['gar_pl'] . ' кв.м., за ' . $object['price'] . ' тыс. руб.';
	        
	        
	        $result .= "<div class=\"part_left350\"><b>Описание</b><br>";
	        $result .= "Расположение: ";
	        $result .=  $object['city'].', '.$object['geo_place']."<br>";
	        
	        $result .= "Площадь: ";
	        $result .=  $object['gar_pl']." кв. м<br>";
	        
	        $result .=  "<br><b>Цена:</b><br>";
	        $result .=  "<span style=\"font-size:20px;font-weight:bold;\">";
	        $result .=  $object['price']." тыс. руб., ".$object['auction'];
	        $result .=  "<br>";
	        $result .=  "</span>";
	        
	        if (strlen($object['descr'])>0){
	            $result .=  "<br><b>Дополнительная информация</b><br>";
	            $result .=  str_replace("\n", "<br>", $object['descr'])."<br>";
	        };
	        
	        if (strlen($object['contacts'])>0){
	        $result .=  "<br><b>Контакты</b><br>";
	            $result .=  str_replace("\n", "<br>", $object['contacts'])."<br>";
	        };
	        
	        $result .=  "<br><b>Постоянная ссылка на эту страницу:</b><br>";
	        $result .=  "<input value=\"".URL."/commerce.php?id=".$id."\" style=\"border:1px solid #808080;width:280px;font-family:Arial;font-size:12px;color:#808080;\" onclick=\"this.select()\">";
	        $result .= "</div><div class=\"part_right340\" style=\"border:0px solid red;\">";
	        $result .= "<b>Карта-схема</b><br>";
	        $result .= "<div class=\"clear\" style=\"margin-top:5px;\"></div>";
	        $result .= "<div class=\"shema\" id=\"map\" style=\"width:312px;height:312px\"></div>";
	        $result .= "</div><div class=\"clear\" style=\"margin-top:20px;\"></div>";
		} else
		    header("Location: " . URL);
	    /*
	     * var placemark = new ymaps.Placemark([55.650625, 37.62708]);

    map.geoObjects.add(placemark);
	     */
	    return $result;
	}
	/**
	 * Скрипты
	 */
	function getScripts()
	{
	    $result = '<script src="//api-maps.yandex.ru/2.0/?load=package.full&lang=ru-RU" type="text/javascript"></script>';
	    $result .= "<script type=\"text/javascript\">ymaps.ready(init);function init(){var myMap = new ymaps.Map('map', {
                    center: [58.538643, 31.258461],
                    behaviors: ['default', 'scrollZoom']
                });
                ymaps.geocode('".$this->city.",".$this->place."', {
                    results: 1
                }).then(function (res) {
                        var firstGeoObject = res.geoObjects.get(0),
                            coords = firstGeoObject.geometry.getCoordinates(),
                            bounds = firstGeoObject.properties.get('boundedBy');
                        myMap.geoObjects.add(firstGeoObject);
                        myMap.setBounds(bounds, {
                            checkZoomRange: true
                        });
                    });
            }
            </script>";
	    return $result;
	}
	/**
	 * Заголовок страницы
	 */
	function getTitle()
	{
	    return $this->title;
	}
	/**
	 * Вернуть тип недвижимости
	 *
	 * @param int $value        	
	 * @return string
	 */
	function getType($value) {
	}
	/**
	 * Получить результат запроса
	 *
	 * @param unknown $value        	
	 */
	function getQuery($value) {
		$res = $this->mysqli->query ( $value );
		$numrows = $res->num_rows;

		while ( $row = $res->fetch_array () ) {
			$rows [] = $row;
		}
		return array (
				'numrows' => $numrows,
				'rows' => $rows 
		);
	}
	/**
	 * Init
	 */
	public function init()
	{
		if ($_SERVER ['REQUEST_METHOD'] == 'GET') {
			$this->params = $_GET;
		} else {
			$this->params = $_POST;
		}
		
		if (isset($this->params['id']))
			return $this->detail($this->params['id']);
		else
			return $this->types($this->params['type']); 
		
	}
	/**
	 * Список объектов определенного типа
	 * @param int $type
	 */
	function types($type)
	{
	    $sort = 'ce.date_created DESC';
	    if (isset($this->params['sort']))
	        switch ($this->params['sort']) {
	            case 1: $sort = 'ce.gar_pl ASC'; break;
	            case 2: $sort = 'ce.price ASC'; break;
		    }    
	    $types = $this->getQuery("select ce.id,ce.date_created, sgg.title city, ce.geo_place, ce.gar_pl, spt.title auction, ce.price from commerce_estate ce left join spr_geo_gorod sgg on sgg.id = ce.geo_gorod_id left join spr_price_torg spt on spt.id=ce.price_torg where ce.type=".$type." order by ".$sort);
		$result = '<img src="./pics/ico_filter.gif" width="18" height="18" align="absmiddle" border="0">';
		$result .= "<b>Найдено  объектов: ".$types['numrows']."</b>";
		if ($types['numrows'] >= 1) {
    		$result .= '<div class="clear" style="margin-top:10px;"></div>';
            $result .= "<table width=\"690\" cellpadding=\"5\" class=\"st\" cellspacing=\"0\">
    		       <tr class=\"tr_buy\">
    		         <td align=\"center\" width=\"75\"><a href=\"?type=$type&sort=0\" class=\"blink\" title=\"Сортировать по дате (актуальные сверху)\">Дата</a></td>
    		         <td align=\"center\"><b>Объект</b></td>
    		         <td align=\"center\"><b>Расположение</b></td>
    		         <td align=\"center\"><a href=\"?type=$type&sort=1\" class=\"blink\" title=\"Сортировать по площади (по возр.)\">Пл.</a></td>
    		         <td align=\"center\" width=\"90\"><a href=\"?type=$type&sort=2\" class=\"blink\" title=\"Сортировать по цене (по возр.)\">Цена</a></td>
    		         <td align=\"center\" width=\"90\"></td>
    		       </tr>";
            
            foreach ($types['rows'] as $row) {
                $id = $row['id'];
                $date = date('d.m.y', $row['date_created']);
                $object = $this->commerce[$type-1];
                $place = $row['city'].', '.$row['geo_place'];
                $s = $row['gar_pl'];
                $price = $row['price'].' тыс. руб.<br>'.$row['auction'];
                $result .= "<tr><td>$date</td><td>$object</td><td>$place</td><td>$s</td><td>$price</td><td><a href=\"?id=$id\" class=\"link\">Подробнее</a></td></tr>";
            }
		
            $result .= '</table>';

		}
		return $result;
	}
	/**
	 * отображение вида
	 *
	 * @param string $filename        	
	 * @return string
	 */
	function view($filename) {
		return file_get_contents ( APP_PATH . '/view/' . $filename );
	}
}

$commerce = new Commerce();
$content = $commerce->init();
$title = $commerce->getTitle();
$scripts = $commerce->getScripts();
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php 
    echo $title ?> -
	Проект &laquo;Новгородская квартира&raquo; (Недвижимость Великого
	Новгорода)</title>
  <?php require "./_parts/include_style.php"; ?>
</head>
<body>
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
		<tr>
			<td valign="top">

  <?php require "./_parts/menu_vertical_left.php"; ?>
  <div class="clear"></div>
  
  <?php require "./_parts/page_blok_news.php"; ?>
  <div class="clear"></div>
  
  <?php require "./_parts/page_blok_labels.php"; ?>
  <div class="clear"></div>
			</td>
			<td valign="top">
				<div class="content_box">
					<div class="content_header">
						<div class="content_inner">
							<b>Аренда и продажа коммерческих помещений в Великом Новгороде</b>
						</div>
					</div>

					<div class="clear"></div>
					<div class="content_cover">
						<div class="content_inner" style="width: 690px;">
							<div class="r_date">
								<a href="./uslugi.php" class="link"><img width="16" height="16"
									align="absmiddle" src="./pics/ico_add.png" border="0"></a> <a
									href="./uslugi.php" class="link"
									onclick="return confirmRealty();">Добавить объявление</a>
							</div>
							<div class="clear"></div>
							<h1><?php echo $title ?></h1>
							<div class="clear"></div>
							<?php 
								echo $content;
							?>
						</div>
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<?php require "./_parts/menu_horisontal_bottom.php"; ?>
		</td>
		</tr>
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
	</table>
	<div class="clear"></div>
	<?php echo $scripts ?>
</body>
</html>
