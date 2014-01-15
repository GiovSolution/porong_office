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
<br>
<? if ($jum_medis <> 0 || $jum_apaket_medis <> 0 ) { ?>

<? // TABLE MEDIS ?>
<table width="1240px" border="0px" cellpadding="0px" cellspacing="0px">
	<tr>
		<td height="100px"><table width="1240px" height="100px" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="700px" align="bottom" valign="bottom">
				<table width="700px" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="700px" valign="bottom" align="right"><b>FAKTUR PENJUALAN</b></td>
				</tr>
				</table>
			</td>
            <td width="540px" valign="top">
			<table width="540px" border="0" cellspacing="0" cellpadding="0">
			 <tr>
			    <td width="70px">&nbsp;</td>
				<td>&nbsp;</td>
				<td height="5px" align="right">
					<font size=5><b><i>COPY</i></b></font>
				</td>
			 </tr>

			 <tr>
				<td width="5px">&nbsp;</td>
                <td width="140px" align="right">Tanggal</td>
                <td width="395px">:&nbsp;&nbsp;
				<?=$jrawat_tanggal;?>
				<?=$jrawat_jam;?></td>
              </tr>
			  <tr>
				<td></td>
                <td align="right">Nomor</td>
                <td>:&nbsp;&nbsp;<?=$cust_no;?></td>
              </tr>
              <tr>
				<td></td>
                <td align="right">Nama</td>
                <td>:&nbsp;&nbsp;<?=$cust_nama;?></td>
              </tr>
              <tr>
				<td></td>
                <td align="right">Alamat</td>
                <td>:&nbsp;&nbsp;<?=$cust_alamat;?></td>
              </tr>
            </table></td>
          </tr>
        </table>
		</td>
	</tr>
	<tr>
	  <td height="10px"><table width="1240px" height="10px" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="200px">&nbsp;</td>
          <td width="1040px" valign="bottom">(<?=$jrawat_nobukti;?>)</td>
        </tr>
		<tr>
          <td width="200px">&nbsp;</td>
          <td width="1040px" valign="bottom">&nbsp;<?//=$jrawat_nobukti_medis;?></td>
        </tr>
      </table></td>
  </tr>
  	<tr>
	  <td width="1240px" height="20px">&nbsp;</td>
  </tr>
	<tr>
	  <td width="1240px" height="200px" valign="top">
	  <?php if($detail_jrawat_medis){?>
	  <table width="1240px" border="0" cellspacing="0" cellpadding="0">
	  <?php }?>
	  	<?php 
		$i=0;
		$total=0;
		$subtotal=0;
		$total_diskon_tamb=0;
		$total_voucher=0;
		$jrawat_voucher_nonmedis=0;
		$jrawat_cashback_medis=0;
		$total_paket=0;
		$diskon_rupiah=0;
		$uang_muka = 0;
		foreach($detail_jrawat_medis as $list => $row) { $i+=1;?>
        <tr>
          <td width="490px">&nbsp;<?=$i;?>.&nbsp;<?=$row->rawat_nama;?></td>
          <td width="150px">&nbsp;<?=$row->drawat_jumlah;?></td>
          <td width="160px" align="right">&nbsp;<?=rupiah($row->drawat_harga);?></td>
          <td width="170px" align="right">&nbsp;<?=rupiah($row->drawat_diskon);?></td>
          <td width="270px" align="right">&nbsp;<?=rupiah(($row->drawat_jumlah)*($row->jumlah_subtotal));?></td>
        </tr>
		<?php 
			$subtotal+=(($row->drawat_jumlah)*($row->jumlah_subtotal));
			$total_voucher =  ($row->jrawat_cashback_medis);
			$diskon_rupiah =   (($row->jrawat_diskon)/100)*$subtotal;
		}
		if ($jum_medis <> 0) {
		//	$total=($subtotal*((100-$jrawat_diskon)/100)-$jrawat_cashback);
		//	$total_diskon_tamb=($subtotal*($jrawat_diskon/100));
		//	$total_voucher= $jrawat_cashback + $jrawat_voucher_nonmedis;
			//$total = ($subtotal - $jrawat_diskon - $uang_muka - $total_voucher);
			
		}
		?>
      <?php if($detail_jrawat_medis){?>
	  </table>
	  <?php }?><br />
	  <table width="1240px" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td><?php if($detail_apaket_medis<>NULL){?><font style="font-weight:bold; border:#000000 1px solid">PENGAMBILAN PAKET</font><?php }?></td>
		</tr>
		<?php 
		$j=0;
		foreach($detail_apaket_medis as $list => $row_apaket){ $j+=1;?>
		<tr>
			<td width="1070px">&nbsp;<?=$j;?>.&nbsp;<?=$row_apaket->paket_nama;?>&nbsp;(<?=$row_apaket->rawat_nama;?>&nbsp;-&nbsp;<?=$row_apaket->jpaket_nobukti;?>)&nbsp;<b>Jml : </b>&nbsp;<?=$row_apaket->dapaket_jumlah;?>&nbsp;<b>Sisa : </b>&nbsp;<?=$row_apaket->dpaket_sisa_paket;?><b> | Hrg Sat (Rp): </b>&nbsp;<?=rupiah($row_apaket->harga_satuan);?><b> | Jml (Rp): </b>&nbsp;<?=rupiah($row_apaket->jum_paket);?></td>
			<td width="170px" align="right"></td>
		</tr>
		<?php 			
			$total_paket = (($row_apaket->jum_paket));
			$uang_muka = $total_paket;
			
			}
		?>
	  </table>
	  </td>
  </tr>
  <tr>
  <td height="30px">
  <?=$iklantoday_keterangan;
	$total = ($subtotal + $total_paket - $uang_muka - $total_voucher - $diskon_rupiah);?>
  </td>
	<tr>
	  <td width="1240px"><table width="1240px" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="160px">&nbsp;</td>
          <td width="280px"><?=$_SESSION[SESSION_USERID];?></td>
          <td width="350px">&nbsp;</td>
		  <td width="150px">&nbsp;</td>
          <td width="150px" align="right"><?=rupiah($subtotal+$total_paket);?></td>
		  <td width="150px" align="right"><b> | UM: </b>&nbsp;<?=rupiah($uang_muka);?></td>
		 
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td width="160px">&nbsp;</td>
          <td width="280px"><?php if($cara_bayar<>''){?><?=$cara_bayar;?>&nbsp;&nbsp;<?=rupiah($bayar_nilai);?><?php }?></td>
          <td width="350px">&nbsp;</td>
		  <td width="150px">&nbsp;</td>
		  <td width="150px" align="right"><?=rupiah($total_voucher+$diskon_rupiah);?></td>
            <td width="150px">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><?php if($cara_bayar2<>''){?><?=$cara_bayar2;?>&nbsp;&nbsp;<?=rupiah($bayar2_nilai);?><?php }?></td>
          <td>&nbsp;</td>
			 <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><?php if($cara_bayar3<>''){?><?=$cara_bayar3;?>&nbsp;&nbsp;<?=rupiah($bayar3_nilai);?><?php }?></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
		  <td align="right"><?=rupiah($total);?></td>
        </tr>
      </table></td>
  </tr>
</table>
	<? if ($jum_nonmedis <> 0 || $jum_apaket_nonmedis <> 0 ) { ?>
		<br><br>
	<? } ?>
<? } ?>

