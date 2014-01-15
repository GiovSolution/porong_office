<? /* 	
	GIOV Solution - Keep IT Simple
*/

class M_master_minta_beli extends Model{
		
		//constructor
		function M_master_minta_beli() {
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
		
		function get_laporan($tgl_awal,$tgl_akhir,$periode,$opsi,$group,$faktur){
			
			switch($group){
				case "Tanggal": $order_by=" ORDER BY tanggal";break;
				case "Supplier": $order_by=" ORDER BY supplier_id";break;
				case "No Faktur": $order_by=" ORDER BY no_bukti";break;
				case "Produk": $order_by=" ORDER BY produk_kode";break;
				default: $order_by=" ORDER BY no_bukti";break;
			}
			
			if($opsi=='rekap'){
				if($periode=='all')
					$sql="SELECT * FROM vu_trans_order WHERE minta_status<>'Batal' ".$order_by;
				else if($periode=='bulan')
					$sql="SELECT * FROM vu_trans_order WHERE minta_status<>'Batal' AND date_format(tanggal,'%Y-%m')='".$tgl_awal."' ".$order_by;
				else if($periode=='tanggal')
					$sql="SELECT * FROM vu_trans_order WHERE minta_status<>'Batal' AND date_format(tanggal,'%Y-%m-%d')>='".$tgl_awal."' 
							AND date_format(tanggal,'%Y-%m-%d')<='".$tgl_akhir."' ".$order_by;
			}else if($opsi=='detail'){
				if($periode=='all')
					$sql="SELECT * FROM vu_detail_order_beli WHERE minta_status<>'Batal' AND  ".$order_by;
				else if($periode=='bulan')
					$sql="SELECT * FROM vu_detail_order_beli WHERE minta_status<>'Batal' AND date_format(tanggal,'%Y-%m')='".$tgl_awal."' ".$order_by;
				else if($periode=='tanggal')
					$sql="SELECT * FROM vu_detail_order_beli WHERE minta_status<>'Batal' AND date_format(tanggal,'%Y-%m-%d')>='".$tgl_awal."' 
							AND date_format(tanggal,'%Y-%m-%d')<='".$tgl_akhir."' ".$order_by;
			}else if($opsi=='faktur'){
				$sql="SELECT DISTINCT * FROM vu_detail_order_beli WHERE dminta_master='".$faktur."'";
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
				$sql.=" WHERE produk_id IN(SELECT dminta_produk FROM detail_order_beli WHERE dminta_master='".$master_id."')";
				
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
				$sql.=" WHERE produk_id IN(SELECT dminta_produk FROM detail_minta_beli WHERE dminta_master='".$master_id."')";
				
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
		
		/*Function utk mengambil harga terakhir dari pemesanan barang OP berdasarkan Tanggal terbaru yg melekat di faktur dan produk yang sama */
		function get_pp_last_price($supplier_id, $produk_id, $minta_tanggal){
			
			/*
			$sql="SELECT dminta_harga , dorder_harga_log, minta_supplier, dminta_produk
					FROM detail_minta_beli 
					LEFT JOIN master_order_beli ON (master_order_beli.minta_id = detail_order_beli.dminta_master)
					LEFT JOIN produk on (detail_order_beli.dorder_produk = produk.produk_id)
					WHERE detail_order_beli.dminta_produk = '".$produk_id."' AND master_order_beli.minta_supplier = '".$supplier_id."'
				ORDER BY detail_order_beli.dorder_harga_log DESC LIMIT 0,5";
				*/
			$sql = "SELECT * from produk
					WHERE produk_id = '".$produk_id."'
					";
				
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
				$sql.=" WHERE satuan_id IN(SELECT dminta_satuan FROM detail_minta_beli WHERE dminta_master='".$master_id."')";
			
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

		function get_gudang_list(){
			$sql="SELECT gudang_id, gudang_nama, gudang_lokasi FROM gudang where gudang_aktif='Aktif'";
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
		
		//function for detail
		//get record list
		function detail_detail_minta_beli_list($master_id,$query,$start,$end) {
			/*
			//Ini query Order Pembelian yang lama
			$query = "SELECT detail_order_beli.dminta_id as dminta_id, detail_order_beli.dminta_master as dminta_master, detail_order_beli.dminta_produk as dminta_produk,detail_order_beli.dminta_satuan as dminta_satuan,
							detail_order_beli.dminta_jumlah as jumlah_barang, detail_order_beli.dminta_harga as harga_satuan, date_format(dorder_harga_log, '%Y-%m-%d %H:%i:%s') as dorder_harga_log,
							detail_order_beli.dminta_diskon as diskon,
							(select sum(detail_terima_beli.dterima_jumlah)
											from detail_terima_beli
											left join master_terima_beli on (master_terima_beli.terima_id = detail_terima_beli.dterima_master)
											where (master_terima_beli.terima_order = master_order_beli.minta_id) and (detail_order_beli.dminta_produk = detail_terima_beli.dterima_produk)
										and (detail_order_beli.dminta_satuan = detail_terima_beli.dterima_satuan) and (master_terima_beli.terima_status <> 'Batal')
											) as jumlah_terima
				FROM detail_order_beli
				LEFT JOIN master_order_beli on (master_order_beli.minta_id = detail_order_beli.dminta_master)
				WHERE detail_order_beli.dminta_master = '".$master_id."'
				group by dminta_produk, dminta_satuan
						";
						*/
			$query = "SELECT detail_minta_beli.*, 
						produk.produk_id, produk.produk_kode, produk.produk_nama
					FROM detail_minta_beli
					LEFT JOIN master_minta_beli on (master_minta_beli.minta_id = detail_minta_beli.dminta_master)
					LEFT JOIN produk on (detail_minta_beli.dminta_produk = produk.produk_id)
					WHERE detail_minta_beli.dminta_master = '".$master_id."'
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
			$query = "SELECT max(minta_id) as master_id from master_order_beli";
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
		
		
		/*Function untuk melakukan Save Harga saja */
		function detail_save_harga_insert($array_dminta_id, $array_dorder_harga, $array_dminta_produk){
			$query="";
		   	for($i = 0; $i < sizeof($array_dminta_produk); $i++){

				$data = array(
					"dminta_harga"=>$array_dorder_harga[$i] 
				);
					
				if($array_dminta_id[$i]==0){
					$this->db->insert('detail_order_beli', $data); 
					
					$query = $query.$this->db->insert_id();
					if($i<sizeof($array_dminta_id)-1){
						$query = $query . ",";
					} 
					
				}else{
					$query = $query.$array_dminta_id[$i];
					if($i<sizeof($array_dminta_id)-1){
						$query = $query . ",";
					} 
					$this->db->where('dminta_id', $array_dminta_id[$i]);
					$this->db->update('detail_order_beli', $data);
				}
			}
				
			return '1';
			
		}
		

		//insert detail record
		function detail_detail_minta_beli_insert($array_dminta_id
                                                 ,$dminta_master
                                                 ,$array_dminta_produk
                                                 ,$array_dorder_satuan
                                                 ,$array_dorder_jumlah
                                                 ,$array_dorder_harga
                                                 ,$array_dorder_diskon
                                                 ,$array_dminta_keterangan ){
            
          if($dminta_master==0){
          	 return '0';
          }else{
            $query="";
		   	for($i = 0; $i < sizeof($array_dminta_produk); $i++){

				$data = array(
					"dminta_master"=>$dminta_master, 
					"dminta_produk"=>$array_dminta_produk[$i], 
					"dminta_satuan"=>$array_dorder_satuan[$i], 
					"dminta_jumlah"=>$array_dorder_jumlah[$i], 
					"dminta_harga"=>$array_dorder_harga[$i],
					"dminta_keterangan"=>$array_dminta_keterangan[$i]
					// "dminta_diskon"=>$array_dorder_diskon[$i] 
				);
				
								
				if($array_dminta_id[$i]==0){
					$this->db->insert('detail_minta_beli', $data); 
					
					$query = $query.$this->db->insert_id();
					if($i<sizeof($array_dminta_id)-1){
						$query = $query . ",";
					} 
					
				}else{
					$query = $query.$array_dminta_id[$i];
					if($i<sizeof($array_dminta_id)-1){
						$query = $query . ",";
					} 
					$this->db->where('dminta_id', $array_dminta_id[$i]);
					$this->db->update('detail_minta_beli', $data);
				}
			}
			
			if($query<>""){
				$sql="DELETE FROM detail_minta_beli WHERE  dminta_master='".$dminta_master."' AND
						dminta_id NOT IN (".$query.")";
				$this->db->query($sql);
			}
			
			return $dminta_master;
          }
		}
		//end of function
		
		//function for get list record
		function master_minta_beli_list($filter,$start,$end){
			$query = "SELECT master_minta_beli.*, gudang.* 
					FROM master_minta_beli
					LEFT JOIN gudang on (gudang.gudang_id = master_minta_beli.minta_gudang)
					";
			
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (minta_no LIKE '%".addslashes($filter)."%' OR 
							 minta_tanggal LIKE '%".addslashes($filter)."%' OR 
							 minta_keterangan LIKE '%".addslashes($filter)."%' )";
			}
			
			$query.=" ORDER BY minta_id DESC";
			
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
		function master_minta_beli_update($minta_id ,$minta_no ,$minta_supplier , $minta_gudang, $minta_tanggal ,$order_carabayar ,$order_diskon, $order_cashback ,
										  $order_biaya ,$order_bayar ,$minta_keterangan, $minta_status, $minta_status_acc, $cetak_minta, $minta_jenis){
			$data = array(
				"minta_id"=>$minta_id, 
				"minta_no"=>$minta_no, 
				"minta_tanggal"=>$minta_tanggal, 
				// "order_carabayar"=>$order_carabayar, 
				"minta_keterangan"=>$minta_keterangan,
				"minta_jenis"=>$minta_jenis,
				"minta_status"=>$minta_status,
				"minta_status_acc"=>$minta_status_acc,
				"minta_update"=>$_SESSION[SESSION_USERID],
				"minta_date_update"=>date('Y-m-d H:i:s')
			);
			
			/*
			if(($_SESSION[SESSION_GROUPID]==9) || ($_SESSION[SESSION_GROUPID]==1)){ 
				$data["order_diskon"]=$order_diskon;
				$data["order_cashback"]=$order_cashback;
				$data["order_biaya"]=$order_biaya; 
				$data["order_bayar"]=$order_bayar; 
			}
			*/
			
			//Cek supplier before update
			$sql="select supplier_id from supplier where supplier_id='".$minta_supplier."'";
			$query=$this->db->query($sql);
			if($query->num_rows())
				$data["minta_supplier"]=$minta_supplier;

			//Cek Gudang before update
			$sql="SELECT gudang_id FROM gudang WHERE gudang_id='".$minta_gudang."'";
			$rs=$this->db->query($sql);
			if($rs->num_rows())
				$data["minta_gudang"]=$minta_gudang;
				
			if($cetak_minta==1){
				$data['minta_status'] = 'Tertutup';
			}
				
			$this->db->where('minta_id', $minta_id);
			$this->db->update('master_minta_beli', $data);
			
			$sql="UPDATE master_minta_beli SET minta_revised=0 WHERE minta_id='".$minta_id."' AND minta_revised is NULL";
			$result = $this->db->query($sql);
			
			$sql="UPDATE master_minta_beli SET minta_revised=(minta_revised+1) WHERE minta_id='".$minta_id."'";
			$result = $this->db->query($sql);
			
			return $minta_id;
		}
		
		//function for create new record
		function master_minta_beli_create($minta_no ,$minta_supplier , $minta_gudang, $minta_tanggal ,$order_carabayar ,$order_diskon, $order_cashback ,$order_biaya ,$order_bayar ,$minta_keterangan, $minta_status, $minta_status_acc, $cetak_minta, $minta_jenis){
			$date_now=date('Y-m-d');
			//if($minta_tanggal==""){
			//	$minta_tanggal=$date_now;
			//}
			//$pattern="OP/".date("ym")."-";
			//$pattern="OP/".date("ym")."-";
			
			$minta_tanggal_pattern=strtotime($minta_tanggal);
			$pattern="PP/".date("ym",$minta_tanggal_pattern)."-";
			$minta_no=$this->m_public_function->get_kode_1('master_minta_beli','minta_no',$pattern,12);
			
			$data = array(
				"minta_no"=>$minta_no, 
				"minta_supplier"=>$minta_supplier, 
				"minta_tanggal"=>$minta_tanggal, 
				"minta_gudang"=>$minta_gudang, 
				// "order_carabayar"=>$order_carabayar, 
				"minta_keterangan"=>$minta_keterangan,
				"minta_status"=>$minta_status,
				"minta_status_acc"=>$minta_status_acc,
				"minta_jenis"=>$minta_jenis,
				"minta_creator"=>$_SESSION[SESSION_USERID],
				"minta_date_create"=>date('Y-m-d H:i:s'),
				"minta_revised"=>0
			);
			if($cetak_minta==1){
				$data['minta_status'] = 'Tertutup';
			}else{
				$data['minta_status'] = 'Terbuka';
			}
			
			/*
			if(($_SESSION[SESSION_GROUPID]==9) || ($_SESSION[SESSION_GROUPID]==1)){ 
				$data["order_diskon"]=$order_diskon;
				$data["order_cashback"]=$order_cashback;
				$data["order_biaya"]=$order_biaya; 
				$data["order_bayar"]=$order_bayar; 
			}
			*/
			
			$this->db->insert('master_minta_beli', $data); 
			if($this->db->affected_rows())
				return $this->db->insert_id();
			else
				return '0';
		}
		
		//fcuntion for delete record
		function master_minta_beli_delete($pkid){
			if(sizeof($pkid)<1){
				return '0';
			} else if (sizeof($pkid) == 1){
				$query = "DELETE FROM master_order_beli WHERE minta_id = ".$pkid[0];
				$this->db->query($query);
			} else {
				$query = "DELETE FROM master_order_beli WHERE ";
				for($i = 0; $i < sizeof($pkid); $i++){
					$query = $query . "minta_id= ".$pkid[$i];
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
		function master_minta_beli_search($minta_id,$minta_no ,$minta_supplier ,$order_tgl_awal, $order_tgl_akhir,
										   $order_carabayar,$minta_keterangan, $minta_status, $minta_status_acc,
										   $start,$end){
			//full query
			$query = "SELECT * FROM vu_trans_order";
			
			if($minta_no!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " no_bukti LIKE '%".$minta_no."%'";
			};
			if($minta_supplier!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " minta_supplier = ".$minta_supplier;
			};
			if($order_tgl_awal!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " date_format(tanggal,'%Y-%m-%d') >='".$order_tgl_awal."'";
			};
			if($order_tgl_akhir!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " date_format(tanggal,'%Y-%m-%d') <='".$order_tgl_akhir."'";
			};
			if($order_carabayar!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " order_carabayar LIKE '%".$order_carabayar."%'";
			};
			if($minta_keterangan!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " minta_keterangan LIKE '%".$minta_keterangan."%'";
			};
			if($minta_status!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " minta_status LIKE '%".$minta_status."%'";
			};
			if($minta_status_acc!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " minta_status_acc LIKE '%".$minta_status_acc."%'";
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
		function master_minta_beli_print($minta_id,$minta_no ,$minta_supplier ,$order_tgl_awal, 
											   $order_tgl_akhir,$order_carabayar,$minta_keterangan, 
											   $minta_status, $minta_status_acc,$option,$filter){
			//full query
			$query = "SELECT * FROM vu_trans_order";
			
			// For simple search
			if ($option=="LIST"){
				if($filter<>""){
					$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
					$query .= " (no_bukti LIKE '%".addslashes($filter)."%' OR 
								 supplier_nama LIKE '%".addslashes($filter)."%' OR 
								 order_carabayar LIKE '%".addslashes($filter)."%' )";
				}
				
			} else if($option=='SEARCH'){
				if($minta_no!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " no_bukti LIKE '%".$minta_no."%'";
				};
				if($minta_supplier!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " minta_supplier = ".$minta_supplier;
				};
				if($order_tgl_awal!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " date_format(tanggal,'%Y-%m-%d') >='".$order_tgl_awal."'";
				};
				if($order_tgl_akhir!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " date_format(tanggal,'%Y-%m-%d') <='".$order_tgl_akhir."'";
				};
				if($order_carabayar!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " order_carabayar LIKE '%".$order_carabayar."%'";
				};
				if($minta_keterangan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " minta_keterangan LIKE '%".$minta_keterangan."%'";
				};
				if($minta_status!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " minta_status LIKE '%".$minta_status."%'";
				};
				if($minta_status_acc!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " minta_status_acc LIKE '%".$minta_status_acc."%'";
				};
				
			}
			//$this->firephp->log($query);
			
			$result = $this->db->query($query);
			
			return $result->result();
		}
		
		//function  for export to excel
		function master_minta_beli_export_excel($minta_id,$minta_no ,$minta_supplier ,$order_tgl_awal, 
											   $order_tgl_akhir,$order_carabayar,$minta_keterangan, 
											   $minta_status, $minta_status_acc,$option,$filter){
			//full query
			/*$query = "SELECT tanggal as Tanggal, no_bukti as 'No Pesanan', supplier_nama as Supplier, jumlah_barang as 'Jumlah Item',
						total_nilai as 'Sub Total', order_diskon as 'Diskon (%)', order_cashback as 'Diskon (Rp)', order_biaya as 'Biaya (Rp)',
						total_nilai+order_biaya-order_cashback-(order_diskon*total_nilai/100) as 'Total Nilai',
						minta_keterangan as 'Keterangan' FROM vu_trans_order";*/
						
			$query = "SELECT tanggal as Tanggal, no_bukti as 'No Pesanan', supplier_nama as Supplier, jumlah_barang as 'Jumlah Item',
						order_carabayar as 'Cara Bayar',
						minta_keterangan as 'Keterangan' FROM vu_trans_order";
				
			if ($option=="LIST"){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (no_bukti LIKE '%".addslashes($filter)."%' OR 
							 supplier_nama LIKE '%".addslashes($filter)."%' OR 
							 order_carabayar LIKE '%".addslashes($filter)."%' )";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($minta_no!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " no_bukti LIKE '%".$minta_no."%'";
				};
				if($minta_supplier!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " minta_supplier = ".$minta_supplier;
				};
				if($order_tgl_awal!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " date_format(tanggal,'%Y-%m-%d') >='".$order_tgl_awal."'";
				};
				if($order_tgl_akhir!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " date_format(tanggal,'%Y-%m-%d') <='".$order_tgl_akhir."'";
				};
				if($order_carabayar!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " order_carabayar LIKE '%".$order_carabayar."%'";
				};
				if($minta_keterangan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " minta_keterangan LIKE '%".$minta_keterangan."%'";
				};
				if($minta_status!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " minta_status LIKE '%".$minta_status."%'";
				};
				if($minta_status_acc!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " minta_status_acc LIKE '%".$minta_status_acc."%'";
				};
				$result = $this->db->query($query);
			}
			return $result;
		}
		
}
?>