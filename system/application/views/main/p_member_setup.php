<?php
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: member_setup Print
	+ Description	: For Print View
	+ Filename 		: p_member_setup.php
 	+ Author  		: 
 	+ Created on 06/Apr/2010 12:55:05
	
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Member Setup List</title>
<link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle.css'/>
</head>
<table summary='Member Setup List'>
	<caption>Member Setup List</caption>
	<thead><tr><th scope='col'>No</th><th scope='col'>Setmember Id</th><th scope='col'>Setmember Transhari</th><th scope='col'>Setmember Transbulan</th><th scope='col'>Setmember Periodeaktif</th><th scope='col'>Setmember Periodetanggang</th><th scope='col'>Setmember Transharitenggang</th><th scope='col'>Setmember Author</th><th scope='col'>Setmember Date Create</th><th scope='col'>Setmember Update</th><th scope='col'>Setmember Date Update</th><th scope='col'>Setmember Revised</th></tr></thead>
	<tfoot><tr><th scope='row'>Total</th><td colspan='11'><?php echo count($data_print); ?></td></tr></tfoot>
	<tbody>
		<?php $i=0; foreach($data_print as $print) { $i++; ?>
		<tr><td><? echo $i; ?></td><td><?php echo $print->setmember_id; ?></td><td><?php echo $print->setmember_transhari; ?></td><td><?php echo $print->setmember_transbulan; ?></td><td><?php echo $print->setmember_periodeaktif; ?></td><td><?php echo $print->setmember_periodetanggang; ?></td><td><?php echo $print->setmember_transharitenggang; ?></td><td><?php echo $print->setmember_author; ?></td><td><?php echo $print->setmember_date_create; ?></td><td><?php echo $print->setmember_update; ?></td><td><?php echo $print->setmember_date_update; ?></td><td><?php echo $print->setmember_revised; ?></td></tr>
		<?php } ?>
	</tbody>
<body onload='window.print()'>
</body>
</html>