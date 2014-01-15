<? /* 
	
	GIOV Solution - Keep IT Simple -

*/

class m_bs extends Model{
		
		//constructor
		function m_bs() {
			parent::Model();
		}
		
		function get_akun_list(){
			$sql="SELECT akun_id,akun_nama FROM akun";
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
		
		function saldo_akhir_list($query,$start,$end) {
			$query = "SELECT sum(kas_jumlah) as kas_saldo from kas";

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

		//function for get list record
		function kas_list($filter,$start,$end){
			$query = "SELECT * FROM bs ";
			
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (bs_tanggal LIKE '%".addslashes($filter)."%' OR bs_keterangan LIKE '%".addslashes($filter)."%' OR bs_kode LIKE '%".addslashes($filter)."%' OR bs_tipe LIKE '%".addslashes($filter)."%')";
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
		function kas_update($kas_id , $kas_tanggal, $kas_jumlah , $kas_keterangan, $kas_tipe ){
			if ($kas_tipe=="Kas Keluar")
				$kas_jumlah = $kas_jumlah * -1;
			$data = array(
				"bs_id"=>$kas_id,	
				"bs_tanggal"=>$kas_tanggal,			
				"bs_jumlah"=>$kas_jumlah,			
				"bs_keterangan"=>$kas_keterangan,
				"bs_tipe"=>$kas_tipe,					
				"bs_date_update"=>date('Y-m-d H:i:s')			
			);
			
			$this->db->where('bs_id', $kas_id);
			$this->db->update('bs', $data);
			if($this->db->affected_rows()){

				return '1';
			}
			
		}
		
		//function for create new record
		function kas_create($kas_tanggal, $kas_jumlah , $kas_keterangan ,$kas_tipe ,$kas_date_create ,$kas_date_update  ){
			if ($kas_tipe=="Kas Keluar")
				$kas_jumlah = $kas_jumlah * -1;

			// AUTO KOD BS
			$bs_tanggal_pattern=strtotime($kas_tanggal);
			$pattern="BS/".date("ym",$bs_tanggal_pattern)."-";
			$bs_kode=$this->m_public_function->get_kode_1('bs','bs_kode',$pattern,12);
			// END AUTO


			$data = array(
				"bs_tanggal"=>$kas_tanggal,	
				"bs_kode"=>$bs_kode,	
				"bs_jumlah"=>$kas_jumlah,	
				"bs_keterangan"=>$kas_keterangan,	
				"bs_tipe"=>$kas_tipe,	
				"bs_date_create"=>date('Y-m-d H:i:s')
			);
			$this->db->insert('bs', $data); 
			if($this->db->affected_rows())
				return '1';
			else
				return '0';
		}
		
		//fcuntion for delete record
		function bank_delete($pkid){
			// You could do some checkups here and return '0' or other error consts.
			// Make a single query to delete all of the banks at the same time :
			if(sizeof($pkid)<1){
				return '0';
			} else if (sizeof($pkid) == 1){
				$query = "DELETE FROM bank WHERE bank_id = ".$pkid[0];
				$this->db->query($query);
			} else {
				$query = "DELETE FROM bank WHERE ";
				for($i = 0; $i < sizeof($pkid); $i++){
					$query = $query . "bank_id= ".$pkid[$i];
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
		function bank_search($bank_id ,$bank_kode ,$bank_nama ,$bank_norek ,$bank_atasnama ,$bank_saldo ,$bank_keterangan ,$bank_aktif ,$bank_creator ,$bank_date_create ,$bank_update ,$bank_date_update ,$bank_revised ,$start,$end){
			if ($bank_aktif=="")
				$bank_aktif = "Aktif";
			//full query
			$query="select * from bank,akun,bank_master WHERE bank_kode=akun_id AND bank_nama=mbank_id";
			
			if($bank_id!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " bank_id LIKE '%".$bank_id."%'";
			};
			if($bank_kode!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " bank_kode LIKE '%".$bank_kode."%'";
			};
			if($bank_nama!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " bank_nama LIKE '%".$bank_nama."%'";
			};
			if($bank_norek!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " bank_norek LIKE '%".$bank_norek."%'";
			};
			if($bank_atasnama!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " bank_atasnama LIKE '%".$bank_atasnama."%'";
			};
			if($bank_saldo!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " bank_saldo LIKE '%".$bank_saldo."%'";
			};
			if($bank_keterangan!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " bank_keterangan LIKE '%".$bank_keterangan."%'";
			};
			if($bank_aktif!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " bank_aktif LIKE '%".$bank_aktif."%'";
			};
			if($bank_creator!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " bank_creator LIKE '%".$bank_creator."%'";
			};
			if($bank_date_create!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " bank_date_create LIKE '%".$bank_date_create."%'";
			};
			if($bank_update!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " bank_update LIKE '%".$bank_update."%'";
			};
			if($bank_date_update!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " bank_date_update LIKE '%".$bank_date_update."%'";
			};
			if($bank_revised!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " bank_revised LIKE '%".$bank_revised."%'";
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
		function bank_print($bank_id ,$bank_kode ,$bank_nama ,$bank_norek ,$bank_atasnama ,$bank_saldo ,$bank_keterangan ,$bank_aktif ,$bank_creator ,$bank_date_create ,$bank_update ,$bank_date_update ,$bank_revised ,$option,$filter){
			//full query
			$query="SELECT * FROM bank,bank_master WHERE  bank_nama=mbank_id";
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (bank_id LIKE '%".addslashes($filter)."%' OR bank_kode LIKE '%".addslashes($filter)."%' OR bank_nama LIKE '%".addslashes($filter)."%' OR bank_norek LIKE '%".addslashes($filter)."%' OR bank_atasnama LIKE '%".addslashes($filter)."%' OR bank_saldo LIKE '%".addslashes($filter)."%' OR bank_keterangan LIKE '%".addslashes($filter)."%' OR bank_aktif LIKE '%".addslashes($filter)."%' OR bank_creator LIKE '%".addslashes($filter)."%' OR bank_date_create LIKE '%".addslashes($filter)."%' OR bank_update LIKE '%".addslashes($filter)."%' OR bank_date_update LIKE '%".addslashes($filter)."%' OR bank_revised LIKE '%".addslashes($filter)."%' )";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($bank_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " bank_id LIKE '%".$bank_id."%'";
				};
				if($bank_kode!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " bank_kode LIKE '%".$bank_kode."%'";
				};
				if($bank_nama!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " bank_nama LIKE '%".$bank_nama."%'";
				};
				if($bank_norek!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " bank_norek LIKE '%".$bank_norek."%'";
				};
				if($bank_atasnama!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " bank_atasnama LIKE '%".$bank_atasnama."%'";
				};
				if($bank_saldo!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " bank_saldo LIKE '%".$bank_saldo."%'";
				};
				if($bank_keterangan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " bank_keterangan LIKE '%".$bank_keterangan."%'";
				};
				if($bank_aktif!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " bank_aktif LIKE '%".$bank_aktif."%'";
				};
				if($bank_creator!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " bank_creator LIKE '%".$bank_creator."%'";
				};
				if($bank_date_create!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " bank_date_create LIKE '%".$bank_date_create."%'";
				};
				if($bank_update!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " bank_update LIKE '%".$bank_update."%'";
				};
				if($bank_date_update!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " bank_date_update LIKE '%".$bank_date_update."%'";
				};
				if($bank_revised!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " bank_revised LIKE '%".$bank_revised."%'";
				};
				$result = $this->db->query($query);
			}
			return $result;
		}
		
		//function  for export to excel
		function bank_export_excel($bank_id ,$bank_kode ,$bank_nama ,$bank_norek ,$bank_atasnama ,$bank_saldo ,$bank_keterangan ,$bank_aktif ,$bank_creator ,$bank_date_create ,$bank_update ,$bank_date_update ,$bank_revised ,$option,$filter){
			//full query
			$query="select bank_master.mbank_nama AS nama_bank,
							bank.bank_norek AS no_rekening,
							bank.bank_atasnama AS atas_nama,
							bank.bank_saldo AS 'Saldo_(Rp)',
							bank.bank_aktif AS aktif
						FROM bank
						Inner Join bank_master ON bank.bank_nama = bank_master.mbank_id";
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (bank_id LIKE '%".addslashes($filter)."%' OR bank_kode LIKE '%".addslashes($filter)."%' OR bank_nama LIKE '%".addslashes($filter)."%' OR bank_norek LIKE '%".addslashes($filter)."%' OR bank_atasnama LIKE '%".addslashes($filter)."%' OR bank_saldo LIKE '%".addslashes($filter)."%' OR bank_keterangan LIKE '%".addslashes($filter)."%' OR bank_aktif LIKE '%".addslashes($filter)."%' OR bank_creator LIKE '%".addslashes($filter)."%' OR bank_date_create LIKE '%".addslashes($filter)."%' OR bank_update LIKE '%".addslashes($filter)."%' OR bank_date_update LIKE '%".addslashes($filter)."%' OR bank_revised LIKE '%".addslashes($filter)."%' )";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($bank_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " bank_id LIKE '%".$bank_id."%'";
				};
				if($bank_kode!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " bank_kode LIKE '%".$bank_kode."%'";
				};
				if($bank_nama!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " bank_nama LIKE '%".$bank_nama."%'";
				};
				if($bank_norek!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " bank_norek LIKE '%".$bank_norek."%'";
				};
				if($bank_atasnama!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " bank_atasnama LIKE '%".$bank_atasnama."%'";
				};
				if($bank_saldo!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " bank_saldo LIKE '%".$bank_saldo."%'";
				};
				if($bank_keterangan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " bank_keterangan LIKE '%".$bank_keterangan."%'";
				};
				if($bank_aktif!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " bank_aktif LIKE '%".$bank_aktif."%'";
				};
				if($bank_creator!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " bank_creator LIKE '%".$bank_creator."%'";
				};
				if($bank_date_create!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " bank_date_create LIKE '%".$bank_date_create."%'";
				};
				if($bank_update!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " bank_update LIKE '%".$bank_update."%'";
				};
				if($bank_date_update!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " bank_date_update LIKE '%".$bank_date_update."%'";
				};
				if($bank_revised!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " bank_revised LIKE '%".$bank_revised."%'";
				};
				$result = $this->db->query($query);
			}
			return $result;
		}
}
?>