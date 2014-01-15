<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cetak Waktu Tunggu</title>
<style type="text/css">
html,body,table,tr,td{
	font-family:Geneva, Arial, Helvetica, sans-serif;
	font-size:12px;
}
.title{
	font-size:12px;
}
</style>
</head>
<body onload="window.print()"><table summary='Rekap Jual' border='1' cellspacing="0px">
<caption><b>Laporan Waktu Tunggu <?php echo $groupby; ?><br/><?php echo $periode; ?> <br/><br/></b></caption>
<thead> 
<tr> 
	<th scope='col'>No</th> 
	<th scope='col'>Tanggal</th> 
	<th scope='col'>Jml Cust <=</th> 
	<th scope='col'>Rata2 Waktu <=</th> 
	<th scope='col'>Jml Cust ></th> 
	<th scope='col'>Rata2 Waktu ></th>
	<th scope='col'>Total Cust</th> 
	<th scope='col'>Rata2 Waktu Tot</th> 
</tr> 
</thead>

<tbody><?php $i=0; 
			$grandtot_cust_kurg=0;
			$grandtot_cust_lbh=0;
			$grandtot_wkt_kurg=0;
			$grandtot_wkt_lbh=0;
			$grandtot_cust_tot=0;
			$grandtot_wkt_tot=0;
			$tot_wkt_kurg=0;
			$tot_wkt_lbh=0;
			$tot_wkt_tot=0;

			foreach($data_print as $print) { 
			$i++; 
			$grandtot_cust_kurg+= $print->jum_cust_kurg;
			$grandtot_cust_lbh+=$print->jum_cust_lbh;
			$grandtot_cust_tot+=$print->tot_cust;
			$tot_wkt_kurg+= (strtotime($print->wkt_tunggu_kurg)-strtotime("00:00:00")+ 17*3600) * $print->jum_cust_kurg;
			$grandtot_wkt_kurg= $tot_wkt_kurg / $grandtot_cust_kurg;
			$tot_wkt_lbh+= (strtotime($print->wkt_tunggu_lbh)-strtotime("00:00:00")+ 17*3600) * $print->jum_cust_lbh;
			$grandtot_wkt_lbh= $tot_wkt_lbh / $grandtot_cust_lbh;
			$tot_wkt_tot+= (strtotime($print->rata_total_wkt_tunggu)-strtotime("00:00:00")+ 17*3600) * $print->tot_cust;
			$grandtot_wkt_tot= $tot_wkt_tot / $grandtot_cust_tot;
			?>
			<tr> 
				<td align="center"><?php echo $i; ?></td> 
				<td align="center"><?php echo $print->tgl; ?></td> 
				<td align="center"><?php echo $print->jum_cust_kurg; ?></td>
				<td align="center"><?php echo $print->wkt_tunggu_kurg; ?></td>
				<td align="center"><?php echo $print->jum_cust_lbh; ?></td> 
				<td align="center"><?php echo $print->wkt_tunggu_lbh; ?></td> 
				<td align="center"><?php echo $print->tot_cust; ?></td> 
				<td align="center"><?php echo $print->rata_total_wkt_tunggu; ?></td> 
			</tr>
			<?php } ?>
</tbody>
<tfoot>
<tr>
	<td align="left" colspan=2 ><b>Grand TOTAL</td> <?php ?> 
	<td align="center" class="numeric"><b><?php echo number_format($grandtot_cust_kurg,0,",",","); ?></td><?php ?> 
	<td align="center" class="numeric"><b><?php echo date("H:i:s",$grandtot_wkt_kurg); ?></td> <?php ?> 
	<td align="center" class="numeric"><b><?php echo number_format($grandtot_cust_lbh,0,",",","); ?></td> <?php ?> 
	<td align="center" class="numeric"><b><?php echo date("H:i:s",$grandtot_wkt_lbh); ?></td> <?php ?> 
	<td align="center" class="numeric"><b><?php echo number_format($grandtot_cust_tot,0,",",","); ?></td> <?php ?> 
	<td align="center" class="numeric"><b><?php echo date("H:i:s",$grandtot_wkt_tot); ?></td> 
</tr>
</tfoot>
</table>
<br>
<table><tr><td align="right"><i>Printed on <?php echo date("d/m/y H:i:s"); ?> </i></td></tr></table>
</body>
</html>
