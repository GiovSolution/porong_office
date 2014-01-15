<?php
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: Penjualan Print
	+ Description	: For Print View
	+ Filename 		: p_detail_order.php
 	+ Author  		: 
 	+ Created on 01/Feb/2010 14:30:05
	
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Laporan Detail Penyesuaian Stok <?php echo $periode; ?> Group By Tanggal</title>
<link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle.css'/>
</head>
<body onload="window.print();">
<table summary='Detail Jual'>
	<caption>Laporan Detail Penyesuaian Stok <br/><?php echo $periode; ?><br/>Group By Tanggal</caption>
	<thead>
    	<tr>
        	<th scope='col'>No</th>
            <th scope='col'>No Bukti</th>
            <th scope='col'>Gudang</th>
            <th scope='col'>Nama Barang</th>
            <th scope='col'>Satuan</th>
            <th scope='col'>Jumlah Awal</th>
            <th scope='col'>Jumlah Koreksi</th>
            <th scope='col'>Jumlah Saldo</th>
        </tr>
    </thead>
	<tbody>
		        
        	<?php $i=0; $j=0; $group=""; 
					$total_awal=0;
					$total_koreksi=0;
					$total_saldo=0;

				foreach($data_print as $print) { 
						
			?>
			<?php if($group!==$print->tanggal) { ?>
           <tr>
                <td><b><? $j++; echo $j; ?></b></td>
                <td colspan="7"><b><?php echo $print->tanggal; ?></b></td>
           </tr>
           <?php 	
		   			$sub_awal=0;
					$sub_koreksi=0;
					$sub_saldo=0;
					$i=0; 
			?>
           <?php foreach($data_print as $print_list) {  ?>
           <?php if($print_list->tanggal==$print->tanggal){ $i++;
		   			$sub_awal+=$print_list->dkoreksi_jmlawal;
					$sub_koreksi+=$print_list->dkoreksi_jmlkoreksi;
					$sub_saldo+=$print_list->dkoreksi_jmlsaldo;
		
					$total_awal+=$print_list->dkoreksi_jmlawal;
					$total_koreksi+=$print_list->dkoreksi_jmlkoreksi;
					$total_saldo+=$print_list->dkoreksi_jmlsaldo;

		   ?>
            <tr>
                <td><? echo $i; ?></td>
                <td><?php echo $print_list->no_bukti;?></td>
                <td><?php echo $print_list->gudang_nama;?></td>
                <td><?php echo $print_list->produk_nama."(".$print_list->produk_kode.")";?></td>
                <td><?php echo $print_list->satuan_nama; ?></td>
                <td class="numeric"><?php echo number_format($print_list->dkoreksi_jmlawal,2,",","."); ?></td>
                <td class="numeric"><?php echo number_format($print_list->dkoreksi_jmlkoreksi,2,",","."); ?></td>
                <td class="numeric"><?php echo number_format($print_list->dkoreksi_jmlsaldo,2,",","."); ?></td>
           </tr>
           <?php } ?>
           <?php } ?>
           <tr>
                <td colspan="5">&nbsp;</td>
                <td align="right" class="numeric"><b><?php echo number_format($sub_awal,2,",","."); ?></b></td>
                <td align="right" class="numeric"><b><?php echo number_format($sub_koreksi,2,",","."); ?></b></td>
                <td align="right" class="numeric"><b><?php echo number_format($sub_saldo,2,",","."); ?></b></td>
           </tr>
           <?php } $group=$print->tanggal; ?>
		<?php 
			
		
		} ?>
        
	</tbody>
    <tfoot>
    	<tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Total</th>
            <td colspan='8'><?php echo count($data_print); ?> data</td>
        </tr>
        <tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row' colspan="9">Summary</th>
        </tr>
        <tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Total Jumlah Awal</th>
            <td class="numeric clear" nowrap="nowrap"><?php echo number_format($total_awal,2,",","."); ?></td>
            <td colspan="7" class="clear">&nbsp;</td>
        </tr>
        <tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Total Jumlah Koreksi</th>
            <td class="numeric clear" nowrap="nowrap"><?php echo number_format($total_koreksi,2,",","."); ?></td>
            <td colspan="7" class="clear">&nbsp;</td>
        </tr>
        <tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Total Jumlah Saldo</th>
            <td class="numeric clear" nowrap="nowrap" ><?php echo number_format($total_saldo,2,",","."); ?></td>
            <td colspan="7" class="clear">&nbsp;</td>
        </tr>       
	</tfoot>
</table>
</body>
</html>