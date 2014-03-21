
// Показать форму
function showblok(id) {
  if (document.getElementById(id).style.display=="none") {
    document.getElementById(id).style.display="inline";
  }else{
    document.getElementById(id).style.display="none";
  };
};


  // Реакции формы авторизации (ввод логина и пароля)
  // ======================================== Щёлчок по полю ввода
  function onClickThis(id) {
   old=document.getElementById(id).value;
   if ((id=='auth_l') && (old=='Ваш Email') )    { document.getElementById(id).value=""; };
   if ((id=='auth_p') && (old=='Пароль') ) { document.getElementById(id).value=""; };
  };

  // =================================== Потеря фокуса полем ввода 
  function onBlurThis(id) {
   old=document.getElementById(id).value;
   if ((id=='auth_l') && (old=='') ) { document.getElementById(id).value="Ваш Email";    };
   if ((id=='auth_p') && (old=='') ) { document.getElementById(id).value="Пароль"; };
  };
  // =============================================================
  
// Показать поле для ввода нас. пункта
function show_block(id,value) {
  if (value=="-1") {
    document.getElementById(id).style.display="inline";
  }else{
    document.getElementById(id).style.display="none";
  };
};  



// Показать район города для ввода ЕСЛИ выбран город Великий Новгород =
function show_block_r(id,value) {
  // Если выбран пункт "Другое"
  if (value=="-1") { 
    
    // Деактивировать меню "Район города"
    document.getElementById('rayon_id').value="0";
    document.myform.geo_rayon_id.disabled=true;
    
    // Показать поле ввода альтернативного названия
    document.getElementById(id).style.display="inline";
    
  // Если выбран населенный пункт из меню
  } else {
  
    // Скрыть поле ввода альтернативного названия
    document.getElementById(id).style.display="none";
    
    // Если выбран г. Великий Новгород
    if (value=="1") {
    
      // Активировать меню "Район города"
      document.myform.geo_rayon_id.disabled=false;
      
    // Если выбрано что-то другое  
    } else {
    
      // Деактивировать меню "Район города" 
      document.getElementById('rayon_id').value="0";
      document.myform.geo_rayon_id.disabled=true;
      
    };
  };
}; 


// Показать район города для ввода ЕСЛИ выбран город Великий Новгород =
function show_block_g(id,value) {
  // Если выбран пункт "Другое"
  if (value=="-1") { 
    // Показать поле ввода альтернативного названия
    document.getElementById(id).style.display="inline";
  // Если выбран населенный пункт из меню
  } else {
    // Скрыть поле ввода альтернативного названия
    document.getElementById(id).style.display="none";
  };
}; 



// Показать или скрыть поля про посуточную аренду
function show_block_ch(th) {
  if (th.checked==true) {
    document.getElementById('div_rent24').style.display="inline";
    document.getElementById('price_rent24').style.display="inline";
  }else{
    document.getElementById('div_rent24').style.display="none";
    document.getElementById('price_rent24').style.display="none";
  };
}; 







// Показать или скрыть блоки полей по квартире / комнате
function clicker(value) {
  if (value=="1") { // продажа комната
    document.getElementById('room_info').style.display="inline";
    document.getElementById('kv_info').style.display="none";
    document.getElementById('price_rent_info').style.display="none";
    document.getElementById('price_sell_info').style.display="inline";
  };
  if (value=="2") { // продажа квартира
    document.getElementById('room_info').style.display="none";
    document.getElementById('kv_info').style.display="inline";
    document.getElementById('price_rent_info').style.display="none";
    document.getElementById('price_sell_info').style.display="inline";
  };
  if (value=="8") { // аренда комната
    document.getElementById('room_info').style.display="inline";
    document.getElementById('kv_info').style.display="none";
    document.getElementById('price_rent_info').style.display="inline";
    document.getElementById('price_sell_info').style.display="none";
  };
  if (value=="9") { // аренда квартира
    document.getElementById('room_info').style.display="none";
    document.getElementById('kv_info').style.display="inline";
    document.getElementById('price_rent_info').style.display="inline";
    document.getElementById('price_sell_info').style.display="none";
  };
};  


// Функции для фильтра (продажа квартир)

function switch_street() {
   if (document.getElementById('street_id').value!=0) {
     document.getElementById('rayon_id').value=0;
   };
};

function switch_rayon() {
   if (document.getElementById('rayon_id').value!=0) {
     document.getElementById('street_id').value=0;
   };
};


// Функции для меню (продажа / аренда)
function switch_wind(value) {
  if (value=="buy") { // продажа
    document.getElementById('wind_rent').style.display="none";
    document.getElementById('wind_buy').style.display="inline";
  };
  if (value=="rent") { // аренда
    document.getElementById('wind_rent').style.display="inline";
    document.getElementById('wind_buy').style.display="none";
  };
};




// Подтверждение удаления
function confirmDelete() {
    if (confirm("Вы действительно хотите удалить объявление?\nОтменить этой действие будет невозможно.")) {
        return true;
    } else {
        return false;
    }
};

// Вывод сообщения по поводу коммерческой недвижимости
function confirmRealty() {
    if (confirm("Объявления по коммерческой недвижимости (продажа, аренда офисных, торговых, складских и производственных помещений) принимаются к публикации на ПЛАТНОЙ основе.\n Перейти на страницу \"Услуги\"?")) {
        return true;
    } else {
        return false;
    }
};