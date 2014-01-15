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
<title>Laporan Rekap Penerimaan Barang <?php echo $periode; ?></title>
<link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle.css'/>
</head>
<body onload='window.print()'>
<table summary='Laporan Rekap Penerimaan Barang'>
	<caption>Laporan Rekap Penerimaan Barang<br/><?php echo $periode; ?><br/>Group By No. Tanggal</caption>
	<thead>
    	<tr>
        	<th scope='col'>No</th>
            <th scope='col'>No PB</th>
            <th scope='col'>No SP</th>
            <th scope='col'>Supplier</th>
            <th scope='col'>Jumlah Item</th>
            <th scope='col'>Jumlah Bonus</th>
			<th scope='col'>Diskon(%)</th>
			<th scope='col'>Total Nilai (Rp)</th>
            <th scope='col'>No Surat Jalan</th>
            <th scope='col'>Nama Pengirim</th>
        </tr>
    </thead>

	<tbody>
		<?php	$i=0; $tanggal=""; $j=0;
				$total_item=0;
				$total_bonus=0;
				$total_totalnilai=0;
				$total_nilai=0;

				$sub_item=0;
				$sub_bonus=0;
				foreach($data_print as $print) {
					$sub_item=0;
					$sub_bonus=0;
					$sub_nilai=0;

					$i=0;
		?>
          <?php if($tanggal!==$print->tanggal) {

			?>
           <tr>
                <td><b><? $j++; echo $j; ?></b></td>
                <td colspan="14"><b><?php echo $print->tanggal;?></b></td>
           </tr>
           <?php foreach($data_print as $print_list) {   ?>
           <?php if($print_list->tanggal==$print->tanggal){ $i++;
		   		$sub_item+=$print_list->jumlah_barang;
				$sub_bonus+=$print_list->jumlah_barang_bonus;

				$total_nilai=$print_list->total_nilai*(100-$print_list->order_diskon)/100;
				$sub_nilai+=$total_nilai;

		   ?>
			<tr>
                <td><? echo $i; ?></td>
                <td><?php echo $print_list->no_bukti; ?></td>
                <td><?php echo $print_list->order_no; ?></td>
                <td><?php echo $print_list->supplier_nama." (".$print_list->supplier_akun.")"; ?></td>
                <td align="right" class="numeric"><?php echo number_format($print_list->jumlah_barang,0,",",","); ?></td>
                <td align="right" class="numeric"><?php echo number_format($print_list->jumlah_barang_bonus,0,",",","); ?></td>
                <td align="right" class="numeric"><?php echo number_format($print_list->order_diskon,0,",",","); ?></td>
				<td align="right" class="numeric"><?php echo number_format($total_nilai,0,",",","); ?></td>
				<td align="right"><?php echo ucfirst($print_list->terima_surat_jalan); ?></td>
                <td align="right"><?php echo ucfirst($print_list->terima_pengirim); ?></td>
      		</tr>
		 <?php } ?>
         <?php } ?>
           <tr>
                <td colspan="4">&nbsp;</td>
                <td align="right" class="numeric"><b><?php echo number_format($sub_item); ?></b></td>
                <td align="right" class="numeric"><b><?php echo number_format($sub_bonus); ?></b></td>
                <td align="right" class="numeric">&nbsp;</td>
				<td align="right" class="numeric"><b><?php echo number_format($sub_nilai); ?></b></td>
                <td align="right" class="numeric">&nbsp;</td>
                <td align="right" class="numeric">&nbsp;</td>
           </tr>
         <?php
		  }

		  		$total_item+=$sub_item;
				$total_bonus+=$sub_bonus;
				$total_totalnilai+=$sub_nilai;

				$tanggal=$print->tanggal;
		 ?>
        <?php } ?>
	</tbody>
	<tfoot>
    	<tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row'>Total</th>
            <td colspan='9'><?php echo count($data_print); ?> data</td>
        </tr>
        <tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row' colspan="10">Summary</th>
        </tr>
        <tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Total Item</th>
            <td nowrap="nowrap" align="right" class="numeric clear"><?php echo number_format($total_item,0,",",","); ?></td>
            <td colspan='8' class="clear">&nbsp;</td>
        </tr>
        <tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Total Item Bonus</th>
            <td  nowrap="nowrap" align="right" class="numeric clear"><?php echo number_format($total_bonus,0,",",","); ?></td>
             <td colspan='8' class="clear">&nbsp;</td>
        </tr>
		<tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Grand Total Nilai</th>
            <td  nowrap="nowrap" align="right" class="numeric clear"><?php echo number_format($total_totalnilai,0,",",","); ?></td>
             <td colspan='8' class="clear">&nbsp;</td>
        </tr>
	</tfoot>
    </table>
</table>
</body>
</html>