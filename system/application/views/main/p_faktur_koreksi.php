<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Surat Mutasi Barang</title>
<link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle_nocolor.css'/>
</head>
<body onload="window.print();window.close();">
<table width="700" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td height="120" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="55%" align="center"><center><p><h2>SURAT <br/>
          PENEYESUAIAN STOK<br><?=$info_nama;?><br/></h2></p></center></td>
        <td width="45%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <!--<//?php 
		foreach($data_print as $print) { 
			$no_bukti=$print->no_bukti;
			$tanggal=$print->tanggal;
			$supplier_nama=$print->supplier_nama;
		}
		?>--><!-- by masongbee-->
          <tr class="clear">
            <td width="34%" align="right" class="clear"><strong>No.</strong></td>
            <td width="4%" class="clear">:&nbsp;</td>
            <td width="62%" class="clear"><?php echo $no_bukti; ?></td>
          </tr>
          <tr>
            <td align="right" class="clear"><strong>Tanggal</strong></td>
            <td class="clear">:&nbsp;</td>
            <td class="clear"><?php echo $tanggal; ?></td>
          </tr>
          <tr>
            <td align="right" class="clear"><strong> Gudang</strong></td>
            <td class="clear">:&nbsp;</td>
            <td class="clear"><?=$gudang_nama; ?></td>
          </tr>
          </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="top"><table width="100%" border="1" cellspacing="0" cellpadding="0">
   
      <tr>
        <td width="4%"><strong>No</strong></td>
        <td width="12%"><strong>Kode</strong></td>
        <td width="47%"><strong>Nama Produk</strong></td>
        <td width="12%"><strong>Volume</strong></td>
        <td width="13%"><strong>Satuan</strong></td>
        <td width="12%"><strong>Jumlah Awal</strong></td>
        <td width="12%"><strong>Jumlah Koreksi</strong></td>
        <td width="12%"><strong>Jumlah Saldo</strong></td>
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
        <td><?php  echo $print->produk_volume; ?></td>
        <td><?php  echo $print->satuan_nama ?></td>
        <td><?php  echo $print->dkoreksi_jmlawal; ?></td>
        <td><?php  echo $print->dkoreksi_jmlkoreksi; ?></td>
        <td><?php  echo $print->dkoreksi_jmlsaldo; ?></td>
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
              <center>
                <p>( &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; )</p></center></td>
            <td width="50%" align="center" class="clear"><center><p><strong>Dibuat Oleh</strong></p></center>
              <p>&nbsp;</p>
              <center><p>( &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; )</p></center></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>