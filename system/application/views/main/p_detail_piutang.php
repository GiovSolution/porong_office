<?php
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: Penjualan Print
	+ Description	: For Print View
	+ Filename 		: p_detail_jual.php
 	+ Author  		: 
 	+ Created on 01/Feb/2010 14:30:05
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Laporan Detail Piutang dan Pelunasannya <?php echo $periode; ?> Group By No Faktur</title>
<link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle.css'/>
</head>
<body onload="window.print();">
<table summary='Laporan Detail Piutang dan Pelunasannya '>
	<caption>Laporan Detail Piutang dan Pelunasannya <br/><?php echo $periode; ?> <br/>Group By  No Faktur</caption>
	<thead>
    	<tr>
        	<th scope='col'>No</th>
            <th scope='col'>No Faktur Pelunasan</th>
			<th scope='col'>Tanggal</th>
            <th scope='col'>Nilai (Rp)</th>
            <th scope='col'>Cara Bayar</th>
        </tr>
    </thead>
		<tbody>
		        
        <?php $i=0; $j=0; $faktur=""; 

		$total_nilai=0;
		
		foreach($data_print as $print) { ?>
			<?php if($faktur!==$print->no_bukti) { 
			
			?>
					
		  <tr>
                <td><b><? $j++; echo $j; ?></b></td>
                <td colspan="9"><b><?php echo "".$print->no_bukti.", ".$print->tanggal.", ".$print->cust_nama."(".$print->cust_no."), Piutang : ".$print->lpiutang_total.", Sisa : ".$print->lpiutang_sisa;?></b></td>
           </tr>
           <?php 	$sub_nilai=0;
					$i=0; 
			?>
           <?php foreach($data_print as $print_list) {  ?>
           <?php if($print_list->no_bukti==$print->no_bukti && $print_list->dpiutang_nilai>0){ 
		   			
					$i++;
		   			$total_nilai+=$print_list->dpiutang_nilai;
					$sub_nilai+=$print_list->dpiutang_nilai;
		   ?>
            <tr>
                <td><? echo $i; ?></td>
                <td><?php echo $print_list->dpiutang_nobukti; ?></td>
                <td><?php echo $print_list->dpiutang_tanggal;?></td>
                <td class="numeric"><?php echo number_format($print_list->dpiutang_nilai,0,",",","); ?></td>
                <td ><?php  echo $print_list->dpiutang_cara; ?></td>
           </tr>
           <?php } ?>
           <?php } ?>
           <tr>
                <td colspan="3"><b>Total</td>
                <td align="right" class="numeric"><b><?php echo number_format($sub_nilai,0,",",","); ?></b></td>
                <td align="right" class="numeric">&nbsp;</td>
           </tr>
           <?php } $faktur=$print->no_bukti; ?>
		<?php } ?>
        
	</tbody>
    <tfoot>
    	<tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Jumlah data</th>
            <td colspan='8'><?php echo count($data_print); ?> data</td>
        </tr>
        <tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row' colspan="9">Summary</th>
        </tr>
        <tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Total Pelunasan</th>
            <td class="numeric clear" nowrap="nowrap"><?php echo number_format($total_nilai,0,",",","); ?></td>
            <td colspan="7" class="clear">&nbsp;</td>
        </tr>
	</tfoot>
</table>
</body>
</html>