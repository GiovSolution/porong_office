<? /* 
	+ Module  		: LAporan Jumlah Penjualan Produk Model
	+ Description	: For record model process back-end
	+ Filename 		: c_lap_jum_penj_produk.php
 	+ Author  		: Fred

*/

class M_lap_jum_penj_produk extends Model{
		
	//constructor
	function M_lap_jum_penj_produk() {
		parent::Model();
	}
	
	function get_petugas_list($query, $tgl_app="", $karyawan_jabatan, $jabatan_staff){
		$user_id=$_SESSION[SESSION_USERID];

		// query ambil karyawan id
		$sql_karyawan ="select * from users where user_name = '".$user_id."'";
		$query_sql_karyawan= $this->db->query($sql_karyawan);
		if ($query_sql_karyawan->num_rows()){
			$data_sql_karyawan= $query_sql_karyawan->row();
			$karyawan_id= $data_sql_karyawan->user_karyawan;
		}
		
		$bln_now=date('Y-m');
		
		
		if(eregi('H',$this->m_security->get_access_group_by_kode('MENU_LAPJUMPENPRODUK'))){
		$sql=  "SELECT karyawan_id,karyawan_no,karyawan_nama, karyawan_sip,karyawan_username,reportt_jmltindakan 
				FROM vu_karyawan 	
				INNER JOIN jabatan ON(karyawan_jabatan=jabatan_id) 
				LEFT JOIN (SELECT * FROM report_tindakan WHERE reportt_bln LIKE '$bln_now%') as rt ON(karyawan_id=rt.reportt_karyawan_id) 
				LEFT JOIN cabang on(vu_karyawan.karyawan_cabang=cabang.cabang_value)
				WHERE karyawan_jabatan=jabatan_id AND (jabatan_nama='$karyawan_jabatan' or jabatan_nama='$jabatan_staff') AND karyawan_aktif='Aktif'
					AND (karyawan_cabang = (SELECT info_cabang FROM info limit 1) 
					OR substring(karyawan_cabang2,
					(select cabang_value 
						from cabang
						left join info on (cabang.cabang_id = info.info_cabang)
						where info.info_cabang = cabang.cabang_id)
					,1) = '1')";
		
		} else {
			//echo "masuk bawah";
			$sql=  "SELECT karyawan_id,karyawan_no,karyawan_nama, karyawan_sip,karyawan_username,reportt_jmltindakan 
				FROM vu_karyawan 
				INNER JOIN jabatan ON(karyawan_jabatan=jabatan_id) 
				LEFT JOIN (SELECT * FROM report_tindakan WHERE reportt_bln LIKE '$bln_now%') as rt ON(karyawan_id=rt.reportt_karyawan_id) 
				LEFT JOIN cabang on(vu_karyawan.karyawan_cabang=cabang.cabang_value)
				WHERE karyawan_jabatan=jabatan_id AND (jabatan_nama='$karyawan_jabatan' or jabatan_nama='$jabatan_staff') AND karyawan_aktif='Aktif'
					AND karyawan_id = '".$karyawan_id."'
					AND (karyawan_cabang = (SELECT info_cabang FROM info limit 1) 
					OR substring(karyawan_cabang2,
					(select cabang_value 
						from cabang
						left join info on (cabang.cabang_id = info.info_cabang)
						where info.info_cabang = cabang.cabang_id)
					,1) = '1')";
		}
		if($query<>""){
			$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
			$sql .= " (karyawan_nama LIKE '%".addslashes($query)."%')";
		}
		if($tgl_app<>""){
			$tgl_app = date('Y-m-d', strtotime($tgl_app));
			$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
			$sql .= " (absensi_tgl='".addslashes($tgl_app)."')";
		}
		//echo $sql;
		$query = $this->db->query($sql);
		$nbrows = $query->num_rows();
		if($nbrows>0){
			foreach($query->result() as $row){
				$arr[] = $row;
			}
			$jsonresult = json_encode($arr);
			return '({"total":"'.$nbrows.'","results":'.$jsonresult.'})';
		} else {
			return '({"total":"0", "results":""})';
		}
	}
	
		
	//function for get list record
	function lap_jum_penj_produk_list($filter,$start,$end){
			$date_now=date('Y-m-d');
			//$query = "SELECT d.dtrawat_date_create, k.karyawan_username, p.rawat_nama from tindakan_detail d left outer join vu_karyawan k on k.karyawan_id=d.dtrawat_petugas1 left outer join perawatan p on p.rawat_id = d.dtrawat_perawatan where d.dtrawat_date_create > '2010-01-31'";
			$query = "";
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (cust_nama LIKE '%".addslashes($filter)."%' OR rawat_nama LIKE '%".addslashes($filter)."%' OR karyawan_username LIKE '%".addslashes($filter)."%' OR karyawan_nama LIKE '%".addslashes($filter)."%' OR dtrawat_status LIKE '%".addslashes($filter)."%')";
			}
			//$query.=" order by k.karyawan_id";
			
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
		
