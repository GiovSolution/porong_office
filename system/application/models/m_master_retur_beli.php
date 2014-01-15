<? /* 	
	GIOV Solution - Keep IT Simple
*/

class M_master_retur_beli extends Model{
		
		//constructor
		function M_master_retur_beli() {
			parent::Model();
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
					$sql="SELECT * FROM vu_trans_retur_beli ".$order_by;
				else if($periode=='bulan')
					$sql="SELECT * FROM vu_trans_retur_beli WHERE tanggal like '".$tgl_awal."%' ".$order_by;
				else if($periode=='tanggal')
					$sql="SELECT * FROM vu_trans_retur_beli WHERE tanggal>='".$tgl_awal."' AND tanggal<='".$tgl_akhir."' ".$order_by;
			}else if($opsi=='detail'){
				if($periode=='all')
					$sql="SELECT * FROM vu_detail_retur_beli ".$order_by;
				else if($periode=='bulan')
					$sql="SELECT * FROM vu_detail_retur_beli WHERE tanggal like '".$tgl_awal."%' ".$order_by;
				else if($periode=='tanggal')
					$sql="SELECT * FROM vu_detail_retur_beli WHERE tanggal>='".$tgl_awal."' AND tanggal<='".$tgl_akhir."' ".$order_by;
			}else if($opsi=='faktur'){
				$sql="SELECT DISTINCT * FROM vu_detail_retur_beli WHERE drbeli_master='".$faktur."'";
			}
			
