
// �������� �����
function showblok(id) {
  if (document.getElementById(id).style.display=="none") {
    document.getElementById(id).style.display="inline";
  }else{
    document.getElementById(id).style.display="none";
  };
};


  // ������� ����� ����������� (���� ������ � ������)
  // ======================================== ٸ���� �� ���� �����
  function onClickThis(id) {
   old=document.getElementById(id).value;
   if ((id=='auth_l') && (old=='��� Email') )    { document.getElementById(id).value=""; };
   if ((id=='auth_p') && (old=='������') ) { document.getElementById(id).value=""; };
  };

  // =================================== ������ ������ ����� ����� 
  function onBlurThis(id) {
   old=document.getElementById(id).value;
   if ((id=='auth_l') && (old=='') ) { document.getElementById(id).value="��� Email";    };
   if ((id=='auth_p') && (old=='') ) { document.getElementById(id).value="������"; };
  };
  // =============================================================
  
// �������� ���� ��� ����� ���. ������
function show_block(id,value) {
  if (value=="-1") {
    document.getElementById(id).style.display="inline";
  }else{
    document.getElementById(id).style.display="none";
  };
};  



// �������� ����� ������ ��� ����� ���� ������ ����� ������� �������� =
function show_block_r(id,value) {
  // ���� ������ ����� "������"
  if (value=="-1") { 
    
    // �������������� ���� "����� ������"
    document.getElementById('rayon_id').value="0";
    document.myform.geo_rayon_id.disabled=true;
    
    // �������� ���� ����� ��������������� ��������
    document.getElementById(id).style.display="inline";
    
  // ���� ������ ���������� ����� �� ����
  } else {
  
    // ������ ���� ����� ��������������� ��������
    document.getElementById(id).style.display="none";
    
    // ���� ������ �. ������� ��������
    if (value=="1") {
    
      // ������������ ���� "����� ������"
      document.myform.geo_rayon_id.disabled=false;
      
    // ���� ������� ���-�� ������  
    } else {
    
      // �������������� ���� "����� ������" 
      document.getElementById('rayon_id').value="0";
      document.myform.geo_rayon_id.disabled=true;
      
    };
  };
}; 


// �������� ����� ������ ��� ����� ���� ������ ����� ������� �������� =
function show_block_g(id,value) {
  // ���� ������ ����� "������"
  if (value=="-1") { 
    // �������� ���� ����� ��������������� ��������
    document.getElementById(id).style.display="inline";
  // ���� ������ ���������� ����� �� ����
  } else {
    // ������ ���� ����� ��������������� ��������
    document.getElementById(id).style.display="none";
  };
}; 



// �������� ��� ������ ���� ��� ���������� ������
function show_block_ch(th) {
  if (th.checked==true) {
    document.getElementById('div_rent24').style.display="inline";
    document.getElementById('price_rent24').style.display="inline";
  }else{
    document.getElementById('div_rent24').style.display="none";
    document.getElementById('price_rent24').style.display="none";
  };
}; 







// �������� ��� ������ ����� ����� �� �������� / �������
function clicker(value) {
  if (value=="1") { // ������� �������
    document.getElementById('room_info').style.display="inline";
    document.getElementById('kv_info').style.display="none";
    document.getElementById('price_rent_info').style.display="none";
    document.getElementById('price_sell_info').style.display="inline";
  };
  if (value=="2") { // ������� ��������
    document.getElementById('room_info').style.display="none";
    document.getElementById('kv_info').style.display="inline";
    document.getElementById('price_rent_info').style.display="none";
    document.getElementById('price_sell_info').style.display="inline";
  };
  if (value=="8") { // ������ �������
    document.getElementById('room_info').style.display="inline";
    document.getElementById('kv_info').style.display="none";
    document.getElementById('price_rent_info').style.display="inline";
    document.getElementById('price_sell_info').style.display="none";
  };
  if (value=="9") { // ������ ��������
    document.getElementById('room_info').style.display="none";
    document.getElementById('kv_info').style.display="inline";
    document.getElementById('price_rent_info').style.display="inline";
    document.getElementById('price_sell_info').style.display="none";
  };
};  


// ������� ��� ������� (������� �������)

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


// ������� ��� ���� (������� / ������)
function switch_wind(value) {
  if (value=="buy") { // �������
    document.getElementById('wind_rent').style.display="none";
    document.getElementById('wind_buy').style.display="inline";
  };
  if (value=="rent") { // ������
    document.getElementById('wind_rent').style.display="inline";
    document.getElementById('wind_buy').style.display="none";
  };
};




// ������������� ��������
function confirmDelete() {
    if (confirm("�� ������������� ������ ������� ����������?\n�������� ���� �������� ����� ����������.")) {
        return true;
    } else {
        return false;
    }
};

// ����� ��������� �� ������ ������������ ������������
function confirmRealty() {
    if (confirm("���������� �� ������������ ������������ (�������, ������ �������, ��������, ��������� � ���������������� ���������) ����������� � ���������� �� ������� ������.\n ������� �� �������� \"������\"?")) {
        return true;
    } else {
        return false;
    }
};