<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Daftar Customer</title>
	<link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle_nocolor.css'/>
</head><body onload='window.print()'>
<table summary='Customer List' border="1" cellspacing="0" cellpadding="0" width="700">
<tr>
	<td colspan="6">
		<table border="0" cellspacing="0" cellpadding="0" class="clear" width="780">
			<tr>
				<td align="center"><center>
				<h1>BUKTI JURNAL UMUM</h1>
				</center>
				</td>
				<td>
					<table border="0" cellspacing="0" cellpadding="0">
						<tr class="clear">
							<td class="clear" align="right" >No Jurnal</td><td class="clear">:</td><td class="clear"><?php echo $no_bukti; ?></td>
						</tr>
						<tr class="clear">
							<td  class="clear" align="right">Tanggal</td><td class="clear">:</td><td class="clear"><?php echo $tanggal; ?></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td align="center" width="15"><b>No</b></td>
	<td align="center" width="80"><b>Kode Akun</b></td>
	<td align="center" width="175"><b>Nama Akun</b></td>
	<td align="center" width="175"><b>Uraian</b></td>
	<td align="center" width="80"><b>Debet (Rp)</b></td>
	<td align="center" width="80"><b>Kredit (Rp)</b></td>
</tr>
<?php $i=0;
	  $total_debet=0;
	  $total_kredit=0;
	foreach($data_print as $list_print) { $i++;?>
<tr class="clear">
	<td><?php echo $i; ?></td>
	<td><?php echo $list_print->akun_kode; ?></td>
	<td><?php echo $list_print->akun_nama; ?></td>
	<td><?php echo $list_print->uraian; ?></td>
	<td class="numeric" style="align:right"><?php echo number_format($list_print->debet); ?></td>
	<td class="numeric" style="align:right"><?php echo number_format($list_print->kredit); ?></td>
</tr>
<?php
	$total_kredit+=$list_print->kredit;
	$total_debet+=$list_print->debet;
	} ?>
<tr>
	<td colspan="4"> JUMLAH</td>
	<td class="numeric" style="align:right"> <?php echo number_format($total_debet);?></td>
	<td class="numeric" style="align:right"> <?php echo number_format($total_kredit);?></td>
</tr>
<tr class="clear">
	<td colspan="6"><?php echo "Terbilang : <b><i>".ucwords(terbilang($total_debet))." Rupiah</b></i>"; ?></td>
</tr>
<tfoot>
<tr>
	<table border="0" cellspacing="0" cellpadding="0" width="784">
		<tr class="clear">
			<td>
				Disetujui,
				<br/>
				<br/>
				<br/>
			</td>
			<td>
				Pembuat/Accounting,
				<br/>
				<br/>
				<br/>
			</td>
		</tr>
	</table>
</tr>
</tfoot>
</table>
</body>
</html>
