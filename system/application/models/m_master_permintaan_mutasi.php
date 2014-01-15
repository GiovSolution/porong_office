<? /* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
    #songbee	mukhlisona@gmail.com
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: master_permintaan_mutasi Model
	+ Description	: For record model process back-end
	+ Filename 		: c_master_permintaan_mutasi.php
 	+ Author  		: 
 	+ Created on 20/Aug/2009 15:43:12
	
*/

class M_master_permintaan_mutasi extends Model{
		
		//constructor
		function M_master_permintaan_mutasi() {
			parent::Model();
		}
		
		function get_cabang(){
			$sql="SELECT info_nama FROM info";
			
			$query2=$this->db->query($sql);
            return $query2; //by isaac
		}
		
		//function for get list record
		function get_permission_op($id){
			$query = "select perm_group from vu_permissions where perm_harga = 1 and menu_id = 31 and perm_group = ".$id."";
					
			
			$result = $this->db->query($query);		
		$nbrows = $result->num_rows();
		return $nbrows;
		}
		
		/*Function utk mencari List Gudang */
	function get_gudang_list(){
		/*Jika yang login adalah Suster */
		if($_SESSION[SESSION_GROUPID]==12)
		{
			$sql = "SELECT gudang_id,gudang_nama FROM gudang WHERE gudang_aktif='Aktif' and gudang_id = 4";
		}
		/*Jika yang login adalah Terapis */
		else if($_SESSION[SESSION_GROUPID]==7){
			$sql = "SELECT gudang_id,gudang_nama FROM gudang WHERE gudang_aktif='Aktif' and gudang_id = 3";
		}
		/*Jika yang login adalah Gudang Besar */
		else if($_SESSION[SESSION_GROUPID]==23){
			$sql = "SELECT gudang_id,gudang_nama FROM gudang WHERE gudang_aktif='Aktif' and gudang_id = 1";
		}
		/*Jika yang login adalah Kasir / Apoteker */
		else if($_SESSION[SESSION_GROUPID]==4 || $_SESSION[SESSION_GROUPID]==26){
			$sql = "SELECT gudang_id,gudang_nama FROM gudang WHERE gudang_aktif='Aktif' and (gudang_id = 2 OR gudang_id = 1)";
		}
		/*Jika yang login adalah administrator*/
		else if($_SESSION[SESSION_GROUPID]==1){
			$sql = "SELECT gudang_id,gudang_nama FROM gudang WHERE gudang_aktif='Aktif'";
		}
		else
		$sql = "SELECT gudang_id,gudang_nama FROM gudang WHERE gudang_aktif='Aktif' AND gudang_nama NOT LIKE 'Gudang Temporary'";
	
		//$sql="SELECT gudang_id,gudang_nama FROM gudang WHERE gudang_aktif='Aktif'";
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
	
		
	/*Function utk mencari List Gudang Semua (Gudang Tujuan)*/
	function get_gudang_all_list(){
		$sql = "SELECT gudang_id,gudang_nama FROM gudang WHERE gudang_aktif='Aktif' AND gudang_nama NOT LIKE 'Gudang Temporary'";
	
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
		
		function get_laporan($tgl_awal,$tgl_akhir,$periode,$opsi,$group,$faktur){
			
			switch($group){
				case "Tanggal": $minta_mutasi_by=" ORDER BY tanggal";break;
				case "No Faktur": $minta_mutasi_by=" ORDER BY no_bukti";break;
				case "Produk": $minta_mutasi_by=" ORDER BY produk_kode";break;
				default: $minta_mutasi_by=" ORDER BY no_bukti";break;
			}
			
			if($opsi=='rekap'){
				if($periode=='all')
					$sql="SELECT * FROM vu_trans_order_mutasi WHERE omutasi_status<>'Batal' ".$minta_mutasi_by;
				else if($periode=='bulan')
					$sql="SELECT * FROM vu_trans_order_mutasi WHERE omutasi_status<>'Batal' AND date_format(tanggal,'%Y-%m')='".$tgl_awal."' ".$minta_mutasi_by;
				else if($periode=='tanggal')
					$sql="SELECT * FROM vu_trans_order_mutasi WHERE omutasi_status<>'Batal' AND date_format(tanggal,'%Y-%m-%d')>='".$tgl_awal."' 
							AND date_format(tanggal,'%Y-%m-%d')<='".$tgl_akhir."' ".$minta_mutasi_by;
			}else if($opsi=='detail'){
				if($periode=='all')
					$sql="SELECT * FROM vu_detail_order_mutasi WHERE omutasi_status<>'Batal' AND  ".$minta_mutasi_by;
				else if($periode=='bulan')
					$sql="SELECT * FROM vu_detail_order_mutasi WHERE omutasi_status<>'Batal' AND date_format(tanggal,'%Y-%m')='".$tgl_awal."' ".$minta_mutasi_by;
				else if($periode=='tanggal')
					$sql="SELECT * FROM vu_detail_order_mutasi WHERE omutasi_status<>'Batal' AND date_format(tanggal,'%Y-%m-%d')>='".$tgl_awal."' 
							AND date_format(tanggal,'%Y-%m-%d')<='".$tgl_akhir."' ".$minta_mutasi_by;
			}else if($opsi=='faktur'){
				$sql="SELECT DISTINCT * FROM vu_detail_order_mutasi WHERE domutasi_master='".$faktur."'";
			}
			
			$query=$this->db->query($sql);
			if($opsi=='faktur')
				return $query;
			else
				return $query->result();
		}
		
		
		function get_produk_selected_list($master_id,$selected_id,$query,$start,$end){
			$sql="SELECT distinct produk_id,produk_nama,produk_kode,kategori_nama FROM vu_produk ";
			
			if($master_id!=="")
				$sql.=" WHERE produk_id IN(SELECT domutasi_produk FROM detail_order_mutasi WHERE domutasi_master='".$master_id."')";
				
			if($selected_id!=="")
			{
				$selected_id=substr($selected_id,0,strlen($selected_id)-1);
				$sql.=(eregi("WHERE",$sql)?" OR ":" WHERE ")." produk_id IN(".$selected_id.")";
			}
			if($query!==""){
				$sql.=(eregi("WHERE",$sql)?" AND ":" WHERE ")." produk_nama like '%".$query."%' OR produk_kode like '%".$query."%'";
			}
			
			$result = $this->db->query($sql);
			$nbrows = $result->num_rows();
/*			$limit = $sql." LIMIT ".$start.",".$end;			
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
				
		function get_produk_all_list($query,$start,$end){
			
			$sql="SELECT distinct produk_id,produk_nama,produk_kode,kategori_nama FROM vu_produk
						WHERE produk_aktif='Aktif'";
			if($query!==""){
				$sql.=(eregi("WHERE",$sql)?" AND ":" WHERE ")." (produk_nama like '%".$query."%' OR produk_kode like '%".$query."%')";
			}
			
			$result = $this->db->query($sql);
			$nbrows = $result->num_rows();
/*			$limit = $sql." LIMIT ".$start.",".$end;			
			$result = $this->db->query($limit); */ 
			
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
		
			
		function get_produk_detail_list($master_id,$query,$start,$end){
			$sql="SELECT distinct produk_id,produk_nama,produk_kode,kategori_nama FROM vu_produk";
			if($master_id<>"")
				$sql.=" WHERE produk_id IN(SELECT domutasi_produk FROM detail_order_mutasi WHERE domutasi_master='".$master_id."')";
				
			/*if($query!==""){
				$sql.=(eregi("WHERE",$sql)?" AND ":" WHERE ")." produk_nama like '%".$query."%' OR produk_kode like '%".$query."%'";
			}*/
			
			$result = $this->db->query($sql);
			$nbrows = $result->num_rows();
/*			$limit = $sql." LIMIT ".$start.",".$end;			
			$result = $this->db->query($limit);*/  
			
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
			
			$sql="SELECT satuan_id,satuan_kode,satuan_nama,konversi_default FROM vu_satuan_konversi WHERE produk_aktif='Aktif'";
			
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
			$sql="SELECT satuan_id,satuan_kode,satuan_nama FROM satuan";
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
				$sql.=" WHERE satuan_id IN(SELECT domutasi_satuan FROM detail_order_mutasi WHERE domutasi_master='".$master_id."')";
			
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
		function detail_detail_minta_mutasi_list($master_id,$query,$start,$end) {
			$query = "SELECT detail_order_mutasi.domutasi_id as domutasi_id, detail_order_mutasi.domutasi_master as domutasi_master, detail_order_mutasi.domutasi_produk as domutasi_produk,detail_order_mutasi.domutasi_satuan as domutasi_satuan,
							detail_order_mutasi.domutasi_jumlah as jumlah_barang, 
							(select sum(detail_terima_beli.dterima_jumlah)
											from detail_terima_beli
											left join master_terima_beli on (master_terima_beli.terima_id = detail_terima_beli.dterima_master)
											where (master_terima_beli.terima_order = master_order_mutasi.omutasi_id) and (detail_order_mutasi.domutasi_produk = detail_terima_beli.dterima_produk)
										and (detail_order_mutasi.domutasi_satuan = detail_terima_beli.dterima_satuan) and (master_terima_beli.terima_status <> 'Batal')
											) as jumlah_terima
				FROM detail_order_mutasi
				LEFT JOIN master_order_mutasi on (master_order_mutasi.omutasi_id = detail_order_mutasi.domutasi_master)
				WHERE detail_order_mutasi.domutasi_master = '".$master_id."'
				group by domutasi_produk, domutasi_satuan
						";

			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
/*			$limit = $query." LIMIT ".$start.",".$end;			
			$result = $this->db->query($limit); */ 
			
			
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
			$query = "SELECT max(omutasi_id) as master_id from master_order_mutasi";
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

		//insert detail record
		function detail_detail_minta_mutasi_insert($array_dminta_mutasi_id
                                                 ,$domutasi_master
                                                 ,$array_dminta_mutasi_produk
                                                 ,$array_dminta_mutasi_satuan
                                                 ,$array_dminta_mutasi_jumlah ){
            
          if($domutasi_master==0){
          	 return '0';
          }else{
            $query="";
		   	for($i = 0; $i < sizeof($array_dminta_mutasi_produk); $i++){

				$data = array(
					"domutasi_master"=>$domutasi_master, 
					"domutasi_produk"=>$array_dminta_mutasi_produk[$i], 
					"domutasi_satuan"=>$array_dminta_mutasi_satuan[$i], 
					"domutasi_jumlah"=>$array_dminta_mutasi_jumlah[$i], 
				);
				
								
				if($array_dminta_mutasi_id[$i]==0){
					$this->db->insert('detail_order_mutasi', $data); 
					
					$query = $query.$this->db->insert_id();
					if($i<sizeof($array_dminta_mutasi_id)-1){
						$query = $query . ",";
					} 
					
				}else{
					$query = $query.$array_dminta_mutasi_id[$i];
					if($i<sizeof($array_dminta_mutasi_id)-1){
						$query = $query . ",";
					} 
					$this->db->where('domutasi_id', $array_dminta_mutasi_id[$i]);
					$this->db->update('detail_order_mutasi', $data);
				}
			}
			
			if($query<>""){
				$sql="DELETE FROM detail_order_mutasi WHERE  domutasi_master='".$domutasi_master."' AND
						domutasi_id NOT IN (".$query.")";
				$this->db->query($sql);
			}
			
			return $domutasi_master;
          }
		}
		//end of function
		
		//function for get list record
		function master_minta_mutasi_list($filter,$start,$end){
			$query = "SELECT * FROM vu_trans_order_mutasi";
			
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (omutasi_no LIKE '%".addslashes($filter)."%')";
			}
			
			$query.=" ORDER BY omutasi_id DESC";
			
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
		function master_minta_mutasi_update($omutasi_id ,$omutasi_no ,$omutasi_asal ,$omutasi_tujuan ,$omutasi_tanggal,$omutasi_keterangan, $omutasi_status, $cetak_order){
			$temp_kode_gudang = "";
			$barang_keluar = 0;
			if($omutasi_asal==1)
				$temp_kode_gudang = "GB";
			if($omutasi_asal==2)
				$temp_kode_gudang = "GR";
			if($omutasi_asal==3)
				$temp_kode_gudang = "KT";
			if($omutasi_asal==4)
				$temp_kode_gudang = "KS";
		
			$data = array(
				"omutasi_id"=>$omutasi_id, 
				"omutasi_no"=>$omutasi_no, 
				"omutasi_tanggal"=>$omutasi_tanggal, 
				"omutasi_keterangan"=>$omutasi_keterangan,
				"omutasi_status"=>$omutasi_status,
				"omutasi_update"=>$_SESSION[SESSION_USERID],
				"omutasi_date_update"=>date('Y-m-d H:i:s')
			);
			
			$sql="SELECT gudang_id FROM gudang WHERE gudang_id='".$omutasi_asal."'";
			$rs=$this->db->query($sql);
			if($rs->num_rows())
				$data["omutasi_asal"]=$omutasi_asal;
				
			$sql="SELECT gudang_id FROM gudang WHERE gudang_id='".$omutasi_tujuan."'";
			$rs=$this->db->query($sql);
			if($rs->num_rows())
				$data["omutasi_tujuan"]=$omutasi_tujuan;
			
			if($cetak_order==1){
				$data['omutasi_status'] = 'Tertutup';
			}
				
			$this->db->where('omutasi_id', $omutasi_id);
			$this->db->update('master_order_mutasi', $data);
			
			$sql="UPDATE master_order_mutasi SET omutasi_revised=0 WHERE omutasi_id='".$omutasi_id."' AND omutasi_revised is NULL";
			$result = $this->db->query($sql);
			
			$sql="UPDATE master_order_mutasi SET omutasi_revised=(omutasi_revised+1) WHERE omutasi_id='".$omutasi_id."'";
			$result = $this->db->query($sql);
			
			return $omutasi_id;
		}
		
		//function for create new record
		function master_minta_mutasi_create($omutasi_no ,$omutasi_asal ,$omutasi_tujuan ,$omutasi_tanggal ,$omutasi_keterangan, $omutasi_status, $cetak_order){
			$date_now=date('Y-m-d');
			
			$temp_kode_gudang = "";
			$barang_keluar = 0;
			if($omutasi_asal==1)
				$temp_kode_gudang = "GB";
			if($omutasi_asal==2)
				$temp_kode_gudang = "GR";
			if($omutasi_asal==3)
				$temp_kode_gudang = "KT";
			if($omutasi_asal==4)
				$temp_kode_gudang = "KS";
			if($omutasi_asal==99)
				$temp_kode_gudang = "GT";
			
			$minta_mutasi_tanggal_pattern=strtotime($omutasi_tanggal);
			$pattern="SMB-".$temp_kode_gudang."/".date("ym",$minta_mutasi_tanggal_pattern)."-";
			$omutasi_no=$this->m_public_function->get_kode_1('master_order_mutasi','omutasi_no',$pattern,16);
			
			$data = array(
				"omutasi_no"=>$omutasi_no, 
				"omutasi_tanggal"=>$omutasi_tanggal, 
				"omutasi_asal"=>$omutasi_asal, 
				"omutasi_tujuan"=>$omutasi_tujuan, 
				"omutasi_keterangan"=>$omutasi_keterangan,
				"omutasi_status"=>$omutasi_status,
				"omutasi_creator"=>$_SESSION[SESSION_USERID],
				"omutasi_date_create"=>date('Y-m-d H:i:s'),
				"omutasi_revised"=>0
			);
			if($cetak_order==1){
				$data['omutasi_status'] = 'Tertutup';
			}else{
				$data['omutasi_status'] = 'Terbuka';
			}
				
			$this->db->insert('master_order_mutasi', $data); 
			if($this->db->affected_rows())
				return $this->db->insert_id();
			else
				return '0';
		}
		
		//fcuntion for delete record
		function master_minta_mutasi_delete($pkid){
			if(sizeof($pkid)<1){
				return '0';
			} else if (sizeof($pkid) == 1){
				$query = "DELETE FROM master_order_mutasi WHERE omutasi_id = ".$pkid[0];
				$this->db->query($query);
			} else {
				$query = "DELETE FROM master_order_mutasi WHERE ";
				for($i = 0; $i < sizeof($pkid); $i++){
					$query = $query . "omutasi_id= ".$pkid[$i];
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
		}
		
		//function for advanced search record
		function master_minta_mutasi_search($omutasi_id,$omutasi_no ,$minta_mutasi_tgl_awal, $minta_mutasi_tgl_akhir,
										   $omutasi_keterangan, $omutasi_status,
										   $start,$end){
			//full query
			$query = "SELECT * FROM vu_trans_order_mutasi";
			
			if($omutasi_no!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " omutasi_no LIKE '%".$omutasi_no."%'";
			};
			
			if($minta_mutasi_tgl_awal!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " date_format(tanggal,'%Y-%m-%d') >='".$minta_mutasi_tgl_awal."'";
			};
			if($minta_mutasi_tgl_akhir!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " date_format(tanggal,'%Y-%m-%d') <='".$minta_mutasi_tgl_akhir."'";
			};
			if($omutasi_keterangan!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " omutasi_keterangan LIKE '%".$omutasi_keterangan."%'";
			};
			if($omutasi_status!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " omutasi_status LIKE '%".$omutasi_status."%'";
			};
			
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
		function master_minta_mutasi_print($omutasi_id,$omutasi_no ,$minta_mutasi_tgl_awal, 
											   $minta_mutasi_tgl_akhir,$omutasi_keterangan, 
											   $omutasi_status,$option,$filter){
			//full query
			$query = "SELECT * FROM vu_trans_order_mutasi";
			
			// For simple search
			if ($option=="LIST"){
				if($filter<>""){
					$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
					$query .= " (omutasi_no LIKE '%".addslashes($filter)."%')";
				}
				
			} else if($option=='SEARCH'){
				if($omutasi_no!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " omutasi_no LIKE '%".$omutasi_no."%'";
				};
				if($minta_mutasi_tgl_awal!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " date_format(tanggal,'%Y-%m-%d') >='".$minta_mutasi_tgl_awal."'";
				};
				if($minta_mutasi_tgl_akhir!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " date_format(tanggal,'%Y-%m-%d') <='".$minta_mutasi_tgl_akhir."'";
				};
				if($omutasi_keterangan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " omutasi_keterangan LIKE '%".$omutasi_keterangan."%'";
				};
				if($omutasi_status!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " omutasi_status LIKE '%".$omutasi_status."%'";
				};
				
			}
			//$this->firephp->log($query);
			
			$result = $this->db->query($query);
			
			return $result->result();
		}
		
		//function  for export to excel
		function master_minta_mutasi_export_excel($omutasi_id,$omutasi_no ,$minta_mutasi_tgl_awal, 
											   $minta_mutasi_tgl_akhir,$omutasi_keterangan, 
											   $omutasi_status,$option,$filter){
			//full query
						
			$query = "SELECT tanggal as Tanggal, no_bukti as 'No Pesanan', jumlah_barang as 'Jumlah Item',
						omutasi_keterangan as 'Keterangan' FROM vu_trans_order_mutasi";
				
			if ($option=="LIST"){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (omutasi_no LIKE '%".addslashes($filter)."%')";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($omutasi_no!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " omutasi_no LIKE '%".$omutasi_no."%'";
				};
				if($minta_mutasi_tgl_awal!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " date_format(tanggal,'%Y-%m-%d') >='".$minta_mutasi_tgl_awal."'";
				};
				if($minta_mutasi_tgl_akhir!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " date_format(tanggal,'%Y-%m-%d') <='".$minta_mutasi_tgl_akhir."'";
				};
				if($omutasi_keterangan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " omutasi_keterangan LIKE '%".$omutasi_keterangan."%'";
				};
				if($omutasi_status!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " omutasi_status LIKE '%".$omutasi_status."%'";
				};
				$result = $this->db->query($query);
			}
			return $result;
		}
		
}
?>