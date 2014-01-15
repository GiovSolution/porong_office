<? /* 
	+ Module  		: report Tindakan Model
	+ Description	: For record model process back-end
	+ Filename 		: c_lap_jum_tindakan_terapis.php
 	+ Author  		: Fred

*/

class M_lap_jum_tindakan_terapis extends Model{
		
	//constructor
	function M_lap_jum_tindakan_terapis() {
		parent::Model();
	}

	
	function get_terapis_list($query="",$start=0,$end=200){
		$user_id=$_SESSION[SESSION_USERID];

		// query ambil karyawan id
		$sql_karyawan ="select * from users where user_name = '".$user_id."'";
		$query_sql_karyawan= $this->db->query($sql_karyawan);
		if ($query_sql_karyawan->num_rows()){
			$data_sql_karyawan= $query_sql_karyawan->row();
			$karyawan_id= $data_sql_karyawan->user_karyawan;
		}
		
		if(eregi('H',$this->m_security->get_access_group_by_kode('MENU_LAPJUMTINDTERAPIS'))){
			$sql="select karyawan_id,karyawan_no,karyawan_nama,karyawan_username,jabatan_nama 
			from vu_karyawan,jabatan 
			where jabatan_id=karyawan_jabatan and karyawan_aktif='Aktif' and (karyawan_jabatan='7' or karyawan_jabatan='4' or karyawan_jabatan = '9' or karyawan_nama = 'suster')";
		} else {
			$sql="select karyawan_id,karyawan_no,karyawan_nama,karyawan_username,jabatan_nama 
			from vu_karyawan,jabatan 
			where jabatan_id=karyawan_jabatan and karyawan_aktif='Aktif'  AND karyawan_id = '".$karyawan_id."' and (karyawan_jabatan='7' or karyawan_jabatan='4' or karyawan_jabatan = '9' or karyawan_nama = 'suster')";
		}
		
		if($query!=="")
				$sql.=" and (karyawan_id like '%".$query."%' or karyawan_no like '%".$query."%' or karyawan_nama like '%".$query."%' or karyawan_username like '%".$query."%')";
		
		$result = $this->db->query($sql);
		$nbrows = $result->num_rows();
		$limit = $sql." LIMIT ".$start.",".$end;			
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
	
	
		
	//function for get list record
	function lap_jum_tindakan_terapis_list($filter,$start,$end){
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
		
	function lap_jum_tindakan_terapis_list2($filter,$start,$end){
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
	function lap_jum_tindakan_terapis_search($tgl_awal,$periode,$lap_jum_tindakan_terapis_id ,$lapjum_tglapp_start ,$lapjum_tglapp_end ,$terapis_id, $lapjum_groupby, $start,$end){
			//full query
			
			if ($periode == 'bulan'){
				$isiperiode=" (date_format(jrawat_tanggal,'%Y-%m')='".$tgl_awal."') and " ;
				$tglpaket=" (date_format(dapaket_tgl_ambil,'%Y-%m')='".$tgl_awal."') and " ;
			}else if($periode == 'tanggal'){
				$isiperiode=" (jrawat_tanggal BETWEEN '".$lapjum_tglapp_start."' AND '".$lapjum_tglapp_end."') 
							and ";
				$tglpaket=" (dapaket_tgl_ambil BETWEEN '".$lapjum_tglapp_start."' AND '".$lapjum_tglapp_end."') 
							and " ;
			}
	
			if ($lapjum_groupby == 'Semua')
			{
			$query ="select rawat_nama,  sum(Jumlah_rawat) as Jumlah_rawat,rawat_kredit, rawat_kode,sum(Total_kredit)	as Total_kredit
					from
						(
						(select ifnull(if((tindakan_detail.dtrawat_petugas1 = 0),if((tindakan_detail.dtrawat_petugas2 = 0),NULL,terapis.karyawan_username),dokter.karyawan_username),referal.karyawan_username) AS karyawan_username,
							perawatan.rawat_nama, perawatan.rawat_kredit, perawatan.rawat_kode,'paket' as status,
							sum(detail_ambil_paket.dapaket_jumlah) as Jumlah_rawat,
							perawatan.rawat_kredit * sum(detail_ambil_paket.dapaket_jumlah) as Total_kredit,
							detail_ambil_paket.dapaket_tgl_ambil as tanggal,
							perawatan.rawat_id as perawatan_id,
							detail_ambil_paket.dapaket_stat_dok as stat_dok
						from detail_ambil_paket
							left join perawatan on (perawatan.rawat_id=detail_ambil_paket.dapaket_item)
							left join tindakan_detail on (tindakan_detail.dtrawat_id=detail_ambil_paket.dapaket_dtrawat)
							left join vu_karyawan as dokter on (tindakan_detail.dtrawat_petugas1=dokter.karyawan_id)
							left join vu_karyawan as terapis on (tindakan_detail.dtrawat_petugas2=terapis.karyawan_id)
							left join vu_karyawan as referal on (detail_ambil_paket.dapaket_referal=referal.karyawan_id)
							left join master_jual_paket on (master_jual_paket.jpaket_id = detail_ambil_paket.dapaket_jpaket)
						WHERE  (detail_ambil_paket.dapaket_referal = '".$terapis_id."' or tindakan_detail.dtrawat_petugas2 = '".$terapis_id."'
						 or tindakan_detail.dtrawat_petugas1 = '".$terapis_id."') and 
							".$tglpaket." (dapaket_item is not null and dapaket_stat_dok='Tertutup') and master_jual_paket.jpaket_stat_dok = 'Tertutup'
							group by karyawan_username, rawat_nama
						)
						union
						(select ifnull(if((tindakan_detail.dtrawat_petugas1 = 0),if((tindakan_detail.dtrawat_petugas2 = 0),NULL,terapis.karyawan_username),dokter.karyawan_username),referal.karyawan_username) AS karyawan_username,
							perawatan.rawat_nama, perawatan.rawat_kredit, perawatan.rawat_kode,'satuan' as status,
							sum(detail_jual_rawat.drawat_jumlah) as Jumlah_rawat,
							perawatan.rawat_kredit * sum(detail_jual_rawat.drawat_jumlah) as Total_kredit,
							master_jual_rawat.jrawat_tanggal as tanggal,
							perawatan.rawat_id as perawatan_id,
							master_jual_rawat.jrawat_stat_dok as stat_dok
						from detail_jual_rawat
							left join master_jual_rawat on (master_jual_rawat.jrawat_id=detail_jual_rawat.drawat_master)
							left join perawatan on (perawatan.rawat_id=detail_jual_rawat.drawat_rawat)
							left join tindakan_detail on (tindakan_detail.dtrawat_id=detail_jual_rawat.drawat_dtrawat)
							left join vu_karyawan as dokter on (tindakan_detail.dtrawat_petugas1=dokter.karyawan_id)
							left join vu_karyawan as terapis on (tindakan_detail.dtrawat_petugas2=terapis.karyawan_id)
							left join vu_karyawan as referal on (detail_jual_rawat.drawat_sales=referal.karyawan_id)
						WHERE (detail_jual_rawat.drawat_sales = '".$terapis_id."' or tindakan_detail.dtrawat_petugas2 = '".$terapis_id."'
						or tindakan_detail.dtrawat_petugas1 = '".$terapis_id."') and 
							".$isiperiode." (rawat_id is not null and jrawat_stat_dok='Tertutup')
						group by karyawan_username, rawat_nama)
						)
					as tabel_union
					group by karyawan_username, rawat_nama";
			}
				

			else if ($lapjum_groupby == 'Perawatan')
			{
			$query ="select ifnull(if((tindakan_detail.dtrawat_petugas1 = 0),if((tindakan_detail.dtrawat_petugas2 = 0),NULL,terapis.karyawan_username),dokter.karyawan_username),referal.karyawan_username) AS karyawan_username,
							perawatan.rawat_nama, perawatan.rawat_kredit, perawatan.rawat_kode,'satuan' as status,
							sum(detail_jual_rawat.drawat_jumlah) as Jumlah_rawat,
							perawatan.rawat_kredit * sum(detail_jual_rawat.drawat_jumlah) as Total_kredit,
							master_jual_rawat.jrawat_tanggal as tanggal,
							perawatan.rawat_id as perawatan_id,
							master_jual_rawat.jrawat_stat_dok as stat_dok
						from detail_jual_rawat
							left join master_jual_rawat on (master_jual_rawat.jrawat_id=detail_jual_rawat.drawat_master)
							left join perawatan on (perawatan.rawat_id=detail_jual_rawat.drawat_rawat)
							left join tindakan_detail on (tindakan_detail.dtrawat_id=detail_jual_rawat.drawat_dtrawat)
							left join vu_karyawan as dokter on (tindakan_detail.dtrawat_petugas1=dokter.karyawan_id)
							left join vu_karyawan as terapis on (tindakan_detail.dtrawat_petugas2=terapis.karyawan_id)
							left join vu_karyawan as referal on (detail_jual_rawat.drawat_sales=referal.karyawan_id)
						WHERE (detail_jual_rawat.drawat_sales = '".$terapis_id."' or tindakan_detail.dtrawat_petugas2 = '".$terapis_id."') and 
							".$isiperiode." (rawat_id is not null and jrawat_stat_dok='Tertutup')
						group by karyawan_username, rawat_nama";
	
			}
			
			else if ($lapjum_groupby == 'Pengambilan_Paket')
			{
			$query ="select ifnull(if((tindakan_detail.dtrawat_petugas1 = 0),if((tindakan_detail.dtrawat_petugas2 = 0),NULL,terapis.karyawan_username),dokter.karyawan_username),referal.karyawan_username) AS karyawan_username,
							perawatan.rawat_nama, perawatan.rawat_kredit, perawatan.rawat_kode,'paket' as status,
							sum(detail_ambil_paket.dapaket_jumlah) as Jumlah_rawat,
							perawatan.rawat_kredit * sum(detail_ambil_paket.dapaket_jumlah) as Total_kredit,
							detail_ambil_paket.dapaket_tgl_ambil as tanggal,
							perawatan.rawat_id as perawatan_id,
							detail_ambil_paket.dapaket_stat_dok as stat_dok
						from detail_ambil_paket
							left join perawatan on (perawatan.rawat_id=detail_ambil_paket.dapaket_item)
							left join tindakan_detail on (tindakan_detail.dtrawat_id=detail_ambil_paket.dapaket_dtrawat)
							left join vu_karyawan as dokter on (tindakan_detail.dtrawat_petugas1=dokter.karyawan_id)
							left join vu_karyawan as terapis on (tindakan_detail.dtrawat_petugas2=terapis.karyawan_id)
							left join vu_karyawan as referal on (detail_ambil_paket.dapaket_referal=referal.karyawan_id)
							left join master_jual_paket on (master_jual_paket.jpaket_id = detail_ambil_paket.dapaket_jpaket)
						WHERE  (detail_ambil_paket.dapaket_referal = '".$terapis_id."' or tindakan_detail.dtrawat_petugas2 = '".$terapis_id."') and 
							".$tglpaket." (dapaket_item is not null and dapaket_stat_dok='Tertutup') and master_jual_paket.jpaket_stat_dok = 'Tertutup'
							group by karyawan_username, rawat_nama";
			}
			
			$query.= " order by rawat_kode ";
			
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
	function lap_jum_tindakan_terapis_search2($tgl_awal,$periode,$lap_jum_tindakan_terapis_id ,$lapjum_tglapp_start ,$lapjum_tglapp_end ,$terapis_id, $lapjum_groupby, $start,$end){
			//full query
			
			if ($periode == 'bulan'){
				$isiperiode=" (date_format(jrawat_tanggal,'%Y-%m')='".$tgl_awal."') and " ;
				$tglpaket=" (date_format(dapaket_tgl_ambil,'%Y-%m')='".$tgl_awal."') and " ;
			}else if($periode == 'tanggal'){
				$isiperiode=" (jrawat_tanggal BETWEEN '".$lapjum_tglapp_start."' AND '".$lapjum_tglapp_end."') 
							and ";
				$tglpaket=" (dapaket_tgl_ambil BETWEEN '".$lapjum_tglapp_start."' AND '".$lapjum_tglapp_end."') 
							and " ;
			}
			
			if ($lapjum_groupby == 'Semua')
			{
			$query ="select sum(table_union.Total_kredit) as grand_total
					from(
					(select ifnull(if((tindakan_detail.dtrawat_petugas1 = 0),if((tindakan_detail.dtrawat_petugas2 = 0),NULL,terapis.karyawan_username),dokter.karyawan_username),referal.karyawan_username) AS karyawan_username,
							perawatan.rawat_nama, perawatan.rawat_kredit, perawatan.rawat_kode,'paket' as status,
							sum(detail_ambil_paket.dapaket_jumlah) as Jumlah_rawat,
							perawatan.rawat_kredit * sum(detail_ambil_paket.dapaket_jumlah) as Total_kredit,
							detail_ambil_paket.dapaket_tgl_ambil as tanggal,
							perawatan.rawat_id as perawatan_id,
							detail_ambil_paket.dapaket_stat_dok as stat_dok
						from detail_ambil_paket
							left join perawatan on (perawatan.rawat_id=detail_ambil_paket.dapaket_item)
							left join tindakan_detail on (tindakan_detail.dtrawat_id=detail_ambil_paket.dapaket_dtrawat)
							left join vu_karyawan as dokter on (tindakan_detail.dtrawat_petugas1=dokter.karyawan_id)
							left join vu_karyawan as terapis on (tindakan_detail.dtrawat_petugas2=terapis.karyawan_id)
							left join vu_karyawan as referal on (detail_ambil_paket.dapaket_referal=referal.karyawan_id)
							left join master_jual_paket on (master_jual_paket.jpaket_id = detail_ambil_paket.dapaket_jpaket)
						WHERE  (detail_ambil_paket.dapaket_referal = '".$terapis_id."' or tindakan_detail.dtrawat_petugas2 = '".$terapis_id."') and 
							".$tglpaket." (dapaket_item is not null and dapaket_stat_dok='Tertutup') and master_jual_paket.jpaket_stat_dok = 'Tertutup'
							group by karyawan_username, rawat_nama)
					union
					(select ifnull(if((tindakan_detail.dtrawat_petugas1 = 0),if((tindakan_detail.dtrawat_petugas2 = 0),NULL,terapis.karyawan_username),dokter.karyawan_username),referal.karyawan_username) AS karyawan_username,
							perawatan.rawat_nama, perawatan.rawat_kredit, perawatan.rawat_kode,'satuan' as status,
							sum(detail_jual_rawat.drawat_jumlah) as Jumlah_rawat,
							perawatan.rawat_kredit * sum(detail_jual_rawat.drawat_jumlah) as Total_kredit,
							master_jual_rawat.jrawat_tanggal as tanggal,
							perawatan.rawat_id as perawatan_id,
							master_jual_rawat.jrawat_stat_dok as stat_dok
						from detail_jual_rawat
							left join master_jual_rawat on (master_jual_rawat.jrawat_id=detail_jual_rawat.drawat_master)
							left join perawatan on (perawatan.rawat_id=detail_jual_rawat.drawat_rawat)
							left join tindakan_detail on (tindakan_detail.dtrawat_id=detail_jual_rawat.drawat_dtrawat)
							left join vu_karyawan as dokter on (tindakan_detail.dtrawat_petugas1=dokter.karyawan_id)
							left join vu_karyawan as terapis on (tindakan_detail.dtrawat_petugas2=terapis.karyawan_id)
							left join vu_karyawan as referal on (detail_jual_rawat.drawat_sales=referal.karyawan_id)
						WHERE (detail_jual_rawat.drawat_sales = '".$terapis_id."' or tindakan_detail.dtrawat_petugas2 = '".$terapis_id."') and 
							".$isiperiode." (rawat_id is not null and jrawat_stat_dok='Tertutup')
						group by karyawan_username, rawat_nama)) as table_union"
				;
			}
			
			if ($lapjum_groupby == 'Perawatan')
			{
			$query ="select sum(vu_kredit.Total_kredit) as grand_total 
						from(
							select ifnull(if((tindakan_detail.dtrawat_petugas1 = 0),if((tindakan_detail.dtrawat_petugas2 = 0),NULL,terapis.karyawan_username),dokter.karyawan_username),referal.karyawan_username) AS karyawan_username,
							perawatan.rawat_nama, perawatan.rawat_kredit, perawatan.rawat_kode,'satuan' as status,
							sum(detail_jual_rawat.drawat_jumlah) as Jumlah_rawat,
							perawatan.rawat_kredit * sum(detail_jual_rawat.drawat_jumlah) as Total_kredit,
							master_jual_rawat.jrawat_tanggal as tanggal,
							perawatan.rawat_id as perawatan_id,
							master_jual_rawat.jrawat_stat_dok as stat_dok
						from detail_jual_rawat
							left join master_jual_rawat on (master_jual_rawat.jrawat_id=detail_jual_rawat.drawat_master)
							left join perawatan on (perawatan.rawat_id=detail_jual_rawat.drawat_rawat)
							left join tindakan_detail on (tindakan_detail.dtrawat_id=detail_jual_rawat.drawat_dtrawat)
							left join vu_karyawan as dokter on (tindakan_detail.dtrawat_petugas1=dokter.karyawan_id)
							left join vu_karyawan as terapis on (tindakan_detail.dtrawat_petugas2=terapis.karyawan_id)
							left join vu_karyawan as referal on (detail_jual_rawat.drawat_sales=referal.karyawan_id)
						WHERE (detail_jual_rawat.drawat_sales = '".$terapis_id."' or tindakan_detail.dtrawat_petugas2 = '".$terapis_id."') and 
							".$isiperiode." (rawat_id is not null and jrawat_stat_dok='Tertutup')
						group by karyawan_username, rawat_nama) as vu_kredit";
		
			}
			
			else if ($lapjum_groupby == 'Pengambilan_Paket')
			{
			$query ="select sum(vu_kredit.Total_kredit) as grand_total 
						from(
							select ifnull(if((tindakan_detail.dtrawat_petugas1 = 0),if((tindakan_detail.dtrawat_petugas2 = 0),NULL,terapis.karyawan_username),dokter.karyawan_username),referal.karyawan_username) AS karyawan_username,
							perawatan.rawat_nama, perawatan.rawat_kredit, perawatan.rawat_kode,'paket' as status,
							sum(detail_ambil_paket.dapaket_jumlah) as Jumlah_rawat,
							perawatan.rawat_kredit * sum(detail_ambil_paket.dapaket_jumlah) as Total_kredit,
							detail_ambil_paket.dapaket_tgl_ambil as tanggal,
							perawatan.rawat_id as perawatan_id,
							detail_ambil_paket.dapaket_stat_dok as stat_dok
						from detail_ambil_paket
							left join perawatan on (perawatan.rawat_id=detail_ambil_paket.dapaket_item)
							left join tindakan_detail on (tindakan_detail.dtrawat_id=detail_ambil_paket.dapaket_dtrawat)
							left join vu_karyawan as dokter on (tindakan_detail.dtrawat_petugas1=dokter.karyawan_id)
							left join vu_karyawan as terapis on (tindakan_detail.dtrawat_petugas2=terapis.karyawan_id)
							left join vu_karyawan as referal on (detail_ambil_paket.dapaket_referal=referal.karyawan_id)
							left join master_jual_paket on (master_jual_paket.jpaket_id = detail_ambil_paket.dapaket_jpaket)
						WHERE  (detail_ambil_paket.dapaket_referal = '".$terapis_id."' or tindakan_detail.dtrawat_petugas2 = '".$terapis_id."') and 
							".$tglpaket." (dapaket_item is not null and dapaket_stat_dok='Tertutup') and master_jual_paket.jpaket_stat_dok = 'Tertutup'
							group by karyawan_username, rawat_nama) as vu_kredit";
			
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
	function lap_jum_tindakan_terapis_print($tgl_awal,$periode,$lap_jum_tindakan_terapis_id ,$lapjum_tglapp_start ,$lapjum_tglapp_end ,$terapis_id ,$lapjum_groupby, $option,$filter){
			//full query
			
				if ($periode == 'bulan'){
					$isiperiode=" (date_format(jrawat_tanggal,'%Y-%m')='".$tgl_awal."') and " ;
					$tglpaket=" (date_format(dapaket_tgl_ambil,'%Y-%m')='".$tgl_awal."') and " ;
				}else if($periode == 'tanggal'){
					$isiperiode=" (jrawat_tanggal BETWEEN '".$lapjum_tglapp_start."' AND '".$lapjum_tglapp_end."') 
								and ";
					$tglpaket=" (dapaket_tgl_ambil BETWEEN '".$lapjum_tglapp_start."' AND '".$lapjum_tglapp_end."') 
								and " ;
				}
		
				if ($lapjum_groupby == 'Semua')
				{
				$query ="select rawat_nama,  sum(Jumlah_rawat) as Jumlah_rawat,rawat_kredit, rawat_kode,sum(Total_kredit)	as Total_kredit, karyawan_username
						from
							(
							(select ifnull(if((tindakan_detail.dtrawat_petugas1 = 0),if((tindakan_detail.dtrawat_petugas2 = 0),NULL,terapis.karyawan_username),dokter.karyawan_username),referal.karyawan_username) AS karyawan_username,
								perawatan.rawat_nama, perawatan.rawat_kredit, perawatan.rawat_kode,'paket' as status,
								sum(detail_ambil_paket.dapaket_jumlah) as Jumlah_rawat,
								perawatan.rawat_kredit * sum(detail_ambil_paket.dapaket_jumlah) as Total_kredit,
								detail_ambil_paket.dapaket_tgl_ambil as tanggal,
								perawatan.rawat_id as perawatan_id,
								detail_ambil_paket.dapaket_stat_dok as stat_dok
							from detail_ambil_paket
								left join perawatan on (perawatan.rawat_id=detail_ambil_paket.dapaket_item)
								left join tindakan_detail on (tindakan_detail.dtrawat_id=detail_ambil_paket.dapaket_dtrawat)
								left join vu_karyawan as dokter on (tindakan_detail.dtrawat_petugas1=dokter.karyawan_id)
								left join vu_karyawan as terapis on (tindakan_detail.dtrawat_petugas2=terapis.karyawan_id)
								left join vu_karyawan as referal on (detail_ambil_paket.dapaket_referal=referal.karyawan_id)
								left join master_jual_paket on (master_jual_paket.jpaket_id = detail_ambil_paket.dapaket_jpaket)
							WHERE  (detail_ambil_paket.dapaket_referal = '".$terapis_id."' or tindakan_detail.dtrawat_petugas2 = '".$terapis_id."'
							 or tindakan_detail.dtrawat_petugas1 = '".$terapis_id."') and 
								".$tglpaket." (dapaket_item is not null and dapaket_stat_dok='Tertutup') and master_jual_paket.jpaket_stat_dok = 'Tertutup'
								group by karyawan_username, rawat_nama
							)
							union
							(select ifnull(if((tindakan_detail.dtrawat_petugas1 = 0),if((tindakan_detail.dtrawat_petugas2 = 0),NULL,terapis.karyawan_username),dokter.karyawan_username),referal.karyawan_username) AS karyawan_username,
								perawatan.rawat_nama, perawatan.rawat_kredit, perawatan.rawat_kode,'satuan' as status,
								sum(detail_jual_rawat.drawat_jumlah) as Jumlah_rawat,
								perawatan.rawat_kredit * sum(detail_jual_rawat.drawat_jumlah) as Total_kredit,
								master_jual_rawat.jrawat_tanggal as tanggal,
								perawatan.rawat_id as perawatan_id,
								master_jual_rawat.jrawat_stat_dok as stat_dok
							from detail_jual_rawat
								left join master_jual_rawat on (master_jual_rawat.jrawat_id=detail_jual_rawat.drawat_master)
								left join perawatan on (perawatan.rawat_id=detail_jual_rawat.drawat_rawat)
								left join tindakan_detail on (tindakan_detail.dtrawat_id=detail_jual_rawat.drawat_dtrawat)
								left join vu_karyawan as dokter on (tindakan_detail.dtrawat_petugas1=dokter.karyawan_id)
								left join vu_karyawan as terapis on (tindakan_detail.dtrawat_petugas2=terapis.karyawan_id)
								left join vu_karyawan as referal on (detail_jual_rawat.drawat_sales=referal.karyawan_id)
							WHERE (detail_jual_rawat.drawat_sales = '".$terapis_id."' or tindakan_detail.dtrawat_petugas2 = '".$terapis_id."'
							 or tindakan_detail.dtrawat_petugas1 = '".$terapis_id."') and 
								".$isiperiode." (rawat_id is not null and jrawat_stat_dok='Tertutup')
							group by karyawan_username, rawat_nama)
							)
						as tabel_union
						group by karyawan_username, rawat_nama";
				}
					

				else if ($lapjum_groupby == 'Perawatan')
				{
				$query ="select ifnull(if((tindakan_detail.dtrawat_petugas1 = 0),if((tindakan_detail.dtrawat_petugas2 = 0),NULL,terapis.karyawan_username),dokter.karyawan_username),referal.karyawan_username) AS karyawan_username,
								perawatan.rawat_nama, perawatan.rawat_kredit, perawatan.rawat_kode,'satuan' as status,
								sum(detail_jual_rawat.drawat_jumlah) as Jumlah_rawat,
								perawatan.rawat_kredit * sum(detail_jual_rawat.drawat_jumlah) as Total_kredit,
								master_jual_rawat.jrawat_tanggal as tanggal,
								perawatan.rawat_id as perawatan_id,
								master_jual_rawat.jrawat_stat_dok as stat_dok
							from detail_jual_rawat
								left join master_jual_rawat on (master_jual_rawat.jrawat_id=detail_jual_rawat.drawat_master)
								left join perawatan on (perawatan.rawat_id=detail_jual_rawat.drawat_rawat)
								left join tindakan_detail on (tindakan_detail.dtrawat_id=detail_jual_rawat.drawat_dtrawat)
								left join vu_karyawan as dokter on (tindakan_detail.dtrawat_petugas1=dokter.karyawan_id)
								left join vu_karyawan as terapis on (tindakan_detail.dtrawat_petugas2=terapis.karyawan_id)
								left join vu_karyawan as referal on (detail_jual_rawat.drawat_sales=referal.karyawan_id)
							WHERE (detail_jual_rawat.drawat_sales = '".$terapis_id."' or tindakan_detail.dtrawat_petugas2 = '".$terapis_id."') and 
								".$isiperiode." (rawat_id is not null and jrawat_stat_dok='Tertutup')
							group by karyawan_username, rawat_nama";
		
				}
				
				else if ($lapjum_groupby == 'Pengambilan_Paket')
				{
				$query ="select ifnull(if((tindakan_detail.dtrawat_petugas1 = 0),if((tindakan_detail.dtrawat_petugas2 = 0),NULL,terapis.karyawan_username),dokter.karyawan_username),referal.karyawan_username) AS karyawan_username,
								perawatan.rawat_nama, perawatan.rawat_kredit, perawatan.rawat_kode,'paket' as status,
								sum(detail_ambil_paket.dapaket_jumlah) as Jumlah_rawat,
								perawatan.rawat_kredit * sum(detail_ambil_paket.dapaket_jumlah) as Total_kredit,
								detail_ambil_paket.dapaket_tgl_ambil as tanggal,
								perawatan.rawat_id as perawatan_id,
								detail_ambil_paket.dapaket_stat_dok as stat_dok
							from detail_ambil_paket
								left join perawatan on (perawatan.rawat_id=detail_ambil_paket.dapaket_item)
								left join tindakan_detail on (tindakan_detail.dtrawat_id=detail_ambil_paket.dapaket_dtrawat)
								left join vu_karyawan as dokter on (tindakan_detail.dtrawat_petugas1=dokter.karyawan_id)
								left join vu_karyawan as terapis on (tindakan_detail.dtrawat_petugas2=terapis.karyawan_id)
								left join vu_karyawan as referal on (detail_ambil_paket.dapaket_referal=referal.karyawan_id)
								left join master_jual_paket on (master_jual_paket.jpaket_id = detail_ambil_paket.dapaket_jpaket)
							WHERE  (detail_ambil_paket.dapaket_referal = '".$terapis_id."' or tindakan_detail.dtrawat_petugas2 = '".$terapis_id."') and 
								".$tglpaket." (dapaket_item is not null and dapaket_stat_dok='Tertutup') and master_jual_paket.jpaket_stat_dok = 'Tertutup'
								group by karyawan_username, rawat_nama";
				}
			
			
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
			return $result;
		}
		
	//function  for export to excel
	function lap_jum_tindakan_terapis_export_excel($tgl_awal,$periode,$lapjum_id ,$terapis_id , $lapjum_tglapp_start, $lapjum_tglapp_end,
													$lapjum_groupby, $option,$filter){
			//full query
			
			if ($periode == 'bulan'){
				$isiperiode=" (date_format(jrawat_tanggal,'%Y-%m')='".$tgl_awal."') and " ;
				$tglpaket=" (date_format(dapaket_tgl_ambil,'%Y-%m')='".$tgl_awal."') and " ;
			}else if($periode == 'tanggal'){
				$isiperiode=" (jrawat_tanggal BETWEEN '".$lapjum_tglapp_start."' AND '".$lapjum_tglapp_end."') 
							and ";
				$tglpaket=" (dapaket_tgl_ambil BETWEEN '".$lapjum_tglapp_start."' AND '".$lapjum_tglapp_end."') 
							and " ;
			}
			
			if ($lapjum_groupby == 'Semua')
			{
			$query ="select rawat_kode as Kode, rawat_nama as Perawatan, sum(Jumlah_rawat) as Jumlah ,rawat_kredit as Kredit_Point,sum(Total_kredit) as Tot_kredit_Point
					from
						(
						(select ifnull(if((tindakan_detail.dtrawat_petugas1 = 0),if((tindakan_detail.dtrawat_petugas2 = 0),NULL,terapis.karyawan_username),dokter.karyawan_username),referal.karyawan_username) AS karyawan_username,
							perawatan.rawat_nama, perawatan.rawat_kredit, perawatan.rawat_kode,'paket' as status,
							sum(detail_ambil_paket.dapaket_jumlah) as Jumlah_rawat,
							perawatan.rawat_kredit * sum(detail_ambil_paket.dapaket_jumlah) as Total_kredit
						from detail_ambil_paket
							left join perawatan on (perawatan.rawat_id=detail_ambil_paket.dapaket_item)
							left join tindakan_detail on (tindakan_detail.dtrawat_id=detail_ambil_paket.dapaket_dtrawat)
							left join vu_karyawan as dokter on (tindakan_detail.dtrawat_petugas1=dokter.karyawan_id)
							left join vu_karyawan as terapis on (tindakan_detail.dtrawat_petugas2=terapis.karyawan_id)
							left join vu_karyawan as referal on (detail_ambil_paket.dapaket_referal=referal.karyawan_id)
							left join master_jual_paket on (master_jual_paket.jpaket_id = detail_ambil_paket.dapaket_jpaket)
						WHERE  (detail_ambil_paket.dapaket_referal = '".$terapis_id."' or tindakan_detail.dtrawat_petugas2 = '".$terapis_id."'
						 or tindakan_detail.dtrawat_petugas1 = '".$terapis_id."') and 
							".$tglpaket." (dapaket_item is not null and dapaket_stat_dok='Tertutup') and master_jual_paket.jpaket_stat_dok = 'Tertutup'
							group by karyawan_username, rawat_nama
						)
						union
						(select ifnull(if((tindakan_detail.dtrawat_petugas1 = 0),if((tindakan_detail.dtrawat_petugas2 = 0),NULL,terapis.karyawan_username),dokter.karyawan_username),referal.karyawan_username) AS karyawan_username,
							perawatan.rawat_nama, perawatan.rawat_kredit, perawatan.rawat_kode,'satuan' as status,
							sum(detail_jual_rawat.drawat_jumlah) as Jumlah_rawat,
							perawatan.rawat_kredit * sum(detail_jual_rawat.drawat_jumlah) as Total_kredit
						from detail_jual_rawat
							left join master_jual_rawat on (master_jual_rawat.jrawat_id=detail_jual_rawat.drawat_master)
							left join perawatan on (perawatan.rawat_id=detail_jual_rawat.drawat_rawat)
							left join tindakan_detail on (tindakan_detail.dtrawat_id=detail_jual_rawat.drawat_dtrawat)
							left join vu_karyawan as dokter on (tindakan_detail.dtrawat_petugas1=dokter.karyawan_id)
							left join vu_karyawan as terapis on (tindakan_detail.dtrawat_petugas2=terapis.karyawan_id)
							left join vu_karyawan as referal on (detail_jual_rawat.drawat_sales=referal.karyawan_id)
						WHERE (detail_jual_rawat.drawat_sales = '".$terapis_id."' or tindakan_detail.dtrawat_petugas2 = '".$terapis_id."'
						 or tindakan_detail.dtrawat_petugas1 = '".$terapis_id."') and 
							".$isiperiode." (rawat_id is not null and jrawat_stat_dok='Tertutup')
						group by karyawan_username, rawat_nama)
						)
					as tabel_union
					group by rawat_nama";
			}
				

			else if ($lapjum_groupby == 'Perawatan')
			{
			$query ="select perawatan.rawat_kode as Kode, perawatan.rawat_nama as Perawatan, sum(detail_jual_rawat.drawat_jumlah) as Jml, perawatan.rawat_kredit as Kredit_Poin , 
							perawatan.rawat_kredit * sum(detail_jual_rawat.drawat_jumlah) as Tot_Kredit_Poin
						from detail_jual_rawat
							left join master_jual_rawat on (master_jual_rawat.jrawat_id=detail_jual_rawat.drawat_master)
							left join perawatan on (perawatan.rawat_id=detail_jual_rawat.drawat_rawat)
							left join tindakan_detail on (tindakan_detail.dtrawat_id=detail_jual_rawat.drawat_dtrawat)
							left join vu_karyawan as dokter on (tindakan_detail.dtrawat_petugas1=dokter.karyawan_id)
							left join vu_karyawan as terapis on (tindakan_detail.dtrawat_petugas2=terapis.karyawan_id)
							left join vu_karyawan as referal on (detail_jual_rawat.drawat_sales=referal.karyawan_id)
						WHERE (detail_jual_rawat.drawat_sales = '".$terapis_id."' or tindakan_detail.dtrawat_petugas2 = '".$terapis_id."') and 
							".$isiperiode." (rawat_id is not null and jrawat_stat_dok='Tertutup')
						group by rawat_nama";
	
			}
			
			else if ($lapjum_groupby == 'Pengambilan_Paket')
			{
			$query ="select
							perawatan.rawat_kode as Kode, perawatan.rawat_nama as Perawatan, sum(detail_ambil_paket.dapaket_jumlah) as Jml,perawatan.rawat_kredit as Kredit_Poin, 
							perawatan.rawat_kredit * sum(detail_ambil_paket.dapaket_jumlah) as Tot_kredit_Poin
						from detail_ambil_paket
							left join perawatan on (perawatan.rawat_id=detail_ambil_paket.dapaket_item)
							left join tindakan_detail on (tindakan_detail.dtrawat_id=detail_ambil_paket.dapaket_dtrawat)
							left join vu_karyawan as dokter on (tindakan_detail.dtrawat_petugas1=dokter.karyawan_id)
							left join vu_karyawan as terapis on (tindakan_detail.dtrawat_petugas2=terapis.karyawan_id)
							left join vu_karyawan as referal on (detail_ambil_paket.dapaket_referal=referal.karyawan_id)
							left join master_jual_paket on (master_jual_paket.jpaket_id = detail_ambil_paket.dapaket_jpaket)
						WHERE  (detail_ambil_paket.dapaket_referal = '".$terapis_id."' or tindakan_detail.dtrawat_petugas2 = '".$terapis_id."') and 
							".$tglpaket." (dapaket_item is not null and dapaket_stat_dok='Tertutup') and master_jual_paket.jpaket_stat_dok = 'Tertutup'
							group by rawat_nama";
			}
			
			$result = $this->db->query($query);
			return $result;
		}
		
}
?>