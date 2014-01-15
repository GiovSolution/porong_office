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
<title>Laporan Rekap Penerimaan Tagihan <?php echo $jenis; ?> <?php echo $periode; ?> Group By No. Faktur</title>
<link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle.css'/>
</head>
<body onload="window.print();">
<table summary='Rekap Tagihan Pembelian'>
	<caption>Laporan Rekap Penerimaan Tagihan <br/><?php echo $periode; ?> <br/>Group By No. Faktur</caption>
	<thead>
    	<tr>
        	<th scope='col'>No</th>
            <th scope='col'>No Tagihan</th>           
            <th scope='col'>Tanggal</th>
            <th scope='col'>Supplier</th>
            <th scope='col'>Total Item</th>
            <th scope='col'>Sub Total (Rp)</th>
            <th scope='col'>Diskon(%)</th>
            <th scope='col'>Diskon (Rp)</th>
            <th scope='col'>Biaya (Rp)</th>
            <th scope='col'>Total Nilai (Rp)</th>
            <th scope='col'>Uang Muka (Rp)</th>
            <th scope='col'>Total Tagihan (Rp)</th>
            <th scope='col'>Jatuh Tempo</th>
        </tr>
    </thead>

	<tbody>
		<?php	$i=0; $tanggal=""; 
				$total_item=0;
				$total_subtotal=0;
				$total_cashback=0;
				$total_biaya=0;
				$total_totalnilai=0;
				$total_uangmuka=0;
				$total_bayar=0;
				$total_tagihan=0;
				foreach($data_print as $print) { $i++; 
					$total_nilai=$print->total_nilai*(100-$print->invoice_diskon)/100-$print->invoice_cashback+$print->invoice_biaya;
					$total_bayar=$total_nilai-$print->order_bayar;
				?>
		<tr>
        	<td><? echo $i; ?></td>
            <td><?php echo $print->no_bukti; ?></td>
            <td><?php echo $print->tanggal; ?></td>
            <td><?php echo $print->supplier_nama." (".$print->supplier_akun.")"; ?></td>
            <td align="right" class="numeric"><?php echo number_format($print->jumlah_barang,0,",","."); ?></td>
            <td align="right" class="numeric"><?php echo number_format($print->total_nilai,2,",","."); ?></td>
            <td align="right" class="numeric"><?php echo number_format($print->invoice_diskon,0,",","."); ?></td>
            <td align="right" class="numeric"><?php echo number_format($print->invoice_cashback,2,",","."); ?></td>
            <td align="right" class="numeric"><?php echo number_format($print->invoice_biaya,0,",","."); ?></td>
            <td align="right" class="numeric"><?php echo number_format($total_nilai,2,",","."); ?></td>
            <td align="right" class="numeric"><?php echo number_format($print->order_bayar,2,",","."); ?></td>
            <td align="right" class="numeric"><?php echo number_format($total_bayar,2,",","."); ?></td>
            <td align="right"><?php echo ucfirst($print->invoice_jatuhtempo); ?></td>
       </tr>
		<?php 
				$total_item+=$print->jumlah_barang;
				$total_subtotal+=$print->total_nilai;
				$total_cashback+=$print->invoice_cashback;
				$total_biaya+=$print->invoice_biaya;
				$total_totalnilai+=$total_nilai;
				$total_uangmuka+=$print->order_bayar;
				$total_tagihan+=($print->total_nilai-$print->order_bayar);
				
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
        	<th scope='row' nowrap="nowrap">Total Item</th>
            <td nowrap="nowrap" align="right" class="numeric clear"><?php echo number_format($total_item,0,",","."); ?></td>
            <td colspan='11' class="clear">&nbsp;</td>
        </tr>
        <tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Diskon (Rp)</th>
            <td  nowrap="nowrap" align="right" class="numeric clear"><?php echo number_format($total_cashback,2,",","."); ?></td>
             <td colspan='11' class="clear">&nbsp;</td>
        </tr>
        <tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Grand Sub Total (Rp)</th>
            <td  nowrap="nowrap" align="right" class="numeric clear"><?php echo number_format($total_subtotal,2,",","."); ?></td>
             <td colspan='11' class="clear" >&nbsp;</td>
        </tr>
        <tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Total Biaya (Rp)</th>
            <td  nowrap="nowrap" align="right" class="numeric clear"><?php echo number_format($total_biaya,2,",","."); ?></td>
             <td colspan='11' class="clear" >&nbsp;</td>
        </tr>
        <tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Grand Total Nilai (Rp)</th>
            <td  nowrap="nowrap" align="right" class="numeric clear"><?php echo number_format($total_totalnilai,2,",","."); ?></td>
             <td colspan='11' class="clear" >&nbsp;</td>
        </tr>
        <tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Total Uang Muka (Rp)</th>
            <td  nowrap="nowrap" align="right" class="numeric clear"><?php echo number_format($total_uangmuka,2,",","."); ?></td>
             <td colspan='11' class="clear" >&nbsp;</td>
        </tr>
        <tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Grand Total Tagihan (Rp)</th>
            <td  nowrap="nowrap" align="right" class="numeric clear"><?php echo number_format($total_tagihan,2,",","."); ?></td>
             <td colspan='11' class="clear" >&nbsp;</td>
        </tr>
	</tfoot>
    </table>
</table>
</body>
</html>