<?php
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: Kuitansi Print
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
<title>Laporan Rekap Kuitansi <?php echo $periode; ?> Group By <?php echo $jenis; ?></title>
<link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle.css'/>
</head>
<body onload="window.print();">
<table summary='Rekap Jual'>
	<caption>Laporan Rekap Kuitansi <br/><?php echo $periode; ?><br/>Group By <?php echo $jenis; ?></caption>
	<thead>
    	<tr>
        	<th scope='col'>No</th>
            <th scope='col'>No Kuitansi</th>           
            <th scope='col'>Tanggal</th>
            <th scope='col'>Customer</th>
            <th scope='col'>Cara Bayar</th>
			<th scope='col'>Nilai (Rp)</th>
            <th scope='col'>Pemakaian (Rp)</th>
            <th scope='col'>Sisa (Rp)</th> 
            <th scope='col'>Keterangan</th>
        </tr>
    </thead>
	<tbody>
		<?php $i=0; $tanggal=""; 
				$total_nilai=0;
				$total_pakai=0;
				$total_sisa=0;
				
		foreach($data_print as $print) { 
				$total_nilai+=$print->total_nilai;
				$total_pakai+=$print->total_pakai;
				$total_sisa+=$print->total_sisa;			
				$i++; 
		?>
		<tr>
        	<td><? echo $i; ?></td>
            <td width="10"><?php echo $print->no_bukti; ?></td>
            <td><?php echo $print->tanggal; ?></td>
            <td><?php echo $print->cust_nama." (".$print->cust_no.")"; ?></td>
			<td align="right" class="numeric"><?php echo $print->cara_bayar; ?></td>
            <td align="right" class="numeric"><?php echo number_format($print->total_nilai,0,",",","); ?></td>
            <td align="right" class="numeric"><?php echo number_format($print->total_pakai,0,",",","); ?></td>
            <td align="right" class="numeric"><?php echo number_format($print->total_sisa,0,",",","); ?></td>
            <td align="right" class="numeric"><?php echo $print->keterangan; ?></td>
       </tr>
		<?php } ?>
	</tbody>
    <tfoot>
    	<tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row'>Jumlah data</th>
            <td colspan='7'><?php echo count($data_print); ?> data</td>
        </tr>
        <tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row' colspan="9">Summary</th>
        </tr>
        <tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Total Nilai (Rp)</th>
            <td  nowrap="nowrap" align="right" class="numeric clear"><?php echo number_format($total_nilai,0,",",","); ?></td>
             <td colspan='6' class="clear">&nbsp;</td>
        </tr>
        <tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Total Pakai (Rp)</th>
            <td  nowrap="nowrap" align="right" class="numeric clear"><?php echo number_format($total_pakai,0,",",","); ?></td>
             <td colspan='6' class="clear">&nbsp;</td>
        </tr>
        <tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Total Sisa (Rp)</th>
            <td  nowrap="nowrap" align="right" class="numeric clear"><?php echo number_format($total_sisa,0,",",","); ?></td>
             <td colspan='6' class="clear" >&nbsp;</td>
        </tr>
	</tfoot>
</table>
</body>
</html>