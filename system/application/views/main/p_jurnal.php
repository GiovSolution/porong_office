<?php
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com,
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id

	+ Module  		: tbl_t_hpp_besar Print
	+ Description	: For Print View
	+ Filename 		: p_tbl_t_hpp_besar.php
 	+ Author  		:
 	+ Created on 27/May/2010 16:40:49

*/
?>
<? if(@$type!=="excel") { ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Jurnal Umum</title>
<link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle.css'/>
</head>
<body onload="window.print();">
<? } ?>
<table summary='Jurnal Umum'>
	<thead>
    	<tr>
        	<td colspan="7" nowrap="nowrap">
               <div style="float:left; margin-left:10px; margin-top:5px;" >
                 <center><b><h1>Jurnal Umum</h1></b></center>
                </div>
            </td>
        </tr>
    <tr>
        <th colspan="1">&nbsp;</th>
        <th>Tanggal</th>
        <th>Kode</th>
        <th>Nama Rekening</th>
        <th>Keterangan</th>
        <th>Debet</th>
        <th>Kredit</th>
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

		$debet=0;
		$kredit=0;
		$sub_debet=0;
		$sub_kredit=0;

		foreach($data_print as $print) {

		if($kode_akun!==$print->jurnal_no){
			$j++;
			$sub_debet=0;
			$sub_kredit=0;
		?>
        <tr>
            <td><b><? echo $j; ?></b></td>
            <td colspan="12"><b><?php
				if($print->jurnal_post=='Y')
					echo "<font color=RED>";
			echo $print->jurnal_no;

            if($print->jurnal_post=='Y')
					echo "</font>";
             ?></b></td>
        </tr>
        <?
			foreach($data_print as $print_list) {


				if($print_list->jurnal_no==$print->jurnal_no){
					$i++;
					$k++;

	    ?>
		<tr>
            <td>&nbsp;</td>
            <td><?php echo $print_list->jurnal_tanggal; ?></td>
            <td><?php echo $print_list->akun_kode; ?></td>
            <td nowrap="nowrap"><?php echo $print_list->akun_nama; ?></td>
            <td><?php echo $print_list->djurnal_detail; ?></td>
            <td align="right" class="numeric"><?php echo number_format($print_list->djurnal_debet); ?></td>
            <td align="right" class="numeric"><?php echo number_format($print_list->djurnal_kredit); ?></td>
		</tr>
		<?php
				$debet+=$print_list->djurnal_debet;
				$kredit+=$print_list->djurnal_kredit;

				$sub_debet+=$print_list->djurnal_debet;
				$sub_kredit+=$print_list->djurnal_kredit;

        		}


           }
		 ?>
         <tr>
            <td colspan="5">&nbsp;</td>
            <td align="right" class="numeric"><b><?php echo number_format($sub_debet); ?></b></td>
            <td align="right" class="numeric"><b><?php echo number_format($sub_kredit); ?></b></td>
		</tr>
        <?

		}
				    $kode_akun=$print->jurnal_no;

		 } ?>

	</tbody>
    <tfoot>
    	<tr>
            <td colspan="5"><b>TOTAL</b></td>
            <td align="right" class="numeric"><b><?php echo number_format($debet); ?></b></td>
            <td align="right" class="numeric"><b><?php echo number_format($kredit); ?></b></td>
		</tr>
    </tfoot>
</table>
<? if(@$type!=="excel") { ?>
</body>
</html>
<? } ?>