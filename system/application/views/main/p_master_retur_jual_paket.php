<?php
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: inbox Print
	+ Description	: For Print View
	+ Filename 		: p_inbox.php
 	+ Author  		: 
 	+ Created on 01/Feb/2010 14:30:05
	
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Daftar Retur Penjualan Paket</title>
<link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle.css'/>
</head>
<body onload="window.print();">
<table summary='Inbox List'>
  <caption>
    Daftar Retur Penjualan Paket
  </caption>
  <thead>
    <tr>
      <th scope='col'>No</th>
      <th scope='col'>Tanggal</th>
      <th scope='col'>No. Faktur</th>
      <th scope='col'>No. Faktur Jual</th>
      <th scope='col'>No. Cust</th>
      <th scope='col'>Customer</th>
      <th scope='col'>Nilai Kuitansi (Rp)</th>
      <th scope='col'>Keterangan</th>
      <th scope='col'>Stat Dok</th>
    </tr>
  </thead>
  <tfoot>
    <tr>
      <th scope='row'>Total</th>
      <td colspan='8'><?php echo count($data_print); ?></td>
    </tr>
  </tfoot>
  <tbody>
    <?php $i=0; foreach($data_print as $print) { $i++; ?>
    <tr>
      <td><? echo $i; ?></td>
      <td><?php echo $print->rpaket_tanggal; ?></td>
      <td><?php echo $print->rpaket_nobukti; ?></td>
      <td><?php echo $print->jpaket_nobukti; ?></td>
      <td><?php echo $print->cust_no; ?></td>
      <td><?php echo $print->cust_nama; ?></td>
      <td><?php echo $print->kwitansi_nilai; ?></td>
      <td><?php echo $print->rpaket_keterangan; ?></td>
      <td><?php echo $print->rpaket_stat_dok; ?></td>
    </tr>
    <?php } ?>
  </tbody>
</table>
<body onload='window.print()'>
</body>
</html>