<? /* 
	+ Description	: For record model process back-end
	+ Filename 		: c_lap_waktu_tunggu.php
 	+ Author  		: Natalie
*/

class M_lap_waktu_tunggu extends Model{
		
	//constructor
	function M_lap_waktu_tunggu() {
		parent::Model();
	}
	
	//function for get list record
	function lap_waktu_tunggu_list($filter,$start,$end){
			$date_now=date('Y-m-d');
			$firstday=date('Y-m');

			//$query = "select tgl, count(cust_nama) as jum_cust,  sec_to_time(sum(time_to_sec(waktu_tunggu))/count(cust_nama)) as rata_waktu_tunggu from vu_tindakan where  ".$periode." ".$groupby." and dtrawat_status != 'Batal' and waktu_tunggu is not null";
			
			$query = "select tgl,SUM(CASE WHEN substring(waktu_tunggu,4,2)<20 THEN 1 ELSE 0 END) as jum_cust_kurg,
					SEC_TO_TIME((SUM(CASE WHEN SUBSTRING(waktu_tunggu,4,2)<20 THEN TIME_TO_SEC(waktu_tunggu) ELSE 0 END))/(SUM(CASE WHEN SUBSTRING(waktu_tunggu,4,2)<20 THEN 1 ELSE 0 END))) as wkt_tunggu_kurg,
						SEC_TO_TIME(SUM(CASE WHEN substring(waktu_tunggu,4,2)<20 THEN 1 ELSE 0 END) * (SUM(CASE WHEN SUBSTRING(waktu_tunggu,4,2)<20 THEN TIME_TO_SEC(waktu_tunggu) ELSE 0 END))/(SUM(CASE WHEN SUBSTRING(waktu_tunggu,4,2)<20 THEN 1 ELSE 0 END))) as tot_wkt_kurg,

					SUM(CASE WHEN substring(waktu_tunggu,4,2)>=20 THEN 1 ELSE 0 END) as jum_cust_lbh,
					SEC_TO_TIME((SUM(CASE WHEN SUBSTRING(waktu_tunggu,4,2)>=20 THEN TIME_TO_SEC(waktu_tunggu) ELSE 0 END))/(SUM(CASE WHEN SUBSTRING(waktu_tunggu,4,2)>=20 THEN 1 ELSE 0 END))) as wkt_tunggu_lbh,
					sec_to_time(SUM(CASE WHEN substring(waktu_tunggu,4,2)>=20 THEN 1 ELSE 0 END) * (SUM(CASE WHEN SUBSTRING(waktu_tunggu,4,2)>=20 THEN TIME_TO_SEC(waktu_tunggu) ELSE 0 END))/(SUM(CASE WHEN SUBSTRING(waktu_tunggu,4,2)>=20 THEN 1 ELSE 0 END))) as tot_wkt_lbh,

					SUM(CASE WHEN substring(waktu_tunggu,4,2)<20 THEN 1 ELSE 0 END) + SUM(CASE WHEN substring(waktu_tunggu,4,2)>=20 THEN 1 ELSE 0 END) as tot_cust,
					sec_to_time((((SUM(CASE WHEN substring(waktu_tunggu,4,2)<20 THEN 1 ELSE 0 END)) * ((SUM(CASE WHEN SUBSTRING(waktu_tunggu,4,2)<20 THEN TIME_TO_SEC(waktu_tunggu) ELSE 0 END)/(SUM(CASE WHEN SUBSTRING(waktu_tunggu,4,2)<20 THEN 1 ELSE 0 END))))) + ((SUM(CASE WHEN substring(waktu_tunggu,4,2)>=20 THEN 1 ELSE 0 END)) * ((SUM(CASE WHEN SUBSTRING(waktu_tunggu,4,2)>=20 THEN TIME_TO_SEC(waktu_tunggu) ELSE 0 END)/(SUM(CASE WHEN SUBSTRING(waktu_tunggu,4,2)>=20 THEN 1 ELSE 0 END)))))) / (SUM(CASE WHEN substring(waktu_tunggu,4,2)<20 THEN 1 ELSE 0 END) + SUM(CASE WHEN substring(waktu_tunggu,4,2)>=20 THEN 1 ELSE 0 END))) as rata_total_wkt_tunggu,
					sec_to_time(SUM(CASE WHEN substring(waktu_tunggu,4,2)<20 THEN 1 ELSE 0 END) + SUM(CASE WHEN substring(waktu_tunggu,4,2)>=20 THEN 1 ELSE 0 END) * (((SUM(CASE WHEN substring(waktu_tunggu,4,2)<20 THEN 1 ELSE 0 END)) * ((SUM(CASE WHEN SUBSTRING(waktu_tunggu,4,2)<20 THEN TIME_TO_SEC(waktu_tunggu) ELSE 0 END)/(SUM(CASE WHEN SUBSTRING(waktu_tunggu,4,2)<20 THEN 1 ELSE 0 END))))) + ((SUM(CASE WHEN substring(waktu_tunggu,4,2)>=20 THEN 1 ELSE 0 END)) * ((SUM(CASE WHEN SUBSTRING(waktu_tunggu,4,2)>=20 THEN TIME_TO_SEC(waktu_tunggu) ELSE 0 END)/(SUM(CASE WHEN SUBSTRING(waktu_tunggu,4,2)>=20 THEN 1 ELSE 0 END)))))) / (SUM(CASE WHEN substring(waktu_tunggu,4,2)<20 THEN 1 ELSE 0 END) + SUM(CASE WHEN substring(waktu_tunggu,4,2)>=20 THEN 1 ELSE 0 END))) as tot_rata_wkt

					FROM vu_tindakan where tgl between '$firstday-01' and '$date_now' and dtrawat_status != 'Batal' and waktu_tunggu is not null";
			
			$query.=" GROUP BY tgl";			
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
			
			if($nbrows>0){
				if($nbrows>0){
					foreach($result->result() as $row){
						$arr[] = $row;
					}
				}
				$jsonresult = json_encode($arr);
				return '({"total":"'.$nbrows.'","results":'.$jsonresult.'})';
			} else {
				return '({"total":"0", "results":""})';
			}
		}	
			
