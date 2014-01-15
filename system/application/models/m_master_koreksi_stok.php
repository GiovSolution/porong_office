<? /* 	
	Miracle IT Team
*/

class M_master_koreksi_stok extends Model{
		
		//constructor
		function M_master_koreksi_stok() {
			parent::Model();
		}
		
		function get_laporan($tgl_awal,$tgl_akhir,$periode,$opsi,$group,$faktur){
			
			switch($group){
				case "Tanggal": $koreksi_by=" ORDER BY tanggal ASC";break;
				case "Gudang": $koreksi_by=" ORDER BY gudang_id ASC";break;
				case "No Bukti": $koreksi_by=" ORDER BY no_bukti ASC";break;
				case "Produk": $koreksi_by=" ORDER BY produk_id ASC";break;
				default: $koreksi_by=" ORDER BY no_bukti ASC";break;
			}
			
			if($opsi=='rekap'){
				if($periode=='all')
					$sql="SELECT * FROM vu_trans_koreksi WHERE koreksi_status='Tertutup' ".$koreksi_by;
				else if($periode=='bulan')
					$sql="SELECT * FROM vu_trans_koreksi WHERE koreksi_status='Tertutup' AND date_format(tanggal,'%Y-%m')='".$tgl_awal."' ".$koreksi_by;
				else if($periode=='tanggal')
					$sql="SELECT * FROM vu_trans_koreksi WHERE koreksi_status='Tertutup' AND date_format(tanggal,'%Y-%m-%d')>='".$tgl_awal."' 
							AND date_format(tanggal,'%Y-%m-%d')<='".$tgl_akhir."' ".$koreksi_by;
			}else if($opsi=='detail'){
				if($periode=='all')
					$sql="SELECT * FROM vu_detail_koreksi koreksi_status='Tertutup' AND  ".$koreksi_by;
				else if($periode=='bulan')
					$sql="SELECT * FROM vu_detail_koreksi WHERE koreksi_status='Tertutup' AND date_format(tanggal,'%Y-%m')='".$tgl_awal."' ".$koreksi_by;
				else if($periode=='tanggal')
					$sql="SELECT * FROM vu_detail_koreksi WHERE koreksi_status='Tertutup' AND date_format(tanggal,'%Y-%m-%d')>='".$tgl_awal."' 
							AND date_format(tanggal,'%Y-%m-%d')<='".$tgl_akhir."' ".$koreksi_by;
			}else if($opsi=='faktur'){
				$sql="SELECT * FROM vu_detail_koreksi WHERE dkoreksi_master='".$faktur."'";
			}
			$query=$this->db->query($sql);
			
			if($opsi=='faktur')
				return $query;
			else
				return $query->result();
		}
		
