<? /* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
    #songbee	mukhlisona@gmail.com
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: jurnal_harian Model
	+ Description	: For record model process back-end
	+ Filename 		: c_jurnal_harian.php
 	+ creator 		: 
 	+ Created on 01/Apr/2010 12:13:56
	
*/

class M_jurnal_harian extends Model{
		
		//constructor
		function M_jurnal_harian() {
			parent::Model();
		}
		
		function get_akun_list($task, $master_id, $selected_id, $filter="",$start=0,$end=15){
			$sql = "SELECT A.* from akun A
					WHERE A.akun_kode not in (
					SELECT B.akun_parent_kode FROM akun B WHERE B.akun_parent_kode is NOT NULL)";
	
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
		function jurnal_harian_list($filter,$start,$end){
			/*$query = "SELECT vu_jurnal_harian.*,date_format(tanggal,'%Y-%m-%d') as tanggal FROM vu_jurnal_harian 
						WHERE jurnal_arsip='T'";

			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " tanggal LIKE '%".addslashes($filter)."%' OR 
							no_jurnal LIKE '%".addslashes($filter)."%' ";
			}
			
			$query.=" ORDER by no_jurnal DESC";
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
			$limit = $query." LIMIT ".$start.",".$end;		
			$result = $this->db->query($limit);  
			
			*/
			
			$query="SELECT N.* FROM (";
			$query.= "SELECT J.`jurnal_no` AS `no_jurnal`,
				  date_format(J.`jurnal_tanggal`,'%Y-%m-%d') AS `tanggal`,
				  J.`djurnal_akun` AS `akun`,
				  J.`akun_kode` AS `akun_kode`,
				  J.`akun_nama` AS `akun_nama`,
				  J.`djurnal_detail` AS `keterangan`,
				  J.`djurnal_debet` AS `debet`,
				  J.`djurnal_kredit` AS `kredit`,
				  J.`jurnal_post` AS `post`,
				  J.`jurnal_date_post` AS `post_date`
			 FROM `vu_jurnal` J
			 WHERE (J.jurnal_post<>'Y' OR J.jurnal_post IS NULL)
			 AND date_format(J.jurnal_tanggal,'%Y-%m-%d') >= (select setup_periode_awal from akun_setup limit 1)
			 AND date_format(J.jurnal_tanggal,'%Y-%m-%d') <= (select setup_periode_akhir from akun_setup limit 1)";


			if ($filter<>""){
				$query .= " AND ";
				$query .= " (J.jurnal_tanggal LIKE '%".addslashes($filter)."%' OR
							J.jurnal_no LIKE '%".addslashes($filter)."%' OR
							J.akun_kode LIKE '%".addslashes($filter)."%') ";
			}

		   $query.=" UNION ";
		   $query.=" SELECT K.`no_jurnal` AS `no_jurnal`,
				  date_format(K.`tanggal`,'%Y-%m-%d') AS `tanggal`,
				  K.`akun` AS `akun`,
				  K.`akun_kode` AS `akun_kode`,
				  K.`akun_nama` AS `akun_nama`,
				  K.`keterangan` AS `keterangan`,
				  K.`debet` AS `debet`,
				  K.`kredit` AS `kredit`,
				  K.`post` AS `post`,
				  K.`post_date` AS `post_date`
			 FROM `vu_jurnal_bank` K
			 WHERE (K.post<>'Y' OR K.post is NULL)
			 AND date_format(K.tanggal,'%Y-%m-%d') >= (select setup_periode_awal from akun_setup limit 1)
			 AND date_format(K.tanggal,'%Y-%m-%d') <= (select setup_periode_akhir from akun_setup limit 1)";

			if ($filter<>""){
				$query .= " AND ";
				$query .= " (K.tanggal LIKE '%".addslashes($filter)."%' OR
							K.no_jurnal LIKE '%".addslashes($filter)."%' OR
							K.akun_kode LIKE '%".addslashes($filter)."%') ";
			}

			$query.=") as N";

			$query.=" ORDER by N.tanggal, N.no_jurnal DESC";
			//$this->firephp->log($query);
			$nbrows=0;
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
			$limit = $query." LIMIT ".$start.",".$end;
			$result = $this->db->query($limit);
			
