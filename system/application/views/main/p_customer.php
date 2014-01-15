<?php /* These code was generated using phpCIGen v 0.1.b (24/06/2009)#zaqi zaqi.smart@gmail.com,http:#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id+ Module : outbox Print+ Description: For Print View+ Filename : p_outbox.php + Author : + Created on 01/Feb/2010 14:30:05*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Daftar Customer</title>
	<link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle.css'/>
</head><body onload='window.print()'>
<table summary='Customer List'>
<caption>DAFTAR CUSTOMER</caption>
<thead>
	<tr>
		<th>No</th>
		<th>No Cust</th>
		<th>Nama Lengkap</th>
		<th>No Member</th>
		<th>Tgl Valid</th>
		<th>L/P</th>
		<th>Alamat </th>
		<th>Kota</th>
		<? //<th>Telp Rumah</th> ?>
		<? //<th>No Ponsel</th> ?>
		<th>Stat Nikah</th>
		<th>Status</th>
	</tr>
</thead>
<tbody>
<?php $i=0; foreach($data_print as $print) { $i++; ?>
	<tr>
		<td><?php echo $i; ?></td>
		<td><?php echo $print->cust_no; ?></td>
		<td><?php echo $print->cust_nama; ?></td>
		<td><?php echo $print->member_no; ?></td>
		<td><?php echo $print->member_valid; ?></td>
		<td><?php echo $print->cust_kelamin; ?></td>
		<td><?php echo $print->cust_alamat; ?></td>
		<td><?php echo $print->cust_kota; ?></td>
		<?//<td> echo $print->cust_telprumah; </td> ?>
		<?//<td> echo $print->cust_hp; </td> ?>
		<td><?php echo $print->cust_statusnikah; ?></td>
		<td><?php echo $print->cust_aktif; ?></td>
	</tr>
	<?php } ?>
</tbody>
<tfoot>
	<tr>
		<th scope='row'>Total</th>
		<td colspan="10"><?php echo count($data_print) ?> </td>
	</tr> </tfoot>
</table>
</body>
</html>