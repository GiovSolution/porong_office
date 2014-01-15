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
<title>List Pesanan Pembelian</title>
<link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle.css'/>
</head>
<body onload="window.print();">
<table summary='Rekap Jual'>
	<caption>List Pesanan Pembelian</caption>
	<thead>
    	<tr>
        	<th scope='col'>No</th>
            <th scope='col'>Tanggal</th>
            <th scope='col'>No OP</th>           
            <th scope='col'>Supplier</th>
            <th scope='col'>Jumlah Item</th>
            <th scope='col'>Cara Bayar</th>
			<th scope='col'>Keterangan</th>
        </tr>
    </thead>
	<tbody>
		<?php $i=0; $tanggal=""; 
				$total_item=0;
				
		foreach($data_print as $print) { 
				$total_item+=$print->jumlah_barang;		
				$i++; 
		?>
		<tr>
        	<td><? echo $i; ?></td>
            <td ><?php echo $print->tanggal; ?></td>
            <td ><?php echo $print->no_bukti; ?></td>
            <td><?php echo $print->supplier_nama; ?></td>
			<td align="right" class="numeric"><?php echo number_format($print->jumlah_barang); ?></td>
            <td><?php echo $print->order_carabayar; ?></td>
            <td><?php echo $print->order_keterangan; ?></td>
       </tr>
		<?php } ?>
	</tbody>
    	<tfoot>
    	<tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row'>Jumlah data</th>
			<td><?php echo count($data_print); ?> data</td>
			<td align="right"><b>Grand TOTAL</b></td>
            <td align="right" class="numeric"><b><?php echo number_format($total_item); ?></b></td>
            <td align="right" colspan="2">&nbsp;</td>
        </tr>
	</tfoot>
</table>
</body>
</html>