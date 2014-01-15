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
<title>Kartu Stok <?php echo @$produk_nama; ?>, di <?php echo @$gudang_nama; ?>, Periode <?php echo @$periode; ?></title>
<link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle.css'/>
</head>
<body onload="window.print();">
<table summary='Rekap Jual'>
	<caption>Kartu Stok <?php echo @$produk_nama; ?><br/><?php echo @$gudang_nama; ?><br/> Periode <?php echo @$periode; ?></caption>
	<thead>
    	<tr>
        	<th scope='col'>No</th>
            <th scope='col'>Tanggal</th>           
            <th scope='col'>No Bukti</th>
            <th scope='col'>Keterangan</th>
            <th scope='col'>Masuk</th>
			<th scope='col'>Keluar</th>
        </tr>
    </thead>
	<tbody>
		<?php $i=0; $tanggal=""; $total_masuk=0; $total_keluar=0; foreach($data_print as $print) { $i++; ?>		
		<tr>
        	<td><? echo $i; ?></td>
            <td width="10"><?php echo $print->tanggal; ?></td>
            <td><?php echo $print->no_bukti; ?></td>
			<td><?php echo $print->keterangan; ?></td>
            <td align="right" class="numeric"><?php echo number_format($print->masuk,2); ?></td>
			<td align="right" class="numeric"><?php echo number_format($print->keluar,2); ?></td>
       </tr>
		<?php 
		$total_masuk+=($print->masuk);
		$total_keluar+= ($print->keluar);
		} ?>
		
	</tbody>
    <tfoot>
    	<tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row'>Jumlah data</th>
			<td colspan="4"><?php echo count($data_print); ?> data</td>
        </tr>
       		<td align="right"><b>Summary</b></td>
         	<td colspan="5" class="clear">&nbsp; </td>
        <tr>
        <tr>
        	<td> Saldo Awal </td>
         	<td align="right" class="numeric"><b><?php echo number_format($saldo_awal,2); ?></b></td>
            <td colspan="4" class="clear">&nbsp; </td>
        </tr>  
        <tr>
        	<td> Jumlah Masuk </td>
         	<td align="right" class="numeric"><b><?php echo number_format($total_masuk,2); ?></b></td>
            <td colspan="4" class="clear">&nbsp; </td>
        </tr>
        <tr>
        	<td> Jumlah Keluar </td>
         	<td align="right" class="numeric"><b><?php echo number_format($total_keluar,2); ?></b></td>
            <td colspan="4" class="clear">&nbsp; </td>
        </tr>
        <tr>
        	<td> Saldo Akhir </td>
         	<td align="right" class="numeric"><b><?php echo number_format(@$saldo_awal+$total_masuk-$total_keluar,2); ?></b></td>
            <td colspan="4" class="clear">&nbsp; </td>
        </tr>
	</tfoot>
</table>
</body>
</html>