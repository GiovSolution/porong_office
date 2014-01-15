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
<title>Daftar Pengambilan Paket</title>
<link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle.css'/>
</head>
<body onload="window.print();">
<table summary='Inbox List'>
	<caption>Daftar Pengambilan Paket <br><?php echo $tgl_ambil;?>[<?php echo $paket_nobukti; ?>]<br><?php echo $cust_nama;?>-<?php echo $cust_no; ?><br><?php echo $paket_nama;?></caption>
	<thead><tr><th scope='col'>No</th>
	<th scope='col'>Tgl Ambil</th>
	<th scope='col'>Perawatan</th>
	<th scope='col'>Jumlah</th>
	<th scope='col'>Client Card</th>
	<th scope='col'>Pemakai</th>	
	<th scope='col'>Referal</th>
	<th scope='col'>Keterangan</th>
	<th scope='col'>Status</th>
	
</tr></thead>
	<tfoot><tr><th scope='row'>Total</th><td colspan='8'><?php echo count($data_print); ?></td></tr></tfoot>
	<tbody>
		<?php $i=0; foreach($data_print as $print) { $i++; ?>
		<tr>
			<td><? echo $i; ?></td>
			<td><?php echo $print->tanggal_ambil; ?></td>
			<td><?php echo $print->perawatan; ?></td>
			<td><?php echo $print->jumlah; ?></td>
			<td><?php echo $print->client_card; ?></td>
			<td><?php echo $print->customer; ?></td>
			<td><?php echo $print->referal; ?></td>
			<td><?php echo $print->keterangan; ?></td>
			<td><?php echo $print->status; ?></td>
			
		</tr>
		<?php } ?>
	</tbody>
</table>
<body onload='window.print()'>
</body>
</html>