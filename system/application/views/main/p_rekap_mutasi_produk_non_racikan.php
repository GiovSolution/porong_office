<?php
/* 	
	
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Laporan Rekap Mutasi Barang <?php echo $jenis; ?> <?php echo $periode; ?> Group By Produk Non Racikan(Gudang Retail)</title>
<link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle.css'/>
</head>
<body onload="window.print();">
<table summary='Rekap Jual'>
	<caption>Laporan Rekap Mutasi Barang<br/><?php echo $periode; ?><br/>Group By Produk Non Racikan(Gudang Retail)</caption>
	<thead>
    	<tr>
        	<th scope='col'>No</th>   
            <th scope='col'>Kode Produk</th>
            <th scope='col'>Nama Produk</th>     
            <th scope='col'>Volume</th>
            <th scope='col'>Satuan</th>
            <th scope='col'>Mutasi In(qty)</th>
			<th scope='col'>Mutasi Out(qty)</th>
        </tr>
    </thead>
	<tbody>
		<?php 	$i=0; 
				$j=0;
				$tanggal=""; 
				$total_item=0;
				$sub_total=0;
				$group="";
			foreach($data_print as $printgroup) { ?>
			
			<?php if($group!=$printgroup->produk_id) { ?>
       	
       <?
		$i=0;
		foreach($data_print as $print) { 
				
			if($print->produk_id==$printgroup->produk_id){  
				$sub_total+=$print->jumlah_in;		
				$total_item+=$print->jumlah_out;	
				$i++; 
		?>
		<tr>
        	<td><? echo $i; ?></td>
            <td><?php echo $print->produk_kode; ?></td>
            <td><?php echo $print->produk_nama; ?></td>
            <td><?php echo $print->produk_volume; ?></td>
            <td><?php echo $print->satuan_nama; ?></td>
			<td align="right" class="numeric"><?php echo number_format($print->jumlah_in,0,",","."); ?></td>
			<td align="right" class="numeric"><?php echo number_format($print->jumlah_out,0,",","."); ?></td>
       </tr>
		<?php }
			}
			?>

		<?php 
			}
			$group=$printgroup->produk_id;
			}
			
			?>
	</tbody>
    	<tfoot>
    	<tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row'>Jumlah data</th>
			<td><?php echo count($data_print); ?> data</td>
			<td align="right" colspan="2"><b>Grand TOTAL</b></td>
			<td align="right" class="numeric"><b><?php echo number_format($sub_total,0,",","."); ?></b></td>
            <td align="right" class="numeric"><b><?php echo number_format($total_item,0,",","."); ?></b></td>
            <td align="right" class="numeric"></td>
        </tr>
	</tfoot>
</table>
</body>
</html>