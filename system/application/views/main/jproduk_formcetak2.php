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
.pagebreak {
page-break-after: always;
}
</style>
</head>
<body onload="window.print();window.close();">
<?php
function myheader($jproduk_tanggal ,$cust_no ,$cust_nama ,$cust_alamat ,$jproduk_nobukti,$jproduk_nobukti_pajak, $jproduk_jam, $jproduk_karyawan, $jproduk_karyawan_no){
?>
<br><br>
<table width="1240px" height="90px" border="0" cellspacing="0" cellpadding="0">
  <td height="5px" > </td>
  <tr>
    <td width="700px" align="bottom" valign="bottom">&nbsp;</td>
    <td width="540px" valign="bottom"><table width="540px" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="100px" align="right">Tanggal & Jam</td>
        <td width="480px">:&nbsp;&nbsp;
          <?=$jproduk_tanggal;?> 
		  <?=$jproduk_jam;?></td>
      </tr>
      <tr>
        <td align="right">Nomor</td>
        <td>:&nbsp;&nbsp;
          <?=$cust_no;?></td>
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
    </table></td>
  </tr>
</table>
<table width="1240px" height="10px" border="0" cellspacing="0" cellpadding="0">
  <tr>
          <td width="200px">&nbsp;</td>
          <td width="1040px" valign="bottom"><?=$jproduk_nobukti_pajak;?></td>
        </tr>
  <tr>
    <td width="200px">&nbsp;</td>
    <td width="1040px" valign="bottom"><?=$jproduk_nobukti;?></td>
  </tr>
</table>
<table width="1240px" height="30px" border="0" cellspacing="0" cellpadding="0">
  <tr>
  	<td>&nbsp;</td>
  </tr>
</table>
<?php
}
?>
<?php
function content_header(){
?>
<table width="1240px" height="200px" border="0" cellspacing="0" cellpadding="0">
  <tr>
  	<td width="1240px" height="200px" valign="top"><table width="1240px" border="0" cellspacing="0" cellpadding="0">
<?php
}
?>
  	  <?php
		/* data header */
		$f_jproduk_tanggal = $jproduk_tanggal;
		$f_iklantoday_keterangan = $iklantoday_keterangan;
		$f_cust_no = $cust_no;
		$f_cust_nama = $cust_nama;
		$f_cust_alamat = $cust_alamat;
		$f_jproduk_nobukti = $jproduk_nobukti;
		$f_jproduk_nobukti_pajak = $jproduk_nobukti_pajak;
		$f_jproduk_jam = $jproduk_jam;
		$f_jproduk_karyawan = $jproduk_karyawan;
		$f_jproduk_karyawan_no = $jproduk_karyawan_no;

		
		/* data footer */
		$f_cara_bayar1 = $cara_bayar1;
		$f_nilai_bayar1 = $nilai_bayar1;
		$f_cara_bayar2 = $cara_bayar2;
		$f_nilai_bayar2 = $nilai_bayar2;
		$f_cara_bayar3 = $cara_bayar3;
		$f_nilai_bayar3 = $nilai_bayar3;
		
		$i=0;
		$total=0;
		$subtotal=0;
		$total_diskon_tamb_tamb=0;
		$total_voucher=0;$pajak=0;
		
		$dcount = sizeof($detail_jproduk);
		foreach($detail_jproduk as $list => $row){
			$i+=1;
			if(($i%15)==1){
				myheader($f_jproduk_tanggal ,$f_cust_no ,$f_cust_nama ,$f_cust_alamat ,$f_jproduk_nobukti,$f_jproduk_nobukti_pajak, $f_jproduk_jam, $f_jproduk_karyawan, $f_jproduk_karyawan_no);
				content_header();
			}
	  ?>
  	  <tr>
  	    <td width="490px">&nbsp;
  	      <?=$i;?>
  	      .&nbsp;
  	      <?=$row->produk_nama;?></td>
  	    <td width="150px">&nbsp;
  	      <?=$row->dproduk_jumlah;?>
  	      <?=$row->satuan_nama;?></td>
  	    <td width="160px" align="right">&nbsp;
  	      <?=rupiah(($row->dproduk_harga)/1.1);?></td>
  	    <td width="170px" align="right">&nbsp;
  	      <?=$row->dproduk_diskon;?></td>
  	    <td width="270px" align="right">&nbsp;
  	      <?=rupiah(($row->dproduk_jumlah)*(($row->jumlah_subtotal)/1.1));?></td>
	    </tr>
  	  <?php 
			$subtotal+=(($row->dproduk_jumlah)*(($row->jumlah_subtotal)/1.1));
			
			if($i==$dcount){
				$total_diskon_tamb=($subtotal*($jproduk_diskon/100))/1.1;
				$total_voucher= $jproduk_cashback/1.1;
				$pajak = ($subtotal - $total_diskon_tamb -$total_voucher)*0.1;
				$total=($subtotal-$total_voucher-$total_diskon_tamb+$pajak);

				content_footer();
				myfooter($subtotal ,$pajak, $total ,$f_cara_bayar1 ,$f_nilai_bayar1 ,$f_cara_bayar2 ,$f_nilai_bayar2 ,$f_cara_bayar3 ,$f_nilai_bayar3
						 ,$total_voucher ,$total_diskon_tamb, $f_iklantoday_keterangan);
			}elseif(($i>1) && ($i%15==0)){
				content_footer();
				echo "<div class='pagebreak'></div>";
			}
		}
	  ?>
<?php
function content_footer(){
?>
    </table></td>
  </tr>  
</table>
<?php
}
?>
<?php
function myfooter($subtotal ,$pajak,$total ,$cara_bayar1 ,$nilai_bayar1 ,$cara_bayar2 ,$nilai_bayar2 ,$cara_bayar3 ,$nilai_bayar3
				  ,$total_voucher ,$total_diskon_tamb, $f_iklantoday_keterangan){
?>
<table width="1240px" border="0" cellspacing="0" cellpadding="0">
   <tr>
    <td height="30px" colspan="5"><?=$f_iklantoday_keterangan;?></td>
  </tr>
  <tr>
    <td width="160px">&nbsp;</td>
    <td width="280px"><?=$_SESSION[SESSION_USERID];?></td>
    <td width="420px">&nbsp;</td>
    <td width="180px">&nbsp;</td>
    <td width="200px" align="right"><?=rupiah($subtotal);?></td>
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
    <td><?php if($cara_bayar1<>''){?>
      <?=$cara_bayar1;?>
      &nbsp;:&nbsp;
      <?=rupiah($nilai_bayar1);?>
      <?php }?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right"><?php if($total_voucher<>0){?>
      <?=rupiah($total_voucher);?>
      <?php }?>
      <?php if($total_diskon_tamb<>0){?>
      <?=rupiah($total_diskon_tamb);?>
      <?php }?> <b>| PPN : </b><?=rupiah($pajak);?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><?php if($cara_bayar2<>''){?>
      <?=$cara_bayar2;?>
      &nbsp;:&nbsp;
      <?=rupiah($nilai_bayar2);?>
      <?php }?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <!--<td align="right"><//?=rupiah($jumlah_bayar);?></td>-->
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><?php if($cara_bayar3<>''){?>
      <?=$cara_bayar3;?>
      &nbsp;:&nbsp;
      <?=rupiah($nilai_bayar3);?>
      <?php }?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right"><?=rupiah($total);?></td>
  </tr>
</table>
<?php
}
?>
</body>
</html>
