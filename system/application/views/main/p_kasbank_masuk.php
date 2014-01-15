<?php
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com,
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id

	+ Module  		: tbl_t_jurnal Print
	+ Description	: For Print View
	+ Filename 		: p_tbl_t_kasbank.php
 	+ Author  		:
 	+ Created on 13/Jul/2010 12:13:56

*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Kas Bank Masuk List</title>
<link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle.css'/>
</head>
<table summary='Tbl T Jurnal List'>
	<caption>Kas Bank Masuk List</caption>
	<thead>
		<tr>
			<th scope='col'>No</th>
			<th scope='col'>Tanggal</th>
			<th scope='col'>No. Bukti</th>
			<th scope='col'>Nama Akun</th>
			<th scope='col'>Kode Akun</th>
			<th scope='col'>Terima</th>
			<th scope='col'>No. Ref.</th>
			<th scope='col'>Nilai</th>
			<th scope='col'>Keterangan</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th scope='row'>Total</th>
			<td colspan='8'><?php echo count($data_print); ?></td>
		</tr>
	</tfoot>
	<tbody>
		<?php $i=0; $total=0; foreach($data_print as $print) { $i++; $total+=$print->kasbank_debet; ?>
		<tr>
			<td><? echo $i; ?></td>
			<td><?php echo $print->kasbank_tanggal; ?></td>
			<td><?php echo $print->kasbank_nobukti; ?></td>
			<td><?php echo $print->akun_nama; ?></td>
			<td><?php echo $print->akun_kode; ?></td>
			<td><?php echo $print->kasbank_terimauntuk; ?></td>
			<td><?php echo $print->kasbank_noref; ?></td>
			<td class="numeric" align="right"><?php echo number_format($print->kasbank_debet); ?></td>
			<td><?php echo $print->kasbank_keterangan; ?></td>
		</tr>
		<?php } ?>
		<tr>
			<td colspan="7" class="numeric" align="right">Total</td>
			<td class="numeric" align="right"><?php echo number_format($total);?></td>
			<td>&nbsp;</td>
		</tr>
	</tbody>
<body>
</body>
</html>