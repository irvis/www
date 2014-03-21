<?php 

  // Подключаем поддержку БД
  require "./_parts/_db.php"; 
  
  // Подключаем авторизацию
  require "./_parts/_auth.php"; 
  // если пользователь авторизован, тогда наша переменная $glogged имеет значение '1';
  
  // Запоминаем имя файла (для подсветки пунктов меню).
  $fname= basename (__FILE__);
  
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <title>Проект &laquo;Новгородская квартира&raquo; - Недвижимость Великого Новгорода.</title>
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
    
    
    
    <div class="r_date">
      <img src="./pics/ico_date.gif" width="18" height="18" align="absmiddle"> 4 ноября 2011 г.
    </div>
    <div class="clear"></div>
    
    
    
    
    <img src="./pics/m/pic_01_zemlya_molodym_semyam.jpg" width="200" height="150" class="st_img" alt="Бесплатные участки под жилищную застройку молодым и многодетным семьям в Великом Новгороде">
    
    <h2>В Новгородской области готовы выдавать бесплатные участки под жилищную застройку</h2>
    
    
      
    <p>В марте 2011 года в Новгородской области, одном из первых регионов в стране, приняли закон о предоставлении молодым и многодетным семьям бесплатных земельных участков. К сегодняшнему дню в нашем регионе разработан порядок их предоставления, то есть прописаны правила и рекомендации для этих категорий граждан, желающих построить свой дом.</p>

<p>Выделение участков начнется уже нынешней осенью. Подробности для читателей «НВ» рассказывает Вероника МИНИНА, первый заместитель главы администрации области.</p>
 
<p><b>&#8211; Вероника Витальевна, сколько молодых и многодетных семей в Новгородской области уже написали заявления о предоставлении земельных участков и сколько земли готова выделить область под бесплатные участки?</b></p>

<p>&#8211; На сегодня поступили заявления от 155 семей из Великого Новгорода и 54 &#8211; из районов области. По предварительной оценке, площадь земель, которые мы сможем выделить для молодых и многодетных семей в этом году, &#8211; почти 266 тысяч квадратных метров. А на следующий год сможем довести эту цифру до 1 миллиона квадратных метров. Стоит учесть, что в нашем законе предусмотрено выделение бесплатных участков не только под жилье, но и под дачное строительство, и под ведение личного подсобного хозяйства.</p>

<p><b>&#8211; Молодые и многодетные семьи находятся в одном списке?</b></p>

<p>&#8211; Да. Нет смысла их разграничивать, потому что условия предоставления бесплатных участков для них практически одинаковые. Уже могу сказать, что подтвердили свое право на получение земли 119 семей, из них около 70 &#8211; в Великом Новгороде.</p>

<p><b>&#8211; Но в нынешней редакции областного закона «О предоставлении земельных участков на территории Новгородской области» есть некий «ценз оседлости», когда бесплатно выдаются участки молодым семьям, прожившим на территории региона не менее пяти лет, а многодетным &#8211; не менее двух лет. В аналогичном федеральном законе таких требований нет.</b></p>

<p>&#8211; Областной закон был разработан на несколько месяцев раньше федерального. И сейчас администрация области планирует через региональную Думу внести соответствующее изменение в отношении многодетных семей. Оно позволит большему числу многодетных семей воспользоваться правом на получение бесплатного участка земли.</p>

<p><b>&#8211; Где власти готовы предоставлять такие участки?</b></p>

<p>&#8211; Мне пришлось столкнуться с тем, что главы районов говорят, будто у них нет свободных участков. Рекомендация для них одна: расширять границы населенных пунктов за счет прилегающих земель. То есть в тех поселениях, где есть потребность в бесплатных участках, решать вопрос о включении в установленном порядке в границы населенных пунктов других категорий земель, в том числе неиспользуемых земель сельхозназначения.</p>

<p>Что касается Великого Новгорода, то, по объективной информации городских властей, мы вынуждены признать, что свободных и готовых участков под индивидуальную застройку нет. За исключением микрорайона Деревяницы и не так давно включенного в черту города микрорайона Кречевицы. В Деревяницах планируется выделить около 40 участков, в Кречевицах &#8211; 54. Размер участков в городе и в районах может составлять от трех до 15 соток.</p>

<p><b>&#8211; А где хотят строиться молодые и многодетные?</b></p>

<p>&#8211; Некоторые горожане хотят жить в деревне. Действующим порядком предусмотрено, что участки предоставляются в границах того муниципального образования, где заявитель проживает. Но администрация области планирует внести изменения в законодательство в части возможности получения данной категорией граждан участков и на территории других муниципальных образований.</p>

