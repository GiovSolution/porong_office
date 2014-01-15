<?php
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: phonegroup Print
	+ Description	: For Print View
	+ Filename 		: p_phonegroup.php
 	+ Author  		: 
 	+ Created on 01/Feb/2010 14:30:05
	
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Laporan Net Sales <?php echo $periode; ?></title>
<link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle.css'/>
</head>
<body onload="window.print();">
<table summary='Laporan Penerimaan Kas'>
	<caption>Laporan Net Sales <br/> <?php echo $periode;  ?></caption>
	<thead>
    	<tr>
        	<th scope='col'>No</th>
			<th scope='col'>Tanggal</th>
            <th scope='col'>NS Medis</th>
            <th scope='col'>NS Non Medis</th>
			<th scope='col'>NS Surgery</th>
			<th scope='col'>NS Anti Aging</th>
            <th scope='col'>NS Produk</th>
            <th scope='col'>NS Lain-lain</th>
            <th scope='col'>Net Sales</th>
        </tr>
    </thead>
	<tbody>
		<?php 
			$ns_medis=0;
			$ns_non_medis=0;
			$ns_produk=0;
			$ns_anti_aging=0;
			$ns_lainlain=0;
			$ns_surgery=0;
			$net_sales=0;
			
			$tot_ns_medis=0;
			$tot_ns_non_medis=0;
			$tot_ns_produk=0;
			$tot_ns_anti_aging=0;
			$tot_ns_lainlain=0;
			$tot_ns_surgery=0;
			$tot_net_sales=0;
			
			$i=0; 
			foreach($jumlah_result as $print) { 
				$ns_medis=$print->tns_medis;
				$ns_non_medis=$print->tns_nonmedis;
				$ns_produk=$print->tns_produk;
				$ns_anti_aging=$print->tns_antiaging;
				$ns_lainlain=$print->tns_lainlain;
				$ns_surgery=$print->tns_surgery;
				$net_sales=$ns_medis+$ns_non_medis+$ns_produk+$ns_anti_aging+$ns_lainlain+$ns_surgery;
				
				$tot_ns_medis+=$print->tns_medis;
				$tot_ns_non_medis+=$print->tns_nonmedis;
				$tot_ns_produk+=$print->tns_produk;
				$tot_ns_anti_aging+=$print->tns_antiaging;
				$tot_ns_lainlain+=$print->tns_lainlain;
				$tot_ns_surgery+=$print->tns_surgery;
				$tot_net_sales+=$ns_medis+$ns_non_medis+$ns_produk+$ns_anti_aging+$ns_lainlain+$ns_surgery;
				$i++;
			
			
		?>
        <tr>
        	<td><? echo $i; ?></td>
			<td><? echo $print->tns_tanggal;; ?></td>
            <td  class="numeric"><?php echo number_format($ns_medis); ?></td>
            <td  class="numeric"><?php echo number_format($ns_non_medis); ?></td>
			<td  class="numeric"><?php echo number_format($ns_surgery); ?></td>
			<td  class="numeric"><?php echo number_format($ns_anti_aging); ?></td>
            <td  class="numeric"><?php echo number_format($ns_produk); ?></td>	
            <td  class="numeric"><?php echo number_format($ns_lainlain); ?></td>           
            <td  class="numeric"><?php echo number_format($net_sales); ?></td>
       </tr>
	   <? } ?>
        
	</tbody>
	<tfoot>
    	<tr>
        	<td class="clear" colspan="2"><b>Grand Total</td>
			<?/*<td><?php echo count($data_print); ?> data</td>*/?>
            <td align="right" class="numeric"><b><?php echo number_format($tot_ns_medis,0,",",","); ?></td>
            <td align="right" class="numeric"><b><?php echo number_format($tot_ns_non_medis,0,",",","); ?></td>
			<td align="right" class="numeric"><b><?php echo number_format($tot_ns_surgery,0,",",","); ?></td>
            <td align="right" class="numeric"><b><?php echo number_format($tot_ns_anti_aging,0,",",","); ?></td>
            <td align="right" class="numeric"><b><?php echo number_format($tot_ns_produk,0,",",","); ?></td>
            <td align="right" class="numeric"><b><?php echo number_format($tot_ns_lainlain,0,",",","); ?></td>
            <td align="right" class="numeric"><b><?php echo number_format($tot_net_sales,0,",",","); ?></td>
        </tr>
	</tfoot>
    	
</table>
</body>
</html>