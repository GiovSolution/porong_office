<?php /* These code was generated using phpCIGen v 0.1.b (24/06/2009)#zaqi zaqi.smart@gmail.com,http:#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id+ Module : Penjualan Print+ Description: For Print View+ Filename : p_detail_jual.php + Author : + Created on 01/Feb/2010 14:30:05*/ ?><!DOCTYPE html PUBLIC "-//W3C<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Laporan Detail Penjualan <?php echo $jenis; ?> <?php echo $periode; ?> Group By Tanggal</title>
	<link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle.css'/>
</head>
<body onload="window.print();">
	<table summary='Detail Jual'>
	<caption>Laporan Detail Penjualan <?php echo $jenis; ?><?php echo ' | '.$periode.' | '; ?>Group By Tanggal, Opsi by <?php echo $opsi; ?></caption>
	<thead> 
		<tr> 
			<th scope='col'>No</th>
			<th scope='col'>Jam</th>
			<th scope='col'>No Cust</th> 
			<th scope='col'>Customer</th> 
			<th scope='col'>No Faktur</th>
			<th scope='col'>Kode</th> 
			<th scope='col'>Nama Barang/Jasa</th> 
			<th scope='col'>Satuan</th> 
			<th scope='col'>Jml</th> 
			<th scope='col'>Harga</th> 
			<th scope='col'>Disk (%)</th> 
			<th scope='col'>Disk (Rp)</th> 
			<th scope='col'>Jns Disk</th> 
			<th scope='col'>Referal</th> 
			<th scope='col'>Total (Rp)</th>
		</tr> 
	</thead>
<tbody> 
<?php 
	$i=0; 
	$j=0; 
	$tanggal=""; 
	$total_item=0;
	$total_diskon=0;
	$total_nilai=0;
	foreach($data_print as $print) { 
		?><?php if($tanggal!==$print->tanggal) { ?> 
			<tr> 
				<td><b><?php $j++; echo $j; ?></b></td> 
				<td colspan="13"><b><?php echo $print->tanggal; ?></b></td> 
			</tr> 
			<?php 
			$sub_cashback=0;
			$sub_total=0;
			$sub_diskon=0;
			$sub_jumlah_barang=0;
			$i=0; ?> 
			<?php 
			foreach($data_print as $print_list) { ?> 
			<?php if($print_list->tanggal==$print->tanggal){ 
				$i++; 
				$sub_jumlah_barang+=$print_list->jumlah_barang;
				$sub_diskon+=$print_list->diskon_nilai;
				$sub_total+=$print_list->subtotal;
				$total_item+=$print_list->jumlah_barang;
				$total_diskon+=$print_list->diskon_nilai;
				$total_nilai+=$print_list->subtotal; ?> 
			<tr> 
				<td><?php echo $i; ?></td>
				<td><?php echo $print_list->time; ?></td>
				<td><?php echo $print_list->cust_no; ?></td> 
				<td><?php echo $print_list->cust_nama; ?></td> 
				<td><?php echo $print_list->no_bukti; ?></td>
				<td><?php echo $print_list->produk_kode; ?></td> 
				<td><?php echo $print_list->produk_nama; ?></td> 
				<td><?php echo $print_list->satuan_nama; ?></td> 
				<td class="numeric"><?php echo number_format($print_list->jumlah_barang,0,",",","); ?></td> 
				<td class="numeric"><?php echo number_format($print_list->harga_satuan,0,",",","); ?></td> 
				<td class="numeric"><?php echo number_format($print_list->diskon,0,",",","); ?></td> 
				<td class="numeric"><?php echo number_format($print_list->diskon_nilai,0,",",","); ?></td> 
				<td class="numeric"><?php echo $print_list->diskon_jenis; ?></td> 
				<td><?php echo $print_list->sales; ?></td> 
				<td class="numeric"><?php echo number_format($print_list->subtotal,0,",",","); ?></td> 
			</tr> <?php } ?> <?php } ?> 
			<tr> 
				<td align="right" colspan="8"><b>Total</td> 
				<td align="right" class="numeric"><b><?php echo number_format($sub_jumlah_barang,0,",",","); ?></b></td> 
				<td align="right" class="numeric">&nbsp;</td> 
				<td align="right" class="numeric">&nbsp;</td> 
				<td align="right" class="numeric"><b><?php echo number_format($sub_diskon,0,",",","); ?></b></td> 
				<td align="right" class="numeric">&nbsp;</td> 
				<td align="right" class="numeric">&nbsp;</td> 
				<td align="right" class="numeric"><b><?php echo number_format($sub_total,0,",",","); ?></b></td> 
			</tr> <?php } $tanggal=$print->tanggal; ?><?php } ?> 
</tbody> 
<tfoot> 
	<tr> 
		<td class="clear">&nbsp;</td> 
		<th scope='row' nowrap="nowrap" colspan='2'>Jumlah data</th> 
		<td colspan='12'><?php echo count($data_print); ?> data</td> 
	</tr> 
	<tr> 
		<td class="clear">&nbsp;</td> 
		<th scope='row' colspan="14">Summary</th> 
	</tr> 
	<tr> 
		<td class="clear">&nbsp;</td> 
		<th scope='row' nowrap="nowrap" colspan='2'>Tot Item</th> 
		<td class="numeric clear" nowrap="nowrap"><?php echo number_format($total_item,0,",",","); ?></td> 
		<td colspan="11" class="clear">&nbsp;</td> 
	</tr> 
	<tr> 
		<td class="clear">&nbsp;</td> 
		<th scope='row' nowrap="nowrap" colspan='2'>Total Disk (Rp)</th> 
		<td class="numeric clear" nowrap="nowrap" ><?php echo number_format($total_diskon,0,",",","); ?></td> 
		<td colspan="11" class="clear">&nbsp;</td> 
	</tr> 
	<tr> 
		<td class="clear">&nbsp;</td> 
		<th scope='row' nowrap="nowrap" colspan='2'>Total (Rp)</th> 
		<td class="numeric clear" nowrap="nowrap"><?php echo number_format($total_nilai,0,",",","); ?></td> 
		<td colspan="11" class="clear">&nbsp;</td> 
	</tr>
</tfoot>
</table>
</body>
</html>