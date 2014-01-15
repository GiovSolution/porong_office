<?php /* These code was generated using phpCIGen v 0.1.b (24/06/2009)#zaqi zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, #CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id+ Module : Penjualan Print+ Description: For Print View+ Filename : p_detail_jual.php + Author : + Created on 01/Feb/2010 14:30:05*/?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Laporan Detail Penjualan <?php echo $jenis; ?> <?php echo $periode; ?> Group By <?php echo $group; ?> </title>
	<link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle.css'/>
</head>
<body onload="window.print();">
<table summary='Detail Jual'>
<caption>Laporan Detail Penjualan <?php echo $jenis; ?><br/><?php echo $periode; ?> <br/>Group By <?php echo $group; ?>, Opsi by <?php echo $opsi; ?></caption>
<thead> 
	<tr> 
		<?//<td scope='col'></td>?>
		<th scope='col'>No</th>
		<th scope='col'>Kode</th> 
		<th scope='col'>Nama Barang/Jasa</th> 
		<?php //<th scope='col'>Satuan</th>?> 
		<th scope='col'>Jumlah</th> 
		<th scope='col'>Harga</th> 
		<th scope='col'>Disk (%)</th> 
		<th scope='col'>Disk (Rp)</th> 
		<th scope='col'>Jenis Disk</th> 
		<th scope='col'>Sales</th> 
		<th scope='col'>Total (Rp)</th> 
	</tr> 
