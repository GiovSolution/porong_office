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
			<th scope='col'>Status</th>
			<th scope='col'>No Faktur</th>
			<th scope='col'>No Pajak</th>
			<th scope='col'>Kode</th> 
			<th scope='col'>Nama Barang/Jasa</th> 
			<? if ($jenis == 'Produk') { ?>
				<th scope='col'>Sat</th> 
			<? } ?>
			<th scope='col'>Jml</th> 
			<th scope='col'>Harga</th> 
			<? 
			/*<th scope='col'>DPP</th>
			<th scope='col'>PPN</th>
			*/?>
			<th scope='col'>Disk (%)</th> 
			<th scope='col'>Disk (Rp)</th> 
			<th scope='col'>Jns</th>
			<? if ($jenis == 'Produk' || $jenis == 'Paket') { ?>
				<th scope='col'>Vchr</th>
			<?} else { ?>
				<th scope='col'>Vchr M</th> 
				<th scope='col'>Vchr NM</th>
			<? } ?>
			<th scope='col'>Referal</th> 
			<th scope='col'>Total (Rp)</th>
			<th scope='col'>Tot DPP (Rp)</th>
			<th scope='col'>Tot PPN (Rp)</th>
			<th scope='col'>Card</th>
			<th scope='col'>Tunai</th>
			<th scope='col'>Ktns</th>
			<th scope='col'>Trns</th>
			<th scope='col'>Cek</th>
		</tr> 
	</thead>
