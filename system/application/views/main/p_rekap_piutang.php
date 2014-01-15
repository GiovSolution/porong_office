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
<title>Laporan Rekap Piutang <?php echo $periode; ?> Group By No. Faktur</title>
<link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle.css'/>
</head>
<body onload="window.print();">
<table summary='Rekap Piutang'>
	<caption>Laporan Rekap Piutang <br/><?php echo $periode; ?>Group By  No. Faktur</caption>
	<thead>
    	<tr>
        	<th rowspan="2" scope='col' >No</th>
            <th rowspan="2" scope='col'>No Faktur</th>           
            <th rowspan="2" scope='col'>Tanggal</th>
            <th rowspan="2" scope='col'>No Cust</th>
            <th rowspan="2" scope='col'>Customer</th>
			<th rowspan="2" scope='col'>Piutang (Rp)</th>
            <th colspan="4" scope='col'>Pelunasan</th>
            <th rowspan="2" scope='col'>Sisa (Rp)</th>
        </tr>
    	<tr>
    	  <th scope='col'>Tunai</th>
    	  <th scope='col'>Card</th>
    	  <th scope='col'>Cek</th>
    	  <th scope='col'>Transfer</th>
      </tr>
    </thead>
	<tbody>
		<?php $i=0; $tanggal=""; 
				$total_tunai=0;
				$total_card=0;
				$total_cek=0;
				$total_transfer=0;
				$total_kuitansi=0;
				$total_piutang=0;
				$total_sisa=0;
				
		foreach($data_print as $print) { 
				$total_piutang+=$print->lpiutang_total;
				$total_sisa+=$print->lpiutang_sisa;
				$total_tunai+=$print->piutang_tunai;
				$total_card+=$print->piutang_card;
				$total_cek+=$print->piutang_cek;
				$total_transfer+=$print->piutang_transfer;
				
				$i++; 
		?>
		<tr>
        	<td><? echo $i; ?></td>
            <td width="81"><?php echo $print->no_bukti; ?></td>
            <td><?php echo $print->tanggal; ?></td>
			<td><?php echo $print->cust_no; ?></td>
            <td><?php echo $print->cust_nama; ?></td>
			<td align="right" class="numeric"><?php echo number_format($print->lpiutang_total,0,",",","); ?></td>
			<td align="right" class="numeric"><?php echo number_format($print->piutang_tunai,0,",",","); ?></td>
			<td align="right" class="numeric"><?php echo number_format($print->piutang_card,0,",",","); ?></td>
			<td align="right" class="numeric"><?php echo number_format($print->piutang_cek,0,",",","); ?></td>
			<td align="right" class="numeric"><?php echo number_format($print->piutang_transfer,0,",",","); ?></td>
            <td align="right" class="numeric"><?php echo number_format($print->lpiutang_sisa,0,",",","); ?></td>
       </tr>
		<?php } ?>
	</tbody>
    	<tfoot>
    	<tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row'>Jumlah data</th>
			<td><?php echo count($data_print); ?> data</td>
			<td colspan="2" align="right"><b>Grand TOTAL</b></td>
            <td align="right" class="numeric"><b><?php echo number_format($total_piutang,0,",",","); ?></b></td>
            <td align="right" class="numeric"><b><?php echo number_format($total_tunai,0,",",","); ?></b></td>
            <td align="right" class="numeric"><b><?php echo number_format($total_card,0,",",","); ?></b></td>
            <td align="right" class="numeric"><b><?php echo number_format($total_cek,0,",",","); ?></b></td>
            <td align="right" class="numeric"><b><?php echo number_format($total_transfer,0,",",","); ?></b></td>
            <td align="right" class="numeric"><b><?php echo number_format($total_sisa,0,",",","); ?></b></td>
          </tr>
	</tfoot>
</table>
</body>
</html>