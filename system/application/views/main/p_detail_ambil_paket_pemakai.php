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
<title>Laporan Detail Pengambilan Paket <?php echo $periode; ?> Group By Pemakaizz</title>
<link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle.css'/>
</head>
<body onload="window.print();">
<table width="1201" summary='Detail Jual'>
	<caption>
	Laporan Detail Pengambilan Paket | <?php echo $periode; ?> Group By <?php echo $group; ?></caption>
	<thead>
    	<tr>
        	<th width="22" scope='col'>No</th>
            <th width="80" scope='col'>Tanggal</th>
            <th width="80" scope='col'>No Faktur</th>           
            <th width="355" scope='col'>Customer</th>
          	<th width="355" scope='col'>Nama Paket</th>
            <th width="320" scope='col'>Nama Perawatan</th>
            <th width="30" scope='col'>Jumlah</th>
			<th width="100" scope='col'>Harga Satuan</th>
			<th width="100" scope='col'>Total</th>
            <th width="150" scope='col'>Referal</th>
        </tr>
    </thead>
	<tbody>
		<?php 	$i=0; 
				$pemakai=""; 
				$total_item=0;
				$j=0;
				$i=0;
				$tot_medis = 0;
				$tot_non_medis = 0;
				$tot_aa = 0;
				$tot_surgery = 0;
				$tot_all = 0;
				$total = 0;
				$jum_all = 0;
				
		foreach($data_print as $printlist){		
			if($pemakai!==$printlist->pemakai_nama){
				?>
				 <tr>
						<td><b><? $j++; echo $j; ?></b></td>
						<td colspan="8"><b><?php echo $printlist->pemakai_nama;?></b></td>
				 </tr>
				<?
					$pemakai=""; 
					$total_item=0;
					$j=0;
					$i=0;
					$tot_medis = 0;
					$tot_non_medis = 0;
					$tot_aa = 0;
					$tot_surgery = 0;
					$tot_all = 0;
					$total = 0;
					$jum_all = 0;
						
				foreach($data_print as $print) { 
					if ($print->kategori_nama == 'Medis') {
						$tot_medis = $tot_medis+$print->dapaket_jumlah*$print->harga_satuan;
					}
					if ($print->kategori_nama == 'Non Medis') {
						$tot_non_medis = $tot_non_medis+$print->dapaket_jumlah*$print->harga_satuan;
					}
					if ($print->kategori_nama == 'Anti Aging') {
						$tot_aa = $tot_aa+$print->dapaket_jumlah*$print->harga_satuan;
					}
					if ($print->kategori_nama == 'Surgery') {
						$tot_surgery = $tot_surgery+$print->dapaket_jumlah*$print->harga_satuan;
					}
					$tot_all = $tot_all + $print->harga_satuan;
					$jum_all = $jum_all + $print->dapaket_jumlah;
					$total = $total + $print->dapaket_jumlah*$print->harga_satuan;
					
					
					if($print->pemakai_nama==$printlist->pemakai_nama){ 
						$i++;?>
						<tr>
							<td><? echo $i; ?></td>
							<td ><?php echo $print->tanggal; ?></td>
							<td><?php echo $print->no_bukti; ?></td>
							<td ><?php echo $print->cust_nama." (".$print->cust_no.")"; ?></td>
							<td ><?php echo $print->paket_nama; ?></td>
							<td ><?php echo $print->rawat_nama; ?></td>
							<td><?php echo $print->dapaket_jumlah; ?></td>
							<td class="numeric"><?php echo number_format($print->harga_satuan,0,",",","); ?></td>
							<td class="numeric"><?php echo number_format($print->dapaket_jumlah*$print->harga_satuan,0,",",","); ?></td>
							<td><?php echo $print->referal; ?></td>
					   </tr><?php
				   }
				}
				?><?
			}
			$pemakai=$printlist->pemakai_nama; 
		}?>
	</tbody>
		<tfoot>
	<tr> 
		<?//<td class="clear"></td>?>
		<td class="foot">&nbsp;</td> 
		<th scope='row' nowrap="nowrap">&nbsp;</th> 
		<td colspan='8' class="foot">&nbsp;</td> 
	</tr> 
	</tfoot>

		<tr> 
			<?//<td></td>?>
			<td class="foot">&nbsp;</td> 
			<th scope='row' nowrap="nowrap">Jum data</th> 
			<td colspan='8' class="foot"><?php echo count($data_print); ?> data</td> 
		</tr> 
		<tr> 
			<?//<td></td>?>
			<td class="foot">&nbsp;</td> 
			<th scope='row' nowrap="nowrap">Total</th> 
			<td class="foot">&nbsp;</td> 
			<td class="numeric foot" nowrap="nowrap" ><?php echo number_format($total,0,",",","); ?></td> 
			<td colspan="8" class="foot">&nbsp;</td> 
		</tr> 
		<tr> 
			<?//<td></td>?>
			<td class="foot">&nbsp;</td> 
			<th scope='row' nowrap="nowrap">Total Medis</th> 
			<td class="foot">&nbsp;</td> 
			<td class="numeric foot" nowrap="nowrap" ><?php echo number_format($tot_medis,0,",",","); ?></td> 
			<td colspan="8" class="foot">&nbsp;</td> 
		</tr> 
		<tr> 
			<?//<td></td>?>
			<td class="foot">&nbsp;</td> 
			<th scope='row' nowrap="nowrap">Total Non Medis</th> 
			<td class="foot">&nbsp;</td> 
			<td class="numeric foot" nowrap="nowrap" ><?php echo number_format($tot_non_medis,0,",",","); ?></td> 
			<td colspan="8" class="foot">&nbsp;</td> 
		</tr> 
		<tr> 
			<?//<td></td>?>
			<td class="foot">&nbsp;</td> 
			<th scope='row' nowrap="nowrap">Total Anti Aging</th> 
			<td class="foot">&nbsp;</td> 
			<td class="numeric foot" nowrap="nowrap" ><?php echo number_format($tot_aa,0,",",","); ?></td> 
			<td colspan="8" class="foot">&nbsp;</td> 
		</tr> 
		<tr> 
			<?//<td></td>?>
			<td class="foot">&nbsp;</td> 
			<th scope='row' nowrap="nowrap">Total Surgery</th> 
			<td class="foot">&nbsp;</td> 
			<td class="numeric foot" nowrap="nowrap" ><?php echo number_format($tot_surgery,0,",",","); ?></td> 
			<td colspan="8" class="foot">&nbsp;</td> 
		</tr> 
</table>
</body>
</html>