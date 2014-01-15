<?php
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: vu_stok_all_saldo Print
	+ Description	: For Print View
	+ Filename 		: p_vu_stok_all_saldo.php
 	+ Author  		: 
 	+ Created on 09/Apr/2010 10:47:15
	
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Vu Stok All Saldo List</title>
<link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle.css'/>
</head>
<table summary='Vu Stok All Saldo List'>
	<caption>Vu Stok All Saldo List</caption>
	<thead><tr><th scope='col'>No</th><th scope='col'>Produk Id</th><th scope='col'>Produk Nama</th><th scope='col'>Satuan Id</th><th scope='col'>Satuan Nama</th><th scope='col'>Stok Saldo</th></tr></thead>
	<tfoot><tr><th scope='row'>Total</th><td colspan='5'><?php echo count($data_print); ?></td></tr></tfoot>
	<tbody>
		<?php $i=0; foreach($data_print as $print) { $i++; ?>
		<tr><td><? echo $i; ?></td><td><?php echo $print->produk_id; ?></td><td><?php echo $print->produk_nama; ?></td><td><?php echo $print->satuan_id; ?></td><td><?php echo $print->satuan_nama; ?></td><td><?php echo $print->stok_saldo; ?></td></tr>
		<?php } ?>
	</tbody>
<body onload='window.print()'>
</body>
</html>