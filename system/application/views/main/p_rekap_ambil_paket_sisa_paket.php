<?php
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#ISAAC SMART
	#IT MIRACLE CLINIC
	
	+ Module  		: Penjualan Print
	+ Description	: For Print View
	+ Filename 		: p_rekap_ambil_paket_sisa_paket.php
 	+ Author  		: isaac
 	+ Created on 01/Feb/2010 14:30:05
	
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Laporan Rekap Pengambilan Paket <?php echo $tanggal_akhir; ?> Group By Paket</title>
<link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle.css'/>
</head>
<body onload="window.print();">
<table width="1201" summary='Rekap Jual'>
	<caption>
	Laporan Detail Pengambilan Paket | <?php echo $tanggal_akhir; ?>Group By Sisa Paket</caption>
	<thead>
    	<tr>
			<th width="22" scope='col'>No</th>
        	<th width="22" scope='col'>No Faktur</th>
            <th width="75" scope='col'>Kode Paket</th>           
            <th width="300" scope='col'>Nama Paket</th>
            <th width="30" scope='col'>Tgl Beli</th>
			<th width="250" scope='col'>Customer</th>
			<th width="50" scope='col'>Freq Paket</th>
			<th width="50" scope='col'>Pengambilan</th>
			<th width="50" scope='col'>Sisa</th>
			<th width="100" scope='col'>Nilai Paket</th>
			<th width="100" scope='col'>Nilai Ambil Paket</th>
			<th width="100" scope='col'>Nilai Sisa Paket</th>
        </tr>
    </thead>
	<tbody>
		<?php 							
		$i=0;
		$total_item=0;
		$total_nilai_paket=0;
		$total_nilai_ambil_paket=0;
		$total_nilai_sisa_paket=0;
		$total_isi_paket=0;
		$total_pengambilan=0;
		$total_sisa_paket=0;
		
		foreach($data_print as $print) { 
			$i++;
			$total_nilai_paket+=$print->nilai_paket;
			$total_nilai_ambil_paket+=$print->nilai_ambil_paket;
			$total_nilai_sisa_paket+=$print->nilai_sisa_paket;
			$total_sisa_paket+=$print->sisa_paket;
			$total_isi_paket+=$print->total_jumlah;
			$total_pengambilan+=$print->pengambilan;
		?>
	
		<tr>
        	<td><? echo $i; ?></td>
            <td nowrap="nowrap"><?php echo $print->no_bukti;  ?></td>
            <td><?php echo $print->paket_kode; ?></td>
			<td><?php echo $print->paket_nama; ?></td>
			<td><?php echo $print->tanggal_beli; ?></td>
			<td><?php echo $print->cust_nama; ?></td>
			<td align="right" class="numeric"><?php echo $print->total_jumlah; ?></td>
			<td align="right" class="numeric"><?php echo $print->pengambilan; ?></td>
			<td align="right" class="numeric"><?php echo $print->sisa_paket; ?></td>
			<td align="right" class="numeric"><?php echo number_format($print->nilai_paket,0,",",","); ?></td>
			<td align="right" class="numeric"><?php echo number_format($print->nilai_ambil_paket,0,",",","); ?></td>
			<td align="right" class="numeric"><?php echo number_format($print->nilai_sisa_paket,0,",",","); ?></td>
       </tr>
		<?php //}
		}
		?>
	</tbody>
	 <tfoot>
	<tr> 
		<?//<td class="clear"></td>?>
		<td class="foot">&nbsp;</td> 
		<th scope='row' nowrap="nowrap">&nbsp;</th> 
		<td colspan='10' class="foot">&nbsp;</td> 
	</tr> 
	</tfoot>

		<tr> 
			<?//<td></td>?>
			<td class="foot">&nbsp;</td> 
			<th scope='row' nowrap="nowrap">Jum data</th> 
			<td colspan='10' class="foot"><?php echo count($data_print); ?> data</td> 
		</tr> 
		<tr> 
			<?//<td></td>?>
			<td class="foot">&nbsp;</td> 
			<th scope='row' nowrap="nowrap">Total Freq Paket</th> 
			<td class="foot">&nbsp;</td> 
			<td class="numeric foot" nowrap="nowrap" ><?php echo number_format($total_isi_paket,0,",",","); ?></td> 
			<td colspan="8" class="foot">&nbsp;</td> 
		</tr> 
		<tr> 
			<?//<td></td>?>
			<td class="foot">&nbsp;</td> 
			<th scope='row' nowrap="nowrap">Total Pengambilan Paket</th> 
			<td class="foot">&nbsp;</td> 
			<td class="numeric foot" nowrap="nowrap" ><?php echo number_format($total_pengambilan,0,",",","); ?></td> 
			<td colspan="8" class="foot">&nbsp;</td> 
		</tr> 
		<tr> 
			<?//<td></td>?>
			<td class="foot">&nbsp;</td> 
			<th scope='row' nowrap="nowrap">Total Sisa Paket</th> 
			<td class="foot">&nbsp;</td> 
			<td class="numeric foot" nowrap="nowrap" ><?php echo number_format($total_sisa_paket,0,",",","); ?></td> 
			<td colspan="8" class="foot">&nbsp;</td> 
		</tr> 
		<tr> 
			<?//<td></td>?>
			<td class="foot">&nbsp;</td> 
			<th scope='row' nowrap="nowrap">Total Nilai Paket</th> 
			<td class="foot">&nbsp;</td> 
			<td class="numeric foot" nowrap="nowrap" ><?php echo number_format($total_nilai_paket,0,",",","); ?></td> 
			<td colspan="8" class="foot">&nbsp;</td> 
		</tr> 
		<tr> 
			<?//<td></td>?>
			<td class="foot">&nbsp;</td> 
			<th scope='row' nowrap="nowrap">Total Nilai Ambil Paket</th> 
			<td class="foot">&nbsp;</td> 
			<td class="numeric foot" nowrap="nowrap" ><?php echo number_format($total_nilai_ambil_paket,0,",",","); ?></td> 
			<td colspan="8" class="foot">&nbsp;</td> 
		</tr> 
		<tr> 
			<?//<td></td>?>
			<td class="foot">&nbsp;</td> 
			<th scope='row' nowrap="nowrap">Total Nilai Sisa Paket</th> 
			<td class="foot">&nbsp;</td> 
			<td class="numeric foot" nowrap="nowrap" ><?php echo number_format($total_nilai_sisa_paket,0,",",","); ?></td> 
			<td colspan="8" class="foot">&nbsp;</td> 
		</tr>	
</table>
</body>
</html>