<?php
/* 	
	+ Module  		: Penjualan Print
	+ Description	: For Print View
	+ Filename 		: p_rekap_jual.php
 	+ Author  		:  Fred and Isaac
	
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Laporan Detail Mutasi <?php echo $jenis; ?> <?php echo $periode; ?> Group By Produk Racikan</title>
<link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle.css'/>
</head>
<body onload="window.print();">
<table summary='Rekap Jual'>
	<caption>Laporan Detail Mutasi <br/><?php echo $periode; ?><br/>Group By Produk Racikan</caption>
	<thead>
    	<tr>
        	<th scope='col'>No</th>   
            <th scope='col'>Tanggal</th>
            <th scope='col'>No Bukti</th>     
            <th scope='col'>Asal Gudang</th>
            <th scope='col'>Tujuan Gudang</th>
            <th scope='col'>Satuan</th>
			<th scope='col'>Mutasi In</th>
			<th scope='col'>Mutasi Out</th>
        </tr>
    </thead>
	<tbody>
		<?php 	$i=0; 
				$j=0;
				$tanggal=""; 
				$total_item_in=0;
				$total_item_out=0;
				$sub_total=0;
				$group="";
			foreach($data_print as $printgroup) { ?>
			
			<?php if($group!==$printgroup->produk_id) { ?>
           <tr>
                <td><b><? $j++; echo $j; ?></b></td>
                <td colspan="6"><b><?php echo $printgroup->produk_nama;?></b></td>
           </tr>		
       <?
	   	$sub_total_in=0;
		$sub_total_out=0;
		$i=0;
		foreach($data_print as $print) { 
				
			if($print->produk_id==$printgroup->produk_id){  
				$sub_total_in+=$print->jumlah_in;
				$sub_total_out+=$print->jumlah_out;				
				$total_item_in+=$print->jumlah_in;	
				$total_item_out+=$print->jumlah_out;
				$i++; 
		?>
		<tr>
        	<td><? echo $i; ?></td>
            <td><?php echo $print->mutasi_tanggal; ?></td>
            <td><?php echo $print->mutasi_no; ?></td>
            <td><?php echo $print->gudang_asal; ?></td>
            <td><?php echo $print->gudang_tujuan; ?></td>
            <td><?php echo $print->satuan_nama; ?></td>
			<td align="right" class="numeric"><?php echo number_format($print->jumlah_in,0,",","."); ?></td>
			<td align="right" class="numeric"><?php echo number_format($print->jumlah_out,0,",","."); ?></td>
       </tr>
		<?php }
			}
			?>
        <tr>
        	<td scope='row'>&nbsp;</th>
            <td scope='row'>&nbsp;</th>
            <td scope='row'>&nbsp;</th>
			<td>&nbsp;</td>
			<td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right" class="numeric"><b><?php echo number_format($sub_total_in,0,",","."); ?></b></td>
			<td align="right" class="numeric"><b><?php echo number_format($sub_total_out,0,",","."); ?></b></td>
        </tr>
		<?php 
			}
			$group=$printgroup->produk_id;
			}
			
			?>
	</tbody>
    	<tfoot>
    	<tr>
        	<td class="clear">&nbsp;</td>
            <td class="clear">&nbsp;</td>
        	<th scope='row'>Jumlah data</th>
			<td><?php echo count($data_print); ?> data</td>
			<td align="right" colspan="2"><b>Grand TOTAL</b></td>
            <td align="right" class="numeric"><b><?php echo number_format($total_item_in,0,",","."); ?></b></td>
			<td align="right" class="numeric"><b><?php echo number_format($total_item_out,0,",","."); ?></b></td>
        </tr>
	</tfoot>
</table>
</body>
</html>