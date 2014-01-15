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
<title>Laporan Rekap Penerimaan Tagihan <?php echo $periode; ?> Group By Tanggal</title>
<link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle.css'/>
</head>
<body onload='window.print()'>
<table summary='Rekap Pesanan Pembelian'>
	<caption>Laporan Penerimaan Tagihan <br/><?php echo $periode; ?><br/>Group By Tanggal</caption>
	<thead>
    	<tr>
        	<th scope='col'>No</th>
            <th scope='col'>No Tagihan</th>
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
		<?php $i=0; $j=0; $tanggal=""; 
				$total_item=0;
				$total_subtotal=0;
				$total_cashback=0;
				$total_biaya=0;
				$total_totalnilai=0;
				$total_uangmuka=0;
				$total_bayar=0;
				$total_tagihan=0;
		
				foreach($data_print as $print) { 
				
				$sub_cashback=0;
				$sub_total=0;
				$sub_biaya=0;
				$sub_nilai=0;
				$sub_uangmuka=0;
				$sub_item=0;
				$sub_tagihan=0;
				$i=0; 
				
				?>
			<?php if($tanggal!==$print->tanggal) { 
			
					
			?>
           <tr>
                <td><b><? $j++; echo $j; ?></b></td>
                <td colspan="12"><b><?php echo $print->tanggal;?></b></td>
           </tr>
           <?php foreach($data_print as $print_list) {  ?>
           <?php if($print_list->tanggal==$print->tanggal){ $i++;
		   
		   			$sub_cashback+=$print->invoice_cashback;;
					$sub_total+=$print->total_nilai;
					$sub_biaya+=$print->invoice_biaya;
					$sub_nilai+=$print->total_nilai;
					$sub_uangmuka+=$print->order_bayar;
					$sub_item+=$print->jumlah_barang;
					$sub_tagihan+=($print->total_nilai-$print->order_bayar);
				
		   			$total_nilai=$print->total_nilai*(100-$print->invoice_diskon)/100-$print->invoice_cashback+$print->invoice_biaya;
					$total_bayar=$total_nilai-$print->order_bayar;
					
		   			$total_item+=$print->jumlah_barang;
					$total_subtotal+=$print->total_nilai;
					$total_cashback+=$print->invoice_cashback;
					$total_biaya+=$print->invoice_biaya;
					$total_totalnilai+=$total_nilai;
					$total_uangmuka+=$print->order_bayar;
					$total_tagihan+=($print->total_nilai-$print->order_bayar);
					
					
		   ?>
            <tr>
                <td><? echo $i; ?></td>
               	<td><?php echo $print_list->no_bukti; ?></td>
                <td><?php echo $print_list->supplier_nama."(".$print_list->supplier_akun.")"; ?></td>
                <td align="right" class="numeric"><?php echo number_format($print_list->jumlah_barang,0,",","."); ?></td>
                <td align="right" class="numeric"><?php echo number_format($print_list->total_nilai,2,",","."); ?></td>
                <td align="right" class="numeric"><?php echo number_format($print_list->invoice_diskon,0,",","."); ?></td>
                <td align="right" class="numeric"><?php echo number_format($print_list->invoice_cashback,2,",","."); ?></td>
                <td align="right" class="numeric"><?php echo number_format($print_list->invoice_biaya,0,",","."); ?></td>
                <td align="right" class="numeric"><?php echo number_format($total_nilai,2,",","."); ?></td>
                <td align="right" class="numeric"><?php echo number_format($print->order_bayar,2,",","."); ?></td>
                <td align="right" class="numeric"><?php echo number_format($total_bayar,2,",","."); ?></td>
                <td align="right"><?php echo ucfirst($print->invoice_jatuhtempo); ?></td>
           </tr>
           <?php } ?>
           <?php } ?>
           <tr>
                <td colspan="3">&nbsp;</td>
                <td align="right" class="numeric"><b><?php echo number_format($sub_item); ?></b></td>
                <td align="right" class="numeric"><b><?php echo number_format($sub_total,2,",","."); ?></b></td>
                <td align="right" class="numeric">&nbsp;</b></td>
                <td align="right" class="numeric"><b><?php echo number_format($sub_cashback,2,",","."); ?></b></td>
                <td align="right" class="numeric"><b><?php echo number_format($sub_biaya,2,",","."); ?></b></td>
                <td align="right" class="numeric"><b><?php echo number_format($sub_nilai,2,",","."); ?></b></td>
                <td align="right" class="numeric"><b><?php echo number_format($sub_uangmuka,2,",","."); ?></b></td>
                <td align="right" class="numeric"><b><?php echo number_format($sub_tagihan,2,",","."); ?></b></td>
                <td align="right" class="numeric">&nbsp;</td>
           </tr>
           <?php } 
		   			$tanggal=$print->tanggal; 
			?>
		<?php } ?>
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