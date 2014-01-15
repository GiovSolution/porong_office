<? /* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
    #songbee	mukhlisona@gmail.com
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: appointment Model
	+ Description	: For record model process back-end
	+ Filename 		: c_appointment.php
 	+ Author  		: masongbee
 	+ Created on 29/Oct/2009 13:33:53
	
*/

class M_appointment extends Model{
		
	//constructor
	function M_appointment() {
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
		$sql .= " ORDER BY karyawan_username";
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
		*/
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
				left join cabang on(vu_karyawan.karyawan_cabang=cabang.cabang_id)
				WHERE karyawan_jabatan=jabatan_id AND jabatan_nama='$karyawan_jabatan' AND karyawan_aktif='Aktif'
					AND (karyawan_cabang = (SELECT info_cabang FROM info limit 1)
					OR substring(karyawan_cabang2,
					(select cabang_value 
						from cabang
						left join info on (cabang.cabang_id = info.info_cabang)
						where info.info_cabang = cabang.cabang_id),1) = '1')";
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
				left join cabang on(vu_karyawan.karyawan_cabang=cabang.cabang_value)
				WHERE karyawan_jabatan=jabatan_id AND jabatan_nama='$karyawan_jabatan' AND karyawan_aktif='Aktif'
					AND (karyawan_cabang = (SELECT info_cabang FROM info limit 1)
					OR substring(karyawan_cabang2,
					(select cabang_value 
						from cabang
						left join info on (cabang.cabang_id = info.info_cabang)
						where info.info_cabang = cabang.cabang_id),1) = '1')";
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
				left join cabang on(vu_karyawan.karyawan_cabang=cabang.cabang_value)
				WHERE karyawan_jabatan=jabatan_id AND jabatan_nama='$karyawan_jabatan' AND karyawan_aktif='Aktif'
					AND (karyawan_cabang = (SELECT info_cabang FROM info limit 1)
					OR substring(karyawan_cabang2,
					(select cabang_value 
						from cabang
						left join info on (cabang.cabang_id = info.info_cabang)
						where info.info_cabang = cabang.cabang_id),1) = '1')";
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
		left join cabang on(vu_karyawan.karyawan_cabang=cabang.cabang_value)
				WHERE karyawan_jabatan=jabatan_id AND jabatan_nama='$karyawan_jabatan' AND karyawan_aktif='Aktif'
					AND (karyawan_cabang = (SELECT info_cabang FROM info limit 1)
					OR substring(karyawan_cabang2,
					(select cabang_value 
						from cabang
						left join info on (cabang.cabang_id = info.info_cabang)
						where info.info_cabang = cabang.cabang_id),1) = '1')";
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
		left join cabang on(vu_karyawan.karyawan_cabang=cabang.cabang_value)
				WHERE karyawan_jabatan=jabatan_id AND jabatan_nama='$karyawan_jabatan' AND karyawan_aktif='Aktif'
					AND (karyawan_cabang = (SELECT info_cabang FROM info limit 1)
						OR substring(karyawan_cabang2,
						(select cabang_value 
						from cabang
						left join info on (cabang.cabang_id = info.info_cabang)
						where info.info_cabang = cabang.cabang_id),1) = '1')";
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
		left join cabang on(vu_karyawan.karyawan_cabang=cabang.cabang_value)
				WHERE karyawan_jabatan=jabatan_id AND jabatan_nama='$karyawan_jabatan' AND karyawan_aktif='Aktif'
					AND (karyawan_cabang = (SELECT info_cabang FROM info limit 1)
						OR substring(karyawan_cabang2,
						(select cabang_value 
						from cabang
						left join info on (cabang.cabang_id = info.info_cabang)
						where info.info_cabang = cabang.cabang_id),1) = '1')";
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
					left join cabang on(vu_karyawan.karyawan_cabang=cabang.cabang_value)
					WHERE karyawan_jabatan=jabatan_id AND jabatan_nama='$karyawan_jabatan' 
						AND karyawan_aktif='Aktif' 
						AND (karyawan_cabang = (SELECT info_cabang FROM info limit 1)
						OR substring(karyawan_cabang2,
						(select cabang_value 
						from cabang
						left join info on (cabang.cabang_id = info.info_cabang)
						where info.info_cabang = cabang.cabang_id),1) = '1')
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
	
	//function for detail
	//get record list detail medis
	function detail_appointment_detail_medis_list($master_id,$query,$start,$end) {
		//$query = "SELECT * FROM appointment_detail WHERE dapp_master='".$master_id."'";
		$query="SELECT * FROM appointment_detail INNER JOIN perawatan ON dapp_perawatan=rawat_id INNER JOIN kategori ON rawat_kategori=kategori_id WHERE (kategori_id='2' or kategori_id='4' or kategori_id='16') AND dapp_master='$master_id'";
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
	//get record list detail nonmedis
	function detail_appointment_detail_nonmedis_list($master_id,$query,$start,$end) {
		//$query = "SELECT * FROM appointment_detail WHERE dapp_master='".$master_id."'";
		$query="SELECT * FROM appointment_detail INNER JOIN perawatan ON dapp_perawatan=rawat_id INNER JOIN kategori ON rawat_kategori=kategori_id WHERE kategori_id='3' AND dapp_master='$master_id'";
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
	//end of function
	
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
	
	//purge all detail from master
	/*function detail_appointment_detail_purge($master_id){
		$sql="DELETE FROM appointment_detail WHERE dapp_master='".$master_id."'";
		$result=$this->db->query($sql);
	}*/
	//*eof
	
	//insert detail record
	function detail_appointment_detail_medis_insert($array_dapp_medis_id ,$dapp_medis_master ,$array_dapp_medis_perawatan ,$array_dapp_medis_tglreservasi ,$array_dapp_medis_jamreservasi ,$array_dapp_medis_petugas ,$array_dapp_medis_status ,$array_dapp_medis_keterangan ,$app_cara ,$app_customer ,$app_keterangan ,$dapp_user){
		$date_now=date('Y-m-d');
		$datetime_now=date('Y-m-d H:i:s');
		
		$size_array = sizeof($array_dapp_medis_perawatan) - 1;
		
		for($i = 0; $i < sizeof($array_dapp_medis_perawatan); $i++){
			$dapp_medis_id = $array_dapp_medis_id[$i];
			$dapp_medis_perawatan = $array_dapp_medis_perawatan[$i];
			$dapp_medis_tglreservasi = $array_dapp_medis_tglreservasi[$i];
			$dapp_medis_jamreservasi = $array_dapp_medis_jamreservasi[$i];
			$dapp_medis_petugas = $array_dapp_medis_petugas[$i];
			$dapp_medis_status = $array_dapp_medis_status[$i];
			$dapp_medis_keterangan = $array_dapp_medis_keterangan[$i];
			
			if(is_numeric($dapp_medis_id)){
				//Detail sudah ada ==> mode Edit
				$sql="SELECT dapp_id
					FROM appointment_detail
					WHERE dapp_id='$dapp_medis_id'
						AND dapp_perawatan='$dapp_medis_perawatan'
						AND dapp_tglreservasi='$dapp_medis_tglreservasi'
						AND dapp_jamreservasi='$dapp_medis_jamreservasi'
						AND dapp_petugas='$dapp_medis_petugas'
						AND dapp_keterangan='$dapp_medis_keterangan'";
				$rs=$this->db->query($sql);
				if(!$rs->num_rows()){
					$sql="SELECT dapp_locked FROM appointment_detail WHERE dapp_id='$dapp_medis_id' AND dapp_locked=0 AND dapp_status<>'datang'";
					$rs=$this->db->query($sql);
					if($rs->num_rows()){
						$data = array(
							//"dapp_master"=>$dapp_medis_master, 
							"dapp_perawatan"=>$dapp_medis_perawatan, 
							"dapp_tglreservasi"=>$dapp_medis_tglreservasi, 
							"dapp_jamreservasi"=>$dapp_medis_jamreservasi, 
							"dapp_petugas"=>$dapp_medis_petugas, 
							"dapp_keterangan"=>$dapp_medis_keterangan,
							"dapp_creator"=>$dapp_user
						);
						$this->db->where('dapp_id', $dapp_medis_id);
						$this->db->update('appointment_detail', $data);
						if($this->db->affected_rows()){
							if($i==$size_array){
								return '1';
							}
						}else{
							if($i==$size_array){
								return '1';
							}
						}
					}else{
						if($i==$size_array){
							return '1';
						}
					}
				}else{
					if($i==$size_array){
						return '1';
					}
				}
			}else{
				//Detail Baru
				/* JIKA $dapp_medis_petugas=="" ==> diisi db.vu_karyawan.karyawan_id WHERE username="Available dr." */
				if($dapp_medis_petugas==""){
					$sql="SELECT karyawan_id FROM vu_karyawan WHERE karyawan_no='99'";
					$rs=$this->db->query($sql);
					if($rs->num_rows()){
						$rs_record=$rs->row_array();
						$dapp_medis_petugas=$rs_record["karyawan_id"];
					}
				}
				
				//if master id not capture from view then capture it from max pk from master table
				if($dapp_medis_master=="" || $dapp_medis_master==NULL){
					$dapp_medis_master=$this->get_master_id();
				}
				
				$dapp_medis_tgldatang=NULL;
				$dapp_medis_jamdatang='';
				if($dapp_medis_status=="datang" || $dapp_medis_status=="Datang"){
					$dapp_medis_tglreservasi=date('Y-m-d');
					
					$dapp_medis_tgldatang=date('Y-m-d');
					$dapp_medis_jamdatang=date('H:i:s');
				}
				
				if($app_cara=="Datang")
					$dapp_medis_keterangan="[W] ".$dapp_medis_keterangan;
				if($app_cara=="Update")
					$dapp_medis_keterangan="[ID] ".$dapp_medis_keterangan;
				
				$dti_app = array(
					"dapp_master"=>$dapp_medis_master, 
					"dapp_perawatan"=>$dapp_medis_perawatan, 
					"dapp_tglreservasi"=>$dapp_medis_tglreservasi, 
					"dapp_jamreservasi"=>$dapp_medis_jamreservasi, 
					"dapp_petugas"=>$dapp_medis_petugas, 
					"dapp_status"=>$dapp_medis_status, 
					"dapp_tgldatang"=>$dapp_medis_tgldatang, 
					"dapp_jamdatang"=>$dapp_medis_jamdatang,
					"dapp_keterangan"=>$dapp_medis_keterangan,
					"dapp_creator"=>$dapp_user
				);
				$this->db->insert('appointment_detail', $dti_app);
				if($this->db->affected_rows()){
					//* Check dan Ambil db.appointment_detail.dapp_id yang telah "barusan" ter-input /
					$sql="SELECT dapp_id
						FROM appointment_detail
						WHERE dapp_master='$dapp_medis_master'
							AND dapp_perawatan='$dapp_medis_perawatan'
							AND dapp_tglreservasi='$dapp_medis_tglreservasi'";
					$rs=$this->db->query($sql);
					if($rs->num_rows()){
						$rs_record=$rs->row_array();
						$dapp_id=$rs_record["dapp_id"];
					}
					//* JIKA Cara Appointment = 'Walk-in' alias 'Datang', maka INSERT ke db.tindakan atau dan db.tindakan_detail /
					if($app_cara=="Datang"){
						$date_now=date('Y-m-d');
						$time_now=date('H:i:s');
						//* INSERT ke db.tindakan dan db.tindakan_detail JIKA $dapp_status=='datang' /
						$sql="SELECT trawat_id FROM tindakan WHERE trawat_cust='$app_customer' AND date_format(trawat_date_create,'%Y-%m-%d')='$date_now'";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){ //* artinya: di db.tindakan telah masuk appointment = $app_customer pada trawat_date_create(tanggal-input) = $date_now /
							$rs_record=$rs->row_array();
							$dtrawat_master=$rs_record["trawat_id"]; //ambil ID dr tabel tindakan
							//Karena di db.tindakan telah ada $app_customer && trawat_date_create='$date_now', maka HANYA INSERT to db.tindakan_detail
							$data_dtindakan=array(
							"dtrawat_master"=>$dtrawat_master,
							"dtrawat_dapp"=>$dapp_id,
							"dtrawat_perawatan"=>$dapp_medis_perawatan,
							"dtrawat_petugas1"=>$dapp_medis_petugas,
							"dtrawat_kategori"=>'Medis',
							"dtrawat_jam"=>$dapp_medis_jamreservasi,
							"dtrawat_jam_datang"=>$time_now,
							"dtrawat_tglapp"=>$dapp_medis_tglreservasi,
							"dtrawat_keterangan"=>$dapp_medis_keterangan,
							"dtrawat_status"=>$dapp_medis_status,
							"dtrawat_creator"=>@$_SESSION[SESSION_USERID]
							);
							$this->db->insert('tindakan_detail', $data_dtindakan);
							if($this->db->affected_rows()){
								//UPDATE/INSERT ke db.report_tindakan dari Dokter && $app_cara=='datang'
								$this->counter_report_tindakan_karyawan($dapp_medis_petugas, $dapp_medis_tglreservasi);
								if($i==$size_array){
									return '1';
								}
							}else{
								if($i==$size_array){
									return '1';
								}
							}
							
						}else{ //* artinya: di db.tindakan BELUM masuk $app_customer && trawat_date_create(tanggal-input) = $date_now /
							//* INSERT to db.tindakan /
							if($app_customer==''){
								/*$sql = "SELECT app_customer
									FROM appointment_detail
									LEFT JOIN appointment ON(dapp_master=app_id)
									WHERE dapp_master='$dapp_medis_master'";*/
								$sql = "SELECT app_customer
									FROM appointment 
									WHERE app_id=".$dapp_medis_master;
								$rs = $this->db->query($sql);
								if($rs->num_rows()){
									$record = $rs->row_array();
									$app_customer = $record['app_customer'];
								}
							}
							$data_tindakan=array(
							"trawat_cust"=>$app_customer,
							"trawat_jamdatang"=>$time_now,
							//"trawat_appointment"=>$kategori_nama,
							"trawat_keterangan"=>$app_keterangan,
							"trawat_creator"=>@$_SESSION[SESSION_USERID]
							);
							$this->db->insert('tindakan', $data_tindakan);
							
							if($this->db->affected_rows()){
								//* Telah ter-insert ke db.tindakan, maka mulai INSERT db.tindakan_detail /
								$sql="SELECT trawat_id FROM tindakan WHERE trawat_cust='$app_customer' AND date_format(trawat_date_create,'%Y-%m-%d')='$date_now'";
								$rs=$this->db->query($sql);
								if($rs->num_rows()){
									$rs_record=$rs->row_array();
									$dtrawat_master=$rs_record["trawat_id"];
								}
								$data_dtindakan=array(
								"dtrawat_master"=>$dtrawat_master,
								"dtrawat_dapp"=>$dapp_id,
								"dtrawat_perawatan"=>$dapp_medis_perawatan,
								"dtrawat_petugas1"=>$dapp_medis_petugas,
								"dtrawat_kategori"=>'Medis',
								"dtrawat_jam"=>$dapp_medis_jamreservasi,
								"dtrawat_jam_datang"=>$time_now,
								"dtrawat_tglapp"=>$dapp_medis_tglreservasi,
								"dtrawat_keterangan"=>$dapp_medis_keterangan,
								"dtrawat_status"=>$dapp_medis_status,
								"dtrawat_creator"=>@$_SESSION[SESSION_USERID]
								);
								$this->db->insert('tindakan_detail', $data_dtindakan);
								if($this->db->affected_rows()){
									//UPDATE/INSERT ke db.report_tindakan dari Dokter && $app_cara=='datang'
									$this->counter_report_tindakan_karyawan($dapp_medis_petugas, $dapp_medis_tglreservasi);
									if($i==$size_array){
										return '1';
									}
								}else{
									if($i==$size_array){
										return '1';
									}
								}
							}else{
								if($i==$size_array){
									return '1';
								}
							}
						}
						
					}else{
						if($i==$size_array){
							return '1';
						}
					}
					
				}else{
					if($i==$size_array){
						return '0';
					}
				}
				
			}
			
		}
		
	}
	
	function detail_appointment_detail_nonmedis_insert(
		$array_dapp_nonmedis_id ,
		$dapp_nonmedis_master ,
		$array_dapp_nonmedis_perawatan ,
		$array_dapp_nonmedis_tglreservasi ,
		$array_dapp_nonmedis_jamreservasi ,
		$array_dapp_nonmedis_petugas2 ,
		$array_dapp_nonmedis_status ,
		$array_dapp_nonmedis_keterangan ,
		$array_dapp_nonmedis_counter ,
		$array_dapp_nonmedis_warna_terapis, 
		$app_cara ,
		$app_customer ,
		$app_keterangan ,
		$dapp_user){
		
		$date_now=date('Y-m-d');
		$datetime_now=date('Y-m-d H:i:s');
		
		$size_array = sizeof($array_dapp_nonmedis_perawatan) - 1;
		
		for($i = 0; $i < sizeof($array_dapp_nonmedis_perawatan); $i++){
			$dapp_nonmedis_id = $array_dapp_nonmedis_id[$i];
			$dapp_nonmedis_perawatan = $array_dapp_nonmedis_perawatan[$i];
			$dapp_nonmedis_tglreservasi = $array_dapp_nonmedis_tglreservasi[$i];
			$dapp_nonmedis_jamreservasi = $array_dapp_nonmedis_jamreservasi[$i];
			$dapp_nonmedis_petugas2 = $array_dapp_nonmedis_petugas2[$i];
			$dapp_nonmedis_status = $array_dapp_nonmedis_status[$i];
			$dapp_nonmedis_keterangan = $array_dapp_nonmedis_keterangan[$i];
			$dapp_nonmedis_counter = $array_dapp_nonmedis_counter[$i];
			$dapp_nonmedis_warna_terapis = $array_dapp_nonmedis_warna_terapis[$i];
			
			if(is_numeric($dapp_nonmedis_id)){
				//Detail sudah ada ==> mode Edit
				$sql="SELECT dapp_id FROM appointment_detail WHERE dapp_id='$dapp_nonmedis_id' AND dapp_perawatan='$dapp_nonmedis_perawatan' AND dapp_tglreservasi='$dapp_nonmedis_tglreservasi' AND dapp_jamreservasi='$dapp_nonmedis_jamreservasi' AND dapp_petugas='$dapp_nonmedis_petugas2' AND dapp_keterangan='$dapp_nonmedis_keterangan'";
				$rs=$this->db->query($sql);
				if(!$rs->num_rows()){
					$sql="SELECT dapp_locked FROM appointment_detail WHERE dapp_id='$dapp_nonmedis_id' AND dapp_locked=0 AND dapp_status<>'datang'";
					$rs=$this->db->query($sql);
					if($rs->num_rows()){
						$data = array(
							//"dapp_master"=>$dapp_medis_master, 
							"dapp_perawatan"=>$dapp_nonmedis_perawatan, 
							"dapp_tglreservasi"=>$dapp_nonmedis_tglreservasi, 
							"dapp_jamreservasi"=>$dapp_nonmedis_jamreservasi, 
							"dapp_petugas2"=>$dapp_nonmedis_petugas2, 
							"dapp_keterangan"=>$dapp_nonmedis_keterangan,
							"dapp_warna_terapis"=>$dapp_nonmedis_warna_terapis,
							"dapp_creator"=>$dapp_user
						);
						$this->db->where('dapp_id', $dapp_nonmedis_id);
						$this->db->update('appointment_detail', $data);
						if($this->db->affected_rows()){
							if($i==$size_array){
								return '1';
							}
						}else{
							if($i==$size_array){
								return '1';
							}
						}
					}else{
						if($i==$size_array){
							return '1';
						}
					}
				}else{
					if($i==$size_array){
						return '1';
					}
				}
				
			}else{
				//Detail Baru
				/* JIKA $dapp_medis_petugas=="" ==> diisi db.vu_karyawan.karyawan_id WHERE username="Available dr." */
				if($dapp_nonmedis_petugas2==""){
					$sql="SELECT karyawan_id FROM vu_karyawan WHERE karyawan_no='999'";
					$rs=$this->db->query($sql);
					if($rs->num_rows()){
						$rs_record=$rs->row_array();
						$dapp_nonmedis_petugas2=$rs_record["karyawan_id"];
					}
				}
				
				//if master id not capture from view then capture it from max pk from master table
				if($dapp_nonmedis_master=="" || $dapp_nonmedis_master==NULL){
					$dapp_nonmedis_master=$this->get_master_id();
				}
				
				$dapp_nonmedis_tgldatang=NULL;
				$dapp_nonmedis_jamdatang='';
				if($dapp_nonmedis_status=="datang" || $dapp_nonmedis_status=="Datang"){
					$dapp_nonmedis_tglreservasi=date('Y-m-d');
					
					$dapp_nonmedis_tgldatang=date('Y-m-d');
					$dapp_nonmedis_jamdatang=date('H:i:s');
				}
				
				if($app_cara=="Datang")
					$dapp_nonmedis_keterangan="[W] ".$dapp_nonmedis_keterangan;
				if($app_cara=="Update")
					$dapp_nonmedis_keterangan="[ID] ".$dapp_nonmedis_keterangan;
				
				$data = array(
					"dapp_master"=>$dapp_nonmedis_master, 
					"dapp_perawatan"=>$dapp_nonmedis_perawatan, 
					"dapp_tglreservasi"=>$dapp_nonmedis_tglreservasi, 
					"dapp_jamreservasi"=>$dapp_nonmedis_jamreservasi, 
					"dapp_petugas2"=>$dapp_nonmedis_petugas2, 
					"dapp_status"=>$dapp_nonmedis_status, 
					"dapp_tgldatang"=>$dapp_nonmedis_tgldatang, 
					"dapp_jamdatang"=>$dapp_nonmedis_jamdatang,
					"dapp_keterangan"=>$dapp_nonmedis_keterangan,
					"dapp_counter"=>$dapp_nonmedis_counter,
					"dapp_warna_terapis"=>$dapp_nonmedis_warna_terapis,
					"dapp_creator"=>$dapp_user
				);
				$this->db->insert('appointment_detail', $data); 
				if($this->db->affected_rows()){
					/* Check dan Ambil db.appointment_detail.dapp_id yang telah "barusan" ter-input */
					$sql="SELECT dapp_id
						FROM appointment_detail
						WHERE dapp_master='$dapp_nonmedis_master'
							AND dapp_perawatan='$dapp_nonmedis_perawatan'
							AND dapp_tglreservasi='$dapp_nonmedis_tglreservasi'";
					$rs=$this->db->query($sql);
					if($rs->num_rows()){
						$rs_record=$rs->row_array();
						$dapp_id=$rs_record["dapp_id"];
					}
					/* JIKA Cara Appointment = 'Walk-in' alias 'Datang', maka INSERT ke db.tindakan atau dan db.tindakan_detail */
					if($app_cara=="Datang"){
						$date_now=date('Y-m-d');
						$time_now=date('H:i:s');
						
						/* INSERT ke db.tindakan dan db.tindakan_detail JIKA $dapp_status=='datang' */
						$sql="SELECT trawat_id FROM tindakan WHERE trawat_cust='$app_customer' AND date_format(trawat_date_create,'%Y-%m-%d')='$date_now'";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){ /* artinya: di db.tindakan telah masuk appointment = $app_customer pada trawat_date_create(tanggal-input) = $date_now */
							$rs_record=$rs->row_array();
							$dtrawat_master=$rs_record["trawat_id"]; //ambil ID dr tabel tindakan
							//Karena di db.tindakan telah ada $app_customer && trawat_date_create='$date_now', maka HANYA INSERT to db.tindakan_detail
							$data_dtindakan=array(
							"dtrawat_master"=>$dtrawat_master,
							"dtrawat_dapp"=>$dapp_id,
							"dtrawat_perawatan"=>$dapp_nonmedis_perawatan,
							"dtrawat_petugas2"=>$dapp_nonmedis_petugas2,
							"dtrawat_kategori"=>'Non Medis',
							"dtrawat_jam"=>$dapp_nonmedis_jamreservasi,
							"dtrawat_jam_datang"=>$time_now,
							"dtrawat_tglapp"=>$dapp_nonmedis_tglreservasi,
							"dtrawat_keterangan"=>$dapp_nonmedis_keterangan,
							"dtrawat_status"=>$dapp_nonmedis_status,
							"dtrawat_creator"=>@$_SESSION[SESSION_USERID]
							);
							$this->db->insert('tindakan_detail', $data_dtindakan);
							if($this->db->affected_rows()){
								//UPDATE/INSERT ke db.report_tindakan dari Terapis && $app_cara=='datang'
								$this->counter_report_tindakan_karyawan($dapp_nonmedis_petugas2, $dapp_nonmedis_tglreservasi);
								if($i==$size_array){
									return '1';
								}
							}else{
								if($i==$size_array){
									return '1';
								}
							}
							
						}else{ /* artinya: di db.tindakan BELUM masuk $app_customer && trawat_date_create(tanggal-input) = $date_now */
							if($app_customer==''){
								/*$sql = "SELECT app_customer
									FROM appointment_detail
									LEFT JOIN appointment ON(dapp_master=app_id)
									WHERE dapp_master='$dapp_nonmedis_master'";*/
								$sql = "SELECT app_customer
									FROM appointment 
									WHERE app_id='$dapp_nonmedis_master'";
								$rs = $this->db->query($sql);
								if($rs->num_rows()){
									$record = $rs->row_array();
									$app_customer = $record['app_customer'];
								}
							}
							
							/* INSERT to db.tindakan */
							$data_tindakan=array(
							"trawat_cust"=>$app_customer,
							"trawat_jamdatang"=>$time_now,
							//"trawat_appointment"=>$kategori_nama,
							"trawat_keterangan"=>$app_keterangan,
							"trawat_creator"=>@$_SESSION[SESSION_USERID]
							);
							$this->db->insert('tindakan', $data_tindakan);
							if($this->db->affected_rows()){
								/* Telah ter-insert ke db.tindakan, maka mulai INSERT db.tindakan_detail */
								$sql="SELECT trawat_id FROM tindakan WHERE trawat_cust='$app_customer' AND date_format(trawat_date_create,'%Y-%m-%d')='$date_now'";
								$rs=$this->db->query($sql);
								if($rs->num_rows()){
									$rs_record=$rs->row_array();
									$dtrawat_master=$rs_record["trawat_id"];
								}
								$data_dtindakan=array(
								"dtrawat_master"=>$dtrawat_master,
								"dtrawat_dapp"=>$dapp_id,
								"dtrawat_perawatan"=>$dapp_nonmedis_perawatan,
								"dtrawat_petugas2"=>$dapp_nonmedis_petugas2,
								"dtrawat_kategori"=>'Non Medis',
								"dtrawat_jam"=>$dapp_nonmedis_jamreservasi,
								"dtrawat_jam_datang"=>$time_now,
								"dtrawat_tglapp"=>$dapp_nonmedis_tglreservasi,
								"dtrawat_keterangan"=>$dapp_nonmedis_keterangan,
								"dtrawat_status"=>$dapp_nonmedis_status,
								"dtrawat_creator"=>@$_SESSION[SESSION_USERID]
								);
								$this->db->insert('tindakan_detail', $data_dtindakan);
								if($this->db->affected_rows()){
									//UPDATE/INSERT ke db.report_tindakan dari Terapis && $app_cara=='datang'
									$this->counter_report_tindakan_karyawan($dapp_nonmedis_petugas2, $dapp_nonmedis_tglreservasi);
									if($i==$size_array){
										return '1';
									}
								}else{
									if($i==$size_array){
										return '1';
									}
								}
							}else{
								if($i==$size_array){
									return '1';
								}
							}
						}
					}else{
						if($i==$size_array){
							return '1';
						}
					}
					
				}else{
					if($i==$size_array){
						return '0';
					}
				}
				
			}
			
		}
		
	}
	//end of function
	
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
	
	
	function tindakan_detail_insert($app_customer
									,$dapp_id
									,$dapp_perawatan
									,$dokter_id
									,$terapis_id
									,$dapp_jamreservasi
									,$kategori_nama
									,$dapp_tglreservasi
									,$dapp_keterangan
									,$dapp_status
									,$dapp_jamdatang
									,$app_user){
		/* 
		* 1. Check di db.tindakan <== apakah Customer sudah masuk di db.tindakan di hari ini ?
		* 1.A. Jika SUDAH ==> INSERT ke db.tindakan_detail dengan dtrawat_status='datang'
		* 1.B. Jika BELUM ==> CREATE db.tindakan --> kemudian INSERT db.tindakan_detail dengan dtrawat_status='datang'
	   */
		$datetime_now = date('Y-m-d H:i:s');
		$time_now = date('H:i:s');
		   
		$sql_trawat = "SELECT trawat_id
			FROM tindakan
			WHERE trawat_cust='".$app_customer."'
				AND date_format(trawat_date_create, '%Y-%m-%d') = date_format(now(), '%Y-%m-%d')";
		$rs_trawat = $this->db->query($sql_trawat);
		if($rs_trawat->num_rows()){
			/* Customer di hari ini sudah pernah masuk di Tindakan, maka 
			 * 1. INSERT ke db.tindakan_detail dengan dtrawat_status='datang'
			*/
			$record_trawat = $rs_trawat->row_array();
			$dtrawat_master = $record_trawat['trawat_id'];
			
			if($kategori_nama=='Medis' || $kategori_nama=='Surgery' || $kategori_nama=='Anti Aging'){
				$dti_dtrawat = array(
					"dtrawat_master"=>$dtrawat_master,
					"dtrawat_dapp"=>$dapp_id,
					"dtrawat_perawatan"=>$dapp_perawatan,
					"dtrawat_petugas1"=>$dokter_id,
					"dtrawat_jam"=>$dapp_jamreservasi,
					"dtrawat_jam_datang"=>$time_now,
					"dtrawat_kategori"=>'Medis',
					"dtrawat_tglapp"=>$dapp_tglreservasi,
					"dtrawat_keterangan"=>$dapp_keterangan,
					"dtrawat_ambil_paket"=>'false',
					"dtrawat_creator"=>$app_user
				);
				$this->db->insert('tindakan_detail', $dti_dtrawat);
				if($this->db->affected_rows()){
					return 1;
				}else{
					return 0;
				}
			}else if($kategori_nama=='Non Medis'){
				$dti_dtrawat = array(
					"dtrawat_master"=>$dtrawat_master,
					"dtrawat_dapp"=>$dapp_id,
					"dtrawat_perawatan"=>$dapp_perawatan,
					"dtrawat_petugas2"=>$terapis_id,
					"dtrawat_jam"=>$dapp_jamreservasi,
					"dtrawat_jam_datang"=>$time_now,
					"dtrawat_kategori"=>'Non Medis',
					"dtrawat_tglapp"=>$dapp_tglreservasi,
					"dtrawat_keterangan"=>$dapp_keterangan,
					"dtrawat_ambil_paket"=>'false',
					"dtrawat_creator"=>$app_user
				);
				$this->db->insert('tindakan_detail', $dti_dtrawat);
				if($this->db->affected_rows()){
					return 1;
				}else{
					return 0;
				}
			}else{
				return 0;
			}
			
		}else{
			/* Customer di hari ini belum pernah masuk di Tindakan, maka CREATE db.tindakan
			* 1. CREATE db.tindakan dan Ambil db.tindakan.trawat_id
			* 2. INSERT db.tindakan_detail
			* 3. UPDATE db.appointment_detail ==> dapp_status='datang', dapp_jamdatang=$time_now
			* 4. Counter $dokter_id / $terapis_id
		   */
			$dti_trawat = array(
				"trawat_cust"=>$app_customer,
				"trawat_jamdatang"=>$dapp_jamdatang,
				"trawat_appointment"=>$kategori_nama,
				"trawat_keterangan"=>$dapp_keterangan,
				"trawat_creator"=>$app_user
			);
			$this->db->insert('tindakan',$dti_trawat);
			if($this->db->affected_rows()){
				//Ambil db.tindakan.trawat_id
				$sql = "SELECT max(trawat_id) AS trawat_id FROM tindakan WHERE trawat_creator='".$app_user."'";
				$rs = $this->db->query($sql);
				if($rs->num_rows()){
					$record = $rs->row_array();
					$dtrawat_master = $record['trawat_id'];
					//INSERT to db.tindakan_detail
					if($kategori_nama=='Medis' || $kategori_nama == 'Surgery' || $kategori_nama=='Anti Aging'){
						$dti_dtrawat = array(
							"dtrawat_master"=>$dtrawat_master,
							"dtrawat_dapp"=>$dapp_id,
							"dtrawat_perawatan"=>$dapp_perawatan,
							"dtrawat_petugas1"=>$dokter_id,
							"dtrawat_jam"=>$dapp_jamreservasi,
							"dtrawat_jam_datang"=>$time_now,
							"dtrawat_kategori"=>'Medis',
							"dtrawat_tglapp"=>$dapp_tglreservasi,
							"dtrawat_keterangan"=>$dapp_keterangan,
							"dtrawat_ambil_paket"=>'false',
							"dtrawat_creator"=>$app_user
						);
						$this->db->insert('tindakan_detail', $dti_dtrawat);
						if($this->db->affected_rows()){
							return 1;
						}else{
							return 0;
						}
					}else if($kategori_nama=='Non Medis'){
						$dti_dtrawat = array(
							"dtrawat_master"=>$dtrawat_master,
							"dtrawat_dapp"=>$dapp_id,
							"dtrawat_perawatan"=>$dapp_perawatan,
							"dtrawat_petugas2"=>$terapis_id,
							"dtrawat_jam"=>$dapp_jamreservasi,
							"dtrawat_jam_datang"=>$time_now,
							"dtrawat_kategori"=>'Non Medis',
							"dtrawat_tglapp"=>$dapp_tglreservasi,
							"dtrawat_keterangan"=>$dapp_keterangan,
							"dtrawat_ambil_paket"=>'false',
							"dtrawat_creator"=>$app_user
						);
						$this->db->insert('tindakan_detail', $dti_dtrawat);
						if($this->db->affected_rows()){
							return 1;
						}else{
							return 0;
						}
					}else{
						return 0;
					}
					
				}else{
					return 0;
				}
			}
		}
	}
	
	//function for get list record
	function appointment_list($filter,$start,$end,$tgl_app,$jam_awal,$jam_akhir,$jenis_rawat,$dokter_id){
		if($jam_awal!=''){		
			$jam_awal=$jam_awal.':00';
		}
		if($jam_akhir!=''){	
			$jam_akhir=$jam_akhir.':00';
		}
		
		if($jenis_rawat=="")
			$jenis_rawat="Medis";
		//$query = "SELECT * FROM appointment";
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
			
			if($jam_awal!='' or $jam_akhir!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				if($jam_awal!='' and $jam_akhir!=''){
					$query.= " dapp_jamreservasi >= '".$jam_awal."' AND dapp_jamreservasi <= '".$jam_akhir."'";
				}else if ($jam_awal!='' and $jam_akhir==''){
					$query.= " dapp_jamreservasi >= '".$jam_awal."'";
				}else if ($jam_awal=='' and $jam_akhir!=''){
					$query.= " dapp_jamreservasi <= '".$jam_akhir."'";
				}
			}
			// For simple search
			/*if ($filter<>"" && is_numeric($filter)==false){
				$query="SELECT * FROM vu_appointment ";
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				//search customer,perawatan,dokter,therapist
				$query .= " (cust_nama LIKE '%".addslashes($filter)."%' OR cust_no LIKE '%".addslashes($filter)."%' OR rawat_nama LIKE '%".addslashes($filter)."%' OR dokter_username LIKE '%".addslashes($filter)."%' OR terapis_username LIKE '%".addslashes($filter)."%')";
			}*/
		}elseif($jenis_rawat=="Non Medis" && $filter==''){
			$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
			$query .=" kategori_nama='Non Medis'";
			if($tgl_app!=""){
				$tgl_app=date('Y-m-d', strtotime($tgl_app));
				$query .=" AND dapp_tglreservasi='$tgl_app'";
			}else{
				$query .=" AND dapp_tglreservasi >= '$dt'";
			}
			
			if($jam_awal!='' or $jam_akhir!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				if($jam_awal!='' and $jam_akhir!=''){
					$query.= " dapp_jamreservasi >= '".$jam_awal."' AND dapp_jamreservasi <= '".$jam_akhir."'";
				}else if ($jam_awal!='' and $jam_akhir==''){
					$query.= " dapp_jamreservasi >= '".$jam_awal."'";
				}else if ($jam_awal=='' and $jam_akhir!=''){
					$query.= " dapp_jamreservasi <= '".$jam_akhir."'";
				}
			}
			// For simple search
			/*if ($filter<>"" && is_numeric($filter)==false){
				$query="SELECT * FROM vu_appointment ";
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				//search customer,perawatan,dokter,therapist
				$query .= " (cust_nama LIKE '%".addslashes($filter)."%' OR cust_no LIKE '%".addslashes($filter)."%' OR rawat_nama LIKE '%".addslashes($filter)."%' OR dokter_username LIKE '%".addslashes($filter)."%' OR terapis_username LIKE '%".addslashes($filter)."%')";
			}*/
		}
		
		// For Pilihan Dokter pada tbar
		if ($dokter_id<>"" && is_numeric($dokter_id)==true){
			if($tgl_app!=""){
				$dt=date('Y-m-d', strtotime($tgl_app));
				$query="SELECT * FROM vu_appointment WHERE dapp_tglreservasi = '$dt'";
			}else{
				$query="SELECT * FROM vu_appointment WHERE dapp_tglreservasi >= '$dt'";
			}
			if($jam_awal!='' or $jam_akhir!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				if($jam_awal!='' and $jam_akhir!=''){
					$query.= " dapp_jamreservasi >= '".$jam_awal."' AND dapp_jamreservasi <= '".$jam_akhir."'";
				}else if ($jam_awal!='' and $jam_akhir==''){
					$query.= " dapp_jamreservasi >= '".$jam_awal."'";
				}else if ($jam_awal=='' and $jam_akhir!=''){
					$query.= " dapp_jamreservasi <= '".$jam_akhir."'";
				}
			}
			$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
			//search customer,perawatan,dokter,therapist
			$query .= " (dokter_id = '".addslashes($dokter_id)."') AND (kategori_nama='Medis' OR kategori_nama = 'Surgery' OR kategori_nama = 'Anti Aging')";
 
		}
		
		// For Pilihan Tanggal Appointment di tbar dengan pilihan dokter kosong
		if($dokter_id=="" && is_numeric($dokter_id)==false && $tgl_app!="" && $jenis_rawat=="Medis"){
			$dt=date('Y-m-d', strtotime($tgl_app));
			$query="SELECT * FROM vu_appointment WHERE (kategori_nama='Medis' OR kategori_nama ='Surgery' OR kategori_nama = 'Anti Aging') AND dapp_tglreservasi = '$dt'";
			
			if($jam_awal!='' or $jam_akhir!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				if($jam_awal!='' and $jam_akhir!=''){
					$query.= " dapp_jamreservasi >= '".$jam_awal."' AND dapp_jamreservasi <= '".$jam_akhir."'";
				}else if ($jam_awal!='' and $jam_akhir==''){
					$query.= " dapp_jamreservasi >= '".$jam_awal."'";
				}else if ($jam_awal=='' and $jam_akhir!=''){
					$query.= " dapp_jamreservasi <= '".$jam_akhir."'";
				}
			}
		}
			
		/*  For simple search
		 *  Simple Search ==> untuk mencari data di hari ini saja
		*/
		if($filter<>''){
			$query="SELECT * FROM vu_appointment WHERE dapp_tglreservasi >= '".$dt."'";
			$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
			//search customer,perawatan,dokter,therapist
			$query .= " (cust_no LIKE '%".addslashes($filter)."%' OR cust_nama LIKE '%".addslashes($filter)."%' )";
		}
		
		$query.=" ORDER BY dapp_tglreservasi ASC, dapp_jamreservasi ASC";
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
	
	//function for update record
	function appointment_update($app_id
							    ,$app_customer
								,$app_tanggal
								,$app_cara
								,$app_keterangan
								,$app_user){
		$dt=date('Y-m-d H:i:s');
		$date_now=date('Y-m-d');
		$bln_now=date('Y-m');
		
		/* UPDATE ke db.appointment baik $dapp_status=='datang' atau $dapp_status!='datang'
		>> Checking di db.appointment, apakah ada Perubahan atau Tidak => jika Tidak maka Tidak Ada Updating */
		$sql="SELECT app_cara,app_keterangan,app_revised, app_customer, app_tanggal FROM appointment WHERE app_id='$app_id'";
		$rs=$this->db->query($sql);
		if($rs->num_rows()){
			$rs_record=$rs->row_array();
			if($rs_record["app_cara"]!=$app_cara || $rs_record["app_keterangan"]!=$app_keterangan || $rs_record["app_tanggal"]!=$app_tanggal || is_numeric($app_customer)){ /* JIKA terjadi PERUBAHAN */
				$data = array(
					"app_cara"=>$app_cara, 
					"app_keterangan"=>$app_keterangan,
					"app_tanggal"=>$app_tanggal,
					"app_update"=>$app_user,
					"app_date_update"=>$dt,
					"app_revised"=>$rs_record["app_revised"]+1
				);
				$sql="SELECT cust_id FROM customer WHERE cust_id='".$app_customer."'";
				$rs=$this->db->query($sql);
				if($rs->num_rows())
					$data["app_customer"]=$app_customer;
					
				$this->db->where('app_id', $app_id);
				$this->db->update('appointment', $data);
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
	
	function appointment_update_list($dapp_id
									,$dapp_tglreservasi
									,$dapp_jamreservasi
									,$dokter
									,$terapis
									,$dapp_keterangan
									,$dapp_status
									,$app_user){
		/* db.appointment_detail.dapp_status pasti !=='datang' ==> artinya belum dimasukkan ke db.tindakan+db.tindakan_detail
		 * maka yang diupdate hanya di db.appointment_detail
		*/
		$datetime_now = date('Y-m-d H:i:s');
		
		//Nilai Awal dari table db.appointment dan db.appointment_detail
		$sql = "SELECT dapp_tglreservasi
				,dapp_jamreservasi
				,dokter_id
				,terapis_id
				,dapp_keterangan
				,kategori_nama
				,dapp_jambatal
				,dapp_jamkonfirmasi
				,dapp_status
			FROM vu_appointment
			WHERE dapp_id='".$dapp_id."'";
		$rs = $this->db->query($sql);
		if($rs->num_rows()){
			$record = $rs->row_array();
			/* menentukan nilai awal dari database untuk dibandingkan dengan nilai di parameter
			 * Jika sama ==> berarti tidak berubah
			 * Jika tidak sama ==> berarti ada perubahan
			*/
			$dapp_tglreservasi_awal = $record['dapp_tglreservasi'];
			$dapp_jamreservasi_awal = $record['dapp_jamreservasi'];
			$dokter_awal = $record['dokter_id'];
			$terapis_awal = $record['terapis_id'];
			$dapp_keterangan_awal = $record['dapp_keterangan'];
			$kategori_nama = $record['kategori_nama'];
			$dapp_status_awal = $record['dapp_status'];
			
			if($dapp_tglreservasi_awal<>$dapp_tglreservasi){
				//ada perubahan tgl_reservasi
				//UPDATE db.appointment_detail.dapp_petugas
				$sqlu_dapp = "UPDATE appointment_detail
					SET dapp_tglreservasi='".$dapp_tglreservasi."'
						,dapp_update='".$app_user."'
						,dapp_date_update='".$datetime_now."'
						,dapp_revised=(dapp_revised+1)
					WHERE dapp_id='".$dapp_id."'";
				$this->db->query($sqlu_dapp);
				if($this->db->affected_rows()){
					return '1';
				}else{
					return '-9';
				}
				
			}else if($dapp_jamreservasi_awal<>$dapp_jamreservasi){
				//ada perubahan jam_reservasi
				//UPDATE db.appointment_detail.dapp_petugas
				$sqlu_dapp = "UPDATE appointment_detail
					SET dapp_jamreservasi='".$dapp_jamreservasi."'
						,dapp_update='".$app_user."'
						,dapp_date_update='".$datetime_now."'
						,dapp_revised=(dapp_revised+1)
					WHERE dapp_id='".$dapp_id."'";
				$this->db->query($sqlu_dapp);
				if($this->db->affected_rows()){
					return '1';
				}else{
					return '-8';
				}
				
			}else if(($kategori_nama=='Medis' || $kategori_nama =='Surgery' || $kategori_nama =='Anti Aging') && is_numeric($dokter)==true && $dokter_awal<>$dokter){
				/* ada pergantian dokter
				 * karena ada perubahan dokter, maka db.report_tindakan juga harus diupdate ==> function report_tindakan_update()
				*/
				$result_reportt_update = $this->report_tindakan_update($dokter_awal ,$dokter ,$dapp_tglreservasi_awal);
				if($result_reportt_update==1){
					//UPDATE db.appointment_detail.dapp_petugas
					$sqlu_dapp = "UPDATE appointment_detail
						SET dapp_petugas='".$dokter."'
							,dapp_update='".$app_user."'
							,dapp_date_update='".$datetime_now."'
							,dapp_revised=(dapp_revised+1)
						WHERE dapp_id='".$dapp_id."'";
					$this->db->query($sqlu_dapp);
					if($this->db->affected_rows()){
						return '1';
					}else{
						return '-2';
					}
				}else{
					//update report_tindakan ==> gagal
					return '-3';
				}
				
				
			}else if($kategori_nama=='Non Medis' && is_numeric($terapis)==true && $terapis_awal<>$terapis){
				/* ada pergantian terapis
				 * karena ada perubahan terapis, maka db.report_tindakan juga harus diupdate ==> function report_tindakan_update()
				*/
				$result_reportt_update = $this->report_tindakan_update($terapis_awal ,$terapis ,$dapp_tglreservasi_awal);
				if($result_reportt_update==1){
					//UPDATE db.appointment_detail.dapp_petugas
					$sqlu_dapp = "UPDATE appointment_detail
						SET dapp_petugas2='".$terapis."'
							,dapp_update='".$app_user."'
							,dapp_date_update='".$datetime_now."'
							,dapp_revised=(dapp_revised+1)
						WHERE dapp_id='".$dapp_id."'";
					$this->db->query($sqlu_dapp);
					if($this->db->affected_rows()){
						return '1';
					}else{
						return '-5';
					}
				}else{
					//update report_tindakan ==> gagal
					return '-4';
				}
				
			}else if($dapp_keterangan_awal<>$dapp_keterangan){
				//ada perubahan keterangan_detail
				//UPDATE db.appointment_detail.dapp_petugas
				$sqlu_dapp = "UPDATE appointment_detail
					SET dapp_keterangan='".$dapp_keterangan."'
						,dapp_update='".$app_user."'
						,dapp_date_update='".$datetime_now."'
						,dapp_revised=(dapp_revised+1)
					WHERE dapp_id='".$dapp_id."'";
				$this->db->query($sqlu_dapp);
				if($this->db->affected_rows()){
					return '1';
				}else{
					return '-7';
				}
				
			//}else if($dapp_status_awal<>$dapp_status && ($dapp_status=='jadwal ulang' || $dapp_status=='reservasi')){
			}else if($dapp_status_awal<>$dapp_status && $dapp_status=='reservasi'){
				//ada perubahan status yang bukan !='datang'
				//UPDATE db.appointment_detail.dapp_petugas
				$sqlu_dapp = "UPDATE appointment_detail
					SET dapp_status='".$dapp_status."'
						,dapp_update='".$app_user."'
						,dapp_date_update='".$datetime_now."'
						,dapp_revised=(dapp_revised+1)
					WHERE dapp_id='".$dapp_id."'";
				$this->db->query($sqlu_dapp);
				if($this->db->affected_rows()){
					return '1';
				}else{
					return '-10';
				}
				
			}
			else if($dapp_status_awal<>$dapp_status && ($dapp_status=='batal' || $dapp_status=='jadwal ulang')){
				//ada perubahan status yang bukan !='datang'
				//UPDATE db.appointment_detail.dapp_petugas
				$sqlu_dapp = "UPDATE appointment_detail
					SET dapp_status='".$dapp_status."'
						,dapp_update='".$app_user."'
						,dapp_date_update='".$datetime_now."'
						,dapp_jambatal='".$datetime_now."'
						,dapp_revised=(dapp_revised+1)
					WHERE dapp_id='".$dapp_id."'";
				$this->db->query($sqlu_dapp);
				if($this->db->affected_rows()){
					return '1';
				}else{
					return '-10';
				}
				
			}
			else if($dapp_status_awal<>$dapp_status && $dapp_status=='konfirmasi'){
				//ada perubahan status yang bukan !='datang'
				//UPDATE db.appointment_detail.dapp_petugas
				$sqlu_dapp = "UPDATE appointment_detail
					SET dapp_status='".$dapp_status."'
						,dapp_update='".$app_user."'
						,dapp_date_update='".$datetime_now."'
						,dapp_jamkonfirmasi='".$datetime_now."'
						,dapp_revised=(dapp_revised+1)
					WHERE dapp_id='".$dapp_id."'";
				$this->db->query($sqlu_dapp);
				if($this->db->affected_rows()){
					return '1';
				}else{
					return '-10';
				}
				
			}
			
			
			else{
				//ada perubahan yang tidak sesuai
				return '-6';
			}
			
		}else{
			//tidak menemukan data
			return '-1';
		}
		
	}
	
	
	function appointment_update_list_status($dapp_id, $dapp_status, $app_user){
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
					
					$dtrawat_insert = $this->tindakan_detail_insert($app_customer
															,$dapp_id
															,$dapp_perawatan
															,$dokter_id
															,$terapis_id
															,$dapp_jamreservasi
															,$kategori_nama
															,$dapp_tglreservasi
															,$dapp_keterangan
															,$dapp_status
															,$time_now
															,$app_user);
					if($dtrawat_insert==1){
						//UPDATE db.appointment_detail.dapp_status='datang', dan dapp_jamdatang=$time_now
						$sqlu_dapp = "UPDATE appointment_detail
							SET dapp_status='".$dapp_status."'
								,dapp_tgldatang='".$date_now."'
								,dapp_jamdatang='".$time_now."'
								,dapp_update='".@$_SESSION[SESSION_USERID]."'
								,dapp_date_update='".$datetime_now."'
								,dapp_revised=(dapp_revised+1)
							WHERE dapp_id='".$dapp_id."'";
						$this->db->query($sqlu_dapp);
						if($this->db->affected_rows()){
							//Counter $dokter_id / $terapis_id
							if($kategori_nama=='Medis' || $kategori_nama == 'Surgery' || $kategori_nama == 'Anti Aging'){
								//Counter $dokter_id
								$rs_dokter_counter = $this->counter_report_tindakan_karyawan($dokter_id, $dapp_tglreservasi);
								if($rs_dokter_counter==1){
									return '1';
								}else{
									return '-14';
								}
							}else if($kategori_nama=='Non Medis'){
								/* Counter $terapis_id
								* $dapp_counter = 'true'/'false' ==> return tetap '1'
							    */
								if($dapp_counter=='true'){
									$rs_terapis_counter = $this->counter_report_tindakan_karyawan($terapis_id, $dapp_tglreservasi);
									if($rs_terapis_counter==1){
										return '1';
									}else{
										return '-15';
									}
								}else{
									return '1';
								}
							}
							
						}else{
							return '-8';
						}
					}else{
						return '-7';
					}
					
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
	function appointment_create($app_customer ,$app_tanggal ,$app_cara ,$app_keterangan ,$app_cust_nama_baru ,$app_cust_telp_baru ,$app_cust_hp_baru ,$app_cust_keterangan_baru ,$app_user){
		$date_now = date('Y-m-d H:i:s');
		
		if($app_cust_nama_baru!=""){
			if($app_cust_telp_baru=="")
				$app_cust_telp_baru='0';
			if($app_cust_hp_baru=="")
				$app_cust_hp_baru='0';
			
			if($app_cust_telp_baru!='0' || $app_cust_hp_baru!='0'){
				$data_cust_baru=array(
				"cust_nama"=>$app_cust_nama_baru,
				"cust_telprumah"=>$app_cust_telp_baru,
				"cust_hp"=>$app_cust_hp_baru,
				"cust_keterangan"=>$app_cust_keterangan_baru,
				"cust_tgllahir"=>'0000-00-00',
				"cust_creator"=>$_SESSION[SESSION_USERID],
				"cust_date_create"=>$date_now,
				"cust_aktif"=>'Aktif'
				);
				$this->db->insert('customer', $data_cust_baru);
				if($this->db->affected_rows()){
					if($app_cust_telp_baru!='0')
						$sql="SELECT cust_id FROM customer WHERE cust_telprumah='$app_cust_telp_baru'";
					if($app_cust_hp_baru!='0')
						$sql="SELECT cust_id FROM customer WHERE cust_hp='$app_cust_hp_baru'";
					if($app_cust_telp_baru!='0' && $app_cust_hp_baru!='0')
						$sql="SELECT cust_id FROM customer WHERE cust_telprumah='$app_cust_telp_baru' AND cust_hp='$app_cust_hp_baru'";
					
					$rs=$this->db->query($sql);
					if($rs->num_rows()){
						$rs_record=$rs->row_array();
						$app_customer=$rs_record["cust_id"];
					}
					
					$data = array(
						"app_customer"=>$app_customer, 
						"app_tanggal"=>$app_tanggal, 
						"app_cara"=>$app_cara, 
						"app_keterangan"=>$app_keterangan,
						"app_creator"=>$app_user
					);
					$this->db->insert('appointment', $data);
					if($this->db->affected_rows())
						return '1';
					else
						return '0';
				}else{
					return '0';
				}
			}elseif($app_cust_telp_baru=='0' && $app_cust_hp_baru=='0'){
				return '3';
			}
			
			if($app_cust_telp_baru!='0')
				$sql="SELECT * FROM customer WHERE cust_telprumah='$app_cust_telp_baru'";
			if($app_cust_hp_baru!='0')
				$sql="SELECT * FROM customer WHERE cust_hp='$app_cust_hp_baru'";
			if($app_cust_telp_baru!='0' && $app_cust_hp_baru!='0')
				$sql="SELECT * FROM customer WHERE cust_telprumah='$app_cust_telp_baru' AND cust_hp='$app_cust_hp_baru'";
			
			$rs=$this->db->query($sql);
			if($rs->num_rows()){
				return '2';
			}
			
		}else{
			$data = array(
				"app_customer"=>$app_customer, 
				"app_tanggal"=>$app_tanggal, 
				"app_cara"=>$app_cara, 
				"app_keterangan"=>$app_keterangan,
				"app_creator"=>$app_user
			);
			$this->db->insert('appointment', $data);
			if($this->db->affected_rows())
				return '1';
			else
				return '0';
		}
		
	}
	
	//fcuntion for delete record
	/*function appointment_delete($pkid){
		// You could do some checkups here and return '0' or other error consts.
		// Make a single query to delete all of the appointments at the same time :
		if(sizeof($pkid)<1){
			return '0';
		} else if (sizeof($pkid) == 1){
			$query = "DELETE FROM appointment WHERE app_id = ".$pkid[0];
			$this->db->query($query);
		} else {
			$query = "DELETE FROM appointment WHERE ";
			for($i = 0; $i < sizeof($pkid); $i++){
				$query = $query . "app_id= ".$pkid[$i];
				if($i<sizeof($pkid)-1){
					$query = $query . " OR ";
				}     
			}
			$this->db->query($query);
		}
		if($this->db->affected_rows()>0)
			return '1';
		else
			return '0';
	}*/
	
	/* Delete appointment_detail */
	/*
	function appointment_delete($pkid){
		// You could do some checkups here and return '0' or other error consts.
		// Make a single query to delete all of the appointments at the same time :
		if(sizeof($pkid)<1){
			return '0';
		} else if (sizeof($pkid) == 1){
			$sql="SELECT dapp_master,dapp_petugas,dapp_petugas2,dapp_tglreservasi FROM appointment_detail WHERE dapp_id='$pkid[0]'";
			$rs=$this->db->query($sql);
			$rs_record=$rs->row_array();
			$temp_dapp_master[]=$rs_record["dapp_master"];
			$temp_dapp_petugas[]=$rs_record["dapp_petugas"];
			$temp_dapp_petugas2[]=$rs_record["dapp_petugas2"];
			$temp_dapp_tglreservasi[]=$rs_record["dapp_tglreservasi"];
			
			$query = "DELETE FROM appointment_detail WHERE dapp_id = ".$pkid[0];
			$this->db->query($query);
		} else {
			$sql="SELECT dapp_master,dapp_petugas,dapp_petugas2,dapp_tglreservasi FROM appointment_detail WHERE ";
			for($i = 0; $i < sizeof($pkid); $i++){
				$sql = $sql . "dapp_id= ".$pkid[$i];
				if($i<sizeof($pkid)-1){
					$sql = $sql . " OR ";
				}
			}
			$rs=$this->db->query($sql);
			$rs_record=$rs->row_array();
			if($rs->num_rows()>0){
				foreach($rs->result_array() as $row){
					$temp_dapp_master[]=$row["dapp_master"];
					$temp_dapp_petugas[]=$row["dapp_petugas"];
					$temp_dapp_petugas2[]=$row["dapp_petugas2"];
					$temp_dapp_tglreservasi[]=$row["dapp_tglreservasi"];
				}
			}
			
			$query = "DELETE FROM appointment_detail WHERE ";
			for($i = 0; $i < sizeof($pkid); $i++){
				$query = $query . "dapp_id= ".$pkid[$i];
				if($i<sizeof($pkid)-1){
					$query = $query . " OR ";
				}     
			}
			$this->db->query($query);
		}
		if($this->db->affected_rows()>0){
			for($i=0; $i<sizeof($temp_dapp_master); $i++){
				$sql="SELECT dapp_master FROM appointment_detail WHERE dapp_master='$temp_dapp_master[$i]'";
				$rs=$this->db->query($sql);
				if(!$rs->num_rows()){
					//DELETE table.appointment where app_id=$temp_dapp_master[$i]
					$this->db->where('app_id', $temp_dapp_master[$i]);
					$this->db->delete('appointment');
				}
			}
			//DeCOUNT table.report_tindakan where 
			for($i=0; $i<sizeof($temp_dapp_petugas); $i++){
				if($temp_dapp_petugas[$i]!=null){
					$check_tglreservasi=date('Y-m', strtotime($temp_dapp_tglreservasi[$i]));
					$sql="SELECT reportt_jmltindakan FROM report_tindakan WHERE reportt_karyawan_id='$temp_dapp_petugas[$i]' AND reportt_bln LIKE '$check_tglreservasi%'";
					$rs=$this->db->query($sql);
					$rs_record=$rs->row_array();
					if($rs->num_rows() && $rs_record["reportt_jmltindakan"]!=0){
						$data=array(
						"reportt_jmltindakan"=>$rs_record["reportt_jmltindakan"]-1
						);
						$this->db->where('reportt_karyawan_id', $temp_dapp_petugas[$i]);
						$this->db->like('reportt_bln', $check_tglreservasi);
						$this->db->update('report_tindakan',$data);
					}
				}
			}
			for($i=0; $i<sizeof($temp_dapp_petugas2); $i++){
				if($temp_dapp_petugas2[$i]!=null){
					$check_tglreservasi=date('Y-m', strtotime($temp_dapp_tglreservasi[$i]));
					$sql="SELECT reportt_jmltindakan FROM report_tindakan WHERE reportt_karyawan_id='$temp_dapp_petugas2[$i]' AND reportt_bln LIKE '$check_tglreservasi%'";
					$rs=$this->db->query($sql);
					$rs_record=$rs->row_array();
					if($rs->num_rows() && $rs_record["reportt_jmltindakan"]!=0){
						$data=array(
						"reportt_jmltindakan"=>$rs_record["reportt_jmltindakan"]-1
						);
						$this->db->where('reportt_karyawan_id', $temp_dapp_petugas2[$i]);
						$this->db->like('reportt_bln', $check_tglreservasi);
						$this->db->update('report_tindakan',$data);
					}
				}
			}
			return '1';
		}else
			return '0';
	}
	*/
	
	//function for advanced search record
	function appointment_search($app_customer ,$app_cara ,$jenis_rawat ,$app_dokter ,$app_terapis , $app_status, $app_rawat_medis, $app_rawat_nonmedis, $app_tgl_start_reservasi, $app_tgl_end_reservasi, $app_tgl_start_app, $app_tgl_end_app, $start,$end){
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
		if($app_status!=''){
			$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
			$query.= " dapp_status='".$app_status."'";
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
								,$app_status
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
								,$filter
								,$jam_awal
								,$jam_akhir){
		//full query
		if($option=='LIST'){
			if($jam_awal!=''){		
				$jam_awal=$jam_awal.':00';
			}
			if($jam_akhir!=''){	
				$jam_akhir=$jam_akhir.':00';
			}
		
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
				if($jam_awal!='' or $jam_akhir!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					if($jam_awal!='' and $jam_akhir!=''){
						$query.= " dapp_jamreservasi >= '".$jam_awal."' AND dapp_jamreservasi <= '".$jam_akhir."'";
					}else if ($jam_awal!='' and $jam_akhir==''){
						$query.= " dapp_jamreservasi >= '".$jam_awal."'";
					}else if ($jam_awal=='' and $jam_akhir!=''){
						$query.= " dapp_jamreservasi <= '".$jam_akhir."'";
					}
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
				if($jam_awal!='' or $jam_akhir!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					if($jam_awal!='' and $jam_akhir!=''){
						$query.= " dapp_jamreservasi >= '".$jam_awal."' AND dapp_jamreservasi <= '".$jam_akhir."'";
					}else if ($jam_awal!='' and $jam_akhir==''){
						$query.= " dapp_jamreservasi >= '".$jam_awal."'";
					}else if ($jam_awal=='' and $jam_akhir!=''){
						$query.= " dapp_jamreservasi <= '".$jam_akhir."'";
					}
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
				
				if($jam_awal!='' or $jam_akhir!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					if($jam_awal!='' and $jam_akhir!=''){
						$query.= " dapp_jamreservasi >= '".$jam_awal."' AND dapp_jamreservasi <= '".$jam_akhir."'";
					}else if ($jam_awal!='' and $jam_akhir==''){
						$query.= " dapp_jamreservasi >= '".$jam_awal."'";
					}else if ($jam_awal=='' and $jam_akhir!=''){
						$query.= " dapp_jamreservasi <= '".$jam_akhir."'";
					}
				}
			}
			
			// For Pilihan Tanggal Appointment di tbar dengan pilihan dokter kosong
			if($filter=="" && is_numeric($filter)==false && $tgl_app!="" && $jenis_rawat=="Medis"){
				$dt=date('Y-m-d', strtotime($tgl_app));
				$query="SELECT * FROM vu_appointment WHERE (kategori_nama='Medis' OR kategori_nama ='Surgery' OR kategori_nama = 'Anti Aging') AND dapp_tglreservasi = '$dt'";
				
				if($jam_awal!='' or $jam_akhir!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					if($jam_awal!='' and $jam_akhir!=''){
						$query.= " dapp_jamreservasi >= '".$jam_awal."' AND dapp_jamreservasi <= '".$jam_akhir."'";
					}else if ($jam_awal!='' and $jam_akhir==''){
						$query.= " dapp_jamreservasi >= '".$jam_awal."'";
					}else if ($jam_awal=='' and $jam_akhir!=''){
						$query.= " dapp_jamreservasi <= '".$jam_akhir."'";
					}
				}
			}
			
			/*  For simple search
			 *  Simple Search ==> untuk mencari data di hari ini saja
			*/
			if($filter<>'' && is_numeric($filter)==false){
				$query="SELECT * FROM vu_appointment WHERE dapp_tglreservasi='".$dt."'";
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				//search customer,perawatan,dokter,therapist
				$query .= " (cust_no LIKE '%".addslashes($filter)."%' OR cust_nama LIKE '%".addslashes($filter)."%' OR dokter_username LIKE '%".addslashes($filter)."%' OR terapis_username LIKE '%".addslashes($filter)."%')";
				
				if($jam_awal!='' or $jam_akhir!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					if($jam_awal!='' and $jam_akhir!=''){
						$query.= " dapp_jamreservasi >= '".$jam_awal."' AND dapp_jamreservasi <= '".$jam_akhir."'";
					}else if ($jam_awal!='' and $jam_akhir==''){
						$query.= " dapp_jamreservasi >= '".$jam_awal."'";
					}else if ($jam_awal=='' and $jam_akhir!=''){
						$query.= " dapp_jamreservasi <= '".$jam_akhir."'";
					}
				}
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
			if($app_status!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " dapp_status='".$app_status."'";
			};
			/*
			if($app_kategori!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " kategori_nama='".$app_kategori."'";
			};
			*/
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
										,$app_status
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
										,$filter
										,$jam_awal
										,$jam_akhir){
		
		//full query
		if($option=='LIST'){
			if($jam_awal!=''){		
				$jam_awal=$jam_awal.':00';
			}
			if($jam_akhir!=''){	
				$jam_akhir=$jam_akhir.':00';
			}
		
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
				
				if($jam_awal!='' or $jam_akhir!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					if($jam_awal!='' and $jam_akhir!=''){
						$query.= " dapp_jamreservasi >= '".$jam_awal."' AND dapp_jamreservasi <= '".$jam_akhir."'";
					}else if ($jam_awal!='' and $jam_akhir==''){
						$query.= " dapp_jamreservasi >= '".$jam_awal."'";
					}else if ($jam_awal=='' and $jam_akhir!=''){
						$query.= " dapp_jamreservasi <= '".$jam_akhir."'";
					}
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
				if($jam_awal!='' or $jam_akhir!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					if($jam_awal!='' and $jam_akhir!=''){
						$query.= " dapp_jamreservasi >= '".$jam_awal."' AND dapp_jamreservasi <= '".$jam_akhir."'";
					}else if ($jam_awal!='' and $jam_akhir==''){
						$query.= " dapp_jamreservasi >= '".$jam_awal."'";
					}else if ($jam_awal=='' and $jam_akhir!=''){
						$query.= " dapp_jamreservasi <= '".$jam_akhir."'";
					}
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
				
				if($jam_awal!='' or $jam_akhir!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					if($jam_awal!='' and $jam_akhir!=''){
						$query.= " dapp_jamreservasi >= '".$jam_awal."' AND dapp_jamreservasi <= '".$jam_akhir."'";
					}else if ($jam_awal!='' and $jam_akhir==''){
						$query.= " dapp_jamreservasi >= '".$jam_awal."'";
					}else if ($jam_awal=='' and $jam_akhir!=''){
						$query.= " dapp_jamreservasi <= '".$jam_akhir."'";
					}
				}
			}
			
			// For Pilihan Tanggal Appointment di tbar dengan pilihan dokter kosong
			if($filter=="" && is_numeric($filter)==false && $tgl_app!="" && $jenis_rawat=="Medis"){
				$dt=date('Y-m-d', strtotime($tgl_app));
				$query="SELECT * FROM vu_appointment WHERE (kategori_nama='Medis' OR kategori_nama ='Surgery' OR kategori_nama = 'Anti Aging') AND dapp_tglreservasi = '$dt'";
				
				if($jam_awal!='' or $jam_akhir!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					if($jam_awal!='' and $jam_akhir!=''){
						$query.= " dapp_jamreservasi >= '".$jam_awal."' AND dapp_jamreservasi <= '".$jam_akhir."'";
					}else if ($jam_awal!='' and $jam_akhir==''){
						$query.= " dapp_jamreservasi >= '".$jam_awal."'";
					}else if ($jam_awal=='' and $jam_akhir!=''){
						$query.= " dapp_jamreservasi <= '".$jam_akhir."'";
					}
				}
			}
			
			/*  For simple search
			 *  Simple Search ==> untuk mencari data di hari ini saja
			*/
			if($filter<>'' && is_numeric($filter)==false){
				$query="SELECT * FROM vu_appointment WHERE dapp_tglreservasi='".$dt."'";
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				//search customer,perawatan,dokter,therapist
				$query .= " (cust_no LIKE '%".addslashes($filter)."%' OR cust_nama LIKE '%".addslashes($filter)."%' OR dokter_username LIKE '%".addslashes($filter)."%' OR terapis_username LIKE '%".addslashes($filter)."%')";
				
				if($jam_awal!='' or $jam_akhir!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					if($jam_awal!='' and $jam_akhir!=''){
						$query.= " dapp_jamreservasi >= '".$jam_awal."' AND dapp_jamreservasi <= '".$jam_akhir."'";
					}else if ($jam_awal!='' and $jam_akhir==''){
						$query.= " dapp_jamreservasi >= '".$jam_awal."'";
					}else if ($jam_awal=='' and $jam_akhir!=''){
						$query.= " dapp_jamreservasi <= '".$jam_akhir."'";
					}
				}
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
			if($app_status!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " dapp_status='".$app_status."'";
			};
			/*
			if($app_kategori!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " kategori_nama='".$app_kategori."'";
			};
			*/
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