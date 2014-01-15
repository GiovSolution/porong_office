<?php
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: inbox Print
	+ Description	: For Print View
	+ Filename 		: p_master_jual_produk.php
 	+ Author  		: 
 	+ Created on 26/Oct/2010 14:30:05
	<td><?php if ($print->no_cust[$i] == $print->no_cust[$i-1]) {echo "";} else {echo "";} ?></td>
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Daftar Kepemilikan Paket</title>
<link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle.css'/>
</head>
<body onload="window.print();">
<table summary='Inbox List'>
	<caption>Daftar Kepemilikan Paket</caption>
	<thead><tr><th scope='col'>No</th>
	<th scope='col'>No. Cust</th>
	<th scope='col'>Customer</th>
	<th scope='col'>Tgl Faktur</th>
	<th scope='col'>No. Faktur</th>
	<th scope='col'>Kode Paket</th>
	<th scope='col'>Nama Paket</th>
	<th scope='col'>Sisa</th>
	<th scope='col'>Tgl Kadaluarsa</th></tr></thead>
	<tfoot><tr><th scope='row'>Total</th><td colspan='8'><?php echo count($data_print); ?></td></tr></tfoot>
	<tbody>
		<?php $i=0; foreach($data_print as $print) { $i++; ?>
		<tr>
			<td><? echo $i; ?></td>
			<td><?php echo $print->no_cust; ?></td>
			<td><?php echo $print->customer; ?></td>
			<td><?php echo $print->tanggal_faktur; ?></td>
			<td><?php echo $print->no_faktur; ?></td>
			<td><?php echo $print->kode_paket; ?></td>
			<td><?php echo $print->nama_paket; ?></td>
			<td><?php echo $print->sisa; ?></td>
			<td><?php echo $print->tgl_kadaluarsa; ?></td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<br>
<i>Printed on <?php echo date("d/m/y H:i:s"); ?> </i>
<body onload='window.print()'>
</body>
</html>