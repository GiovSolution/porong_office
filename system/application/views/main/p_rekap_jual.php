<?php /* These code was generated using phpCIGen v 0.1.b (24/06/2009)#zaqi zaqi.smart@gmail.com,http:#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id+ Module : Penjualan Print+ Description: For Print View+ Filename : p_rekap_jual.php + Author : + Created on 01/Feb/2010 14:30:05*/ ?>
<!DOCTYPE html PUBLIC "-//W3C<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Laporan Rekap Penjualan <?php echo $jenis; ?> <?php echo $periode; ?> Group By No. Faktur</title>
	<link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle.css'/>
</head>
<body onload="window.print();">
<table summary='Rekap Jual'>
	<caption>
		Laporan Rekap Penjualan <?php echo $jenis; ?><br/><?php echo $periode; ?>Group By No. Faktur
	</caption>
	<thead> 
		<tr> 
			<th scope='col'>No</th> 
			<th scope='col'>No Faktur</th> 
			<th scope='col'>Tanggal</th> 
			<th scope='col'>No Cust</th> 
			<th scope='col'>Customer</th>
			<th scope='col'>Tot Item</th> 
			<th scope='col'>Subtotal (Rp)</th> 
			<? //<th scope='col'>Disk + (%)</th> ?>
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
			<? //<th scope='col'>Voucher (Rp)</th> ?>
			<th scope='col'>Hutang (Rp)</th> 
		</tr> 
	</thead>
	<tbody>
	<?php 
		$i=0; 
		$tanggal=""; 
		$total_item=0;
		$total_diskon=0;
		$total_diskonp=0;
		$total_cashback=0;
		$total_cashback_medis=0;
		$total_nilai=0;
		$total_bayar=0;
		$total_tunai=0;
		$total_cek=0;
		$total_transfer=0;
		$total_kuitansi=0;
		$total_card=0;
		$total_voucher=0;
		$total_kredit=0;
		foreach($data_print as $print) { 
			$total_item+=$print->jumlah_barang;
			$total_diskon+=$print->cashback;
			$total_diskonp+=($print->diskon*$print->total_nilai)/100;
			$total_cashback+=$print->cashback;
			$total_cashback_medis+=$print->cashback_medis;
			$total_nilai+=$print->total_nilai;
			$total_bayar+=$print->total_bayar;
			$total_tunai+=$print->tunai;
			$total_cek+=$print->cek;
			$total_transfer+=$print->transfer;
			$total_kuitansi+=$print->kuitansi;
			$total_card+=$print->card;
			$total_voucher+=$print->voucher;
			$total_kredit+=$print->kredit;$i++; 
	?>
	<tr> 
		<td>
			<?php echo $i; ?>
		</td> 
		<td width="10">
			<?php echo $print->no_bukti; ?>
		</td> 
		<td>
			<?php echo $print->tanggal; ?>
		</td>
		<td>
			<?php echo $print->cust_no; ?>
		</td> 
		<td>
			<?php echo $print->cust_nama; ?>
		</td>
		<td align="right" class="numeric">
			<?php echo number_format($print->jumlah_barang,0,",",","); ?>
		</td>
		<td align="right" class="numeric">
			<?php echo number_format($print->total_nilai,0,",",","); ?>
		</td> 
		<? /*
		<td align="right" class="numeric">
			<?php echo number_format($print->diskon,0,",",","); ?>
		</td> 
		*/ ?>
		<? if ($jenis == 'Perawatan') {?>
			<td align="right" class="numeric">
				<?php echo number_format($print->cashback,0,",",","); ?>
			</td><?php /*<td align="right" class="numeric"><?php echo number_format($print->total_bayar,0,",",","); ?></td>*/ ?> 
			<td align="right" class="numeric">
				<?php echo number_format($print->cashback_medis,0,",",","); ?>
			</td><?php /*<td align="right" class="numeric"><?php echo number_format($print->total_bayar,0,",",","); ?></td>*/ ?> 
		<? } else { ?>
			<td align="right" class="numeric">
				<?php echo number_format($print->cashback,0,",",","); ?>
			</td><?php /*<td align="right" class="numeric"><?php echo number_format($print->total_bayar,0,",",","); ?></td>*/ ?> 
		<? } ?>
		
		<td align="right" class="numeric">
			<?php echo number_format($print->tunai,0,",",","); ?>
		</td> 
		<td align="right" class="numeric">
			<?php echo number_format($print->cek,0,",",","); ?>
		</td> 
		<td align="right" class="numeric">
			<?php echo number_format($print->transfer,0,",",","); ?>
		</td> 
		<td align="right" class="numeric">
			<?php echo number_format($print->kuitansi,0,",",","); ?>
		</td> 
		<td align="right" class="numeric">
			<?php echo number_format($print->card,0,",",","); ?>
		</td> 
		<? /*
		<td align="right" class="numeric">
			<?php echo number_format($print->voucher,0,",",","); ?>
		</td> 
		*/ ?>
		<td align="right" class="numeric">
			<?php echo number_format($print->kredit,0,",",","); ?>
		</td> 
	</tr>
	<?php } ?>
	</tbody> 
	<tfoot> 
	<tr> 
		<td class="clear">&nbsp;</td> 
		<th scope='row'>Jumlah data</th>
		<td><?php echo count($data_print); ?> data</td>
		<td colspan="2" align="right"><b>Grand TOTAL</td> 
		<?php ?> 
		<td align="right" class="numeric"><b><?php echo number_format($total_item,0,",",","); ?></td><?php ?> 
		<td align="right" class="numeric"><b><?php echo number_format($total_nilai,0,",",","); ?></td> <?php ?> 
		<?/*<td align="right" class="numeric"><b><?php echo number_format($total_diskonp,0,",",","); ?></td> <?php */?> 
		
		<? if ($jenis == 'Perawatan') {?>
			<td align="right" class="numeric"><b><?php echo number_format($total_cashback,0,",",","); ?></td><?php /*<td align="right" 
			class="numeric"><b><?php echo number_format($total_bayar,0,",",","); ?></td>*/ ?> <?php ?> 
			<td align="right" class="numeric"><b><?php echo number_format($total_cashback_medis,0,",",","); ?></td><?php /*<td align="right" 
			class="numeric"><b><?php echo number_format($total_bayar,0,",",","); ?></td>*/ ?> <?php ?> 
		<? } else { ?>
			<td align="right" class="numeric"><b><?php echo number_format($total_cashback,0,",",","); ?></td>
		<? } ?>
		<td align="right" class="numeric"><b><?php echo number_format($total_tunai,0,",",","); ?></td> <?php ?> 
		<td align="right" class="numeric"><b><?php echo number_format($total_cek,0,",",","); ?></td> <?php ?> 
		<td align="right" class="numeric"><b><?php echo number_format($total_transfer,0,",",","); ?></td> <?php ?> 
		<td align="right" class="numeric"><b><?php echo number_format($total_kuitansi,0,",",","); ?></td> <?php ?> 
		<td align="right" class="numeric"><b><?php echo number_format($total_card,0,",",","); ?></td> <?php ?> 
		<? /*<td align="right" class="numeric"><b><?php echo number_format($total_voucher,0,",",","); ?></td> <?php */ ?> 
		<td align="right" class="numeric"><b><?php echo number_format($total_kredit,0,",",","); ?></td> </tr>
	</tfoot>
</table>
</body>
</html>