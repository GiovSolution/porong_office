<?php
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: Penjualan Print
	+ Description	: For Print View
	+ Filename 		: p_detail_order.php
 	+ Author  		: 
 	+ Created on 01/Feb/2010 14:30:05
	
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Laporan Detail Retur Barang <?php echo $periode; ?></title>
<link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle.css'/>
</head>
<body onload='window.print()'>
<table summary='Detail Retur Barang'>
	<caption>Laporan Detail Retur Barang <br/><?php echo $periode; ?><br/>Group By No. Faktur</caption>
	<thead>
    	<tr>
        	<th scope='col'>No</th>
            <th scope='col'>Nama Barang</th>
            <th scope='col'>Satuan</th>
            <th scope='col'>Jumlah</th>
            <th scope='col'>Harga</th>
            <th scope='col'>Diskon(%)</th>
            <th scope='col'>Diskon(Rp)</th>
            <th scope='col'>Total Nilai (Rp)</th>
        </tr>
    </thead>
	<tbody>
		        
        	<?php $i=0; $j=0; $faktur=""; 
					$total_item=0;
					$total_diskon=0;
					$total_nilai=0;
					foreach($data_print as $print) { 
						
			?>
			<?php if($faktur!==$print->no_bukti) { ?>
           <tr>
                <td><b><? $j++; echo $j; ?></b></td>
                <td colspan="9"><b><?php echo "No Faktur: ".$print->no_bukti.", Tanggal : ".$print->tanggal.", Supplier: ".$print->supplier_nama."(".$print->supplier_akun.")";?></b></td>
           </tr>
           <?php 	
		   			$sub_cashback=0;
					$sub_total=0;
					$sub_diskon=0;
					$sub_jumlah_barang=0;
					$i=0; 
			?>
           <?php foreach($data_print as $print_list) {  ?>
           <?php if($print_list->no_bukti==$print->no_bukti){ $i++;
		   			$sub_jumlah_barang+=$print_list->jumlah_barang;
					$sub_diskon+=$print_list->diskon_nilai;
					$sub_total+=$print_list->subtotal;
		   ?>
            <tr>
                <td><? echo $i; ?></td>
                <td><?php echo $print_list->produk_nama.")";?></td>
                <td><?php echo $print_list->satuan_nama; ?></td>
                <td class="numeric"><?php echo number_format($print_list->jumlah_barang,0,",","."); ?></td>
                <td class="numeric"><?php echo number_format($print_list->harga_satuan,2,",","."); ?></td>
                <td class="numeric"><?php echo number_format($print_list->diskon,0,",","."); ?></td>
                <td class="numeric"><?php echo number_format($print_list->diskon_nilai,2,",","."); ?></td>
                <td class="numeric"><?php echo number_format($print_list->subtotal,2,",","."); ?></td>
           </tr>
           <?php } ?>
           <?php } ?>
           <tr>
                <td colspan="3">&nbsp;</td>
                <td align="right" class="numeric"><b><?php echo number_format($sub_jumlah_barang,0,",","."); ?></b></td>
                <td align="right" class="numeric">&nbsp;</td>
                <td align="right" class="numeric">&nbsp;</td>
                <td align="right" class="numeric"><b><?php echo number_format($sub_diskon,2,",","."); ?></b></td>
                <td align="right" class="numeric"><b><?php echo number_format($sub_total,2,",","."); ?></b></td>
           </tr>
           <?php } $faktur=$print->no_bukti; ?>
		<?php 
			$total_item+=$sub_jumlah_barang;
			$total_diskon+=$sub_diskon;
			$total_nilai+=$sub_total;
		
		} ?>
        
	</tbody>
    <tfoot>
    	<tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Total</th>
            <td colspan='6'><?php echo count($data_print); ?> data</td>
        </tr>
        <tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row' colspan="7">Summary</th>
        </tr>
        <tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Total Item</th>
            <td class="numeric clear" nowrap="nowrap"><?php echo number_format($total_item,0,",","."); ?></td>
            <td colspan="5" class="clear">&nbsp;</td>
        </tr>
        <tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Total Diskon (Rp)</th>
            <td class="numeric clear" nowrap="nowrap" ><?php echo number_format($total_diskon,2,",","."); ?></td>
            <td colspan="5" class="clear">&nbsp;</td>
        </tr>
        <tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Total Nilai (Rp)</th>
            <td class="numeric clear" nowrap="nowrap"><?php echo number_format($total_nilai,2,",","."); ?></td>
            <td colspan="5" class="clear">&nbsp;</td>
        </tr>
	</tfoot>
</table>
</body>
</html>