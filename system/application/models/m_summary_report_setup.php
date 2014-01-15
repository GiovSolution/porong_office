<? /* 
	+ Module  		: summary_report_setup Model
	+ Description	: For record model process back-end
	+ Filename 		: m_summary_report_setup.php
 	+ creator 		: Fred
	
*/

class M_summary_report_setup extends Model{
		
		//constructor
		function M_summary_report_setup() {
			parent::Model();
		}
		
	function get_tahun_list($query){
		$sql=  "select distinct setsr_tahun as tahun from sr_setup";
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
		function sr_setup_list($filter,$start,$end,$tahun){
		
			$query = "SELECT * FROM sr_setup WHERE setsr_tahun='".$tahun."'";
			
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
		
	function sr_setup_update($setsr_id, $setsr_jan, $setsr_feb, $setsr_mar, $setsr_apr, $setsr_may, $setsr_jun, $setsr_jul, $setsr_aug, $setsr_sep, $setsr_oct, $setsr_nov, $setsr_dec, $setsr_update, $setsr_date_update, $setsr_revised){
		$sql="select * from sr_setup where setsr_id = '$setsr_id'";
	
		$rs=$this->db->query($sql);
		if($rs->num_rows()){
		$data = array(
				"setsr_id"=>$setsr_id,
				"setsr_jan"=>$setsr_jan,
				"setsr_feb"=>$setsr_feb,
				"setsr_mar"=>$setsr_mar,
				"setsr_apr"=>$setsr_apr,
				"setsr_may"=>$setsr_may,
				"setsr_jun"=>$setsr_jun,
				"setsr_jul"=>$setsr_jul,
				"setsr_aug"=>$setsr_aug,
				"setsr_sep"=>$setsr_sep,
				"setsr_oct"=>$setsr_oct,
				"setsr_nov"=>$setsr_nov,
				"setsr_dec"=>$setsr_dec,
				"setsr_update"=>$_SESSION[SESSION_USERID],
				"setsr_date_update"=>date('Y-m-d H:i:s')
				
			);
			$this->db->where('setsr_id', $setsr_id);
			$this->db->update('sr_setup', $data);
		}
			if($this->db->affected_rows())
				return '1';
			else
				return '0';
		}
		

	//function for update record
	function sr_setup_create($setsr_id, $setsr_cabang, $setsr_tahun, $setsr_jenis, $setsr_jan, $setsr_feb, $setsr_mar, $setsr_apr, $setsr_may, $setsr_jun, $setsr_jul, $setsr_aug, $setsr_sep, $setsr_oct, $setsr_nov, $setsr_dec, $setsr_author, $setsr_date_create, $setsr_update, $setsr_date_update, $setsr_revised){
			
		$datetime_now=date('Y-m-d H:i:s');
	
		$query = "SELECT setsr_tahun from sr_setup where setsr_tahun = '".$setsr_tahun."'";
		$result = $this->db->query($query);
		$nbrows = $result->num_rows();
		if($nbrows>0){
			foreach($result->result() as $row){
				$arr[] = $row;
			}
			$jsonresult = json_encode($arr);
			return '({"total":"'.$nbrows.'","results":'.$jsonresult.'})';
		} 
			
		else {
				
				$data = array(
				"setsr_id"=>$setsr_id,
				"setsr_cabang"=>$setsr_cabang,
				"setsr_tahun"=>$setsr_tahun,
				"setsr_jenis"=>'Kunjungan',
				"setsr_jan"=>$setsr_jan,
				"setsr_feb"=>$setsr_feb,
				"setsr_mar"=>$setsr_mar,
				"setsr_apr"=>$setsr_apr,
				"setsr_may"=>$setsr_may,
				"setsr_jun"=>$setsr_jun,
				"setsr_jul"=>$setsr_jul,
				"setsr_aug"=>$setsr_aug,
				"setsr_sep"=>$setsr_sep,
				"setsr_oct"=>$setsr_oct,
				"setsr_nov"=>$setsr_nov,
				"setsr_dec"=>$setsr_dec,
				"setsr_author"=>$_SESSION[SESSION_USERID],
				"setsr_date_create"=>date('Y-m-d H:i:s')
		);
		$this->db->insert('sr_setup', $data); 
			
		$data2 = array(
				"setsr_id"=>$setsr_id,
				"setsr_cabang"=>$setsr_cabang,
				"setsr_tahun"=>$setsr_tahun,
				"setsr_jenis"=>'Kunjungan Pria',
				"setsr_jan"=>$setsr_jan,
				"setsr_feb"=>$setsr_feb,
				"setsr_mar"=>$setsr_mar,
				"setsr_apr"=>$setsr_apr,
				"setsr_may"=>$setsr_may,
				"setsr_jun"=>$setsr_jun,
				"setsr_jul"=>$setsr_jul,
				"setsr_aug"=>$setsr_aug,
				"setsr_sep"=>$setsr_sep,
				"setsr_oct"=>$setsr_oct,
				"setsr_nov"=>$setsr_nov,
				"setsr_dec"=>$setsr_dec,
				"setsr_author"=>$_SESSION[SESSION_USERID],
				"setsr_date_create"=>date('Y-m-d H:i:s')
		);
		$this->db->insert('sr_setup', $data2); 
			
			$data3 = array(
				"setsr_id"=>$setsr_id,
				"setsr_cabang"=>$setsr_cabang,
				"setsr_tahun"=>$setsr_tahun,
				"setsr_jenis"=>'Kunjungan Wanita',
				"setsr_jan"=>$setsr_jan,
				"setsr_feb"=>$setsr_feb,
				"setsr_mar"=>$setsr_mar,
				"setsr_apr"=>$setsr_apr,
				"setsr_may"=>$setsr_may,
				"setsr_jun"=>$setsr_jun,
				"setsr_jul"=>$setsr_jul,
				"setsr_aug"=>$setsr_aug,
				"setsr_sep"=>$setsr_sep,
				"setsr_oct"=>$setsr_oct,
				"setsr_nov"=>$setsr_nov,
				"setsr_dec"=>$setsr_dec,
				"setsr_author"=>$_SESSION[SESSION_USERID],
				"setsr_date_create"=>date('Y-m-d H:i:s')
			);
			$this->db->insert('sr_setup', $data3); 
			
			$data4 = array(
				"setsr_id"=>$setsr_id,
				"setsr_cabang"=>$setsr_cabang,
				"setsr_tahun"=>$setsr_tahun,
				"setsr_jenis"=>'Customer Lama',
				"setsr_jan"=>$setsr_jan,
				"setsr_feb"=>$setsr_feb,
				"setsr_mar"=>$setsr_mar,
				"setsr_apr"=>$setsr_apr,
				"setsr_may"=>$setsr_may,
				"setsr_jun"=>$setsr_jun,
				"setsr_jul"=>$setsr_jul,
				"setsr_aug"=>$setsr_aug,
				"setsr_sep"=>$setsr_sep,
				"setsr_oct"=>$setsr_oct,
				"setsr_nov"=>$setsr_nov,
				"setsr_dec"=>$setsr_dec,
				"setsr_author"=>$_SESSION[SESSION_USERID],
				"setsr_date_create"=>date('Y-m-d H:i:s')
			);
			$this->db->insert('sr_setup', $data4); 
				
			$data5 = array(
				"setsr_id"=>$setsr_id,
				"setsr_cabang"=>$setsr_cabang,
				"setsr_tahun"=>$setsr_tahun,
				"setsr_jenis"=>'Customer Baru',
				"setsr_jan"=>$setsr_jan,
				"setsr_feb"=>$setsr_feb,
				"setsr_mar"=>$setsr_mar,
				"setsr_apr"=>$setsr_apr,
				"setsr_may"=>$setsr_may,
				"setsr_jun"=>$setsr_jun,
				"setsr_jul"=>$setsr_jul,
				"setsr_aug"=>$setsr_aug,
				"setsr_sep"=>$setsr_sep,
				"setsr_oct"=>$setsr_oct,
				"setsr_nov"=>$setsr_nov,
				"setsr_dec"=>$setsr_dec,
				"setsr_author"=>$_SESSION[SESSION_USERID],
				"setsr_date_create"=>date('Y-m-d H:i:s')
			);
			$this->db->insert('sr_setup', $data5); 
			
			$data6 = array(
				"setsr_id"=>$setsr_id,
				"setsr_cabang"=>$setsr_cabang,
				"setsr_tahun"=>$setsr_tahun,
				"setsr_jenis"=>'Member Baru',
				"setsr_jan"=>$setsr_jan,
				"setsr_feb"=>$setsr_feb,
				"setsr_mar"=>$setsr_mar,
				"setsr_apr"=>$setsr_apr,
				"setsr_may"=>$setsr_may,
				"setsr_jun"=>$setsr_jun,
				"setsr_jul"=>$setsr_jul,
				"setsr_aug"=>$setsr_aug,
				"setsr_sep"=>$setsr_sep,
				"setsr_oct"=>$setsr_oct,
				"setsr_nov"=>$setsr_nov,
				"setsr_dec"=>$setsr_dec,
				"setsr_author"=>$_SESSION[SESSION_USERID],
				"setsr_date_create"=>date('Y-m-d H:i:s')
			);
			$this->db->insert('sr_setup', $data6); 
		
			$data7 = array(
				"setsr_id"=>$setsr_id,
				"setsr_cabang"=>$setsr_cabang,
				"setsr_tahun"=>$setsr_tahun,
				"setsr_jenis"=>'Perawatan Medis (Rp)',
				"setsr_jan"=>$setsr_jan,
				"setsr_feb"=>$setsr_feb,
				"setsr_mar"=>$setsr_mar,
				"setsr_apr"=>$setsr_apr,
				"setsr_may"=>$setsr_may,
				"setsr_jun"=>$setsr_jun,
				"setsr_jul"=>$setsr_jul,
				"setsr_aug"=>$setsr_aug,
				"setsr_sep"=>$setsr_sep,
				"setsr_oct"=>$setsr_oct,
				"setsr_nov"=>$setsr_nov,
				"setsr_dec"=>$setsr_dec,
				"setsr_author"=>$_SESSION[SESSION_USERID],
				"setsr_date_create"=>date('Y-m-d H:i:s')
			);
			$this->db->insert('sr_setup', $data7);
			
			$data8 = array(
				"setsr_id"=>$setsr_id,
				"setsr_cabang"=>$setsr_cabang,
				"setsr_tahun"=>$setsr_tahun,
				"setsr_jenis"=>'Perawatan Medis (Qty)',
				"setsr_jan"=>$setsr_jan,
				"setsr_feb"=>$setsr_feb,
				"setsr_mar"=>$setsr_mar,
				"setsr_apr"=>$setsr_apr,
				"setsr_may"=>$setsr_may,
				"setsr_jun"=>$setsr_jun,
				"setsr_jul"=>$setsr_jul,
				"setsr_aug"=>$setsr_aug,
				"setsr_sep"=>$setsr_sep,
				"setsr_oct"=>$setsr_oct,
				"setsr_nov"=>$setsr_nov,
				"setsr_dec"=>$setsr_dec,
				"setsr_author"=>$_SESSION[SESSION_USERID],
				"setsr_date_create"=>date('Y-m-d H:i:s')
			);
			$this->db->insert('sr_setup', $data8);
				
			$data9 = array(
				"setsr_id"=>$setsr_id,
				"setsr_cabang"=>$setsr_cabang,
				"setsr_tahun"=>$setsr_tahun,
				"setsr_jenis"=>'Perawatan Non Medis (Rp)',
				"setsr_jan"=>$setsr_jan,
				"setsr_feb"=>$setsr_feb,
				"setsr_mar"=>$setsr_mar,
				"setsr_apr"=>$setsr_apr,
				"setsr_may"=>$setsr_may,
				"setsr_jun"=>$setsr_jun,
				"setsr_jul"=>$setsr_jul,
				"setsr_aug"=>$setsr_aug,
				"setsr_sep"=>$setsr_sep,
				"setsr_oct"=>$setsr_oct,
				"setsr_nov"=>$setsr_nov,
				"setsr_dec"=>$setsr_dec,
				"setsr_author"=>$_SESSION[SESSION_USERID],
				"setsr_date_create"=>date('Y-m-d H:i:s')
			);
			$this->db->insert('sr_setup', $data9);


			$data10 = array(
				"setsr_id"=>$setsr_id,
				"setsr_cabang"=>$setsr_cabang,
				"setsr_tahun"=>$setsr_tahun,
				"setsr_jenis"=>'Perawatan Non Medis (Qty)',
				"setsr_jan"=>$setsr_jan,
				"setsr_feb"=>$setsr_feb,
				"setsr_mar"=>$setsr_mar,
				"setsr_apr"=>$setsr_apr,
				"setsr_may"=>$setsr_may,
				"setsr_jun"=>$setsr_jun,
				"setsr_jul"=>$setsr_jul,
				"setsr_aug"=>$setsr_aug,
				"setsr_sep"=>$setsr_sep,
				"setsr_oct"=>$setsr_oct,
				"setsr_nov"=>$setsr_nov,
				"setsr_dec"=>$setsr_dec,
				"setsr_author"=>$_SESSION[SESSION_USERID],
				"setsr_date_create"=>date('Y-m-d H:i:s')
			);
			$this->db->insert('sr_setup', $data10);
			
			
			$data11 = array(
				"setsr_id"=>$setsr_id,
				"setsr_cabang"=>$setsr_cabang,
				"setsr_tahun"=>$setsr_tahun,
				"setsr_jenis"=>'Produk (Rp)',
				"setsr_jan"=>$setsr_jan,
				"setsr_feb"=>$setsr_feb,
				"setsr_mar"=>$setsr_mar,
				"setsr_apr"=>$setsr_apr,
				"setsr_may"=>$setsr_may,
				"setsr_jun"=>$setsr_jun,
				"setsr_jul"=>$setsr_jul,
				"setsr_aug"=>$setsr_aug,
				"setsr_sep"=>$setsr_sep,
				"setsr_oct"=>$setsr_oct,
				"setsr_nov"=>$setsr_nov,
				"setsr_dec"=>$setsr_dec,
				"setsr_author"=>$_SESSION[SESSION_USERID],
				"setsr_date_create"=>date('Y-m-d H:i:s')
			);
			$this->db->insert('sr_setup', $data11);
				
				
				
			$data12 = array(
				"setsr_id"=>$setsr_id,
				"setsr_cabang"=>$setsr_cabang,
				"setsr_tahun"=>$setsr_tahun,
				"setsr_jenis"=>'Produk (Qty)',
				"setsr_jan"=>$setsr_jan,
				"setsr_feb"=>$setsr_feb,
				"setsr_mar"=>$setsr_mar,
				"setsr_apr"=>$setsr_apr,
				"setsr_may"=>$setsr_may,
				"setsr_jun"=>$setsr_jun,
				"setsr_jul"=>$setsr_jul,
				"setsr_aug"=>$setsr_aug,
				"setsr_sep"=>$setsr_sep,
				"setsr_oct"=>$setsr_oct,
				"setsr_nov"=>$setsr_nov,
				"setsr_dec"=>$setsr_dec,
				"setsr_author"=>$_SESSION[SESSION_USERID],
				"setsr_date_create"=>date('Y-m-d H:i:s')
			);
			$this->db->insert('sr_setup', $data12);
			
			$data13 = array(
				"setsr_id"=>$setsr_id,
				"setsr_cabang"=>$setsr_cabang,
				"setsr_tahun"=>$setsr_tahun,
				"setsr_jenis"=>'Jum Hari Kerja',
				"setsr_jan"=>$setsr_jan,
				"setsr_feb"=>$setsr_feb,
				"setsr_mar"=>$setsr_mar,
				"setsr_apr"=>$setsr_apr,
				"setsr_may"=>$setsr_may,
				"setsr_jun"=>$setsr_jun,
				"setsr_jul"=>$setsr_jul,
				"setsr_aug"=>$setsr_aug,
				"setsr_sep"=>$setsr_sep,
				"setsr_oct"=>$setsr_oct,
				"setsr_nov"=>$setsr_nov,
				"setsr_dec"=>$setsr_dec,
				"setsr_author"=>$_SESSION[SESSION_USERID],
				"setsr_date_create"=>date('Y-m-d H:i:s')
			);
			$this->db->insert('sr_setup', $data13);
			/*
			$data14 = array(
				"setsr_id"=>$setsr_id,
				"setsr_cabang"=>$setsr_cabang,
				"setsr_tahun"=>$setsr_tahun,
				"setsr_jenis"=>'NS Bulan (Rp)',
				"setsr_jan"=>$setsr_jan,
				"setsr_feb"=>$setsr_feb,
				"setsr_mar"=>$setsr_mar,
				"setsr_apr"=>$setsr_apr,
				"setsr_may"=>$setsr_may,
				"setsr_jun"=>$setsr_jun,
				"setsr_jul"=>$setsr_jul,
				"setsr_aug"=>$setsr_aug,
				"setsr_sep"=>$setsr_sep,
				"setsr_oct"=>$setsr_oct,
				"setsr_nov"=>$setsr_nov,
				"setsr_dec"=>$setsr_dec,
				"setsr_author"=>$_SESSION[SESSION_USERID],
				"setsr_date_create"=>date('Y-m-d H:i:s')
			);
			$this->db->insert('sr_setup', $data14);
			
			$data15 = array(
				"setsr_id"=>$setsr_id,
				"setsr_cabang"=>$setsr_cabang,
				"setsr_tahun"=>$setsr_tahun,
				"setsr_jenis"=>'NS Periode (Rp)',
				"setsr_jan"=>$setsr_jan,
				"setsr_feb"=>$setsr_feb,
				"setsr_mar"=>$setsr_mar,
				"setsr_apr"=>$setsr_apr,
				"setsr_may"=>$setsr_may,
				"setsr_jun"=>$setsr_jun,
				"setsr_jul"=>$setsr_jul,
				"setsr_aug"=>$setsr_aug,
				"setsr_sep"=>$setsr_sep,
				"setsr_oct"=>$setsr_oct,
				"setsr_nov"=>$setsr_nov,
				"setsr_dec"=>$setsr_dec,
				"setsr_author"=>$_SESSION[SESSION_USERID],
				"setsr_date_create"=>date('Y-m-d H:i:s')
			);
			$this->db->insert('sr_setup', $data15);
			
			$data16 = array(
				"setsr_id"=>$setsr_id,
				"setsr_cabang"=>$setsr_cabang,
				"setsr_tahun"=>$setsr_tahun,
				"setsr_jenis"=>'NS Tahun (Rp)',
				"setsr_jan"=>$setsr_jan,
				"setsr_feb"=>$setsr_feb,
				"setsr_mar"=>$setsr_mar,
				"setsr_apr"=>$setsr_apr,
				"setsr_may"=>$setsr_may,
				"setsr_jun"=>$setsr_jun,
				"setsr_jul"=>$setsr_jul,
				"setsr_aug"=>$setsr_aug,
				"setsr_sep"=>$setsr_sep,
				"setsr_oct"=>$setsr_oct,
				"setsr_nov"=>$setsr_nov,
				"setsr_dec"=>$setsr_dec,
				"setsr_author"=>$_SESSION[SESSION_USERID],
				"setsr_date_create"=>date('Y-m-d H:i:s')
			);
			$this->db->insert('sr_setup', $data16);
			
			$data17 = array(
				"setsr_id"=>$setsr_id,
				"setsr_cabang"=>$setsr_cabang,
				"setsr_tahun"=>$setsr_tahun,
				"setsr_jenis"=>'Spending (Rp)',
				"setsr_jan"=>$setsr_jan,
				"setsr_feb"=>$setsr_feb,
				"setsr_mar"=>$setsr_mar,
				"setsr_apr"=>$setsr_apr,
				"setsr_may"=>$setsr_may,
				"setsr_jun"=>$setsr_jun,
				"setsr_jul"=>$setsr_jul,
				"setsr_aug"=>$setsr_aug,
				"setsr_sep"=>$setsr_sep,
				"setsr_oct"=>$setsr_oct,
				"setsr_nov"=>$setsr_nov,
				"setsr_dec"=>$setsr_dec,
				"setsr_author"=>$_SESSION[SESSION_USERID],
				"setsr_date_create"=>date('Y-m-d H:i:s')
			);
			$this->db->insert('sr_setup', $data17);
			*/	
				
			}
			
			if($this->db->affected_rows())
				return '1';
			else
				return '0';
	
		}
		
		
}
?>