			$query=$this->db->query($sql);
			if($opsi=='faktur')
				return $query;
			else
				return $query->result();
		}
		
		
		function get_terima_list($query,$start,$end){
			// $sql="SELECT * from vu_trans_invoice";
			$sql = "SELECT master_terima_beli.*, 
						supplier.supplier_nama, supplier.supplier_id,
						master_order_beli.order_no
					FROM master_terima_beli
					LEFT JOIN supplier ON (master_terima_beli.terima_supplier = supplier.supplier_id)
					LEFT JOIN master_order_beli ON (master_order_beli.order_id = master_terima_beli.terima_order)
					WHERE master_terima_beli.terima_status = 'Tertutup'
					";
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
		
		function get_produk_selected_list($selected_id,$query,$start,$end){
			$sql="SELECT distinct produk_id,produk_nama,produk_kode,kategori_nama,satuan_id,satuan_nama,dinvoice_harga,
						dinvoice_diskon FROM vu_detail_invoice";
			if($selected_id!=="")
			{
				$selected_id=substr($selected_id,0,strlen($selected_id)-1);
				$sql.=" WHERE produk_id IN(".$selected_id.")";
			}
			if($query!==""){
				$sql.=(eregi("WHERE",$sql)?" AND ":" WHERE ")." produk_nama like '%".$query."%' OR produk_kode like '%".$query."%'";
			}
			
			$result = $this->db->query($sql);
			$nbrows = $result->num_rows();
		/*	$limit = $sql." LIMIT ".$start.",".$end;			
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
				
		function get_produk_all_list($terima_id, $selected_id, $query,$start,$end){
			$sql="SELECT produk_id,produk_nama,produk_kode,detail_terima_beli.dterima_jumlah 
				FROM produk
				LEFT JOIN detail_terima_beli on (detail_terima_beli.dterima_produk = produk.produk_id)
			";
			if($terima_id<>"")
				$sql.=" WHERE produk_id IN(SELECT dterima_produk FROM detail_terima_beli WHERE dterima_master='".$terima_id."')";

			if($query!==""){
				$sql.=(eregi("WHERE",$sql)?" AND ":" WHERE ")." produk_nama like '%".$query."%' OR produk_kode like '%".$query."%'";
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
				
		function get_produk_detail_list($master_id,$query,$start,$end){
			$sql="SELECT distinct produk_id,produk_nama,produk_kode,kategori_nama,satuan_id,satuan_nama,drbeli_harga, drbeli_diskon 
					FROM vu_detail_retur_beli";
			if($master_id<>"")
				$sql.=" WHERE drbeli_master='".$master_id."'";
			if($query!==""){
				$sql.=(eregi("WHERE",$sql)?" AND ":" WHERE ")." produk_nama like '%".$query."%' OR produk_kode like '%".$query."%'";
			}
			
			$result = $this->db->query($sql);
			$nbrows = $result->num_rows();
			/*$limit = $sql." LIMIT ".$start.",".$end;			
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
		
		function get_satuan_produk_list($selected_id){
			
			$sql="SELECT satuan_id,satuan_kode,satuan_nama FROM vu_satuan_konversi WHERE produk_aktif='Aktif'
					AND satuan_id in(SELECT distinct dterima_satuan FROM detail_terima_beli)";
			
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
				$sql.=" WHERE satuan_id IN(SELECT drbeli_satuan FROM detail_retur_beli WHERE drbeli_master='".$master_id."')";
			
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
		
		function get_harga_on_order($dorder_master, $dorder_produk, $dorder_satuan){
			$sql="SELECT * FROM detail_order_beli WHERE dorder_master='".$dorder_master."' AND dorder_produk='".$dorder_produk."' AND dorder_satuan='".$dorder_satuan."'";
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
		
		function get_satuan_by_produkid($dterima_master, $dterima_produk){
			if($dterima_master=="" OR $dterima_produk==""){
				$sql="SELECT * FROM detail_terima_beli,satuan WHERE dterima_satuan=satuan_id";
			}else{
				$sql="SELECT * FROM detail_terima_beli,satuan WHERE dterima_satuan=satuan_id AND dterima_master='".$dterima_master."' AND dterima_produk='".$dterima_produk."'";
			}
			/*$sql="SELECT * FROM detail_order_beli,satuan WHERE dorder_satuan=satuan_id AND dterima_master='".$dterima_master."' AND dterima_produk='".$dterima_produk."' AND dorder_master='".$dorder_master."'";*/
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
		
		function get_drbeli_by_terimabeli($terima_id){
			$sql="SELECT * FROM detail_terima_beli,produk,satuan WHERE dterima_produk=produk_id AND dterima_satuan=satuan_id AND dterima_master='".$terima_id."'";
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
		
		function get_terima_beli_list(){
			$sql="SELECT * FROM master_terima_beli,supplier WHERE terima_supplier=supplier_id";
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
		function detail_detail_retur_beli_list($master_id,$query,$start,$end) {

		$query = "SELECT drbeli_id,drbeli_master,drbeli_produk,drbeli_satuan,drbeli_jumlah,drbeli_harga,drbeli_diskon
						FROM detail_retur_beli where drbeli_master='".$master_id."'";
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
/*			if($end<=0) $end=15;
			$limit = $query." LIMIT ".$start.",".$end;			
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
		//end of function
		
		//get master id, note : not done yet
		function get_master_id() {
			$query = "SELECT max(rbeli_id) as master_id from master_retur_beli";
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
		function detail_detail_retur_beli_purge($master_id){
			$sql="DELETE from detail_retur_beli where drbeli_master='".$master_id."'";
			$result=$this->db->query($sql);
		}
		//*eof
		
		//insert detail record
		function detail_detail_retur_beli_insert($array_drbeli_id ,$drbeli_master ,$array_drbeli_produk ,$array_drbeli_satuan ,$array_drbeli_jumlah ,
												 $array_drbeli_harga, $array_drbeli_diskon ){
			
			$query="";
			for($i = 0; $i < sizeof($array_drbeli_produk); $i++){

				$data = array(
					"drbeli_master"=>$drbeli_master, 
					"drbeli_produk"=>$array_drbeli_produk[$i], 
					"drbeli_satuan"=>$array_drbeli_satuan[$i], 
					"drbeli_jumlah"=>$array_drbeli_jumlah[$i], 
					"drbeli_harga"=>$array_drbeli_harga[$i], 
					"drbeli_diskon"=>$array_drbeli_diskon[$i] 
				);
				
				if($array_drbeli_id[$i]==0){
					$this->db->insert('detail_retur_beli', $data); 
					
					$query = $query.$this->db->insert_id();
					if($i<sizeof($array_drbeli_id)-1){
						$query = $query . ",";
					}
					
				}else{
					$query = $query.$array_drbeli_id[$i];
					if($i<sizeof($array_drbeli_id)-1){
						$query = $query . ",";
					} 
					
					$this->db->where('drbeli_id', $array_drbeli_id[$i]);
					$this->db->update('detail_retur_beli', $data);
				}
			}
			
			if($query<>""){
				$sql="DELETE FROM detail_retur_beli WHERE  drbeli_master='".$drbeli_master."' AND
						drbeli_id NOT IN (".$query.")";
				$this->db->query($sql);
			}
			
			return '1';

		}
		//end of function
		
		//function for get list record
		function master_retur_beli_list($filter,$start,$end){
			$query = "SELECT * from vu_trans_retur_beli";
			
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (no_bukti LIKE '%".addslashes($filter)."%' OR
							 no_order LIKE '%".addslashes($filter)."%' OR 
							 supplier_nama LIKE '%".addslashes($filter)."%' OR 
							 no_terima LIKE '%".addslashes($filter)."%')";
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
		function master_retur_beli_update($rbeli_id ,$rbeli_nobukti ,$rbeli_terima ,$rbeli_supplier ,$rbeli_tanggal ,$rbeli_keterangan, 
										  $rbeli_status ){
			$data = array(
				"rbeli_id"=>$rbeli_id, 
				"rbeli_nobukti"=>$rbeli_nobukti, 
				"rbeli_tanggal"=>$rbeli_tanggal, 
				"rbeli_keterangan"=>$rbeli_keterangan,
				"rbeli_status"=>$rbeli_status,
				"rbeli_update"=>$_SESSION[SESSION_USERID],
				"rbeli_date_update"=>date('Y-m-d H:i:s')
			);
			$sql="SELECT supplier_id FROM supplier,master_terima_beli 
					WHERE terima_supplier=supplier_id and terima_id='".$rbeli_terima."'";
			$rs=$this->db->query($sql);
			if($rs->num_rows()){
				$ds=$rs->row();
				$data["rbeli_supplier"]=$ds->supplier_id;
			}
			
			$sql="SELECT terima_id FROM master_terima_beli WHERE terima_id='".$rbeli_terima."'";
			$rs=$this->db->query($sql);
			if($rs->num_rows())
				$data["rbeli_terima"]=$rbeli_terima;
			
			$this->db->where('rbeli_id', $rbeli_id);
			$this->db->update('master_retur_beli', $data);
			
			$sql="UPDATE master_retur_beli SET rbeli_revised=0 WHERE rbeli_id='".$rbeli_id."' AND rbeli_revised is NULL";
			$result = $this->db->query($sql);
			
			$sql="UPDATE master_retur_beli SET rbeli_revised=(rbeli_revised+1) WHERE rbeli_id='".$rbeli_id."'";
			$result = $this->db->query($sql);
			
			return $rbeli_id;;
		}
		
		//function for create new record
		function master_retur_beli_create($rbeli_nobukti ,$rbeli_terima ,$rbeli_supplier ,$rbeli_tanggal ,$rbeli_keterangan, $rbeli_status ){
			
			$pattern="RB/".date("y/m")."/";
			$rbeli_nobukti=$this->m_public_function->get_kode_1('master_retur_beli','rbeli_nobukti',$pattern,13);
			
			$data = array(
				"rbeli_nobukti"=>$rbeli_nobukti, 
				"rbeli_terima"=>$rbeli_terima, 
				"rbeli_tanggal"=>$rbeli_tanggal, 
				"rbeli_keterangan"=>$rbeli_keterangan,
				"rbeli_status"=>$rbeli_status,
				"rbeli_creator"=>$_SESSION[SESSION_USERID],
				"rbeli_date_create"=>date('Y-m-d H:i:s'),
				"rbeli_revised"=>0
			);
			$sql="SELECT supplier_id FROM supplier,master_terima_beli 
					WHERE terima_supplier=supplier_id and terima_id='".$rbeli_terima."'";
			$rs=$this->db->query($sql);
			if($rs->num_rows()){
				$ds=$rs->row();
				$data["rbeli_supplier"]=$ds->supplier_id;
			}
			
			$this->db->insert('master_retur_beli', $data); 
			if($this->db->affected_rows())
				return $this->db->insert_id();
			else
				return '0';
		}
		
		//fcuntion for delete record
		function master_retur_beli_delete($pkid){
			if(sizeof($pkid)<1){
				return '0';
			} else if (sizeof($pkid) == 1){
				$query = "DELETE FROM master_retur_beli WHERE rbeli_id = ".$pkid[0];
				$this->db->query($query);
			} else {
				$query = "DELETE FROM master_retur_beli WHERE ";
				for($i = 0; $i < sizeof($pkid); $i++){
					$query = $query . "rbeli_id= ".$pkid[$i];
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
		function master_retur_beli_search($rbeli_id ,$rbeli_nobukti ,$rbeli_terima ,$rbeli_supplier ,$rbeli_tgl_awal,$rbeli_tgl_akhir,
										  $rbeli_keterangan, $rbeli_status ,$rbeli_status, $start,$end){
			//full query
			$query="select * from vu_trans_retur_beli";
			
			
			if($rbeli_nobukti!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " no_bukti LIKE '%".$rbeli_nobukti."%'";
			};
			if($rbeli_terima!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " rbeli_terima LIKE '%".$rbeli_terima."%'";
			};
			if($rbeli_supplier!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " rbeli_supplier LIKE '%".$rbeli_supplier."%'";
			};
			if($rbeli_tgl_awal!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " date_format(tanggal,'%Y-%m-%d') >= '".$rbeli_tgl_awal."'";
			};
			if($rbeli_tgl_akhir!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " date_format(tanggal,'%Y-%m-%d') <= '".$rbeli_tgl_akhir."'";
			};
			if($rbeli_keterangan!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " rbeli_keterangan LIKE '%".$rbeli_keterangan."%'";
			};
			if($rbeli_status!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " rbeli_status LIKE '%".$rbeli_status."%'";
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
		function master_retur_beli_print($rbeli_id ,$rbeli_nobukti ,$rbeli_terima ,$rbeli_supplier ,$rbeli_tgl_awal,$rbeli_tgl_akhir,
										  $rbeli_keterangan, $rbeli_status ,$rbeli_status ,$option,$filter){
			//full query
			$query="SELECT * FROM vu_trans_retur_beli";
			if($option=='LIST'){
				if ($filter<>""){
					$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
					$query .= " (no_bukti LIKE '%".addslashes($filter)."%' OR
								 no_order LIKE '%".addslashes($filter)."%' OR 
								 supplier_nama LIKE '%".addslashes($filter)."%' OR 
								 no_terima LIKE '%".addslashes($filter)."%')";
				}
			} else if($option=='SEARCH'){
				if($rbeli_nobukti!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " no_bukti = '".$rbeli_nobukti."'";
				};
				if($rbeli_terima!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " rbeli_terima LIKE '%".$rbeli_terima."%'";
				};
				if($rbeli_supplier!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " rbeli_supplier LIKE '%".$rbeli_supplier."%'";
				};
				if($rbeli_tgl_awal!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " date_format(tanggal,'%Y-%m-%d') >= '".$rbeli_tgl_awal."'";
				};
				if($rbeli_tgl_akhir!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " date_format(tanggal,'%Y-%m-%d') <= '".$rbeli_tgl_akhir."'";
				};
				if($rbeli_keterangan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " rbeli_keterangan LIKE '%".$rbeli_keterangan."%'";
				};
				if($rbeli_status!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " rbeli_status LIKE '%".$rbeli_status."%'";
				};
				
			}
			$result = $this->db->query($query);
			return $result->result();
		}
		
		//function  for export to excel
		function master_retur_beli_export_excel($rbeli_id ,$rbeli_nobukti ,$rbeli_terima ,$rbeli_supplier ,$rbeli_tgl_awal,$rbeli_tgl_akhir,
										  		$rbeli_keterangan, $rbeli_status ,$rbeli_status ,$option,$filter){
			//full query
			$query="SELECT tanggal as Tanggal, no_bukti as 'No Retur', no_terima as 'No Penerimaan', no_order as 'No Pesanan',
					supplier_nama as 'Supplier', jumlah_barang as 'Jumlah Item', total_nilai as 'Total Nilai', rbeli_keterangan as 'Keterangan' 
					FROM vu_trans_retur_beli";
			if($option=='LIST'){
				if ($filter<>""){
					$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
					$query .= " (no_bukti LIKE '%".addslashes($filter)."%' OR
								 no_order LIKE '%".addslashes($filter)."%' OR 
								 supplier_nama LIKE '%".addslashes($filter)."%' OR 
								 no_terima LIKE '%".addslashes($filter)."%')";
				}
			} else if($option=='SEARCH'){
				if($rbeli_nobukti!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " no_bukti = '".$rbeli_nobukti."'";
				};
				if($rbeli_terima!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " rbeli_terima LIKE '%".$rbeli_terima."%'";
				};
				if($rbeli_supplier!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " rbeli_supplier LIKE '%".$rbeli_supplier."%'";
				};
				if($rbeli_tgl_awal!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " date_format(tanggal,'%Y-%m-%d') >= '".$rbeli_tgl_awal."'";
				};
				if($rbeli_tgl_akhir!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " date_format(tanggal,'%Y-%m-%d') <= '".$rbeli_tgl_akhir."'";
				};
				if($rbeli_keterangan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " rbeli_keterangan LIKE '%".$rbeli_keterangan."%'";
				};
				if($rbeli_status!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " rbeli_status LIKE '%".$rbeli_status."%'";
				};
			}
			$result = $this->db->query($query);
			
			return $result;
		}
		
}
?>