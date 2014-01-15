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
<title>Laporan Detail Mutasi <?php echo $jenis; ?> <?php echo $periode; ?> Group By Produk</title>
<link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle.css'/>
</head>
<body onload="window.print();">
<table summary='Rekap Jual'>
	<caption>Laporan Detail Mutasi <br/><?php echo $periode; ?><br/>Group By Produk</caption>
	<thead>
    	<tr>
        	<th scope='col'>No</th>   
            <th scope='col'>Tanggal</th>
            <th scope='col'>No Bukti</th>     
            <th scope='col'>Asal Gudang</th>
            <th scope='col'>Tujuan Gudang</th>
            <th scope='col'>Satuan</th>
			<th scope='col'>Jumlah</th>
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
			
			<?php if($group!==$printgroup->dmutasi_produk) { ?>
           <tr>
                <td><b><? $j++; echo $j; ?></b></td>
                <td colspan="5"><b><?php echo $printgroup->produk_nama;?></b></td>
           </tr>		
       <?
	   	$sub_total=0;
		$i=0;
		foreach($data_print as $print) { 
				
			if($print->dmutasi_produk==$printgroup->dmutasi_produk){  
				$sub_total+=$print->dmutasi_jumlah;		
				$total_item+=$print->dmutasi_jumlah;	
				$i++; 
		?>
		<tr>
        	<td><? echo $i; ?></td>
            <td><?php echo $print->mutasi_tanggal; ?></td>
            <td><?php echo $print->mutasi_no; ?></td>
            <td><?php echo $print->gudang_asal_nama; ?></td>
            <td><?php echo $print->gudang_tujuan_nama; ?></td>
            <td><?php echo $print->satuan_nama; ?></td>
			<td align="right" class="numeric"><?php echo number_format($print->dmutasi_jumlah,0,",","."); ?></td>
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
            <td align="right" class="numeric"><b><?php echo number_format($sub_total,0,",","."); ?></b></td>
        </tr>
		<?php 
			}
			$group=$printgroup->dmutasi_produk;
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
            <td align="right" class="numeric"><b><?php echo number_format($total_item,0,",","."); ?></b></td>
        </tr>
	</tfoot>
</table>
</body>
</html>