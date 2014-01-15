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
<title>Laporan Rekap Retur Paket <?php echo $periode; ?> Group By Tanggal</title>
<link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle.css'/>
</head>
<body onload="window.print()">
<table summary='Rekap Retur Jual'>
	<caption>Laporan Rekap  Retur Paket <br/><?php echo $periode; ?><br/> Group By Tanggal</caption>
	<thead>
    	<tr>
        	<th scope='col'>No</th>
            <th scope='col'>No Faktur Jual/ Tanggal</th>
            <th scope='col'>No Faktur Retur</th>
            <th scope='col'>Customer</th>
            <th scope='col'>Nilai Kwitansi (Rp)</th>
        </tr>
    </thead>
	<tbody>
		<?php 
		$i=0; $tanggal=""; 
		$j=0;

		$total_nilai=0;
		
		foreach($data_print as $printlist) { $i++; 
		
		if($tanggal!==$printlist->tanggal){
			$j++;
		?>
        <tr>
        	<td scope='col'><b><?php echo $j; ?></b></td>
            <td scope='col' colspan="7"><b><?php echo $printlist->tanggal; ?></b></td>
        </tr>
        <?php
				$i=0;

				$sub_nilai=0;
				foreach($data_print as $print) { 
					
					if($print->tanggal==$printlist->tanggal){
						$i++;
						$total_nilai+=$print->drpaket_rupiah_retur;
						$sub_nilai+=$print->drpaket_rupiah_retur;
				
		?>
		<tr>
        	<td><? echo $i; ?></td>
            <td><?php echo $print->no_bukti_jual."/".$print->tanggal_jual; ?></td>
            <td><?php echo $print->no_bukti; ?></td>
            <td><?php echo $print->cust_nama." (".$print->cust_no.")"; ?></td>
            <td align="right" class="numeric"><?php echo number_format($print->drpaket_rupiah_retur,2,",","."); ?></td>
             <td><?php echo $print->rpaket_keterangan; ?></td>
       </tr>
		<?php 		}
				}
		?>
		<tr>
                <td colspan="4">&nbsp;</td>
                <td align="right" class="numeric"><b><?php echo number_format($sub_nilai,0,",","."); ?></b></td>
                <td >&nbsp;</td>
        </tr>
        <?
		}
		$tanggal=$printlist->tanggal;
		}
		
		
		?>
	</tbody>
    <tfoot>
    	<tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row'>Total</th>
            <td colspan='12'><?php echo count($data_print); ?> data</td>
        </tr>
        <tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row' colspan="13">Summary</th>
        </tr>
        <tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Total Nilai Kwitansi (Rp)</th>
            <td  nowrap="nowrap" align="right" class="numeric clear"><?php echo number_format($total_nilai,2,",","."); ?></td>
             <td colspan='11' class="clear" >&nbsp;</td>
        </tr>
	</tfoot>
</table>
</body>
</html>