<tbody> 
<?php 
	$i=0; 
	$j=0; 
	$tanggal=""; 
	$total_item=0;
	$grand_total_jumlah=0;
	$grand_total_diskon=0;
	$grand_total_total=0;
	$grand_total_voucher_medis=0;
	$grand_total_voucher_nonmedis=0;
	$grand_total_dpp=0;
	$grand_total_ppn=0;
	$grand_total_card=0;
	$grand_total_tunai=0;
	$grand_total_kuitansi=0;
	$grand_total_transfer=0;
	$grand_total_cek=0;
	foreach($data_print as $print) { 
		?><?php if($tanggal!==$print->tanggal) { ?> 
			<tr> 
				<td><b><?php $j++; echo $j; ?></b></td> 
				<td colspan="13"><b><?php echo $print->tanggal; ?></b></td> 
			</tr> 
			<?php 
			$sub_cashback=0;
			$sub_total=0;
			$sub_total_dpp=0;
			$sub_total_ppn=0;
			$total_card=0;
			$total_tunai=0;
			$total_kuitansi=0;
			$total_transfer=0;
			$total_cek=0;
			$total_voucher_medis=0;
			$total_voucher_nonmedis=0;
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
				$sub_total_dpp+=(($print_list->harga_satuan/1.1)*$print_list->jumlah_barang-((($print_list->harga_satuan/1.1)*$print_list->jumlah_barang)*$print_list->diskon/100));
				$sub_total_ppn+=$print_list->subtotal-((($print_list->harga_satuan/1.1)*$print_list->jumlah_barang)-((($print_list->harga_satuan/1.1)*$print_list->jumlah_barang)*$print_list->diskon/100));
				$total_voucher_medis+=$print_list->voucher_medis;
				$total_voucher_nonmedis+=$print_list->voucher;
				$total_card+=$print_list->bayar_card;
				$total_tunai+=$print_list->bayar_tunai;
				$total_kuitansi+=$print_list->bayar_kuitansi;
				$total_transfer+=$print_list->bayar_transfer;
				$total_cek+=$print_list->bayar_cek;
				$total_item+=$print_list->jumlah_barang;
				$grand_total_diskon+=$print_list->diskon_nilai;
				$grand_total_voucher_medis+=$print_list->voucher_medis;
				$grand_total_voucher_nonmedis+=$print_list->voucher;
				$grand_total_total+=$print_list->subtotal;
				$grand_total_dpp+=((($print_list->harga_satuan/1.1)*$print_list->jumlah_barang)-((($print_list->harga_satuan/1.1)*$print_list->jumlah_barang)*$print_list->diskon/100));
				$grand_total_ppn+=$print_list->subtotal-((($print_list->harga_satuan/1.1)*$print_list->jumlah_barang)-((($print_list->harga_satuan/1.1)*$print_list->jumlah_barang)*$print_list->diskon/100));
				$grand_total_card+=$print_list->bayar_card; 
				$grand_total_tunai+=$print_list->bayar_tunai; 
				$grand_total_kuitansi+=$print_list->bayar_kuitansi; 
				$grand_total_transfer+=$print_list->bayar_transfer; 
				$grand_total_cek+=$print_list->bayar_cek; 
			?> 
			<tr> 
				<td><?php echo $i; ?></td>
				<td><?php echo substr($print_list->time,0,5); ?></td>
				<td><?php echo $print_list->cust_no; ?></td> 
				<td><?php echo $print_list->cust_nama; ?></td>
				<td><?php echo $print_list->status; ?></td>				
				<td><?php echo $print_list->no_bukti; ?></td>
				<? if ($print_list->faktur_pajak=='-') { ?>
					<td><?php echo $print_list->faktur_pajak; ?></td>
				<? } else { ?>
					<td><?php echo substr($print_list->faktur_pajak,8,2).'.'.substr($print_list->faktur_pajak,15,4); ?></td>
				<? } ?>
				<td><?php echo $print_list->produk_kode; ?></td> 
				<td><?php echo $print_list->produk_nama; ?></td> 
				<? if ($jenis == 'Produk') { ?>
					<td><?php echo $print_list->satuan_kode; ?></td> 
				<? } ?>
				<td class="numeric"><?php echo number_format($print_list->jumlah_barang,0,",",","); ?></td> 
				<td class="numeric">&nbsp;&nbsp;<?php echo number_format($print_list->harga_satuan,0,",",",").' '; ?></td> 
				<? /*
				<td class="numeric">&nbsp;&nbsp;<?php echo number_format($print_list->harga_satuan/1.1,0,",",",").' '; ?></td>
				<td class="numeric">&nbsp;&nbsp;<?php echo number_format($print_list->harga_satuan-$print_list->harga_satuan/1.1,0,",",",").' '; ?></td>
				*/ ?>
				<td class="numeric"><?php echo number_format($print_list->diskon,0,",",","); ?></td> 
				<td class="numeric"><?php echo number_format($print_list->diskon_nilai,0,",",","); ?></td> 
				<td class="numeric"><?php echo substr($print_list->diskon_jenis,0,3); ?></td>
				<? if ($jenis == 'Produk' || $jenis == 'Paket') { ?>
					<td class="numeric"><?php echo number_format($print_list->voucher,0,",",","); ?></td>
				<?} else { ?>
					<td class="numeric"><?php echo number_format($print_list->voucher_medis,0,",",","); ?></td> 
					<td class="numeric"><?php echo number_format($print_list->voucher,0,",",","); ?></td> 
				<? } ?>
				<td><?php echo $print_list->sales; ?></td> 
				<td class="numeric"><?php echo number_format($print_list->subtotal,0,",",","); ?></td> 
				<td class="numeric"><?php echo number_format((($print_list->harga_satuan/1.1)*$print_list->jumlah_barang)-
				((($print_list->harga_satuan/1.1)*$print_list->jumlah_barang)*$print_list->diskon/100),0,",",","); ?></td> 
				<td class="numeric"><?php echo number_format($print_list->subtotal-
				((($print_list->harga_satuan/1.1)*$print_list->jumlah_barang)-((($print_list->harga_satuan/1.1)*$print_list->jumlah_barang)*$print_list->diskon/100)),0,",",","); ?></td> 
				<td class="numeric"><?php echo number_format($print_list->bayar_card,0,",",",");?></td>
				<td class="numeric"><?php echo number_format($print_list->bayar_tunai,0,",",",");?></td>
				<td class="numeric"><?php echo number_format($print_list->bayar_kuitansi,0,",",",");?></td>
				<td class="numeric"><?php echo number_format($print_list->bayar_transfer,0,",",",");?></td>
				<td class="numeric"><?php echo number_format($print_list->bayar_cek,0,",",",");?></td>
			</tr> <?php } ?> <?php } ?> 
			<tr> 
				<? if ($jenis == 'Produk') { ?>
					<td align="right" colspan="8"><b>Total</td> 
				<? } else { ?>
					<td align="right" colspan="7"><b>Total</td> 
				<? } ?>
				<td align="right" class="numeric"><b><?php echo number_format($sub_jumlah_barang,0,",",","); ?></b></td> 
				<td align="right" class="numeric">&nbsp;</td> 
				<td align="right" class="numeric">&nbsp;</td> 
				<td align="right" class="numeric">&nbsp;</td>
				<td align="right" class="numeric">&nbsp;</td>
				<td align="right" class="numeric"><b><?php echo number_format($sub_diskon,0,",",","); ?></b></td> 
				<td align="right" class="numeric">&nbsp;</td> 
				<? if ($jenis == 'Produk' || $jenis == 'Paket') { ?>
					<td align="right" class="numeric"><b><?php echo number_format($total_voucher_nonmedis,0,",",","); ?></b></td>
				<? } else { ?>
					<td align="right" class="numeric"><b><?php echo number_format($total_voucher_medis,0,",",","); ?></b></td> 
					<td align="right" class="numeric"><b><?php echo number_format($total_voucher_nonmedis,0,",",","); ?></b></td>
				<? } ?>
				<td align="right" class="numeric">&nbsp;</td>
				<td align="right" class="numeric"><b><?php echo number_format($sub_total,0,",",","); ?></b></td> 
				<td align="right" class="numeric"><b><?php echo number_format($sub_total_dpp,0,",",","); ?></b></td> 
				<td align="right" class="numeric"><b><?php echo number_format($sub_total_ppn,0,",",","); ?></b></td> 
				<td align="right" class="numeric"><b><?php echo number_format($total_card,0,",",","); ?></b></td>
				<td align="right" class="numeric"><b><?php echo number_format($total_tunai,0,",",","); ?></b></td>
				<td align="right" class="numeric"><b><?php echo number_format($total_kuitansi,0,",",","); ?></b></td>
				<td align="right" class="numeric"><b><?php echo number_format($total_transfer,0,",",","); ?></b></td>
				<td align="right" class="numeric"><b><?php echo number_format($total_cek,0,",",","); ?></b></td>
			</tr> <?php } $tanggal=$print->tanggal; ?><?php } ?> 
