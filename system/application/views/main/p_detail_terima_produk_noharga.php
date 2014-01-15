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
<title>Laporan Detail Penerimaan Barang <?php echo $periode; ?> Group By Produk</title>
<link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle.css'/>
</head>
<body onload="window.print();">
<table summary='Detail Jual'>
	<caption>Laporan Detail Penerimaan Barang<br/><?php echo $periode; ?><br/>Group By Produk</caption>
	<thead>
    	<tr>
        	<th scope='col'>No</th>
            <th scope='col'>Tanggal</th>
            <th scope='col'>No Faktur</th>
            <th scope='col'>Kode</th>
            <th scope='col'>Supplier</th>
			<th scope='col'>Satuan</th>
            <th scope='col'>Jumlah</th>
            <th scope='col'>Jenis</th>
            <th scope='col'>Diskon(%)</th>
            <th scope='col'>Diskon(Rp)</th>
            <th scope='col'>Total Nilai (Rp)</th>
        </tr>
    </thead>
	<tbody>

        	<?php $i=0; $j=0; $produk="";
					$total_item=0;
					$total_diskon=0;
					$total_nilai=0;


					foreach($data_print as $print) {
					$sub_jumlah=0;
					$sub_total=0;
					$sub_diskon=0;

			?>
			<?php if($produk!==$print->produk_id) { ?>
           <tr>
                <td><b><? $j++; echo $j; ?></b></td>
				<td colspan="12"><b><?php echo $print->produk_nama;?></b></td>
           </tr>
           <?php

					$i=0;
			?>
           <?php foreach($data_print as $print_list) {
		   			//$sub_jumlah=0;
		   ?>
           <?php if($print_list->produk_id==$print->produk_id){ $i++;
		   			$sub_jumlah+=$print_list->jumlah;
					$sub_diskon+=$print_list->diskon_nilai;
					$sub_total+=$print_list->subtotal;

					$total_item+=$print_list->jumlah;
					$total_diskon+=$print_list->diskon_nilai;
					$total_nilai+=$print_list->subtotal;

		   ?>
            <tr>
                <td><? echo $i; ?></td>
                <td><?php echo $print_list->tanggal;?></td>
                <td><?php echo $print_list->no_bukti;?></td>
				<td><?php echo $print->produk_kode;?></td>
                <td><?php echo $print_list->supplier_nama."(".$print_list->supplier_akun.")";?></td>
                <td><?php echo $print_list->satuan_nama; ?></td>
                <td class="numeric"><?php echo number_format($print_list->jumlah,0,",",","); ?></td>
                <td class="numeric"><?php echo $print_list->jenis; ?></td>
	
                <td class="numeric"><?php echo number_format($print_list->diskon,0,",",","); ?></td>
                <td class="numeric"><?php echo number_format($print_list->diskon_nilai,0,",",","); ?></td>
                <td class="numeric"><?php echo number_format($print_list->subtotal,0,",",","); ?></td>

           </tr>
           <?php } ?>
           <?php } ?>
           <tr>
                <td colspan="6">&nbsp;</td>
                <td align="right" class="numeric"><b><?php echo number_format($sub_jumlah,0,",",","); ?></b></td>
              
				<td align="right" class="numeric">&nbsp;</td>
                <td align="right" class="numeric">&nbsp;</td>
                <td align="right" class="numeric"><b><?php echo number_format($sub_diskon,0,",",","); ?></b></td>
                <td align="right" class="numeric"><b><?php echo number_format($sub_total,0,",",","); ?></b></td>
           </tr>
           <?php } $produk=$print->produk_id; ?>
		<?php


		} ?>

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
        	<th scope='row' nowrap="nowrap">Total Item</th>
            <td class="numeric clear" nowrap="nowrap"><?php echo number_format($total_item,0,",",","); ?></td>
            <td colspan="9" class="clear">&nbsp;</td>
        </tr>
		<tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Total Diskon (Rp)</th>
            <td class="numeric clear" nowrap="nowrap" ><?php echo number_format($total_diskon,0,",",","); ?></td>
            <td colspan="9" class="clear">&nbsp;</td>
        </tr>
        <tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Total Nilai (Rp)</th>
            <td class="numeric clear" nowrap="nowrap"><?php echo number_format($total_nilai,0,",",","); ?></td>
            <td colspan="9" class="clear">&nbsp;</td>
        </tr>
	</tfoot>
</table>
</body>
</html>