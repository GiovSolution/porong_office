<?php
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: Penjualan Print
	+ Description	: For Print View
	+ Filename 		: p_detail_jual.php
 	+ Author  		: 
 	+ Created on 01/Feb/2010 14:30:05
	
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Laporan Tindakan Non Medis <?php echo $periode; ?> Group By Customer</title>
<link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle.css'/>
</head>
<body onload="window.print();">
<table summary='Detail Jual'>
	<caption>Laporan Tindakan Non Medis <br/><?php echo $periode; ?><br/>Group By Customer</caption>
	<thead>
    	<tr>
        	<th scope='col'>No</th>
			<th scope='col'>Tanggal</th>
            <th scope='col'>Perawatan</th>
			<th scope='col'>Jml</th>
			<th scope='col'>Terapis</th>
            <th scope='col'>Status</th>
            <th scope='col'>Jam App</th>
            <th scope='col'>Keterangan</th>
        </tr>
    </thead>
	
	<tbody>
		        
        <?php $i=0; $j=0; $tanggal=""; 
		
		
			foreach($data_print as $print) { ?>
			<?php if($tanggal!==$print->trawat_cust) { ?>
           <tr>
                <td><b><? $j++; echo $j; ?></b></td>
                <td colspan="6"><b><?php echo $print->cust_nama." (".$print->cust_no.")";?></b></td>
           </tr>
           <?php 	
					$i=0; 
			?>
           <?php foreach($data_print as $print_list) {  ?>
           <?php if($print_list->trawat_cust==$print->trawat_cust){ $i++;
		   			
		   ?>
            <tr>
                <td><? echo $i; ?></td>
                <td><?php echo $print_list->dtrawat_tglapp; ?></td>
                <td><?php echo $print_list->rawat_nama; ?></td>
				<td><?php echo $print_list->dtrawat_jumlah; ?></td>
				<td><?php echo $print_list->terapis_nama; ?></td>
                <td><?php echo $print_list->dtrawat_status; ?></td>
                <td><?php echo $print_list->dtrawat_jam; ?></td>
                <td><?php echo $print_list->dtrawat_keterangan; ?></td>
           </tr>
           <?php } ?>
           <?php } ?>
           <tr>
                <td align="right" colspan="2"><b>Total</td>
                <td align="right" class="numeric"><b><?php echo $i." data"; ?></b></td>
                <td align="right" colspan="4">&nbsp;</td>
           </tr>
           <?php } $tanggal=$print->trawat_cust; ?>
		<?php } ?>
        
	</tbody>
    <tfoot>
    	<tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Jumlah data</th>
            <td colspan='5'><?php echo count($data_print); ?> data</td>
        </tr>
	</tfoot>
</table>
</body>
</html>