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
<title>Daftar Kode Akun</title>
<link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle.css'/>
</head>
<body onload="window.print();">
<table summary='Daftar Akun'>
    <thead>
    	<tr>
    	<td colspan="8" nowrap="nowrap">
        	<div style="float:left; margin-left:10px; margin-top:5px;" > 
             <center><b><h1>Kode Akun</h1></b></center>
            </div>
        </td>
        </tr>
    </thead>
	<thead>
    	<tr>
        	<th scope='col'>No</th>
            <th scope='col'>Kode</th>
            <th scope='col'>Nama</th>
            <th scope='col'>Debet</th>
            <th scope='col'>Kredit</th>
            <th scope='col'>Saldo</th>
            <th scope='col'>Jenis</th>
            <th scope='col'>Aktif</th>
        </tr>
    </thead>
	<tbody>
		<?php $i=0; foreach($data_print as $print) { $i++; ?>
		<tr>
        	<td><? echo $i; ?></td>
            <td><?php echo $print->akun_kode; ?></td>
            <td><?php echo str_repeat("-",$print->akun_level)." ".$print->akun_nama; ?></td>
            <td><?php echo $print->akun_debet; ?></td>
            <td><?php echo $print->akun_kredit; ?></td>
            <td><?php echo $print->akun_saldo; ?></td>
            <td><?php echo $print->akun_jenis; ?></td>
            <td><?php echo $print->akun_aktif=='Y'?'Ya':'Tidak'; ?></td>
        </tr>
		<?php } ?>
	</tbody>
    <tfoot><tr><th scope='row'>Total</th><td colspan='15'><?php echo count($data_print); ?></td></tr></tfoot>
</table>
</body>
</html>