<? /* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
    #songbee	mukhlisona@gmail.com
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: promo Model
	+ Description	: For record model process back-end
	+ Filename 		: c_promo.php
 	+ Author  		: 
 	+ Created on 27/Aug/2009 08:57:17
	
*/

class M_promo extends Model{
		
		//constructor
		function M_promo() {
			parent::Model();
		}
		
		//function for detail
		function get_rawat_list($query,$start,$end){
			$rs_rows=0;
			if(is_numeric($query)==true){
				$sql_drawat="SELECT rpromo_perawatan FROM promo_perawatan WHERE rpromo_master='".$query."'";
				$rs=$this->db->query($sql_drawat);
				$rs_rows=$rs->num_rows();
			}
			
			$sql="select distinct * from vu_perawatan WHERE rawat_aktif='Aktif'";
			if($query<>"" && is_numeric($query)==false){
				$sql.=eregi("WHERE",$sql)? " AND ":" WHERE ";
				$sql.=" (rawat_kode like '%".$query."%' or rawat_nama like '%".$query."%' or kategori_nama like '%".$query."%' or group_nama like '%".$query."%' or rawat_kodelama like '%".$query."%') ";
			}else{
				if($rs_rows){
					$filter="";
					$sql.=eregi("AND",$sql)? " OR ":" AND ";
					foreach($rs->result() as $row_drawat){
						
						$filter.="OR rawat_id='".$row_drawat->ipromo_perawatan."' ";
					}
					$sql=$sql."(".substr($filter,2,strlen($filter)).")";
				}
			}
			$sql.=" ORDER BY rawat_id ASC";
			
			$result = $this->db->query($sql);
			$nbrows = $result->num_rows();
			if($end!=0){
				$limit = $sql." LIMIT ".$start.",".$end;			
				$result = $this->db->query($limit);
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
		
		function get_produk_list($query,$start,$end){
			$rs_rows=0;
			if(is_numeric($query)==true){
				$sql_dproduk="SELECT ipromo_produk FROM promo_produk WHERE ipromo_master='".$query."'";
				$rs=$this->db->query($sql_dproduk);
				$rs_rows=$rs->num_rows();
			}
			
			$sql="select * from vu_produk WHERE produk_aktif='Aktif'";
			if($query<>"" && is_numeric($query)==false){
				$sql.=eregi("WHERE",$sql)? " AND ":" WHERE ";
				$sql.=" (produk_kode like '%".$query."%' or produk_nama like '%".$query."%' or satuan_nama like '%".$query."%' or kategori_nama like '%".$query."%' or group_nama like '%".$query."%' or produk_kodelama like '%".$query."%') ";
			}else{
				if($rs_rows){
					$filter="";
					$sql.=eregi("AND",$sql)? " OR ":" AND ";
					foreach($rs->result() as $row_dproduk){
						
						$filter.="OR produk_id='".$row_dproduk->krawat_produk."' ";
					}
					$sql=$sql."(".substr($filter,2,strlen($filter)).")";
				}
			}
			$sql.=" ORDER BY produk_id ASC";
			
			$result = $this->db->query($sql);
			$nbrows = $result->num_rows();
			if($end!=0){
				$limit = $sql." LIMIT ".$start.",".$end;			
				$result = $this->db->query($limit);
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
		
		function detail_promo_perawatan_list($master_id,$query,$start,$end) {
			$query = "SELECT * FROM promo_perawatan where rpromo_master='".$master_id."'";
			$result = $this->db->query($query);
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
		
		function detail_promo_produk_list($master_id,$query,$start,$end) {
			$query = "SELECT * FROM promo_produk where ipromo_master='".$master_id."'";
			$result = $this->db->query($query);
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
		
		
		//insert detail record
		function detail_promo_produk_insert($ipromo_id ,$ipromo_master ,$ipromo_produk ){
					
			$query="";
			for($i = 0; $i < sizeof($ipromo_produk); $i++){
			
			$data = array(
				"ipromo_master"=>$ipromo_master, 
				"ipromo_produk"=>$ipromo_produk[$i]
			);
			
			if($ipromo_id[$i]==0){
				
				$this->db->insert('promo_produk', $data); 
				
				$query = $query.$this->db->insert_id();
				if($i<sizeof($ipromo_id)-1){
					$query = $query . ",";
				}
			
			}else{
				$query = $query.$ipromo_id[$i];
				if($i<sizeof($ipromo_id)-1){
					$query = $query . ",";
				} 
				$this->db->where('ipromo_id', $ipromo_id[$i]);
				$this->db->update('promo_produk', $data);
			}
			}
			
			if($query<>""){
			$sql="DELETE FROM promo_produk WHERE  ipromo_master='".$ipromo_master."' AND
					ipromo_id NOT IN (".$query.")";
			$this->db->query($sql);
			}
			
			return '1';
		}
		
		function detail_promo_perawatan_insert($rpromo_id ,$rpromo_master ,$rpromo_perawatan ){
			$query="";
			for($i = 0; $i < sizeof($rpromo_perawatan); $i++){
			
			$data = array(
				"rpromo_master"=>$rpromo_master, 
				"rpromo_perawatan"=>$rpromo_perawatan[$i]
			);
			
			if($rpromo_id[$i]==0){
				
				$this->db->insert('promo_perawatan', $data); 
				
				$query = $query.$this->db->insert_id();
				if($i<sizeof($rpromo_id)-1){
					$query = $query . ",";
				}
			
			}else{
				$query = $query.$rpromo_id[$i];
				if($i<sizeof($rpromo_id)-1){
					$query = $query . ",";
				} 
				$this->db->where('rpromo_id', $rpromo_id[$i]);
				$this->db->update('promo_perawatan', $data);
			}
			}
			
			if($query<>""){
			$sql="DELETE FROM promo_perawatan WHERE  rpromo_master='".$rpromo_master."' AND
					rpromo_id NOT IN (".$query.")";
			$this->db->query($sql);
			}
			
			return '1';

		}
		
		//end of function
		
		//function for get list record
		function promo_list($filter,$start,$end){
			$query = "SELECT * FROM promo";
			
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (promo_acara LIKE '%".addslashes($filter)."%' OR 
							 promo_tempat LIKE '%".addslashes($filter)."%'  OR 
							 promo_keterangan LIKE '%".addslashes($filter)."%' )";
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
		function promo_update($promo_id ,$promo_acara ,$promo_tempat, $promo_keterangan ,$promo_tglmulai ,$promo_tglselesai
							  ,$promo_diskon ,$promo_allproduk ,$promo_allrawat ){
			$data = array(
				"promo_id"=>$promo_id, 
				"promo_acara"=>$promo_acara, 
				"promo_tempat"=>$promo_tempat,
				"promo_keterangan"=>$promo_keterangan, 
				"promo_tglmulai"=>$promo_tglmulai, 
				"promo_tglselesai"=>$promo_tglselesai, 
				"promo_diskon"=>$promo_diskon, 
				"promo_allproduk"=>$promo_allproduk, 
				"promo_allrawat"=>$promo_allrawat 
			);
			$this->db->where('promo_id', $promo_id);
			$this->db->update('promo', $data);
			
			return $promo_id;
		}
		
		//function for create new record
		function promo_create($promo_acara ,$promo_tempat, $promo_keterangan ,$promo_tglmulai ,$promo_tglselesai ,
							  $promo_diskon ,$promo_allproduk ,$promo_allrawat ){
			$data = array(
				"promo_acara"=>$promo_acara, 
				"promo_tempat"=>$promo_tempat, 
				"promo_keterangan"=>$promo_keterangan, 
				"promo_tglmulai"=>$promo_tglmulai, 
				"promo_tglselesai"=>$promo_tglselesai, 
				"promo_diskon"=>$promo_diskon, 
				"promo_allproduk"=>$promo_allproduk, 
				"promo_allrawat"=>$promo_allrawat 
			);
			$this->db->insert('promo', $data); 
			if($this->db->affected_rows())
				return $this->db->insert_id();
			else
				return '0';
		}
		
		//fcuntion for delete record
		function promo_delete($pkid){
			if(sizeof($pkid)<1){
				return '0';
			} else if (sizeof($pkid) == 1){
				$query = "DELETE FROM promo WHERE promo_id = ".$pkid[0];
				$this->db->query($query);
			} else {
				$query = "DELETE FROM promo WHERE ";
				for($i = 0; $i < sizeof($pkid); $i++){
					$query = $query . "promo_id= ".$pkid[$i];
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
		function promo_search($promo_acara ,$promo_tempat,$promo_keterangan ,$promo_tglmulai ,$promo_tglselesai ,
							  $promo_diskon ,$start,$end){
			//full query
			$query="select *
					from promo";
			
			
			if($promo_acara!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " promo_acara LIKE '%".$promo_acara."%'";
			};
			if($promo_tempat!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " promo_tempat LIKE '%".$promo_tempat."%'";
			};
			if($promo_keterangan!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " promo_keterangan LIKE '%".$promo_keterangan."%'";
			};
			if($promo_tglmulai!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " promo_tglmulai LIKE '%".$promo_tglmulai."%'";
			};
			if($promo_tglselesai!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " promo_tglselesai LIKE '%".$promo_tglselesai."%'";
			};
			
			if($promo_diskon!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " promo_diskon LIKE '%".$promo_diskon."%'";
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
		function promo_print($promo_acara ,$promo_tempat, $promo_keterangan ,$promo_tglmulai ,$promo_tglselesai ,
							 $promo_diskon ,$option,$filter){
			//full query
			$query="select * from promo";
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (promo_acara LIKE '%".addslashes($filter)."%' OR 
							 promo_tempat LIKE '%".addslashes($filter)."%' OR 
							 promo_keterangan LIKE '%".addslashes($filter)."%' )";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){

				if($promo_acara!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " promo_acara LIKE '%".$promo_acara."%'";
				};
				if($promo_tempat!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " promo_tempat LIKE '%".$promo_tempat."%'";
				};
				if($promo_keterangan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " promo_keterangan LIKE '%".$promo_keterangan."%'";
				};
				if($promo_tglmulai!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " promo_tglmulai LIKE '%".$promo_tglmulai."%'";
				};
				if($promo_tglselesai!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " promo_tglselesai LIKE '%".$promo_tglselesai."%'";
				};
				
				if($promo_diskon!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " promo_diskon LIKE '%".$promo_diskon."%'";
				};
				
				$result = $this->db->query($query);
			}
			return $result->result();
		}
		
		//function  for export to excel
		function promo_export_excel($promo_acara ,$promo_tempat ,$promo_tglmulai ,$promo_tglselesai ,
									$promo_diskon ,$option,$filter){
			//full query
			$query="select promo_acara as Acara, promo_tempat as Tempat, promo_tglmulai as 'Tanggal Mulai'
					,promo_tglselesai as 'Tanggal Selesai', promo_diskon as Diskon, promo_keterangan as Keterangan 
					from promo";
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (promo_acara LIKE '%".addslashes($filter)."%' OR 
							 promo_tempat LIKE '%".addslashes($filter)."%' OR 
							 promo_keterangan LIKE '%".addslashes($filter)."%')";
			} else if($option=='SEARCH'){
				
				if($promo_acara!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " promo_acara LIKE '%".$promo_acara."%'";
				};
				if($promo_tempat!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " promo_tempat LIKE '%".$promo_tempat."%'";
				};
				if($promo_keterangan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " promo_keterangan LIKE '%".$promo_keterangan."%'";
				};
				if($promo_tglmulai!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " promo_tglmulai LIKE '%".$promo_tglmulai."%'";
				};
				if($promo_tglselesai!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " promo_tglselesai LIKE '%".$promo_tglselesai."%'";
				};
				
				if($promo_diskon!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " promo_diskon LIKE '%".$promo_diskon."%'";
				};
				
				
			}
			$result = $this->db->query($query);
			return $result;
		}
		
}
?>