<? /* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com,
    #songbee	mukhlisona@gmail.com
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id

	+ Module  		: jurnal Model
	+ Description	: For record model process back-end
	+ Filename 		: c_jurnal.php
 	+ creator 		:
 	+ Created on 01/Apr/2010 12:13:56

*/

class M_jurnal extends Model{

		//constructor
		function M_jurnal() {
			parent::Model();
		}

		function jurnal_reopen($jurnal_id){
			$sqlupdate="UPDATE jurnal SET jurnal_post='T' WHERE jurnal_id='".$jurnal_id."'";
			$result = $this->db->query($sqlupdate);
			if($result){
				$sqlselect="SELECT jurnal_no FROM jurnal WHERE jurnal_id='".$jurnal_id."'";
				$result = $this->db->query($sqlselect);
				if($result->num_rows()){
						$rowjurnal=$result->row();
						$sqldelete="DELETE FROM buku_besar WHERE buku_ref='".$rowjurnal->jurnal_no."'";
						$result = $this->db->query($sqldelete);
						if($result){
							return '1';
						}else
							return '0';
				}else{
					return '0';
				}
			}else{
				return '0';
			}
		}

		function print_faktur($faktur){
			$sql="SELECT jurnal_no AS no_bukti,
				       date_format(jurnal_tanggal, '%Y-%m-%d') AS tanggal,
				       A.akun_nama,
				       A.akun_kode,
				       jurnal_id,
				       djurnal_detail AS uraian,
				       djurnal_debet AS debet,
				       djurnal_kredit AS kredit
				  FROM jurnal,
				       akun A,
				       jurnal_detail
				 WHERE jurnal_detail.djurnal_akun = A.akun_id
				       AND jurnal.jurnal_id = jurnal_detail.djurnal_master AND
				 	   jurnal_id='".$faktur."' ORDER BY djurnal_id DESC";

				$result = $this->db->query($sql);
				return $result;
		}

