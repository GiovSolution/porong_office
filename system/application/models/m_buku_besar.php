<? /* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
    #songbee	mukhlisona@gmail.com
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: buku_besar Model
	+ Description	: For record model process back-end
	+ Filename 		: c_buku_besar.php
 	+ creator 		: 
 	+ Created on 27/May/2010 16:40:49
	
*/

class M_buku_besar extends Model{
		
		//constructor
		function M_buku_besar() {
			parent::Model();
		}
		
		function get_akun_list($filter,$start,$end){
			$query =   "SELECT 
							A.*, B.akun_id as akun_parent_id, B.akun_kode as akun_parent_kode, B.akun_nama as akun_parent_nama
						FROM akun A 
						LEFT JOIN akun B ON (/*A.akun_parent_kode=B.akun_kode OR*/ A.akun_parent=B.akun_id) AND A.akun_aktif='Y' AND A.akun_level>2";

			// For simple search
			if ($filter<>"" && $query !=""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (A.akun_kode LIKE '%".addslashes($filter)."%' OR 
							 A.akun_jenis LIKE '%".addslashes($filter)."%' OR
							 A.akun_nama LIKE '%".addslashes($filter)."%' OR 
							 A.akun_saldo LIKE '%".addslashes($filter)."%' )";
				$limit = $query;
			}
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
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
		
		
		//function for get list record
		function buku_besar_list($filter,$start,$end){
			$query="SELECT * FROM `buku_besar` 
					Inner Join `akun` ON `buku_besar`.`buku_akun` = `akun`.`akun_id` 
					ORDER BY buku_tanggal ASC";

			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " ( buku_tanggal LIKE '%".addslashes($filter)."%' OR 
							  buku_ref LIKE '%".addslashes($filter)."%' OR 
							  buku_akun LIKE '%".addslashes($filter)."%' )";
			}
			
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
			$limit = $query." LIMIT ".$start.",".$end;		
			$result = $this->db->query($limit);  
			$i=0;
			$saldo=0;
			if($nbrows>0){
				foreach($result->result() as $row){
					$data[$i]["buku_id"] = $row->buku_id;
					$data[$i]["buku_tanggal"] = $row->buku_tanggal;
					$data[$i]["buku_ref"] = $row->buku_ref;
					$data[$i]["buku_akun"] = $row->buku_akun;
					$data[$i]["buku_akun_kode"] = $row->akun_kode;
					$data[$i]["akun_nama"] = $row->akun_nama;
					$data[$i]["buku_debet"] = $row->buku_debet;
					$data[$i]["buku_kredit"] = $row->buku_kredit;
					$data[$i]["buku_saldo"] = $saldo+($row->buku_debet-$row->buku_kredit);
					$data[$i]["buku_author"] = $row->buku_author;
					$data[$i]["buku_date_create"] = $row->buku_date_create;
					$data[$i]["buku_update"] = $row->buku_update;
					$data[$i]["buku_revised"] = $row->buku_revised;
					
					$saldo = ($row->buku_debet-$row->buku_kredit);
					$i++;
				}
				$jsonresult = json_encode($data);
				return '({"total":"'.$nbrows.'","results":'.$jsonresult.'})';
			} else {
				return '({"total":"0", "results":""})';
			}
		}
		
		//function for create new record
		function buku_besar_create($buku_tanggal ,$buku_ref ,$buku_akun ,$buku_debet ,$buku_kredit ,$buku_author ,$buku_date_create ){
			$data = array(
				"buku_tanggal"=>$buku_tanggal, 
				"buku_ref"=>$buku_ref, 
				"buku_akun"=>$buku_akun, 
				"buku_debet"=>$buku_debet, 
				"buku_kredit"=>$buku_kredit, 
				"buku_author"=>$buku_author, 
				"buku_date_create"=>$buku_date_create 
			);
			$this->db->insert('buku_besar', $data); 
			if($this->db->affected_rows())
				return '1';
			else
				return '0';
		}
		
		//function for update record
		function buku_besar_update($buku_id,$buku_tanggal,$buku_ref,$buku_akun,$buku_debet,$buku_kredit,$buku_update,$buku_date_update){
			$data = array(
				"buku_tanggal"=>$buku_tanggal, 
				"buku_ref"=>$buku_ref, 
				"buku_akun"=>$buku_akun, 
				"buku_debet"=>$buku_debet, 
				"buku_kredit"=>$buku_kredit, 
				"buku_update"=>$buku_update, 
				"buku_date_update"=>$buku_date_update 
			);
			
			$this->db->where('buku_id', $buku_id);
			$this->db->update('buku_besar', $data);
			$sql="UPDATE buku_besar set buku_revised=(buku_revised+1) where buku_id='".$buku_id."'";
			$this->db->query($sql);
			return '1';
		}
		
		//fcuntion for delete record
		function buku_besar_delete($pkid){
			// You could do some checkups here and return '0' or other error consts.
			// Make a single query to delete all of the buku_besars at the same time :
			if(sizeof($pkid)<1){
				return '0';
			} else if (sizeof($pkid) == 1){
				$query = "DELETE FROM buku_besar WHERE buku_id = ".$pkid[0];
				$this->db->query($query);
			} else {
				$query = "DELETE FROM buku_besar WHERE ";
				for($i = 0; $i < sizeof($pkid); $i++){
					$query = $query . "buku_id= ".$pkid[$i];
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
		function buku_besar_search($buku_akun, $buku_tanggal, $buku_tanggalEnd ,$start,$end ){
			
			$query="SELECT * FROM vu_buku_besar WHERE (buku_kredit>0 OR buku_debet>0)";
			
			if($buku_tanggal!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " buku_tanggal >= '".$buku_tanggal."'";
			}
			
			if($buku_tanggalEnd!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " buku_tanggal <= '".$buku_tanggalEnd."'";
			}
			
			
			$akun_kode="";
			$akun_nama="";
			if($buku_akun!=''){
				$sql="SELECT akun_kode,akun_nama FROM akun WHERE akun_id='".$buku_akun."'";
				$result=$this->db->query($sql);
				if($result->num_rows()){
					$row=$result->row();
					$akun_kode=$row->akun_kode;
					$akun_nama=$row->akun_nama;
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " replace(akun_kode,'.','') like  '".str_replace(".","",$row->akun_kode)."%'";
				}
			}else{
				
			}
				
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
			$limit = $query." ORDER BY buku_akun, buku_tanggal, buku_ref  "." LIMIT ".$start.",".$end;
			
			//$this->firephp->log($limit);
			$result = $this->db->query($limit);   
			$i=0;
			$group_akun="";
			$group_akun_s="";
			$saldo=0;
			if($nbrows>0){
				foreach($result->result() as $row){
					
					if($akun_kode!=="")
					{
						if(trim($group_akun_s)<>trim($akun_kode)){
							
							//$this->firephp->log("akun : ".$akun_kode.", group : ".$group_akun_s);
							$group_akun_s=$akun_kode;
							if($buku_tanggal!=="")
							{
									if($row->akun_saldo=='Debet'){
										$sql = "SELECT 
													(
														select sum(a.akun_debet - a.akun_kredit)
														from vu_akun a
														where replace(a.akun_kode,'.','') like '".str_replace(".","",$akun_kode)."%'
													) +
													ifnull(sum(buku_debet), 0) - ifnull(sum(buku_kredit), 0) as buku_saldo
												FROM vu_buku_besar
												WHERE replace(akun_kode,'.','') like  '".str_replace(".","",$akun_kode)."%'
													AND buku_tanggal < '".$buku_tanggal."'
													AND buku_tanggal >= (select setup_periode_awal from akun_setup limit 1)
													AND buku_tanggal <= (select setup_periode_akhir from akun_setup limit 1)";
									}
									else{
										$sql = "SELECT 
													(
														select sum(a.akun_kredit - a.akun_debet)
														from vu_akun a
														where replace(a.akun_kode,'.','') like '".str_replace(".","",$akun_kode)."%'
													) +													
													ifnull(sum(buku_kredit), 0) - ifnull(sum(buku_debet), 0) as buku_saldo
												FROM vu_buku_besar
												WHERE replace(akun_kode,'.','') like  '".str_replace(".","",$akun_kode)."%'
													AND buku_tanggal < '".$buku_tanggal."'
													AND buku_tanggal >= (select setup_periode_awal from akun_setup limit 1)
													AND buku_tanggal <= (select setup_periode_akhir from akun_setup limit 1)";
									}
									$result=$this->db->query($sql);
									if($result->num_rows()){
										$rowdata=$result->row();
										$data[$i]["buku_akun_kode"] = $akun_kode;
										$data[$i]["buku_akun_nama"] = $akun_nama;
										$data[$i]["buku_id"] = '';
										$data[$i]["buku_tanggal"] = '';
										$data[$i]["buku_ref"] = '';
										$data[$i]["buku_akun"] = '';
										$data[$i]["akun_nama"] = "<b>Saldo Awal: ".$akun_nama."</b>";;
										$data[$i]["akun_kode"] = $akun_kode;
										$data[$i]["buku_debet"] = 0; //$rowdata->buku_saldo;
										$data[$i]["buku_saldo"] = $rowdata->buku_saldo;
										$data[$i]["buku_kredit"] = 0;
										$data[$i]["buku_author"] = '';
										$data[$i]["buku_date_create"] = '';
										$data[$i]["buku_update"] = '';
										$data[$i]["buku_revised"] = '';
										$saldo=$rowdata->buku_saldo;
										$i++;
									}else{							
										$data[$i]["buku_akun_kode"] = $akun_kode;
										$data[$i]["buku_akun_nama"] = $akun_nama;
										$data[$i]["buku_id"] = '';
										$data[$i]["buku_tanggal"] = '';
										$data[$i]["buku_ref"] = '';
										$data[$i]["buku_akun"] = '';
										$data[$i]["akun_nama"] = "<b>Saldo Awal: ".$akun_nama."</b>";
										$data[$i]["akun_kode"] = $akun_kode;
										$data[$i]["buku_debet"] =0;
										$data[$i]["buku_kredit"] = 0;
										$data[$i]["buku_saldo"] =0;
										$data[$i]["buku_author"] = '';
										$data[$i]["buku_date_create"] = '';
										$data[$i]["buku_update"] = '';
										$data[$i]["buku_revised"] = '';
										$i++;
									}
							}else{							
								$data[$i]["buku_akun_kode"] = $akun_kode;
								$data[$i]["buku_akun_nama"] = $akun_nama;
								$data[$i]["buku_id"] = '';
								$data[$i]["buku_tanggal"] = '';
								$data[$i]["buku_ref"] = '';
								$data[$i]["buku_akun"] = '';
								$data[$i]["akun_nama"] = "<b>Saldo Awal: ".$akun_nama."</b>";
								$data[$i]["akun_kode"] = $akun_kode;
								$data[$i]["buku_debet"] =0;
								$data[$i]["buku_saldo"] =0;
								$data[$i]["buku_kredit"] = 0;
								$data[$i]["buku_author"] = '';
								$data[$i]["buku_date_create"] = '';
								$data[$i]["buku_update"] = '';
								$data[$i]["buku_revised"] = '';
								$i++;
							}
							
						}
	
						$data[$i]["buku_akun_kode"] = $akun_kode;
						$data[$i]["buku_akun_nama"] = $akun_nama;
					}else
					{
						if($row->akun_kode!==$group_akun){
							$saldo=0; 
							
							if(trim($group_akun_s)<>trim($row->akun_kode)){
								$group_akun_s=$row->akun_kode;
								if($buku_tanggal!=="")
								{
										if($row->akun_saldo=='Debet'){
										$sql = "SELECT 
													(
														select sum(a.akun_debet - a.akun_kredit)
														from vu_akun a
														where replace(a.akun_kode,'.','') like '".str_replace(".","",$row->akun_kode)."%'
													) -														
													ifnull(sum(buku_debet), 0) - ifnull(sum(buku_kredit), 0) as buku_saldo
												FROM vu_buku_besar
												WHERE replace(akun_kode,'.','') like  '".str_replace(".","",$row->akun_kode)."%'
												AND buku_tanggal < '".$buku_tanggal."'
												AND buku_tanggal >= (select setup_periode_awal from akun_setup limit 1)
												AND buku_tanggal <= (select setup_periode_akhir from akun_setup limit 1)";
										}
										else{
										$sql = "SELECT 										
													(
														select sum(a.akun_kredit - a.akun_kredit)
														from vu_akun a
														where replace(a.akun_kode,'.','') like '".str_replace(".","",$row->akun_kode)."%'
													) -																											
													ifnull(sum(buku_kredit), 0) - ifnull(sum(buku_debet), 0) as buku_saldo
												FROM vu_buku_besar
												WHERE replace(akun_kode,'.','') like  '".str_replace(".","",$row->akun_kode)."%'
												AND buku_tanggal < '".$buku_tanggal."'												
												AND buku_tanggal >= (select setup_periode_awal from akun_setup limit 1)
												AND buku_tanggal <= (select setup_periode_akhir from akun_setup limit 1)";
										}
										$result=$this->db->query($sql);
										if($result->num_rows()){
											$rowdata=$result->row();
											$data[$i]["buku_akun_kode"] = $row->akun_kode;
											$data[$i]["buku_akun_nama"] = $row->akun_nama;
											$data[$i]["buku_id"] = '';
											$data[$i]["buku_tanggal"] = '';
											$data[$i]["buku_ref"] = '';
											$data[$i]["buku_akun"] = '';
											$data[$i]["akun_nama"] = "<b>Saldo Awal: ".$row->akun_nama."</b>";;
											$data[$i]["akun_kode"] = $row->akun_kode;
											$data[$i]["buku_debet"] = 0;//$rowdata->buku_saldo;
											$data[$i]["buku_saldo"] = $rowdata->buku_saldo;
											$data[$i]["buku_kredit"] = 0;
											$data[$i]["buku_author"] = '';
											$data[$i]["buku_date_create"] = '';
											$data[$i]["buku_update"] = '';
											$data[$i]["buku_revised"] = '';
											$saldo=$rowdata->buku_saldo;
											$i++;
										}else{							
											$data[$i]["buku_akun_kode"] = $row->akun_kode;
											$data[$i]["buku_akun_nama"] = $row->akun_nama;
											$data[$i]["buku_id"] = '';
											$data[$i]["buku_tanggal"] = '';
											$data[$i]["buku_ref"] = '';
											$data[$i]["buku_akun"] = '';
											$data[$i]["akun_nama"] = "<b>Saldo Awal: ".$row->akun_nama."</b>";
											$data[$i]["akun_kode"] = $row->akun_kode;
											$data[$i]["buku_debet"] =0;
											$data[$i]["buku_kredit"] = 0;
											$data[$i]["buku_saldo"] =0;
											$data[$i]["buku_author"] = '';
											$data[$i]["buku_date_create"] = '';
											$data[$i]["buku_update"] = '';
											$data[$i]["buku_revised"] = '';
											$i++;
										}
								}else{							
									$data[$i]["buku_akun_kode"] = $row->akun_kode;
									$data[$i]["buku_akun_nama"] = $row->akun_nama;
									$data[$i]["buku_id"] = '';
									$data[$i]["buku_tanggal"] = '';
									$data[$i]["buku_ref"] = '';
									$data[$i]["buku_akun"] = '';
									$data[$i]["akun_nama"] = "<b>Saldo Awal: ".$row->akun_nama."</b>";
									$data[$i]["akun_kode"] = $row->akun_kode;
									$data[$i]["buku_debet"] =0;
									$data[$i]["buku_saldo"] =0;
									$data[$i]["buku_kredit"] = 0;
									$data[$i]["buku_author"] = '';
									$data[$i]["buku_date_create"] = '';
									$data[$i]["buku_update"] = '';
									$data[$i]["buku_revised"] = '';
									$i++;
								}
							
							}
						
						}
						
						
						$data[$i]["buku_akun_kode"] = $row->akun_kode;
						$data[$i]["buku_akun_nama"] =$row->akun_nama;
					}
					
					$group_akun=$row->akun_kode;
					
					$data[$i]["buku_id"] = $row->buku_id;
					$data[$i]["buku_tanggal"] = $row->buku_tanggal;
					$data[$i]["buku_ref"] = $row->buku_ref;
					
					$data[$i]["buku_akun"] = $row->buku_akun;
					$data[$i]["akun_nama"] = $row->akun_nama;
					$data[$i]["akun_kode"] = $row->akun_kode;
					$data[$i]["buku_debet"] = $row->buku_debet;
					$data[$i]["buku_kredit"] = $row->buku_kredit;
					$data[$i]["buku_author"] = $row->buku_author;
					$data[$i]["buku_date_create"] = $row->buku_date_create;
					$data[$i]["buku_update"] = $row->buku_update;
					$data[$i]["buku_revised"] = $row->buku_revised;
					$data[$i]["buku_keterangan"] = $row->buku_keterangan;
															
					
					if($row->akun_saldo=='Debet')
						$saldo+= ($row->buku_debet-$row->buku_kredit);
					else
						$saldo+= ($row->buku_kredit-$row->buku_debet);
					$data[$i]["buku_saldo"] = $saldo;
					
					
					$i++;
				}
				$jsonresult = json_encode($data);
				return  '({"total":"'.$nbrows.'","results":'.$jsonresult.'})';
			} else {
				return '({"total":"0", "results":""})';
			}
		}
		
		//function for print record
		function buku_besar_print($buku_akun, $buku_tanggal, $buku_tanggalEnd ,$start,$end){
			$query="SELECT *,date_format(buku_tanggal,'%Y-%m-%d') as buku_tanggal FROM vu_buku_besar WHERE (buku_kredit>0 OR buku_debet>0)";
			
			if($buku_tanggal!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " buku_tanggal >= '".$buku_tanggal."'";
			}
			
			if($buku_tanggalEnd!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " buku_tanggal <= '".$buku_tanggalEnd."'";
			}
			
			
			$akun_kode="";
			$akun_nama="";
			if($buku_akun!=''){
				$sql="SELECT akun_kode,akun_nama FROM akun WHERE akun_id='".$buku_akun."'";
				$result=$this->db->query($sql);
				if($result->num_rows()){
					$row=$result->row();
					$akun_kode=$row->akun_kode;
					$akun_nama=$row->akun_nama;
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " replace(akun_kode,'.','') like  '".str_replace(".","",$row->akun_kode)."%'";
				}
			}else{
				
			}
				
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
			$limit = $query." ORDER BY buku_akun, buku_tanggal, buku_ref  ";//." LIMIT ".$start.",".$end;
			
			//$this->firephp->log($limit);
			$result = $this->db->query($limit);   
			$i=0;
			$group_akun="";
			$group_akun_s="";
			$saldo=0;
			if($nbrows>0){
				foreach($result->result() as $row){
					
					if($akun_kode!=="")
					{
						if(trim($group_akun_s)<>trim($akun_kode)){
							
							//$this->firephp->log("akun : ".$akun_kode.", group : ".$group_akun_s);
							$group_akun_s=$akun_kode;
							if($buku_tanggal!=="")
							{
									if($row->akun_saldo=='Debet'){
									$sql="SELECT 
													(
														select sum(a.akun_debet - a.akun_kredit)
														from vu_akun a
														where replace(a.akun_kode,'.','') like '".str_replace(".","",$akun_kode)."%'
													) -
													ifnull(sum(buku_debet), 0) - ifnull(sum(buku_kredit), 0) as buku_saldo
												FROM vu_buku_besar
												WHERE replace(akun_kode,'.','') like  '".str_replace(".","",$akun_kode)."%'
													AND buku_tanggal < '".$buku_tanggal."'
													AND buku_tanggal >= (select setup_periode_awal from akun_setup limit 1)
													AND buku_tanggal <= (select setup_periode_akhir from akun_setup limit 1)";
									}else{
										$sql="SELECT 
													(
														select sum(a.akun_kredit - a.akun_debet)
														from vu_akun a
														where replace(a.akun_kode,'.','') like '".str_replace(".","",$akun_kode)."%'
													) -													
													ifnull(sum(buku_kredit), 0) - ifnull(sum(buku_debet), 0) as buku_saldo
												FROM vu_buku_besar
												WHERE replace(akun_kode,'.','') like  '".str_replace(".","",$akun_kode)."%'
													AND buku_tanggal < '".$buku_tanggal."'
													AND buku_tanggal >= (select setup_periode_awal from akun_setup limit 1)
													AND buku_tanggal <= (select setup_periode_akhir from akun_setup limit 1)";
									}
									$result=$this->db->query($sql);
									if($result->num_rows()){
										$rowdata=$result->row();
										$data[$i]["buku_akun_kode"] = $akun_kode;
										$data[$i]["buku_akun_nama"] = $akun_nama;
										$data[$i]["buku_keterangan"] = $row->buku_keterangan;
										$data[$i]["buku_id"] = '';
										$data[$i]["buku_tanggal"] = '';
										$data[$i]["buku_ref"] = '';
										$data[$i]["buku_akun"] = '';
										$data[$i]["akun_nama"] = "<b>Saldo Awal : ".$akun_nama."</b>";;
										$data[$i]["akun_kode"] = $akun_kode;
										$data[$i]["buku_debet"] = 0;//$rowdata->buku_saldo;
										$data[$i]["buku_saldo"] = $rowdata->buku_saldo;
										$data[$i]["buku_kredit"] = 0;
										$data[$i]["buku_author"] = '';
										$data[$i]["buku_date_create"] = '';
										$data[$i]["buku_update"] = '';
										$data[$i]["buku_revised"] = '';
										$saldo=$rowdata->buku_saldo;
										$i++;
									}else{							
										$data[$i]["buku_akun_kode"] = $akun_kode;
										$data[$i]["buku_akun_nama"] = $akun_nama;
										$data[$i]["buku_id"] = '';
										$data[$i]["buku_tanggal"] = '';
										$data[$i]["buku_ref"] = '';
										$data[$i]["buku_akun"] = '';
										$data[$i]["akun_nama"] = "<b>Saldo Awal : ".$akun_nama."</b>";
										$data[$i]["akun_kode"] = $akun_kode;
										$data[$i]["buku_debet"] =0;
										$data[$i]["buku_kredit"] = 0;
										$data[$i]["buku_saldo"] =0;
										$data[$i]["buku_author"] = '';
										$data[$i]["buku_date_create"] = '';
										$data[$i]["buku_update"] = '';
										$data[$i]["buku_revised"] = '';
										$i++;
									}
							}else{							
								$data[$i]["buku_akun_kode"] = $akun_kode;
								$data[$i]["buku_akun_nama"] = $akun_nama;
								$data[$i]["buku_keterangan"] = $row->buku_keterangan;
								$data[$i]["buku_id"] = '';
								$data[$i]["buku_tanggal"] = '';
								$data[$i]["buku_ref"] = '';
								$data[$i]["buku_akun"] = '';
								$data[$i]["akun_nama"] = "<b>Saldo Awal : ".$akun_nama."</b>";
								$data[$i]["akun_kode"] = $akun_kode;
								$data[$i]["buku_debet"] =0;
								$data[$i]["buku_saldo"] =0;
								$data[$i]["buku_kredit"] = 0;
								$data[$i]["buku_author"] = '';
								$data[$i]["buku_date_create"] = '';
								$data[$i]["buku_update"] = '';
								$data[$i]["buku_revised"] = '';
								$i++;
							}
							
						}
	
						$data[$i]["buku_akun_kode"] = $akun_kode;
						$data[$i]["buku_akun_nama"] = $akun_nama;
					}else
					{
						if($row->akun_kode!==$group_akun){
							$saldo=0; 
							
							if(trim($group_akun_s)<>trim($row->akun_kode)){
								$group_akun_s=$row->akun_kode;
								if($buku_tanggal!=="")
								{
										if($row->akun_saldo=='Debet'){
										$sql="SELECT 
													(
														select sum(a.akun_debet - a.akun_kredit)
														from vu_akun a
														where replace(a.akun_kode,'.','') like '".str_replace(".","",$akun_kode)."%'
													) -														
													ifnull(sum(buku_debet), 0) - ifnull(sum(buku_kredit), 0) as buku_saldo
												FROM vu_buku_besar
												WHERE replace(akun_kode,'.','') like  '".str_replace(".","",$row->akun_kode)."%'
												AND buku_tanggal < '".$buku_tanggal."'
												AND buku_tanggal >= (select setup_periode_awal from akun_setup limit 1)
												AND buku_tanggal <= (select setup_periode_akhir from akun_setup limit 1)";
										}else{
											$sql="SELECT 										
													(
														select sum(a.akun_kredit - a.akun_debit)
														from vu_akun a
														where replace(a.akun_kode,'.','') like '".str_replace(".","",$akun_kode)."%'
													) -																											
													ifnull(sum(buku_kredit), 0) - ifnull(sum(buku_debet), 0) as buku_saldo
												FROM vu_buku_besar
												WHERE replace(akun_kode,'.','') like  '".str_replace(".","",$row->akun_kode)."%'
												AND buku_tanggal < '".$buku_tanggal."'
													AND buku_tanggal >= (select setup_periode_awal from akun_setup limit 1)
													AND buku_tanggal <= (select setup_periode_akhir from akun_setup limit 1)";
										}
										$result=$this->db->query($sql);
										if($result->num_rows()){
											$rowdata=$result->row();
											$data[$i]["buku_akun_kode"] = $akun_kode;
											$data[$i]["buku_akun_nama"] = $akun_nama;
											$data[$i]["buku_keterangan"] = $row->buku_keterangan;
											$data[$i]["buku_id"] = '';
											$data[$i]["buku_tanggal"] = '';
											$data[$i]["buku_ref"] = '';
											$data[$i]["buku_akun"] = '';
											$data[$i]["akun_nama"] = "<b>Saldo Awal : ".$row->akun_nama."</b>";;
											$data[$i]["akun_kode"] = $row->akun_kode;
											$data[$i]["buku_debet"] = 0;//$rowdata->buku_saldo;
											$data[$i]["buku_saldo"] = $rowdata->buku_saldo;
											$data[$i]["buku_kredit"] = 0;
											$data[$i]["buku_author"] = '';
											$data[$i]["buku_date_create"] = '';
											$data[$i]["buku_update"] = '';
											$data[$i]["buku_revised"] = '';
											$saldo=$rowdata->buku_saldo;
											$i++;
										}else{							
											$data[$i]["buku_akun_kode"] = $row->akun_kode;
											$data[$i]["buku_akun_nama"] = $row->akun_nama;
											$data[$i]["buku_keterangan"] = $row->buku_keterangan;
											$data[$i]["buku_id"] = '';
											$data[$i]["buku_tanggal"] = '';
											$data[$i]["buku_ref"] = '';
											$data[$i]["buku_akun"] = '';
											$data[$i]["akun_nama"] = "<b>Saldo Awal : ".$row->akun_nama."</b>";
											$data[$i]["akun_kode"] = $row->akun_kode;
											$data[$i]["buku_debet"] =0;
											$data[$i]["buku_kredit"] = 0;
											$data[$i]["buku_saldo"] =0;
											$data[$i]["buku_author"] = '';
											$data[$i]["buku_date_create"] = '';
											$data[$i]["buku_update"] = '';
											$data[$i]["buku_revised"] = '';
											$i++;
										}
								}else{							
									$data[$i]["buku_akun_kode"] = $row->akun_kode;
									$data[$i]["buku_akun_nama"] = $row->akun_nama;
									$data[$i]["buku_keterangan"] = $row->buku_keterangan;
									$data[$i]["buku_id"] = '';
									$data[$i]["buku_tanggal"] = '';
									$data[$i]["buku_ref"] = '';
									$data[$i]["buku_akun"] = '';
									$data[$i]["akun_nama"] = "<b>Saldo Awal : ".$row->akun_nama."</b>";
									$data[$i]["akun_kode"] = $row->akun_kode;
									$data[$i]["buku_saldo"] =0;
									$data[$i]["buku_debet"] =0;
									$data[$i]["buku_kredit"] = 0;
									$data[$i]["buku_author"] = '';
									$data[$i]["buku_date_create"] = '';
									$data[$i]["buku_update"] = '';
									$data[$i]["buku_revised"] = '';
									$i++;
								}
							
							}
						
						}
						
						
						$data[$i]["buku_akun_kode"] = $row->akun_kode;
						$data[$i]["buku_akun_nama"] =$row->akun_nama;
					}
					
					$group_akun=$row->akun_kode;
					
					$data[$i]["buku_id"] = $row->buku_id;
					$data[$i]["buku_tanggal"] = $row->buku_tanggal;
					$data[$i]["buku_ref"] = $row->buku_ref;
					$data[$i]["buku_keterangan"] = $row->buku_keterangan;
					$data[$i]["buku_akun"] = $row->buku_akun;
					$data[$i]["akun_nama"] = $row->akun_nama;
					$data[$i]["akun_kode"] = $row->akun_kode;
					$data[$i]["buku_debet"] = $row->buku_debet;
					$data[$i]["buku_kredit"] = $row->buku_kredit;
					$data[$i]["buku_author"] = $row->buku_author;
					$data[$i]["buku_date_create"] = $row->buku_date_create;
					$data[$i]["buku_update"] = $row->buku_update;
					$data[$i]["buku_revised"] = $row->buku_revised;
					
					
					if($row->akun_saldo=='Debet')
						$saldo+= ($row->buku_debet-$row->buku_kredit);
					else
						$saldo+= ($row->buku_kredit-$row->buku_debet);
					$data[$i]["buku_saldo"] = $saldo;
					
					
					$i++;
				}
				return $data;
			}else
				return NULL;
			
		}
		
		//function  for export to excel
		function buku_besar_export_excel($buku_akun, $buku_tanggal, $buku_tanggalEnd ,$start,$end){
			//full query
			/*						
			$query="ELECT
				`buku_besar`.`buku_tanggal`,
				`buku_besar`.`buku_ref`,
				`akun`.`akun_nama`,
				`buku_besar`.`buku_debet`,
				`buku_besar`.`buku_kredit`
				FROM `buku_besar` Inner Join `akun` ON `buku_besar`.`buku_akun` = `akun`.`akun_id` ";
			
			
			if($buku_tanggal!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " buku_tanggal >= '".$buku_tanggal."'";
			};
			
			if($buku_tanggalEnd!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " buku_tanggal <= '".$buku_tanggalEnd."'";
			};
			
			if($buku_akun!=''){
			$sql="SELECT akun_kode FROM akun WHERE akun_id='".$buku_akun."'";
			$kode=$this->db->query($sql);
			foreach($kode->result() as $cell){
				$kode_akun = $cell->akun_kode;
			}
			$exp = explode(".", $kode_akun);
			$exp[0];
			
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " akun_kode LIKE '%".$exp[0]."%'";
			}
			
			
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
			$limit = $query." ORDER BY buku_tanggal, buku_id "." LIMIT ".$start.",".$end;
			$result = $this->db->query($limit);   
			
			return $result;
			*/
			$query="SELECT *,date_format(buku_tanggal,'%Y-%m-%d') as buku_tanggal FROM vu_buku_besar WHERE (buku_kredit>0 OR buku_debet>0)";
			
			if($buku_tanggal!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " buku_tanggal >= '".$buku_tanggal."'";
			}
			
			if($buku_tanggalEnd!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " buku_tanggal <= '".$buku_tanggalEnd."'";
			}
			
			
			$akun_kode="";
			$akun_nama="";
			if($buku_akun!=''){
				$sql="SELECT akun_kode,akun_nama FROM akun WHERE akun_id='".$buku_akun."'";
				$result=$this->db->query($sql);
				if($result->num_rows()){
					$row=$result->row();
					$akun_kode=$row->akun_kode;
					$akun_nama=$row->akun_nama;
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " replace(akun_kode,'.','') like  '".str_replace(".","",$row->akun_kode)."%'";
				}
			}else{
				
			}
				
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
			$limit = $query." ORDER BY buku_akun, buku_tanggal  "." LIMIT ".$start.",".$end;
			
			//$this->firephp->log($limit);
			$result = $this->db->query($limit);   
			$i=0;
			$group_akun="";
			$group_akun_s="";
			$saldo=0;
			if($nbrows>0){
				foreach($result->result() as $row){
					
					if($akun_kode!=="")
					{
						if(trim($group_akun_s)<>trim($akun_kode)){
							
							//$this->firephp->log("akun : ".$akun_kode.", group : ".$group_akun_s);
							$group_akun_s=$akun_kode;
							if($buku_tanggal!=="")
							{
									if($row->akun_saldo=='Debet'){
									$sql="SELECT sum(buku_debet)-sum(buku_kredit) as buku_saldo
										FROM vu_buku_besar
										WHERE replace(akun_kode,'.','') like  '".str_replace(".","",$akun_kode)."%'
										AND buku_tanggal <= '".$buku_tanggal."'";
									}else{
										$sql="SELECT sum(buku_kredit)-sum(buku_debet) as buku_saldo
										FROM vu_buku_besar
										WHERE replace(akun_kode,'.','') like  '".str_replace(".","",$akun_kode)."%'
										AND buku_tanggal <= '".$buku_tanggal."'";
									}
									$result=$this->db->query($sql);
									if($result->num_rows()){
										$rowdata=$result->row();
										$data[$i]["buku_akun_kode"] = $akun_kode;
										$data[$i]["buku_akun_nama"] = $akun_nama;
										$data[$i]["buku_keterangan"] = $row->buku_keterangan;
										$data[$i]["buku_id"] = '';
										$data[$i]["buku_tanggal"] = '';
										$data[$i]["buku_ref"] = '';
										$data[$i]["buku_akun"] = '';
										$data[$i]["akun_nama"] = "<b>Saldo Awal : ".$akun_nama."</b>";;
										$data[$i]["akun_kode"] = $akun_kode;
										$data[$i]["buku_debet"] = 0;//$rowdata->buku_saldo;
										$data[$i]["buku_saldo"] = $rowdata->buku_saldo;
										$data[$i]["buku_kredit"] = 0;
										$data[$i]["buku_author"] = '';
										$data[$i]["buku_date_create"] = '';
										$data[$i]["buku_update"] = '';
										$data[$i]["buku_revised"] = '';
										$saldo=$rowdata->buku_saldo;
										$i++;
									}else{							
										$data[$i]["buku_akun_kode"] = $akun_kode;
										$data[$i]["buku_akun_nama"] = $akun_nama;
										$data[$i]["buku_id"] = '';
										$data[$i]["buku_tanggal"] = '';
										$data[$i]["buku_ref"] = '';
										$data[$i]["buku_akun"] = '';
										$data[$i]["akun_nama"] = "<b>Saldo Awal : ".$akun_nama."</b>";
										$data[$i]["akun_kode"] = $akun_kode;
										$data[$i]["buku_debet"] =0;
										$data[$i]["buku_kredit"] = 0;
										$data[$i]["buku_saldo"] =0;
										$data[$i]["buku_author"] = '';
										$data[$i]["buku_date_create"] = '';
										$data[$i]["buku_update"] = '';
										$data[$i]["buku_revised"] = '';
										$i++;
									}
							}else{							
								$data[$i]["buku_akun_kode"] = $akun_kode;
								$data[$i]["buku_akun_nama"] = $akun_nama;
								$data[$i]["buku_keterangan"] = $row->buku_keterangan;
								$data[$i]["buku_id"] = '';
								$data[$i]["buku_tanggal"] = '';
								$data[$i]["buku_ref"] = '';
								$data[$i]["buku_akun"] = '';
								$data[$i]["akun_nama"] = "<b>Saldo Awal : ".$akun_nama."</b>";
								$data[$i]["akun_kode"] = $akun_kode;
								$data[$i]["buku_debet"] =0;
								$data[$i]["buku_saldo"] =0;
								$data[$i]["buku_kredit"] = 0;
								$data[$i]["buku_author"] = '';
								$data[$i]["buku_date_create"] = '';
								$data[$i]["buku_update"] = '';
								$data[$i]["buku_revised"] = '';
								$i++;
							}
							
						}
	
						$data[$i]["buku_akun_kode"] = $akun_kode;
						$data[$i]["buku_akun_nama"] = $akun_nama;
					}else
					{
						if($row->akun_kode!==$group_akun){
							$saldo=0; 
							
							if(trim($group_akun_s)<>trim($row->akun_kode)){
								$group_akun_s=$row->akun_kode;
								if($buku_tanggal!=="")
								{
										if($row->akun_saldo=='Debet'){
										$sql="SELECT sum(buku_debet)-sum(buku_kredit) as buku_saldo
											FROM vu_buku_besar
											WHERE replace(akun_kode,'.','') like  '".str_replace(".","",$row->akun_kode)."%'
											AND buku_tanggal <= '".$buku_tanggal."'";
										}else{
											$sql="SELECT sum(buku_kredit)-sum(buku_debet) as buku_saldo
											FROM vu_buku_besar
											WHERE replace(akun_kode,'.','') like  '".str_replace(".","",$row->akun_kode)."%'
											AND buku_tanggal <= '".$buku_tanggal."'";
										}
										$result=$this->db->query($sql);
										if($result->num_rows()){
											$rowdata=$result->row();
											$data[$i]["buku_akun_kode"] = $akun_kode;
											$data[$i]["buku_akun_nama"] = $akun_nama;
											$data[$i]["buku_keterangan"] = $row->buku_keterangan;
											$data[$i]["buku_id"] = '';
											$data[$i]["buku_tanggal"] = '';
											$data[$i]["buku_ref"] = '';
											$data[$i]["buku_akun"] = '';
											$data[$i]["akun_nama"] = "<b>Saldo Awal : ".$row->akun_nama."</b>";;
											$data[$i]["akun_kode"] = $row->akun_kode;
											$data[$i]["buku_debet"] = 0;//$rowdata->buku_saldo;
											$data[$i]["buku_saldo"] = $rowdata->buku_saldo;
											$data[$i]["buku_kredit"] = 0;
											$data[$i]["buku_author"] = '';
											$data[$i]["buku_date_create"] = '';
											$data[$i]["buku_update"] = '';
											$data[$i]["buku_revised"] = '';
											$saldo=$rowdata->buku_saldo;
											$i++;
										}else{							
											$data[$i]["buku_akun_kode"] = $row->akun_kode;
											$data[$i]["buku_akun_nama"] = $row->akun_nama;
											$data[$i]["buku_keterangan"] = $row->buku_keterangan;
											$data[$i]["buku_id"] = '';
											$data[$i]["buku_tanggal"] = '';
											$data[$i]["buku_ref"] = '';
											$data[$i]["buku_akun"] = '';
											$data[$i]["akun_nama"] = "<b>Saldo Awal : ".$row->akun_nama."</b>";
											$data[$i]["akun_kode"] = $row->akun_kode;
											$data[$i]["buku_debet"] =0;
											$data[$i]["buku_kredit"] = 0;
											$data[$i]["buku_saldo"] =0;
											$data[$i]["buku_author"] = '';
											$data[$i]["buku_date_create"] = '';
											$data[$i]["buku_update"] = '';
											$data[$i]["buku_revised"] = '';
											$i++;
										}
								}else{							
									$data[$i]["buku_akun_kode"] = $row->akun_kode;
									$data[$i]["buku_akun_nama"] = $row->akun_nama;
									$data[$i]["buku_keterangan"] = $row->buku_keterangan;
									$data[$i]["buku_id"] = '';
									$data[$i]["buku_tanggal"] = '';
									$data[$i]["buku_ref"] = '';
									$data[$i]["buku_akun"] = '';
									$data[$i]["akun_nama"] = "<b>Saldo Awal : ".$row->akun_nama."</b>";
									$data[$i]["akun_kode"] = $row->akun_kode;
									$data[$i]["buku_saldo"] =0;
									$data[$i]["buku_debet"] =0;
									$data[$i]["buku_kredit"] = 0;
									$data[$i]["buku_author"] = '';
									$data[$i]["buku_date_create"] = '';
									$data[$i]["buku_update"] = '';
									$data[$i]["buku_revised"] = '';
									$i++;
								}
							
							}
						
						}
						
						
						$data[$i]["buku_akun_kode"] = $row->akun_kode;
						$data[$i]["buku_akun_nama"] =$row->akun_nama;
					}
					
					$group_akun=$row->akun_kode;
					
					$data[$i]["buku_id"] = $row->buku_id;
					$data[$i]["buku_tanggal"] = $row->buku_tanggal;
					$data[$i]["buku_ref"] = $row->buku_ref;
					$data[$i]["buku_keterangan"] = $row->buku_keterangan;
					$data[$i]["buku_akun"] = $row->buku_akun;
					$data[$i]["akun_nama"] = $row->akun_nama;
					$data[$i]["akun_kode"] = $row->akun_kode;
					$data[$i]["buku_debet"] = $row->buku_debet;
					$data[$i]["buku_kredit"] = $row->buku_kredit;
					$data[$i]["buku_author"] = $row->buku_author;
					$data[$i]["buku_date_create"] = $row->buku_date_create;
					$data[$i]["buku_update"] = $row->buku_update;
					$data[$i]["buku_revised"] = $row->buku_revised;
					
					
					if($row->akun_saldo=='Debet')
						$saldo+= ($row->buku_debet-$row->buku_kredit);
					else
						$saldo+= ($row->buku_kredit-$row->buku_debet);
					$data[$i]["buku_saldo"] = $saldo;
					
					
					$i++;
				}
				return $result;
			}else
				return NULL;
		}
		
	
		
		
}
?>