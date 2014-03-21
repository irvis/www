<?php 

  // Подключаем поддержку БД
  require "/home/n/nifestofil/novkva/public_html/_parts/_db.php"; 

  //$autouser='1791'; // Агентство СМАРТ ВН - smartvn@mail.ru - оплата до 3-его сентября 2013 г.
  
  $autouser='9999999999';
  
  
  $query="UPDATE rent_kmn
          SET date_upped='".time()."' 
          WHERE usr_id='".$autouser."';";
  $res=mysql_query($query,$db);
  
  $query="UPDATE rent_kva
          SET date_upped='".time()."' 
          WHERE usr_id='".$autouser."';";
  $res=mysql_query($query,$db);
  
  
  
  
  
  $query="UPDATE sell_dom
          SET date_upped='".time()."' 
          WHERE usr_id='".$autouser."';";
  $res=mysql_query($query,$db);
  
  $query="UPDATE sell_gar
          SET date_upped='".time()."' 
          WHERE usr_id='".$autouser."';";
  $res=mysql_query($query,$db);
  
  $query="UPDATE sell_kmn
          SET date_upped='".time()."' 
          WHERE usr_id='".$autouser."';";
  $res=mysql_query($query,$db);
  
  $query="UPDATE sell_kva
          SET date_upped='".time()."' 
          WHERE usr_id='".$autouser."';";
  $res=mysql_query($query,$db);
  
  $query="UPDATE sell_uch
          SET date_upped='".time()."' 
          WHERE usr_id='".$autouser."';";
  $res=mysql_query($query,$db);
  
  
  
    
  echo "User=".$autouser."<br>Auto upped!";
?>