</tbody> 
<tfoot> 
	<tr> 
		<td class="clear">&nbsp;</td> 
		<th scope='row' nowrap="nowrap" colspan='2'>Jumlah data</th> 
		<? if ($jenis == 'Produk') { ?>
			<td colspan='5'><?php echo count($data_print); ?> data</td> 
		<? } else { ?>
			<td colspan='4'><?php echo count($data_print); ?> data</td> 
		<? } ?>
		<td class="numeric clear" nowrap="nowrap"><?php echo number_format($total_item,0,",",","); ?></td>
		<td class="clear">&nbsp;</td>
		<td class="clear">&nbsp;</td>
		<td class="clear">&nbsp;</td>
		<td class="clear">&nbsp;</td>
		<td class="numeric clear" nowrap="nowrap"><?php echo number_format($grand_total_diskon,0,",",","); ?></td>
		<td class="clear">&nbsp;</td>
		<? if ($jenis == 'Produk' || $jenis == 'Paket') { ?>
			<td class="numeric clear" nowrap="nowrap"><?php echo number_format($grand_total_voucher_nonmedis,0,",",","); ?></td>
		<?} else { ?>
			<td class="numeric clear" nowrap="nowrap"><?php echo number_format($grand_total_voucher_medis,0,",",","); ?></td> 
			<td class="numeric clear" nowrap="nowrap"><?php echo number_format($grand_total_voucher_nonmedis,0,",",","); ?></td> 
		<? } ?>
		<td class="clear">&nbsp;</td>
		<td class="numeric clear" nowrap="nowrap"><?php echo number_format($grand_total_total,0,",",","); ?></td> 
		<td class="numeric clear" nowrap="nowrap"><?php echo number_format($grand_total_dpp,0,",",","); ?></td> 
		<td class="numeric clear" nowrap="nowrap"><?php echo number_format($grand_total_ppn,0,",",","); ?></td> 
		<td class="numeric clear" nowrap="nowrap"><?php echo number_format($grand_total_card,0,",",","); ?></td> 
		<td class="numeric clear" nowrap="nowrap"><?php echo number_format($grand_total_tunai,0,",",","); ?></td>
		<td class="numeric clear" nowrap="nowrap"><?php echo number_format($grand_total_kuitansi,0,",",","); ?></td>
		<td class="numeric clear" nowrap="nowrap"><?php echo number_format($grand_total_transfer,0,",",","); ?></td>
		<td class="numeric clear" nowrap="nowrap"><?php echo number_format($grand_total_cek,0,",",","); ?></td>
	</tr> 
</tfoot>
</table>
</body>
</html>