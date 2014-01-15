<? /* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
    #songbee	mukhlisona@gmail.com
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: cabang Model
	+ Description	: For record model process back-end
	+ Filename 		: c_cabang.php
 	+ Author  		: zainal, mukhlison
 	+ Created on 06/Aug/2009 15:46:36
	
*/

class M_cabang extends Model{
		
		//constructor
		function M_cabang() {
			parent::Model();
		}
		
		//function for get list record
		function cabang_list($filter,$start,$end){
			$query = "SELECT * FROM cabang";
			
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (cabang_nama LIKE '%".addslashes($filter)."%' OR cabang_kota LIKE '%".addslashes($filter)."%' )";
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
		function cabang_update($cabang_id ,$cabang_kode,$cabang_kode_akun,$cabang_nama ,$cabang_alamat ,$cabang_kota ,$cabang_kodepos ,$cabang_propinsi ,$cabang_keterangan ,$cabang_aktif,$cabang_pajak ){
			if ($cabang_aktif=="")
				$cabang_aktif = "Aktif";
				
			if($cabang_pajak=='true')
				$pajak="1";
			else if($cabang_pajak=='false')
				$pajak="0";
				
			$data = array(
				"cabang_id"=>$cabang_id,
				"cabang_kode"=>$cabang_kode,
				"cabang_kode_akun"=>$cabang_kode_akun,				
				"cabang_nama"=>$cabang_nama,			
				"cabang_alamat"=>$cabang_alamat,			
				"cabang_kota"=>$cabang_kota,
				"cabang_kodepos"=>$cabang_kodepos,
				"cabang_propinsi"=>$cabang_propinsi,			
				"cabang_keterangan"=>$cabang_keterangan,			
				"cabang_aktif"=>$cabang_aktif,	
				"cabang_pajak"=>$pajak,					
//				"cabang_creator"=>$cabang_creator,			
//				"cabang_date_create"=>$cabang_date_create,			
				"cabang_update"=>$_SESSION[SESSION_USERID],			
				"cabang_date_update"=>date('Y-m-d H:i:s')		
//				"cabang_revised"=>$cabang_revised
			);
			$this->db->where('cabang_id', $cabang_id);
			$this->db->update('cabang', $data);
			
			if($this->db->affected_rows()){
				$sql="UPDATE cabang set cabang_revised=(cabang_revised+1) WHERE cabang_id='".$cabang_id."'";
				$this->db->query($sql);
			}
			return '1';

		}
		
		//function for create new record
		function cabang_create($cabang_kode,$cabang_kode_akun,$cabang_nama ,$cabang_alamat ,$cabang_kota ,$cabang_kodepos ,$cabang_propinsi ,$cabang_keterangan ,$cabang_aktif,$cabang_pajak ){
			if ($cabang_aktif=="")
				$cabang_aktif = "Aktif";
				
			if($cabang_pajak=='true')
				$pajak="1";
			else if($cabang_pajak=='false')
				$pajak="0";
			
			$data = array(
				"cabang_kode"=>$cabang_kode,
				"cabang_kode_akun"=>$cabang_kode_akun,
				"cabang_nama"=>$cabang_nama,	
				"cabang_alamat"=>$cabang_alamat,	
				"cabang_kota"=>$cabang_kota,	
				"cabang_kodepos"=>$cabang_kodepos,	
				"cabang_propinsi"=>$cabang_propinsi,	
				"cabang_keterangan"=>$cabang_keterangan,	
				"cabang_aktif"=>$cabang_aktif,
				"cabang_pajak"=>$pajak,					
				"cabang_creator"=>$_SESSION[SESSION_USERID],	
				"cabang_date_create"=>date('Y-m-d H:i:s'),	
//				"cabang_update"=>$cabang_update,	
//				"cabang_date_update"=>$cabang_date_update,	
				"cabang_revised"=>'0'	
			);
			$this->db->insert('cabang', $data); 
			if($this->db->affected_rows())
				return '1';
			else
				return '0';
		}
		
		//fcuntion for delete record
		function cabang_delete($pkid){
			// You could do some checkups here and return '0' or other error consts.
			// Make a single query to delete all of the cabangs at the same time :
			if(sizeof($pkid)<1){
				return '0';
			} else if (sizeof($pkid) == 1){
				$query = "DELETE FROM cabang WHERE cabang_id = ".$pkid[0];
				$this->db->query($query);
			} else {
				$query = "DELETE FROM cabang WHERE ";
				for($i = 0; $i < sizeof($pkid); $i++){
					$query = $query . "cabang_id= ".$pkid[$i];
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
		function cabang_search($cabang_id ,$cabang_nama ,$cabang_alamat ,$cabang_kota ,$cabang_kodepos ,$cabang_propinsi ,$cabang_keterangan ,$cabang_aktif ,$start,$end,$cabang_pajak){
			if ($cabang_aktif=="")
				$cabang_aktif = "Aktif";

			//full query
			$query="select * from cabang";
			
			if($cabang_id!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " cabang_id LIKE '%".$cabang_id."%'";
			};
			if($cabang_nama!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " cabang_nama LIKE '%".$cabang_nama."%'";
			};
			if($cabang_alamat!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " cabang_alamat LIKE '%".$cabang_alamat."%'";
			};
			if($cabang_kota!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " cabang_kota LIKE '%".$cabang_kota."%'";
			};
			if($cabang_kodepos!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " cabang_kodepos LIKE '%".$cabang_kodepos."%'";
			};
			if($cabang_propinsi!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " cabang_propinsi LIKE '%".$cabang_propinsi."%'";
			};
			if($cabang_keterangan!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " cabang_keterangan LIKE '%".$cabang_keterangan."%'";
			};
			if($cabang_aktif!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " cabang_aktif LIKE '%".$cabang_aktif."%'";
			};
			if($cabang_pajak!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " cabang_pajak = '%".$cabang_pajak."%'";
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
		function cabang_print($cabang_id ,$cabang_kode,$cabang_kode_akun,$cabang_nama ,$cabang_alamat ,$cabang_kota ,$cabang_kodepos ,$cabang_propinsi ,$cabang_keterangan ,$cabang_aktif ,$option,$filter,$cabang_pajak){
			//full query
			$query="select * from cabang";
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (cabang_id LIKE '%".addslashes($filter)."%' OR cabang_nama LIKE '%".addslashes($filter)."%' OR cabang_alamat LIKE '%".addslashes($filter)."%' OR cabang_kota LIKE '%".addslashes($filter)."%' OR cabang_kodepos LIKE '%".addslashes($filter)."%' OR cabang_propinsi LIKE '%".addslashes($filter)."%' OR cabang_keterangan LIKE '%".addslashes($filter)."%' OR cabang_aktif LIKE '%".addslashes($filter)."%' )";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($cabang_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cabang_id LIKE '%".$cabang_id."%'";
				};
				
				if($cabang_nama!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cabang_nama LIKE '%".$cabang_nama."%'";
				};
				if($cabang_alamat!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cabang_alamat LIKE '%".$cabang_alamat."%'";
				};
				if($cabang_kota!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cabang_kota LIKE '%".$cabang_kota."%'";
				};
				if($cabang_kodepos!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cabang_kodepos LIKE '%".$cabang_kodepos."%'";
				};
				if($cabang_propinsi!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cabang_propinsi LIKE '%".$cabang_propinsi."%'";
				};
				if($cabang_keterangan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cabang_keterangan LIKE '%".$cabang_keterangan."%'";
				};
				if($cabang_aktif!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cabang_aktif LIKE '%".$cabang_aktif."%'";
				};
				$result = $this->db->query($query);
			}
			return $result;
		}
		
		//function  for export to excel
		function cabang_export_excel($cabang_id ,$cabang_kode,$cabang_kode_akun,$cabang_nama ,$cabang_alamat ,$cabang_kota ,$cabang_kodepos ,$cabang_propinsi ,$cabang_keterangan ,$cabang_aktif ,$option,$filter,$cabang_pajak){
			//full query
			$query="select cabang_nama AS nama,
							cabang_kode AS kode,
							cabang_kode_akun AS kode_akun,
							cabang_alamat AS alamat,
							cabang_kota AS kota,
							cabang_kodepos AS kodepos,
							cabang_propinsi AS propinsi,
							cabang_keterangan AS keterangan,
							cabang_aktif AS aktif
					from cabang";
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (cabang_id LIKE '%".addslashes($filter)."%' OR cabang_kode LIKE '%".addslashes($filter)."%' OR cabang_kode_akun LIKE '%".addslashes($filter)."%' OR cabang_nama LIKE '%".addslashes($filter)."%' OR cabang_alamat LIKE '%".addslashes($filter)."%' OR cabang_kota LIKE '%".addslashes($filter)."%' OR cabang_kodepos LIKE '%".addslashes($filter)."%' OR cabang_propinsi LIKE '%".addslashes($filter)."%' OR cabang_keterangan LIKE '%".addslashes($filter)."%' OR cabang_aktif LIKE '%".addslashes($filter)."%' )";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($cabang_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cabang_id LIKE '%".$cabang_id."%'";
				};
				if($cabang_kode!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cabang_kode LIKE '%".$cabang_kode."%'";
				};
				if($cabang_kode_akun!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cabang_kode_akun LIKE '%".$cabang_kode_akun."%'";
				};
				if($cabang_nama!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cabang_nama LIKE '%".$cabang_nama."%'";
				};
				if($cabang_alamat!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cabang_alamat LIKE '%".$cabang_alamat."%'";
				};
				if($cabang_kota!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cabang_kota LIKE '%".$cabang_kota."%'";
				};
				if($cabang_kodepos!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cabang_kodepos LIKE '%".$cabang_kodepos."%'";
				};
				if($cabang_propinsi!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cabang_propinsi LIKE '%".$cabang_propinsi."%'";
				};
				if($cabang_keterangan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cabang_keterangan LIKE '%".$cabang_keterangan."%'";
				};
				if($cabang_aktif!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " cabang_aktif LIKE '%".$cabang_aktif."%'";
				};
				$result = $this->db->query($query);
			}
			return $result;
		}
		

}
?>