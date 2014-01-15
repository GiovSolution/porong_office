<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cetak Penjualan Paket</title>
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
<? // Ini Penjualan Paket Medis ?>
<table width="1240px" border="0px" cellpadding="0px" cellspacing="0px">
	<tr>
		<td height="1px"><table width="1240px" height="20px" border="0" cellspacing="0" cellpadding="0">
		<br>
		</td>
		<td height="10px"><table width="1240px" height="20px" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="700px" align="center" valign="bottom">&nbsp;</td>
            <td width="540px" valign="top"><table width="540px" border="0" cellspacing="0" cellpadding="0">
				<tr>
			    <td width="70px">&nbsp;</td>
				<td>&nbsp;</td>
				<td rowspan ="3" height="5px" align="right">
					<font size=5><b><i>COPY</i></b></font>&nbsp;&nbsp;&nbsp;
				</td>
				</tr>
              <tr>
                <td width="100px" align="right">Tanggal & Jam</td>
                <td width="480px">:&nbsp;&nbsp;
				<?=$jpaket_tanggal;?>
				<?=$jpaket_jam;?>
				</td>
              </tr>
			  <tr>
                <td align="right">Nomor</td>
                <td>:&nbsp;&nbsp;<?=$cust_no;?></td>
              </tr>
              <tr>
                <td align="right">Nama</td>
                <td>:&nbsp;&nbsp;<?=$cust_nama;?></td>
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
	  <td height="15px">
	  <table width="1240px" height="15px" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="200px">&nbsp;</td>
          <td width="1040px" valign="bottom"><?=$jpaket_nobukti;?></td>
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
		/*Ini untuk Penjualan Paket  Medis */
		$i=0;
		//$total=0;
		$subtotal=0;
		//$total_diskon_tamb=0;
		//$total_voucher=0;
		foreach($detail_jpaket_medis as $list => $row) { $i+=1;?>
        <tr>
          <td width="490px">&nbsp;<?=$i;?>.&nbsp;<?=$row->paket_nama;?></td>
          <td width="150px">&nbsp;<?=$row->dpaket_jumlah;?></td>
          <td width="160px" align="right">&nbsp;<?=rupiah($row->dpaket_harga);?></td>
          <td width="170px" align="right">&nbsp;<?=$row->dpaket_diskon;?></td>
          <td width="270px" align="right">&nbsp;<?=rupiah($row->jumlah_subtotal_medis);?></td>
		  <td width="170px" align="right"><b>[&nbsp;&nbsp;Exp : <?=$row->tgl_kadaluarsa;?>&nbsp;&nbsp;]</b></td>
		 </tr>
		<?php 
			$subtotal+=($row->jumlah_subtotal_medis);
			$voucher_medis = $row->voucher_total_medis;
		}
		//$total=($subtotal*((100-$jpaket_diskon)/100)-$jpaket_cashback);
		//$total_diskon_tamb=($subtotal*($jpaket_diskon/100));
		//$total_voucher= $jpaket_cashback;
		
		$total_medis = $subtotal - $voucher_medis;
		//$detail_jpaket_medis as $list2 => $row2;
		
		?>
      </table>
	  </td>
  </tr>
  
  <tr>
  <td height="30px">
  <?=$iklantoday_keterangan;?>
  </td>
  </tr>
  
	<tr>
	  <td width="1240px"><table width="1240px" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="160px">&nbsp;</td>
          <td width="280px"><?=$_SESSION[SESSION_USERID];?></td>
          <td width="420px">&nbsp;</td>
          <td width="180px">&nbsp;</td>
          <td width="200px" align="right"><?=rupiah($subtotal);?>&nbsp;&nbsp;&nbsp;</td>
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
          <td><?php if($cara_bayar1<>''){?><?//=$cara_bayar1;?>&nbsp;:&nbsp;<?//=rupiah($nilai_bayar1);?><?php }?></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td width="400px" align="right">
			<?php if($voucher_medis<>0){?><?echo rupiah($voucher_medis);?>&nbsp;&nbsp;&nbsp;<?php }?>
		  </td>
        </tr>
        <tr height="30px">
          <td>&nbsp;</td>
          <td><?php if($cara_bayar3<>''){?><?//=$cara_bayar3;?>&nbsp;:&nbsp;<?//=rupiah($nilai_bayar3);?><?php }?></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td align="right"><?echo rupiah($total_medis);?>&nbsp;&nbsp;&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
<? if ($jum_nonmedis <> 0) { ?>
<br>
<br>
<? } ?>

<? } ?>


<? if ($jum_nonmedis <> 0) { ?>
<? // Ini Penjualan Paket Non Medis ?>
<table width="1240px" border="0px" cellpadding="0px" cellspacing="0px">
	<tr>
		<td height="1px"><table width="1240px" height="20px" border="0" cellspacing="0" cellpadding="0">
		<br>
		</td>
		<td height="10px"><table width="1240px" height="20px" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="700px" align="center" valign="bottom">&nbsp;</td>
            <td width="540px" valign="top"><table width="540px" border="0" cellspacing="0" cellpadding="0">
              <tr>
			    <td width="70px">&nbsp;</td>
				<td>&nbsp;</td>
				<td rowspan ="3" height="5px" align="right">
					<font size=5><b><i>COPY</i></b></font>&nbsp;&nbsp;&nbsp;
				</td>
				</tr>
              <tr>
			  <tr>
                <td width="100px" align="right">Tanggal & Jam</td>
                <td width="480px">:&nbsp;&nbsp;
				<?=$jpaket_tanggal;?>
				<?=$jpaket_jam;?>
				</td>
              </tr>
			  <tr>
                <td align="right">Nomor</td>
                <td>:&nbsp;&nbsp;<?=$cust_no;?></td>
              </tr>
              <tr>
                <td align="right">Nama</td>
                <td>:&nbsp;&nbsp;<?=$cust_nama;?></td>
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
	  <td height="15px">
	  <table width="1240px" height="15px" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="200px">&nbsp;</td>
		  <td width="1040px" valign="bottom"><?=$jpaket_nobukti;?></td>
          <td width="1040px" valign="bottom"><?=$jpaket_nobukti_pajak;?></td>
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
		/*Ini untuk Penjualan Paket Non Medis */
		$i=0;
		//$total=0;
		$subtotal_nonmedis=0;
		//$total_diskon_tamb=0;
		//$total_voucher=0;
		$ppn = 0;
		$total_nonmedis = 0;
		$voucher_nonmedis_pajak = 0;
		foreach($detail_jpaket_nonmedis as $list => $row) { $i+=1;?>
        <tr>
          <td width="490px">&nbsp;<?=$i;?>.&nbsp;<?=$row->paket_nama;?></td>
          <td width="150px">&nbsp;<?=$row->dpaket_jumlah;?></td>
          <td width="160px" align="right">&nbsp;<?=rupiah($row->dpp);?></td>
          <td width="170px" align="right">&nbsp;<?=$row->dpaket_diskon;?></td>
          <td width="270px" align="right">&nbsp;<?=rupiah($row->subtotnet_dpp);?></td>
		  <td width="170px" align="right"><b>[&nbsp;&nbsp;Exp : <?=$row->tgl_kadaluarsa;?>&nbsp;&nbsp;]</b></td>
		 </tr>
		<?php 
			$subtotal_nonmedis+=($row->subtotnet_dpp);
			$voucher_nonmedis = $row->voucher_total_nonmedis;
		}
		//$total=($subtotal_nonmedis*((100-$jpaket_diskon)/100)-$jpaket_cashback);
		//$total_diskon_tamb=($subtotal_nonmedis*($jpaket_diskon/100));
		//$total_voucher= $jpaket_cashback;		
		$voucher_nonmedis_pajak = $voucher_nonmedis/1.1;
		$ppn = ($subtotal_nonmedis-$voucher_nonmedis_pajak)*10/100;
		$total_nonmedis = ($subtotal_nonmedis - $voucher_nonmedis_pajak) + $ppn;
		?>
      </table>
	  </td>
  </tr>
  
  <tr>
  <td height="30px">
  <?=$iklantoday_keterangan;?>
  </td>
  </tr>
  
	<tr>
	  <td width="1240px"><table width="1240px" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="160px">&nbsp;</td>
          <td width="280px"><?=$_SESSION[SESSION_USERID];?></td>
          <td width="420px">&nbsp;</td>
          <td width="180px">&nbsp;</td>
          <td width="200px" align="right"><?=rupiah($subtotal_nonmedis);?>&nbsp;&nbsp;&nbsp;</td>
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
          <td><?php if($cara_bayar1<>''){?><?//=$cara_bayar1;?>&nbsp;&nbsp;<?//=rupiah($nilai_bayar1);?><?php }?></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td width="400px" align="right">
			<?php if($voucher_nonmedis<>0){
					echo rupiah($voucher_nonmedis_pajak).' | ';}?>
			<? echo '<b>PPN: '.rupiah($ppn);?>&nbsp;&nbsp;&nbsp;
		  </td>
        </tr>
        <tr height="30px">
          <td>&nbsp;</td>
          <td><?php if($cara_bayar3<>''){?><?//=$cara_bayar3;?>&nbsp;:&nbsp;<?//=rupiah($nilai_bayar3);?><?php }?></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td align="right"><?=rupiah($total_nonmedis);?>&nbsp;&nbsp;&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
<? } ?>

</body>
</html>