</thead>
<tbody>
<?php 
	$i=0; 
	$j=0; 
	$faktur=""; 
	$total_item=0;
	$total_diskon=0;
	$total_nilai=0;
	$total_voucher=0;
	$total_diskon_persen=0;
	$total_bayar=0;
	$total_hutang=0;
	$total_card=0;
	$total_tunai=0;
	$total_kuitansi=0;
	$total_transfer=0;
	$total_cek=0;
	foreach($data_print as $print) { ?><?php 
		if($faktur!==$print->no_bukti) { 
			$total_voucher+=$print->voucher;
			$total_bayar+=$print->bayar;
			$total_hutang+=$print->totalbiaya-$print->bayar;
			// total cara bayar
			$total_card+=$print->bayar_card;
			$total_tunai+=$print->bayar_tunai;
			$total_kuitansi+=$print->bayar_kuitansi;
			$total_transfer+=$print->bayar_transfer;
			$total_cek+=$print->bayar_cek;
			
			
			if ($print->keterangan == ''){ 
				$print->keterangan = '-'; }?>
				<tr>
				<?//<td></td>?>
					<td>
						<b><?php $j++; echo $j; ?></b>
					</td>
					<td colspan="9"><b><?php echo "".$print->no_bukti.", ".$print->tanggal.", ".$print->cust_nama."(".$print->cust_no."), Ket : ".$print->keterangan."";?></b>
					</td> 
				</tr>
				<?php 
				$sub_cashback=0;
				$sub_total=0;
				$sub_diskon=0;
				$sub_jumlah_barang=0;
				$i=0; ?><?php 
				foreach($data_print as $print_list) { ?><?php 
					if($print_list->no_bukti==$print->no_bukti){ 
						$i++; 
						$sub_jumlah_barang+=$print_list->jumlah_barang;
						$sub_diskon+=$print_list->diskon_nilai;
						$sub_total+=$print_list->subtotal;
						$total_item+=$print_list->jumlah_barang;
						$total_diskon+=$print_list->diskon_nilai;
						$total_nilai+=$print_list->subtotal; 
						$total_diskon_persen+=(($print_list->subtotal*$print->diskon_umum)/100);
				?>
						<tr>
							<?/*
							<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
							*/
							?>
							<td><?php echo $i; ?></td> 
							<td><?php echo $print_list->produk_kode; ?></td> 
							<td><?php echo $print_list->produk_nama;?></td>
							<?php //<td> echo $print_list->satuan_nama; </td> ?> 
							<td class="numeric"><?php echo number_format($print_list->jumlah_barang,0,",",","); ?></td> 
							<td class="numeric"><?php echo number_format($print_list->harga_satuan,0,",",","); ?></td> 
							<td class="numeric"><?php echo number_format($print_list->diskon,0,",",","); ?></td> 
							<td class="numeric"><?php echo number_format($print_list->diskon_nilai,0,",",","); ?></td> 
							<td class="title_main"><?php echo $print_list->diskon_jenis; ?></td> 
							<td><?php echo $print_list->sales; ?></td> 
							<td class="numeric"><?php echo number_format($print_list->subtotal,0,",",","); ?></td> 
						</tr><?php } ?><?php } ?>
						<tr> 
							<?//<td></td>?>
							<td colspan="3"><b>Jum Item</td> 
							<td align="right" class="numeric"><b><?php echo number_format($sub_jumlah_barang,0,",",","); ?></b></td> 
							<td align="right" class="numeric">&nbsp;</td> 
							<td align="right" class="numeric">&nbsp;</td> 
							<td colspan="3" align="right" class="numeric"><b>Sub Tot (Rp)</td>
							<td align="right" class="numeric"><b><?php echo number_format($sub_total,0,",",","); ?></b></td> 
						</tr>
						<tr> 
							<?//<td></td>?>
							<td colspan="4"><b>
								<table class="bayar">
									<tr>
										<td align="right" class="title" width="50" height="17"><b>Card</b></td> 
										<td align="right" class="title" width="50" height="17"><b>Tunai</b></td> 
										<td align="right" class="title" width="50" height="17"><b>Kuitansi</b></td> 
										<td align="right" class="title" width="50" height="17"><b>Transfer</b></td> 
										<td align="right" class="title" width="50" height="17"><b>Cek/Giro</b></td> 
									</tr>
								</table>
							</td>  
							<td align="right" class="numeric"><b>Disk (%)</b></td> 
							<td align="right" class="numeric"><?php echo number_format($print->diskon_umum,0,",",","); ?></td> 
							<td align="right" class="numeric"><b>Voucher (Rp)</b></td> 
							<td align="right" class="numeric"><?php echo number_format($print->voucher,0,",",","); ?></td> 
							<td align="right" class="numeric"><b>Total (Rp)</b></td> 
							<td align="right" class="numeric"><b><?php echo number_format($print->totalbiaya,0,",",","); ?></b></td> 
						</tr>
						<tr> 
							<?//<td></td>?>
							<td colspan="4"><b>
								<table class="bayar">
								<tr>
									<td align="right" class="numeric_bayar" width="50" height="17"><?php echo number_format($print->bayar_card,0,",",","); ?></td> 
									<td align="right" class="numeric_bayar" width="50" height="17"><?php echo number_format($print->bayar_tunai,0,",",","); ?></td> 
									<td align="right" class="numeric_bayar" width="50" height="17"><?php echo number_format($print->bayar_kuitansi,0,",",","); ?></td> 
									<td align="right" class="numeric_bayar" width="50" height="17"><?php echo number_format($print->bayar_transfer,0,",",","); ?></td> 
									<td align="right" class="numeric_bayar" width="50" height="17"><?php echo number_format($print->bayar_cek,0,",",","); ?></td> 
								</tr>
								</table>
							</td> 
							<td align="right" class="numeric">&nbsp;</td> 
							<td align="right" class="numeric">&nbsp;</td> 
							<td align="right" class="numeric"><b>Hutang (Rp)</b></td> 
							<td align="right" class="numeric"><b><?php echo number_format($print->totalbiaya-$print->bayar,0,",",","); ?></b></td> 
							<td align="right" class="numeric"><b>Tot Bayar (Rp)</b></td> 
							<td align="right" class="numeric"><b><?php echo number_format($print->bayar,0,",",","); ?></b></td> 
						</tr>
						<? /*
						<tr> 
							<td colspan="7"><b>&nbsp;</td> 
							<td align="right" class="numeric">&nbsp;</td> 
							<td align="right" class="numeric"><b>Tot Bayar (Rp)</b></td> 
							<td align="right" class="numeric"><b><?php echo number_format($print->bayar,0,",",","); ?></b></td> 
						</tr>
						<tr> 
							<td colspan="8"><b>&nbsp;</td> 
							<td align="right" class="numeric"><b>Hutang (Rp)</b></td> 
							<td align="right" class="numeric"><b><?php echo number_format($print->totalbiaya-$print->bayar,0,",",","); ?></b></td> 

						</tr>
						<tr> 
							<td colspan="3"><b>Total</td> 
							<td align="right" class="numeric"><b><?php echo number_format($sub_jumlah_barang,0,",",","); ?></b></td> 
							<td align="right" class="numeric">&nbsp;</td> 
							<td align="right" class="numeric">&nbsp;</td> 
							<td align="right" class="numeric"><b><?php echo number_format($sub_diskon,0,",",","); ?></b></td> 
							<td align="right" class="numeric">&nbsp;</td> 
							<td align="right" class="numeric">&nbsp;</td> 
							<td align="right" class="numeric"><b><?php echo number_format($sub_total,0,",",","); ?></b></td> 
						</tr>
						*/ 
						?>
						<?php } $faktur=$print->no_bukti; ?>
				<?php } ?>
</tbody>

<tfoot>
<tr> 
	<?//<td class="clear"></td>?>
	<td class="foot">&nbsp;</td> 
	<th scope='row' nowrap="nowrap">&nbsp;</th> 
	<td colspan='8' class="foot">&nbsp;</td> 
</tr> 
<tr> 
	<?//<td class="clear"></td>?>
	<td class="foot">&nbsp;</td> 
	<th scope='row' nowrap="nowrap">&nbsp;</th> 
	<td colspan='8' class="foot">&nbsp;</td> 