	function lap_waktu_tunggu_list2($filter,$start,$end){
		$date_now=date('Y-m-d');
		$firstday=date('Y-m');

		//$query = "select tgl, count(cust_nama) as jum_cust,  sec_to_time(sum(time_to_sec(waktu_tunggu))/count(cust_nama)) as rata_waktu_tunggu from vu_tindakan where  ".$periode." ".$groupby." and dtrawat_status != 'Batal' and waktu_tunggu is not null";
		
		$query = "SELECT tgl, sum(jum_cust_kurg) as avg_cust_kurg, 
						sec_to_time(sum(time_to_sec(tot_wkt_kurg)) / sum(jum_cust_kurg)) as avg_waktu_kurg, 
						sum(jum_cust_lbh) as avg_cust_lbh, 
						sec_to_time(sum(time_to_sec(tot_wkt_lbh)) / sum(jum_cust_lbh)) as avg_waktu_lbh, 
						sum(tot_cust) as total_cust, 
						sec_to_time(((sum(jum_cust_kurg) * (sum(time_to_sec(tot_wkt_kurg)) / sum(jum_cust_kurg))) + (sum(jum_cust_lbh) * (sum(time_to_sec(tot_wkt_lbh)) / sum(jum_cust_lbh)))) /  sum(tot_cust) ) as avg_waktu_total

					from (select tgl,SUM(CASE WHEN substring(waktu_tunggu,4,2)<20 THEN 1 ELSE 0 END) as jum_cust_kurg,
					SEC_TO_TIME((SUM(CASE WHEN SUBSTRING(waktu_tunggu,4,2)<20 THEN TIME_TO_SEC(waktu_tunggu) ELSE 0 END))/(SUM(CASE WHEN SUBSTRING(waktu_tunggu,4,2)<20 THEN 1 ELSE 0 END))) as wkt_tunggu_kurg,
						SEC_TO_TIME(SUM(CASE WHEN substring(waktu_tunggu,4,2)<20 THEN 1 ELSE 0 END) * (SUM(CASE WHEN SUBSTRING(waktu_tunggu,4,2)<20 THEN TIME_TO_SEC(waktu_tunggu) ELSE 0 END))/(SUM(CASE WHEN SUBSTRING(waktu_tunggu,4,2)<20 THEN 1 ELSE 0 END))) as tot_wkt_kurg,

					SUM(CASE WHEN substring(waktu_tunggu,4,2)>=20 THEN 1 ELSE 0 END) as jum_cust_lbh,
					SEC_TO_TIME((SUM(CASE WHEN SUBSTRING(waktu_tunggu,4,2)>=20 THEN TIME_TO_SEC(waktu_tunggu) ELSE 0 END))/(SUM(CASE WHEN SUBSTRING(waktu_tunggu,4,2)>=20 THEN 1 ELSE 0 END))) as wkt_tunggu_lbh,
					sec_to_time(SUM(CASE WHEN substring(waktu_tunggu,4,2)>=20 THEN 1 ELSE 0 END) * (SUM(CASE WHEN SUBSTRING(waktu_tunggu,4,2)>=20 THEN TIME_TO_SEC(waktu_tunggu) ELSE 0 END))/(SUM(CASE WHEN SUBSTRING(waktu_tunggu,4,2)>=20 THEN 1 ELSE 0 END))) as tot_wkt_lbh,

					SUM(CASE WHEN substring(waktu_tunggu,4,2)<20 THEN 1 ELSE 0 END) + SUM(CASE WHEN substring(waktu_tunggu,4,2)>=20 THEN 1 ELSE 0 END) as tot_cust

					FROM vu_tindakan where tgl between '$firstday' and '$date_now' and dtrawat_status != 'Batal' and waktu_tunggu is not null
					) as tabel";
		
		$query.=" GROUP BY tgl";			
		$result = $this->db->query($query);
		$nbrows = $result->num_rows();
		
		if($nbrows>0){
			if($nbrows>0){
				foreach($result->result() as $row){
					$arr[] = $row;
				}
			}
			$jsonresult = json_encode($arr);
			return '({"total":"'.$nbrows.'","results":'.$jsonresult.'})';
		} else {
			return '({"total":"0", "results":""})';
		}
	}	
		
		
	function get_daftar_customer($lap_waktu_tunggu_id  ,$lap_waktu_tunggu_tgllahir, $lap_waktu_tunggu_tgllahirend,$lap_waktu_tunggu_umurstart, $lap_waktu_tunggu_umurend,$tgl_start ,$tgl_end ,$lap_waktu_tunggu_kelamin, $lap_waktu_tunggu_member,$groupby,$tgl_tindakan,$start,$end){
		
		if ($lap_waktu_tunggu_kelamin == '' or $lap_waktu_tunggu_kelamin == 'S')
		{
			$cust_kelamin = "";
		}			
		else if ($lap_waktu_tunggu_kelamin == 'P')
		{
			$cust_kelamin = " and vu_customer.cust_kelamin = '$lap_waktu_tunggu_kelamin'";
		}
		else if($lap_waktu_tunggu_kelamin == 'L')
		{
			$cust_kelamin = " and vu_customer.cust_kelamin = '$lap_waktu_tunggu_kelamin'";			
		}
		
		if ($groupby == '' or $groupby == 'Semua')
		{
			$cust_daftar = "";
		}
		else if ($groupby == 'Lama')
		{
			$cust_daftar = " and ((vu_customer.cust_terdaftar not between '$tgl_start' and '$tgl_end') or (vu_customer.cust_terdaftar is null))";
		}
		else if($groupby == 'Baru')
		{
			$cust_daftar = " and vu_customer.cust_terdaftar between '$tgl_start' and '$tgl_end'";			
		}			
		
		if ($lap_waktu_tunggu_member == '' or $lap_waktu_tunggu_member == 'Semua')
		{
			$stat_member = "";
		}
		else if ($lap_waktu_tunggu_member == 'Lama')
		{
			$stat_member = " and vu_customer.member_register not between '$tgl_start' and '$tgl_end'";
		}
		else if($lap_waktu_tunggu_member == 'Baru')
		{
			$stat_member = " and vu_customer.member_register between '$tgl_start' and '$tgl_end'";
		}
		else if($lap_waktu_tunggu_member == 'Non Member')
		{
			$stat_member = " and vu_customer.cust_member = 0";
		}
			
		if($lap_waktu_tunggu_tgllahir!='' and $lap_waktu_tunggu_tgllahirend!=''){
			$tgllahir= " and cust_tgllahir BETWEEN '$lap_waktu_tunggu_tgllahir' AND '$lap_waktu_tunggu_tgllahirend'";
		}else if ($lap_waktu_tunggu_tgllahir!='' and $lap_waktu_tunggu_tgllahirend==''){
			$tgllahir= " and cust_tgllahir BETWEEN '$lap_waktu_tunggu_tgllahir' AND now()";
		}else if ($lap_waktu_tunggu_tgllahir=='' and $lap_waktu_tunggu_tgllahirend!=''){
			$tgllahir= " and cust_tgllahir < '$lap_waktu_tunggu_tgllahirend'";
		}else if ($lap_waktu_tunggu_tgllahir=='' and $lap_waktu_tunggu_tgllahirend==''){
			$tgllahir= "";
		}

		if($lap_waktu_tunggu_umurstart!='' and $lap_waktu_tunggu_umurend!=''){
			$umur= " and (year(now())-year(cust_tgllahir)) BETWEEN '$lap_waktu_tunggu_umurstart' AND '$lap_waktu_tunggu_umurend'";
		}else if ($lap_waktu_tunggu_umurstart!='' and $lap_waktu_tunggu_umurend==''){
			$umur= " and (year(now())-year(cust_tgllahir)) > '$lap_waktu_tunggu_umurstart'";
		}else if ($lap_waktu_tunggu_umurstart=='' and $lap_waktu_tunggu_umurend!=''){
			$umur= " and (year(now())-year(cust_tgllahir)) < '$lap_waktu_tunggu_umurend'";
		}else if ($lap_waktu_tunggu_umurstart=='' and $lap_waktu_tunggu_umurend==''){
			$umur= "";
		}
		
		///////////////
				if($tgl_start!='' && $tgl_end!=''){
			$query = "select date_format(tgl_tindakan, '%Y-%m-%d') as tgl_tindakan,
					cust_id, cust_no, cust_nama					
					from
					(
						(
							/* MEDIS */
							select 
								cust_id, 
								cust_no,
								cust_nama,
								count(distinct temp_jum_cust_medis) as jum_cust_medis,
								jum_cust_surgery,
								jum_cust_antiaging,
								jum_cust_nonmedis,
								jum_cust_produk,
								jum_total,
								tgl_tindakan
								from
								((
									select
									vu_customer.cust_id,
									vu_customer.cust_no,
									vu_customer.cust_nama,
									master_jual_rawat.jrawat_cust as temp_jum_cust_medis,
									
									0 as jum_cust_surgery,
									0 as jum_cust_antiaging,
									0 as jum_cust_nonmedis,
									0 as jum_cust_produk,
									0 as jum_total,
									master_jual_rawat.jrawat_tanggal as tgl_tindakan
									from detail_jual_rawat
									left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
									left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
									left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
									where perawatan.rawat_kategori = 2 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and master_jual_rawat.jrawat_tanggal ='$tgl_tindakan'".$cust_kelamin."".$cust_daftar."".$stat_member."".$umur."".$tgllahir."
								)
								union
								(
									select 
									vu_customer.cust_id,
									vu_customer.cust_no,
									vu_customer.cust_nama,
									detail_ambil_paket.dapaket_cust as temp_jum_cust_medis,
									0 as jum_cust_surgery,
									0 as jum_cust_antiaging,
									0 as jum_cust_nonmedis,
									0 as jum_cust_produk,
									0 as jum_total,
									detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
									from detail_ambil_paket
									left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
									left join vu_customer on (detail_ambil_paket.dapaket_cust = vu_customer.cust_id)
									where perawatan.rawat_kategori = 2 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil  ='$tgl_tindakan'".$cust_kelamin."".$cust_daftar."".$stat_member."".$umur."".$tgllahir."
								)) as table_sum_medis
							group by cust_nama
						)
						
						/* SURGERY */
						union
						(
							select 
								cust_id,
								cust_no,
								cust_nama,
								jum_cust_medis,
								count(distinct temp_jum_cust_surgery) as jum_cust_surgery,
								jum_cust_antiaging,
								jum_cust_nonmedis,
								jum_cust_produk,
								jum_total,
								tgl_tindakan
								from
								((
									select 
										vu_customer.cust_id,
										vu_customer.cust_no,
										vu_customer.cust_nama,
										0 as jum_cust_medis,
										master_jual_rawat.jrawat_cust as temp_jum_cust_surgery,
										0 as jum_cust_antiaging,
										0 as jum_cust_nonmedis,
										0 as jum_cust_produk,
										0 as jum_total,
										master_jual_rawat.jrawat_tanggal as tgl_tindakan
									from detail_jual_rawat
									left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
									left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
									left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
									where perawatan.rawat_kategori = 4 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and master_jual_rawat.jrawat_tanggal  ='$tgl_tindakan'".$cust_kelamin."".$cust_daftar."".$stat_member."".$umur."".$tgllahir."

								)
								union
								(
									select 
										vu_customer.cust_id,
										vu_customer.cust_no,
										vu_customer.cust_nama,
										0 as jum_cust_medis,
										detail_ambil_paket.dapaket_cust as temp_jum_cust_surgery,
										0 as jum_cust_antiaging,
										0 as jum_cust_nonmedis,
										0 as jum_cust_produk,
										0 as jum_total,
										detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
									from detail_ambil_paket
									left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
									left join vu_customer on (detail_ambil_paket.dapaket_cust = vu_customer.cust_id)
									where perawatan.rawat_kategori = 4 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil  ='$tgl_tindakan'".$cust_kelamin."".$cust_daftar."".$stat_member."".$umur."".$tgllahir."
								)) as table_sum_surgery
							group by cust_nama

						)

						/* ANTI AGING */
						union
						(
							select 
							cust_id,
							cust_no,
							cust_nama,
								jum_cust_medis,
								jum_cust_surgery,
								count(distinct temp_jum_cust_antiaging) as jum_cust_antiaging,
								jum_cust_nonmedis,
								jum_cust_produk,
								jum_total,
								tgl_tindakan
								from
								((
									select 
									vu_customer.cust_id,
									vu_customer.cust_no,
									vu_customer.cust_nama,
										0 as jum_cust_medis,
										0 as jum_cust_surgery,
										master_jual_rawat.jrawat_cust as temp_jum_cust_antiaging,
										0 as jum_cust_nonmedis,
										0 as jum_cust_produk,
										0 as jum_total,
										master_jual_rawat.jrawat_tanggal as tgl_tindakan
									from detail_jual_rawat
									left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
									left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
									left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
									where perawatan.rawat_kategori = 16 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and master_jual_rawat.jrawat_tanggal  ='$tgl_tindakan'".$cust_kelamin."".$cust_daftar."".$stat_member."".$umur."".$tgllahir."

								)
								union
								(
									select
										vu_customer.cust_id,
										vu_customer.cust_no,
										vu_customer.cust_nama,									
										0 as jum_cust_medis,
										0 as jum_cust_surgery,
										detail_ambil_paket.dapaket_cust as temp_jum_cust_antiaging,
										0 as jum_cust_nonmedis,
										0 as jum_cust_produk,
										0 as jum_total,
										detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
									from detail_ambil_paket
									left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
									left join vu_customer on (detail_ambil_paket.dapaket_cust = vu_customer.cust_id)
									where perawatan.rawat_kategori = 16 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil  ='$tgl_tindakan'".$cust_kelamin."".$cust_daftar."".$stat_member."".$umur."".$tgllahir."
								)) as table_sum_antiaging 
							group by cust_nama

						)

						
						/*  NON-MEDIS */
						union
						(
							select 
								cust_id,
								cust_no,
								cust_nama,
								jum_cust_medis,
								jum_cust_surgery,
								jum_cust_antiaging,
								count(distinct temp_jum_cust_nonmedis) as jum_cust_nonmedis,
								jum_cust_produk,
								jum_total,
								tgl_tindakan
								from
								((
									select 
										vu_customer.cust_id,
										vu_customer.cust_no,
										vu_customer.cust_nama,
										0 as jum_cust_medis,
										0 as jum_cust_surgery,
										0 as jum_cust_antiaging,
										master_jual_rawat.jrawat_cust as temp_jum_cust_nonmedis,
										0 as jum_cust_produk,
										0 as jum_total,
										master_jual_rawat.jrawat_tanggal as tgl_tindakan
									from detail_jual_rawat
									left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
									left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
									left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
									where perawatan.rawat_kategori = 3 and master_jual_rawat.jrawat_stat_dok='Tertutup' and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and master_jual_rawat.jrawat_tanggal  ='$tgl_tindakan'".$cust_kelamin."".$cust_daftar."".$stat_member."".$umur."".$tgllahir."

								)
								union
								(
									select 
										vu_customer.cust_id,
										vu_customer.cust_no,
										vu_customer.cust_nama,
										0 as jum_cust_medis,
										0 as jum_cust_surgery,
										0 as jum_cust_antiaging,
										detail_ambil_paket.dapaket_cust as temp_jum_cust_nonmedis,
										0 as jum_cust_produk,
										0 as jum_total,
										detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
									from detail_ambil_paket
									left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
									left join vu_customer on (detail_ambil_paket.dapaket_cust = vu_customer.cust_id)
									where perawatan.rawat_kategori = 3 and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil  ='$tgl_tindakan'".$cust_kelamin."".$cust_daftar."".$stat_member."".$umur."".$tgllahir."
								)) as table_sum_nonmedis
							group by cust_nama
						)

						/* PRODUK*/
						union
						(
							select 
								vu_customer.cust_id,
								vu_customer.cust_no,
								vu_customer.cust_nama,
								0 as jum_cust_medis,
								0 as jum_cust_surgery,
								0 as jum_cust_antiaging,
								0 as jum_cust_nonmedis,
								count(distinct master_jual_produk.jproduk_cust) as jum_cust_produk,
								0 as jum_total,
								master_jual_produk.jproduk_tanggal as tgl_tindakan
							from master_jual_produk
							left join vu_customer on (master_jual_produk.jproduk_cust = vu_customer.cust_id)
							where master_jual_produk.jproduk_stat_dok ='Tertutup' and (master_jual_produk.jproduk_totalbiaya <> 0 or master_jual_produk.jproduk_cashback <> 0) and master_jual_produk.jproduk_tanggal  ='$tgl_tindakan'".$cust_kelamin."".$cust_daftar."".$stat_member."".$umur."".$tgllahir."
							group by cust_nama
						)

						/* TOTAL*/
						union
						(
							select 
								cust_id,
								cust_no,
								cust_nama,
								jum_cust_medis,
								jum_cust_surgery,
								jum_cust_antiaging,
								jum_cust_nonmedis,
								jum_cust_produk,
								count(distinct cust) as jum_total,
								tgl_tindakan
								from
								((	
									select 
										vu_customer.cust_id,
										vu_customer.cust_no,
										vu_customer.cust_nama,
										0 as jum_cust_medis,
										0 as jum_cust_surgery,
										0 as jum_cust_antiaging,
										0 as jum_cust_nonmedis,
										0 as jum_cust_produk,
										master_jual_rawat.jrawat_cust as cust,
										master_jual_rawat.jrawat_tanggal as tgl_tindakan
									from detail_jual_rawat
									left join master_jual_rawat on (detail_jual_rawat.drawat_master = master_jual_rawat.jrawat_id)
									left join perawatan on (detail_jual_rawat.drawat_rawat=perawatan.rawat_id)
									left join vu_customer on (master_jual_rawat.jrawat_cust = vu_customer.cust_id)
									where master_jual_rawat.jrawat_stat_dok ='Tertutup'
									and (master_jual_rawat.jrawat_totalbiaya <> 0 or master_jual_rawat.jrawat_cashback <> 0) and (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and master_jual_rawat.jrawat_tanggal ='$tgl_tindakan'".$cust_kelamin."".$cust_daftar."".$stat_member."".$umur."".$tgllahir."
								)
								union
								(
									select 
										vu_customer.cust_id,
										vu_customer.cust_no,
										vu_customer.cust_nama,
										0 as jum_cust_medis,
										0 as jum_cust_surgery,
										0 as jum_cust_antiaging,
										0 as jum_cust_nonmedis,
										0 as jum_cust_produk,
										master_jual_produk.jproduk_cust as cust,
										master_jual_produk.jproduk_tanggal as tgl_tindakan
									from master_jual_produk
									left join vu_customer on (master_jual_produk.jproduk_cust = vu_customer.cust_id)
									where master_jual_produk.jproduk_stat_dok ='Tertutup' and (master_jual_produk.jproduk_totalbiaya <> 0 or master_jual_produk.jproduk_cashback <> 0) and master_jual_produk.jproduk_tanggal  ='$tgl_tindakan'".$cust_kelamin."".$cust_daftar."".$stat_member."".$umur."".$tgllahir."
								)
								
								union
								(
								select 
									vu_customer.cust_id,
									vu_customer.cust_no,
									vu_customer.cust_nama,
									0 as jum_cust_medis,
									0 as jum_cust_surgery,
									0 as jum_cust_antiaging,
									0 as jum_cust_nonmedis,
									0 as jum_cust_produk,
									detail_ambil_paket.dapaket_cust as cust,
									detail_ambil_paket.dapaket_tgl_ambil as tgl_tindakan
								from detail_ambil_paket
								left join perawatan on (detail_ambil_paket.dapaket_item = perawatan.rawat_id)
								left join vu_customer on (detail_ambil_paket.dapaket_cust = vu_customer.cust_id)
								where (perawatan.rawat_kategori = 2 or perawatan.rawat_kategori = 3 or perawatan.rawat_kategori = 4 or perawatan.rawat_kategori = 16) and detail_ambil_paket.dapaket_stat_dok ='Tertutup' and detail_ambil_paket.dapaket_tgl_ambil  ='$tgl_tindakan'".$cust_kelamin."".$cust_daftar."".$stat_member."".$umur."".$tgllahir."
								)
								
								)as table_union2
							group by cust_nama
						)

					) as table_union group by cust_nama";

					}
				
		/////////////
			
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
			//$limit = $query." LIMIT ".$start.",".$end;			
			//$result = $this->db->query($limit);  
			
			$i = 0;
			if($nbrows>0){
				foreach($result->result() as $row){
					$arr[] = $row;
					$i+=$i;
				}
				$jsonresult = json_encode($arr);
				return '({"total":"'.$nbrows.'","results":'.$jsonresult.'})';
			} else {
				return '({"total":"0", "results":""})';
			}
		}	
					
	//function for advanced search record
	function lap_waktu_tunggu_search($menit,$tgl_awal,$periode,$lap_waktu_tunggu_id ,$tgl_start ,$tgl_end ,$groupby, $start,$end){
			//full query

		
		if ($groupby == '' or $groupby == 'Semua')
		{
			$groupby = "";
		}
		else if ($groupby == 'Medis')
		{
			$groupby = " and kategori_nama = 'medis'";
		}
		else if($groupby == 'NonMedis')
		{
			$groupby = " and kategori_nama = 'non medis'";			
		}			
		
//untuk periode
		if ($periode == 'bulan'){
			$periode=" (date_format(tgl,'%Y-%m')='".$tgl_awal."') " ;
		}else if($periode == 'tanggal'){
			$periode = " (tgl between '".$tgl_start."' and '".$tgl_end."') ";	
		}
		
		
		if($tgl_start!='' && $tgl_end!=''){
			//$query = "select tgl, count(cust_nama) as jum_cust,  sec_to_time(sum(time_to_sec(waktu_tunggu))/count(cust_nama)) as rata_waktu_tunggu from vu_tindakan where  ".$periode." ".$groupby." and dtrawat_status != 'Batal' and waktu_tunggu is not null";
			
			$query = "					
					select tgl,SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu) <=(".$menit."*60) THEN 1 ELSE 0 END) as jum_cust_kurg,
ifnull(SEC_TO_TIME((SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu) <=(".$menit."*60) THEN TIME_TO_SEC(waktu_tunggu) ELSE 0 END))/(SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu) <=(".$menit."*60) THEN 1 ELSE 0 END))),sec_to_time(0)) as wkt_tunggu_kurg,
SEC_TO_TIME(SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu) <=(".$menit."*60) THEN 1 ELSE 0 END) * (SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu) <=(".$menit."*60) THEN TIME_TO_SEC(waktu_tunggu) ELSE 0 END))/(SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu) <=(".$menit."*60) THEN 1 ELSE 0 END))) as tot_wkt_kurg,

SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu) >(".$menit."*60) THEN 1 ELSE 0 END) as jum_cust_lbh,
ifnull(SEC_TO_TIME((SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu) >(".$menit."*60) THEN TIME_TO_SEC(waktu_tunggu) ELSE 0 END))/(SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu) >(".$menit."*60) THEN 1 ELSE 0 END))),sec_to_time(0)) as wkt_tunggu_lbh,
sec_to_time(SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu) >(".$menit."*60) THEN 1 ELSE 0 END) * (SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu) >(".$menit."*60) THEN TIME_TO_SEC(waktu_tunggu) ELSE 0 END))/(SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu) >(".$menit."*60) THEN 1 ELSE 0 END))) as tot_wkt_lbh,

SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu) <=(".$menit."*60) THEN 1 ELSE 0 END) + SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu) >(".$menit."*60) THEN 1 ELSE 0 END) as tot_cust,

sec_to_time((((SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu) <=(".$menit."*60) THEN 1 ELSE 0 END)) * ifnull(((SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu) <=(".$menit."*60) THEN TIME_TO_SEC(waktu_tunggu) ELSE 0 END)/(SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu) <=(".$menit."*60) THEN 1 ELSE 0 END)))),sec_to_time(0))) + ((SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu) >(".$menit."*60) THEN 1 ELSE 0 END)) * ifnull(((SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu) >(".$menit."*60) THEN TIME_TO_SEC(waktu_tunggu) ELSE 0 END)/(SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu) >(".$menit."*60) THEN 1 ELSE 0 END)))),sec_to_time(0)))) / (SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu) <=(".$menit."*60) THEN 1 ELSE 0 END) + SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu) >(".$menit."*60) THEN 1 ELSE 0 END))) as rata_total_wkt_tunggu,
					
