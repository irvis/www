<?php

  // ���������� ��������� ��
  require "./_parts/_db.php"; 



if (isset($_GET['link_id'])) {
// ���� ����� �������� � ���
  
  $link_id=(int)$_GET['link_id'];
  
  $query="SELECT * from c_links WHERE id='".$link_id."' AND type<>'8'";
  if (mysql_num_rows(mysql_query($query,$db))!=0) {
  // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++        
  // ���� ����� �������� ���� (�������� ���� � ����� id)
  
    // ��������� ����
    $q="INSERT INTO c_clicks VALUES (
      '',
      '$link_id',
      '".date("H:i:s d.m.Y")."',
      '".time()."',
      '".$_SERVER['REMOTE_ADDR']."',
      '".$_SERVER['HTTP_REFERER']."'
      )";
    $r=mysql_query($q,$db);
    
    
    // ������ ������� ���������
    $q="UPDATE c_links SET count = count+1 WHERE id = '".$link_id."'";
    $r=mysql_query($q,$db);
    
    
    // �������������� �� ������ ��������
    $q="SELECT t1.url
      FROM c_links AS t1
      WHERE id='".$link_id."'";
    $r=mysql_query($q,$db);
    
    $ar=mysql_fetch_assoc($r);
    $url=$ar['url'];  
    header ("Location: $url");
    exit; 
  // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  
  
  } else {
  // ���� ��� ������ ��������� �����:
  
    $url="http://www.novkva.ru/404.php";  
    header ("Location: $url");
    exit; 
  
  };

};








?>