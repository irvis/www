$(window).load(function() {

	
	
	jQuery('a.linkBlue').click(function(){
		if (jQuery('#popEnter').size()) {
			jQuery('#popEnter').remove();
		} else {
			var $menuPos = $(this).offset();
			var $left = $menuPos.left + ($(this).outerWidth() * 0.75);
			var $top = $(this).outerHeight();
			var $popEnter = jQuery('<div id=popEnter class="popover fade bottom in" style="top:0; right: 0; display: block;position: fixed"><div class="arrow"></div><div class="popover-inner"><h3 class="popover-title">Вход для пользователей</h3><div class="popover-content"><p><input type="text" placeholder="Введите адрес епочты"><br><input type="password" placeholder="Пароль"><br><button class="btn btn-small btn-primary" type="submit">Войти</button><button class="btn btn-success pull-right" type="button">Регистрация</button></p></div></div></div>').appendTo('body');
			var $leftPopE = $left - $popEnter.width();
			$popEnter.css({'top':$top, 'left':$leftPopE});
			jQuery('#popEnter > div.arrow').css('left',$popEnter.width() - 20);
		}
	});

});
