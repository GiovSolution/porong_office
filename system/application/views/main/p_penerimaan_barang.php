<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Laporan Pesanan Pembelian</title>
</head>

<body onload="window.print();">
<table width="700" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td height="120" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="55%" align="center"><br/><h2>LAPORAN <br/>
          PENERIMAAN BARANG <br><?=$info_nama;?><br/></h2></p></td>
        <td width="45%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <?php 
		foreach($data_print as $print) { 
			$no_bukti=$print->no_bukti;
			$tanggal=$print->tanggal;
			$supplier_nama=$print->supplier_nama;
			$surat_jalan=$print->terima_surat_jalan;
		}
		?>
          <tr>
            <td width="40%" align="right"><strong>No.</strong></td>
            <td width="4%">&nbsp;</td>
            <td width="72%"><?=$no_bukti; ?></td>
          </tr>
          <tr>
            <td align="right"><strong>Tanggal</strong></td>
            <td>&nbsp;</td>
            <td><?=$tanggal; ?></td>
          </tr>
          <tr>
            <td align="right"><strong>Dari</strong></td>
            <td>&nbsp;</td>
            <td><?=$supplier_nama; ?></td>
          </tr>
		  <tr>
            <td align="right"><strong>Surat Jalan</strong></td>
            <td>&nbsp;</td>
            <td><?=$surat_jalan; ?></td>
          </tr>
          <tr>
            <td align="right">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="top"><table width="100%" border="1" cellspacing="0" cellpadding="0">
   
      <tr>
        <td width="4%">&nbsp;</td>
        <td width="12%"><strong>Kode</strong></td>
        <td width="47%"><strong>Nama Produk</strong></td>
        <td width="12%"><strong>Jumlah</strong></td>
        <td width="13%"><strong>Volume</strong></td>
        <td width="12%"><strong>Satuan</strong></td>
      </tr>
      <?php 
	  $i=0;
	  foreach($data_print as $print) { 
	  $i++; 
	  ?>
      <tr>
      	<td><?php  echo $i; ?>;</td>
        <td><?php  echo $print->produk_kode; ?></td>
        <td><?php  echo $print->produk_nama; ?></td>
        <td><?php  echo $print->jumlah; ?></td>
        <td><?php  echo $print->produk_volume ?></td>
        <td><?php  echo $print->satuan_nama; ?></td>
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
            <td width="50%" align="center"><p><strong>Accounting</strong></p>
              <p>&nbsp;</p>
              <p>( &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; )</p></td>
            <td width="50%" align="center"><p><strong>Diterima Oleh</strong></p>
              <p>&nbsp;</p>
              <p>( &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; )</p></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>