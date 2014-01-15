<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Surat Permintaan Mutasi</title>
<link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle_nocolor.css'/>
</head>
<body onload="window.print()">
<?//window.close();">?>
<table width="700" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td height="10" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="55%" align="center"><font size="4"><center><b>SURAT PERMINTAAN MUTASI </b></font><br><font size="3"><b><?=$info_nama;?></font><br></center>
		<table>
			<tr>
				<td class="clear"><br></td>
			</tr>
			<tr>
				<td align="right" class="clear"><strong>Gudang Asal</strong></td>
				<td align="right" class="clear">:</td>
				<td class="clear"><?=$gudang_asal_nama; ?></td>
			</tr>	
			<tr>
				<td align="right" class="clear"><strong>Gudang Tujuan</strong></td>
				<td align="right" class="clear">:</td>
				<td class="clear"><?=$gudang_tujuan_nama; ?></td>
			</tr>		
		</table>
		</td>
        <td width="45%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <!--<//?php 
		foreach($data_print as $print) { 
			$no_bukti=$print->no_bukti;
			$tanggal=$print->tanggal;
			$supplier_nama=$print->supplier_nama;
		}
		?>--><!-- by masongbee-->
		 <tr class="clear">
            <td align="right" class="clear"><strong>Tanggal</strong></td>
            <td align="right" class="clear">:</td>
            <td class="clear"><?=$tanggal; ?></td>
          </tr>
          <tr class="clear">
            <td width="31%" align="right" class="clear"><strong>No.</strong></td>
            <td width="3%" align="right" class="clear">:</td>
            <td width="66%" class="clear" ><?=$no_bukti; ?></td>
          </tr>
         
         <!-- <tr class="clear">
            <td align="right" class="clear"><strong>Kepada</strong></td>
            <td align="right" class="clear">:</td>
            <td class="clear"><?//=$supplier_nama; ?></td>
          </tr>-->
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="top"><table width="100%" border="1" cellspacing="0" cellpadding="0">
   
      <tr>
        <td width="4%"  style="margin:2px" rowspan='2'><strong>No</strong></td>
        <td width="8%" rowspan='2' ><center><strong>Kode</strong></center></td>
        <td width="30%" rowspan='2'><center><strong>Nama Produk</strong></center></td>
		<td width="8%" rowspan='2'><center><strong>Satuan</strong></center></td>
        <td width="8%" rowspan='2'><center><strong>Isi</strong></center></td>
		<td width="12%" colspan='2'><center><strong>Jumlah (sesuai satuan)</strong></center></td>
		<td width="22%"rowspan='2'><center><strong>Keterangan</strong></center></td>
      </tr>
	  <tr>
		<td width="12%"><strong>Stok Saat ini</strong></td>
		<td width="8%"><strong>Diminta</strong></td>
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
		<td><?php  echo $print->satuan_nama; ?></td>   
        <td><?php  echo $print->produk_volume ?></td>
        <td>&nbsp;</td>
		<td class="numeric" align="right" ><?php  echo number_format($print->jumlah_barang); ?></td>
        <td>&nbsp;</td>
      </tr>
      <?php } ?>
    </table></td>
  </tr>
  <tr>
    <td height="97"><table width="100%" border="1" cellspacing="0" cellpadding="0">
      <tr>
        <td>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="30%" align="center" class="clear"><center><p><strong>Diminta oleh,</strong></p></center>
              <p>&nbsp;</p>
              <center><p>(Nama Peminta / Koordinator)</p></center>
			</td>
            <td width="40%" align="center"  class="clear"><center><p><strong>Mengetahui,</strong></p></center>
              <p>&nbsp;</p>
              <center><p>(Supervisor)</p></center>
			</td>
			<td width="30%" align="center"  class="clear"><center><p><strong>Disetujui,</strong></p></center>
              <p>&nbsp;</p>
              <center><p>(Clinic Manager)</p></center>
			</td>
          </tr>
        </table>
		</td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>