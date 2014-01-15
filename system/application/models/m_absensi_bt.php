<? /* 
	+ Module  		: absensi bt Model
	+ Description	: For record model process back-end
	+ Filename 		: M_absensi_bt.php
 	+ creator 		: Isaac
	
*/

class M_absensi_bt extends Model{
		
		//constructor
		function M_absensi_bt() {
			parent::Model();
		}
		
	function get_tahun_list($query){
		$sql=  "select distinct absensi_tahun as tahun from absensi_bt";
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
		
		
	function get_customer_list2($query,$start,$end){
		$sql="SELECT cust_id,cust_no,cust_nama,cust_tgllahir,cust_alamat,cust_telprumah,cust_point FROM customer WHERE cust_aktif='Aktif'";
		if($query<>""){
			$sql=$sql." and (cust_id = '".$query."' or cust_no like '%".$query."%' or cust_alamat like '%".$query."%' or cust_nama like '%".$query."%' or cust_telprumah like '%".$query."%' or cust_telprumah2 like '%".$query."%' or cust_telpkantor like '%".$query."%' or cust_hp like '%".$query."%' or cust_hp2 like '%".$query."%' or cust_hp3 like '%".$query."%') ";
		}
		
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
		
	function set_cust_point($cust_id){
		$sql = "SELECT cust_point from customer where cust_id='".$cust_id."' and cust_aktif!='Tidak Aktif' order by cust_id desc limit 1";
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
		function absensi_bt_list($filter,$start,$end,$tahun,$bulan){
		
			$jum_hari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
			$nama_hari = "	1 as absensi_id, 
							2 as absensi_karyawan_id, 
							'-' as absensi_bulan, 
							'-' as absensi_tahun,";
			
			for ($i=1; $i<=$jum_hari; $i++) {
				$nama_hari = $nama_hari."
				case dayname('".$tahun."-".$bulan."-".$i."') 
					when 'Monday' then 'Sen'
					when 'Tuesday' then 'Sel'
					when 'Wednesday' then 'Rab'
					when 'Thursday' then 'Kms'
					when 'Friday' then 'Jmt'
					when 'Saturday' then 'Sab'
					when 'Sunday' then 'Mgg' 
					end absensi_shift_".$i.", ";	
			}
			
			if ($jum_hari == 28) {
				$nama_hari = $nama_hari."'NA' as satu, 'NA' as dua, 'NA' tiga, 5 as absensi_keterangan, 6 as absensi_creator, 7 as absensi_date_create, 8 as absensi_update, 9 as absensi_date_update, 10 as absensi_revised, '-----Nama Hari-----' as absensi_karyawan_nama";
			} else if ($jum_hari == 29) {
				$nama_hari = $nama_hari."'NA' as satu, 'NA' as dua, 5 as absensi_keterangan, 6 as absensi_creator, 7 as absensi_date_create, 8 as absensi_update, 9 as absensi_date_update, 10 as absensi_revised, '-----Nama Hari-----' as absensi_karyawan_nama";
			} else if ($jum_hari == 30) {
				$nama_hari = $nama_hari."'NA' as satu, 5 as absensi_keterangan, 6 as absensi_creator, 7 as absensi_date_create, 8 as absensi_update, 9 as absensi_date_update, 10 as absensi_revised, '-----Nama Hari-----' as absensi_karyawan_nama";
			} else if ($jum_hari == 31) {
				$nama_hari = $nama_hari."5 as absensi_keterangan, 6 as absensi_creator, 7 as absensi_date_create, 8 as absensi_update, 9 as absensi_date_update, 10 as absensi_revised, '-----Nama Hari-----' as absensi_karyawan_nama";
			}
			
			$query = "
					SELECT ".$nama_hari."
						UNION
					SELECT absensi_bt.*, vu_karyawan.karyawan_nama as absensi_karyawan_nama FROM absensi_bt
					left join vu_karyawan on (vu_karyawan.karyawan_id = absensi_bt.absensi_karyawan_id)
					WHERE
						absensi_bulan = ".$bulan." and absensi_tahun = ".$tahun." and karyawan_aktif = 'Aktif'
					";
			
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (setsr_jenis LIKE '%".addslashes($filter)."%' OR setsr_cabang LIKE '%".addslashes($filter)."%' OR setsr_id LIKE '%".addslashes($filter)."%' OR setsr_tahun LIKE '%".addslashes($filter)."%' )";
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
		
	function absensi_bt_update($absensi_id, $absensi_shift_1,$absensi_shift_2,$absensi_shift_3,$absensi_shift_4,$absensi_shift_5,$absensi_shift_6,$absensi_shift_7,$absensi_shift_8,$absensi_shift_9,$absensi_shift_10,$absensi_shift_11,$absensi_shift_12,$absensi_shift_13,$absensi_shift_14,$absensi_shift_15,$absensi_shift_16,$absensi_shift_17,$absensi_shift_18,$absensi_shift_19,$absensi_shift_20,$absensi_shift_21,$absensi_shift_22,$absensi_shift_23,$absensi_shift_24,$absensi_shift_25,$absensi_shift_26,$absensi_shift_27,$absensi_shift_28,$absensi_shift_29,$absensi_shift_30,$absensi_shift_31){
		
		$sql="select * from absensi_bt where absensi_id = '$absensi_id'";
	
		$rs=$this->db->query($sql);
		if($rs->num_rows()){
		$data = array(
				//"setsr_id"=>$setsr_id,
				"absensi_shift_1"=>$absensi_shift_1,
				"absensi_shift_2"=>$absensi_shift_2,
				"absensi_shift_3"=>$absensi_shift_3,
				"absensi_shift_4"=>$absensi_shift_4,
				"absensi_shift_5"=>$absensi_shift_5,
				"absensi_shift_6"=>$absensi_shift_6,
				"absensi_shift_7"=>$absensi_shift_7,
				"absensi_shift_8"=>$absensi_shift_8,
				"absensi_shift_9"=>$absensi_shift_9,
				"absensi_shift_10"=>$absensi_shift_10,
				"absensi_shift_11"=>$absensi_shift_11,
				"absensi_shift_12"=>$absensi_shift_12,
				"absensi_shift_13"=>$absensi_shift_13,
				"absensi_shift_14"=>$absensi_shift_14,
				"absensi_shift_15"=>$absensi_shift_15,
				"absensi_shift_16"=>$absensi_shift_16,
				"absensi_shift_17"=>$absensi_shift_17,
				"absensi_shift_18"=>$absensi_shift_18,
				"absensi_shift_19"=>$absensi_shift_19,
				"absensi_shift_20"=>$absensi_shift_20,
				"absensi_shift_21"=>$absensi_shift_21,
				"absensi_shift_22"=>$absensi_shift_22,
				"absensi_shift_23"=>$absensi_shift_23,
				"absensi_shift_24"=>$absensi_shift_24,
				"absensi_shift_25"=>$absensi_shift_25,
				"absensi_shift_26"=>$absensi_shift_26,
				"absensi_shift_27"=>$absensi_shift_27,
				"absensi_shift_28"=>$absensi_shift_28,
				"absensi_shift_29"=>$absensi_shift_29,
				"absensi_shift_30"=>$absensi_shift_30,				
				"absensi_shift_31"=>$absensi_shift_31,
				"absensi_update"=>$_SESSION[SESSION_USERID],
				"absensi_date_update"=>date('Y-m-d H:i:s')
				
			);
			$this->db->where('absensi_id', $absensi_id);
			$this->db->update('absensi_bt', $data);
		}
			if($this->db->affected_rows())
				return '1';
			else
				return '0';
		}
		

	//function for update record
	function absensi_bt_create($absensi_bt_bulan, $absensi_bt_tahun){
			
		$datetime_now=date('Y-m-d H:i:s');
		$username = $_SESSION[SESSION_USERID];
	
		$query = "SELECT absensi_tahun, absensi_bulan, absensi_karyawan_id from absensi_bt where absensi_bulan = '".$absensi_bt_bulan."' and absensi_tahun = '".$absensi_bt_tahun."'";
		$result = $this->db->query($query);
		$nbrows = $result->num_rows();
		
		if($nbrows>0){
		// jika tahun dan bulan yang dipilih sudah ada
			$query_bt = "select karyawan_id from vu_karyawan 
						where 
							karyawan_jabatan = 7 and karyawan_aktif = 'Aktif' and
							karyawan_cabang = (select info.info_cabang from info)";
			$result_bt = $this->db->query($query_bt);
			$i=0;
			foreach($result_bt->result() as $row){
			$j=0;
			$ada=0;
			$row_bt= $result_bt->row($i);
			$karyawan_id= $row_bt->karyawan_id;	
			$i++;
			
				foreach($result->result() as $row_absen){
					$row_absensi= $result->row($j);
					$karyawan_id_absensi= $row_absensi->absensi_karyawan_id;
					$j++;
					//echo 'Pembanding: '.$karyawan_id.' ';
					//echo 'Cari: '.$karyawan_id_absensi.' ';
					
					//exit;
					if ($karyawan_id_absensi==$karyawan_id ) {
						//echo 'MASUK Pembanding: '.$karyawan_id.' ';
						//echo ' MASUKCari: '.$karyawan_id_absensi.' ';
					
						$ada = 1;
					}
				}
			
			if ($ada == 0) {
				//echo 'MASUK Pembanding: '.$karyawan_id.' ';
				//echo ' MASUKCari: '.$karyawan_id_absensi.' ';
				$data_bt = array(
					"absensi_karyawan_id"=>$karyawan_id,
					"absensi_bulan"=>$absensi_bt_bulan,	
					"absensi_tahun"=>$absensi_bt_tahun,	
					"absensi_shift_1"=>'',	
					"absensi_shift_2"=>'',	
					"absensi_shift_3"=>'',	
					"absensi_shift_4"=>'',	
					"absensi_shift_5"=>'',	
					"absensi_shift_6"=>'',	
					"absensi_shift_7"=>'',	
					"absensi_shift_8"=>'',	
					"absensi_shift_9"=>'',	
					"absensi_shift_10"=>'',	
					"absensi_shift_11"=>'',	
					"absensi_shift_12"=>'',	
					"absensi_shift_13"=>'',	
					"absensi_shift_14"=>'',	
					"absensi_shift_15"=>'',	
					"absensi_shift_16"=>'',	
					"absensi_shift_17"=>'',	
					"absensi_shift_18"=>'',	
					"absensi_shift_19"=>'',	
					"absensi_shift_20"=>'',	
					"absensi_shift_21"=>'',	
					"absensi_shift_22"=>'',	
					"absensi_shift_23"=>'',	
					"absensi_shift_24"=>'',	
					"absensi_shift_25"=>'',	
					"absensi_shift_26"=>'',	
					"absensi_shift_27"=>'',	
					"absensi_shift_28"=>'',	
					"absensi_shift_29"=>'',	
					"absensi_shift_30"=>'',	
					"absensi_shift_31"=>'',					
					"absensi_creator"=>$username,	
					"absensi_date_create"=>date('Y-m-d H:i:s')	
				);
				$this->db->insert('absensi_bt', $data_bt); 
			}
				
			
			}
			
			foreach($result->result() as $row){
				$arr[] = $row;
			}
			$jsonresult = json_encode($arr);
			return '({"total":"'.$nbrows.'","results":'.$jsonresult.'})';
		} 
			
		else {
		// jika tahun dan bulan terpilih belum ada sama sekali	
			$i=0;
			$query_bt = "select * from vu_karyawan 
						where 
							karyawan_jabatan = 7 and karyawan_aktif = 'Aktif' and
							karyawan_cabang = (select info.info_cabang from info)";
			$result_bt = $this->db->query($query_bt);
			foreach($result_bt->result() as $row){
				$row_bt= $result_bt->row($i);
				$karyawan_id= $row_bt->karyawan_id;
				$i++;
				$data_bt = array(
				"absensi_karyawan_id"=>$karyawan_id,
				"absensi_bulan"=>$absensi_bt_bulan,	
				"absensi_tahun"=>$absensi_bt_tahun,	
				"absensi_shift_1"=>'',	
				"absensi_shift_2"=>'',	
				"absensi_shift_3"=>'',	
				"absensi_shift_4"=>'',	
				"absensi_shift_5"=>'',	
				"absensi_shift_6"=>'',	
				"absensi_shift_7"=>'',	
				"absensi_shift_8"=>'',	
				"absensi_shift_9"=>'',	
				"absensi_shift_10"=>'',	
				"absensi_shift_11"=>'',	
				"absensi_shift_12"=>'',	
				"absensi_shift_13"=>'',	
				"absensi_shift_14"=>'',	
				"absensi_shift_15"=>'',	
				"absensi_shift_16"=>'',	
				"absensi_shift_17"=>'',	
				"absensi_shift_18"=>'',	
				"absensi_shift_19"=>'',	
				"absensi_shift_20"=>'',	
				"absensi_shift_21"=>'',	
				"absensi_shift_22"=>'',	
				"absensi_shift_23"=>'',	
				"absensi_shift_24"=>'',	
				"absensi_shift_25"=>'',	
				"absensi_shift_26"=>'',	
				"absensi_shift_27"=>'',	
				"absensi_shift_28"=>'',	
				"absensi_shift_29"=>'',	
				"absensi_shift_30"=>'',	
				"absensi_shift_31"=>'',					
				"absensi_creator"=>$username,	
				"absensi_date_create"=>date('Y-m-d H:i:s')	
			);
			$this->db->insert('absensi_bt', $data_bt); 
			}
				
				
		}
		
		if($this->db->affected_rows())
			return '1';
		else
			return '0';
	
	}
		
		
}
?>