<?php /* These code was generated using phpCIGen v 0.1.b (24/06/2009)#zaqi zaqi.smart@gmail.com,http:#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id+ Module : Penjualan Print+ Description: For Print View+ Filename : p_rekap_jual.php + Author : + Created on 01/Feb/2010 14:30:05*/ ?><!DOCTYPE html PUBLIC "-//W3C<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Laporan Rekap Penjualan <?php echo $jenis; ?> <?php echo $periode; ?> Group By Tanggal</title><link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle.css'/>
</head>
<body onload="window.print();">
<table summary='Rekap Jual'>
	<caption>Laporan Rekap Penjualan <?php echo $jenis; ?><br/><?php echo $periode; ?><br/>Group By Tanggal</caption>
<thead> 
<tr> 
	<th scope='col'>No</th> 
	<th scope='col'>No Cust</th> 
	<th scope='col'>Customer</th> 
	<th scope='col'>No Faktur</th>
	<th scope='col'>Tot Item</th> 
	<th scope='col'>Total (Rp)</th> 
	<? //<th scope='col'>Disk (%)</th> ?>
	<? //<th scope='col'>Disk (Rp)</th> ?>
	<? if ($jenis == 'Perawatan') {?>
		<th scope='col'>Voucher NonMedis(Rp)</th> <?php ?> 
		<th scope='col'>Voucher Medis(Rp)</th> <?php ?> 
	<? } else {?>
		<th scope='col'>Voucher (Rp)</th> <?php ?> 
	<? } ?>
	<th scope='col'>Tunai (Rp)</th>
	<th scope='col'>Cek/Giro (Rp)</th>
	<th scope='col'>Transfer (Rp)</th> 
	<th scope='col'>Kuitansi (Rp)</th>
	<th scope='col'>Card (Rp)</th> 
	<?//<th scope='col'>Voucher (Rp)</th>?>
	<th scope='col'>Kredit (Rp)</th> 
