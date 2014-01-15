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
<title>List Tagihan Pembelian</title>
<link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle.css'/>
</head>
<body onload="window.print();">
<table summary='Rekap Jual'>
	<caption>List Tagihan Pembelian</caption>
	<thead>
    	<tr>
        	<th scope='col'>No</th>
            <th scope='col'>Tanggal</th>
            <th scope='col'>No PT</th>  
            <th scope='col'>No Tagihan</th>  
            <th scope='col'>No PB</th>           
            <th scope='col'>Supplier</th>
            <th scope='col'>Jumlah Item</th>
            <th scope='col'>Sub Total (Rp)</th>
            <th scope='col'>Potongan Harga (Rp)</th>
            <th scope='col'>Diskon (%)</th>
            <th scope='col'>Biaya (Rp)</th>
            <th scope='col'>Uang Muka (Rp)</th>
            <th scope='col'>Total Tagihan (Rp)</th>
            <th scope='col'>Jatuh Tempo</th>
			<th scope='col'>Keterangan</th>
        </tr>
    </thead>
	<tbody>
		<?php $i=0; $tanggal=""; 
				$total_item=0;
				$total_potongan=0;
				$total_biaya=0;
				$total_uangmuka=0;
				$total_nilai=0;
				$total_tagihan=0;
				
		foreach($data_print as $print) { 
				$total_item+=$print->jumlah_barang;	
				$total_potongan+=$print->invoice_cashback;
				$total_biaya+=$print->invoice_biaya;
				$total_uangmuka+=$print->invoice_uangmuka;
				$total_nilai+=$print->total_nilai;
				$total_tagihan+= ($print->total_nilai+$print->invoice_biaya-$print->invoice_uangmuka-$print->invoice_cashback-($print->total_nilai*$print->invoice_diskon/100));
								
				$i++; 
		?>
		<tr>
        	<td><? echo $i; ?></td>
            <td ><?php echo $print->tanggal; ?></td>
            <td ><?php echo $print->no_bukti_auto; ?></td>
            <td ><?php echo $print->no_bukti; ?></td>
            <td ><?php echo $print->terima_no; ?></td>
            <td><?php echo $print->supplier_nama; ?></td>
			<td align="right" class="numeric"><?php echo number_format($print->jumlah_barang); ?></td>
            <td align="right" class="numeric"><?php echo number_format($print->total_nilai); ?></td>
            <td align="right" class="numeric"><?php echo number_format($print->invoice_cashback); ?></td>
             <td align="right" class="numeric"><?php echo number_format($print->invoice_diskon); ?></td>
            <td align="right" class="numeric"><?php echo number_format($print->invoice_biaya); ?></td>
            <td align="right" class="numeric"><?php echo number_format($print->invoice_uangmuka); ?></td>
            <td align="right" class="numeric"><?php echo number_format($print->total_nilai+$print->invoice_biaya-$print->invoice_uangmuka-$print->invoice_cashback-($print->total_nilai*$print->invoice_diskon/100)) ?></td>
            <td><?php echo $print->invoice_jatuhtempo; ?></td>
            <td><?php echo $print->invoice_keterangan; ?></td>
       </tr>
		<?php } ?>
	</tbody>
    	<tfoot>
    	<tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row' colspan="2">Jumlah data</th>
			<td><?php echo count($data_print); ?> data</td>
			<td align="right" colspan="2"><b>Grand TOTAL</b></td>
            <td align="right" class="numeric"><b><?php echo number_format($total_item); ?></b></td>
            <td align="right" class="numeric"><b><?php echo number_format($total_nilai); ?></b></td>
            <td align="right" class="numeric"><b><?php echo number_format($total_potongan); ?></b></td>
            <td>&nbsp;</td>
            <td align="right" class="numeric"><b><?php echo number_format($total_biaya); ?></b></td>
            <td align="right" class="numeric"><b><?php echo number_format($total_uangmuka); ?></b></td>
            <td align="right" class="numeric"><b><?php echo number_format($total_tagihan); ?></b></td>
            <td align="right" colspan="2">&nbsp;</td>
        </tr>
	</tfoot>
</table>
</body>
</html>