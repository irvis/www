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
  <title>������ &laquo;������������ ��������&raquo; - ������������ �������� ���������.</title>
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
  
  
  <div class="content_box">
  
  
  
  <div class="content_header">
        <div class="content_inner">
        <b>������ &laquo;������������ ��������&raquo;</b>
        </div>
  </div>
  <div class="clear"></div>
  <div class="content_cover">
    <div class="content_inner">
      
      <div class="otstup"> <!-- otstup --> 
      
      <? echo "������ ��. ������� = ".get_notice_by_object ($db, 12, 143); ?>

      
      
      <div class="clear"></div>
      
      
      
      
      
    
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      </div> <!-- otstup --> 
      
    </div>
    
    
    
  
  
  

  



  
  
  
  
  
  
    
    
    
    
    
    
  </div> <!-- content box -->
  
  
  
  
  
  
  
  
  
  
  
  
  
  
 
  
  
  
  
  
  
  
  
  
  
  
  
  

  
  
  
  
  
  
  
  
  
  
  
  
  
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