	function lap_jum_penj_produk_list2($filter,$start,$end){
			$date_now=date('Y-m-d');
			//$query = "SELECT d.dtrawat_date_create, k.karyawan_username, p.rawat_nama from tindakan_detail d left outer join vu_karyawan k on k.karyawan_id=d.dtrawat_petugas1 left outer join perawatan p on p.rawat_id = d.dtrawat_perawatan where d.dtrawat_date_create > '2010-01-31'";
			
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (cust_nama LIKE '%".addslashes($filter)."%' OR rawat_nama LIKE '%".addslashes($filter)."%' OR karyawan_username LIKE '%".addslashes($filter)."%' OR karyawan_nama LIKE '%".addslashes($filter)."%' OR dtrawat_status LIKE '%".addslashes($filter)."%')";
			}
			$query.=" order by k.karyawan_id";
			
			//$query2 = "SELECT * FROM vu_tindakan WHERE kategori_nama='Medis' AND dtrawat_tglapp='$date_now'"; //TAMPILAN MEDIS SAJA
			//$query2 = "SELECT medis.* FROM vu_tindakan medis WHERE (medis.kategori_nama='Medis' OR medis.dtrawat_master IN(SELECT nonmedis.dtrawat_master FROM vu_tindakan nonmedis WHERE nonmedis.kategori_nama='Non Medis' AND date_format(dtrawat_tglapp,'%Y-%m-%d') = date_format('$date_now','%Y-%m-%d') AND nonmedis.dtrawat_dapp='0')) AND date_format(dtrawat_tglapp,'%Y-%m-%d') = date_format('$date_now','%Y-%m-%d')";
			$query2 = "SELECT * FROM vu_tindakan WHERE date_format(dtrawat_tglapp,'%Y-%m-%d') = date_format('$date_now','%Y-%m-%d') AND (kategori_nama='Medis' OR dtrawat_petugas2='0')";
			
			// For simple search
			if ($filter<>""){
				$query2 .=eregi("WHERE",$query2)? " AND ":" WHERE ";
				$query2 .= " (cust_nama LIKE '%".addslashes($filter)."%' OR rawat_nama LIKE '%".addslashes($filter)."%' OR karyawan_username LIKE '%".addslashes($filter)."%' OR karyawan_nama LIKE '%".addslashes($filter)."%' OR dtrawat_status LIKE '%".addslashes($filter)."%')";
			}
			$query2.=" AND dtrawat_status='datang'";
			
			//$query3 = "SELECT * FROM vu_tindakan WHERE kategori_nama='Medis' AND dtrawat_tglapp='$date_now'"; //TAMPILAN MEDIS SAJA
			//$query3 = "SELECT medis.* FROM vu_tindakan medis WHERE (medis.kategori_nama='Medis' OR medis.dtrawat_master IN(SELECT nonmedis.dtrawat_master FROM vu_tindakan nonmedis WHERE nonmedis.kategori_nama='Non Medis' AND date_format(dtrawat_tglapp,'%Y-%m-%d') = date_format('$date_now','%Y-%m-%d') AND nonmedis.dtrawat_dapp='0')) AND date_format(dtrawat_tglapp,'%Y-%m-%d') = date_format('$date_now','%Y-%m-%d')";
			$query3 = "SELECT * FROM vu_tindakan WHERE date_format(dtrawat_tglapp,'%Y-%m-%d') = date_format('$date_now','%Y-%m-%d') AND (kategori_nama='Medis' OR dtrawat_petugas2='0')";
			
