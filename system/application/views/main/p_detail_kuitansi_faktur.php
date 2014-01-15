<?php
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: Kuitansi Print
	+ Description	: For Print View
	+ Filename 		: p_rekap_jual.php
 	+ Author  		: 
 	+ Created on 01/Feb/2010 14:30:05
	
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Laporan Detail Kuitansi <?php echo $periode; ?> Group By No Faktur</title>
<link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle.css'/>
</head>
<body onload="window.print();">
<table summary='Rekap Jual'>
	<caption>Laporan Detail Kuitansi <br/><?php echo $periode; ?><br/>Group By No Faktur</caption>
	<thead>
    	<tr>
        	<th scope='col'>No</th>
            <th scope='col'>No Kuitansi</th> 
            <th scope='col'>Tanggal</th> 
            <th scope='col'>Jenis Transaksi</th>          
            <th scope='col'>Customer</th>
			<th scope='col'>Nilai Pemakaian (Rp)</th>
        </tr>
    </thead>
	<tbody>
		<?php 	$i=0;
				$j=0;
				$total_nilai=0;
				$total_pakai=0;
				$total_sisa=0;
				$group="";
				
				
		foreach($data_print as $print) { 
				$total_pakai+=$print->pakai_nilai;
				$i++; 
				
				$sub_nilai=0;
				$sub_pakai=0;
				$sub_sisa=0;
				$i=0; 
			
			if($group!==$print->no_faktur) { 
					
			?>
           <tr>
                <td><b><? $j++; echo $j; ?></b></td>
                <td colspan="5"><b><?php echo $print->no_faktur;?></b></td>
           </tr>
          <?php foreach($data_print as $print_list) {  ?>
          <?php if($print_list->no_faktur==$print->no_faktur){ $i++;
		   
		   			$sub_pakai+=$print_list->pakai_nilai;

		   ?>
		<tr>
        	<td><? echo $i; ?></td>
            <td width="10"><?php echo $print_list->no_bukti; ?></td>
            <td width="10"><?php echo $print_list->tanggal; ?></td>
            <td width="10"><?php echo ucwords(str_replace("_"," ",$print_list->jenis_transaksi)); ?></td>
            <td><?php echo $print_list->cust_nama." (".$print_list->cust_no.")"; ?></td>
            <td align="right" class="numeric"><?php echo number_format($print_list->pakai_nilai,0,",",","); ?></td>
      	</tr>
	   <?php } ?>
       <?php } ?>
       <tr>
            <td colspan="5">&nbsp;</td>
            <td align="right" class="numeric"><b><?php echo number_format($sub_pakai); ?></b></td>
       </tr>
       <?php 
	   	} 
       		   	 $group=$print->no_faktur; 
               
               
        ?>
    <?php } ?>
	</tbody>
    <tfoot>
    	<tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row'>Jumlah data</th>
            <td colspan='6'><?php echo count($data_print); ?> data</td>
        </tr>
        <tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row' colspan="7">Summary</th>
        </tr>
        <tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Total Nilai (Rp)</th>
            <td  nowrap="nowrap" align="right" class="numeric clear"><?php echo number_format($total_pakai,0,",",","); ?></td>
             <td colspan='5' class="clear">&nbsp;</td>
        </tr>
	</tfoot>
</table>
</body>
</html>