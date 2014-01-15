<?php
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: phonegroup Print
	+ Description	: For Print View
	+ Filename 		: p_phonegroup.php
 	+ Author  		: 
 	+ Created on 01/Feb/2010 14:30:05
	
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Laporan Penerimaan Kas <?php echo $periode; ?></title>
<link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle.css'/>
</head>
<body onload="window.print();">
<table summary='Laporan Penerimaan Kas'>
	<caption>Laporan Penerimaan Kas <br/> <?php echo $periode;  ?></caption>
	<thead>
    	<tr>
        	<th scope='col'>No</th>
            <th scope='col'>Jenis Transaksi</th>
            <th scope='col'>Tunai</th>
            <th scope='col'>Kuitansi</th>
            <th scope='col'>Kartu Kredit</th>
            <th scope='col'>Cek/Giro</th>
            <th scope='col'>Transfer</th>
            <?//<th scope='col'>Voucher</th>?>
            <th scope='col'>Total Nilai</th>
        </tr>
    </thead>
	<tbody>
		<?php 
			//produk
			$produk_tunai=0;
			$produk_kwitansi=0;
			$produk_kredit=0;
			$produk_cek=0;
			$produk_transfer=0;
			$produk_voucher=0;
			$produk_total=0;
			//rawat
			$rawat_tunai=0;
			$rawat_kwitansi=0;
			$rawat_kredit=0;
			$rawat_cek=0;
			$rawat_transfer=0;
			$rawat_voucher=0;
			$rawat_total=0;
			//paket
			$paket_tunai=0;
			$paket_kwitansi=0;
			$paket_kredit=0;
			$paket_cek=0;
			$paket_transfer=0;
			$paket_voucher=0;
			$paket_total=0;
			//kwitansi
			$kwitansi_tunai=0;
			$kwitansi_kwitansi=0;
			$kwitansi_kredit=0;
			$kwitansi_cek=0;
			$kwitansi_transfer=0;
			$kwitansi_voucher=0;
			$kwitansi_total=0;
			//lunas
			$lunas_tunai=0;
			$lunas_kwitansi=0;
			$lunas_kredit=0;
			$lunas_cek=0;
			$lunas_transfer=0;
			$lunas_voucher=0;
			$lunas_total=0;
			//total
			$total_tunai=0;
			$total_kwitansi=0;
			$total_kredit=0;
			$total_cek=0;
			$total_transfer=0;
			$total_voucher=0;
			$total_total=0;
			
			$i=0; 
			foreach($data_print as $print) { 
				$i++;
				if($print->jenis_transaksi=="Penjualan Produk")
				{
					$produk_tunai=$print->nilai_tunai;
					$produk_kwitansi=$print->nilai_kwitansi;
					$produk_kredit=$print->nilai_card;
					$produk_cek=$print->nilai_cek;
					$produk_transfer=$print->nilai_transfer;
					$produk_voucher=$print->nilai_voucher;
					$produk_total=$produk_tunai+$produk_kwitansi+$produk_kredit+$produk_cek+$produk_transfer+$produk_voucher;
				}elseif($print->jenis_transaksi=="Penjualan Perawatan")
				{
					$rawat_tunai=$print->nilai_tunai;
					$rawat_kwitansi=$print->nilai_kwitansi;
					$rawat_kredit=$print->nilai_card;
					$rawat_cek=$print->nilai_cek;
					$rawat_transfer=$print->nilai_transfer;
					$rawat_voucher=$print->nilai_voucher;
					$rawat_total=$rawat_tunai+$rawat_kwitansi+$rawat_kredit+$rawat_cek+$rawat_transfer+$rawat_voucher;
				}elseif($print->jenis_transaksi=="Penjualan Paket")
				{
					$paket_tunai=$print->nilai_tunai;
					$paket_kwitansi=$print->nilai_kwitansi;
					$paket_kredit=$print->nilai_card;
					$paket_cek=$print->nilai_cek;
					$paket_transfer=$print->nilai_transfer;
					$paket_voucher=$print->nilai_voucher;
					$paket_total=$paket_tunai+$paket_kwitansi+$paket_kredit+$paket_cek+$paket_transfer+$paket_voucher;
				}elseif($print->jenis_transaksi=="Penjualan Kuitansi")
				{
					$kwitansi_tunai=$print->nilai_tunai;
					$kwitansi_kwitansi=$print->nilai_kwitansi;
					$kwitansi_kredit=$print->nilai_card;
					$kwitansi_cek=$print->nilai_cek;
					$kwitansi_transfer=$print->nilai_transfer;
					$kwitansi_voucher=$print->nilai_voucher;
					$kwitansi_total=$kwitansi_tunai+$kwitansi_kwitansi+$kwitansi_kredit+$kwitansi_cek+$kwitansi_transfer+$kwitansi_voucher;	
				}elseif($print->jenis_transaksi=="Pelunasan Piutang")
				{
					$lunas_tunai=$print->nilai_tunai;
					$lunas_kwitansi=$print->nilai_kwitansi;
					$lunas_kredit=$print->nilai_card;
					$lunas_cek=$print->nilai_cek;
					$lunas_transfer=$print->nilai_transfer;
					$lunas_voucher=$print->nilai_voucher;
					$lunas_total=$lunas_tunai+$lunas_kwitansi+$lunas_kredit+$lunas_cek+$lunas_transfer+$lunas_voucher;	
				}
			}
			
			$total_tunai=$produk_tunai+$rawat_tunai+$paket_tunai+$kwitansi_tunai+$lunas_tunai;
			$total_kredit=$produk_kredit+$rawat_kredit+$paket_kredit+$kwitansi_kredit+$lunas_kredit;
			$total_kwitansi=$produk_kwitansi+$rawat_kwitansi+$paket_kwitansi+$kwitansi_kwitansi+$lunas_kwitansi;
			$total_cek=$produk_cek+$rawat_cek+$paket_cek+$kwitansi_cek+$lunas_cek;
			$total_transfer=$produk_transfer+$rawat_transfer+$paket_transfer+$kwitansi_transfer+$lunas_transfer;
			$total_voucher=$produk_voucher+$rawat_voucher+$paket_voucher+$kwitansi_voucher+$lunas_voucher;
			$total_nilai=$produk_total+$rawat_total+$paket_total+$kwitansi_total+$lunas_total;
			
		?>
        <tr>
        	<td>1.</td>
            <td>Penjualan Produk</td>
            <td  class="numeric"><?php echo number_format($produk_tunai); ?></td>
            <td  class="numeric"><?php echo number_format($produk_kwitansi); ?></td>
            <td  class="numeric"><?php echo number_format($produk_kredit); ?></td>
            <td  class="numeric"><?php echo number_format($produk_cek); ?></td>
            <td  class="numeric"><?php echo number_format($produk_transfer); ?></td>
            <?/*<td  class="numeric"><?php echo number_format($produk_voucher); ?></td>*/?>
            <td  class="numeric"><?php echo number_format($produk_total); ?></td>
       </tr>
        <tr>
        	<td>2.</td>
            <td>Penjualan Perawatan</td>
            <td  class="numeric"><?php echo number_format($rawat_tunai); ?></td>
            <td  class="numeric"><?php echo number_format($rawat_kwitansi); ?></td>
            <td  class="numeric"><?php echo number_format($rawat_kredit); ?></td>
            <td  class="numeric"><?php echo number_format($rawat_cek); ?></td>
            <td  class="numeric"><?php echo number_format($rawat_transfer); ?></td>
           <?/* <td  class="numeric"><?php echo number_format($rawat_voucher); ?></td>*/?>
            <td  class="numeric"><?php echo number_format($rawat_total); ?></td>
       </tr>
        <tr>
        	<td>3.</td>
            <td>Penjualan Paket</td>
            <td  class="numeric"><?php echo number_format($paket_tunai); ?></td>
            <td  class="numeric"><?php echo number_format($paket_kwitansi); ?></td>
            <td  class="numeric"><?php echo number_format($paket_kredit); ?></td>
            <td  class="numeric"><?php echo number_format($paket_cek); ?></td>
            <td  class="numeric"><?php echo number_format($paket_transfer); ?></td>
            <?/*<td  class="numeric"><?php echo number_format($paket_voucher); ?></td>*/?>
            <td  class="numeric"><?php echo number_format($paket_total); ?></td>
       </tr>
        <tr>
        	<td>4.</td>
            <td>Penjualan Kuitansi</td>
            <td  class="numeric"><?php echo number_format($kwitansi_tunai); ?></td>
            <td  class="numeric"><?php echo number_format($kwitansi_kwitansi); ?></td>
            <td  class="numeric"><?php echo number_format($kwitansi_kredit); ?></td>
            <td  class="numeric"><?php echo number_format($kwitansi_cek); ?></td>
            <td  class="numeric"><?php echo number_format($kwitansi_transfer); ?></td>
            <?/*<td  class="numeric"><?php echo number_format($kwitansi_voucher); ?></td>*/?>
            <td  class="numeric"><?php echo number_format($kwitansi_total); ?></td>
       </tr>
	   <tr>
        	<td>5.</td>
            <td>Pelunasan Piutang</td>
            <td  class="numeric"><?php echo number_format($lunas_tunai); ?></td>
            <td  class="numeric"><?php echo number_format($lunas_kwitansi); ?></td>
            <td  class="numeric"><?php echo number_format($lunas_kredit); ?></td>
            <td  class="numeric"><?php echo number_format($lunas_cek); ?></td>
            <td  class="numeric"><?php echo number_format($lunas_transfer); ?></td>
            <?/*<td  class="numeric"><?php echo number_format($lunas_voucher); ?></td>*/?>
            <td  class="numeric"><?php echo number_format($lunas_total); ?></td>
       </tr>
	</tbody>
    	<tfoot>
    	<tr>
        	<th scope='row'>Total</th>
            <td colspan='8'><?php echo count($data_print); ?> data</td>
        </tr>
        <tr>
        	<th scope='row' colspan="9">Resume</th>
        </tr>
        <tr><td class="clear">&nbsp;</td>
        	<th scope='row'>Total Tunai (Rp)</th>
            <td class="numeric"><?php echo number_format($total_tunai); ?></td>
            <td colspan='6' class="clear">&nbsp;</td>
        </tr>
        <tr><td class="clear">&nbsp;</td>
        	<th scope='row'>Diskon Kuitansi (Rp)</th>
            <td class="numeric"><?php echo number_format($total_kwitansi); ?></td>
            <td colspan='6' class="clear">&nbsp;</td>
        </tr>
        <tr><td class="clear">&nbsp;</td>
        	<th scope='row'>Total Kartu Kredit (Rp)</th>
            <td class="numeric"><?php echo number_format($total_kredit); ?></td>
            <td colspan='6' class="clear">&nbsp;</td>
        </tr>
        <tr><td class="clear">&nbsp;</td>
        	<th scope='row'>Total Cek/Giro (Rp)</th>
            <td class="numeric"><?php echo number_format($total_cek); ?></td>
            <td colspan='6' class="clear">&nbsp;</td>
        </tr>
        <tr><td class="clear">&nbsp;</td>
        	<th scope='row'>Total Transfer (Rp)</th>
            <td class="numeric"><?php echo number_format($total_transfer); ?></td>
            <td colspan='6' class="clear">&nbsp;</td>
        </tr>
		<? /*
        <tr><td class="clear">&nbsp;</td>
        	<th scope='row'>Total Voucher (Rp)</th>
            <td class="numeric"><?php echo number_format($total_voucher); ?></td>
            <td colspan='6' class="clear">&nbsp;</td>
        </tr>
		*/ ?>
        <tr><td class="clear">&nbsp;</td>
        	<th scope='row'>Total Nilai (Rp)</th>
            <td class="numeric"><?php echo number_format($total_nilai); ?></td>
            <td colspan='6' class="clear">&nbsp;</td>
        </tr>
	</tfoot>
</table>
</body>
</html>