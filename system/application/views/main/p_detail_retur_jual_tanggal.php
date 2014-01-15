<?php
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: Penjualan Print
	+ Description	: For Print View
	+ Filename 		: p_detail_jual.php
 	+ Author  		: 
 	+ Created on 01/Feb/2010 14:30:05
	
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Laporan Detail Retur Penjualan <?php echo $periode; ?> Group by Tanggal</title>
<link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle.css'/>
</head>
<body onload="window.print()">
<table summary='Detail Retur Jual'>
	<caption>Laporan Detail Retur Penjualan <br/><?php echo $periode; ?> <br/>Group by Tanggal</caption>
	<thead>
    	<tr>
        	<th scope='col'>No</th>
            <th scope='col'>No Faktur Jual</th>
            <th scope='col'>No Faktur</th>
            <th scope='col'>Customer</th>
            <th scope='col'>Produk</th>
            <th scope='col'>Satuan</th>
            <th scope='col'>Jumlah</th>
            <th scope='col'>Harga</th>
            <th scope='col'>Diskon(%)</th>
            <th scope='col'>Diskon(Rp)</th>
            <th scope='col'>Jenis Diskon</th>
            <th scope='col'>Total Nilai (Rp)</th>
        </tr>
    </thead>
    <tbody>
		<?php 
		$i=0; 
		$group=""; 
		$j=0;
		$total_item=0;
		$total_cashback=0;
		$total_nilai=0;
		
		foreach($data_print as $printlist) { $i++; 
		
			if($group!==$printlist->tanggal){
			$j++;
		?>
        <tr>
        	<td scope='col'><b><?php echo $j; ?></b></td>
            <td scope='col' colspan="11"><b><?php echo $printlist->tanggal; ?></b></td>
        </tr>
        <?php
			
			$i=0;
				$sub_item=0;
				$sub_cashback=0;
				$sub_nilai=0;
				foreach($data_print as $print) { 
					
					if($print->tanggal==$printlist->tanggal){
						$i++;
						$total_item+=$print->jumlah_barang;
						$total_cashback+=$print->diskon_nilai;
						$total_nilai+=$print->subtotal;
						
						$sub_item+=$print->jumlah_barang;
						$sub_cashback+=$print->diskon_nilai;
						$sub_nilai+=$print->subtotal;
		?>
		<tr>
        	<td><? echo $i; ?></td>
            <td><?php echo $print->no_bukti_jual; ?></td>
            <td><?php echo $print->no_bukti; ?></td>
            <td><?php echo $print->cust_nama." (".$print->cust_no.")"; ?></td>
            <td><?php echo $print->produk_nama."( ".$print->produk_kode.")"; ?></td>
            <td><?php echo $print->satuan_nama; ?></td>
            <td class="numeric"><?php echo number_format($print->jumlah_barang,0,",","."); ?></td>
            <td class="numeric"><?php echo number_format($print->harga_satuan,2,",","."); ?></td>
            <td class="numeric"><?php echo number_format($print->diskon,0,",","."); ?></td>
            <td class="numeric"><?php echo number_format($print->diskon_nilai,2,",","."); ?></td>
            <td class="numeric"><?php echo $print->diskon_jenis; ?></td>
            <td class="numeric"><?php echo number_format($print->subtotal,2,",","."); ?></td>
       </tr>
		<?php 		}
				}
		?>
		<tr>
            <td colspan="6">&nbsp;</td>
            <td align="right" class="numeric"><b><?php echo number_format($sub_item,0,",","."); ?></b></td>
            <td colspan="2" >&nbsp;  </td>
            <td align="right" class="numeric"><b><?php echo number_format($sub_cashback,0,",","."); ?></b></td>
            <td>&nbsp;  </td>
            <td align="right" class="numeric"><b><?php echo number_format($sub_nilai,0,",","."); ?></b></td>
         </tr>
        <?
		}
		$group=$printlist->tanggal;
		}
		
		
		?>
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
            <td class="numeric clear" nowrap="nowrap"><?php echo number_format($total_item,0,",","."); ?></td>
            <td colspan="9" class="clear">&nbsp;</td>
        </tr>
        <tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Total Diskon (Rp)</th>
            <td class="numeric clear" nowrap="nowrap" ><?php echo number_format($total_cashback,2,",","."); ?></td>
            <td colspan="9" class="clear">&nbsp;</td>
        </tr>
        <tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Total Nilai (Rp)</th>
            <td class="numeric clear" nowrap="nowrap"><?php echo number_format($total_nilai,2,",","."); ?></td>
            <td colspan="9" class="clear">&nbsp;</td>
        </tr>
	</tfoot>
</table>
</body>
</html>