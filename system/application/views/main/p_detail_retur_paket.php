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
<title>Laporan Detail Retur Paket <?php echo $periode; ?> Group by No Faktur</title>
<link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle.css'/>
</head>
<body onload="window.print()">
<table summary='Detail Retur Jual'>
	<caption>Laporan Detail Retur Paket <br/><?php echo $periode; ?> <br/>Group by No Faktur</caption>
	<thead>
    	<tr>
        	<th scope='col'>No</th>
            <th scope='col'>Tanggal</th>
            <th scope='col'>No Faktur Jual</th>
            <th scope='col'>Customer</th>
            <th scope='col'>Paket</th>
            <th scope='col'>Jumlah Diambil</th>
            <th scope='col'>Jumlah Diretur</th>
			<th scope='col'>Nilai Sisa Paket (Rp)</th>
            <th scope='col'>Nilai Retur (Rp)</th>
			<th scope='col'>Selisih Nilai (Rp)</th>
        </tr>
    </thead>
    <tbody>
		<?php 
		$i=0; 
		$group=""; 
		$j=0;
		$total_item=0;
		$total_back=0;
		$total_nilai=0;
		$total_sisa_paket=0;
		$total_selisih=0;
		
		foreach($data_print as $printlist) { $i++; 
		
			if($group!==$printlist->no_bukti){
			$j++;
		?>
        <tr>
        	<td scope='col'><b><?php echo $j; ?></b></td>
            <td scope='col' colspan="11"><b><?php echo $printlist->no_bukti; ?></b></td>
        </tr>
        <?php
			
			$i=0;
				$sub_item=0;
				$sub_back=0;
				$sub_nilai=0;
				$sub_sisa_paket=0;
				$sub_selisih=0;
				
				foreach($data_print as $print) { 
					
					if($print->no_bukti==$printlist->no_bukti){
						$i++;
						$total_item+=$print->drpaket_jumlah_terambil;
						$total_back+=$print->drpaket_jumlah_diretur;
						$total_nilai+=$print->drpaket_rupiah_retur;
						$total_sisa_paket+=$print->nilai_sisa_paket;
						$total_selisih+=$print->selisih_retur_sisa;
						
						$sub_item+=$print->drpaket_jumlah_terambil;
						$sub_back+=$print->drpaket_jumlah_diretur;
						$sub_nilai+=$print->drpaket_rupiah_retur;
						$sub_sisa_paket+=$print->nilai_sisa_paket;
						$sub_selisih+=$print->selisih_retur_sisa;
		?>
		<tr>
        	<td><? echo $i; ?></td>
            <td><?php echo $print->tanggal; ?></td>
            <td><?php echo $print->no_bukti_jual."/".$print->tanggal_jual; ?></td>
            <td><?php echo $print->cust_nama." (".$print->cust_no.")"; ?></td>
            <td><?php echo $print->paket_nama."( ".$print->paket_kode.")"; ?></td>
            <td class="numeric"><?php echo number_format($print->drpaket_jumlah_terambil,0,",","."); ?></td>
            <td class="numeric"><?php echo number_format($print->drpaket_jumlah_diretur,2,",","."); ?></td>
			<td class="numeric"><?php echo number_format($print->nilai_sisa_paket,0,",","."); ?></td>
            <td class="numeric"><?php echo number_format($print->drpaket_rupiah_retur,0,",","."); ?></td>
			<td class="numeric"><?php echo number_format($print->selisih_retur_sisa,0,",","."); ?></td>
       </tr>
		<?php 		}
				}
		?>
		<tr>
            <td colspan="5">&nbsp;</td>
            <td align="right" class="numeric"><b><?php echo number_format($sub_item,0,",","."); ?></b></td>
            <td align="right" class="numeric"><b><?php echo number_format($sub_back,0,",","."); ?></b></td>
            <td align="right" class="numeric"><b><?php echo number_format($sub_nilai,0,",","."); ?></b></td>
			<td align="right" class="numeric"><b><?php echo number_format($sub_sisa_paket,0,",","."); ?></b></td>
			<td align="right" class="numeric"><b><?php echo number_format($sub_selisih,0,",","."); ?></b></td>
         </tr>
        <?
		}
		$group=$printlist->no_bukti;
		}
		
		
		?>
	</tbody>
	<tfoot>
    	<tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Total</th>
            <td colspan='10'><?php echo count($data_print); ?> data</td>
        </tr>
        <tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row' colspan="11">Summary</th>
        </tr>
        <tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Total Terambil</th>
            <td class="numeric clear" nowrap="nowrap"><?php echo number_format($total_item,0,",","."); ?></td>
            <td colspan="9" class="clear">&nbsp;</td>
        </tr>
        <tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Total Diretur</th>
            <td class="numeric clear" nowrap="nowrap" ><?php echo number_format($total_back,2,",","."); ?></td>
            <td colspan="9" class="clear">&nbsp;</td>
        </tr>
		<tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Total Nilai Sisa Paket (Rp)</th>
            <td class="numeric clear" nowrap="nowrap"><?php echo number_format($total_sisa_paket,2,",","."); ?></td>
            <td colspan="9" class="clear">&nbsp;</td>
        </tr>
        <tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Total Nilai Retur (Rp)</th>
            <td class="numeric clear" nowrap="nowrap"><?php echo number_format($total_nilai,2,",","."); ?></td>
            <td colspan="9" class="clear">&nbsp;</td>
        </tr>
		<tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Total Selisih Nilai (Rp)</th>
            <td class="numeric clear" nowrap="nowrap"><?php echo number_format($total_selisih,2,",","."); ?></td>
            <td colspan="9" class="clear">&nbsp;</td>
        </tr>
	</tfoot>
</table>
</body>
</html>