<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cetak Resep Dokter</title>
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
<table width="350px" border="0px" cellpadding="0px" cellspacing="0px">
	<tr>
		<td height="100px" colspan="2">
			<table height="70px" border="0" cellspacing="0" cellpadding="0">
			  <tr>
			  <br>
			  <br>
			  <br>
				<td valign="bottom"><div align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?=$karyawan_nama;?></div></td>
			  </tr>
			</table>
		</td>
	</tr>
  	<tr>
	  <td align="left" width="200px" valign="top" ><br><?=$karyawan_sip;?></td> 
		<td height="50px" valign="top" align="right"><br><?=$resep_tanggal;?></td>	
	</tr>
	<tr>

	</tr>
	<tr>
	  <td height="430px" valign="top" colspan="2">
	  <table border="0" cellspacing="0" cellpadding="0">
	  	<?php 
		//if ($detail_resepdokter != '')
		//{
		$i=0;
		?>
		<tr>
			<td colspan="3">
			<?
			//print "<b><font size=medium> R/ </font></b>";
			?></td>
		</tr>
		<tr>
			<td align="center"></td><td align="center"></td><td align="center"></td>
		</tr>
		<?foreach($detail_resepdokter as $list => $row) { $i+=1;?>
        <tr>
          <td height="20px" width="250px"> <?=$row->produk_nama;?></td>
		  <td height="20px" width="40px" align="right"><?=$row->dresepl_jumlah;?></td>
		  <td height="20px" width="60px"align="left"><?=$row->satuan_nama;?></td>
        </tr>
		<?php }?>
		<tr>
			<td colspan="3">
			<br>
			</td>
		</tr>
		
		<?php
		//}else
			//print ("Error! Call IT Department..");
		$i=0;
		?>
		<tr><td colspan="3">
		
		<?
		//print "<b><font size=medium> R/ </font></b>";
		?></td></tr>
		<tr><td align="center"></td><td align="center"></td><td align="center"></td></tr>
		<?
		foreach($detail_resepdokter_tambahan as $list => $row) { $i+=1;?>
        <tr>
			<td height="20px" width="150x"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$row->dresept_tambahan;?></td>
			<td height="20px" width="30px"align="right"><?=$row->dresept_jumlah;?>&nbsp;</td>
			<td height="20px" width="40px" align="left"><?=$row->dresept_satuan;?></td>
		</tr>
		<?php }
		?>
		
		
		
		<?php
		
		$i=0;
		?>
		<tr><td colspan="3">
		<?
		//print "<b><font size=medium> R/ </font></b>";
		?></td></tr>
		<tr><td align="center"></td><td align="center"></td><td align="center"></td></tr>
		<?
		foreach($detail_resepdokter_racikan as $list => $row) { $i+=1;?>
        <tr>
			<td height="20px" width="300x"> <?=$row->rkombinasi_keterangan;?></td>
		</tr>
		<?php }
		?>

      </table>
	  </td>
  </tr>
  <tr>
  </tr>
</table>
<br>
<br>
<br>
<br>

<table width="350"border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="20px">&nbsp;</td>
          <td width="50px"><?=$resep_no;?></td>
          <td width="10px">&nbsp;</td>
    
        <tr>
          <td>&nbsp;</td>
          <td><?=$resep_cust_manual;?></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
		  <br>
          <td><?=$cust_alamat;?></td>
          <td>&nbsp;</td>
        </tr>
      </table>
</body>
</html>