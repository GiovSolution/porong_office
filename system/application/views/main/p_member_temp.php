<?php
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: inbox Print
	+ Description	: For Print View
	+ Filename 		: p_inbox.php
 	+ Author  		: 
 	+ Created on 01/Feb/2010 14:30:05
	
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Formulir Pendaftaran Miracle Member Card <?=$cabang_kota;?></title>
</head>
<body onload="window.print();">

<? foreach($data_print as $print) { 
	$koma1 = '';
	$koma2 = '';
	if ($print->cust_telprumah2 <> '')
		$koma1 = ', ';
	if ($print->cust_telpkantor <> '')
		$koma2 = ', ';
	$koma3 = '';
	$koma4 = '';	
	if ($print->cust_hp2 <> '')
		$koma3 = ', ';
	if ($print->cust_hp3 <> '')
		$koma4 = ', ';
?>
<table border="0" width="700">
		<tr>
			<td width="20"></td>
			<td align="center" colspan="4"><font size="5px"><b><br>Formulir Pendaftaran Miracle Member Card </b></td>
		</tr>
		<tr>
			<td width="20"></td>
			<td colspan="4"><br><br><b><?php echo $print->cust_no; ?></td>
		</tr>
		<tr>
			<td width="20"></td>
			<td colspan="4"><br><br>Pelanggan yang terhormat, terimakasih atas kesediaannya untuk memeriksa kembali data Anda:</td>
		</tr>
		<tr>
			<td width="20"></td>
			<td width="30" height="40"></td>
			<td width="100">Nama Lengkap</td>
			<td width="30">:</td>
			<td width="200"><?php echo $print->cust_nama; ?></td>
		</tr>
		<tr>
			<td width="20"></td>
			<td width="30" height="40"></td>
			<td width="100">Alamat</td>
			<td width="30">:</td>
			<td width="200"><?php echo $print->cust_alamat; ?></td>
		</tr>
		<tr>
			<td width="20"></td>
			<td width="30" height="40"></td>
			<td width="100">Kota</td>
			<td width="30">:</td>
			<td width="200"><?php echo $print->cust_kota; ?></td>
		</tr>
		<tr>
			<td width="20"></td>
			<td width="30" height="40"></td>
			<td width="100">Telp Rumah :</td>
			<td width="30">:</td>
			<td width="200">
				<?php echo $print->cust_telprumah.$koma1.$print->cust_telprumah2.$koma2. $print->cust_telpkantor; ?></td>
		</tr>
		<tr>
			<td width="20"></td>
			<td width="30" height="40"></td>
			<td width="100">HP</td>
			<td width="30">:</td>
			<td width="200"><?php echo $print->cust_hp.$koma3.$print->cust_hp2.$koma4.$print->cust_hp3; ?></td>
		</tr>
		<tr>
			<td width="20"></td>
			<td colspan="4"><br><br>Jika ada kesalahan pada data di atas, mohon dapat mengisikan data baru Anda di bawah ini:</td>
		</tr>
		<tr>
			<td width="20"></td>
			<td width="30" height="40"></td>
			<td width="100">Nama Lengkap</td>
			<td width="30">:</td>
			<td width="200"><?php echo '____________________________________________________' ?></td>
		</tr>
		<tr>
			<td width="20"></td>
			<td width="30" height="40"></td>
			<td width="100">Alamat</td>
			<td width="30">:</td>
			<td width="200"><?php echo '____________________________________________________' ?></td>
		</tr>
		<tr>
			<td width="20"></td>
			<td width="30" height="40"></td>
			<td width="100">Kota</td>
			<td width="30">:</td>
			<td width="200"><?php echo '____________________________________________________' ?></td>
		</tr>
		<tr>
			<td width="20"></td>
			<td width="30" height="40"></td>
			<td width="100">Telp Rumah :</td>
			<td width="30">:</td>
			<td width="200">
				<?php echo '____________________________________________________'?></td>
		</tr>
		<tr>
			<td width="20"></td>
			<td width="30" height="40"></td>
			<td width="100">HP</td>
			<td width="30">:</td>
			<td width="200"><?php echo '____________________________________________________' ?></td>
		</tr>
		<tr>
			<td width="20"></td>
			<td colspan="4"><br><br>Bersama ini saya menyatakan bahwa data di atas sudah sesuai dengan data personal saya dan saya menyetujui untuk didaftarkan sebagai member dari Miracle Aesthetic Clinic.</td>
		</tr>
		<tr>
			<td width="20"></td>
			<td colspan="4"><br><br><br><?=$cabang_kota;?>, .................................</td>
		</tr>
		<tr>
			<td width="20"></td>
			<td colspan="4"><br><br><br><br>(_______________________________)</td>
		</tr>
		<tr>
			<td width="20"></td>
			<td colspan="4" align="right"><br><font size="2px"><i>Printed on : <? echo date('d-m-y H:i:s')?></td>
		</tr>
		
		
</table>
<? } ?>
</body>
</html>