			// For simple search
			if ($filter<>""){
				$query3 .=eregi("WHERE",$query3)? " AND ":" WHERE ";
				$query3 .= " (cust_nama LIKE '%".addslashes($filter)."%' OR rawat_nama LIKE '%".addslashes($filter)."%' OR karyawan_username LIKE '%".addslashes($filter)."%' OR karyawan_nama LIKE '%".addslashes($filter)."%' OR dtrawat_status LIKE '%".addslashes($filter)."%')";
			}
			$query3.=" AND dtrawat_status='selesai'";
			
			//$query4 = "SELECT * FROM vu_tindakan WHERE kategori_nama='Medis' AND dtrawat_tglapp='$date_now'"; //TAMPILAN MEDIS SAJA
			//$query4 = "SELECT medis.* FROM vu_tindakan medis WHERE (medis.kategori_nama='Medis' OR medis.dtrawat_master IN(SELECT nonmedis.dtrawat_master FROM vu_tindakan nonmedis WHERE nonmedis.kategori_nama='Non Medis' AND date_format(dtrawat_tglapp,'%Y-%m-%d') = date_format('$date_now','%Y-%m-%d') AND nonmedis.dtrawat_dapp='0')) AND date_format(dtrawat_tglapp,'%Y-%m-%d') = date_format('$date_now','%Y-%m-%d')";
			$query4 = "SELECT * FROM vu_tindakan WHERE date_format(dtrawat_tglapp,'%Y-%m-%d') = date_format('$date_now','%Y-%m-%d') AND (kategori_nama='Medis' OR dtrawat_petugas2='0')";
			
			// For simple search
			if ($filter<>""){
				$query4 .=eregi("WHERE",$query4)? " AND ":" WHERE ";
				$query4 .= " (cust_nama LIKE '%".addslashes($filter)."%' OR rawat_nama LIKE '%".addslashes($filter)."%' OR karyawan_username LIKE '%".addslashes($filter)."%' OR karyawan_nama LIKE '%".addslashes($filter)."%' OR dtrawat_status LIKE '%".addslashes($filter)."%')";
			}
			$query4.=" AND dtrawat_status='batal'";
			
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
			//$limit = $query." LIMIT ".$start.",".$end;		
			//$result = $this->db->query($limit);  
			$result2 = $this->db->query($query2);
			$nbrows2 = $result2->num_rows();
			
			$result3 = $this->db->query($query3);
			$nbrows3 = $result3->num_rows();
			
			$result4 = $this->db->query($query4);
			$nbrows4 = $result4->num_rows();
			
