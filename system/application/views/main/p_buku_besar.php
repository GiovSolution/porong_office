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
<?php if(@$type!=="excel") { ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Laporan Buku Besar &amp; Buku Pembantu</title>
<link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle.css'/>
</head>
       
<body onload="window.print();">
<?php } ?>

<table summary='Laporan Buku Besar &amp; Buku Pembantu'>
	<thead>
    	<tr>
        	<td colspan="8" nowrap="nowrap">
               <div style="float:left; margin-left:10px; margin-top:5px;" > 
                 <center><b><h1>Laporan Buku Besar &amp; Buku Pembantu</h1></b></center>
                </div>
            </td>
        </tr>
    </thead>
	<thead>
    	<tr>
        	<th scope='col'>No</th>
            <th scope='col'>Tanggal</th>
            <th scope='col'>No Ref</th>
            <th scope='col'>Kode</th>
            <th scope='col'>Akun</th>
			<th scope='col'>Keterangan</th>
            <th scope='col'>Debet</th>
            <th scope='col'>Kredit</th>
            <th scope='col'>Saldo</th>
       	</tr>
    </thead>

	<tbody>
		<?php 
		$saldo=0;
		$i=0; 
		$j=0;
		$kode_group="";
		
		foreach($data_print as $print) {
		
		if($kode_group!==$print["buku_akun_kode"]){
			$j++;
			
		?>
        <tr>
            <td><b><? echo $j; ?></b></td>
            <td colspan="12"><b><?php echo $print["buku_akun_kode"]." : ".$print["buku_akun_nama"];?></b></td>
        </tr>
        <?
			foreach($data_print as $print_list) {  
				if($print_list["buku_akun_kode"]==$print["buku_akun_kode"]){ 
					$i++;
				
	    ?>
		<tr>
            <td><? // echo $i; ?></td>
            <td><?php echo $print_list["buku_tanggal"]; ?></td>
            <td><?php echo $print_list["buku_ref"]; ?></td>
            <td><?php echo $print_list["akun_kode"]; ?></td>
            <td><?php echo $print_list["akun_nama"]; ?></td>
			<td><?php echo $print_list["buku_keterangan"]; ?></td>
            <td align="right" class="numeric"><?php echo number_format($print_list["buku_debet"]); ?></td>
            <td align="right" class="numeric"><?php echo number_format($print_list["buku_kredit"]); ?></td>
            <td align="right" class="numeric"><b><?php echo number_format($print_list["buku_saldo"]);?></b></td>
		</tr>
		<?php		
        		}
           }
		}
		    $kode_group=$print["buku_akun_kode"];
					
		 } ?>
	</tbody>
</table>
<? if(@$type!=="excel") { ?>
</body>
</html>
<? } ?>