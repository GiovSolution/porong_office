<? /* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
		
	+ Module  		: Laporan Net Sales Model
	+ Description	: For record model process back-end
	+ Filename 		: m_lap_netsales.php
 	+ Author  		: Miracle Corporate IT Dept
 	+ Created on 2011-10-03
	
*/

class M_lap_netsales extends Model{
		
		//constructor
		function M_lap_netsales() {
			parent::Model();
		}
		
	// net sales
	function get_laporan_netsales_recalc($tgl_awal, $tgl_akhir, $periode, $bulan, $tahun, $groupby){

		if ($periode == 'bulan'){
			$tgl_awal	= $tahun.'-'.$bulan.'-01';
			$tgl_akhir	= $tahun.'-'.$bulan.'-'.cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun); //mengetahui jumlah hari dlm bulan itu
		}									   
	
		//bersihkan tabel temporary sesuai tgl ybs dan bukan penginputan Manual
		$sql_del	=  "delete t from temp_netsales t
						where 
							t.tns_tanggal between '".$tgl_awal."' and '".$tgl_akhir."'
							and (t.tns_source <> 'Manual' or t.tns_source is null) ";
		$this->db->query($sql_del);
		
		//mendapatkan list tanggal transaksi, yg belum pernah ada penginputan Manual
		$sql_get_tanggal = "select *
							from
							(
								select distinct m1.jproduk_tanggal as tgl
								from master_jual_produk m1
								where 
									m1.jproduk_stat_dok = 'Tertutup'
									and m1.jproduk_tanggal between '".$tgl_awal."' and '".$tgl_akhir."'

								union

								select distinct m2.jrawat_tanggal as tgl
								from master_jual_rawat m2
								where
									m2.jrawat_stat_dok = 'Tertutup'
									and m2.jrawat_tanggal between '".$tgl_awal."' and '".$tgl_akhir."'

								union
									
								select distinct d.dapaket_tgl_ambil as tgl
								from detail_ambil_paket d
								where
									d.dapaket_stat_dok = 'Tertutup'
									and d.dapaket_tgl_ambil  between '".$tgl_awal."' and '".$tgl_akhir."'
							) as tabel_tgl 
							where tgl not in 
							(
								select t.tns_tanggal
								from  temp_netsales t
								where t.tns_source = 'Manual'
							)";
		$list_tgl = $this->db->query($sql_get_tanggal);	
		
		//insert ke tabel temp
		$i = 0;
		foreach($list_tgl->result() as $row){
			$record = $list_tgl->row_array($i);
			
			$sql_pr		=  "call pr_netsales('".$record['tgl']."', '".$record['tgl']."', 'Rekap', 
							@SalesMedis, @SalesNonMedis, @SalesSurgery, @SalesAntiAging, @SalesProduk, @SalesLainLain, @SalesTotal)";		
			$this->db->query($sql_pr);							
					
			$sql_ins	=  "insert into temp_netsales (tns_tanggal, tns_medis, tns_nonmedis, tns_surgery, tns_antiaging, tns_produk, tns_lainlain, tns_total, tns_source)
							select '".$record['tgl']."',@SalesMedis, @SalesNonMedis, @SalesSurgery, @SalesAntiAging, @SalesProduk, @SalesLainLain, @SalesTotal, 'MIS';";
			$this->db->query($sql_ins);				
							
			//print_r($record);
			$i++;
		}
		
		//select dari tabel temp / hasilnya
		if ($groupby == 'daily') {
			$sql	=  "select *
						from temp_netsales t
						where t.tns_tanggal between '".$tgl_awal."' and '".$tgl_akhir."'
						order by t.tns_tanggal asc";
		} else if ($groupby = 'monthly') {
			$sql	=  "select
							substring(t.tns_tanggal, 6, 2) as tns_tanggal,
							sum(t.tns_medis) as tns_medis, 
							sum(t.tns_nonmedis) as tns_nonmedis, 
							sum(t.tns_surgery) as tns_surgery, 
							sum(t.tns_antiaging) as tns_antiaging, 
							sum(t.tns_antiaging) as tns_antiaging, 
							sum(t.tns_produk) as tns_produk, 
							sum(t.tns_lainlain) as tns_lainlain, 
							sum(t.tns_total) as tns_total		
						from temp_netsales t
						where t.tns_tanggal between '".$tgl_awal."' and '".$tgl_akhir."'
						group by substring(t.tns_tanggal, 6, 2)
						order by t.tns_tanggal asc";
		}
				
		$result = $this->db->query($sql);
		$nbrows = $result->num_rows();
		//return $query->result();
		
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

	function get_laporan_netsales($tgl_awal, $tgl_akhir, $periode, $bulan, $tahun,$chart='false'){

		if ($periode == 'bulan'){
			$tgl_awal	= $tahun.'-'.$bulan.'-01';
			$tgl_akhir	= $tahun.'-'.$bulan.'-'.cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun); //mengetahui jumlah hari dlm bulan itu
		}									   
	
		//select dari tabel temp / hasilnya
		$sql		=  "select *
						from temp_netsales t
						where t.tns_tanggal between '".$tgl_awal."' and '".$tgl_akhir."'
						order by t.tns_tanggal asc";
				
		$result = $this->db->query($sql);
		$nbrows = $result->num_rows();
		//return $query->result();
		
		if ($chart == 'true')
		{ 	
		  return $result->result();
		}
		else
		{
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
	}
	// eof net sales
	
	function get_laporan_netsalestotal($tgl_awal, $tgl_akhir, $periode, $bulan, $tahun){

		if ($periode == 'bulan'){
			$tgl_awal	= $tahun.'-'.$bulan.'-01';
			$tgl_akhir	= $tahun.'-'.$bulan.'-'.cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun); //mengetahui jumlah hari dlm bulan itu
		}									   	
			
		$sql		=  "select 
							sum(tns_medis) as tns_medis_total,
							sum(tns_nonmedis) as tns_nonmedis_total,
							sum(tns_surgery) as tns_surgery_total,
							sum(tns_antiaging) as tns_antiaging_total,
							sum(tns_produk) as tns_produk_total,
							sum(tns_lainlain) as tns_lainlain_total,
							sum(tns_total) as tns_grand_total
						from temp_netsales t
						where t.tns_tanggal between '".$tgl_awal."' and '".$tgl_akhir."'";
				
		$result = $this->db->query($sql);
		$nbrows = $result->num_rows();
		//return $query->result();
		
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

	//function for print record
	function laporan_netsales_print($tgl_awal, $tgl_akhir, $bulan, $tahun, $periode, $groupby){
	//full query
		if ($periode == '' && $groupby == ''){
			$periode = 'bulan';
			$tahun = date('Y');
			$bulan = date('m');
		} 
		if ($periode == 'bulan'){
			$tgl_awal	= $tahun.'-'.$bulan.'-01';
			$tgl_akhir	= $tahun.'-'.$bulan.'-'.cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun); //mengetahui jumlah hari dlm bulan itu
		}
			
		//select dari tabel temp / hasilnya
		$sql		=  "select *
						from temp_netsales t
						where t.tns_tanggal between '".$tgl_awal."' and '".$tgl_akhir."'
						order by t.tns_tanggal asc";
				
		$result = $this->db->query($sql);
		$nbrows = $result->num_rows();

		return $result;
	}

	
}
?>