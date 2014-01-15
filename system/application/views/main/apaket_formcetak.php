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
<body onload="window.print();window.close();">
<table width="1240px" border="0px" cellpadding="0px" cellspacing="0px">
	<tr>
		<td height="90px"><table width="1240px" height="90px" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="700px" align="center" valign="bottom"><font style="font-size:18px; font-weight:bold; border:#000000 1px solid">PENGAMBILAN PAKET </font></td>
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
		foreach($detail_ambil_paket as $list => $row) { $i+=1;?>
        <tr>
          <td width="1240px">&nbsp;<?=$i;?>.&nbsp;<?=$row->paket_nama;?>&nbsp;(<?=$row->rawat_nama;?>&nbsp;-&nbsp;<?=$row->jpaket_nobukti;?>)&nbsp;&nbsp;<strong>diambil oleh:</strong> <?=$row->dapaket_cust_no;?> - <?=$row->dapaket_cust_nama;?>&nbsp;- <b>Jml : </b>&nbsp;<?=$row->dapaket_jumlah;?>&nbsp;- <b>Sisa : </b>&nbsp;<?=$row->dpaket_sisa_paket;?>&nbsp;- <b>Tgl Kadaluarsa : </b>&nbsp;<?=$row->dpaket_kadaluarsa;?></td>
        </tr>
		<?php 
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
          <td width="420px">&nbsp;</td>
          <td width="180px">&nbsp;</td>
          <td width="200px" align="right">&nbsp;</td>
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
          <td align="right">&nbsp;</td>
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
          <td align="right">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
