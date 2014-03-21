<!-- +++++++++ Реклама ++++++++++ -->
<div class="menu_box">
  <div class="menu_header">
        <div class="menu_inner">
        <b>Реклама</b>
        </div>
  </div>
  
  <div class="clear"></div>
  
  <div class="menu_cover">
    <div class="menu_inner">
      
      <? $rnd=mt_rand(1,2); ?>
      
      <? if ($rnd==1) { ?>
        <a target="_blank" href="http://novgorod-land.ru"><img src="./pics/220x400_land.gif" class="bnr" alt="Портал недвижимости со скидкой, Великий Новгород" width="220" height="400" style="margin-left:5px;"></a>
      <? }; ?>
      
      
      <? if ($rnd==2) { ?>
        <img src="./pics/220x400_domoteka2.jpg" class="bnr" alt="Агентство недвижимости Домотека, Великий Новгород" width="220" height="400" style="margin-left:5px; margin-top:5px">
      <? }; ?>
      
      
	  
	  
      
      
    </div>
  </div>
</div>
<!-- +++++++++ /Реклама ++++++++++ -->
<div class="clear"></div>





<!-- +++++++++ Информеры ++++++++++ -->
<div class="menu_box">
  <div class="menu_header">
        <div class="menu_inner">
        <b>Наши информеры</b>
        </div>
  </div>
  
  <div class="clear"></div>
  
  <div class="menu_cover">
    <div class="menu_inner">
      
      <div style="display:inline;float:left;margin-left:15px;text-align:center;">
        <a href="http://www.novkva.ru/informers.php" target="_blank"><img src="http://www.novkva.ru/inf/informer_kvam.php" width="200" height="200" alt="Стоимость 1 кв. метра жилья в Великом Новгороде - Проект Новгородская Квартира" border="0"></a>
        <div class="clear" style="margin-top:5px;"></div>
        <a href="./informers.php" class="link">Получить код информера</a>
      </div>
      
    </div>
  </div>
</div>
<!-- +++++++++ /Информеры ++++++++++ -->
<div class="clear"></div>






<!-- +++++++++ Наши партнеры ++++++++++ -->
<div class="menu_box">
  <div class="menu_header">
        <div class="menu_inner">
        <b>Наши партнеры</b>
        </div>
  </div>
  
  <div class="clear"></div>
  
  <div class="menu_cover">
    <div class="menu_inner">
      
      <? $mass_bnr=array(); 
      
        $mass_bnr[0]="<a href=\"http://www.avt-nov.ru/\" target=\"_blank\"><img src=\"./pics/avtograf_w220_ani_v02.gif\" class=\"bnr\" alt=\"Рекламное агентство Автограф, Великий Новгород\" width=\"220\" height=\"80\" style=\"margin-left:3px;\"></a><div class=\"clear\"></div>";
        $mass_bnr[1]="<a href=\"http://www.novjob.ru/jobcat.php?id=69\" target=\"_blank\"><img src=\"./pics/novjob_w220.gif\" class=\"bnr\" alt=\"Работа в сфере недвижимости в Великом Новгороде\" width=\"220\" height=\"80\" style=\"margin-top:10px;margin-left:3px;\"></a><div class=\"clear\"></div>";
        $mass_bnr[2]="<a href=\"http://banksportal.ru\" target=\"_blank\"><img src=\"./pics/banks.jpg\" class=\"bnr\" alt=\"Все банки в Великом Новгороде\" width=\"220\" height=\"80\" style=\"margin-top:10px;margin-left:3px;\"></a><div class=\"clear\"></div>";
        $mass_bnr[3]="<a href=\"http://glav-agentstvo.ru\" target=\"_blank\"><img src=\"./pics/glav.jpg\" class=\"bnr\" alt=\"ГлавАгентство\" width=\"220\" height=\"80\" style=\"margin-top:10px;margin-left:3px;\"></a><div class=\"clear\"></div>";
        
        shuffle($mass_bnr);
        
        for ($i=0; $i<4; $i++) echo $mass_bnr[$i];
        
        
        
        
      ?>
      
      
      
      

      
      
      
      
    </div>
  </div>
</div>
<!-- +++++++++ /Наши партнеры ++++++++++ -->
<div class="clear"></div>






