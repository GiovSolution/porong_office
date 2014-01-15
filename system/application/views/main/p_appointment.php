<?php
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: inbox Print
	+ Description	: For Print View
	+ Filename 		: p_appointment.php
 	+ Author  		: 
 	+ Created on 26/Oct/2010 14:30:05
	
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Daftar Appointment</title>
<link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle.css'/>
</head>
<body onload="window.print();">
<table summary='Inbox List'>
	<caption>Daftar Appointment</caption>
	<thead><tr><th scope='col'>No</th>
	<th scope='col'>Tgl App</th>
	<th scope='col'>Jam App</th>
	<th scope='col'>Perawatan</th>
	<th scope='col'>No. Customer</th>
	<th scope='col'>Customer</th>
	<th scope='col'>Dokter</th>
	<th scope='col'>Terapis</th>
	<th scope='col'>Status</th>
    <th scope='col'>Jam Dtg</th>
    <th scope='col'>Keterangan</th></tr></thead>
	<tfoot><tr><th scope='row'>Total</th><td colspan='10'><?php echo count($data_print); ?></td></tr></tfoot>
	<tbody>
		<?php $i=0; foreach($data_print as $print) { $i++; ?>
		<tr><td><? echo $i; ?></td><td><?php echo $print->dapp_tglreservasi; ?></td><td><?php echo $print->dapp_jamreservasi; ?></td><td><?php echo $print->rawat_nama ?></td><td><?php echo $print->cust_no; ?></td><td><?php echo $print->cust_nama; ?></td><td><?php echo $print->dokter_username; ?></td><td><?php echo $print->terapis_username; ?></td><td><?php echo $print->dapp_status; ?></td><td><?php echo $print->dapp_jamdatang; ?></td><td><?php echo $print->dapp_keterangan; ?></td></tr>
		<?php } ?>
	</tbody>
</table>
<body onload='window.print()'>
</body>
</html>