<p><b>&#8211; Что нужно, чтобы получить участок?</b></p>

<p>&#8211; Для этого нужно, чтобы участок находился в зоне, предназначенной для индивидуальной жилой застройки, и был свободен от прав третьих лиц. Мы разработали Порядок предоставления бесплатных участков, он опубликован на сайте КУГИ. Те справки, которые нужно собрать, &#8211; недорогие, и вообще, пакет документов нельзя назвать сложным. Многодетным семьям, например, даже не нужно подтверждать, что они нуждаются в улучшении жилищных условий.</p>

<p><b>&#8211; Земли у нас находятся в разной собственности &#8211; федеральной, областной, муниципальной... Но есть и те, на которые государственная собственность не разграничена. Что делать, если выбранный участок находится на такой земле?</b></p>

<p>&#8211; Вопрос только в том, кто такой землей распоряжается. Законодатель установил, что землей в районах области распоряжаются администрации муниципальных районов, а на территории Великого Новгорода &#8211; комитет по управлению государственным имуществом области. В эти органы гражданам и нужно обращаться с заявлением.</p>

<p><b>&#8211; Если все-таки семья получит отказ в предоставлении конкретного участка, как проверить правомерность действий местных властей?</b></p>

<p>&#8211; На свое официальное заявление с просьбой предоставить участок семья должна получить официальный ответ. Перечень случаев для отказа установлен Порядком, гражданин вправе оценить, правомерно ли сделан этот отказ. Поверьте, контролирующих органов у нас достаточно &#8211; и прокуратура, и суд. Мы готовы разбираться в каждом конкретном случае. Однозначно могу сказать: на территории области земли есть, закон существует, порядок получения участков прописан.</p>

<p><b>&#8211; Когда начнется реальное выделение участков?</b></p>

<p>&#8211; По области формирование участков уже идет. По Великому Новгороду предоставление участков планируется не позднее осени. Кстати, заметьте, что у нас, в Новгородской области, оформление земельных участков для семей идет за счет областного бюджета в отличие от той же Псковской области, где участки формируются за счет средств заявителя.</p>

<p><b>&#8211; Если семья получила бесплатно земельный участок под строительство, она может обратиться в областные льготные программы, которые помогают финансировать возведение жилья?</b></p>

<p>&#8211; Конечно, одно другого не исключает. Тем более что у нас в области успешно действует агентство по ипотечному жилищному кредитованию, определены субсидии, банки охотно идут навстречу. Теперь дело за новгородцами: правильно найти источник ресурсов и просчитать свою платежеспособность.</p>


<p><b>Как в других регионах предоставляют бесплатные земельные участки</b></p>

<p>Бесплатное предоставление земельного участка для молодых и многодетных семей регулируется Законом Российской Федерации от 14 июня 2011 г. № 138-ФЗ «О внесении изменений в статью 16 Федерального закона «О содейсствии развитию жилищного строительства» и Земельный кодекс Российской Федерации».</p>

<p>В регионах новый закон реализуют по-разному, и это предусмотрено федеральным законодательством.</p>

<p>Например, в Иванове семьям, где третий ребенок родился после 1 января 2011 года, обещано не менее 12 соток земли.</p>

<p>В Хакасии законодательство о бесплатных участках для многодетных и молодых семей расширили, включив в него молодых специалистов, окончивших образовательные учреждения начального, среднего и (или) высшего профессионального образования и работающих по трудовому договору, заключённому на срок не менее пяти лет, в сельской местности по полученной специальности.</p>

<p>В Волгоградской области депутаты областной Думы предложили поправки, согласно которым земельные участки составляют 10 соток. Кроме того, многодетным семьям, получившим земельные участки для индивидуального жилищного строительства, местные парламентарии предлагают предоставлять единовременную денежную выплату в размере 200 тысяч рублей.</p>

<p>Законодательное собрание Забайкальского края в середине мая подготовило законопроект, согласно которому земля многодетным семьям должна выделяться в границах района или города, где они проживают.</p>

<p>А вот для жителей Москвы и Санкт-Петербурга тоже есть свои особенности по реализации данного проекта. Земельный участок предоставляется многодетным семьям для строительства жилья, но в данных городах свободных территорий практически нет, поэтому москвичам и питерцам земельные участки будут предоставляться в пригородной территории, а не в самом городе.</p>

      
<p>&copy; Автор: <b>Юлия Генерозова</b>, газета <a class="link" href="http://www.novved.ru/component/content/article/26/15060---" target="_blank" rel="nofollow">&laquo;Новгородские ведомости&raquo;</a>, 5 августа 2011 г.</p>      
      
      
      
      
      
      
      
      
      
      
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