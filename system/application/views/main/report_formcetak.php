<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Student Report</title>
<style type="text/css">
html,body,table,tr,td{
	font-family:Geneva, Arial, Helvetica, sans-serif;
	font-size:12px;
}
.title{
	font-size:12px;
}
</style>
</head>
<body onload="window.print();">
<?php 
  $i=0;
  foreach($detail_jproduk as $list => $row) { $i+=1;?>
<table width="420px" border="1px" cellpadding="0px" cellspacing="0px">
  <tr>
    <td height="10px" >
      <table width="420px" border="1px" cellpadding="0px" cellspacing="0px">
      <tr>
        <td width="100px"><img src="./uploads/logo.png" width="100" height="100"></td>    
        <td align=center><b>PROGRESS REPORT</b><br>
            Period : <?=$lr_period;?><br>
            Theme : <?=$lr_theme;?><br>
            Sub Theme : <?=$lr_subtheme;?><br>
            Student Name : <?=$row->cust_nama;?><br>
        </td>    
      </tr>
    </table>
    </td>
	</tr>
	<tr>
	  <td width="420px" valign="top">
	  <table width="420px" border="1" cellspacing="0" cellpadding="0">
    <tr>
      <td align=center>No</td>
      <td align=center width="100px">Subject</td>
      <td align=center>What I've Learned</td>
      <td align=center>My Progress</td>
    </tr>
    <tr>
      <td height="90px">1.</td>
      <td>Language Development</td>
      <td>&nbsp;&nbsp;<?=$lr_ld;?></td>
      <td align=center>
        <?
          $count_ld=0;
          $count_ld=strlen($row->dlr_report_ld);
          for ($i = 1; $i <= $count_ld; $i++) {
              ?><img src="./uploads/smiley.png" width="20" height="20"><?
          }
        ?>
    </td>
    </tr>
    <tr>
      <td height="90px">2.</td>
      <td>Social and Emotional Development <i>(Becoming a social being)</td>
      <td>&nbsp;&nbsp;<?=$lr_sed;?></td>
      <td align=center>
        <?
          $count_ld=0;
          $count_ld=strlen($row->dlr_report_sed);
          for ($i = 1; $i <= $count_ld; $i++) {
              ?><img src="./uploads/smiley.png" width="20" height="20"><?
          }
        ?>
      </td>
    </tr>
    <tr>
      <td height="90px">3.</td>
      <td>Physical Development (Moving and exploring)</td>
      <td>&nbsp;&nbsp;<?=$lr_pd;?></td>
      <td align=center>
        <?
          $count_ld=0;
          $count_ld=strlen($row->dlr_report_pd);
          for ($i = 1; $i <= $count_ld; $i++) {
              ?><img src="./uploads/smiley.png" width="20" height="20"><?
          }
        ?>
      </td>
    </tr>
    <tr>
      <td height="90px">4.</td>
      <td>Bible / Character Building</td>
      <td>&nbsp;&nbsp;<?=$lr_cb;?></td>
      <td align=center>
        <?
          $count_ld=0;
          $count_ld=strlen($row->dlr_report_cb);
          for ($i = 1; $i <= $count_ld; $i++) {
              ?><img src="./uploads/smiley.png" width="20" height="20"><?
          }
        ?>
      </td>
    </tr>
    <tr>
      <td height="90px">5.</td>
      <td>Mandarin</td>
      <td>&nbsp;&nbsp;<?=$lr_m;?></td>
      <td align=center>
        <?
          $count_ld=0;
          $count_ld=strlen($row->dlr_report_m);
          for ($i = 1; $i <= $count_ld; $i++) {
              ?><img src="./uploads/smiley.png" width="20" height="20"><?
          }
        ?>
      </td>
    </tr>
    </table>
	  </td>
  </tr>
  <tr>
    <td width="420px" valign="top">
    <table width="420px" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="175px"></td>
      <td colspan=3 align=center>Signature,</td>
    </tr>
    <tr height="60px">
      <td></td>
      <td valign=bottom align=center><hr>Parent</td>
      <td width="10px"></td>
      <td valign=bottom align=center><hr>Teacher</td>
      <td width="10px"></td>
    </tr>
    </table>
    </td>
  </tr>
</table>
<br>
  <?php 
  }
?>
</body>
</html>