<? if ($jum_nonmedis <> 0 || $jum_apaket_nonmedis <> 0 ) { ?>
<? // TABLE NON MEDIS ?>
<table width="1240px" border="0px" cellpadding="0px" cellspacing="0px">
	<tr>
		<td height="100px"><table width="1240px" height="100px" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="700px" align="bottom" valign="bottom">
				<table width="700px" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="700px" valign="bottom" align="right"><b>FAKTUR</b></td>
				</tr>
				</table>
			</td>
            <td width="540px" valign="top">
			<table width="540px" border="0" cellspacing="0" cellpadding="0">
			  <tr>
			    <td width="70px">&nbsp;</td>
				<td>&nbsp;</td>
				<td height="5px" align="right">
					<font size=5><b><i>COPY</i></b></font>
				</td>
			 </tr>
              <tr>
				<td width="5px">&nbsp;&nbsp;</td>
                <td width="140px" align="right">Tanggal</td>
                <td width="395px">:&nbsp;&nbsp;
				<?=$jrawat_tanggal;?>
				<?=$jrawat_jam;?></td>
              </tr>
			  <tr>
				<td></td>
                <td align="right">Nomor</td>
                <td>:&nbsp;&nbsp;<?=$cust_no;?></td>
              </tr>
              <tr>
				<td></td>
                <td align="right">Nama</td>
                <td>:&nbsp;&nbsp;<?=$cust_nama;?></td>
              </tr>
              <tr>
				<td></td>
                <td align="right">Alamat</td>
                <td>:&nbsp;&nbsp;<?=$cust_alamat;?></td>
              </tr>
            </table></td>
          </tr>
        </table>
		</td>
	</tr>
	<tr>
	  <td height="10px"><table width="1240px" height="10px" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="200px">&nbsp;</td>
          <td width="1040px" valign="bottom"><?//=$jrawat_nobukti_pajak;?></td>
        </tr>
		<tr>
          <td width="200px">&nbsp;</td>
          <td width="1040px" valign="bottom">(<?=$jrawat_nobukti;?>)</td>
        </tr>
      </table></td>
  </tr>
  	<tr>
	  <td width="1240px" height="20px">&nbsp;</td>
  </tr>
	<tr>
	  <td width="1240px" height="200px" valign="top">
	  <?php if($detail_jrawat_nonmedis){?>
	  <table width="1240px" border="0" cellspacing="0" cellpadding="0">
	  <?php }?>
	  	<?php 
		$i=0;
		$total=0;
		$subtotal=0;
		$total_diskon_tamb=0;
		$total_voucher=0;
		$subtotal_paket = 0;
		$uang_muka_non = 0;
		foreach($detail_jrawat_nonmedis as $list => $row) { $i+=1;?>
        <tr>
          <td width="490px">&nbsp;<?=$i;?>.&nbsp;<?=$row->rawat_nama;?></td>
          <td width="150px">&nbsp;<?=rupiah($row->drawat_jumlah);?></td>
          <td width="160px" align="right">&nbsp;<?=rupiah(($row->drawat_harga)/1.1);?></td>
          <td width="170px" align="right">&nbsp;<?=rupiah($row->drawat_diskon);?></td>
          <td width="270px" align="right">&nbsp;<?=rupiah(((($row->drawat_jumlah)*($row->drawat_harga))/1.1) - (((($row->drawat_jumlah)*($row->drawat_harga))/1.1)*($row->drawat_diskon / 100)));?></td>
        </tr>
		<?php 
			$subtotal+=(((($row->drawat_jumlah)*($row->drawat_harga))/1.1) - (((($row->drawat_jumlah)*($row->drawat_harga))/1.1)*($row->drawat_diskon / 100)));
			$sub_harga=(($row->drawat_jumlah)*($row->drawat_harga));
			$diskon_rupiah = (($row->jrawat_diskon)/100)*$sub_harga;
			$pajak = ($subtotal)*0.1;
		}
		
		if ($jum_nonmedis <> 0) {
		//	$total=($subtotal*((100-$jrawat_diskon)/100)-$jrawat_cashback_nonmedis);
			//$total_diskon_tamb=($subtotal*($jrawat_diskon/100));
			//$total_voucher= $jrawat_cashback_nonmedis;
			$diskon=$diskon;
			$total=($subtotal + $pajak)-($diskon+$diskon_rupiah);
		}
		?>
      <?php if($detail_jrawat_nonmedis){?>
	  </table>
	  <?php }?><br />
	  <table width="1240px" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td><?php if($detail_apaket_nonmedis<>NULL){?><font style="font-weight:bold; border:#000000 1px solid">PENGAMBILAN PAKET</font><?php }?></td>
		</tr>
		<?php 
		$j=0;
		foreach($detail_apaket_nonmedis as $list => $row_apaket){ $j+=1;?>
		<tr>
			<td width="1070px">&nbsp;<?=$j;?>.&nbsp;<?=$row_apaket->paket_nama;?>&nbsp;(<?=$row_apaket->rawat_nama;?>&nbsp;-&nbsp;<?=$row_apaket->jpaket_nobukti;?>)&nbsp;<b>Jml : </b>&nbsp;<?=$row_apaket->dapaket_jumlah;?>&nbsp;<b>Sisa : </b>&nbsp;<?=$row_apaket->dpaket_sisa_paket;?><b> | Hrg Sat (Rp): </b>&nbsp;<?=rupiah(($row_apaket->harga_satuan)/1.1);?><b> | Jml (Rp): </b>&nbsp;<?=rupiah(($row_apaket->jum_paket)/1.1);?></td>
			<td width="170px" align="right"></td>
		</tr>
		<?php $subtotal_paket=($row_apaket->jum_paket)/1.1;
				$uang_muka_non+=(($row_apaket->harga_satuan)* ($row_apaket->dapaket_jumlah))/1.1;
				//$pajak+= ($subtotal+$row_apaket->diskon)*0.1;
				
		
		}?>
		
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
		  <td width="160px">&nbsp;</td>
          <td width="280px"><?=$_SESSION[SESSION_USERID];?></td>
          <td width="350px">&nbsp;</td>
          <td width="150px">&nbsp;</td>
          <td width="150px" align="right"><?=rupiah($subtotal+$subtotal_paket);?></td>
			<td width="150px" align="right"><b> | UM: </b>&nbsp;<?=rupiah($uang_muka_non);?></td> 
	   </tr>
	   <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
		  <td>&nbsp;</td>
        </tr>
		 <tr>
			<td width="160px">&nbsp;</td>
			<td width="160px">&nbsp;</td>
          <td width="280px">&nbsp;</td>
          <td width="350px">&nbsp;</td>
          <td width="150px">&nbsp;</td>
          <td width="150px" align="right"><?=rupiah($diskon+$diskon_rupiah);?></td>
		  <td width="150px" align="right"><b> | PPN: </b>&nbsp;<?=rupiah((($subtotal+$subtotal_paket)-($diskon+$diskon_rupiah)-$uang_muka_non)*0.1);?></td>


        </tr>
		 </tr>
        <tr>
          <td>&nbsp;</td>
          <td><?php if($cara_bayar<>''){?><?//=$cara_bayar;?>&nbsp;&nbsp;<?//=rupiah($bayar_nilai);?><?php }?></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td align="right">
			<?php if($total_voucher<>0){?><?=rupiah($total_voucher);?><?php }?>
			<?php if($total_diskon_tamb<>0){?><?=rupiah($total_diskon_tamb);?><?php }?>
		  </td>
        </tr>
        <tr>
			 <td>&nbsp;</td>
		   <td>&nbsp;</td>
          <td><?php if($cara_bayar3<>''){?><?//=$cara_bayar3;?>&nbsp;&nbsp;<?//=rupiah($bayar3_nilai);?><?php }?></td>
          <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
           <td width="150px" align="right"><?=rupiah(($subtotal+$subtotal_paket)-$uang_muka_non-($diskon+$diskon_rupiah)+((($subtotal+$subtotal_paket)-($diskon+$diskon_rupiah)-$uang_muka_non)*0.1));?></td>
        </tr>
      </table></td>
  </tr>
</table>
<? } ?>
</body>
</html>
