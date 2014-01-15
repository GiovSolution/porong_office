<? /* 
	+ Module  		: penghangusan paket Model
	+ Description	: For record model process back-end
	+ Filename 		: penghangusan paket.php
 	+ creator 		: Fred
	
*/

class M_penghangusan_paket extends Model{
		
		//constructor
		function M_penghangusan_paket() {
			parent::Model();
		}
		
	function get_laporan($tgl_awal,$tgl_akhir,$periode,$opsi,$opsi_status,$group){
			$order_by="";
			switch($group){
				case "Tanggal": $order_by=" ORDER BY penghangusan_tanggal ASC";break;
				case "Customer": $order_by=" ORDER BY cust_id ASC";break;
				case "No Faktur": $order_by=" ORDER BY no_bukti ASC";break;
				case "Paket": $order_by=" ORDER BY paket_id ASC";break;
				case "Sales": $order_by=" ORDER BY sales ASC";break;
				case "Jenis Diskon": $order_by=" ORDER BY diskon_jenis ASC";break;
				default: $order_by=" ORDER BY no_bukti ASC";break;
			}
			
			if($opsi=='rekap'){
				if($periode=='all')
					$sql="SELECT * FROM vu_lap_penghangusan_paket ".$order_by;
				else if($periode=='bulan')
					$sql="SELECT * FROM vu_lap_penghangusan_paket WHERE date_format(penghangusan_tanggal, '%Y-%m')='".$tgl_awal."' ".$order_by;
				else if($periode=='tanggal')
					$sql="SELECT * FROM vu_lap_penghangusan_paket WHERE date_format(penghangusan_tanggal, '%Y-%m-%d')>='".$tgl_awal."' AND date_format(penghangusan_tanggal, '%Y-%m-%d')<='".$tgl_akhir."' ".$order_by;
			}
			/*
			else if($opsi=='detail'){
				if($opsi_status=='semua') {
					if($periode=='all')
						$sql="SELECT * FROM vu_detail_jual_paket WHERE jpaket_stat_dok<>'Terbuka' ".$order_by;
					else if($periode=='bulan')
						$sql="SELECT * FROM vu_detail_jual_paket WHERE jpaket_stat_dok<>'Terbuka' AND  date_format(tanggal, '%Y-%m')='".$tgl_awal."' ".$order_by;
					else if($periode=='tanggal')
						$sql="SELECT * FROM vu_detail_jual_paket WHERE jpaket_stat_dok<>'Terbuka' AND date_format(tanggal, '%Y-%m-%d')>='".$tgl_awal."' AND date_format(tanggal, '%Y-%m-%d')<='".$tgl_akhir."' ".$order_by;
				}  else if($opsi_status=='tertutup') {
					if($periode=='all')
						$sql="SELECT * FROM vu_detail_jual_paket WHERE jpaket_stat_dok='Tertutup' ".$order_by;
					else if($periode=='bulan')
						$sql="SELECT * FROM vu_detail_jual_paket WHERE jpaket_stat_dok='Tertutup' AND  date_format(tanggal, '%Y-%m')='".$tgl_awal."' ".$order_by;
					else if($periode=='tanggal')
						$sql="SELECT * FROM vu_detail_jual_paket WHERE jpaket_stat_dok='Tertutup' AND date_format(tanggal, '%Y-%m-%d')>='".$tgl_awal."' AND date_format(tanggal, '%Y-%m-%d')<='".$tgl_akhir."' ".$order_by;
				}
			}
			*/
			//echo $sql;
			
			$query=$this->db->query($sql);
			return $query->result();
		}
	
		
	function get_paket_list($query,$start,$end){
		$sql="SELECT dpaket_master
					,dpaket_paket
					,cust_id
					,cust_no
					,cust_nama
					,jpaket_tanggal
					,jpaket_nobukti
					,paket_kode
					,paket_nama
					,CONCAT((jpaket_nobukti),' - ',  paket_nama, ' (', cust_nama, ')') as paket_nama_cust
					,dpaket_id
					,dpaket_jumlah
					,dpaket_sisa_paket
					,dpaket_kadaluarsa 
					,date_add(date_format(dpaket_kadaluarsa,'%Y-%m-%d'), interval 365 day) as tanggal_hangus
				FROM detail_jual_paket 
				LEFT JOIN master_jual_paket ON(dpaket_master=jpaket_id) 
				LEFT JOIN customer ON(jpaket_cust=cust_id) 
				LEFT JOIN paket ON(dpaket_paket=paket_id) 
				WHERE dpaket_sisa_paket > 0
				AND jpaket_stat_dok='Tertutup' AND (detail_jual_paket.dpaket_kadaluarsa <= date_add(date_format(now(),'%Y-%m-%d'),INTERVAL -365 DAY))";
		if($query<>""){
			$sql=$sql." and (jpaket_nobukti like '%".$query."%' or cust_no like '%".$query."%' or paket_nama like '%".$query."%' or cust_nama like '%".$query."%') ";
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
		
	function get_info_paket_by_paket_id($query,$start,$end, $paket_id){
		$sql="SELECT dpaket_master
					,dpaket_paket
					,cust_id
					,cust_no
					,cust_nama
					,jpaket_tanggal
					,jpaket_nobukti
					,paket_kode
					,paket_nama
					,paket_id
					,CONCAT((jpaket_nobukti),' - ',  paket_nama, ' (', cust_nama, ')') as paket_nama_cust
					,dpaket_id
					,dpaket_jumlah
					,dpaket_sisa_paket
					,dpaket_kadaluarsa 
					,date_add(date_format(dpaket_kadaluarsa,'%Y-%m-%d'), interval 365 day) as tanggal_hangus
				FROM detail_jual_paket 
				LEFT JOIN master_jual_paket ON(dpaket_master=jpaket_id) 
				LEFT JOIN customer ON(jpaket_cust=cust_id) 
				LEFT JOIN paket ON(dpaket_paket=paket_id) 
				WHERE dpaket_sisa_paket > 0
				AND jpaket_stat_dok='Tertutup' AND (detail_jual_paket.dpaket_kadaluarsa <= date_add(date_format(now(),'%Y-%m-%d'),INTERVAL -365 DAY)) AND dpaket_id = '".$paket_id."'";
				
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
	function perpanjang_paket_list($filter,$start,$end){
		
			$query = "select CONCAT(customer.cust_nama, ' (', customer.cust_no, ')') as cust_display,
						CONCAT(paket.paket_nama, ' (', master_jual_paket.jpaket_nobukti, ')') as paket_display,
						penghangusan_paket.*, 
						master_jual_paket.jpaket_tanggal as jpaket_tanggal
						from penghangusan_paket
						left join detail_jual_paket on (detail_jual_paket.dpaket_id = penghangusan_paket.penghangusan_dpaket_id)
						left join master_jual_paket on (master_jual_paket.jpaket_id = detail_jual_paket.dpaket_master)
						left join customer on (customer.cust_id = master_jual_paket.jpaket_cust)
						left join paket on (paket.paket_id = detail_jual_paket.dpaket_paket)";
			
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (bank_kode LIKE '%".addslashes($filter)."%' OR bank_nama LIKE '%".addslashes($filter)."%' OR bank_norek LIKE '%".addslashes($filter)."%' OR bank_atasnama LIKE '%".addslashes($filter)."%' )";
			}
			
			$query.=" ORDER BY penghangusan_tanggal DESC";
			
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
		function perpanjang_paket_create($penghangusan_id, $penghangusan_dpaket_id, $penghangusan_tanggal, $penghangusan_keterangan, 	$perpanjang_creator, $perpanjang_date_create, $penghangusan_dpaket_master, $penghangusan_sisa_sebelum, $penghangusan_paket_id, $penghangusan_cust_id){
		
		$datetime_now=date('Y-m-d H:i:s');
		
		$sql_check = "select * from penghangusan_paket where penghangusan_dpaket_id = '$penghangusan_dpaket_id'";
		$rs = $this->db->query($sql_check);
		$rs_rows = $rs->num_rows();
		if($rs_rows>0){
			return '2';
		}
		else
		{
			$data = array(
				"penghangusan_id"=>$penghangusan_id,	
				"penghangusan_dpaket_id"=>$penghangusan_dpaket_id,	
				"penghangusan_dpaket_master"=>$penghangusan_dpaket_master,
				"penghangusan_sisa_sebelum"=>$penghangusan_sisa_sebelum,					
				"penghangusan_tanggal"=>$penghangusan_tanggal,
				"penghangusan_keterangan"=>$penghangusan_keterangan,
				"penghangusan_creator"=>$_SESSION[SESSION_USERID],
				"penghangusan_date_create"=>date('Y-m-d H:i:s')
			);
			$this->db->insert('penghangusan_paket', $data); 
			
			$data2 = array(
				"dapaket_dpaket"=>$penghangusan_dpaket_id,
				"dapaket_jpaket"=>$penghangusan_dpaket_master,
				"dapaket_paket"=>$penghangusan_paket_id,
				"dapaket_item"=>801, //ini adalah perawatan NOT AVAILABLE
				"dapaket_jenis_item"=>'perawatan',
				"dapaket_jumlah"=>$penghangusan_sisa_sebelum,
				"dapaket_cust"=>$penghangusan_cust_id,
				"dapaket_creator"=>@$_SESSION[SESSION_USERID],
				"dapaket_tgl_ambil"=>$penghangusan_tanggal,
				//"dapaket_referal"=>$dapaket_referal,
				"dapaket_keterangan"=>$penghangusan_keterangan,
				"dapaket_stat_dok"=>'Write-Off'
			);
			$this->db->insert('detail_ambil_paket', $data2); 
			
			
			$sql_sisa_paket = "UPDATE detail_jual_paket
			LEFT JOIN paket ON(dpaket_paket=paket_id)
			LEFT JOIN vu_total_ambil_paket ON(vu_total_ambil_paket.dapaket_dpaket=dpaket_id 
				AND vu_total_ambil_paket.dapaket_jpaket=detail_jual_paket.dpaket_master
				AND vu_total_ambil_paket.dapaket_paket=detail_jual_paket.dpaket_paket)
			SET dpaket_sisa_paket=((dpaket_jumlah*paket_jmlisi)- IF(isnull(vu_total_ambil_paket.total_ambil_paket),0,vu_total_ambil_paket.total_ambil_paket))
			WHERE detail_jual_paket.dpaket_id='$penghangusan_dpaket_id'
				AND detail_jual_paket.dpaket_master='$penghangusan_dpaket_master'
				AND detail_jual_paket.dpaket_paket='$penghangusan_paket_id'";
			$this->db->query($sql_sisa_paket);
			
			if($this->db->affected_rows())
				return '1';
			else
				return '0';
		}

		}
		
		

		
		
}
?>