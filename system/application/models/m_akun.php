<? /* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com,
    #songbee	mukhlisona@gmail.com
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id

	+ Module  		: akun Model
	+ Description	: For record model process back-end
	+ Filename 		: c_akun.php
 	+ creator 		:
 	+ Created on 12/Mar/2010 10:42:59

*/

class M_akun extends Model{

		//constructor
		function M_akun() {
			parent::Model();
		}

		//function for get list record
		function akun_list($filter,$start,$end){
			/*$query = "SELECTa test.*
						FROM  (SELECT A.*,B.akun_id as akun_parent_id, B.akun_kode as akun_parent_kode2, B.akun_nama as akun_parent_nama,
										D.departemen_id,D.departemen_nama
							FROM akun A
							LEFT JOIN departemen D ON (A.akun_departemen = D.departemen_id)
						  	LEFT JOIN akun B ON (A.akun_parent=B.akun_id)) as test
						WHERE test.akun_aktif='Aktif'";
			*/
			$query =   "select 
							v.akun_id, v.akun_kode, v.akun_jenis, v.akun_parent, v.akun_level, v.akun_nama, d.departemen_nama, 
							v.akun_parent as akun_parent_id, v.parent_kode as akun_parent_kode, v.parent_nama as akun_parent_nama,
							v.akun_debet, v.akun_kredit, v.akun_periode_awal, v.akun_saldo, v.akun_aktif, 
							v.akun_creator, v.akun_date_create, v.akun_update, v.akun_date_update, v.akun_revised
						from vu_akun v
						left join departemen d on d.departemen_id = v.akun_departemen
						where v.akun_aktif = 'Aktif'";
						
			// For simple search
			if ($filter<>"" && $query !=""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (v.akun_kode LIKE '%".addslashes($filter)."%' OR
							 v.akun_jenis LIKE '%".addslashes($filter)."%' OR
							 v.akun_nama LIKE '%".addslashes($filter)."%' OR
							 v.akun_saldo LIKE '%".addslashes($filter)."%' )";
				$limit = $query;
			}
			
			$query .= "order by v.akun_kode ";
			
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
			if($end=="") $end=15;
			$limit = $query." LIMIT ".$start.",".$end;
			$result = $this->db->query($limit);
			//$this->firephp->log($limit);

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

		function get_akun_list($filter,$start,$end){
			$query = "SELECT concat('(', a.akun_kode, ') ', a.akun_nama) as akun_kode_nama, a.* FROM akun a WHERE akun_level<5 AND akun_aktif='Aktif'";

			// For simple search
			if ($filter<>"" && $query !=""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (akun_kode LIKE '%".addslashes($filter)."%' OR
							 akun_jenis LIKE '%".addslashes($filter)."%' OR
							 akun_nama LIKE '%".addslashes($filter)."%' OR
							 akun_saldo LIKE '%".addslashes($filter)."%' )";
				$limit = $query;
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

		function get_akun_departemen_list(){
			$sql="SELECT departemen_id,departemen_nama FROM departemen where departemen_aktif='Aktif'";
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

		//function for create new record
		function akun_create($akun_kode ,$akun_jenis ,$akun_parent ,$akun_level ,$akun_nama ,$akun_debet ,$akun_kredit ,$akun_saldo ,$akun_aktif ,
							 $akun_creator ,$akun_date_create, $akun_departemen ){
			$data = array(
				"akun_kode"=>$akun_kode,
				"akun_jenis"=>$akun_jenis,
				"akun_parent"=>$akun_parent,
				"akun_nama"=>$akun_nama,
				"akun_debet"=>$akun_debet,
				"akun_kredit"=>$akun_kredit,
				"akun_saldo"=>$akun_saldo,
				"akun_aktif"=>$akun_aktif,
				"akun_creator"=>$akun_creator,
				"akun_date_create"=>$akun_date_create
			);


			if($akun_departemen!==""){
				$sql="SELECT departemen_id FROM departemen WHERE departemen_id='".$akun_departemen."' LIMIT 1";
				$result=$this->db->query($sql);
				if($result->num_rows()){
					$data["akun_departemen"]=$akun_departemen;
				}
			}else{
				$data["akun_departemen"]=0;
			}

			if($akun_parent!==""){
				$sql="SELECT akun_kode,akun_level FROM akun WHERE akun_id='".$akun_parent."'";
				$result=$this->db->query($sql);
				if($result->num_rows()){
					$row=$result->row();
					$data["akun_parent_kode"]=$row->akun_kode;
					$data["akun_level"]=$row->akun_level+1;
				}
			}else{
				$data["akun_level"]=0;
			}

			$this->db->insert('akun', $data);
			if($this->db->affected_rows()){
				return '1';
			}
			else
				return '0';
				
			
		}

		//function for update record
		function akun_update($akun_id,$akun_kode,$akun_jenis,$akun_parent,$akun_level,$akun_nama,$akun_debet,$akun_kredit,$akun_saldo,$akun_aktif,
							 $akun_update,$akun_date_update,$akun_departemen, $akun_periode_awal){
			$data = array(
				"akun_kode"=>$akun_kode,
				"akun_jenis"=>$akun_jenis,
				"akun_parent"=>$akun_parent,
				"akun_nama"=>$akun_nama,
				"akun_debet"=>$akun_debet,
				"akun_kredit"=>$akun_kredit,
				"akun_saldo"=>$akun_saldo,
				"akun_aktif"=>$akun_aktif,
				"akun_update"=>$akun_update,
				"akun_date_update"=>$akun_date_update
			);

			if($akun_departemen!==""){
				$sql="SELECT departemen_id FROM departemen WHERE departemen_id='".$akun_departemen."' LIMIT 1";
				$result=$this->db->query($sql);
				if($result->num_rows()){
					$data["akun_departemen"]=$akun_departemen;
				}
			}else{
				$data["akun_departemen"]=0;
			}

			if($akun_parent!==""){
				$sql="SELECT akun_id, akun_kode,akun_level, akun_jenis FROM akun WHERE akun_id='".$akun_parent."'";
				$result=$this->db->query($sql);
				if($result->num_rows()){
					$row=$result->row();
					$data["akun_parent"]=$row->akun_id;
					$data["akun_parent_kode"]=$row->akun_kode;
					$data["akun_level"]=$row->akun_level+1;
					$data["akun_jenis"]=$row->akun_jenis;
				}
			}

			$sql="SELECT departemen_id FROM departemen WHERE departemen_id='".$akun_departemen."'";
			$rs=$this->db->query($sql);
			if($rs->num_rows())
				$data["akun_departemen"]=$akun_departemen;

			$this->db->where('akun_id', $akun_id);
			$this->db->update('akun', $data);
			$sql = "UPDATE akun SET akun_revised=(akun_revised+1) WHERE akun_id='".$akun_id."'";
			$this->db->query($sql);
			
			$sql_sa = "UPDATE akun_sa SET sa_debet = ".$akun_debet.", sa_kredit = ".$akun_kredit." WHERE sa_master = ".$akun_id." and sa_periode_awal = '".$akun_periode_awal."'";
			$this->db->query($sql_sa);

			/*
			$sql="SELECT akun_parent_kode,akun_level FROM akun WHERE akun_id='".$akun_id."'";
			$result=$this->db->query($sql);
			if($result->num_rows()){
				$row=$result->row();
				$data["akun_parent_kode"]=$row->akun_parent_kode;
				$data["akun_level"]=$row->akun_level;
			}

			$this->db->insert('akun', $data);*/

			return '1';
		}

		//fcuntion for delete record
		function akun_delete($pkid){
			// You could do some checkups here and return '0' or other error consts.
			// Make a single query to delete all of the akuns at the same time :
			if(sizeof($pkid)<1){
				return '0';
			} else if (sizeof($pkid) == 1){
				$query = "DELETE akun  WHERE akun_id = ".$pkid[0];
				$this->db->query($query);
			} else {
				$query = "DELETE akun  WHERE ";
				for($i = 0; $i < sizeof($pkid); $i++){
					$query = $query . "akun_id= ".$pkid[$i];
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
		function akun_search($akun_id ,$akun_kode ,$akun_jenis ,$akun_parent ,$akun_level ,$akun_nama ,$akun_debet ,$akun_kredit ,$akun_saldo ,
							 $akun_aktif ,$akun_creator ,$akun_date_create ,$akun_update ,$akun_date_update ,$akun_revised ,$start,$end){
			//full query
			$query = "SELECT test.*
						FROM  (SELECT A.*,B.akun_id as akun_parent_id, B.akun_kode as akun_parent_kode2, B.akun_nama as akun_parent_nama,
										D.departemen_id,D.departemen_nama
							FROM akun A
							LEFT JOIN departemen D ON (A.akun_departemen = D.departemen_id)
						  	LEFT JOIN akun B ON (A.akun_parent=B.akun_id)) as test ";

			if($akun_kode!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " test.akun_kode LIKE '%".$akun_kode."%'";
			};
			if($akun_jenis!=''){
				$query.=" AND ";
				$query.= " test.akun_jenis = '".$akun_jenis."'";
			};
			if($akun_parent!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " test.akun_parent = '".$akun_parent."'";
			};
			if($akun_level!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " test.akun_level = '".$akun_level."'";
			};
			if($akun_nama!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " test.akun_nama LIKE '%".$akun_nama."%'";
			};
			if($akun_saldo!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " test.akun_saldo LIKE '%".$akun_saldo."%'";
			};
			if($akun_aktif!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " test.akun_aktif = '".$akun_aktif."'";
			};

			//$this->firephp->log($query);

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
		function akun_print($akun_id ,$akun_kode ,$akun_jenis ,$akun_parent ,$akun_level ,$akun_nama ,$akun_debet ,$akun_kredit ,$akun_saldo ,
							$akun_aktif ,$akun_creator ,$akun_date_create ,$akun_update ,$akun_date_update ,$akun_revised ,$option,$filter){
			//full query
			$sql = "SELECT test.*
						FROM  (SELECT A.*,B.akun_id as akun_parent_id, B.akun_kode as akun_parent_kode2, B.akun_nama as akun_parent_nama,
										D.departemen_id,D.departemen_nama
							FROM akun A
							LEFT JOIN departemen D ON (A.akun_departemen = D.departemen_id)
						  	LEFT JOIN akun B ON (A.akun_parent_kode=B.akun_kode OR A.akun_parent=B.akun_id)) as test ";

			if($option=='LIST'){
				$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
				$sql .= " (test.akun_kode LIKE '%".addslashes($filter)."%' OR
						   test.akun_jenis LIKE '%".addslashes($filter)."%' OR
						   test.akun_parent LIKE '%".addslashes($filter)."%' OR
						   test.akun_level LIKE '%".addslashes($filter)."%' OR
						   test.akun_nama LIKE '%".addslashes($filter)."%' )";

			} else if($option=='SEARCH'){
				if($akun_kode!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " test.akun_kode LIKE '%".$akun_kode."%'";
				};
				if($akun_jenis!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " test.akun_jenis = '".$akun_jenis."'";
				};
				if($akun_parent!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " test.akun_parent = '".$akun_parent."'";
				};
				if($akun_level!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " test.akun_level = '".$akun_level."'";
				};
				if($akun_nama!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " test.akun_nama LIKE '%".$akun_nama."%'";
				};
				if($akun_saldo!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " test.akun_saldo LIKE '%".$akun_saldo."%'";
				};
				if($akun_aktif!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " test.akun_aktif LIKE '%".$akun_aktif."%'";
				};

			}
			$query = $this->db->query($sql);
			return $query->result();

		}

		//function  for export to excel
		function akun_export_excel($akun_id ,$akun_kode ,$akun_jenis ,$akun_parent ,$akun_level ,$akun_nama ,$akun_debet ,$akun_kredit ,$akun_saldo ,
								   $akun_aktif ,$akun_creator ,$akun_date_create ,$akun_update ,$akun_date_update ,$akun_revised ,$option,$filter){
			//full query
			$sql = "SELECT test.*
						FROM  (SELECT A.*,B.akun_id as akun_parent_id, B.akun_kode as akun_parent_kode2, B.akun_nama as akun_parent_nama,
										D.departemen_id,D.departemen_nama
							FROM akun A
							LEFT JOIN departemen D ON (A.akun_departemen = D.departemen_id)
						  	LEFT JOIN akun B ON (A.akun_parent=B.akun_id)) as test";

			if($option=='LIST'){
					$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
					$sql .= " (test.akun_kode LIKE '%".addslashes($filter)."%' OR
						   test.akun_jenis LIKE '%".addslashes($filter)."%' OR
						   test.akun_nama LIKE '%".addslashes($filter)."%' )";
			} else if($option=='SEARCH'){
				if($akun_kode!=''){
					$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
					$sql.= " test.akun_kode LIKE '%".$akun_kode."%'";
				};
				if($akun_jenis!=''){
					$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
					$sql.= " test.akun_jenis = '".$akun_jenis."'";
				};
				if($akun_parent!=''){
					$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
					$sql.= " test.akun_parent ='".$akun_parent."'";
				};
				if($akun_level!=''){
					$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
					$sql.= " test.akun_level = '".$akun_level."'";
				};
				if($akun_nama!=''){
					$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
					$sql.= " test.akun_nama LIKE '%".$akun_nama."%'";
				};
				if($akun_saldo!=''){
					$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
					$sql.= " test.akun_saldo LIKE '%".$akun_saldo."%'";
				};

				if($akun_aktif!=''){
					$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
					$query.= " test.akun_aktif LIKE '%".$akun_aktif."%'";
				};

			}

			$query = $this->db->query($sql);
			return $query;
		}

}
?>