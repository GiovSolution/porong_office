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
<title>Laporan Rekap Penyesuaian Stok <?php echo $jenis; ?> <?php echo $periode; ?> Order By No. Bukti</title>
<link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle.css'/>
</head>
<body onload="window.print();">
<table summary='Rekap Penyesuaian Stok'>
	<caption>Laporan Rekap Penyesuaian Stok <br/><?php echo $periode; ?><br/>Group By No. Bukti</caption>
	<thead>
    	<tr>
        	<th scope='col'>No</th>
            <th scope='col'>No Bukti</th>           
            <th scope='col'>Tanggal</th>
            <th scope='col'>Gudang</th>
            <th scope='col'>Jumlah Awal</th>
            <th scope='col'>Jumlah Koreksi</th>
            <th scope='col'>Jumlah Saldo</th>
        </tr>
    </thead>

	<tbody>
		<?php	$i=0; 
				$group=""; 
				$total_awal=0;
				$total_koreksi=0;
				$total_saldo=0;

				foreach($data_print as $print) { $i++; 
					$total_awal+=$print->jumlah_awal;
					$total_koreksi+=$print->jumlah_koreksi;
					$total_saldo+=$print->jumlah_saldo;
				?>
		<tr>
        	<td><? echo $i; ?></td>
            <td><?php echo $print->no_bukti; ?></td>
            <td><?php echo $print->tanggal; ?></td>
            <td><?php echo $print->gudang_nama; ?></td>
            <td align="right" class="numeric"><?php echo number_format($print->jumlah_awal,2,",","."); ?></td>
            <td align="right" class="numeric"><?php echo number_format($print->jumlah_koreksi,2,",","."); ?></td>
            <td align="right" class="numeric"><?php echo number_format($print->jumlah_saldo,2,",","."); ?></td>
       </tr>
		<?php 
			
				} ?>
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
        	<th scope='row' nowrap="nowrap">Total Jumlah Awal</th>
            <td nowrap="nowrap" align="right" class="numeric clear"><?php echo number_format($total_awal,0,",","."); ?></td>
            <td colspan='11' class="clear">&nbsp;</td>
        </tr>
        <tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Total Jumlah Koreksi</th>
            <td  nowrap="nowrap" align="right" class="numeric clear"><?php echo number_format($total_koreksi,2,",","."); ?></td>
             <td colspan='11' class="clear">&nbsp;</td>
        </tr>
        <tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Total Jumlah Saldo</th>
            <td  nowrap="nowrap" align="right" class="numeric clear"><?php echo number_format($total_saldo,2,",","."); ?></td>
             <td colspan='11' class="clear" >&nbsp;</td>
        </tr>
	</tfoot>
    </table>
</table>
</body>
</html>