sec_to_time(SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu) <=(".$menit."*60) THEN 1 ELSE 0 END) + SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu) >(".$menit."*60) THEN 1 ELSE 0 END) * (((SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu) <=(".$menit."*60) THEN 1 ELSE 0 END)) * ((SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu) <=(".$menit."*60) THEN TIME_TO_SEC(waktu_tunggu) ELSE 0 END)/(SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu) <=(".$menit."*60) THEN 1 ELSE 0 END))))) + ((SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu) >(".$menit."*60) THEN 1 ELSE 0 END)) * ((SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu) >(".$menit."*60) THEN TIME_TO_SEC(waktu_tunggu) ELSE 0 END)/(SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu) >(".$menit."*60) THEN 1 ELSE 0 END)))))) / (SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu) <=(".$menit."*60) THEN 1 ELSE 0 END) + SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu) >(".$menit."*60) THEN 1 ELSE 0 END))) as tot_rata_wkt

FROM vu_tindakan where ".$periode." ".$groupby." and dtrawat_status != 'Batal' and waktu_tunggu is not null";
					}		
			
			$query.=" GROUP BY tgl ORDER BY tgl";
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
			
			$limit = $query." LIMIT ".$start.",".$end;		
			$result = $this->db->query($limit);    
			
			if($nbrows>0){
				foreach($result->result() as $row){
					$arr[] = $row;
				}
				$jsonresult = json_encode($arr);
				return '({"total":"'.$nbrows.'","results":'.$jsonresult.'})';
			} else {
				return '({"total":"0", "results":""})';
			}
		}
		
		//function for advanced search record
	function lap_waktu_tunggu_average_search($menit,$tgl_awal,$periode,$lap_waktu_tunggu_id ,$tgl_start ,$tgl_end ,$groupby, $start,$end){
			//full query

		
		if ($groupby == '' or $groupby == 'Semua')
		{
			$groupby = "";
		}
		else if ($groupby == 'Medis')
		{
			$groupby = " and kategori_nama = 'medis'";
		}
		else if($groupby == 'NonMedis')
		{
			$groupby = " and kategori_nama = 'non medis'";			
		}			
		
//untuk periode
		if ($periode == 'bulan'){
			$periode=" (date_format(tgl,'%Y-%m')='".$tgl_awal."') " ;
		}else if($periode == 'tanggal'){
			$periode = " (tgl between '".$tgl_start."' and '".$tgl_end."') ";	
		}
		
		
		if($tgl_start!='' && $tgl_end!=''){
			//$query = "select tgl, count(cust_nama) as jum_cust,  sec_to_time(sum(time_to_sec(waktu_tunggu))/count(cust_nama)) as rata_waktu_tunggu from vu_tindakan where  ".$periode." ".$groupby." and dtrawat_status != 'Batal' and waktu_tunggu is not null";
			
			$query = "SELECT tgl, sum(jum_cust_kurg) as avg_cust_kurg, 
	sec_to_time(sum(time_to_sec(tot_wkt_kurg)) / sum(jum_cust_kurg)) as avg_waktu_kurg, 
	sum(jum_cust_lbh) as avg_cust_lbh, 
	sec_to_time(sum(time_to_sec(tot_wkt_lbh)) / sum(jum_cust_lbh)) as avg_waktu_lbh, 
	sum(tot_cust) as total_cust, 
	sec_to_time(((sum(jum_cust_kurg) * (sum(time_to_sec(tot_wkt_kurg)) / sum(jum_cust_kurg))) + (sum(jum_cust_lbh) * (sum(time_to_sec(tot_wkt_lbh)) / sum(jum_cust_lbh)))) /  sum(tot_cust) ) as avg_waktu_total

from (select tgl,SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu) <=(".$menit."*60) THEN 1 ELSE 0 END) as jum_cust_kurg,
SEC_TO_TIME((SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu) <=(".$menit."*60) THEN TIME_TO_SEC(waktu_tunggu) ELSE 0 END))/(SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu) <=(".$menit."*60) THEN 1 ELSE 0 END))) as wkt_tunggu_kurg,
	SEC_TO_TIME(SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu) <=(".$menit."*60) THEN 1 ELSE 0 END) * (SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu) <=(".$menit."*60) THEN TIME_TO_SEC(waktu_tunggu) ELSE 0 END))/(SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu) <=(".$menit."*60) THEN 1 ELSE 0 END))) as tot_wkt_kurg,

SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu) >(".$menit."*60) THEN 1 ELSE 0 END) as jum_cust_lbh,
SEC_TO_TIME((SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu) >(".$menit."*60) THEN TIME_TO_SEC(waktu_tunggu) ELSE 0 END))/(SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu) >(".$menit."*60) THEN 1 ELSE 0 END))) as wkt_tunggu_lbh,
sec_to_time(SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu) >(".$menit."*60) THEN 1 ELSE 0 END) * (SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu) >(".$menit."*60) THEN TIME_TO_SEC(waktu_tunggu) ELSE 0 END))/(SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu) >(".$menit."*60) THEN 1 ELSE 0 END))) as tot_wkt_lbh,

SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu) <=(".$menit."*60) THEN 1 ELSE 0 END) + SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu) >(".$menit."*60) THEN 1 ELSE 0 END) as tot_cust

FROM vu_tindakan where  ".$periode." ".$groupby." and dtrawat_status != 'Batal' and waktu_tunggu is not null
) as tabel";
					}		
			
			$query.=" GROUP BY tgl";
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
			
			$limit = $query." LIMIT ".$start.",".$end;		
			$result = $this->db->query($limit);    
			
			if($nbrows>0){
				foreach($result->result() as $row){
					$arr[] = $row;
				}
				$jsonresult = json_encode($arr);
				return '({"total":"'.$nbrows.'","results":'.$jsonresult.'})';
			} else {
				return '({"total":"0", "results":""})';
			}
		}
		
		function get_laporan_tunggu($menit,$tgl_awal,$periode,$lap_waktu_tunggu_id ,$tgl_start ,$tgl_end ,$groupby, $trawat_id ,$trawat_cust ,$option,$filter){		
		if ($groupby == '' or $groupby == 'Semua')
		{
			$groupby = "";
		}
		else if ($groupby == 'Medis')
		{
			$groupby = " and kategori_nama = 'medis'";
		}
		else if($groupby == 'NonMedis')
		{
			$groupby = " and kategori_nama = 'non medis'";			
		}			
		
//untuk periode
		if ($periode == 'bulan'){
			$periode=" (date_format(tgl,'%Y-%m')='".$tgl_awal."') " ;
		}else if($periode == 'tanggal'){
			$periode = " (tgl between '".$tgl_start."' and '".$tgl_end."') ";	
		}
		
		
		if($tgl_start!='' && $tgl_end!=''){
			//$query = "select tgl, count(cust_nama) as jum_cust,  sec_to_time(sum(time_to_sec(waktu_tunggu))/count(cust_nama)) as rata_waktu_tunggu from vu_tindakan where  ".$periode." ".$groupby." and dtrawat_status != 'Batal' and waktu_tunggu is not null";
			
			$query = "SELECT tgl,

					SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu) <=(".$menit."*60) THEN 1 ELSE 0 END) as jum_cust_kurg,
					SEC_TO_TIME((SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu) <=(".$menit."*60) THEN TIME_TO_SEC(waktu_tunggu) ELSE 0 END))/(SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu) <=(".$menit."*60) THEN 1 ELSE 0 END))) as wkt_tunggu_kurg,

					SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu)>(".$menit."*60) THEN 1 ELSE 0 END) as jum_cust_lbh,
					SEC_TO_TIME((SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu)>(".$menit."*60) THEN TIME_TO_SEC(waktu_tunggu) ELSE 0 END))/(SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu)>(".$menit."*60) THEN 1 ELSE 0 END))) as wkt_tunggu_lbh,

					SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu) <=(".$menit."*60) THEN 1 ELSE 0 END) + SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu)>(".$menit."*60) THEN 1 ELSE 0 END) as tot_cust,

					sec_to_time((((SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu) <=(".$menit."*60) THEN 1 ELSE 0 END)) * ((SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu) <=(".$menit."*60) THEN TIME_TO_SEC(waktu_tunggu) ELSE 0 END)/(SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu) <=(".$menit."*60) THEN 1 ELSE 0 END))))) + ((SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu)>(".$menit."*60) THEN 1 ELSE 0 END)) * ((SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu)>(".$menit."*60) THEN TIME_TO_SEC(waktu_tunggu) ELSE 0 END)/(SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu)>(".$menit."*60) THEN 1 ELSE 0 END)))))) / (SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu) <=(".$menit."*60) THEN 1 ELSE 0 END) + SUM(CASE WHEN TIME_TO_SEC(waktu_tunggu)>(".$menit."*60) THEN 1 ELSE 0 END))) as rata_total_wkt_tunggu

					FROM vu_tindakan where ".$periode." ".$groupby." and dtrawat_status != 'Batal' and waktu_tunggu is not null";
					}		
			
			$query.=" GROUP BY tgl";
		
		$query=$this->db->query($query);
		return $query->result();
	}
		
}
?>