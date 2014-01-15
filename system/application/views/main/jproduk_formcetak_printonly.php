<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cetak Penjualan Produk</title>
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
  <td height="10px" > </td>
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
				<?=$jproduk_tanggal;?>
				<?=$jproduk_jam;?>
				</td>
              </tr>
			  <tr>
                <td align="right">Nomor</td>
                <td>:&nbsp;&nbsp;<?=$cust_no;?></td>
              </tr>
              <tr>
                <td align="right">Nama</td>
                <td>:&nbsp;&nbsp;
				<?=$cust_nama;?>
				<?
					$nama_karyawan=$jproduk_karyawan;
					if ($nama_karyawan <> 'NA')
					{
						?>(<?=$jproduk_karyawan;?>,<?=$jproduk_karyawan_no;?>)<? 
					}
				?>
				</td>
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
          <td width="1040px" valign="bottom"><?=$jproduk_nobukti;?></td>
        </tr>
      </table></td>
  </tr>
  	<tr>
	  <td width="1240px" height="30px">&nbsp;</td>
  </tr>
	<tr>
	  <td width="1240px" height="200px" valign="top">
	  <table width="1240px" border="0" cellspacing="0" cellpadding="0">
	  	<?php 
		$i=0;
		$total=0;
		$subtotal=0;
		$total_diskon_tamb_tamb=0;
		$total_voucher=0;
		foreach($detail_jproduk as $list => $row) { $i+=1;?>
        <tr>
          <td width="490px">&nbsp;<?=$i;?>.&nbsp;<?=$row->produk_nama;?></td>
          <td width="150px">&nbsp;<?=$row->dproduk_jumlah;?> <?=$row->satuan_nama;?></td>
          <td width="160px" align="right">&nbsp;<?=rupiah(($row->dproduk_harga));?></td>
          <td width="170px" align="right">&nbsp;<?=$row->dproduk_diskon;?></td>
          <td width="270px" align="right">&nbsp;<?=rupiah(($row->dproduk_jumlah)*($row->jumlah_subtotal));?></td>
        </tr>
		<?php 
			$subtotal+=(($row->dproduk_jumlah)*($row->jumlah_subtotal));
		}
		$total=($subtotal*((100-$jproduk_diskon)/100)-$jproduk_cashback);
		$total_diskon_tamb=($subtotal*($jproduk_diskon/100));
		$total_voucher= $jproduk_cashback;	
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
          <td width="280px"><?=$jproduk_creator;?></td>
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
          <td><?php if($cara_bayar1<>''){?><?=$cara_bayar1;?>&nbsp;:&nbsp;<?=rupiah($nilai_bayar1);?><?php }?></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
		  <td align="right">
          <?php if($total_voucher<>0){?><?=rupiah($total_voucher);?><?php }?>
		  <?php if($total_diskon_tamb<>0){?><?=rupiah($total_diskon_tamb);?><?php }?>
		  </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><?php if($cara_bayar2<>''){?><?=$cara_bayar2;?>&nbsp;:&nbsp;<?=rupiah($nilai_bayar2);?><?php }?></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
		  <td>&nbsp;</td>
          <!--<td align="right"><//?=rupiah($jumlah_bayar);?></td>-->
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><?php if($cara_bayar3<>''){?><?=$cara_bayar3;?>&nbsp;:&nbsp;<?=rupiah($nilai_bayar3);?><?php }?></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td align="right"><?=rupiah($total);?></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
