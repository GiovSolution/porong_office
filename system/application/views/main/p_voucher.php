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
<title>History Point</title>
<link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle.css'/>
</head>
<body onload="window.print();">
<table summary='Daftar Promo'>
    <thead>
    	<tr>
    	<td colspan="8" nowrap="nowrap">
        	<div style="float:left; margin-left:10px; margin-top:5px;" > 
             <center><b>
             <h1>History Penukaran Poin</h1></b></center>
            </div>
        </td>
        </tr>
    </thead>
	<thead>
    	<tr>
        	<th scope='col'>No</th>
        	<th scope='col'>No Voucher</th>
            <th scope='col'>Poin</th>
            <th scope='col'>Nilai (Rp)</th>
            <th scope='col'>Kadaluarsa</th>
            <th scope='col'>No Member</th>
            <th scope='col'>Jenis Transaksi</th>
        </tr>
    </thead>
	<tbody>
		<?php $i=0; foreach($data_print as $print) { $i++; ?>
		<tr>
        	<td><? echo $i; ?></td>
            <td><?php echo $print->voucher_no; ?></td>
            <td class="numeric"><?php echo number_format($print->voucher_point); ?></td>
            <td class="numeric"><?php echo number_format($print->voucher_cashback); ?></td>
            <td><?php echo $print->voucher_kadaluarsa; ?></td>
            <td><?php echo $print->voucher_cust; ?></td>
            <td><?php echo $print->voucher_nama; ?></td>
        </tr>
		<?php } ?>
	</tbody>
    <tfoot><tr><th scope='row'>Total</th><td colspan='15'><?php echo count($data_print); ?></td></tr></tfoot>
</table>
</body>
</html>