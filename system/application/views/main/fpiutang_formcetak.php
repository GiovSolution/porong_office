<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cetak Pelunasan Piutang</title>
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
function myheader($fpiutang_tanggal ,$cust_no ,$cust_nama ,$cust_alamat ,$fpiutang_nobukti){
?>
<table width="1240px" height="110px" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="700px" align="bottom" valign="bottom">&nbsp;</td>
    <td width="540px" valign="bottom"><table width="540px" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="60px" align="right">Tanggal</td>
        <td width="480px">:&nbsp;&nbsp;
          <?=$fpiutang_tanggal;?></td>
      </tr>
      <tr>
        <td align="right">Nomor</td>
        <td>:&nbsp;&nbsp;
          <?=$cust_no;?></td>
      </tr>
      <tr>
        <td align="right">Nama</td>
        <td>:&nbsp;&nbsp;
          <?=$cust_nama;?></td>
      </tr>
      <tr>
        <td align="right">&nbsp;&nbsp;</td>
                <td>&nbsp;&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="1240px" height="10px" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="200px">&nbsp;</td>
    <td width="1040px" valign="bottom"><?=$fpiutang_nobukti;?></td>
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
		$f_fpiutang_tanggal = $fpiutang_tanggal;
		$f_cust_no = $cust_no;
		$f_cust_nama = $cust_nama;
		$f_cust_alamat = $cust_alamat;
		$f_fpiutang_nobukti = $fpiutang_nobukti;
		
		/* data footer */
		$f_cara_bayar1 = $cara_bayar1;
		$f_nilai_bayar1 = $nilai_bayar1;
		
		$i=0;
		$total=0;
		$subtotal=0;
		$total_diskon_tamb=0;
		$total_voucher=0;
		
		$dcount = sizeof($detail_fpiutang);
		foreach($detail_fpiutang as $list => $row){
			$i+=1;
			if(($i%15)==1){
				myheader($f_fpiutang_tanggal ,$f_cust_no ,$f_cust_nama ,$f_cust_alamat ,$f_fpiutang_nobukti);
				content_header();
			}
	  ?>
  	  <tr>
  	    <td width="490px">&nbsp;
  	      <?=$i;?>
  	      .&nbsp;
  	      <?=$row->lpiutang_faktur;?></td>
  	    <td width="150px">&nbsp;
  	      <?php ?>
  	      <?php ?></td>
  	    <td width="160px" align="right">&nbsp;
  	      <?php ?></td>
  	    <td width="170px" align="right">&nbsp;
  	      <?php ?></td>
  	    <td width="270px" align="right">&nbsp;
  	      <?=rupiah($row->dpiutang_nilai);?></td>
	    </tr>
  	  <?php 
			$subtotal+=($row->dpiutang_nilai);
			
			if($i==$dcount){
				$total=$subtotal;
				
				content_footer();
				myfooter($subtotal ,$total ,$f_cara_bayar1 ,$f_nilai_bayar1 ,$total_voucher ,$total_diskon_tamb);
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
function myfooter($subtotal ,$total ,$cara_bayar1 ,$nilai_bayar1 ,$total_voucher ,$total_diskon_tamb){
?>
<table width="1240px" border="0" cellspacing="0" cellpadding="0">
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
      <?php }?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <!--<td align="right"><//?=rupiah($jumlah_bayar);?></td>-->
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
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
