<?php
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: Penjualan Print
	+ Description	: For Print View
	+ Filename 		: p_rekap_jual.php
 	+ Author  		: 
 	+ Created on 01/Feb/2010 14:30:05
	
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Laporan  Pengunjung</title>
<link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle.css'/>
</head>
<table summary='Detail Pengunjung List'>
	<caption>Daftar Detail Pengunjung <?php echo $periode; ?></caption>
	<thead>
    	<tr>
        	<th scope='col'>No</th>
            <th width="70" scope='col'>Client Card</th>
            <th width="180" scope='col'>Nama Customer</th>
    	</tr>
	</thead>
	<tfoot><tr><th scope='row'>Total</th><td colspan="2" ><?php echo count($data_print); ?></td></tr></tfoot>
	<tbody>
		<?php $i=0; foreach($data_print as $print) { $i++; ?>
		<tr>
        	<td><? echo $i; ?></td>
            <td><?php echo $print->cust_no; ?></td>
            <td><?php echo $print->cust_nama; ?></td>
        </tr>
		<?php } ?>
	</tbody>
<body onload='window.print()'>
</body>
</html>