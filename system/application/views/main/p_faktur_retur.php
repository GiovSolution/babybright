<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Surat Retur Barang</title>
<link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle_nocolor.css'/>
</head>
<body onload="window.print();window.close();">
<table width="700" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td height="120" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="55%" align="center"><center><br/><h2>SURAT <br/>
          RETUR BARANG <br><?=$info_nama;?><br/></h2></p></center></td>
        <td width="45%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
       
          <tr class="clear">
            <td width="31%" align="right" class="clear"><strong>No. Retur</strong></td>
            <td width="3%" align="right" class="clear">:</td>
            <td width="66%" class="clear"><?=$no_bukti; ?></td>
          </tr>
          <tr class="clear">
            <td width="31%" align="right" class="clear"><strong>No. SP</strong></td>
            <td width="3%" align="right" class="clear">:</td>
            <td width="66%" class="clear"><?=$no_terima; ?></td>
          </tr>
          <tr class="clear">
            <td width="31%" align="right" class="clear"><strong>No. PB</strong></td>
            <td width="3%" align="right" class="clear">:</td>
            <td width="66%" class="clear"><?=$no_terima; ?></td>
          </tr>
          <tr class="clear">
            <td align="right" class="clear"><strong>Tanggal</strong></td>
            <td align="right" class="clear">:</td>
            <td class="clear"><?=$tanggal; ?></td>
          </tr>
          <tr class="clear">
            <td align="right" class="clear"><strong>Supplier</strong></td>
            <td align="right" class="clear">:</td>
            <td class="clear"><?=$supplier_nama; ?></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="top"><table width="100%" border="1" cellspacing="0" cellpadding="0">
   
      <tr>
        <td width="4%"  style="margin:2px"><strong>No</strong></td>
        <td width="12%"><strong>Kode</strong></td>
        <td width="47%"><strong>Nama Produk</strong></td>
        <td width="12%"><strong>Jumlah</strong></td>
        <td width="13%"><strong>Volume</strong></td>
        <td width="12%"><strong>Satuan</strong></td>
        <td width="12%"><strong>Harga Satuan</strong></td>
        <td width="12%"><strong>Diskon (%)</strong></td>
        <td width="12%"><strong>Sub Total</strong></td>
      </tr>
      <?php 
	  $i=0;
	  foreach($data_print as $print) { 
	  $i++; 
	  ?>
      <tr>
      	<td><?php  echo $i; ?></td>
        <td><?php  echo $print->produk_kode; ?></td>
        <td><?php  echo $print->produk_nama; ?></td>
        <td class="numeric" align="right" ><?php  echo number_format($print->jumlah_barang); ?></td>
        <td><?php  echo $print->produk_volume ?></td>
        <td><?php  echo $print->satuan_nama; ?></td>
        <td class="numeric"><?php  echo number_format($print->harga_satuan); ?></td>
        <td class="numeric"><?php  echo $print->diskon; ?></td>
        <td class="numeric"><?php  echo number_format($print->subtotal); ?></td>
      </tr>
      <?php } ?>
    </table></td>
  </tr>
  <tr>
    <td height="97"><table width="100%" border="1" cellspacing="0" cellpadding="0">
      <tr>
        <td width="35%"><p><b><u>Keterangan</u></b></p>
          <p>&nbsp;</p>
          <p>&nbsp;</p></td>
        <td width="65%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="50%" align="center" class="clear"><center><p><strong>Accounting</strong></p></center>
              <p>&nbsp;</p>
              <p>( &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;   )</p></td>
            <td width="50%" align="center"  class="clear"><center><p><strong>Dibuat Oleh</strong></p></center>
              <p>&nbsp;</p>
              <center><p>( &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;)</p></center></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>