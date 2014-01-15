<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cetak Penjualan Rawat</title>
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
<table width="1240px" border="0px" cellpadding="0px" cellspacing="0px">
	<tr>
		<td height="110px"><table width="1240px" height="110px" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="700px" align="bottom" valign="bottom">&nbsp;</td>
            <td width="540px" valign="bottom"><table width="540px" border="0" cellspacing="0" cellpadding="0">
              <tr>
				<td></td>
				<td height="5px" align="right">
					<font size=5><b><i>COPY</i></b></font>
				</td>
			  </tr>
			  <tr>
                <td width="100px" align="right">Tanggal & Jam</td>
                <td width="480px">:&nbsp;&nbsp;
				<?=$jrawat_tanggal;?>
				<?=$jrawat_jam;?>
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
	  <td height="20px"><table width="1240px" height="10px" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="200px">&nbsp;</td>
          <td width="1040px" valign="bottom"><?=$jrawat_nobukti;?></td>
        </tr>
      </table></td>
  </tr>
  	<tr>
	  <td width="1240px" height="30px">&nbsp;</td>
  </tr>
	<tr>
	  <td width="1240px" height="200px" valign="top">
	  <?php if($detail_jrawat){?>
	  <table width="1240px" border="0" cellspacing="0" cellpadding="0">
	  <?php }?>
	  	<?php 
		$i=0;
		$total=0;
		$subtotal=0;
		$total_diskon_tamb=0;
		$total_voucher=0;
		foreach($detail_jrawat as $list => $row) { $i+=1;?>
        <tr>
          <td width="490px">&nbsp;<?=$i;?>.&nbsp;<?=$row->rawat_nama;?></td>
          <td width="150px">&nbsp;<?=$row->drawat_jumlah;?></td>
          <td width="160px" align="right">&nbsp;<?=rupiah($row->drawat_harga);?></td>
          <td width="170px" align="right">&nbsp;<?=$row->drawat_diskon;?></td>
          <td width="270px" align="right">&nbsp;<?=rupiah(($row->drawat_jumlah)*($row->jumlah_subtotal));?></td>
        </tr>
		<?php 
			$subtotal+=(($row->drawat_jumlah)*($row->jumlah_subtotal));
		}
		$total=($subtotal*((100-$jrawat_diskon)/100)-$jrawat_cashback-$jrawat_cashback_medis);
		$total_diskon_tamb=($subtotal*($jrawat_diskon/100));
		$total_voucher= $jrawat_cashback + $jrawat_cashback_medis;
		?>
      <?php if($detail_jrawat){?>
	  </table>
	  <?php }?><br />
	  <table width="1240px" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td><?php if($detail_apaket<>NULL){?><font style="font-weight:bold; border:#000000 1px solid">PENGAMBILAN PAKET</font><?php }?></td>
		</tr>
		<?php 
		$j=0;
		foreach($detail_apaket as $list => $row_apaket){ $j+=1;?>
		<tr>
			<td width="970px">&nbsp;<?=$j;?>.&nbsp;<?=$row_apaket->paket_nama;?>&nbsp;(<?=$row_apaket->rawat_nama;?>&nbsp;-&nbsp;<?=$row_apaket->jpaket_nobukti;?>)&nbsp;<b>Jml : </b>&nbsp;<?=$row_apaket->dapaket_jumlah;?>&nbsp;<b>Sisa : </b>&nbsp;<?=$row_apaket->dpaket_sisa_paket;?></td>
			<td width="270px" align="right">0</td>
		</tr>
		<?php }?>
	  </table>
	  </td>
  </tr>
  <tr>
  <td height="30px">
  <?=$iklantoday_keterangan;?>
  </td>
	<tr>
	  <td width="1240px"><table width="1240px" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="160px">&nbsp;</td>
          <td width="280px"><?=$jrawat_creator;?></td>
          <td width="420px">&nbsp;</td>
          <td width="180px">&nbsp;</td>
          <td width="200px" align="right"><?=rupiah($subtotal);?></td>
        </tr>
        <tr>
          <td align = "right">&nbsp;Printed by :</td>
          <td>&nbsp;<?=$_SESSION[SESSION_USERID];?></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><?php if($cara_bayar<>''){?><?=$cara_bayar;?>&nbsp;:&nbsp;<?=rupiah($bayar_nilai);?><?php }?></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td align="right">
			<?php if($total_voucher<>0){?><?=rupiah($total_voucher);?><?php }?>
			<?php if($total_diskon_tamb<>0){?><?=rupiah($total_diskon_tamb);?><?php }?>
		  </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><?php if($cara_bayar2<>''){?><?=$cara_bayar2;?>&nbsp;:&nbsp;<?=rupiah($bayar2_nilai);?><?php }?></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td align="right"><?=rupiah($jumlah_bayar);?></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><?php if($cara_bayar3<>''){?><?=$cara_bayar3;?>&nbsp;:&nbsp;<?=rupiah($bayar3_nilai);?><?php }?></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td align="right"><?=rupiah($total);?></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
