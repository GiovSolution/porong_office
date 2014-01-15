<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Surat Mutasi Barang</title>
<link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle_nocolor.css'/>
</head>
<body onload="window.print();">
<table width="700" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td height="60" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
	  <td width="32%">
	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
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
            <td align="right" class="clear"><strong>Dari Gudang</strong></td>
            <td class="clear">:&nbsp;</td>
            <td class="clear"><?=$gudang_asal_nama; ?></td>
          </tr>
          <tr>
            <td align="right" class="clear"><strong>Ke Gudang</strong></td>
            <td class="clear">:&nbsp;</td>
            <td class="clear"><?=$gudang_tujuan_nama; ?></td>
          </tr>
        </table>
		</td>
        <td width="28%" align="center"><font size="4"><center><p><b>SURAT <br/>
          MUTASI BARANG<br><font size="3"><b><?=$info_nama;?></p></center></td>
        <td width="40%">
		<? // posisi racikan ?>
		<?php if($data_print2<>NULL){ ?>
		 <?php if($mutasi_racikan==1){?>
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <!--<//?php 
		foreach($data_print as $print) { 
			$no_bukti=$print->no_bukti;
			$tanggal=$print->tanggal;
			$supplier_nama=$print->supplier_nama;
		}
		?>--><!-- by masongbee-->
		 <?php if($status_mutasi=='mutasi out'){?>
          <tr class="clear">
            <td width="34%" align="right" class="clear"><strong>Racikan keluar</strong></td>
            <td width="4%" class="clear">&nbsp;</td>
            <td width="62%" class="clear">&nbsp;</td>
          </tr>
		<?php /*
          <tr>
            <td align="right" class="clear"><strong>Produk jadi Tujuan</strong></td>
            <td class="clear">:&nbsp;</td>
            <td class="clear"><?php echo $produk_nama; ?></td>
          </tr>
          <tr>
            <td align="right" class="clear"><strong>Jumlah</strong></td>
            <td class="clear">:&nbsp;</td>
            <td class="clear"><?=$jumlah_out; ?></td>
          </tr>
		    */ ?>
          <?}?>
		
		   <?php if($status_mutasi=='mutasi in'){?>
		  <tr>
		    <td align="right" class="clear"><strong>Racikan Masuk</strong></td>
            <td class="clear">&nbsp;</td>
            <td class="clear">&nbsp;</td>
          </tr>
		
		  <tr>
            <td align="right" class="clear"><strong>No Ref</strong></td>
            <td class="clear">:&nbsp;</td>
            <td class="clear"><?=$mutasi_noref; ?></td>
          </tr>
		  <?}?>
        </table>
		 <?}?>
		 <?}?>
		</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="top"><table width="100%" border="1" cellspacing="0" cellpadding="0">
   
      <tr>
        <td width="4%"><strong>No</strong></td>
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
      	<td><?php  echo $i; ?></td>
        <td><?php  echo $print->produk_kode; ?></td>
        <td><?php  echo $print->produk_nama; ?></td>
        <td><?php  echo $print->dmutasi_jumlah; ?></td>
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
            <td width="50%" align="center" class="clear"><center><p><strong>Dibuat Oleh</strong></p></center>
              <p>&nbsp;</p>
              <center>
                <p>( &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; )</p></center></td>
            <td width="50%" align="center" class="clear"><center><p><strong>Penerima</strong></p></center>
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