		function get_stok_produk_selected($gudang,$produk_id,$tanggal){
			/*if($gudang==1){
				$sql="SELECT distinct produk_id,produk_kode,produk_nama,jumlah_stok,satuan_kode,satuan_id, satuan_nama FROM vu_stok_gudang_besar_saldo 
						WHERE produk_id='".$produk_id."'";
			}elseif($gudang==2){
				$sql="SELECT distinct produk_id,produk_kode,produk_nama,jumlah_stok,satuan_kode,satuan_id, satuan_nama FROM vu_stok_gudang_produk_saldo
					WHERE produk_id='".$produk_id."'";
			}else{
				$sql="SELECT distinct produk_id,produk_kode,produk_nama,jumlah_stok,satuan_kode,satuan_id, satuan_nama FROM vu_stok_gudang_all";
				$sql.=(eregi("WHERE",$sql)?" AND ":" WHERE ")." gudang_id ='".$gudang."' AND produk_id='".$produk_id."'";
			}*/
			
			$sql="SELECT 	produk_id, satuan_id, sum(jml_terima_barang*konversi_nilai)
										+sum(jml_terima_bonus*konversi_nilai)
										-sum(jml_retur_beli*konversi_nilai)
										-sum(jml_mutasi_keluar*konversi_nilai)
										+sum(jml_mutasi_masuk*konversi_nilai)
										+sum(jml_koreksi_stok*konversi_nilai)
										-sum(jml_jual_produk*konversi_nilai)
										-sum(jml_jual_grooming*konversi_nilai)
										+sum(jml_retur_produk*konversi_nilai)
										+sum(jml_retur_paket*konversi_nilai)
										-sum(jml_pakai_cabin*konversi_nilai)
										as jumlah_stok
								FROM	vu_stok_new_produk
								WHERE   produk_id='".$produk_id."'
										AND gudang='".$gudang."'
										AND status='Tertutup'
										AND date_format(tanggal,'%Y-%m-%d') < '".$tanggal."'
								GROUP BY produk_id";
			//echo $sql;
			
			$result = $this->db->query($sql);
			$nbrows = $result->num_rows();
			
			if($nbrows<1){
				$sql="SELECT distinct produk_id,produk_kode,produk_nama,0 as jumlah_stok,satuan_kode,satuan_id, satuan_nama 
						FROM vu_produk_satuan_terkecil
						WHERE produk_id='".$produk_id."'";
				$result = $this->db->query($sql);
				$nbrows = $result->num_rows();
			}
			
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
		
		
		function get_produk_selected_list($gudang,$selected_id,$query,$start,$end){
			/*if($gudang==1){
				$sql="SELECT distinct produk_id,produk_kode,produk_nama,jumlah_stok,satuan_kode, satuan_nama FROM vu_stok_gudang_besar_saldo";
			}elseif($gudang==2){
				$sql="SELECT distinct produk_id,produk_kode,produk_nama,jumlah_stok,satuan_kode, satuan_nama FROM vu_stok_gudang_produk_saldo";
			}else{
				$sql="SELECT distinct produk_id,produk_kode,produk_nama,jumlah_stok,satuan_kode, satuan_nama FROM vu_stok_gudang_all";
				$sql.=(eregi("WHERE",$sql)?" AND ":" WHERE ")." gudang_id =".$gudang."";
			}*/
			$sql="SELECT distinct produk_id,produk_kode,produk_nama,satuan_kode, satuan_nama FROM vu_produk_satuan_default WHERE produk_aktif='Aktif'";
			if($selected_id!=="")
			{
				$selected_id=substr($selected_id,0,strlen($selected_id)-1);
				$sql.=(eregi("WHERE",$sql)?" AND ":" WHERE ")." produk_id IN(".$selected_id.")";
			}
			/*if($query!==""){
				$sql.=(eregi("WHERE",$sql)?" AND ":" WHERE ")." produk_nama like '%".$query."%' OR produk_kode like '%".$query."%'";
			}*/
			
			$result = $this->db->query($sql);
			$nbrows = $result->num_rows();
/*			$limit = $sql." LIMIT ".$start.",".$end;			
			$result = $this->db->query($limit);  */
			
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
				
		function get_produk_all_list($gudang,$selected_id,$query,$start,$end){
			
			/*if($gudang==1){
				$sql="SELECT distinct produk_id,produk_kode,produk_nama,satuan_kode, satuan_nama,satuan_id,jumlah_stok FROM vu_stok_gudang_besar_saldo";
			}elseif($gudang==2){
				$sql="SELECT distinct produk_id,produk_kode,produk_nama,satuan_kode, satuan_nama,satuan_id,jumlah_stok FROM vu_stok_gudang_produk_saldo";
			}else{
				$sql="SELECT distinct produk_id,produk_kode,produk_nama,satuan_kode, satuan_nama,satuan_id,jumlah_stok FROM vu_stok_gudang_all";
				$sql.=(eregi("WHERE",$sql)?" AND ":" WHERE ")." gudang_id =".$gudang."";
			}
			if($query!==""){
				$sql.=(eregi("WHERE",$sql)?" AND ":" WHERE ")." produk_nama like '%".$query."%' OR produk_kode like '%".$query."%'";
			}*/
			$sql="SELECT distinct produk_id,produk_kode,produk_nama,satuan_kode, satuan_nama FROM vu_produk_satuan_default WHERE produk_aktif='Aktif'";
			if($query!==""){
				$sql.=(eregi("WHERE",$sql)?" AND ":" WHERE ")." produk_nama like '%".$query."%' OR produk_kode like '%".$query."%'";
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
		
			
		function get_produk_detail_list($gudang,$master_id,$query,$start,$end){
			/*if($gudang==1){
				$sql="SELECT distinct produk_id,produk_kode,produk_nama,jumlah_stok,satuan_kode, satuan_nama FROM vu_stok_gudang_besar_saldo";
			}elseif($gudang==2){
				$sql="SELECT distinct produk_id,produk_kode,produk_nama,jumlah_stok,satuan_kode, satuan_nama FROM vu_stok_gudang_produk_saldo";
			}else{
				$sql="SELECT distinct produk_id,produk_kode,produk_nama,jumlah_stok,satuan_kode, satuan_nama FROM vu_stok_gudang_all";
				$sql.=(eregi("WHERE",$sql)?" AND ":" WHERE ")." gudang_id =".$gudang."";
			}
			*/
			
			$sql="SELECT distinct produk_id,produk_kode,produk_nama,satuan_kode, satuan_nama FROM vu_produk_satuan_default";
			
			if($master_id<>""){
				$sql.=(eregi("WHERE",$sql)?" AND ":" WHERE ");
				$sql.=" produk_id IN(SELECT dkoreksi_produk FROM detail_koreksi_stok WHERE dkoreksi_master='".$master_id."') ORDER by produk_id ASC";
			}
			
			/*if($query!==""){
				$sql.=(eregi("WHERE",$sql)?" AND ":" WHERE ")." produk_nama like '%".$query."%' OR produk_kode like '%".$query."%'";
			}*/
			
			$result = $this->db->query($sql);
			$nbrows = $result->num_rows();
			/*$limit = $sql." LIMIT ".$start.",".$end;			
			$result = $this->db->query($limit);  
			*/
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
		
		function get_satuan_produk_list($selected_id){
			
			$sql="SELECT satuan_id,satuan_kode,satuan_nama,konversi_nilai FROM vu_satuan_konversi WHERE produk_aktif='Aktif'";
			
			if($selected_id!==""){
				$sql.=(eregi("WHERE",$sql)?" AND ":" WHERE ")." produk_id='".$selected_id."'";
			}
			
			$result = $this->db->query($sql);
			$nbrows = $result->num_rows();
			
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
		
		function get_satuan_selected_list($selected_id){
			$sql="SELECT satuan_id,satuan_kode,satuan_nama,konversi_nilai FROM vu_satuan_konversi";
			
			if($selected_id!=="")
			{
				$selected_id=substr($selected_id,0,strlen($selected_id)-1);
				$sql.=" WHERE satuan_id IN(".$selected_id.")";
			}
			
			$result = $this->db->query($sql);
			$nbrows = $result->num_rows();
			
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
		
		function get_satuan_detail_list($master_id){
			$sql="SELECT satuan_id,satuan_kode,satuan_nama FROM satuan";
			if($master_id<>"")
				$sql.=" WHERE satuan_id IN(SELECT dkoreksi_satuan FROM detail_koreksi_stok WHERE dkoreksi_master='".$master_id."')";
			
			$result = $this->db->query($sql);
			$nbrows = $result->num_rows();
			
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
		
		//function for detail
		//get record list
		function detail_detail_koreksi_stok_list($master_id,$query,$start,$end) {
							
			$query = "SELECT dkoreksi_id,dkoreksi_master,dkoreksi_produk,dkoreksi_satuan,dkoreksi_jmlawal,dkoreksi_jmlkoreksi,dkoreksi_jmlsaldo,
						dkoreksi_ket FROM detail_koreksi_stok 
						WHERE dkoreksi_master='".$master_id."' AND dkoreksi_produk<>0 ORDER by dkoreksi_produk ASC";
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
/*			$limit = $query." LIMIT ".$start.",".$end;			
			$result = $this->db->query($limit);  
			*/
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
			$query = "SELECT max(koreksi_id) as master_id from master_koreksi_stok";
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
		function detail_detail_koreksi_stok_purge($master_id){
			$sql="DELETE from detail_koreksi_stok where dkoreksi_master='".$master_id."'";
			$result=$this->db->query($sql);
		}
		//*eof
		
		//insert detail record
		function detail_detail_koreksi_stok_insert($array_dkoreksi_id ,$dkoreksi_master ,$array_dkoreksi_produk ,$array_dkoreksi_satuan ,
												   $array_dkoreksi_jmlawal ,$array_dkoreksi_jmlkoreksi ,$array_dkoreksi_jmlsaldo ,
												   $array_dkoreksi_ket ){
			
			$query="";
			for($i = 0; $i < sizeof($array_dkoreksi_produk); $i++){

				$data = array(
					"dkoreksi_master"=>$dkoreksi_master, 
					"dkoreksi_produk"=>$array_dkoreksi_produk[$i], 
					"dkoreksi_satuan"=>$array_dkoreksi_satuan[$i], 
					"dkoreksi_jmlawal"=>$array_dkoreksi_jmlawal[$i], 
					"dkoreksi_jmlkoreksi"=>$array_dkoreksi_jmlkoreksi[$i], 
					"dkoreksi_jmlsaldo"=>$array_dkoreksi_jmlsaldo[$i],
					"dkoreksi_ket"=>$array_dkoreksi_ket[$i]
				);
				
				if($array_dkoreksi_id[$i]==0){
					$this->db->insert('detail_koreksi_stok', $data); 
					
					$query = $query.$this->db->insert_id();
					if($i<sizeof($array_dkoreksi_id)-1){
						$query = $query . ",";
					}
					
				}else{
					$query = $query.$array_dkoreksi_id[$i];
					if($i<sizeof($array_dkoreksi_id)-1){
						$query = $query . ",";
					} 
					
					$this->db->where('dkoreksi_id', $array_dkoreksi_id[$i]);
					$this->db->update('detail_koreksi_stok', $data);
				}
			}
			
			/*
			if($query<>""){
				$sql="DELETE FROM detail_koreksi_stok WHERE  dkoreksi_master='".$dkoreksi_master."' AND
						dkoreksi_id NOT IN (".$query.")";
				$this->db->query($sql);
			}
			*/
			
			return '1';

		}
		//end of function
		
		//function for get list record
		function master_koreksi_stok_list($filter,$start,$end){
			$query = "SELECT distinct * FROM master_koreksi_stok
						LEFT JOIN gudang on(master_koreksi_stok.koreksi_gudang=gudang.gudang_id)";
			
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (koreksi_no LIKE '%".addslashes($filter)."%' OR 
							gudang_nama LIKE '%".addslashes($filter)."%' OR 
							koreksi_keterangan LIKE '%".addslashes($filter)."%' )";
			}
			$query .= " order by koreksi_tanggal desc";
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
		function master_koreksi_stok_update($koreksi_id , $koreksi_no, $koreksi_gudang ,$koreksi_tanggal ,
											$koreksi_keterangan, $koreksi_status,$koreksi_cetak,
											$array_dkoreksi_id ,$array_dkoreksi_produk ,
											$array_dkoreksi_satuan ,$array_dkoreksi_jmlawal ,
											$array_dkoreksi_jmlkoreksi ,$array_dkoreksi_jmlsaldo ,
											$array_dkoreksi_ket ){
			$data = array(
				"koreksi_id"=>$koreksi_id, 
				"koreksi_no"=>$koreksi_no,
//				"koreksi_gudang"=>$koreksi_gudang, 
				"koreksi_tanggal"=>$koreksi_tanggal, 
				"koreksi_keterangan"=>$koreksi_keterangan,
				"koreksi_status"=>$koreksi_status,
				"koreksi_update"=>$_SESSION[SESSION_USERID],
				"koreksi_date_update"=>date('Y-m-d H:i:s')
			);
			$sql="SELECT gudang_id FROM gudang WHERE gudang_id='".$koreksi_gudang."'";
			$rs=$this->db->query($sql);
			if($rs->num_rows())
				$data["koreksi_gudang"]=$koreksi_gudang;
				
			if($koreksi_cetak==1){
				$data['koreksi_status'] = 'Tertutup';
			}
			
			$this->db->where('koreksi_id', $koreksi_id);
			$this->db->update('master_koreksi_stok', $data);
			
			
			$this->detail_detail_koreksi_stok_insert($array_dkoreksi_id ,$koreksi_id ,$array_dkoreksi_produk ,
														$array_dkoreksi_satuan ,$array_dkoreksi_jmlawal ,
														$array_dkoreksi_jmlkoreksi ,$array_dkoreksi_jmlsaldo ,
														$array_dkoreksi_ket );
			
			$sql="UPDATE master_koreksi_stok SET koreksi_revised=0 WHERE koreksi_id='".$koreksi_id."' AND koreksi_revised is NULL";
			$result = $this->db->query($sql);
			
			$sql="UPDATE master_koreksi_stok SET koreksi_revised=(koreksi_revised+1) WHERE koreksi_id='".$koreksi_id."'";
			$result = $this->db->query($sql);
			
			return $koreksi_id;
		}
		
		//function for create new record
		function master_koreksi_stok_create($koreksi_no, $koreksi_gudang ,$koreksi_tanggal ,$koreksi_keterangan, 
																		 $koreksi_status,$koreksi_cetak,
																		 $array_dkoreksi_id ,$array_dkoreksi_produk ,
																		$array_dkoreksi_satuan ,$array_dkoreksi_jmlawal ,
																		$array_dkoreksi_jmlkoreksi ,$array_dkoreksi_jmlsaldo ,
																		$array_dkoreksi_ket ){
			$koreksi_tanggal_pattern=strtotime($koreksi_tanggal);
			$pattern="PS/".date("ym",$koreksi_tanggal_pattern)."-";
			$koreksi_no=$this->m_public_function->get_kode_1('master_koreksi_stok','koreksi_no',$pattern,12);
			
			$data = array(
				"koreksi_no"=>$koreksi_no,
				"koreksi_gudang"=>$koreksi_gudang, 
				"koreksi_tanggal"=>$koreksi_tanggal, 
				"koreksi_keterangan"=>$koreksi_keterangan,
				"koreksi_status"=>$koreksi_status,
				"koreksi_creator"=>$_SESSION[SESSION_USERID],
				"koreksi_date_create"=>date('Y-m-d H:i:s'),
				"koreksi_revised"=>0
			);
			
			if($koreksi_cetak==1){
				$data['koreksi_status'] = 'Tertutup';
			}else{
				$data['koreksi_status'] = 'Terbuka';
			}
				
			$this->db->insert('master_koreksi_stok', $data); 
			if($this->db->affected_rows())
			{
			$dkoreksi_master_id = $this->db->insert_id();
			$this->detail_detail_koreksi_stok_insert($array_dkoreksi_id ,$dkoreksi_master_id ,$array_dkoreksi_produk ,
														$array_dkoreksi_satuan ,$array_dkoreksi_jmlawal ,
														$array_dkoreksi_jmlkoreksi ,$array_dkoreksi_jmlsaldo ,
														$array_dkoreksi_ket );
			return $dkoreksi_master_id;
				
			}
			else
				return '0';
		}
		
		//fcuntion for delete record
		function master_koreksi_stok_delete($pkid){
			// You could do some checkups here and return '0' or other error consts.
			// Make a single query to delete all of the master_koreksi_stoks at the same time :
			if(sizeof($pkid)<1){
				return '0';
			} else if (sizeof($pkid) == 1){
				$query = "DELETE master_koreksi_stok,detail_koreksi_stok  
							FROM master_koreksi_stok,detail_koreksi_stok WHERE koreksi_id=dkoreksi_master AND koreksi_id = ".$pkid[0];
				$this->db->query($query);
			} else {
				$query = "DELETE master_koreksi_stok,detail_koreksi_stok  
							FROM master_koreksi_stok,detail_koreksi_stok WHERE koreksi_id=dkoreksi_master AND (";
				for($i = 0; $i < sizeof($pkid); $i++){
					$query = $query . "koreksi_id= ".$pkid[$i];
					if($i<sizeof($pkid)-1){
						$query = $query . " OR ";
					}     
				}
				$query.=")";
				$this->db->query($query);
			}
			if($this->db->affected_rows()>0)
				return '1';
			else
				return '0';
		}
		
		//function for advanced search record
		function master_koreksi_stok_search($koreksi_id , $koreksi_no, $koreksi_gudang ,$koreksi_tgl_awal, $koreksi_tgl_akhir ,$koreksi_keterangan,
											$koreksi_status, $start,$end){
			//full query
			$query="SELECT distinct * FROM master_koreksi_stok
					LEFT JOIN gudang on(master_koreksi_stok.koreksi_gudang=gudang.gudang_id)";
			
			if($koreksi_no!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " koreksi_no LIKE '%".$koreksi_no."%'";
			};
			
			if($koreksi_gudang!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " koreksi_gudang LIKE '%".$koreksi_gudang."%'";
			};
			if($koreksi_tgl_awal!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " date_format(koreksi_tanggal, '%Y-%m-%d') >='".$koreksi_tgl_awal."'";
			};
			if($koreksi_tgl_akhir!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " date_format(koreksi_tanggal, '%Y-%m-%d') <='".$koreksi_tgl_akhir."'";
			};
			if($koreksi_keterangan!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " koreksi_keterangan LIKE '%".$koreksi_keterangan."%'";
			};
			if($koreksi_status!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " koreksi_status LIKE '%".$koreksi_status."%'";
			};
			
			$query.= " order by koreksi_tanggal desc";
			
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
		function master_koreksi_stok_print($koreksi_id , $koreksi_no, $koreksi_gudang ,$koreksi_tgl_awal, $koreksi_tgl_akhir ,$koreksi_keterangan,
											$koreksi_status ,$option,$filter){
			//full query
			$query = "SELECT distinct * FROM master_koreksi_stok,gudang WHERE koreksi_gudang=gudang_id";
			
			if($option=='LIST'){
				if ($filter<>""){
					$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
					$query .= " (koreksi_no LIKE '%".addslashes($filter)."%' OR 
								gudang_nama LIKE '%".addslashes($filter)."%' OR 
								koreksi_keterangan LIKE '%".addslashes($filter)."%' )";
				}
			} else if($option=='SEARCH'){
				
				if($koreksi_no!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " koreksi_no LIKE '%".$koreksi_no."%'";
				};
				
				if($koreksi_gudang!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " koreksi_gudang LIKE '%".$koreksi_gudang."%'";
				};
				if($koreksi_tgl_awal!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " date_format(koreksi_tanggal, '%Y-%m-%d') >='".$koreksi_tgl_awal."'";
				};
				if($koreksi_tgl_akhir!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " date_format(koreksi_tanggal, '%Y-%m-%d') <='".$koreksi_tgl_akhir."'";
				};
				if($koreksi_keterangan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " koreksi_keterangan LIKE '%".$koreksi_keterangan."%'";
				};
				if($koreksi_status!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " koreksi_status LIKE '%".$koreksi_status."%'";
				};
				
			}
			
			$result = $this->db->query($query);
			return $result->result();
		}
		
		//function  for export to excel
		function master_koreksi_stok_export_excel($koreksi_id , $koreksi_no, $koreksi_gudang ,$koreksi_tgl_awal, $koreksi_tgl_akhir ,
												  $koreksi_keterangan, $koreksi_status ,$option,$filter){
			//full query
			$query = "SELECT  koreksi_tanggal as Tanggal, koreksi_no as 'No PS', gudang_nama as Gudang, koreksi_keterangan as Keterangan, 
								koreksi_status as Status
								FROM master_koreksi_stok,gudang WHERE koreksi_gudang=gudang_id";
			if($option=='LIST'){
				if ($filter<>""){
					$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
					$query .= " (koreksi_no LIKE '%".addslashes($filter)."%' OR 
								gudang_nama LIKE '%".addslashes($filter)."%' OR 
								koreksi_keterangan LIKE '%".addslashes($filter)."%' )";
				}
			} else if($option=='SEARCH'){
				if($koreksi_no!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " koreksi_no LIKE '%".$koreksi_no."%'";
				};
				
				if($koreksi_gudang!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " koreksi_gudang LIKE '%".$koreksi_gudang."%'";
				};
				if($koreksi_tgl_awal!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " date_format(koreksi_tanggal, '%Y-%m-%d') >='".$koreksi_tgl_awal."'";
				};
				if($koreksi_tgl_akhir!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " date_format(koreksi_tanggal, '%Y-%m-%d') <='".$koreksi_tgl_akhir."'";
				};
				if($koreksi_keterangan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " koreksi_keterangan LIKE '%".$koreksi_keterangan."%'";
				};
				if($koreksi_status!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " koreksi_status LIKE '%".$koreksi_status."%'";
				};
			}
			
			$result = $this->db->query($query);
			return $result;
		}
		
}
?>