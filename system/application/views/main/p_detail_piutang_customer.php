<?php
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: Penjualan Print
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
<title>Laporan Rekap Piutang <?php echo $pelunasan; ?><?php echo $periode; ?> Group By Customer</title>
<link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle.css'/>
</head>
<body onload="window.print();">
<table summary='Rekap Piutang Customer'>
	<caption>Laporan Rekap Piutang <br/><?php echo $pelunasan; ?><br/><?php echo $periode; ?> <br/>Group By  Customer</caption>
	<thead>
       	<tr>
        	<th rowspan="2" scope='col'>No</th>
            <th rowspan="2" scope='col'>No Faktur</th>           
            <th rowspan="2" scope='col'>Tanggal</th>
			<th rowspan="2" scope='col'>Piutang (Rp)</th>
            <th colspan="6" scope='col' align="center">Pelunasan</th>
            <th rowspan="2" scope='col'>Sisa (Rp)</th>
        </tr>
    	<tr>
    	  <th scope='col'>No Faktur</th>
          <th scope='col'>Tgl Bayar</th>
          <th scope='col'>Tunai</th>
    	  <th scope='col'>Card</th>
    	  <th scope='col'>Cek</th>
    	  <th scope='col'>Transfer</th>
        </tr>
    </thead>
	<tbody>
		<?php $i=0; $j=0; $cust=""; 
				$total_tunai=0;
				$total_card=0;
				$total_cek=0;
				$total_transfer=0;
				$total_kuitansi=0;
				$total_piutang=0;
				$total_sisa=0;
				
				foreach($data_print as $print) { ?>
			<?php if($cust!==$print->cust_id) { ?>
           <tr>
                <td><b><? $j++; echo $j; ?></b></td>
                <td colspan="11"><b><?php echo $print->cust_nama." (".$print->cust_no.")";?></b></td>
           </tr>
           <?php 
				$sub_tunai=0;
				$sub_cek=0;
				$sub_transfer=0;
				$sub_kuitansi=0;
				$sub_card=0;
				$sub_kredit=0;
				$sub_piutang=0;
				$sub_sisa=0;

				$i=0;
				$no_bukti_trans = "";
				$sub_piutang_sisa = 0;
				$sub_piutang_sisa_perfaktur = array();
				$array_perfaktur = 0;
				$grand_total_piutang = 0;
				$total_bayar = 0;
			?>
           <?php foreach($data_print as $print_list) { 
		   ?>
           <?php if($print_list->cust_id==$print->cust_id){ 
		   			$total_piutang+=$print_list->lpiutang_total;
					$total_sisa+=$print_list->lpiutang_sisa;
					$total_tunai+=$print_list->piutang_tunai;
					$total_card+=$print_list->piutang_card;
					$total_cek+=$print_list->piutang_cek;
					$total_transfer+=$print_list->piutang_transfer;
					
					$sub_piutang+=$print_list->lpiutang_total;
					$sub_sisa+=$print_list->lpiutang_sisa;
					$sub_tunai+=$print_list->piutang_tunai;
					$sub_card+=$print_list->piutang_card;
					$sub_cek+=$print_list->piutang_cek;
					$sub_transfer+=$print_list->piutang_transfer;
					
					$total_bayar = $sub_tunai+$sub_card+$sub_cek+$sub_transfer;
		   ?>
            <tr>
                <?php if(($print_list->no_bukti)!==$no_bukti_trans){
					$i++;
					$grand_total_piutang+=$print_list->lpiutang_total;
					$sub_piutang_sisa_perfaktur[$array_perfaktur]=$sub_piutang_sisa;
					$array_perfaktur++;
					?>
				<td><? echo $i; ?></td>
                <td><?php echo $print_list->no_bukti; ?></td>
                <td><?php echo $print_list->tanggal; ?></td>
                <td align="right" class="numeric"><?php echo number_format($print_list->lpiutang_total,0,",",","); ?></td>
				<?php $no_bukti_trans=$print_list->no_bukti;}else{?>
				<td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="right" class="numeric">&nbsp;</td>
				<?php }?>
                <td align="right" class="numeric"><?php echo $print_list->dpiutang_nobukti; ?></td>
				<td align="right" class="numeric"><?php if(empty($print_list->dpiutang_tanggal)){echo '&nbsp;';}else{echo date('Y-m-d', strtotime($print_list->dpiutang_tanggal));} ?></td>
				<td align="right" class="numeric"><?php echo number_format($print_list->piutang_tunai,0,",",","); ?></td>
                <td align="right" class="numeric"><?php echo number_format($print_list->piutang_card,0,",",","); ?></td>
                <td align="right" class="numeric"><?php echo number_format($print_list->piutang_cek,0,",",","); ?></td>
                <td align="right" class="numeric"><?php echo number_format($print_list->piutang_transfer,0,",",","); ?></td>
                <td align="right" class="numeric"><?php
					$total_sisa_perfaktur = 0;
					for($array_sisa=1; $array_sisa<(sizeof($sub_piutang_sisa_perfaktur)); $array_sisa++){
						$total_sisa_perfaktur+=$sub_piutang_sisa_perfaktur[$array_sisa];
					}
					//$sub_piutang_sisa = ($print_list->lpiutang_total) - $total_bayar;
					$sub_piutang_sisa = $grand_total_piutang - $total_bayar - $total_sisa_perfaktur;
					echo number_format($sub_piutang_sisa,0,",",","); ?></td>
           </tr>
           <?php } ?>
           <?php } ?>
           <tr>
                <td colspan="3">&nbsp;</td>
                <td align="right" class="numeric"><b><?php echo number_format($grand_total_piutang,0,",",","); ?></b></td>
                <td align="right" class="numeric">&nbsp;</td>
				<td align="right" class="numeric">&nbsp;</td>
				<td align="right" class="numeric"><b><?php echo number_format($sub_tunai,0,",",","); ?></b></td>
                <td align="right" class="numeric"><b><?php echo number_format($sub_card,0,",",","); ?></b></td>
                <td align="right" class="numeric"><b><?php echo number_format($sub_cek,0,",",","); ?></b></td>
                <td align="right" class="numeric"><b><?php echo number_format($sub_transfer,0,",",","); ?></b></td>
                <td align="right" class="numeric"><b><?php
					$total_sisa_piutang = 0;
					for($array_sisa=1; $array_sisa<(sizeof($sub_piutang_sisa_perfaktur)); $array_sisa++){
						$total_sisa_piutang+=$sub_piutang_sisa_perfaktur[$array_sisa];
					}
					$total_sisa_piutang += $sub_piutang_sisa;
					echo number_format($total_sisa_piutang,0,",",","); ?></b></td>
           </tr>
           <?php } $cust=$print->cust_id; ?>
		<?php } ?>
	</tbody>
    <tfoot>
    	<tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row'>Total</th>
            <td colspan='9'><?php echo count($data_print); ?> data</td>
        </tr>
        <tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row' colspan="10">Summary</th>
        </tr>
        <tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Total Piutang (Rp)</th>
            <td nowrap="nowrap" align="right" class="numeric clear"><?php echo number_format($total_piutang,0,",",","); ?></td>
            <td colspan='8' class="clear">&nbsp;</td>
        </tr>
        <tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Total Tunai (Rp)</th>
            <td  nowrap="nowrap" align="right" class="numeric clear"><?php echo number_format($total_tunai,0,",",","); ?></td>
             <td colspan='8' class="clear" >&nbsp;</td>
        </tr>
		<tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Total Card (Rp)</th>
            <td  nowrap="nowrap" align="right" class="numeric clear"><?php echo number_format($total_card,0,",",","); ?></td>
             <td colspan='8' class="clear">&nbsp;</td>
        </tr>
        <tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Total Cek (Rp)</th>
            <td  nowrap="nowrap" align="right" class="numeric clear"><?php echo number_format($total_cek,0,",",","); ?></td>
             <td colspan='8' class="clear">&nbsp;</td>
        </tr>

        <tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Total Transfer (Rp)</th>
            <td  nowrap="nowrap" align="right" class="numeric clear"><?php echo number_format($total_transfer,0,",",","); ?></td>
             <td colspan='8' class="clear" >&nbsp;</td>
        </tr>
        <tr>
        	<td class="clear">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Total Sisa (Rp)</th>
            <td  nowrap="nowrap" align="right" class="numeric clear"><?php echo number_format($total_sisa,0,",",","); ?></td>
             <td colspan='8' class="clear" >&nbsp;</td>
        </tr>
	</tfoot>
</table>
</body>
</html>