</tr> 
<tr>
	<?//<td class="clear"></td>?>
	<td class="foot">&nbsp;</td> 
	<th scope='row' nowrap="nowrap">&nbsp;</th> 
	<td colspan='8' class="foot">&nbsp;</td> 
</tr> 
</tfoot>

 
<? //<tfoot> ?>
<tr> 
	<?//<td></td>?>
	<td class="foot">&nbsp;</td> 
	<th scope='row' nowrap="nowrap">Jum data</th> 
	<td colspan='8' class="foot"><?php echo count($data_print); ?> data</td> 
</tr> 
<tr> 
	<?//<td></td>?>
	<td class="foot">&nbsp;</td> 
	<th scope='row' colspan="2">Summary</th> 
	<td class="foot">&nbsp;</td> 
	<th scope='row' colspan="6">Cara Bayar :</th>
</tr> 
<tr> 
	<?//<td></td>?>
	<td class="foot">&nbsp;</td> 
	<th scope='row' nowrap="nowrap">Tot Item</th> 
	<td class="numeric foot" nowrap="nowrap"><?php echo number_format($total_item,0,",",","); ?></td> 
	<td class="foot">&nbsp;</td> 
	<th scope='row' nowrap="nowrap">Card (Rp)</th> 
	<td class="numeric foot" nowrap="nowrap" colspan="2"><?php echo number_format($total_card,0,",",","); ?></td>
	<td class="foot" colspan="3">&nbsp;</td>
</tr> 
<tr> 
	<?//<td></td>?>
	<td class="foot">&nbsp;</td> 
	<th scope='row' nowrap="nowrap">Total (Rp)</th> 
	<td class="numeric foot" nowrap="nowrap"><?php echo number_format($total_nilai,0,",",","); ?></td> 
	<td class="foot">&nbsp;</td> 
	<th scope='row' nowrap="nowrap">Tunai (Rp)</th> 
	<td class="numeric foot" nowrap="nowrap" colspan="2"><?php echo number_format($total_tunai,0,",",","); ?></td>
	<td class="foot" colspan="3">&nbsp;</td>
</tr>
<tr> 
	<?//<td></td>?>
	<td class="foot">&nbsp;</td> 
	<th scope='row' nowrap="nowrap">Total Disk (Rp)</th> 
	<td class="numeric foot" nowrap="nowrap" ><?php echo number_format($total_diskon_persen,0,",",","); ?></td> 
	<td class="foot">&nbsp;</td>
	<th scope='row' nowrap="nowrap">Kuitansi (Rp)</th> 
	<td class="numeric foot" nowrap="nowrap" colspan="2"><?php echo number_format($total_kuitansi,0,",",","); ?></td>
	<td class="foot" colspan="3">&nbsp;</td>
</tr> 
<tr> 
	<?//<td></td>?>
	<td class="foot">&nbsp;</td> 
	<th scope='row' nowrap="nowrap">Total Voucher (Rp)</th> 
	<td class="numeric foot" nowrap="nowrap" ><?php echo number_format($total_voucher,0,",",","); ?></td> 
	<td class="foot">&nbsp;</td> 
	<th scope='row' nowrap="nowrap">Cek/Giro (Rp)</th> 
	<td class="numeric foot" nowrap="nowrap" colspan="2"><?php echo number_format($total_cek,0,",",","); ?></td>
	<td class="foot" colspan="3">&nbsp;</td>
</tr> 
<tr> 
	<?//<td></td>?>
	<td class="foot">&nbsp;</td> 
	<th scope='row' nowrap="nowrap">Total Bayar (Rp)</th> 
	<td class="numeric foot" nowrap="nowrap" ><?php echo number_format($total_bayar,0,",",","); ?></td> 
	<td class="foot">&nbsp;</td>
	<th scope='row' nowrap="nowrap">Transfer (Rp)</th> 
	<td class="numeric foot" nowrap="nowrap" colspan="2"><?php echo number_format($total_transfer,0,",",","); ?></td>
	<td class="foot" colspan="3">&nbsp;</td>
</tr> 
<tr> 
	<?//<td></td>?>
	<td class="foot">&nbsp;</td> 
	<th scope='row' nowrap="nowrap">Total Hutang (Rp)</th> 
	<td class="numeric foot" nowrap="nowrap" ><?php echo number_format($total_hutang,0,",",","); ?></td> 
	<td colspan="7" class="foot">&nbsp;</td> 
</tr> 
<tr> 
	<?//<td></td>?>
	<td class="foot">&nbsp;</td> 
	<th scope='row' nowrap="nowrap">Total Net Sales Produk (Rp)</th> 
	<td class="numeric foot" nowrap="nowrap" ><?php echo number_format($total_nilai-$total_voucher,0,",",","); ?></td> 
	<td colspan="7" class="foot">&nbsp;</td> 
</tr> 

<? //</tfoot> ?>
</table>
</body>
</html>