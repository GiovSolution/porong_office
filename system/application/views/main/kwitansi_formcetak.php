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
        <td width="700px" align="center" valign="bottom"><font style="font-family:Geneva, Arial, Helvetica, sans-serif; font-size:32px;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;KUITANSI</strong></font></td>
        <td width="540px" valign="top"><table width="540px" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="60px" align="right">&nbsp;</td>
            <td width="480px">&nbsp;</td>
          </tr>
          <tr>
            <td align="right">No.</td>
            <td>&nbsp;&nbsp;<?=$kwitansi_no;?></td>
          </tr>
          <tr>
            <td align="right">Tanggal</td>
            <td>:&nbsp;&nbsp;<?=$kwitansi_tanggal;?></td>
          </tr>
          <tr>
            <td align="right">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="35px"><table width="1240px" height="35px" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="200px">&nbsp;</td>
        <td width="1040px" valign="bottom">Sudah terima dari&nbsp;&nbsp;<font style="font-size:14px;font-weight:bold"><?=$kwitansi_customer; ?></font></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td width="1240px" height="30px">&nbsp;</td>
  </tr>
  <tr>
    <td width="1240px" height="140px" valign="top"><table width="1240px" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="50px">&nbsp;</td>
		<td width="190px">Banyaknya uang</td>
        <td width="1000px"><strong><?=$kwitansi_terbilang; ?></strong></td>
      </tr>
	  <tr>
        <td width="50px">&nbsp;</td>
		<td width="190px">Untuk pembayaran</td>
        <td width="1000px"><?=$kwitansi_keterangan; ?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
  	<td width="1240px" height="90px" valign="top"><table width="1240px" height="50px" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="50px" height="50px">&nbsp;</td>
        <td width="1190px" valign="top"><table width="1190" height="50px" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="800px" height="50px" valign="top"><table width="800px" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><table width="800px" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="350px" align="left"><font style="font-size:16px; font-weight:bold"><?=$kwitansi_nilai; ?></font></td>
                        <td width="450px">&nbsp;</td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="800" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <?php if($kwitansi_cara=='tunai'){?><td width="10px" style="border:#000000 1px solid"><b>V</b></td><?php }else{?>
					  <td width="10px" style="border:#000000 1px solid">&nbsp;</td>
					  <?php }?>
                      <td width="80px">&nbsp;Tunai</td>
                      <?php if($kwitansi_cara=='card'){?><td width="10px" style="border:#000000 1px solid"><b>V</b></td><?php }else{?>
					  <td width="10px" style="border:#000000 1px solid">&nbsp;</td>
					  <?php }?>
                      <td width="80px">&nbsp;Card</td>
                      <?php if($kwitansi_cara=='cek/giro'){?><td width="10px" style="border:#000000 1px solid"><b>V</b></td><?php }else{?>
					  <td width="10px" style="border:#000000 1px solid">&nbsp;</td>
					  <?php }?>
                      <td width="110px">&nbsp;Cek/Giro</td>
                      <?php if($kwitansi_cara=='transfer'){?><td width="10px" style="border:#000000 1px solid"><b>V</b></td><?php }else{?>
					  <td width="10px" style="border:#000000 1px solid">&nbsp;</td>
					  <?php }?>
                      <td width="110px">&nbsp;Transfer</td>
					  <?php if($kwitansi_cara=='retur'){?><td width="10px" style="border:#000000 1px solid"><b>V</b></td><?php }else{?>
					  <td width="10px" style="border:#000000 1px solid">&nbsp;</td>
					  <?php }?>
                      <td width="100px">&nbsp;Retur</td>
                      <td>&nbsp;</td>
                    </tr>
                  </table></td>
                </tr>
            </table></td>
            <td width="390px" height="50px">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
	  <tr>
	  	<td width="50px" height="10px">&nbsp;</td>
		<td width="1190px"><span style="border:#000000 1px solid">NOTE: Kuitansi ini baru dianggap sah, setelah pembayaran dengan Bilyet Giro/Cek tsb dapat diuangkan. </span></td>
	  </tr>
    </table></td>
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
