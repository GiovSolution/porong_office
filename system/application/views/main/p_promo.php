<?php
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: akun Print
	+ Description	: For Print View
	+ Filename 		: p_akun.php
 	+ Author  		: Zainal, Anam
 	+ Created on 12/Mar/2010 10:42:59
	
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Daftar Promo</title>
<link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle.css'/>
</head>
<body onload="window.print();">
<table summary='Daftar Promo'>
    <thead>
    	<tr>
    	<td colspan="8" nowrap="nowrap">
        	<div style="float:left; margin-left:10px; margin-top:5px;" > 
             <center><b>
             <h1>Promo</h1></b></center>
            </div>
        </td>
        </tr>
    </thead>
	<thead>
    	<tr>
        	<th scope='col'>No</th>
            <th scope='col'>Acara</th>
            <th scope='col'>Tempat</th>
            <th scope='col'>Tanggal Mulai</th>
            <th scope='col'>Tanggal Selesai</th>
            <th scope='col'>Keterangan</th>
        </tr>
    </thead>
	<tbody>
		<?php $i=0; foreach($data_print as $print) { $i++; ?>
		<tr>
        	<td><? echo $i; ?></td>
            <td><?php echo $print->promo_acara; ?></td>
            <td><?php echo $print->promo_tempat; ?></td>
            <td><?php echo $print->promo_tglmulai; ?></td>
            <td><?php echo $print->promo_tglselesai; ?></td>
            <td><?php echo $print->promo_keterangan; ?></td>
        </tr>
		<?php } ?>
	</tbody>
    <tfoot><tr><th scope='row'>Total</th><td colspan='15'><?php echo count($data_print); ?></td></tr></tfoot>
</table>
</body>
</html>