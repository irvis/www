<?php 

  // ���������� ��������� ��
  require "./_parts/_db.php"; 
  
  // ���������� �����������
  require "./_parts/_auth.php"; 
  // ���� ������������ �����������, ����� ���� ���������� $glogged ����� �������� '1';
  
  // ���������� ��� ����� (��� ��������� ������� ����).
  $fname= basename (__FILE__);
  
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <title>�������� ��������� � ������� ��������� (� ������ � �� �������) - ������ &laquo;������������ ��������&raquo; (������������ �������� ���������)</title>
  <?php require "./_parts/include_style.php"; ?>
</head>
<body>




<table align="center" width="985" border="0" cellpadding="0" cellspacing="0">
<!-- ����� -->
<tr>
<td colspan="2">
  <?php require "./_parts/page_header.php"; ?>
</td>
</tr>
<!-- /����� -->

<!-- ���� -->
<tr>
<td colspan="2">
  <?php require "./_parts/menu_horisontal_top.php"; ?>
</td>
</tr>
<!-- /���� -->

<!-- ������ -->
<tr>
<td colspan="2">
  <?php require "./_parts/banner_horisontal_big.php"; ?>
</td>
</tr>
<!-- /������ -->



<!-- ���� -->
<tr>
<!-- +++++++++++++++++++++++++++++++++++++++++++ ����� ����� -->
<td valign="top">

  <?php require "./_parts/menu_vertical_left.php"; ?>
  <div class="clear"></div>
  
  <?php require "./_parts/page_blok_news.php"; ?>
  <div class="clear"></div>
  
  <?php require "./_parts/page_blok_labels.php"; ?>
  <div class="clear"></div>
  
</td>
<!-- +++++++++++++++++++++++++++++++++++++++++++ ����� ����� -->




<!-- ������ �����-->
<td valign="top">
  
  <!-- ========================================================================================= -->
  
<div class="content_box">
  
  <div class="content_header">
        <div class="content_inner">
        <b>������ � ������� �������� ��������� � ������� ���������</b>
        </div>
  </div>

  <div class="clear"></div>
  
  
  
  
  
  
  
  
  
     
 
 
 
 <div class="content_cover">
    <div class="content_inner" style="width:690px;">
       
       
       
        
       <div class="r_date">
           <a href="./uslugi.php" class="link"><img width="16" height="16" align="absmiddle" src="./pics/ico_add.png" border="0"></a> 
           <a href="./uslugi.php" class="link" onclick="return confirmRealty();">�������� ����������</a>
       </div>
       
       <div class="clear"></div>
       <h2>������ � ������� �������� ��������� � ������� ���������</h2>
       <div class="clear"></div>
       
       
       <!--
       <a href="./pics/realty/kn_office_662x120_001_big.jpg" target="_blank"><img width="662" height="120" style="display:inline;float:left;margin-right:20px;margin-bottom:20px;border:1px solid #acabab;" alt="���� ��������� � ������� ��������� �� ��. ����������, �.8" title="�������� ����������� ���������� (��������� � ����� ����)" src="./pics/realty/kn_office_662x120_001.jpg"></a>
       -->
       
    
       <img height="120" width="320" style="display:inline;float:left;margin-right:20px;margin-bottom:20px;border:1px solid #acabab;" alt="������ ��������� ��� ������� � ������� ���������" src="./pics/realty/320x120_office_002.jpg"/>
       
       <img height="120" width="320" style="display:inline;float:left;margin-right:20px;margin-bottom:20px;border:1px solid #acabab;" alt="������ �������� ��������� � ������� ���������" src="./pics/realty/320x120_torg_004.jpg"/>
       
       
      
      

      
       
    </div>
  </div>
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
</div> <!-- /content_box -->


  
  <!-- ========================================================================================= -->

</td>
<!-- /������ �����-->

</tr>
<!-- /���� -->





<!-- ���� -->
<tr>
<td colspan="2">
  <?php require "./_parts/menu_horisontal_bottom.php"; ?>
</td>
</tr>
<!-- /���� -->

<!-- �������� -->
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
<!-- /�������� -->

</table>






<div class="clear"></div>









</body>
</html>