</tr> 
</thead>
	<tbody>
	<?php 
	$i=0; 
	$j=0; 
	$tanggal=""; 
	$total_item=0;
	$total_diskon=0;
	$total_diskon_medis=0;
	$total_diskonp=0;
	$total_nilai=0;
	$total_tunai=0;
	$total_cek=0;
	$total_transfer=0;
	$total_kuitansi=0;
	$total_card=0;
	$total_voucher=0;
	$total_kredit=0;
	foreach($data_print as $print) { ?><?php if($tanggal!==$print->tanggal) { ?> 
		<tr> 
			<td><b><?php $j++; echo $j; ?></b></td> 
			<td colspan="14"><b><?php echo $print->tanggal; ?></b></td> 
		</tr> 
		<?php 
			$sub_cashback=0;
			$sub_cashback_medis=0;
			$sub_total=0;
			$sub_tunai=0;
			$sub_cek=0;
			$sub_transfer=0;
			$sub_kuitansi=0;
			$sub_card=0;
			$sub_kredit=0;
			$sub_jumlah_barang=0;
			$sub_voucher=0;
			$i=0; 
		?> <?php 
		foreach($data_print as $print_list) { ?> <?php if($print_list->tanggal==$print->tanggal){ $i++; 
		$sub_cashback+=$print_list->cashback;
		$sub_cashback_medis+=$print_list->cashback_medis;
		$sub_jumlah_barang+=$print_list->jumlah_barang;
		$sub_total+=$print_list->total_nilai;
		$sub_tunai+=$print_list->tunai;
		$sub_cek+=$print_list->cek;
		$sub_transfer+=$print_list->transfer;
		$sub_kuitansi+=$print_list->kuitansi;
		$sub_card+=$print_list->card;
		$sub_kredit+=$print_list->kredit;
		$sub_voucher+=$print_list->voucher; 
		$total_item+=$print_list->jumlah_barang;
		$total_diskon+=$print_list->cashback;
		$total_diskon_medis+=$print_list->cashback_medis;
		$total_diskonp+=($print_list->diskon*$print_list->total_nilai)/100;
		$total_nilai+=$print_list->total_nilai;
		$total_tunai+=$print_list->tunai;
		$total_cek+=$print_list->cek;
		$total_transfer+=$print_list->transfer;
		$total_kuitansi+=$print_list->kuitansi;
		$total_card+=$print_list->card;
		$total_kredit+=$print_list->kredit;
		$total_voucher+=$print_list->voucher; ?> 
		<tr> 
			<td><?php echo $i; ?></td>
			<td><?php echo $print_list->cust_no; ?></td> 
			<td><?php echo $print_list->cust_nama; ?></td> 
			<td><?php echo $print_list->no_bukti; ?></td> 
			<td align="right" class="numeric"><?php echo number_format($print_list->jumlah_barang,0,",",","); ?></td>
			<td align="right" class="numeric"><?php echo number_format($print_list->total_nilai,0,",",","); ?></td>
			<? if ($jenis == 'Perawatan') {?>
				<td align="right" class="numeric"><?php echo number_format($print_list->cashback,0,",",","); ?></td> 
				<td align="right" class="numeric"><?php echo number_format($print_list->cashback_medis,0,",",","); ?></td> 
			<? } else { ?>
				<td align="right" class="numeric"><?php echo number_format($print_list->cashback,0,",",","); ?></td> 
			<? } ?>
			<td align="right" class="numeric"><?php echo number_format($print_list->tunai,0,",",","); ?></td>
			<td align="right" class="numeric"><?php echo number_format($print_list->cek,0,",",","); ?></td>
			<td align="right" class="numeric"><?php echo number_format($print_list->transfer,0,",",","); ?></td>
			<td align="right" class="numeric"><?php echo number_format($print_list->kuitansi,0,",",","); ?></td>
			<td align="right" class="numeric"><?php echo number_format($print_list->card,0,",",","); ?></td>
			<td align="right" class="numeric"><?php echo number_format($print_list->kredit,0,",",","); ?></td>
		</tr> <?php } ?> <?php } ?> 
		<tr>
			<td colspan="4">&nbsp;</td>
			<td align="right" class="numeric"><b><?php echo number_format($sub_jumlah_barang,0,",",","); ?></b></td>
			<td align="right" class="numeric"><b><?php echo number_format($sub_total,0,",",","); ?></b></td>
			<? if ($jenis == 'Perawatan') {?>
				<td align="right" class="numeric"><b><?php echo number_format($sub_cashback,0,",",","); ?></b></td> 
				<td align="right" class="numeric"><b><?php echo number_format($sub_cashback_medis,0,",",","); ?></b></td>
			<? } else { ?>
				<td align="right" class="numeric"><b><?php echo number_format($sub_cashback,0,",",","); ?></b></td> 
			<? } ?>
			<td align="right" class="numeric"><b><?php echo number_format($sub_tunai,0,",",","); ?></b></td> 
			<td align="right" class="numeric"><b><?php echo number_format($sub_cek,0,",",","); ?></b></td> 
			<td align="right" class="numeric"><b><?php echo number_format($sub_transfer,0,",",","); ?></b></td>
			<td align="right" class="numeric"><b><?php echo number_format($sub_kuitansi,0,",",","); ?></b></td> <td align="right" class="numeric"><b><?php echo number_format($sub_card,0,",",","); ?></b></td> 
			<td align="right" class="numeric"><b><?php echo number_format($sub_kredit,0,",",","); ?></b></td> 
		</tr> <?php } $tanggal=$print->tanggal; ?><?php } ?>
