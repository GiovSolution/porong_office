<?php
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: tbl_t_labarugi_besar Print
	+ Description	: For Print View
	+ Filename 		: p_tbl_t_labarugi_besar.php
 	+ Author  		: 
 	+ Created on 27/May/2010 16:40:49
	
*/
?>
<? if(@$type!=="excel") { ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Laporan Rugi/Laba</title>
<link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle.css'/>
</head>
<body onload="window.print();">
<? } ?>
<table summary='Laporan Rugi/Laba'>
		<thead>
    	<tr>
            <td colspan="4" nowrap="nowrap">
                <div style="float:left; margin-left:10px; margin-top:5px;" > 
                     <center><b><h1>Laporan Rugi/Laba</h1></b></center>
                </div>
            </td>
        </tr>
    </thead>
    <thead>
    <tr>
        <th colspan="2">&nbsp;
        </th>
        <th>Bulan ini        </th>
        <th>S/d Bulan ini    </th>
    </tr>
    </thead>
	<tbody>
		<?php 
		$saldo=0;
		$i=0; 
		$j=0;
		$kode_akun="";
		$f="";
		$k=0;
		
		$saldo=0;
		$saldo_periode=0;
		
		foreach($data_print as $print) {
		
		if($kode_akun!==$print["labarugi_jenis"]){
			$j++;
			
		?>
        <tr>
            <td><b><? echo $j; ?></b></td>
            <td colspan="12"><b><?php echo $print["labarugi_jenis"];?></b></td>
        </tr>
        <?
			foreach($data_print as $print_list) {  
				if($print_list["labarugi_jenis"]==$print["labarugi_jenis"]){ 
					$i++;
					$k++;
				
	    ?>
		<tr>
            <td>&nbsp;</td>
            <td><?php echo $print_list["labarugi_akun_nama"]; ?></td>
            <td align="right" class="numeric"><?php echo number_format($print_list["labarugi_saldo"]); ?></td>
            <td align="right" class="numeric"><?php echo number_format($print_list["labarugi_saldo_periode"]); ?></td>
		</tr>
		<?php		
				$saldo-=$print_list["labarugi_saldo"];
				$saldo_periode-=$print_list["labarugi_saldo_periode"];
        		}
			
		
           }
		 
		 
		}
				    $kode_akun=$print["labarugi_jenis"];
					
		 } ?>
         <tfoot>
         <tr>
           	<td colspan="2"><b>TOTAL RUGI/LABA</b></td>
            <td align="right" class="numeric"><?php echo number_format($saldo_periode); ?></td>
            <td align="right" class="numeric"><?php echo number_format($saldo); ?></td>
         </tr>
         </tfoot>
	</tbody>
</table>  
<? if(@$type!=="excel") { ?>
</body>
</html>
<? } ?>