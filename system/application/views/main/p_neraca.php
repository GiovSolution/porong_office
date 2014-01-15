<?php
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: tbl_t_buku_besar Print
	+ Description	: For Print View
	+ Filename 		: p_tbl_t_buku_besar.php
 	+ Author  		: 
 	+ Created on 27/May/2010 16:40:49
	
*/
?>
<? if(@$type!=="excel") { ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Laporan Neraca</title>
<link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle.css'/>
</head>
<body onload="window.print();">
<? } ?>
<table summary='Laporan Neraca'>
	<thead>
    	<tr>
            <td colspan="4" nowrap="nowrap">
            <div style="float:left; margin-left:10px; margin-top:5px;" > 
                 <img src="../assets/images/pmmp_logo2.png" width="40%" height="40%" align="left" style="margin-right:5px" /> 
                 <center><b><h1>Laporan Neraca</h1></b></center>
            </div>
            </td>
        </tr>
    </thead>
	<tbody>
		<?php 
		$saldo=0;
		$i=0; 
		$j=0;
		$kode_akun="";
		$ap="";
		$f="";
		$k=0;
		
		$saldo_periode=0;
		$saldo=0;
		
		foreach($data_print as $apprint) {
			if($ap!==$apprint["neraca_jenis"] ){
					
				if($apprint["neraca_level"]==1 && $ap!==$apprint["neraca_jenis"]){
					$ap=$apprint["neraca_jenis"];
		?>
        <tr>
            <td>&nbsp;</td>
            <td colspan="12"><b><?php echo $apprint["neraca_jenis"];?></b></td>
        </tr>
        <?
				}
				
		$saldo_periode=0;
		$saldo=0;
		
		foreach($data_print as $print) {
		if($apprint["neraca_jenis"]==$print["neraca_jenis"]){ 
		
		if($kode_akun!==$print["neraca_jenis"] &&  $print["neraca_level"]>1){
			$j++;
			
		?>
        <tr>
            <td><b><? echo $j; ?></b></td>
            <td colspan="12"><b><?php echo $print["neraca_jenis"];?></b></td>
        </tr>
        <?
			
			foreach($data_print as $print_list) {  
				if($print_list["neraca_jenis"]==$print["neraca_jenis"] && $print["neraca_level"]>1){ 
					$i++;
					$k++;
					$saldo_periode+=$print_list["neraca_saldo_periode"];
					$saldo+=$print_list["neraca_saldo"];
						
				?>
				<tr>
					<td>&nbsp;</td>
					<td><?php echo $print_list["neraca_akun_nama"]; ?></td>
					<td align="right" class="numeric"><?php echo number_format($print_list["neraca_saldo_periode"]); ?></td>
					<td align="right" class="numeric"><?php echo number_format($print_list["neraca_saldo"]); ?></td>
				</tr>
				<?php		
					
				}
		
           	}
			
 			
			?>
             <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="right" class="numeric"><b><?php echo number_format($saldo_periode);?></b></td>
                <td align="right" class="numeric"><b><?php echo number_format($saldo);?></b></td>
            </tr>
            <?	
		}
				    $kode_akun=$print["neraca_jenis"];
		
					
		 }
		
		}

		}
		 
		 
	}
	?>
	</tbody>
</table>
<? if(@$type!=="excel") { ?>
</body>
</html>
<? } ?>