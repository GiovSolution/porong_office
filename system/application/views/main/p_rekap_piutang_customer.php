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
<title>Laporan Rekap Piutang <?php echo $pelunasan; ?><?php echo $periode; ?> Group By Customer</title>
<link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle.css'/>
</head>
<body onload="window.print();">
<table summary='Rekap Piutang Customer'>
	<caption>Laporan Rekap Piutang <br/><?php echo $pelunasan; ?><br/><?php echo $periode; ?> <br/>Group By  Customer</caption>
	<thead>
       	<tr>
        	<th rowspan="2" scope='col'>No</th>
            <th rowspan="2" scope='col'>Customer</th>           
            <? //<th rowspan="2" scope='col'>Tanggal</th> ?>
			<th rowspan="2" scope='col'>Piutang (Rp)</th>
            <th colspan="4" scope='col' align="center">Pelunasan</th>
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
		<?php $i=0; $j=0; $cust=""; 
				$total_tunai=0;
				$total_card=0;
				$total_cek=0;
				$total_transfer=0;
				$total_kuitansi=0;
				$total_piutang=0;
				$total_sisa=0;
		
				foreach($data_print as $print) { ?>
			<?php if($cust!==$print->cust_id) { ?>
           <tr>
                <td><b><? $j++; echo $j; ?></b></td>
                <td><?php echo $print->cust_nama." (".$print->cust_no.")";?></td>
           
			<?php 
				$i=0; 
				$total_piutang+=$print->piutang_total;
				$total_sisa+=$print->piutang_sisa;
				$total_tunai+=$print->piutang_tunai;
				$total_card+=$print->piutang_card;
				$total_cek+=$print->piutang_cek;
				$total_transfer+=$print->piutang_transfer;
			?>
           
                <td align="right" class="numeric"><?php echo number_format($print->piutang_total,0,",",","); ?></td>
                <td align="right" class="numeric"><?php echo number_format($print->piutang_tunai,0,",",","); ?></td>
                <td align="right" class="numeric"><?php echo number_format($print->piutang_card,0,",",","); ?></td>
                <td align="right" class="numeric"><?php echo number_format($print->piutang_cek,0,",",","); ?></td>
                <td align="right" class="numeric"><?php echo number_format($print->piutang_transfer,0,",",","); ?></td>
                <td align="right" class="numeric"><?php echo number_format($print->piutang_sisa,0,",",","); ?></td>
           </tr>
           <?php } $cust=$print->cust_id; ?>
		<?php } ?>
	</tbody>
    <tfoot>
    	<tr>
        	<td class="foot">&nbsp;</td>
        	<th scope='row'>Total</th>
            <td colspan='7'><?php echo count($data_print); ?> data</td>
        </tr>
        <tr>
        	<td class="foot">&nbsp;</td>
        	<th scope='row' colspan="8">Summary</th>
        </tr>
        <tr>
        	<td class="foot">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Total Piutang (Rp)</th>
            <td nowrap="nowrap" align="right" class="numeric foot"><?php echo number_format($total_piutang,0,",",","); ?></td>
            <td colspan='6' class="foot">&nbsp;</td>
        </tr>
        <tr>
        	<td class="foot">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Total Tunai (Rp)</th>
            <td scope='row' nowrap="nowrap" align="right" class="numeric foot"><?php echo number_format($total_tunai,0,",",","); ?></td>
            <td colspan='6' class="foot">&nbsp;</td>
        </tr>
		<tr>
        	<td class="foot">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Total Card (Rp)</th>
            <td class="numeric foot" nowrap="nowrap"><?php echo number_format($total_card,0,",",","); ?></td>
             <td colspan='6' class="foot">&nbsp;</td>
        </tr>
        <tr>
        	<td class="foot">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Total Cek (Rp)</th>
            <td  nowrap="nowrap" align="right" class="numeric foot"><?php echo number_format($total_cek,0,",",","); ?></td>
             <td colspan='6' class="foot">&nbsp;</td>
        </tr>

        <tr>
        	<td class="foot">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Total Transfer (Rp)</th>
            <td  nowrap="nowrap" align="right" class="numeric foot"><?php echo number_format($total_transfer,0,",",","); ?></td>
             <td colspan='6' class="foot" >&nbsp;</td>
        </tr>
        <tr>
        	<td class="foot">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Total Sisa (Rp)</th>
            <td  nowrap="nowrap" align="right" class="numeric foot"><?php echo number_format($total_sisa,0,",",","); ?></td>
             <td colspan='6' class="foot" >&nbsp;</td>
        </tr>
	</tfoot>
</table>
</body>
</html>