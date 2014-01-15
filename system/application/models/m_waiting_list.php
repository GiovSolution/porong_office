<? /* 		
	+ Module  		: Waiting List Model
	+ Description	: For record view
	+ Filename 		: m_waiting_list.php
 	+ Author  		: Fred
	
*/

class M_waiting_list extends Model{
		
	//constructor
	function M_waiting_list() {
		parent::Model();
	}
	
	function get_dokter_list($query, $tgl_app, $karyawan_jabatan){
		$date_now=date('Y-m-d');
		$bln_now=date('Y-m');
		if($tgl_app==""){
			$tgl_app=$date_now;
			$bln_filter=$bln_now;
		}elseif($tgl_app!=""){
			$bln_filter=date('Y-m', strtotime($tgl_app));
		}
		//$sql="SELECT karyawan_id,karyawan_no,karyawan_nama,karyawan_username,reportt_jmltindakan FROM vu_karyawan INNER JOIN jabatan ON(karyawan_jabatan=jabatan_id) LEFT JOIN (SELECT * FROM report_tindakan WHERE reportt_bln LIKE '$bln_now%') as rt ON(karyawan_id=rt.reportt_karyawan_id) WHERE karyawan_jabatan=jabatan_id AND jabatan_nama='$karyawan_jabatan' AND karyawan_aktif='Aktif'";
		$sql=  "SELECT 
					karyawan_id,karyawan_no,karyawan_nama,karyawan_username,vu_report_tindakan_dokter.dokter_count 
				FROM vu_karyawan 
				INNER JOIN jabatan ON(karyawan_jabatan=jabatan_id) 
				LEFT JOIN vu_report_tindakan_dokter ON(vu_report_tindakan_dokter.dokter_id=vu_karyawan.karyawan_id AND
					vu_report_tindakan_dokter.dokter_bulan='$bln_filter') 
					left join cabang on(vu_karyawan.karyawan_cabang=cabang.cabang_value)
				WHERE karyawan_jabatan=jabatan_id AND jabatan_nama='$karyawan_jabatan' AND karyawan_aktif='Aktif'
					AND(karyawan_cabang = (SELECT info_cabang FROM info limit 1) 
					OR substring(karyawan_cabang2,
					(select cabang_value 
						from cabang
						left join info on (cabang.cabang_id = info.info_cabang)
						where info.info_cabang = cabang.cabang_id)
					,1) = '1')";
		if($query<>""){
			$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
			$sql .= " (karyawan_nama LIKE '%".addslashes($query)."%')";
		}
		/*if($tgl_app<>""){
			$tgl_app = date('Y-m-d', strtotime($tgl_app));
			$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
			$sql .= " (absensi_tgl='".addslashes($tgl_app)."')";
		}*/
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
	
	function get_terapis_list($query, $tgl_app, $karyawan_jabatan){
		$sql="select karyawan_id,karyawan_no,karyawan_nama,karyawan_username,jabatan_nama 
				from vu_karyawan,jabatan 
				where 	jabatan_id=karyawan_jabatan and 
						karyawan_aktif='Aktif' and 
						karyawan_jabatan='7' and
						(karyawan_cabang = (SELECT info_cabang FROM info limit 1)
					OR substring(karyawan_cabang2,
					(select cabang_value 
						from cabang
						left join info on (cabang.cabang_id = info.info_cabang)
						where info.info_cabang = cabang.cabang_id),1) = '1')";
		if($query!=="")
			$sql.=" and (karyawan_id like '%".$query."%' or karyawan_no like '%".$query."%' or karyawan_nama like '%".$query."%'
						 or jabatan_nama like '%".$query."%')";
	
		$result = $this->db->query($sql);
		$nbrows = $result->num_rows();
		//$limit = $sql." LIMIT ".$start.",".$end;			
		//$result = $this->db->query($limit); 
		if($nbrows>0){
			foreach($result->result() as $row){
				$arr[] = $row;
			}
			$jsonresult = json_encode($arr);
			return '({"total":"'.$nbrows.'","results":'.$jsonresult.'})';
		} else {
			return '({"total":"0", "results":""})';
		}
		
		/*
		$this->db->where('absensi_shift',"");
		$this->db->delete('absensi');
		$date_now=date('Y-m-d');
		$bln_now=date('Y-m');
		if($tgl_app==""){
			$tgl_app=$date_now;
			$bln_filter=$bln_now;
		}elseif($tgl_app!=""){
			$bln_filter=date('Y-m', strtotime($tgl_app));
		}
		
		/* Mencari Terapis yang sudah memiliki Jadwal di db.absensi WHERE db.absensi.absensi_shift = 'P' */
		//$sql="SELECT karyawan_id,karyawan_no,karyawan_nama,karyawan_username,reportt_jmltindakan,ab.absensi_shift FROM vu_karyawan INNER JOIN jabatan ON(karyawan_jabatan=jabatan_id) INNER JOIN (SELECT absensi_karyawan_id,absensi_tgl,absensi_shift FROM absensi WHERE absensi_shift='P') as ab ON(vu_karyawan.karyawan_id=ab.absensi_karyawan_id) LEFT JOIN (SELECT * FROM report_tindakan WHERE date_format(reportt_bln,'%Y-%m')='$bln_filter') as rt ON(karyawan_id=rt.reportt_karyawan_id) WHERE karyawan_jabatan=jabatan_id AND jabatan_nama='$karyawan_jabatan' AND karyawan_aktif='Aktif'";
		/*
		$sql=  "SELECT 
					vu_karyawan.karyawan_id,karyawan_no,karyawan_nama,karyawan_username,
					vu_report_tindakan_terapis.terapis_count+tindakan_adjust.adj_count as new_count,ab.absensi_shift 
				FROM vu_karyawan 
				INNER JOIN jabatan ON(karyawan_jabatan=jabatan_id) 
				INNER JOIN 
					(SELECT absensi_karyawan_id,absensi_tgl,absensi_shift 
					 FROM absensi WHERE absensi_shift='P') as ab 
					 ON (vu_karyawan.karyawan_id=ab.absensi_karyawan_id) 
				LEFT JOIN vu_report_tindakan_terapis ON
					(vu_karyawan.karyawan_id=vu_report_tindakan_terapis.terapis_id AND
					 vu_report_tindakan_terapis.terapis_bulan='$bln_filter') 
				LEFT JOIN tindakan_adjust on 
					(tindakan_adjust.karyawan_id=vu_report_tindakan_terapis.terapis_id and
					 date_format(tindakan_adjust.adj_bln,'%Y-%m')=vu_report_tindakan_terapis.terapis_bulan) 
				WHERE karyawan_jabatan=jabatan_id AND jabatan_nama='$karyawan_jabatan' AND karyawan_aktif='Aktif'
					AND karyawan_cabang = (SELECT info_cabang FROM info limit 1)";
		if($query<>"" && is_numeric($query)==false){
			$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
			$sql .= " (karyawan_nama LIKE '%".addslashes($query)."%')";
		}
		if($tgl_app<>""){ /* Query pada $sql akan di AND ab.absensi_tgl=$tgl_app Jika $tgl_app<>'' */
		/*
		$tgl_app = date('Y-m-d', strtotime($tgl_app));
			$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
			$sql .= " (ab.absensi_tgl='".addslashes($tgl_app)."')";
		}
		$sql.=" ORDER BY vu_report_tindakan_terapis.terapis_count ASC";
		
		$sql2= "SELECT 
					vu_karyawan.karyawan_id,karyawan_no,karyawan_nama,karyawan_username,
					vu_report_tindakan_terapis.terapis_count+tindakan_adjust.adj_count as new_count,ab.absensi_shift 
				FROM vu_karyawan 
				INNER JOIN jabatan ON(karyawan_jabatan=jabatan_id) 
				INNER JOIN 
				   (SELECT absensi_karyawan_id,absensi_tgl,absensi_shift 
					FROM absensi WHERE absensi_shift='S') as ab 
					ON(vu_karyawan.karyawan_id=ab.absensi_karyawan_id) 
				LEFT JOIN vu_report_tindakan_terapis ON
					(vu_karyawan.karyawan_id=vu_report_tindakan_terapis.terapis_id AND 
					 vu_report_tindakan_terapis.terapis_bulan='$bln_filter') 
				LEFT JOIN tindakan_adjust on 
					(tindakan_adjust.karyawan_id=vu_report_tindakan_terapis.terapis_id and
					 date_format(tindakan_adjust.adj_bln,'%Y-%m')=vu_report_tindakan_terapis.terapis_bulan) 
				WHERE karyawan_jabatan=jabatan_id AND jabatan_nama='$karyawan_jabatan' AND karyawan_aktif='Aktif'
					AND karyawan_cabang = (SELECT info_cabang FROM info limit 1)";
		if($query<>"" && is_numeric($query)==false){
			$sql2 .=eregi("WHERE",$sql2)? " AND ":" WHERE ";
			$sql2 .= " (karyawan_nama LIKE '%".addslashes($query)."%')";
		}
		if($tgl_app<>""){
			$tgl_app = date('Y-m-d', strtotime($tgl_app));
			$sql2 .=eregi("WHERE",$sql2)? " AND ":" WHERE ";
			$sql2 .= " (ab.absensi_tgl='".addslashes($tgl_app)."')";
		}
		$sql2.=" ORDER BY vu_report_tindakan_terapis.terapis_count ASC";
		
		$sql3= "SELECT vu_karyawan.karyawan_id,karyawan_no,karyawan_nama,karyawan_username,vu_report_tindakan_terapis.terapis_count+tindakan_adjust.adj_count as new_count,ab.absensi_shift 
				FROM vu_karyawan 
				INNER JOIN jabatan ON(karyawan_jabatan=jabatan_id) 
				INNER JOIN (SELECT absensi_karyawan_id,absensi_tgl,absensi_shift FROM absensi WHERE absensi_shift='M') as ab ON(vu_karyawan.karyawan_id=ab.absensi_karyawan_id) 
				LEFT JOIN vu_report_tindakan_terapis ON(vu_karyawan.karyawan_id=vu_report_tindakan_terapis.terapis_id AND vu_report_tindakan_terapis.terapis_bulan='$bln_filter') 
				LEFT JOIN tindakan_adjust on (tindakan_adjust.karyawan_id=vu_report_tindakan_terapis.terapis_id and date_format(tindakan_adjust.adj_bln,'%Y-%m')=vu_report_tindakan_terapis.terapis_bulan) 
				WHERE karyawan_jabatan=jabatan_id AND jabatan_nama='$karyawan_jabatan' AND karyawan_aktif='Aktif'
					AND karyawan_cabang = (SELECT info_cabang FROM info limit 1)";
		if($query<>"" && is_numeric($query)==false){
			$sql3 .=eregi("WHERE",$sql3)? " AND ":" WHERE ";
			$sql3 .= " (karyawan_nama LIKE '%".addslashes($query)."%')";
		}
		if($tgl_app<>""){
			$tgl_app = date('Y-m-d', strtotime($tgl_app));
			$sql3 .=eregi("WHERE",$sql3)? " AND ":" WHERE ";
			$sql3 .= " (ab.absensi_tgl='".addslashes($tgl_app)."')";
		}
		$sql3.=" ORDER BY vu_report_tindakan_terapis.terapis_count ASC";
		
		$sql4=" SELECT vu_karyawan.karyawan_id,karyawan_no,karyawan_nama,karyawan_username,vu_report_tindakan_terapis.terapis_count+tindakan_adjust.adj_count as new_count,ab.absensi_shift FROM vu_karyawan INNER JOIN jabatan ON(karyawan_jabatan=jabatan_id) INNER JOIN (SELECT absensi_karyawan_id,absensi_tgl,absensi_shift FROM absensi WHERE absensi_shift='OFF') as ab ON(vu_karyawan.karyawan_id=ab.absensi_karyawan_id) LEFT JOIN vu_report_tindakan_terapis ON(vu_karyawan.karyawan_id=vu_report_tindakan_terapis.terapis_id AND vu_report_tindakan_terapis.terapis_bulan='$bln_filter') LEFT JOIN tindakan_adjust on (tindakan_adjust.karyawan_id=vu_report_tindakan_terapis.terapis_id and date_format(tindakan_adjust.adj_bln,'%Y-%m')=vu_report_tindakan_terapis.terapis_bulan) 
				WHERE karyawan_jabatan=jabatan_id AND jabatan_nama='$karyawan_jabatan' AND karyawan_aktif='Aktif'
					AND karyawan_cabang = (SELECT info_cabang FROM info limit 1)";
		if($query<>"" && is_numeric($query)==false){
			$sql4 .=eregi("WHERE",$sql4)? " AND ":" WHERE ";
			$sql4 .= " (karyawan_nama LIKE '%".addslashes($query)."%')";
		}
		if($tgl_app<>""){
			$tgl_app = date('Y-m-d', strtotime($tgl_app));
			$sql4 .=eregi("WHERE",$sql4)? " AND ":" WHERE ";
			$sql4 .= " (ab.absensi_tgl='".addslashes($tgl_app)."')";
		}
		$sql4.=" ORDER BY vu_report_tindakan_terapis.terapis_count ASC";
		
		$sql5= "SELECT vu_karyawan.karyawan_id,karyawan_no,karyawan_nama,karyawan_username,vu_report_tindakan_terapis.terapis_count+tindakan_adjust.adj_count as new_count,ab.absensi_shift FROM vu_karyawan INNER JOIN jabatan ON(karyawan_jabatan=jabatan_id) INNER JOIN (SELECT absensi_karyawan_id,absensi_tgl,absensi_shift FROM absensi WHERE absensi_shift='CT') as ab ON(vu_karyawan.karyawan_id=ab.absensi_karyawan_id) LEFT JOIN vu_report_tindakan_terapis ON(vu_karyawan.karyawan_id=vu_report_tindakan_terapis.terapis_id AND vu_report_tindakan_terapis.terapis_bulan='$bln_filter') LEFT JOIN tindakan_adjust on (tindakan_adjust.karyawan_id=vu_report_tindakan_terapis.terapis_id and date_format(tindakan_adjust.adj_bln,'%Y-%m')=vu_report_tindakan_terapis.terapis_bulan) 
				WHERE karyawan_jabatan=jabatan_id AND jabatan_nama='$karyawan_jabatan' AND karyawan_aktif='Aktif'
					AND karyawan_cabang = (SELECT info_cabang FROM info limit 1)";
		if($query<>"" && is_numeric($query)==false){
			$sql5 .=eregi("WHERE",$sql5)? " AND ":" WHERE ";
			$sql5 .= " (karyawan_nama LIKE '%".addslashes($query)."%')";
		}
		if($tgl_app<>""){
			$tgl_app = date('Y-m-d', strtotime($tgl_app));
			$sql5 .=eregi("WHERE",$sql5)? " AND ":" WHERE ";
			$sql5 .= " (ab.absensi_tgl='".addslashes($tgl_app)."')";
		}
		$sql5.=" ORDER BY vu_report_tindakan_terapis.terapis_count ASC";
		
		$sql6= "SELECT vu_karyawan.karyawan_id,karyawan_no,karyawan_nama,karyawan_username,vu_report_tindakan_terapis.terapis_count+tindakan_adjust.adj_count as new_count,ab.absensi_shift FROM vu_karyawan INNER JOIN jabatan ON(karyawan_jabatan=jabatan_id) INNER JOIN (SELECT absensi_karyawan_id,absensi_tgl,absensi_shift FROM absensi WHERE absensi_shift='H') as ab ON(vu_karyawan.karyawan_id=ab.absensi_karyawan_id) LEFT JOIN vu_report_tindakan_terapis ON(vu_karyawan.karyawan_id=vu_report_tindakan_terapis.terapis_id AND vu_report_tindakan_terapis.terapis_bulan='$bln_filter') LEFT JOIN tindakan_adjust on (tindakan_adjust.karyawan_id=vu_report_tindakan_terapis.terapis_id and date_format(tindakan_adjust.adj_bln,'%Y-%m')=vu_report_tindakan_terapis.terapis_bulan) 
				WHERE karyawan_jabatan=jabatan_id AND jabatan_nama='$karyawan_jabatan' AND karyawan_aktif='Aktif'
					AND karyawan_cabang = (SELECT info_cabang FROM info limit 1)";
		if($query<>"" && is_numeric($query)==false){
			$sql6 .=eregi("WHERE",$sql6)? " AND ":" WHERE ";
			$sql6 .= " (karyawan_nama LIKE '%".addslashes($query)."%')";
		}
		if($tgl_app<>""){
			$tgl_app = date('Y-m-d', strtotime($tgl_app));
			$sql6 .=eregi("WHERE",$sql6)? " AND ":" WHERE ";
			$sql6 .= " (ab.absensi_tgl='".addslashes($tgl_app)."')";
		}
		$sql6.=" ORDER BY vu_report_tindakan_terapis.terapis_count ASC";
		
		
		$query = $this->db->query($sql);
		$nbrows = $query->num_rows();
		
		$query2 = $this->db->query($sql2);
		$nbrows2 = $query2->num_rows();
		
		$query3 = $this->db->query($sql3);
		$nbrows3 = $query3->num_rows();
		
		$query4 = $this->db->query($sql4);
		$nbrows4 = $query4->num_rows();
		
		$query5 = $this->db->query($sql5);
		$nbrows5 = $query5->num_rows();
		
		$query6 = $this->db->query($sql6);
		$nbrows6 = $query6->num_rows();
		
		$nbrows7=0;
		if($nbrows==0 && $nbrows2==0 && $nbrows3==0 && $nbrows4==0){
			//$sql7="SELECT karyawan_id,karyawan_no,karyawan_nama,karyawan_username,reportt_jmltindakan,ab.absensi_shift FROM vu_karyawan INNER JOIN jabatan ON(karyawan_jabatan=jabatan_id) LEFT JOIN (SELECT absensi_karyawan_id,absensi_tgl,absensi_shift FROM absensi WHERE date_format(absensi_tgl,'%Y-%m')='$bln_filter') as ab ON(vu_karyawan.karyawan_id=ab.absensi_karyawan_id) LEFT JOIN (SELECT * FROM report_tindakan WHERE date_format(reportt_bln,'%Y-%m')='$bln_filter') as rt ON(karyawan_id=rt.reportt_karyawan_id) WHERE karyawan_jabatan=jabatan_id AND jabatan_nama='$karyawan_jabatan' AND karyawan_aktif='Aktif' ORDER BY reportt_jmltindakan ASC";
			$sql7= "SELECT 
						vu_karyawan.karyawan_id,karyawan_no,karyawan_nama,karyawan_username,
						vu_report_tindakan_terapis.terapis_count+tindakan_adjust.adj_count as new_count,ab.absensi_shift 
					FROM vu_karyawan 
					INNER JOIN jabatan ON(karyawan_jabatan=jabatan_id) 
					LEFT JOIN 
						(SELECT absensi_karyawan_id,absensi_tgl,absensi_shift 
						 FROM absensi WHERE date_format(absensi_tgl,'%Y-%m')='$bln_filter') as ab 
						 ON(vu_karyawan.karyawan_id=ab.absensi_karyawan_id) 
					LEFT JOIN vu_report_tindakan_terapis ON
						(vu_karyawan.karyawan_id=vu_report_tindakan_terapis.terapis_id AND 
						vu_report_tindakan_terapis.terapis_bulan='$bln_filter') 
					LEFT JOIN tindakan_adjust on 
						(tindakan_adjust.karyawan_id=vu_report_tindakan_terapis.terapis_id and
						date_format(tindakan_adjust.adj_bln,'%Y-%m')=vu_report_tindakan_terapis.terapis_bulan) 
					WHERE karyawan_jabatan=jabatan_id AND jabatan_nama='$karyawan_jabatan' 
						AND karyawan_aktif='Aktif' 
						AND karyawan_cabang = (SELECT info_cabang FROM info limit 1)
					ORDER BY vu_report_tindakan_terapis.terapis_count ASC";
			/*if($query<>"" && is_numeric($query)==false){
				$sql5 .=eregi("WHERE",$sql5)? " AND ":" WHERE ";
				$sql5 .= " (karyawan_nama LIKE '%".addslashes($query)."%')";
			}*/
		/*
			$query7 = $this->db->query($sql7);
			$nbrows7 = $query7->num_rows();
		}
		
		if($nbrows>0 || $nbrows2>0 || $nbrows3>0 || $nbrows4>0 || $nbrows5>0 || $nbrows6>0 || $nbrows7>0){
			if($nbrows>0){
				foreach($query->result() as $row){
					$arr[] = $row;
				}
			}
			if($nbrows2>0){
				foreach($query2->result() as $row2){
					$arr[] = $row2;
				}
			}
			if($nbrows3>0){
				foreach($query3->result() as $row3){
					$arr[] = $row3;
				}
			}
			if($nbrows4>0){
				foreach($query4->result() as $row4){
					$arr[] = $row4;
				}
			}
			if($nbrows5>0){
				foreach($query5->result() as $row5){
					$arr[] = $row5;
				}
			}
			if($nbrows6>0){
				foreach($query6->result() as $row6){
					$arr[] = $row6;
				}
			}
			if($nbrows7>0){
				foreach($query7->result() as $row7){
					$arr[] = $row7;
				}
			}
			$nbrows=$nbrows+$nbrows2+$nbrows3+$nbrows4+$nbrows5+$nbrows6+$nbrows7;
			$jsonresult = json_encode($arr);
			return '({"total":"'.$nbrows.'","results":'.$jsonresult.'})';
		} else {
			return '({"total":"0", "results":""})';
		}
		*/
	}
	
	
	//get master id, note : not done yet
	function get_master_id() {
		$query = "SELECT max(app_id) AS master_id FROM appointment WHERE app_creator='".@$_SESSION[SESSION_USERID]."'";
		$result = $this->db->query($query);
		if($result->num_rows()){
			$data=$result->row();
			$master_id=$data->master_id;
			return $master_id;
		}else{
			return '0';
		}
	}
	//eof

	
	function counter_report_tindakan_karyawan($karyawan_id, $dapp_tglreservasi){
		/* karyawan === Dokter / Terapis
		 * UPDATE/INSERT ke db.report_tindakan karena $dapp_status=='datang'
		 * 1. Check $karyawan_id apakah sudah ada di db.report_tindakan
		 * 2. Jika ADA ==> UPDATE db.report_tindakan.reportt_jmltindakan
		 * 3. Jika TIDAK ADA ==> INSERT ke db.report_tindakan
		*/
		$date_now = date('Y-m-d');
		$bln_now = date('Y-m',strtotime($dapp_tglreservasi));
		
		$sql="SELECT reportt_id
				,reportt_jmltindakan
			FROM report_tindakan
			WHERE reportt_bln LIKE '$bln_now%'
				AND reportt_karyawan_id='$karyawan_id'";
		$rs=$this->db->query($sql);
		if($rs->num_rows()){
			//UPDATE report tindakan untuk $karyawan_id
			$rs_record=$rs->row_array();
			$reportt_jmltindakan = $rs_record['reportt_jmltindakan'];
			$reportt_jmltindakan_update = $reportt_jmltindakan + 1;
			$reportt_id = $rs_record['reportt_id'];
			
			$data_reportt=array(
			"reportt_jmltindakan"=>$reportt_jmltindakan_update
			);
			$this->db->where('reportt_karyawan_id', $karyawan_id);
			$this->db->where('reportt_id', $reportt_id);
			$this->db->update('report_tindakan', $data_reportt);
			if($this->db->affected_rows()>-1){
				return 1;
			}else{
				return 0;
			}
		}else{
			//report tindakan baru di bulan ini untuk $karyawan_id
			$data_reportt=array(
			"reportt_karyawan_id"=>$karyawan_id,
			"reportt_bln"=>$date_now,
			"reportt_jmltindakan"=>1
			);
			$this->db->insert('report_tindakan', $data_reportt);
			if($this->db->affected_rows()){
				return 1;
			}else{
				return '0';
			}
		}
	}
	
