<?php
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: akun_map Print
	+ Description	: For Print View
	+ Filename 		: p_akun_map.php
 	+ Author  		: 
 	+ Created on 06/Oct/2010 10:15:56
	
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Akun Map List</title>
<link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle.css'/>
</head>
<table summary='Akun Map List'>
	<caption>Akun Map List</caption>
	<thead><tr><th scope='col'>No</th><th scope='col'>Map Id</th><th scope='col'>Map Kategori</th><th scope='col'>Map Nama</th><th scope='col'>Map Akun</th><th scope='col'>Map Akun Kode</th><th scope='col'>Map Aktif</th><th scope='col'>Map Author</th><th scope='col'>Map Date Create</th><th scope='col'>Map Update</th><th scope='col'>Map Date Update</th><th scope='col'>Map Revised</th></tr></thead>
	<tfoot><tr><th scope='row'>Total</th><td colspan='11'><?php echo count($data_print); ?></td></tr></tfoot>
	<tbody>
		<?php $i=0; foreach($data_print as $print) { $i++; ?>
		<tr><td><? echo $i; ?></td><td><?php echo $print->map_id; ?></td><td><?php echo $print->map_kategori; ?></td><td><?php echo $print->map_nama; ?></td><td><?php echo $print->map_akun; ?></td><td><?php echo $print->map_akun_kode; ?></td><td><?php echo $print->map_aktif; ?></td><td><?php echo $print->map_author; ?></td><td><?php echo $print->map_date_create; ?></td><td><?php echo $print->map_update; ?></td><td><?php echo $print->map_date_update; ?></td><td><?php echo $print->map_revised; ?></td></tr>
		<?php } ?>
	</tbody>
<body onload='window.print()'>
</body>
</html>