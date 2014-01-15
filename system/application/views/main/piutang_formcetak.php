<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cetak Kwitansi</title>
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
        <td width="700px" align="center" valign="bottom"><font style="font-size:18px; font-weight:bold; border:#000000 1px solid">PELUNASAN PIUTANG</font></td>
        <td width="540px" valign="top"><table width="540px" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="60px" align="right">Tanggal</td>
            <td width="480px">:&nbsp;&nbsp;
              <?=$dpiutang_tanggal;?></td>
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
    </table></td>
  </tr>
  <tr>
    <td height="40px"><table width="1240px" height="40px" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="200px">&nbsp;</td>
        <td width="1040px" valign="bottom"><?=$dpiutang_nobukti;?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td width="1240px" height="30px">&nbsp;</td>
  </tr>
  <tr>
    <td width="1240px" height="200px" valign="top"><table width="1240px" border="0" cellspacing="0" cellpadding="0">
      <?php 
		$i=0;
		$total_bayar=0;
		foreach($detail_lpiutang as $list => $row) { $i+=1;?>
      <tr>
        <td width="490px">&nbsp;
          <?=$i;?>
          .&nbsp;
          <?=$row->lpiutang_faktur;?></td>
        <td width="150px">&nbsp;</td>
        <td width="160px" align="right">&nbsp;</td>
        <td width="170px" align="right">&nbsp;</td>
        <td width="270px" align="right">&nbsp;
          <?=rupiah($row->dpiutang_nilai);?></td>
      </tr>
      <?php 
			$total_bayar+=$row->dpiutang_nilai;
		}
		?>
    </table></td>
  </tr>
  <tr>
    <td height="30px">&nbsp;</td>
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
        <td><?=$cara_bayar;?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td align="right"><?=rupiah($total_bayar);?></td>
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