		function get_akun_list($task, $master_id, $selected_id, $filter="",$start=0,$end=15){
			$sql = "SELECT A.* from akun A
					WHERE A.akun_kode not in (
					SELECT B.akun_parent_kode FROM akun B WHERE B.akun_parent_kode is NOT NULL)";
			if($task=='detail'){
				/*$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
				$sql .=" A.akun_id IN (SELECT djurnal_akun FROM jurnal_detail WHERE djurnal_master='".$master_id."')";
				*/

				$sql="SELECT B.* FROM jurnal_detail A,(".$sql.") as B
						WHERE A.djurnal_akun=B.akun_id
						AND A.djurnal_master='".$master_id."'";

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

			}else if($task=='selected'){
				if($selected_id!=="")
				{
					$selected_id=substr($selected_id,0,strlen($selected_id)-1);
					$sql.=(eregi("WHERE",$sql)?" AND ":" WHERE ")." akun_id IN(".$selected_id.")";
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

			}else{

				if ($filter<>""){
						$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
						$sql .= " (akun_kode LIKE '%".addslashes($filter)."%' OR
								   akun_nama LIKE '%".addslashes($filter)."%' OR
								   akun_jenis LIKE '%".addslashes($filter)."%')";
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

		}

		function get_detail_jurnal_list($task,$master_id,$query,$start,$end){

			$query="SELECT djurnal_id,djurnal_akun,djurnal_detail,djurnal_debet,djurnal_kredit,akun_kode from vu_jurnal
					WHERE djurnal_master='".$master_id."'";
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
		/*	$limit = $query." LIMIT ".$start.",".$end;
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

		//function for get list record
		function jurnal_list($filter,$start,$end){
			$query = "SELECT * FROM vu_jurnal
						WHERE date_format(jurnal_tanggal,'%Y-%m-%d') >= (select setup_periode_awal from akun_setup limit 1)
						AND date_format(jurnal_tanggal,'%Y-%m-%d')<= (select setup_periode_akhir from akun_setup limit 1)
						AND jurnal_arsip='T'";

			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " jurnal_tanggal LIKE '%".addslashes($filter)."%' OR
							jurnal_no LIKE '%".addslashes($filter)."%' ";
			}
			$query.=" ORDER by jurnal_no DESC, djurnal_id DESC";
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
			if($start=="") $start=0;
			if($end=="") $end=15;
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

		function detail_jurnal_purge($jurnal_master){
			$sql="DELETE from jurnal_detail WHERE djurnal_master='".$jurnal_master."'";
			$this->db->query($sql);
			return '1';
		}

		function detail_jurnal_insert($jurnal_id,$jurnal_master,$jurnal_akun, $jurnal_detail, $jurnal_debet,$jurnal_kredit){
			$query="";
		   	for($i = 0; $i < sizeof($jurnal_akun); $i++){
				$data = array(
					"djurnal_master"=>$jurnal_master,
					"djurnal_akun"=>$jurnal_akun[$i],
					"djurnal_detail"=>$jurnal_detail[$i],
					"djurnal_debet"=>$jurnal_debet[$i],
					"djurnal_kredit"=>$jurnal_kredit[$i]
				);

				$sql="SELECT akun_kode FROM akun WHERE akun_id='".$jurnal_akun[$i]."'";
				$rs=$this->db->query($sql);

				if($rs->num_rows()){
					$row=$rs->row();
					$data["djurnal_akun_kode"]=$row->akun_kode;
				}

				if($jurnal_id[$i]==0){
					$this->db->insert('jurnal_detail', $data);

					$query = $query.$this->db->insert_id();
					if($i<sizeof($jurnal_id)-1){
						$query = $query . ",";
					}

				}else{
					$query = $query.$jurnal_id[$i];
					if($i<sizeof($jurnal_id)-1){
						$query = $query . ",";
					}
					$this->db->where('djurnal_id', $jurnal_id[$i]);
					$this->db->update('jurnal_detail', $data);
				}
			}

			if($query<>""){
				$sql="DELETE FROM jurnal_detail WHERE  djurnal_master='".$jurnal_master."' AND
						djurnal_id NOT IN (".$query.")";
				$this->db->query($sql);
			}

			return $jurnal_master;
		}

		//function for create new record
		function jurnal_create($jurnal_no,$jurnal_tanggal ,$jurnal_keterangan ,$jurnal_noref ,$jurnal_unit ,$jurnal_author,
									 $jurnal_date_create ){
			$data = array(
				"jurnal_tanggal"=>$jurnal_tanggal,
				"jurnal_keterangan"=>$jurnal_keterangan,
				"jurnal_noref"=>$jurnal_noref,
				"jurnal_unit"=>$jurnal_unit,
				"jurnal_author"=>$jurnal_author,
				"jurnal_date_create"=>$jurnal_date_create
			);

			$jurnal_tanggal=strtotime($jurnal_tanggal);
			$pattern="J/".date("ym",$jurnal_tanggal)."-";
			$jurnal_no=$this->m_public_function->get_kode_1('jurnal','jurnal_no',$pattern,11);
			$data["jurnal_no"]=$jurnal_no;
			
			$this->db->insert('jurnal', $data);
			if($this->db->affected_rows())
				return $this->db->insert_id();
			else
				return 0;
				
			/*
			$sql="SELECT jurnal_no FROM vu_jurnal WHERE jurnal_no='".$jurnal_no."'";
			$rs=$this->db->query($sql);
			if($rs->num_rows()){
				return 'ER:No Jurnal sudah digunakan !';
			}else{
				$this->db->insert('jurnal', $data);
				if($this->db->affected_rows())
					return 'OK:'.$this->db->insert_id();
				else
					return 'ER:Gagal disimpan digunakan !';
			}*/
			
		}

		//function for update record
		function jurnal_update($jurnal_id,$jurnal_no,$jurnal_tanggal,$jurnal_keterangan,$jurnal_noref,$jurnal_unit,$jurnal_update,
									 $jurnal_date_update){
			$data = array(
				"jurnal_tanggal"=>$jurnal_tanggal,
				"jurnal_keterangan"=>$jurnal_keterangan,
				"jurnal_noref"=>$jurnal_noref,
				"jurnal_unit"=>$jurnal_unit,
				"jurnal_update"=>$jurnal_update,
				"jurnal_date_update"=>$jurnal_date_update
			);

			
			$this->db->where('jurnal_id', $jurnal_id);
			$this->db->update('jurnal', $data);
			return $jurnal_id;
				
			/*$sql="SELECT jurnal_no FROM vu_jurnal WHERE jurnal_no='".$jurnal_no."' AND jurnal_id<>'".$jurnal_id."'";
			$rs=$this->db->query($sql);
			//$this->firephp->log($sql);
			if($rs->num_rows()){
				return 'ER:No Jurnal sudah digunakan !';
			}else{
				$this->db->insert('jurnal', $data);
				if($this->db->affected_rows()){
					$this->db->where('jurnal_id', $jurnal_id);
					$this->db->update('jurnal', $data);
					$sql="UPDATE jurnal set jurnal_revised=(jurnal_revised+1) where jurnal_id='".$jurnal_id."'";
					$this->db->query($sql);
					return 'OK:'.$jurnal_id;
				}
				else
					return 'ER:Gagal disimpan !';
			}*/
		}

		//fcuntion for delete record
		function jurnal_delete($pkid){
			// You could do some checkups here and return '0' or other error consts.
			// Make a single query to delete all of the jurnals at the same time :
			if(sizeof($pkid)<1){
				return '0';
			} else if (sizeof($pkid) == 1){
				$query = "DELETE FROM jurnal WHERE jurnal_id = ".$pkid[0];
				$this->db->query($query);
			} else {
				$query = "DELETE FROM jurnal WHERE ";
				for($i = 0; $i < sizeof($pkid); $i++){
					$query = $query . "jurnal_id= ".$pkid[$i];
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
		function jurnal_search($jurnal_no ,$jurnal_tgl_awal ,$jurnal_tgl_akhir ,$start,$end){
			//full query
			$query="select * from vu_jurnal
					WHERE date_format(jurnal_tanggal,'%Y-%m-%d') >= (select setup_periode_awal from akun_setup limit 1)
					AND date_format(jurnal_tanggal,'%Y-%m-%d')<= (select setup_periode_akhir from akun_setup limit 1)";

			if($jurnal_tgl_awal!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " date_format(jurnal_tanggal,'%Y-%m-%d')>='".$jurnal_tgl_awal."'";
			};
			if($jurnal_tgl_akhir!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " date_format(jurnal_tanggal,'%Y-%m-%d')<='".$jurnal_tgl_akhir."'";
			};
			if($jurnal_no!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " jurnal_no LIKE '%".$jurnal_no."%'";
			};

			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
			if($start=="") $start=0;
			if($end=="") $end=15;
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
		function jurnal_print($jurnal_no ,$jurnal_tgl_awal ,$jurnal_tgl_akhir ,$option,$filter){
			//full query
			$sql="select * from vu_jurnal
					WHERE date_format(jurnal_tanggal,'%Y-%m-%d')>=date_format('".$_SESSION["periode_awal"]."','%Y-%m-%d')
					AND date_format(jurnal_tanggal,'%Y-%m-%d')<=date_format('".$_SESSION["periode_akhir"]."','%Y-%m-%d')";

			if($option=='LIST'){
				$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
				$sql .= " (jurnal_no LIKE '%".addslashes($filter)."%' OR jurnal_tanggal LIKE '%".addslashes($filter)."%')";
				$sql .=" ORDER by jurnal_no DESC, djurnal_id DESC";
				$query = $this->db->query($sql);
			} else if($option=='SEARCH'){
				if($jurnal_tgl_awal!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " date_format(jurnal_tanggal,'%Y-%m-%d')>='".$jurnal_tgl_awal."'";
				};
				if($jurnal_tgl_akhir!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " date_format(jurnal_tanggal,'%Y-%m-%d')<='".$jurnal_tgl_akhir."'";
				};
				if($jurnal_no!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " jurnal_no LIKE '%".$jurnal_no."%'";
				};
				$sql .=" ORDER by jurnal_no DESC, djurnal_id DESC";
				$query = $this->db->query($sql);
			}
			return $query->result();
		}

		//function  for export to excel
		function jurnal_export_excel($jurnal_no ,$jurnal_tgl_awal ,$jurnal_tgl_akhir ,$option,$filter){
			//full query
			$sql="select * from vu_jurnal
					WHERE date_format(jurnal_tanggal,'%Y-%m-%d') >= (select setup_periode_awal from akun_setup limit 1)
					  AND date_format(jurnal_tanggal,'%Y-%m-%d') <= (select setup_periode_akhir from akun_setup limit 1)";

			if($option=='LIST'){
				$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
				$sql .= " (jurnal_no LIKE '%".addslashes($filter)."%' OR jurnal_tanggal LIKE '%".addslashes($filter)."%')";
				$query = $this->db->query($sql);
			} else if($option=='SEARCH'){
				if($jurnal_tgl_awal!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " date_format(jurnal_tanggal,'%Y-%m-%d')>='".$jurnal_tgl_awal."'";
				};
				if($jurnal_tgl_akhir!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " date_format(jurnal_tanggal,'%Y-%m-%d')<='".$jurnal_tgl_akhir."'";
				};
				if($jurnal_no!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " jurnal_no LIKE '%".$jurnal_no."%'";
				};
				$query = $this->db->query($sql);
			}
			return $query;
		}

}
?>