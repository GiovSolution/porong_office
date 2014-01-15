<?php
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	
	+ Module  		: Lap Jum Tindakan Dokter Print
	+ Description	: For Print View
	+ Filename 		: p_lap_sum_all_dokter.php
 	+ Author  		: Natalie
 	+ Created on 08/Mar/2012 
*/
?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
	<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />
	<title>Printing the Tindakan Grid</title>
	<link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle.css'/>
</head>
<body onload='window.print()'>
<table summary='All Produk'>
	<caption>LAPORAN JUMLAH PENJUALAN SEMUA PRODUK</caption>
		<thead>
			<tr>
				<th scope='col'>No</th>
				<th scope='col'>Kode</th>
				<th scope='col'>Produk</th><?php echo $list_dokter; ?>
			</tr>
		</thead>
<tbody>
	<?
	$j = 0;
	//print_r($data_print1);
	foreach($data_print1 as $data){ ?>
	<tr>
	<? $j=$j+1;?>
	<td><? echo $j; ?></td>
	<td><? echo $data->produk_kode; ?></td>
	<td><? echo $data->produk_nama; ?></td>
	<td align='right' class='numeric'>
	<?
		for ($i=0; $i<$numrows_dokter; $i++) {
				$nama_param = 'tjjp_ref'.$i;
				echo $data->$nama_param;
				?></td><td align='right' class='numeric'><?
		}
	?>
	<? //echo $data->$nama_param; ?></td>
	<td align='right' class='numeric'></td>
	</tr>
	<? } ?>
</tbody>
<tfoot>
	<tr>
		<th>Total</th>
		<td colspan='2'><? echo ' '.$j. ' data'; ?></td>
		<td align='right' class='numeric'>
		<?//print_r($data_print2);?>
		<? for ($i=0; $i<$numrows_dokter; $i++) {
			$nama_param = 'tjjp_total_ref'.$i;
			echo $data_print2[0]->$nama_param;
			?> </td><td align='right' class='numeric'> <?
		} ?>
		</td>
		<td align='right' class='numeric'></td>
	</tr>
</tfoot>
</table>
</body>
</html>