</tbody> 
<tfoot> 
	<tr> 
		<td class="clear">&nbsp;</td> 
		<th scope='row'>Total</th> 
		<td colspan='14'><?php echo count($data_print); ?> data</td>
	</tr> 
	<tr> 
		<td class="clear">&nbsp;</td> 
		<th scope='row' colspan="13">Summary</th>
	</tr> 
	<tr> 
		<td class="clear">&nbsp;</td> 
		<th scope='row' nowrap="nowrap">Tot Item</th> 
		<td nowrap="nowrap" align="right" class="numeric clear"><?php echo number_format($total_item,0,",",","); ?></td> 
		<td colspan='12' class="clear">&nbsp;</td> 
	</tr>
	<tr> 
		<td class="clear">&nbsp;</td> 
		<th scope='row' nowrap="nowrap">Total (Rp)</th> 
		<td nowrap="nowrap" align="right" class="numeric clear"><?php echo number_format($total_nilai,0,",",","); ?></td> 
		<td colspan='12' class="clear" >&nbsp;</td> 
	</tr> 
	<tr> 
		<td class="clear">&nbsp;</td>
		<th scope='row' nowrap="nowrap">Total Tunai (Rp)</th> 
		<td nowrap="nowrap" align="right" class="numeric clear"><?php echo number_format($total_tunai,0,",",","); ?></td> 
		<td colspan='12' class="clear" >&nbsp;</td> 
	</tr> 
	<tr> 
		<td class="clear">&nbsp;</td> 
		<th scope='row' nowrap="nowrap">Total Cek/Giro (Rp)</th> 
		<td nowrap="nowrap" align="right" class="numeric clear"><?php echo number_format($total_cek,0,",",","); ?></td> 
		<td colspan='12' class="clear" >&nbsp;</td> 
	</tr> 
	<tr> 
		<td class="clear">&nbsp;</td> <th scope='row' nowrap="nowrap">Total Transfer (Rp)</th> 
		<td nowrap="nowrap" align="right" class="numeric clear"><?php echo number_format($total_transfer,0,",",","); ?></td> 
		<td colspan='12' class="clear" >&nbsp;</td> 
	</tr> 
	<tr> 
		<td class="clear">&nbsp;</td>
		<th scope='row' nowrap="nowrap">Total Kuitansi (Rp)</th> 
		<td nowrap="nowrap" align="right" class="numeric clear"><?php echo number_format($total_kuitansi,0,",",","); ?></td>
		<td colspan='12' class="clear" >&nbsp;</td> 
	</tr> 
	<tr> 
		<td class="clear">&nbsp;</td> 
		<th scope='row' nowrap="nowrap">Total Credit (Rp)</th>
		<td nowrap="nowrap" align="right" class="numeric clear"><?php echo number_format($total_card,0,",",","); ?></td> 
		<td colspan='12' class="clear" >&nbsp;</td> 
	</tr> 
	<? if ($jenis == 'Perawatan') {?>
		<tr> 
			<td class="clear">&nbsp;</td> 
			<th scope='row' nowrap="nowrap">Total Voucher NonMedis(Rp)</th> 
			<td nowrap="nowrap" align="right" class="numeric clear"><?php echo number_format($total_diskon,0,",",","); ?></td> 
			<td colspan='12' class="clear" >&nbsp;</td> 
		</tr> 
			<tr> 
			<td class="clear">&nbsp;</td> 
			<th scope='row' nowrap="nowrap">Total Voucher Medis(Rp)</th> 
			<td nowrap="nowrap" align="right" class="numeric clear"><?php echo number_format($total_diskon_medis,0,",",","); ?></td> 
			<td colspan='12' class="clear" >&nbsp;</td> 
		</tr> 
	<? } else { ?>
		<tr> 
			<td class="clear">&nbsp;</td> 
			<th scope='row' nowrap="nowrap">Total Voucher (Rp)</th> 
			<td nowrap="nowrap" align="right" class="numeric clear"><?php echo number_format($total_diskon,0,",",","); ?></td> 
			<td colspan='12' class="clear" >&nbsp;</td> 
		</tr> 
	<? } ?>
	<tr>
		<td class="clear">&nbsp;</td> 
		<th scope='row' nowrap="nowrap">Total Kredit (Rp)</th> 
		<td nowrap="nowrap" align="right" class="numeric clear"><?php echo number_format($total_kredit,0,",",","); ?></td> 
		<td colspan='12' class="clear" >&nbsp;</td> 
	</tr>
</tfoot>
</table>
</body>
</html>