			//$this->firephp->log($nbrows);
			
			
			
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
		
		
		//function for advanced search record
		function jurnal_harian_search($jurnal_no ,$jurnal_tgl_awal ,$jurnal_tgl_akhir ,$start,$end){
			//full query
			/*$query="SELECT vu_jurnal_harian.*,date_format(tanggal,'%Y-%m-%d') as tanggal FROM vu_jurnal_harian ";
			

			if($jurnal_tgl_awal!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " date_format(tanggal,'%Y-%m-%d')>='".$jurnal_tgl_awal."'";
			};
			if($jurnal_tgl_akhir!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " date_format(tanggal,'%Y-%m-%d')<='".$jurnal_tgl_akhir."'";
			};
			if($jurnal_no!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " no_jurnal LIKE '%".$jurnal_no."%'";
			};
			
			$query.=" ORDER by no_jurnal DESC";
			
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
			$limit = $query." LIMIT ".$start.",".$end;		
			$result = $this->db->query($limit);*/

			$query="SELECT N.* FROM (";
			$query.= "SELECT J.`jurnal_no` AS `no_jurnal`,
				  date_format(J.`jurnal_tanggal`,'%Y-%m-%d') AS `tanggal`,
				  J.`djurnal_akun` AS `akun`,
				  J.`akun_kode` AS `akun_kode`,
				  J.`akun_nama` AS `akun_nama`,
				  J.`djurnal_detail` AS `keterangan`,
				  J.`djurnal_debet` AS `debet`,
				  J.`djurnal_kredit` AS `kredit`,
				  J.`jurnal_post` AS `post`,
				  J.`jurnal_date_post` AS `post_date`
			 FROM `vu_jurnal` J
			 WHERE 
			 date_format(J.jurnal_tanggal,'%Y-%m-%d') >= (select setup_periode_awal from akun_setup limit 1)
			 AND date_format(J.jurnal_tanggal,'%Y-%m-%d') <= (select setup_periode_akhir from akun_setup limit 1)";


			if($jurnal_tgl_awal!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " date_format(J.jurnal_tanggal,'%Y-%m-%d')>='".$jurnal_tgl_awal."'";
			};
			if($jurnal_tgl_akhir!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " date_format(J.jurnal_tanggal,'%Y-%m-%d')<='".$jurnal_tgl_akhir."'";
			};
			if($jurnal_no!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " J.jurnal_no LIKE '%".$jurnal_no."%'";
			};


		   $query.=" UNION ";
		   $query.=" SELECT K.`no_jurnal` AS `no_jurnal`,
				  date_format(K.`tanggal`,'%Y-%m-%d') AS `tanggal`,
				  K.`akun` AS `akun`,
				  K.`akun_kode` AS `akun_kode`,
				  K.`akun_nama` AS `akun_nama`,
				  K.`keterangan` AS `keterangan`,
				  K.`debet` AS `debet`,
				  K.`kredit` AS `kredit`,
				  K.`post` AS `post`,
				  K.`post_date` AS `post_date`
			 FROM `vu_jurnal_bank` K
			 WHERE 
			 date_format(K.tanggal,'%Y-%m-%d') >= (select setup_periode_awal from akun_setup limit 1)
			 AND date_format(K.tanggal,'%Y-%m-%d') <= (select setup_periode_akhir from akun_setup limit 1)";

			if($jurnal_tgl_awal!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " date_format(K.tanggal,'%Y-%m-%d')>='".$jurnal_tgl_awal."'";
			};
			if($jurnal_tgl_akhir!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " date_format(K.tanggal,'%Y-%m-%d')<='".$jurnal_tgl_akhir."'";
			};
			if($jurnal_no!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " K.no_jurnal LIKE '%".$jurnal_no."%'";
			};


			$query.=") as N";

			$query.=" ORDER by N.tanggal, N.no_jurnal DESC";
			//$this->firephp->log($query);
			//$nbrows=0;
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
		function jurnal_harian_print($jurnal_no ,$jurnal_tgl_awal ,$jurnal_tgl_akhir ,$option,$filter){
			//full query
			/*$sql="SELECT vu_jurnal_harian.*,date_format(tanggal,'%Y-%m-%d') as tanggal FROM vu_jurnal_harian ";
			if($option=='LIST'){
				$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
				$sql .= " (no_jurnal LIKE '%".addslashes($filter)."%' OR tanggal LIKE '%".addslashes($filter)."%')";
				$query = $this->db->query($sql);
			} else if($option=='SEARCH'){
				if($jurnal_tgl_awal!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " date_format(tanggal,'%Y-%m-%d')>='".$jurnal_tgl_awal."'";
				};
				if($jurnal_tgl_akhir!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " date_format(tanggal,'%Y-%m-%d')<='".$jurnal_tgl_akhir."'";
				};
				if($jurnal_no!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " no_jurnal LIKE '%".$jurnal_no."%'";
				};
				$query = $this->db->query($sql);
			}*/
			
			$query="SELECT N.* FROM (";
			$query.= "SELECT J.`jurnal_no` AS `no_jurnal`,
				  date_format(J.`jurnal_tanggal`,'%Y-%m-%d') AS `tanggal`,
				  J.`djurnal_akun` AS `akun`,
				  J.`akun_kode` AS `akun_kode`,
				  J.`akun_nama` AS `akun_nama`,
				  J.`djurnal_detail` AS `keterangan`,
				  J.`djurnal_debet` AS `debet`,
				  J.`djurnal_kredit` AS `kredit`,
				  J.`jurnal_post` AS `post`,
				  J.`jurnal_date_post` AS `post_date`
			 FROM `vu_jurnal` J
			 WHERE jurnal_post<>'Y'
			 AND date_format(J.jurnal_tanggal,'%Y-%m-%d') >= (select setup_periode_awal from akun_setup limit 1)
			 AND date_format(J.jurnal_tanggal,'%Y-%m-%d') <= (select setup_periode_akhir from akun_setup limit 1)";


			if($jurnal_tgl_awal!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " date_format(J.jurnal_tanggal,'%Y-%m-%d')>='".$jurnal_tgl_awal."'";
			};
			if($jurnal_tgl_akhir!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " date_format(J.jurnal_tanggal,'%Y-%m-%d')<='".$jurnal_tgl_akhir."'";
			};
			if($jurnal_no!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " J.jurnal_no LIKE '%".$jurnal_no."%'";
			};


		   $query.=" UNION ";
		   $query.=" SELECT K.`no_jurnal` AS `no_jurnal`,
				  date_format(K.`tanggal`,'%Y-%m-%d') AS `tanggal`,
				  K.`akun` AS `akun`,
				  K.`akun_kode` AS `akun_kode`,
				  K.`akun_nama` AS `akun_nama`,
				  K.`keterangan` AS `keterangan`,
				  K.`debet` AS `debet`,
				  K.`kredit` AS `kredit`,
				  K.`post` AS `post`,
				  K.`post_date` AS `post_date`
			 FROM `vu_jurnal_bank` K
			 WHERE date_format(K.tanggal,'%Y-%m-%d') >= (select setup_periode_awal from akun_setup limit 1)
			 AND date_format(K.tanggal,'%Y-%m-%d') <= (select setup_periode_akhir from akun_setup limit 1)";

			if($jurnal_tgl_awal!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " date_format(K.tanggal,'%Y-%m-%d')>='".$jurnal_tgl_awal."'";
			};
			if($jurnal_tgl_akhir!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " date_format(K.tanggal,'%Y-%m-%d')<='".$jurnal_tgl_akhir."'";
			};
			if($jurnal_no!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " K.no_jurnal LIKE '%".$jurnal_no."%'";
			};

			$query.=") as N";
			$query.=" ORDER by N.tanggal, N.no_jurnal DESC";

			$query = $this->db->query($query);
			
			return $query->result();
		}
		
		//function  for export to excel
		function jurnal_harian_export_excel($jurnal_no ,$jurnal_tgl_awal ,$jurnal_tgl_akhir ,$option,$filter){
			//full query
			$sql="SELECT vu_jurnal_harian.*,date_format(tanggal,'%Y-%m-%d') as tanggal FROM vu_jurnal_harian ";
			if($option=='LIST'){
				$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
				$sql .= " (no_jurnal LIKE '%".addslashes($filter)."%' OR tanggal LIKE '%".addslashes($filter)."%')";
				$query = $this->db->query($sql);
			} else if($option=='SEARCH'){
				if($jurnal_tgl_awal!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " date_format(tanggal,'%Y-%m-%d')>='".$jurnal_tgl_awal."'";
				};
				if($jurnal_tgl_akhir!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " date_format(tanggal,'%Y-%m-%d')<='".$jurnal_tgl_akhir."'";
				};
				if($jurnal_no!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " no_jurnal LIKE '%".$jurnal_no."%'";
				};
				$query = $this->db->query($sql);
			}
			return $query;
		}
		
}
?>