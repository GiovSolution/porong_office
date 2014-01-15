<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cetak Pengambilan Paket</title>
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
<body onload="window.print();window.close();">
<br><br>
<? if ($jum_medis <> 0) { ?>
<table width="1240px" border="0px" cellpadding="0px" cellspacing="0px">
	<tr>
		<td height="90px"><table width="1240px" height="90px" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="400px" align="center" valign="bottom"><font style="font-size:18px; font-weight:bold; border:#000000 1px solid">PENGAMBILAN PAKET </font></td>
			<td width="300px" valign="bottom" align="center"><b>FAKTUR PENJUALAN</b></td>
            <td width="540px" valign="top"><table width="540px" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="60px" align="right">Tanggal</td>
                <td width="480px">:&nbsp;&nbsp;<?=$dapaket_tanggal;?></td>
              </tr>
			  <tr>
                <td align="right">Nomor</td>
                <td>:&nbsp;&nbsp;<?=$jpaket_cust_no;?></td>
              </tr>
              <tr>
                <td align="right">Nama</td>
                <td>:&nbsp;&nbsp;<?=$jpaket_cust_nama;?></td>
              </tr>
              <tr>
                <td align="right">&nbsp;&nbsp;</td>
                <td>&nbsp;&nbsp;</td>
              </tr>
            </table></td>
          </tr>
        </table></td>
	</tr>
	<tr>
	  <td height="40px"><table width="1240px" height="40px" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="200px">&nbsp;</td>
		  <td width="1040px" valign="bottom">&nbsp;</td>
          <!--<td width="1040px" valign="bottom"><//?=$jpaket_nobukti;?></td>-->
        </tr>
      </table></td>
  </tr>
  	<tr>
	  <td width="1240px" height="25px">&nbsp;</td>
  </tr>
	<tr>
	  <td width="1240px" height="200px" valign="top">
	  <table width="1240px" border="0" cellspacing="0" cellpadding="0">
	  	<?php 
		$i=0;
		$subtotal=0;
		$uang_muka=0;
		$total=0;
		foreach($detail_ambil_paket_medis as $list => $row) { $i+=1;?>
        <tr>
          <td width="1070px">&nbsp;<?=$i;?>.&nbsp;<?=$row->paket_nama;?>&nbsp;(<?=$row->rawat_nama;?>&nbsp;-&nbsp;<?=$row->jpaket_nobukti;?>)&nbsp;<b>Jml : </b>&nbsp;<?=$row->dapaket_jumlah;?>&nbsp;<b>Sisa : </b>&nbsp;<?=$row->dpaket_sisa_paket;?><b> | Hrg Sat (Rp): </b>&nbsp;<?=rupiah($row->harga_satuan);?><b> | Jml (Rp): </b>&nbsp;<?=rupiah($row->jum_paket);?></td>
			<td width="170px" align="right"></td>
        </tr>
		<?php 
			$subtotal+= $row->jum_paket;
			$uang_muka = ($row->harga_satuan)*$row->dapaket_jumlah;
			$total = $subtotal - $uang_muka;
		}
		?>
      </table>
	  </td>
  </tr>
  <tr>
  <td height="30px">&nbsp;
  
  </td>
  </tr>
	<tr>
	  <td width="1240px"><table width="1240px" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="160px">&nbsp;</td>
          <td width="280px"><?=$_SESSION[SESSION_USERID];?></td>
          <td width="350px">&nbsp;</td>
          <td width="150px" align="right"><?=rupiah($subtotal);?></td>
		  <td width="150px">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td width="150px" align="right"><b> | UM: </b>&nbsp;<?=rupiah($uang_muka);?></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td align="right">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td align="right"><?=rupiah($total);?></td>
        </tr>
      </table></td>
  </tr>
</table>
<? } ?> 
<table width="1240px" border="0px" cellpadding="0px" cellspacing="0px">
	<tr>
		<td height="10px"></td>
	</tr>
</table>
<? if ($jum_nonmedis <> 0 ) { ?>
<? // TABLE NON MEDIS ?>
<table width="1240px" border="0px" cellpadding="0px" cellspacing="0px">
	<tr>
		<td height="90px"><table width="1240px" height="90px" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="400px" align="center" valign="bottom"><font style="font-size:18px; font-weight:bold; border:#000000 1px solid">PENGAMBILAN PAKET </font></td>
			<td width="300px" valign="bottom" align="center"><b>FAKTUR PENJUALAN</b></td>
            <td width="540px" valign="top"><table width="540px" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="60px" align="right">Tanggal</td>
                <td width="480px">:&nbsp;&nbsp;<?=$dapaket_tanggal;?></td>
              </tr>
			  <tr>
                <td align="right">Nomor</td>
                <td>:&nbsp;&nbsp;<?=$jpaket_cust_no;?></td>
              </tr>
              <tr>
                <td align="right">Nama</td>
                <td>:&nbsp;&nbsp;<?=$jpaket_cust_nama;?></td>
              </tr>
              <tr>
                <td align="right">Alamat</td>
                <td>:&nbsp;&nbsp;<?=$jpaket_cust_alamat;?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
	</tr>
	<tr>
	  <td height="40px"><table width="1240px" height="40px" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="200px">&nbsp;</td>
          <td width="1040px" valign="bottom" align="left"><?=$dapaket_nobukti_pajak;?></td>
        </tr>
      </table></td>
  </tr>
  	<tr>
	  <td width="1240px" height="25px">&nbsp;</td>
  </tr>
	<tr>
	  <td width="1240px" height="200px" valign="top">
	  <table width="1240px" border="0" cellspacing="0" cellpadding="0">
	  	<?php 
		$i=0;
		$subtotal=0;
		$uang_muka=0;
		$total=0;
		foreach($detail_ambil_paket_nonmedis as $list => $row) { $i+=1;?>
        <tr>
          <td width="1070px">&nbsp;<?=$i;?>.&nbsp;<?=$row->paket_nama;?>&nbsp;(<?=$row->rawat_nama;?>&nbsp;-&nbsp;<?=$row->jpaket_nobukti;?>)&nbsp;<b>Jml : </b>&nbsp;<?=$row->dapaket_jumlah;?>&nbsp;<b>Sisa : </b>&nbsp;<?=$row->dpaket_sisa_paket;?><b>| Hrg Sat (Rp): </b>&nbsp;<?=rupiah($row->harga_satuan);?><b>| Jml (Rp): </b>&nbsp;<?=rupiah($row->jum_paket);?></td>
			<td width="170px" align="right"></td>
        </tr>
		<?php 
			$subtotal+= ($row->jum_paket)/1.1;
			$pajak = ($subtotal)*0.1;
			$uang_muka+= ($row->harga_satuan)*$row->dapaket_jumlah;
			$total = $subtotal + $pajak - $uang_muka;
		}
		?>
      </table>
	  </td>
  </tr>
  <tr>
	<td width="1240px" height="30px">&nbsp;</td>
  </tr>
	<tr>
	  <td width="1240px"><table width="1240px" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="160px">&nbsp;</td>
          <td width="280px"><?=$_SESSION[SESSION_USERID];?></td>
          <td width="350px">&nbsp;</td>
          <td width="150px" align="right"><?//=rupiah($subtotal);?></td>
		  <td width="150px" align="right"><? //<b> | PPN: </b>&nbsp;<?=rupiah($pajak);?></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td width="150px" align="right"><b> | UM: </b>&nbsp;<?=rupiah($uang_muka);?></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td align="right">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td align="right"><?=rupiah($total);?></td>
        </tr>
      </table></td>
  </tr>
</table>
<? } ?>
</body>
</html>
