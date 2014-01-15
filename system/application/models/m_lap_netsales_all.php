<? /* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
		
	+ Module  		: Laporan Net Sales Model
	+ Description	: For record model process back-end
	+ Filename 		: m_lap_netsales_all.php
 	+ Author  		: Miracle Corporate IT Dept
 	+ Created on 2011-10-03
	
*/

class M_lap_netsales_all extends Model{
		
		//constructor
		function M_lap_netsales_all() {
			parent::Model();
		}
		
	function get_laporan_netsales_all($tgl_awal, $tgl_akhir, $periode, $bulan, $tahun, $cabang_th, $cabang_ki, $cabang_hr, $cabang_tp, $cabang_dps, $cabang_mta, $cabang_mdn, $cabang_lbk, $cabang_mnd, $cabang_ygk, $cabang_blpn, $chart='false'){

		if ($periode == 'bulan'){
			$tgl_awal	= $tahun.'-'.$bulan.'-01';
			$tgl_akhir	= $tahun.'-'.$bulan.'-'.cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun); //mengetahui jumlah hari dlm bulan itu
		}									   
	
		//select dari tabel temp / hasilnya
		$sql		=  "select
							v.cabang_kode, 
							sum(v.tns_medis) as tns_medis,
							sum(v.tns_nonmedis) as tns_nonmedis, 
							sum(v.tns_surgery) as tns_surgery, 
							sum(v.tns_antiaging) as tns_antiaging, 
							sum(v.tns_produk) as tns_produk, 
							sum(v.tns_lainlain) as tns_lainlain,
							sum(v.tns_total) as tns_total
						from vu_netsales_all v
						where 
							v.tns_tanggal between '".$tgl_awal."' and '".$tgl_akhir."'
							and (v.cabang_kode = ".$cabang_th."
							or v.cabang_kode = ".$cabang_ki."
							or v.cabang_kode = ".$cabang_hr."
							or v.cabang_kode = ".$cabang_tp."
							or v.cabang_kode = ".$cabang_dps."
							or v.cabang_kode = ".$cabang_mta."
							or v.cabang_kode = ".$cabang_mdn."
							or v.cabang_kode = ".$cabang_lbk."
							or v.cabang_kode = ".$cabang_mnd."
							or v.cabang_kode = ".$cabang_ygk.")
						group by v.cabang_kode
						order by v.cabang_order";
				
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
	
	function get_laporan_netsales_alltotal($tgl_awal, $tgl_akhir, $periode, $bulan, $tahun, $cabang_th, $cabang_ki, $cabang_hr, $cabang_tp, $cabang_dps, $cabang_mta, $cabang_mdn, $cabang_lbk, $cabang_mnd, $cabang_ygk, $cabang_blpn){

		if ($periode == 'bulan'){
			$tgl_awal	= $tahun.'-'.$bulan.'-01';
			$tgl_akhir	= $tahun.'-'.$bulan.'-'.cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun); //mengetahui jumlah hari dlm bulan itu
		}									   	
			
		$sql		=  "select 
							sum(v.tns_medis) as tns_medis_total,
							sum(v.tns_nonmedis) as tns_nonmedis_total, 
							sum(v.tns_surgery) as tns_surgery_total, 
							sum(v.tns_antiaging) as tns_antiaging_total, 
							sum(v.tns_produk) as tns_produk_total, 
							sum(v.tns_lainlain) as tns_lainlain_total,
							sum(v.tns_total) as tns_grand_total
						from vu_netsales_all v
						where v.tns_tanggal between '".$tgl_awal."' and '".$tgl_akhir."'
						and (v.cabang_kode = ".$cabang_th."
							or v.cabang_kode = ".$cabang_ki."
							or v.cabang_kode = ".$cabang_hr."
							or v.cabang_kode = ".$cabang_tp."
							or v.cabang_kode = ".$cabang_dps."
							or v.cabang_kode = ".$cabang_mta."
							or v.cabang_kode = ".$cabang_mdn."
							or v.cabang_kode = ".$cabang_lbk."
							or v.cabang_kode = ".$cabang_mnd."
							or v.cabang_kode = ".$cabang_ygk.")";
				
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

	function get_laporan_netsales_alldetail($tgl_awal, $tgl_akhir, $periode, $bulan, $tahun, $cabang){

		if ($periode == 'bulan'){
			$tgl_awal	= $tahun.'-'.$bulan.'-01';
			$tgl_akhir	= $tahun.'-'.$bulan.'-'.cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun); //mengetahui jumlah hari dlm bulan itu
		}									   	
			
		$sql		=  "select
							v.tns_tanggal,
							v.tns_medis,
							v.tns_nonmedis,
							v.tns_surgery,
							v.tns_antiaging,
							v.tns_produk,
							v.tns_lainlain,
							v.tns_total,
							v.tns_source,
							v.tns_date_create
						from vu_netsales_all v
						where v.tns_tanggal between '".$tgl_awal."' and '".$tgl_akhir."'
						and v.cabang_kode = ".$cabang."
						order by v.tns_tanggal asc";
				
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
}
?>