	function decounter_report_tindakan_karyawan($karyawan_id, $dapp_tglreservasi){
		/* karyawan === Dokter / Terapis
		 * UPDATE/INSERT ke db.report_tindakan karena $dapp_status=='datang'
		 * 1. Check $dokter_id apakah sudah ada di db.report_tindakan
		 * 2. Jika ADA ==> UPDATE db.report_tindakan.reportt_jmltindakan
		 * 3. Jika TIDAK ADA ==> INSERT ke db.report_tindakan
		*/
		$date_now = date('Y-m-d');
		$bln_now = date('Y-m',strtotime($dapp_tglreservasi));
		
		$sql = "UPDATE report_tindakan
			SET reportt_jmltindakan = (reportt_jmltindakan-1)
			WHERE reportt_bln LIKE '".$bln_now."%'
				AND reportt_karyawan_id='".$karyawan_id."'";
		$this->db->query($sql);
		if($this->db->affected_rows()){
			return 1;
		}else{
			return 1;
		}
	}
	
	function report_tindakan_update($karyawan_id_awal, $karyawan_id_pengganti, $dapp_tglreservasi){
		//$karyawan_id_awal ==> decounter
		$result_awal = $this->decounter_report_tindakan_karyawan($karyawan_id_awal, $dapp_tglreservasi);
		
		if($result_awal==1){
			//$karyawan_id_pengganti ==> counter
			$result_pengganti = $this->counter_report_tindakan_karyawan($karyawan_id_pengganti, $dapp_tglreservasi);
			if($result_pengganti==1){
				return 1;
			}else{
				return 0;
			}
		}else{
			return 0;
		}
	}
	
	
	//function for get list record
	function waiting_list_list($filter,$start,$end,$tgl_app,$jenis_rawat,$karyawan_id){
		if($jenis_rawat=="")
			$jenis_rawat="Medis";
		//$query = "SELECT * FROM appointment";
		$dt=date('Y-m-d');
		$dt_six=date('Y-m-d',mktime(0,0,0,date("m"),date("d")+6,date("Y")));
		$query="select waiting_list.*,vu_karyawan.karyawan_username,customer.cust_nama,customer.cust_no,perawatan.rawat_nama 
					from waiting_list,vu_karyawan,customer,perawatan 
					where waiting_list.cust_id=customer.cust_id and waiting_list.rawat_id=perawatan.rawat_id and waiting_list.karyawan_id=vu_karyawan.karyawan_id
					order by waiting_list.wl_date desc,waiting_list.wl_status='Waiting List' desc,waiting_list.wl_status='Appointment' desc,waiting_list.karyawan_id,waiting_list.wl_priority";

		// For Pilihan Dokter pada tbar
		if ($karyawan_id<>"" && is_numeric($karyawan_id)==true){
			if($tgl_app!=""){
				$dt=date('Y-m-d', strtotime($tgl_app));
				$query="select waiting_list.*,vu_karyawan.karyawan_username,customer.cust_nama,customer.cust_no,perawatan.rawat_nama 
					from waiting_list,vu_karyawan,customer,perawatan 
					where waiting_list.cust_id=customer.cust_id and waiting_list.rawat_id=perawatan.rawat_id and waiting_list.karyawan_id=vu_karyawan.karyawan_id 
						and vu_karyawan.karyawan_id = '$karyawan_id' and waiting_list.wl_date = '$dt'
						order by waiting_list.wl_date desc,waiting_list.wl_status='Waiting List' desc,waiting_list.wl_status='Appointment' desc,waiting_list.karyawan_id,waiting_list.wl_priority";
			}else{
				$query="select waiting_list.*,vu_karyawan.karyawan_username,customer.cust_nama,customer.cust_no,perawatan.rawat_nama 
					from waiting_list,vu_karyawan,customer,perawatan 
					where waiting_list.cust_id=customer.cust_id and waiting_list.rawat_id=perawatan.rawat_id and waiting_list.karyawan_id=vu_karyawan.karyawan_id 
						and vu_karyawan.karyawan_id = '$karyawan_id'
						order by waiting_list.wl_date desc,waiting_list.wl_status='Waiting List' desc,waiting_list.wl_status='Appointment' desc,waiting_list.karyawan_id,waiting_list.wl_priority";
			}

		}
		
		// For Pilihan Tanggal Appointment di tbar dengan pilihan dokter kosong
		if($karyawan_id=="" && is_numeric($karyawan_id)==false && $tgl_app!=""){
			$dt=date('Y-m-d', strtotime($tgl_app));
			$query="select waiting_list.*,vu_karyawan.karyawan_username,customer.cust_nama,customer.cust_no,perawatan.rawat_nama 
					from waiting_list,vu_karyawan,customer,perawatan 
					where waiting_list.cust_id=customer.cust_id and waiting_list.rawat_id=perawatan.rawat_id and waiting_list.karyawan_id=vu_karyawan.karyawan_id 
					and waiting_list.wl_date = '$dt'
					order by waiting_list.wl_date desc,waiting_list.wl_status='Waiting List' desc,waiting_list.wl_status='Appointment' desc,waiting_list.karyawan_id,waiting_list.wl_priority";
		}
		
		/// For simple search
		 // Simple Search ==> untuk mencari data di hari ini saja
		//
		if($filter<>''){
			$query="select waiting_list.*,vu_karyawan.karyawan_username,customer.cust_nama,customer.cust_no,perawatan.rawat_nama 
					from waiting_list
					left join customer on (waiting_list.cust_id=customer.cust_id) 
					left join perawatan on (waiting_list.rawat_id=perawatan.rawat_id)
					left join vu_karyawan on (waiting_list.karyawan_id=vu_karyawan.karyawan_id)
					WHERE waiting_list.wl_date >= '".$dt."'";
			$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
			//search customer,perawatan,dokter,therapist
			$query .= " (karyawan_username LIKE '%".addslashes($filter)."%' OR cust_no LIKE '%".addslashes($filter)."%' OR cust_nama LIKE '%".addslashes($filter)."%' )";
			$query .= " order by waiting_list.wl_date desc,waiting_list.wl_status='Waiting List' desc,waiting_list.wl_status='Appointment' desc,waiting_list.karyawan_id,waiting_list.wl_priority";
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
	
	//function for update record
	function waiting_list_update($wl_id
								 ,$wl_customer
								 ,$karyawan_id
								 ,$rawat_id
								 ,$wl_tanggal
								 ,$wl_keterangan
								 ,$wl_user){
		$dt=date('Y-m-d H:i:s');
		$date_now=date('Y-m-d');
		$bln_now=date('Y-m');
		
		/* UPDATE ke db.appointment baik $dapp_status=='datang' atau $dapp_status!='datang'
		>> Checking di db.appointment, apakah ada Perubahan atau Tidak => jika Tidak maka Tidak Ada Updating */
		$sql="SELECT * FROM waiting_list WHERE wl_id='$wl_id'";
		$rs=$this->db->query($sql);
		if($rs->num_rows()){
			$rs_record=$rs->row_array();
			if($rs_record["wl_date"]!=$wl_tanggal || $rs_record["wl_keterangan"]!=$wl_keterangan){ /* JIKA terjadi PERUBAHAN */
				$data = array(
					"wl_date"=>$wl_tanggal,
					"wl_keterangan"=>$wl_keterangan,
					"wl_update"=>$wl_user,
					"wl_date_update"=>$dt,
					"wl_revised"=>$rs_record["wl_revised"]+1
				);
				$this->db->where('wl_id', $wl_id);
				$this->db->update('waiting_list', $data);
				if($this->db->affected_rows()){
					return '1';
				}else{
					return '1';
				}
			}else{
				return '1';
			}
		}else{
			return '1';
		}
	}
	
	function waiting_list_update_list($wl_id
									,$wl_date
									,$wl_keterangan
									,$wl_status
									,$wl_user){
		/* db.appointment_detail.dapp_status pasti !=='datang' ==> artinya belum dimasukkan ke db.tindakan+db.tindakan_detail
		 * maka yang diupdate hanya di db.appointment_detail
		*/
		$datetime_now = date('Y-m-d H:i:s');
		
		//Nilai Awal dari table db.appointment dan db.appointment_detail
		$sql = "SELECT *
			FROM waiting_list
			WHERE wl_id='".$wl_id."'";
		$rs = $this->db->query($sql);
		if($rs->num_rows()){
		$data = array(
		
				"wl_status"=>$wl_status,
				"wl_keterangan"=>$wl_keterangan,
				"wl_update"=>$wl_user
			);
			$this->db->where('wl_id', $wl_id);
			$this->db->update('waiting_list', $data);
		}
	
			if($this->db->affected_rows())
				return '1';
			else
				return '0';
		
	}
	
	
	function waiting_list_update_list_status($dapp_id, $dapp_status, $app_user){
		/* Edit LIST: dari status='datang' ==> status!='datang' || dari status!='datang' ==> status='datang'
		 * 1. JIKA = status='datang' ==> status!='datang', maka akan membatalkan db.tindakan_detail WHERE dtrawat_dapp=$dapp_id
		 * 2. JIKA = status!='datang' ==> status='datang', maka akan meng-INSERT-kan ke db.tindakan_detail dengan dtrawat_status='datang'
		*/
		$datetime_now = date('Y-m-d H:i:s');
		$date_now = date('Y-m-d');
		$time_now = date('H:i:s');
		
		$sql = "SELECT dapp_id
				,app_customer
				,rawat_id
				,kategori_nama
				,dokter_id
				,terapis_id
				,dapp_jamreservasi
				,dapp_tglreservasi
				,dapp_jambatal
				,dapp_jamkonfirmasi
				,dapp_keterangan
				,dapp_locked
				,dapp_status
				,dapp_counter
			FROM vu_appointment
			WHERE dapp_id='".$dapp_id."'";
		$rs = $this->db->query($sql);
		if($rs->num_rows()){
			$record = $rs->row_array();
			$dapp_status_awal = $record['dapp_status'];
			$dapp_locked = $record['dapp_locked'];
			$app_customer = $record['app_customer'];
			$dapp_perawatan = $record['rawat_id'];
			$kategori_nama = $record['kategori_nama'];
			$dokter_id = $record['dokter_id'];
			$terapis_id = $record['terapis_id'];
			$dapp_jamreservasi = $record['dapp_jamreservasi'];
			$dapp_tglreservasi = $record['dapp_tglreservasi'];
			$dapp_keterangan = $record['dapp_keterangan'];
			$dapp_counter = $record['dapp_counter'];
			
			
			if($dapp_locked==0){
				//Bisa di-Edit
				if(($dapp_status_awal<>$dapp_status) && $dapp_status_awal=='datang' && $dapp_status<>'datang'){
					//Edit LIST: dari status='datang' ==> status!='datang'
					/* 
					 * 1. Batalkan db.tindakan_detail WHERE dtrawat_dapp=$dapp_id
					 * 2. Jika sudah sukses ==> UPDATE db.appointment_detail.dapp_status!='datang'
					 * 3. DeCounter $dokter_id / $terapis_id
					*/
					$sqlu_dtrawat = "UPDATE tindakan_detail
						SET dtrawat_status='batal'
							,dtrawat_update='".@$_SESSION[SESSION_USERID]."'
							,dtrawat_date_update='".$datetime_now."'
							,dtrawat_revised=(dtrawat_revised+1)
						WHERE dtrawat_dapp='".$dapp_id."'";
					$this->db->query($sqlu_dtrawat);
					if($this->db->affected_rows()>-1){
						//UPDATE db.appointment_detail.dapp_status!='datang'
						$sqlu_dapp = "UPDATE appointment_detail
							SET dapp_status='".$dapp_status."'
								,dapp_jamdatang=''
								,dapp_update='".@$_SESSION[SESSION_USERID]."'
								,dapp_date_update='".$datetime_now."'
								,dapp_revised=(dapp_revised+1)
							WHERE dapp_id='".$dapp_id."'";
						$this->db->query($sqlu_dapp);
						if($this->db->affected_rows()>-1){
							/* DeCounter $dokter_id / $terapis_id
							 * $dapp_counter = 'true'/'false' ==> return tetap '1'
							*/
							if($kategori_nama=='Medis' || $kategori_nama == 'Surgery' || $kategori_nama == 'Anti Aging'){
								$rs_dokter_decounter = $this->decounter_report_tindakan_karyawan($dokter_id, $dapp_tglreservasi);
								if($rs_dokter_decounter==1){
									return '1';
								}else{
									return '-12';
								}
							}else if($kategori_nama=='Non Medis'){
								if($dapp_counter=='true'){
									$rs_terapis_decounter = $this->decounter_report_tindakan_karyawan($terapis_id, $dapp_tglreservasi);
									if($rs_terapis_decounter==1){
										return '1';
									}else{
										return '-13';
									}
								}else{
									return '1';
								}
								
							}
							
						}else{
							return '-4';
						}
					}else{
						return '-3';
					}
					
				}else if(($dapp_status_awal<>$dapp_status) && $dapp_status_awal<>'datang' && $dapp_status=='datang'){
					//Edit LIST: dari status!='datang' ==> status='datang'
					/* 
					 * 1. Proses INSERT to db.tindakan + db.tindakan_detail
					 * 2. Jika proses ke-1 sukses ==> UPDATE db.appointment_detail.dapp_status='datang'
					 * 3. Counter $dokter_id / $terapis_id
					*/
					
				}else{
					return '-11';
				}
			}else{
				//Tidak Boleh di-Edit
				return '-2';
			}
			
		}else{
			return '-1';
		}
	}
	
	//function for create new record
	function waiting_list_create($wl_customer , $karyawan_id, $rawat_id, $wl_tanggal ,$wl_keterangan ,$wl_user){
		
		if($wl_customer==''){
			$wl_customer=-1;
		}
		
		$date_now = date('Y-m-d H:i:s');
		$temp = 1;
		$wl_priority_temp = 0;
			
			/* mengambil nilai max dari priority, agar tidak terjadi dobel input priority / keloncatan*/
			$sql_parameter = "select max(wl_priority) as priority_temp from waiting_list where karyawan_id = '$karyawan_id' and wl_date = '$wl_tanggal'";
			$query_parameter = $this->db->query($sql_parameter);
			$jml_data = $query_parameter->num_rows();
			$data_parameter = $query_parameter->row($jml_data-1);
			/* Di cek, kalau datanya ada, maka priority tersebut ditambahan dengan inputan new yg baru.. */
			if($jml_data>0){
				$wl_priority_temp	= $temp+($data_parameter->priority_temp);
				
			} 
			/* Jika tidak ada datanya, langsung diinputkan prioritynya menjadi 1*/
			else {
				$wl_priority_temp	= $temp;
			}
	
			$data = array(
				"cust_id"=>$wl_customer, 
				"wl_date"=>$wl_tanggal, 
				"karyawan_id"=>$karyawan_id, 
				"rawat_id"=>$rawat_id,
				"wl_status"=>'Waiting List',
				"wl_priority"=>$wl_priority_temp,
				"wl_keterangan"=>$wl_keterangan,
				"wl_creator"=>$wl_user
			);
			$this->db->insert('waiting_list', $data);
			if($this->db->affected_rows())
				return '1';
			else
				return '0';
		
		
	}
	

	function waiting_list_down($wl_id,$karyawan_id, $wl_priority, $wl_date){
		$datetime_now = date('Y-m-d H:i:s');
		$sql = "SELECT * FROM waiting_list WHERE wl_id='".$wl_id."'";
		$rs = $this->db->query($sql);
		if($rs->num_rows()>0){
			$record = $rs->row_array();
			$wl_id_awal = $record['wl_id'];
			$wl_priority_awal = $record['wl_priority'];
			$karyawan_id_awal = $record['karyawan_id'];
			$wl_date_awal = $record['wl_date'];
			$temp_hitung = $wl_priority_awal + 1;
			
		$query_temp = "SELECT count(wl_priority) as wl_priority from waiting_list 
						WHERE karyawan_id = '".$karyawan_id."' 
						and date_format(wl_date,'%Y-%m-%d') = '".$wl_date."' 
						order by wl_priority desc";
		$query_parameter = $this->db->query($query_temp);
		$jml_data = $query_parameter->row();	
		
		$max_priority	= $jml_data->wl_priority;
			
		
		if($wl_priority_awal<>$max_priority)
		{
			
		$query="UPDATE waiting_list set wl_priority = '".$wl_priority_awal."'
				WHERE wl_priority = '".$temp_hitung."' AND karyawan_id = '".$karyawan_id_awal."' AND wl_date = '".$wl_date_awal."' and wl_status = 'Waiting List' ";
		$this->db->query($query);
		
		$query2 = "UPDATE waiting_list set wl_priority = '".$temp_hitung."'
					WHERE wl_id = '".$wl_id_awal."' and wl_status = 'Waiting List'";
		$this->db->query($query2);

		return 1;
		}
		else
		{
			return 2;
			/*Return 2, karena wl_priority sudah paling bawah, dan tidak bisa diupdate.. atau wl_status != Waiting List */
		}
		
		}
		else{
			//data tidak bisa di-Edit, karena data tidak ada
			return '-3';
		}
		
		
	}
	
	function waiting_list_up($wl_id,$karyawan_id, $wl_priority, $wl_date){
		$datetime_now = date('Y-m-d H:i:s');
		$sql = "SELECT * FROM waiting_list WHERE wl_id='".$wl_id."'";
		$rs = $this->db->query($sql);
		
		if($rs->num_rows()>0){
			$record = $rs->row_array();
			$wl_id_awal = $record['wl_id'];
			$wl_priority_awal = $record['wl_priority'];
			$karyawan_id_awal = $record['karyawan_id'];
			$wl_date_awal = $record['wl_date'];
			$temp_hitung = $wl_priority_awal - 1;
			
		if($temp_hitung > 0)
		{
		$query="UPDATE waiting_list set wl_priority = '".$wl_priority_awal."'
				WHERE wl_priority = '".$temp_hitung."' AND karyawan_id = '".$karyawan_id_awal."' AND wl_date = '".$wl_date_awal."' and wl_status = 'Waiting List' ";
		$this->db->query($query);
		
		$query2 = "UPDATE waiting_list set wl_priority = '".$temp_hitung."'
					WHERE wl_id = '".$wl_id_awal."' and wl_status = 'Waiting List'";
		$this->db->query($query2);

		return 1;
	
		}
		else
			return 2;
		
		}
		else{
			//data tidak bisa di-Edit, karena data tidak ada
			return '-3';
		}
		
		
	}
	
	
	//function for advanced search record
	function appointment_search($app_customer ,$app_cara ,$jenis_rawat ,$app_dokter ,$app_terapis , $app_rawat_medis, $app_rawat_nonmedis, $app_tgl_start_reservasi, $app_tgl_end_reservasi, $app_tgl_start_app, $app_tgl_end_app, $start,$end){
		//full query
		//$query="select * from appointment";
		/*$query="SELECT app_id,app_customer,cust_nama,karyawan_dokter.karyawan_nama as dokter_nama,karyawan_terapis.karyawan_nama as terapis_nama,rawat_id,rawat_nama,kategori_nama,dapp_id,dapp_status,dapp_tglreservasi,dapp_jamdatang,app_tanggal,app_cara,app_keterangan,dapp_jamreservasi,app_creator,app_date_create,app_update,app_date_update,app_revised 
FROM (((appointment inner join appointment_detail on appointment.app_id=appointment_detail.dapp_master inner join perawatan on appointment_detail.dapp_perawatan=perawatan.rawat_id 
inner join customer on appointment.app_customer=customer.cust_id inner join kategori on perawatan.rawat_kategori=kategori.kategori_id) 
left join vu_karyawan as karyawan_dokter on appointment_detail.dapp_petugas=karyawan_dokter.karyawan_id) left join vu_karyawan as karyawan_terapis on appointment_detail.dapp_petugas2=karyawan_terapis.karyawan_id)";
*/
		$dt=date('Y-m-d');
		$dt_six=date('Y-m-d',mktime(0,0,0,date("m"),date("d")+6,date("Y")));
		$query="SELECT * FROM vu_appointment";
		
		if($app_customer!=''){
			$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
			$query.= " app_customer='".$app_customer."'";
		};
		if($app_tgl_start_reservasi!='' && $app_tgl_end_reservasi!=''){
			$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
			$query.= " app_tanggal BETWEEN '".$app_tgl_start_reservasi."' AND '".$app_tgl_end_reservasi."'";
		}else if($app_tgl_start_reservasi!='' && $app_tgl_end_reservasi==''){
			$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
			$query.= " app_tanggal='".$app_tgl_start_reservasi."'";
		}
		if($app_tgl_start_app!='' && $app_tgl_end_app!=''){
			$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
			$query.= " dapp_tglreservasi BETWEEN '".$app_tgl_start_app."' AND '".$app_tgl_end_app."'";
		}else if($app_tgl_start_app!='' && $app_tgl_end_app==''){
			$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
			$query.= " dapp_tglreservasi='".$app_tgl_start_app."'";
		}
		if($app_cara!=''){
			$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
			$query.= " app_cara LIKE '%".$app_cara."%'";
		};
		if($jenis_rawat!=''){
			$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
			$query.= " kategori_nama='".$jenis_rawat."'";
		};
		if($app_dokter!=''){
			$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
			$query.= " dokter_id='".$app_dokter."'";
		};
		if($app_terapis!=''){
			$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
			$query.= " terapis_id='".$app_terapis."'";
		};
		if($app_rawat_medis!=''){
			$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
			$query.= " rawat_id = '".$app_rawat_medis."'";
		};
		if($app_rawat_nonmedis!=''){
			$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
			$query.= " rawat_id = '".$app_rawat_nonmedis."'";
		};
		/*if($app_keterangan!=''){
			$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
			$query.= " app_keterangan LIKE '%".$app_keterangan."%'";
		};*/
		//echo $query;
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
	function appointment_print($app_customer
								,$app_cara
								,$jenis_rawat
								,$app_dokter
								,$app_terapis
								,$app_tgl_start_reservasi
								,$app_tgl_end_reservasi
								,$app_tgl_start_app
								,$app_tgl_end_app
								,$app_rawat_medis
								,$app_rawat_nonmedis
								,$tgl_app
								,$option
								,$filter){
		//full query
		if($option=='LIST'){
			if($jenis_rawat==""){
				$jenis_rawat="Medis";
			}
			$dt=date('Y-m-d');
			$dt_six=date('Y-m-d',mktime(0,0,0,date("m"),date("d")+6,date("Y")));
			$query="SELECT * FROM vu_appointment";
			
			if($jenis_rawat=="Medis" && $filter==''){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .=" (kategori_nama='Medis' OR kategori_nama = 'Surgery' OR kategori_nama = 'Anti Aging')";
				if($tgl_app!=""){
					$tgl_app=date('Y-m-d', strtotime($tgl_app));
					$query .=" AND dapp_tglreservasi='$tgl_app'";
				}else{
					$query .=" AND dapp_tglreservasi >= '$dt'";
				}
				// For simple search
				if ($filter<>"" && is_numeric($filter)==false){
					$query="SELECT * FROM vu_appointment ";
					$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
					//search customer,perawatan,dokter,therapist
					$query .= " (cust_nama LIKE '%".addslashes($filter)."%' OR rawat_nama LIKE '%".addslashes($filter)."%' OR dokter_username LIKE '%".addslashes($filter)."%' OR terapis_username LIKE '%".addslashes($filter)."%')";
				}
			}elseif($jenis_rawat=="Non Medis" && $filter==''){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .=" kategori_nama='Non Medis'";
				if($tgl_app!=""){
					$tgl_app=date('Y-m-d', strtotime($tgl_app));
					$query .=" AND dapp_tglreservasi='$tgl_app'";
				}else{
					$query .=" AND dapp_tglreservasi >= '$dt'";
				}
				// For simple search
				if ($filter<>"" && is_numeric($filter)==false){
					$query="SELECT * FROM vu_appointment ";
					$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
					//search customer,perawatan,dokter,therapist
					$query .= " (cust_nama LIKE '%".addslashes($filter)."%' OR rawat_nama LIKE '%".addslashes($filter)."%' OR dokter_username LIKE '%".addslashes($filter)."%' OR terapis_username LIKE '%".addslashes($filter)."%')";
				}
			}
			
			// For Pilihan Dokter pada tbar
			if ($filter<>"" && is_numeric($filter)==true){
				if($tgl_app!=""){
					$dt=date('Y-m-d', strtotime($tgl_app));
					$query="SELECT * FROM vu_appointment WHERE dapp_tglreservasi = '$dt'";
				}else{
					$query="SELECT * FROM vu_appointment WHERE dapp_tglreservasi >= '$dt'";
				}
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				//search customer,perawatan,dokter,therapist
				$query .= " (dokter_id = '".addslashes($filter)."') AND (kategori_nama='Medis' OR kategori_nama = 'Surgery' OR kategori_nama = 'Anti Aging')";
			}
			
			// For Pilihan Tanggal Appointment di tbar dengan pilihan dokter kosong
			if($filter=="" && is_numeric($filter)==false && $tgl_app!="" && $jenis_rawat=="Medis"){
				$dt=date('Y-m-d', strtotime($tgl_app));
				$query="SELECT * FROM vu_appointment WHERE (kategori_nama='Medis' OR kategori_nama ='Surgery' OR kategori_nama = 'Anti Aging') AND dapp_tglreservasi = '$dt'";
			}
			
			/*  For simple search
			 *  Simple Search ==> untuk mencari data di hari ini saja
			*/
			if($filter<>'' && is_numeric($filter)==false){
				$query="SELECT * FROM vu_appointment WHERE dapp_tglreservasi='".$dt."'";
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				//search customer,perawatan,dokter,therapist
				$query .= " (cust_no LIKE '%".addslashes($filter)."%' OR cust_nama LIKE '%".addslashes($filter)."%' OR dokter_username LIKE '%".addslashes($filter)."%' OR terapis_username LIKE '%".addslashes($filter)."%')";
			}
			
			$query.=" ORDER BY dapp_tglreservasi ASC, dapp_jamreservasi ASC";
			$result = $this->db->query($query);
		} else if($option=='SEARCH'){
			$dt=date('Y-m-d');
			$dt_six=date('Y-m-d',mktime(0,0,0,date("m"),date("d")+6,date("Y")));
			$query="SELECT * FROM vu_appointment";
			
			if($app_customer!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " app_customer='".$app_customer."'";
			};
			if($app_tgl_start_reservasi!='' && $app_tgl_end_reservasi!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " app_tanggal BETWEEN '".$app_tgl_start_reservasi."' AND '".$app_tgl_end_reservasi."'";
			}else if($app_tgl_start_reservasi!='' && $app_tgl_end_reservasi==''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " app_tanggal='".$app_tgl_start_reservasi."'";
			}
			if($app_tgl_start_app!='' && $app_tgl_end_app!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " dapp_tglreservasi BETWEEN '".$app_tgl_start_app."' AND '".$app_tgl_end_app."'";
			}else if($app_tgl_start_app!='' && $app_tgl_end_app==''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " dapp_tglreservasi='".$app_tgl_start_app."'";
			}
			if($app_cara!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " app_cara LIKE '%".$app_cara."%'";
			};
			if($app_kategori!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " kategori_nama='".$app_kategori."'";
			};
			if($app_dokter!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " karyawan_dokter.karyawan_id='".$app_dokter."'";
			};
			if($app_terapis!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " karyawan_terapis.karyawan_id='".$app_terapis."'";
			};
			if($app_rawat_medis!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " rawat_id = '".$app_rawat_medis."'";
			};
			if($app_rawat_nonmedis!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " rawat_id = '".$app_rawat_nonmedis."'";
			};
			
			$result = $this->db->query($query);
		}
		return $result->result();
	}
	
	//function  for export to excel
	function appointment_export_excel($app_customer
										,$app_cara
										,$jenis_rawat
										,$app_dokter
										,$app_terapis
										,$app_tgl_start_reservasi
										,$app_tgl_end_reservasi
										,$app_tgl_start_app
										,$app_tgl_end_app
										,$app_rawat_medis
										,$app_rawat_nonmedis
										,$tgl_app
										,$option
										,$filter){
		
		//full query
		if($option=='LIST'){
			if($jenis_rawat==""){
				$jenis_rawat="Medis";
			}
			$dt=date('Y-m-d');
			$dt_six=date('Y-m-d',mktime(0,0,0,date("m"),date("d")+6,date("Y")));
			$query="SELECT dapp_tglreservasi AS tgl_app
					,dapp_jamreservasi AS jam_app
					,rawat_nama AS perawatan
					,cust_no AS no_cust
					,cust_nama AS customer
					,dokter_username AS dokter
					,terapis_username AS terapis
					,dapp_status AS status
					,dapp_jamdatang AS jam_dtg
					,dapp_jambatal as dapp_jambatal
					,dapp_jamkonfirmasi as dapp_jamkonfirmasi
					,dapp_keterangan AS keterangan
				FROM vu_appointment";
			
			if($jenis_rawat=="Medis" && $filter==''){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .=" (kategori_nama='Medis' OR kategori_nama = 'Surgery' OR kategori_nama = 'Anti Aging')";
				if($tgl_app!=""){
					$tgl_app=date('Y-m-d', strtotime($tgl_app));
					$query .=" AND dapp_tglreservasi='$tgl_app'";
				}else{
					$query .=" AND dapp_tglreservasi >= '$dt'";
				}
				// For simple search
				if ($filter<>"" && is_numeric($filter)==false){
					$query="SELECT * FROM vu_appointment ";
					$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
					//search customer,perawatan,dokter,therapist
					$query .= " (cust_nama LIKE '%".addslashes($filter)."%' OR rawat_nama LIKE '%".addslashes($filter)."%' OR dokter_username LIKE '%".addslashes($filter)."%' OR terapis_username LIKE '%".addslashes($filter)."%')";
				}
			}elseif($jenis_rawat=="Non Medis" && $filter==''){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .=" kategori_nama='Non Medis'";
				if($tgl_app!=""){
					$tgl_app=date('Y-m-d', strtotime($tgl_app));
					$query .=" AND dapp_tglreservasi='$tgl_app'";
				}else{
					$query .=" AND dapp_tglreservasi >= '$dt'";
				}
				// For simple search
				if ($filter<>"" && is_numeric($filter)==false){
					$query="SELECT * FROM vu_appointment ";
					$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
					//search customer,perawatan,dokter,therapist
					$query .= " (cust_nama LIKE '%".addslashes($filter)."%' OR rawat_nama LIKE '%".addslashes($filter)."%' OR dokter_username LIKE '%".addslashes($filter)."%' OR terapis_username LIKE '%".addslashes($filter)."%')";
				}
			}
			
			// For Pilihan Dokter pada tbar
			if ($filter<>"" && is_numeric($filter)==true){
				if($tgl_app!=""){
					$dt=date('Y-m-d', strtotime($tgl_app));
					$query="SELECT * FROM vu_appointment WHERE dapp_tglreservasi = '$dt'";
				}else{
					$query="SELECT * FROM vu_appointment WHERE dapp_tglreservasi >= '$dt'";
				}
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				//search customer,perawatan,dokter,therapist
				$query .= " (dokter_id = '".addslashes($filter)."') AND (kategori_nama='Medis' OR kategori_nama = 'Surgery' OR kategori_nama = 'Anti Aging')";
			}
			
			// For Pilihan Tanggal Appointment di tbar dengan pilihan dokter kosong
			if($filter=="" && is_numeric($filter)==false && $tgl_app!="" && $jenis_rawat=="Medis"){
				$dt=date('Y-m-d', strtotime($tgl_app));
				$query="SELECT * FROM vu_appointment WHERE (kategori_nama='Medis' OR kategori_nama ='Surgery' OR kategori_nama = 'Anti Aging') AND dapp_tglreservasi = '$dt'";
			}
			
			/*  For simple search
			 *  Simple Search ==> untuk mencari data di hari ini saja
			*/
			if($filter<>'' && is_numeric($filter)==false){
				$query="SELECT * FROM vu_appointment WHERE dapp_tglreservasi='".$dt."'";
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				//search customer,perawatan,dokter,therapist
				$query .= " (cust_no LIKE '%".addslashes($filter)."%' OR cust_nama LIKE '%".addslashes($filter)."%' OR dokter_username LIKE '%".addslashes($filter)."%' OR terapis_username LIKE '%".addslashes($filter)."%')";
			}
			
			$query.=" ORDER BY dapp_tglreservasi ASC, dapp_jamreservasi ASC";
			$result = $this->db->query($query);
			
		} else if($option=='SEARCH'){
			$dt=date('Y-m-d');
			$dt_six=date('Y-m-d',mktime(0,0,0,date("m"),date("d")+6,date("Y")));
			$query="SELECT dapp_tglreservasi AS tgl_app
					,dapp_jamreservasi AS jam_app
					,rawat_nama AS perawatan
					,cust_no AS no_cust
					,cust_nama AS customer
					,dokter_username AS dokter
					,terapis_username AS terapis
					,dapp_status AS status
					,dapp_jamdatang AS jam_dtg
					,dapp_jambatal as dapp_jambatal
					,dapp_jamkonfirmasi as dapp_jamkonfirmasi
					,dapp_keterangan AS keterangan
				FROM vu_appointment";
			
			if($app_customer!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " app_customer='".$app_customer."'";
			};
			if($app_tgl_start_reservasi!='' && $app_tgl_end_reservasi!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " app_tanggal BETWEEN '".$app_tgl_start_reservasi."' AND '".$app_tgl_end_reservasi."'";
			}else if($app_tgl_start_reservasi!='' && $app_tgl_end_reservasi==''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " app_tanggal='".$app_tgl_start_reservasi."'";
			}
			if($app_tgl_start_app!='' && $app_tgl_end_app!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " dapp_tglreservasi BETWEEN '".$app_tgl_start_app."' AND '".$app_tgl_end_app."'";
			}else if($app_tgl_start_app!='' && $app_tgl_end_app==''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " dapp_tglreservasi='".$app_tgl_start_app."'";
			}
			if($app_cara!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " app_cara LIKE '%".$app_cara."%'";
			};
			if($app_kategori!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " kategori_nama='".$app_kategori."'";
			};
			if($app_dokter!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " karyawan_dokter.karyawan_id='".$app_dokter."'";
			};
			if($app_terapis!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " karyawan_terapis.karyawan_id='".$app_terapis."'";
			};
			if($app_rawat_medis!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " rawat_id = '".$app_rawat_medis."'";
			};
			if($app_rawat_nonmedis!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " rawat_id = '".$app_rawat_nonmedis."'";
			};
			
			$result = $this->db->query($query);
		}
		return $result;
	}
		
}
?>