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
<title>Laporan Rekap Retur Barang <?php echo $periode; ?></title>
<link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle.css'/>
</head>
<body onload='window.print()'>
<table summary='Laporan Rekap Penerimaan Barang'>
	<caption>Laporan Rekap Retur Barang<br/><?php echo $periode; ?><br/>Group By No. Tanggal</caption>
	<thead>
    	<tr>
        	<th scope='col'>No</th>
            <th scope='col'>No Retur</th> 
            <th scope='col'>No PB</th> 
            <th scope='col'>No SP</th>            
            <th scope='col'>Supplier</th>
            <th scope='col'>Jumlah Item</th>
            <th scope='col'>Total Nilai</th>
            <th scope='col'>Keterangan</th>
        </tr>
    </thead>

	<tbody>
		<?php	$i=0; $tanggal=""; $j=0; 
				$total_item=0;
				$total_nilai=0;

				foreach($data_print as $print) { 
					$sub_item=0;
					$sub_nilai=0;
					$i=0;
		?>
          <?php if($tanggal!==$print->tanggal) { 
								
			?>
           <tr>
                <td><b><? $j++; echo $j; ?></b></td>
                <td colspan="12"><b><?php echo $print->tanggal;?></b></td>
           </tr>
           <?php foreach($data_print as $print_list) {   ?>
           <?php if($print_list->tanggal==$print->tanggal){ $i++; 
		   		$sub_item+=$print_list->jumlah_barang;
				$sub_nilai+=$print_list->total_nilai;
		   ?>
			<tr>
                <td><? echo $i; ?></td>
                <td><?php echo $print_list->no_bukti; ?></td>
                <td><?php echo $print_list->no_order; ?></td>
                <td><?php echo $print_list->no_terima; ?></td>
                <td><?php echo $print_list->supplier_nama." (".$print_list->supplier_akun.")"; ?></td>
                <td align="right" class="numeric"><?php echo number_format($print_list->jumlah_barang,0,",","."); ?></td>
                <td align="right" class="numeric"><?php echo number_format($print_list->total_nilai,0,",","."); ?></td>
                <td align="right"><?php echo ucfirst($print_list->rbeli_keterangan); ?></td>
      		</tr>
		 <?php } ?>
         <?php } ?>
           <tr>
                <td colspan="5">&nbsp;</td>
                <td align="right" class="numeric"><b><?php echo number_format($sub_item); ?></b></td>
                <td align="right" class="numeric"><b><?php echo number_format($sub_nilai); ?></b></td>
                <td align="right" class="numeric">&nbsp;</td>
           </tr>
         <?php	
		  }
		  
		  		$total_item+=$sub_item;
				$total_nilai+=$sub_nilai;
				$tanggal=$print->tanggal; 
		 ?>
        <?php } ?>
	</tbody>
	<tfoot>
    	<tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row'>Total</th>
            <td colspan='7'><?php echo count($data_print); ?> data</td>
        </tr>
        <tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row' colspan="8">Summary</th>
        </tr>
        <tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Total Item</th>
            <td nowrap="nowrap" align="right" class="numeric clear"><?php echo number_format($total_item,0,",","."); ?></td>
            <td colspan='6' class="clear">&nbsp;</td>
        </tr>
        <tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Total Nilai</th>
            <td  nowrap="nowrap" align="right" class="numeric clear"><?php echo number_format($total_nilai,0,",","."); ?></td>
             <td colspan='6' class="clear">&nbsp;</td>
        </tr>
	</tfoot>
    </table>
</table>
</body>
</html>