			if($nbrows>0 || $nbrows2>0 || $nbrows3>0 || $nbrows4>0){
				if($nbrows>0){
					foreach($result->result() as $row){
						$arr[] = $row;
					}
				}
				if($nbrows2>0){
					foreach($result2->result() as $row2){
						$arr[] = $row2;
					}
				}
				if($nbrows3>0){
					foreach($result3->result() as $row3){
						$arr[] = $row3;
					}
				}
				if($nbrows4>0){
					foreach($result4->result() as $row4){
						$arr[] = $row4;
					}
				}
				$jsonresult = json_encode($arr);
				return '({"total":"'.$nbrows.'","results":'.$jsonresult.'})';
			} else {
				return '({"total":"0", "results":""})';
			}
		}	
		
	//function for advanced search record
	function lap_jum_penj_produk_search($group1_id,$bulan, $tahun, $opsi_jproduk,$periode,$ljpp_id ,$ljpp_tgl_start ,$ljpp_tgl_end ,$ljpp_karyawan_id, /*$ljpp_groupby, */$start,$end){
			//full query	
			if ($periode == 'bulan'){
				$tanggal_start	= $tahun.'-'.$bulan.'-01';
				$tanggal_end	= $tahun.'-'.$bulan.'-'.cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun); //mengetahui jumlah hari dlm bulan itu
			} else if($periode == 'tanggal'){
				$tanggal_start	= $ljpp_tgl_start;
				$tanggal_end	= $ljpp_tgl_end; 
			}
			
			if ($opsi_jproduk == 'all')
			{
				$query="select vu_karyawan.karyawan_username, produk.produk_kode, produk.produk_nama,
							master_jual_produk.jproduk_tanggal as tanggal,
							sum(detail_jual_produk.dproduk_jumlah) as Jumlah_produk,
							(produk.produk_kredit/100) * produk.produk_harga as komisi_satuan,
							((produk.produk_kredit/100) * produk.produk_harga) * (sum(detail_jual_produk.dproduk_jumlah))  as komisi
						from detail_jual_produk
							left join master_jual_produk on (detail_jual_produk.dproduk_master=master_jual_produk.jproduk_id)
							left join vu_karyawan on (detail_jual_produk.dproduk_karyawan=vu_karyawan.karyawan_id)
							left join produk on (detail_jual_produk.dproduk_produk=produk.produk_id)
						where master_jual_produk.jproduk_stat_dok = 'Tertutup'
							and (master_jual_produk.jproduk_tanggal between '".$tanggal_start."' and '".$tanggal_end."')
							and detail_jual_produk.dproduk_karyawan = '".$ljpp_karyawan_id."'
							group by vu_karyawan.karyawan_username, produk.produk_nama";		
			}else if ($opsi_jproduk == 'group1')
			{
				$query="select vu_karyawan.karyawan_username, produk.produk_kode, produk.produk_nama,
							master_jual_produk.jproduk_tanggal as tanggal,
							sum(detail_jual_produk.dproduk_jumlah) as Jumlah_produk,
							(produk.produk_kredit/100) * produk.produk_harga as komisi_satuan,
							((produk.produk_kredit/100) * produk.produk_harga) * (sum(detail_jual_produk.dproduk_jumlah))  as komisi
						from detail_jual_produk
							left join master_jual_produk on (detail_jual_produk.dproduk_master=master_jual_produk.jproduk_id)
							left join vu_karyawan on (detail_jual_produk.dproduk_karyawan=vu_karyawan.karyawan_id)
							left join produk on (detail_jual_produk.dproduk_produk=produk.produk_id)
						where master_jual_produk.jproduk_stat_dok = 'Tertutup'
							and (master_jual_produk.jproduk_tanggal between '".$tanggal_start."' and '".$tanggal_end."')
							and detail_jual_produk.dproduk_karyawan = '".$ljpp_karyawan_id."'
							and produk.produk_group = '".$group1_id."'
							group by vu_karyawan.karyawan_username, produk.produk_nama";		
			}
		
			else if ($opsi_jproduk == 'Perawatan')
			{
	
			}
		
			else if ($opsi_jproduk == 'Pengambilan_Paket')
			{

			}
		
			$query.= " order by produk_kode ";
			
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
	function lap_jum_penj_produk_search2($group1_id,$bulan, $tahun, $opsi_jproduk,$periode,$ljpp_id ,$ljpp_tgl_start ,$ljpp_tgl_end ,$ljpp_karyawan_id, /*$ljpp_groupby, */ $start,$end){
			//full query
			if ($periode == 'bulan'){
				$tanggal_start	= $tahun.'-'.$bulan.'-01';
				$tanggal_end	= $tahun.'-'.$bulan.'-'.cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun); //mengetahui jumlah hari dlm bulan itu
			} else if($periode == 'tanggal'){
				$tanggal_start	= $ljpp_tgl_start;
				$tanggal_end	= $ljpp_tgl_end; 
			}
			
			if ($opsi_jproduk == 'all')
			{
				$query="select sum(vu_lap_jml_produk.tot_kredit) as Total_kredit
						from
						(	
							select vu_karyawan.karyawan_username, produk.produk_kode, produk.produk_nama,
								master_jual_produk.jproduk_tanggal as tanggal,
								sum(detail_jual_produk.dproduk_jumlah) as Jumlah_produk,
								(produk_kredit/100 * produk_harga) * sum(detail_jual_produk.dproduk_jumlah) as tot_kredit
							from detail_jual_produk
								left join master_jual_produk on (detail_jual_produk.dproduk_master=master_jual_produk.jproduk_id)
								left join vu_karyawan on (detail_jual_produk.dproduk_karyawan=vu_karyawan.karyawan_id)
								left join produk on (detail_jual_produk.dproduk_produk=produk.produk_id)
							where master_jual_produk.jproduk_stat_dok = 'Tertutup'
								and (master_jual_produk.jproduk_tanggal between '".$tanggal_start."' and '".$tanggal_end."')
								and detail_jual_produk.dproduk_karyawan = '".$ljpp_karyawan_id."'
								group by vu_karyawan.karyawan_username, produk.produk_nama
						) as vu_lap_jml_produk
									";
							
			}else if ($opsi_jproduk == 'group1')
			{
				$query="select sum(vu_lap_jml_produk.tot_kredit) as Total_kredit
						from
						(
							select vu_karyawan.karyawan_username, produk.produk_kode, produk.produk_nama,
								master_jual_produk.jproduk_tanggal as tanggal,
								sum(detail_jual_produk.dproduk_jumlah) as Jumlah_produk,
								(produk_kredit/100 * produk_harga) * sum(detail_jual_produk.dproduk_jumlah) as tot_kredit
								(produk.produk_kredit/100) * produk.produk_harga as komisi_satuan,
								((produk.produk_kredit/100) * produk.produk_harga) * (sum(detail_jual_produk.dproduk_jumlah))  as komisi
							from detail_jual_produk
								left join master_jual_produk on (detail_jual_produk.dproduk_master=master_jual_produk.jproduk_id)
								left join vu_karyawan on (detail_jual_produk.dproduk_karyawan=vu_karyawan.karyawan_id)
								left join produk on (detail_jual_produk.dproduk_produk=produk.produk_id)
							where master_jual_produk.jproduk_stat_dok = 'Tertutup'
								and (master_jual_produk.jproduk_tanggal between '".$tanggal_start."' and '".$tanggal_end."')
								and detail_jual_produk.dproduk_karyawan = '".$ljpp_karyawan_id."'
								and produk.produk_group = '".$group1_id."'
								group by vu_karyawan.karyawan_username, produk.produk_nama
						) as vu_lap_jml_produk";								
			}
			else if ($ljpp_groupby == 'Perawatan')
			{

			}
			
			else if ($ljpp_groupby == 'Pengambilan_Paket')
			{
	
			}
			
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

	//function for print record
	function report_tindakan_print($group1_id,$bulan, $tahun, $opsi_jproduk,$periode,$ljpp_tgl_start , $ljpp_tgl_end, $ljpp_karyawan_id,/*$ljpp_groupby, */ $option, $filter){
	
		if ($periode == 'bulan'){
			$tanggal_start	= $tahun.'-'.$bulan.'-01';
			$tanggal_end	= $tahun.'-'.$bulan.'-'.cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun); //mengetahui jumlah hari dlm bulan itu
		} else if($periode == 'tanggal'){
			$tanggal_start	= $ljpp_tgl_start;
			$tanggal_end	= $ljpp_tgl_end; 
		}
			
		//full query
		if ($opsi_jproduk == 'all')
		{
			$query="select vu_karyawan.karyawan_username, produk.produk_kode, produk.produk_nama,
						master_jual_produk.jproduk_tanggal as tanggal,
						sum(detail_jual_produk.dproduk_jumlah) as Jumlah_produk,
						(produk.produk_kredit/100) * produk.produk_harga as komisi_satuan,
						((produk.produk_kredit/100) * produk.produk_harga) * (sum(detail_jual_produk.dproduk_jumlah))  as komisi
					from detail_jual_produk
						left join master_jual_produk on (detail_jual_produk.dproduk_master=master_jual_produk.jproduk_id)
						left join vu_karyawan on (detail_jual_produk.dproduk_karyawan=vu_karyawan.karyawan_id)
						left join produk on (detail_jual_produk.dproduk_produk=produk.produk_id)
					where master_jual_produk.jproduk_stat_dok = 'Tertutup'
						and (master_jual_produk.jproduk_tanggal between '".$tanggal_start."' and '".$tanggal_end."')
						and detail_jual_produk.dproduk_karyawan = '".$ljpp_karyawan_id."'
						group by vu_karyawan.karyawan_username, produk.produk_nama
							";
						
		}
		else if ($opsi_jproduk == 'group1')
		{
			$query="select vu_karyawan.karyawan_username, produk.produk_kode, produk.produk_nama,
						master_jual_produk.jproduk_tanggal as tanggal,
						sum(detail_jual_produk.dproduk_jumlah) as Jumlah_produk,
						(produk.produk_kredit/100) * produk.produk_harga as komisi_satuan,
						((produk.produk_kredit/100) * produk.produk_harga) * (sum(detail_jual_produk.dproduk_jumlah))  as komisi
					from detail_jual_produk
						left join master_jual_produk on (detail_jual_produk.dproduk_master=master_jual_produk.jproduk_id)
						left join vu_karyawan on (detail_jual_produk.dproduk_karyawan=vu_karyawan.karyawan_id)
						left join produk on (detail_jual_produk.dproduk_produk=produk.produk_id)
					where master_jual_produk.jproduk_stat_dok = 'Tertutup'
						and (master_jual_produk.jproduk_tanggal between '".$tanggal_start."' and '".$tanggal_end."')
						and detail_jual_produk.dproduk_karyawan = '".$ljpp_karyawan_id."'
						and produk.produk_group = '".$group1_id."'
						group by vu_karyawan.karyawan_username, produk.produk_nama";		
		}
		else if ($ljpp_groupby == 'Perawatan')
		{

		}
	
		else if ($ljpp_groupby == 'Pengambilan_Paket')
		{

		}
	 
		$result = $this->db->query($query);  
		return $result;
	}
		
	//function  for export to excel
	function lap_jum_penj_produk_exportExcel($group1_id,$bulan, $tahun, $opsi_jproduk,$periode,$ljpp_tgl_start , $ljpp_tgl_end, $ljpp_karyawan_id,
										/*$ljpp_groupby, */$option, $filter){
			//full query
				
		if ($periode == 'bulan'){
				$tanggal_start	= $tahun.'-'.$bulan.'-01';
				$tanggal_end	= $tahun.'-'.$bulan.'-'.cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun); //mengetahui jumlah hari dlm bulan itu
			} else if($periode == 'tanggal'){
				$tanggal_start	= $ljpp_tgl_start;
				$tanggal_end	= $ljpp_tgl_end; 
			}
			
		if ($opsi_jproduk == 'all')
		{
				$query="select produk.produk_kode as Kode, produk.produk_nama as Produk,
							sum(detail_jual_produk.dproduk_jumlah) as Jumlah,
							(produk.produk_kredit/100) * produk.produk_harga as Kredit_Rp,												
							((produk.produk_kredit/100) * produk.produk_harga) * (sum(detail_jual_produk.dproduk_jumlah))  as Tot_Kredit_Rp
						from detail_jual_produk
							left join master_jual_produk on (detail_jual_produk.dproduk_master=master_jual_produk.jproduk_id)
							left join vu_karyawan on (detail_jual_produk.dproduk_karyawan=vu_karyawan.karyawan_id)
							left join produk on (detail_jual_produk.dproduk_produk=produk.produk_id)
						where master_jual_produk.jproduk_stat_dok = 'Tertutup'
							and (master_jual_produk.jproduk_tanggal between '".$tanggal_start."' and '".$tanggal_end."')
							and detail_jual_produk.dproduk_karyawan = '".$ljpp_karyawan_id."'
							group by vu_karyawan.karyawan_username, produk.produk_nama
						";				
		}
		else if ($opsi_jproduk == 'group1')
			{
				$query="select produk.produk_kode, produk.produk_nama,
							sum(detail_jual_produk.dproduk_jumlah) as Jumlah,
							(produk.produk_kredit/100) * produk.produk_harga as Kredit_Rp,
							((produk.produk_kredit/100) * produk.produk_harga) * (sum(detail_jual_produk.dproduk_jumlah))   as Tot_Kredit_Rp
						from detail_jual_produk
							left join master_jual_produk on (detail_jual_produk.dproduk_master=master_jual_produk.jproduk_id)
							left join vu_karyawan on (detail_jual_produk.dproduk_karyawan=vu_karyawan.karyawan_id)
							left join produk on (detail_jual_produk.dproduk_produk=produk.produk_id)
						where master_jual_produk.jproduk_stat_dok = 'Tertutup'
							and (master_jual_produk.jproduk_tanggal between '".$tanggal_start."' and '".$tanggal_end."')
							and detail_jual_produk.dproduk_karyawan = '".$ljpp_karyawan_id."'
							and produk.produk_group = '".$group1_id."'
							group by vu_karyawan.karyawan_username, produk.produk_nama";		
			}
		else if ($ljpp_groupby == 'Perawatan')
		{

		}
	
		else if ($ljpp_groupby == 'Pengambilan_Paket')
		{

		}
	 
		$result = $this->db->query($query);  
		return $result;
	}
		
}
?>