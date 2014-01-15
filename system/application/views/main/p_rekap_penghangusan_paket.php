<?php /* Miracle IT Team*/ ?>
<!DOCTYPE html PUBLIC "-//W3C<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Laporan Rekap Penghangusan Sisa Paket <?php echo $periode; ?> Group By Tanggal Penghangusan</title>
	<link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle.css'/>
</head>
<body onload="window.print();">
<table summary='Rekap Jual'>
	<caption>
		Laporan Penghangusan Sisa Paket <br/><?php echo $periode; ?> Group By Tanggal Penghangusan
	</caption>
	<thead> 
		<tr> 
			<th scope='col'>No</th> 
			<th scope='col'>Tgl Penghangusan</th> 
			<th scope='col'>No Cust</th> 
			<th scope='col'>Customer</th> 
			<th scope='col'>Paket Nama</th>
			<th scope='col'>No Faktur</th> 
			<th scope='col'>Tgl Faktur</th> 
			<th scope='col'>Harga Paket</th> 
			<th scope='col'>Total Isi Paket</th> 
			<th scope='col'>Sisa Terakhir</th> 
			<th scope='col'>Nilai Write-Off</th> 
			<th scope='col'>Keterangan</th> 
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
		$total_nilai_penghangusan=0;
		foreach($data_print as $print) { 
			//$total_item+=$print->jumlah_barang;
			//$total_diskon+=$print->cashback;
			//$total_diskonp+=($print->diskon*$print->total_nilai)/100;
			//$total_cashback+=$print->cashback;
			//$total_cashback_medis+=$print->cashback_medis;
			//$total_nilai+=$print->total_nilai;
			//$total_bayar+=$print->total_bayar;
			//$total_tunai+=$print->tunai;
			//$total_cek+=$print->cek;
			//$total_transfer+=$print->transfer;
			//$total_kuitansi+=$print->kuitansi;
			//$total_card+=$print->card;
			//$total_voucher+=$print->voucher;
			//$total_kredit+=$print->kredit;
			$i++; 
	?>
	<tr> 
		<td>
			<?php echo $i; ?>
		</td> 
		<td width="10">
			<?php echo $print->penghangusan_tanggal; ?>
		</td> 
		<td>
			<?php echo $print->cust_no; ?> &nbsp;
		</td>
		<td>
			<?php echo $print->cust_nama; ?> &nbsp;
		</td> 
		<td>
			<?php echo $print->paket_nama; ?> &nbsp;
		</td>
		<td>
			<?php echo $print->no_faktur; ?> &nbsp;
		</td>
		<td>
			<?php echo $print->tgl_beli_faktur; ?>
		</td>
		<? /*
		<td align="right" class="numeric">
			<?php echo number_format($print->diskon,0,",",","); ?>
		</td> 
		*/ ?>
			<td align="right" class="numeric">
				<?php echo number_format($print->harga_paket,0,",",","); ?>
			</td><?php /*<td align="right" class="numeric"><?php echo number_format($print->total_bayar,0,",",","); ?></td>*/ ?> 

		<td align="right" class="numeric">
			<?php echo number_format($print->total_isi_paket,0,",",","); ?>
		</td> 
		<td align="right" class="numeric">
			<?php echo number_format($print->sisa_terakhir,0,",",","); ?>
		</td> 
		<td align="right" class="numeric">
			<?php echo number_format($print->nilai_penghangusan_paket,0,",",","); ?> &nbsp;
		</td> 
		<td>
			<?php echo $print->keterangan; ?>
		</td>

		<? 
			
			$total_nilai_penghangusan+=$print->nilai_penghangusan_paket;
		?>
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
		<td align="right" class="numeric"><b><?php /*echo number_format($total_item,0,",",","); */?></td><?php ?> 
		<td align="right" class="numeric"><b><?php /*echo number_format($total_nilai,0,",",","); */?></td> <?php ?> 
		<?/*<td align="right" class="numeric"><b><?php echo number_format($total_diskonp,0,",",","); ?></td> <?php */?> 
		
		<td align="right" class="numeric"><b><?php /*echo number_format($total_cashback,0,",",","); */?></td>
	
		<td align="right" class="numeric"><b><?php /*echo number_format($total_tunai,0,",",","); */?></td> <?php ?> 
		<td align="right" class="numeric"><b><?php /*echo number_format($total_cek,0,",",","); */?></td> <?php ?> 
		<td align="right" class="numeric"><b><?php echo number_format($total_nilai_penghangusan,0,",",","); ?></td> <?php ?> 

		<td align="right" class="numeric"><b><?php /*echo number_format($total_voucher,0,",",",");*/ ?></td> <?php  ?> 
 </tr>
	</tfoot>
</table>
</body>
</html>