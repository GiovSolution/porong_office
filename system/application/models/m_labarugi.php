<? /* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
    #songbee	mukhlisona@gmail.com
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: labarugi Model
	+ Description	: For record model process back-end
	+ Filename 		: c_labarugi.php
 	+ Author  		: Zainal, Anam
 	+ Created on 12/Mar/2010 10:45:40
	
*/

class M_labarugi extends Model{
		
		//constructor
		function M_labarugi() {
			parent::Model();
		}
	

		//function for advanced search record
		function labarugi_search($buku_periode, $buku_tglawal, $buku_tglakhir, $buku_bulan, $buku_tahun, $buku_akun, $start,$end){		
			
			
			//AKUN LEVEL 1
			$sql = "SELECT	
						A.akun_id, A.akun_saldo, A.akun_kode, A.akun_jenis, A.akun_nama, A.akun_level,
						B.akun_id as akun_parent_id, B.akun_nama as akun_parent, B.akun_kode as akun_parent_kode
					FROM 	akun A, akun B
					WHERE 	A.akun_level=2  
							AND A.	akun_parent_kode=B.akun_kode
							AND A.akun_jenis='R/L'
							AND B.akun_level=1
					ORDER by A.akun_parent_kode ASC";
					
			$master=$this->db->query($sql);
			$nbrows=$master->num_rows();

			$saldo=0;
			$i=0;
			$labarugi_tot = 0;
			$labarugi_tot_periode = 0;
			
			foreach($master->result() as $row){
				
				//s/d bulan ini
				$sql = "SELECT 
							A.akun_kode, sum(B.buku_debet) as debet, sum(B.buku_kredit) as kredit
						FROM buku_besar B, akun A
						WHERE 
							B.buku_akun = A.akun_id AND
							replace(A.akun_kode,'.','') like '".str_replace(".","",$row->akun_kode)."%' AND
							B.buku_tanggal >= (select setup_periode_awal from akun_setup limit 1) and
							B.buku_tanggal <= (select setup_periode_akhir from akun_setup limit 1) ";
							/*AND substring(replace(A.akun_kode,'.',''), 3) like '".substr(str_replace(".","",$row->akun_kode), 2)."%' ";*/
						//substring(x, 3) (mysql) & substr(x, 2) (php) --> karena 2 digit awal tidak dipakai (menunjukkan kode divisi)
				if($buku_periode=="bulan"){
					$sql.="	AND date_format(buku_tanggal,'%Y-%m')<='".$buku_tahun."-".$buku_bulan."'";
				}
				
				//print_r($sql);
				
				//$sql.="GROUP BY A.akun_kode";
				//$sql.="	ORDER BY A.akun_kode ASC";
				
				//GET SALDO BEFORE
				$data[$i]["labarugi_saldo"]=0;
				
				$sqlsaldo =    "SELECT
									A.akun_kode,sum(A.akun_debet) as debet,sum(A.akun_kredit) as kredit, A.akun_saldo
								FROM vu_akun A
								WHERE 
									replace(A.akun_kode,'.','') like '".str_replace(".","",$row->akun_kode)."%' ";
									/*substring(replace(A.akun_kode,'.',''), 3) like '".substr(str_replace(".","",$row->akun_kode), 2)."%' ";*/
									/*replace(A.akun_kode,'.','') like  '".str_replace(".","",$row->akun_kode)."%'";*/
				//$sqlsaldo.=" GROUP BY A.akun_kode ";
				$sqlsaldo.="	ORDER BY A.akun_kode ASC ";
								
				$rssaldo=$this->db->query($sqlsaldo);
				if($rssaldo->num_rows()){
					$rowsaldo=$rssaldo->row();
					if($rowsaldo->akun_saldo=='Debet'){
						$data[$i]["labarugi_saldo"]= ($rowsaldo->debet-$rowsaldo->kredit);
					}else{
						$data[$i]["labarugi_saldo"]= ($rowsaldo->kredit-$rowsaldo->debet);
					}
				//print_r($sqlsaldo);
				}
				$labarugi_tot += ($rowsaldo->kredit - $rowsaldo->debet);
				
				
				//----->
					
				$isi=$this->db->query($sql);
				if($isi->num_rows()){
					$rowisi=$isi->row();
				
/*					print_r($sql);
					print_r(', akun_kode: '); print_r($rowisi->akun_kode);
					print_r(', debet: '); print_r($rowisi->debet);
					print_r(', kredit: '); print_r($rowisi->kredit);					
*/				
					$data[$i]["labarugi_akun"]=$row->akun_id;
					$data[$i]["labarugi_jenis"]=$row->akun_parent;
					$data[$i]["labarugi_jenis_id"]=$row->akun_parent_id;
					$data[$i]["labarugi_akun_kode"]=$row->akun_kode;
					$data[$i]["labarugi_akun_nama"]=$row->akun_nama;
	
					if($row->akun_saldo=='Debet'){
						$data[$i]["labarugi_saldo"]+= ($rowisi->debet-$rowisi->kredit);
					}else{
						$data[$i]["labarugi_saldo"]+= ($rowisi->kredit-$rowisi->debet);	
					}
				}else{
					$data[$i]["labarugi_akun"]=$row->akun_id;
					$data[$i]["labarugi_jenis"]=$row->akun_parent;
					$data[$i]["labarugi_jenis_id"]=$row->akun_parent_id;
					$data[$i]["labarugi_akun_kode"]=$row->akun_kode;
					$data[$i]["labarugi_akun_nama"]=$row->akun_nama;
					$data[$i]["labarugi_saldo"]=0;
				}
				$labarugi_tot += ($rowisi->kredit - $rowisi->debet);
								
				//bulan ini
				$sql = "SELECT 
							A.akun_kode, sum(B.buku_debet) as debet, sum(B.buku_kredit) as kredit
						FROM buku_besar B, akun A
						WHERE 
							B.buku_akun = A.akun_id AND
							replace(A.akun_kode,'.','') like '".str_replace(".","",$row->akun_kode)."%' AND
							B.buku_tanggal >= (select setup_periode_awal from akun_setup limit 1) AND
							B.buku_tanggal <= (select setup_periode_akhir from akun_setup limit 1) ";
							/*AND substring(replace(A.akun_kode,'.',''), 3) like '".substr(str_replace(".","",$row->akun_kode), 2)."%' ";*/
						//substring(x, 3) (mysql) & substr(x, 2) (php) --> karena 2 digit awal tidak dipakai (menunjukkan kode divisi)
				if($buku_periode=="bulan"){
					$sql.="	AND date_format(buku_tanggal,'%Y-%m')='".$buku_tahun."-".$buku_bulan."'";
				}
				//$sql.="GROUP BY A.akun_kode";
				//$sql.="	ORDER BY A.akun_kode ASC";
				
				//print_r($sql);
						
				$isi=$this->db->query($sql);
				if($isi->num_rows()){
					$rowisi=$isi->row();
					if($row->akun_saldo=='Debet')
						$data[$i]["labarugi_saldo_periode"]= ($rowisi->debet-$rowisi->kredit);
					else
						$data[$i]["labarugi_saldo_periode"]= ($rowisi->kredit-$rowisi->debet);	
				}else{
					$data[$i]["labarugi_saldo_periode"]=0;
				}
				$labarugi_tot_periode += ($rowisi->kredit - $rowisi->debet);
				
				$i++;
			}
			
					$data[$i]["labarugi_akun"]			= '';
					$data[$i]["labarugi_jenis"]			= '';
					$data[$i]["labarugi_jenis_id"]		= '';
					$data[$i]["labarugi_akun_kode"]		= '';
					$data[$i]["labarugi_akun_nama"]		= "<b>TOTAL LABA / RUGI :</b>";
					$data[$i]["labarugi_saldo_periode"]	= $labarugi_tot_periode;
					$data[$i]["labarugi_saldo"]			= $labarugi_tot;
					
			if($nbrows>0){
				$jsonresult = json_encode($data);
				return '({"total":"'.$nbrows.'","results":'.$jsonresult.'})';
			} else {
				return '({"total":"0", "results":""})';
			}
		}
		
		/*function labarugi_footer(){
			$sql="SELECT * FROM tbl_s_rl_setting";
			$isi=$this->db->query($sql);
			return $isi->result();
		}*/
		
		
		function labarugi_print($buku_periode, $buku_tglawal, $buku_tglakhir, $buku_bulan, $buku_tahun, $buku_akun, $start,$end){
			
			//AKUN LEVEL 1
			$sql="SELECT A.akun_id,A.akun_saldo,A.akun_kode,A.akun_jenis,A.akun_nama,A.akun_level,B.akun_id as akun_parent_id, B.akun_nama as akun_parent 
					FROM akun A, akun B
					WHERE A.akun_level=2  
					AND A.akun_parent_kode=B.akun_kode
					AND A.akun_jenis='R/L'
					AND B.akun_level=1
					ORDER by A.akun_kode ASC";
					
			$master=$this->db->query($sql);
			$nbrows=$master->num_rows();

			$saldo=0;
			$i=0;

			$saldo=0;
			$i=0;
			foreach($master->result() as $row){
										
					//s/d bulan ini
				$sql="SELECT A.akun_kode,sum(B.buku_debet) as debet,sum(B.buku_kredit) as kredit
						FROM	buku_besar B, akun A
						WHERE 
							B.buku_akun=A.akun_id AND
							replace(A.akun_kode,'.','') like  '".str_replace(".","",$row->akun_kode)."%' AND
							B.buku_tanggal >= (select setup_periode_awal from akun_setup limit 1) AND
							B.buku_tanggal <= (select setup_periode_akhir from akun_setup limit 1)";
				if($buku_periode=="bulan"){
					$sql.="	AND date_format(buku_tanggal,'%Y-%m')<='".$buku_tahun."-".$buku_bulan."'";
				}
				$sql.="GROUP BY A.akun_kode";
				$sql.="	ORDER BY A.akun_kode ASC";
				
				//GET SALDO BEFORE
				$data[$i]["labarugi_saldo"]=0;
				
				$sqlsaldo="SELECT 	A.akun_kode,sum(A.akun_debet) as debet,sum(A.akun_kredit) as kredit, A.akun_saldo
						FROM	vu_akun A
						WHERE   replace(A.akun_kode,'.','') like  '".str_replace(".","",$row->akun_kode)."%'";
				$sqlsaldo.="GROUP BY A.akun_kode";
				$sqlsaldo.="	ORDER BY A.akun_kode ASC";
				
				$rssaldo=$this->db->query($sqlsaldo);
				if($rssaldo->num_rows()){
					$rowsaldo=$rssaldo->row();
					if($rowsaldo->akun_saldo=='Debet'){
						$data[$i]["labarugi_saldo"]= ($rowsaldo->debet-$rowsaldo->kredit);
					}else{
						$data[$i]["labarugi_saldo"]= ($rowsaldo->debet-$rowsaldo->kredit);
					}
				}
				//----->
				
				$isi=$this->db->query($sql);
				if($isi->num_rows()){
					$rowisi=$isi->row();
					$data[$i]["labarugi_akun"]=$row->akun_id;
					$data[$i]["labarugi_jenis"]=$row->akun_parent;
					$data[$i]["labarugi_jenis_id"]=$row->akun_parent_id;
					$data[$i]["labarugi_akun_kode"]=$row->akun_kode;
					$data[$i]["labarugi_akun_nama"]=$row->akun_nama;
					
					if($row->akun_saldo=='Debet'){
						$data[$i]["labarugi_saldo"]= ($rowisi->debet-$rowisi->kredit);
					}else{
						$data[$i]["labarugi_saldo"]= ($rowisi->kredit-$rowisi->debet);	
					}
				}else{
					$data[$i]["labarugi_akun"]=$row->akun_id;
					$data[$i]["labarugi_jenis"]=$row->akun_parent;
					$data[$i]["labarugi_jenis_id"]=$row->akun_parent_id;
					$data[$i]["labarugi_akun_kode"]=$row->akun_kode;
					$data[$i]["labarugi_akun_nama"]=$row->akun_nama;
					$data[$i]["labarugi_saldo"]=0;
				}
				
				//bulan ini
				$sql="SELECT A.akun_kode,sum(B.buku_debet) as debet,sum(B.buku_kredit) as kredit
						FROM	buku_besar B, akun A
						WHERE 
							B.buku_akun=A.akun_id AND 
							replace(A.akun_kode,'.','') like  '".str_replace(".","",$row->akun_kode)."%' AND
							B.buku_tanggal >= (select setup_periode_awal from akun_setup limit 1) AND
							B.buku_tanggal <= (select setup_periode_akhir from akun_setup limit 1)";
				if($buku_periode=="bulan"){
					$sql.="	AND date_format(buku_tanggal,'%Y-%m')='".$buku_tahun."-".$buku_bulan."'";
				}
				$sql.="GROUP BY A.akun_kode";
				$sql.="	ORDER BY A.akun_kode ASC";
						
				$isi=$this->db->query($sql);
				if($isi->num_rows()){
					$rowisi=$isi->row();
					if($row->akun_saldo=='Debet')
						$data[$i]["labarugi_saldo_periode"]= ($rowisi->debet-$rowisi->kredit);
					else
						$data[$i]["labarugi_saldo_periode"]= ($rowisi->kredit-$rowisi->debet);	
				}else{
					$data[$i]["labarugi_saldo_periode"]=0;
				}
				
					
				$i++;
			}
			
			if($master->num_rows()>0){
				$this->firephp->log("masuk");
				return $data;
			}else{
				return 0;
			}
		}
		
		//function  for export to excel
		function labarugi_export_excel($buku_id ,$buku_tanggal ,$buku_akun ,$buku_debet ,$buku_kredit ,$buku_saldo_debet ,$buku_saldo_kredit ,$option,$filter){
			//full query
			$query="select * from labarugi";
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (buku_id LIKE '%".addslashes($filter)."%' OR buku_tanggal LIKE '%".addslashes($filter)."%' OR buku_akun LIKE '%".addslashes($filter)."%' OR buku_debet LIKE '%".addslashes($filter)."%' OR buku_kredit LIKE '%".addslashes($filter)."%' OR buku_saldo_debet LIKE '%".addslashes($filter)."%' OR buku_saldo_kredit LIKE '%".addslashes($filter)."%' )";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($buku_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " buku_id LIKE '%".$buku_id."%'";
				};
				if($buku_tanggal!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " buku_tanggal LIKE '%".$buku_tanggal."%'";
				};
				if($buku_akun!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " buku_akun LIKE '%".$buku_akun."%'";
				};
				if($buku_debet!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " buku_debet LIKE '%".$buku_debet."%'";
				};
				if($buku_kredit!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " buku_kredit LIKE '%".$buku_kredit."%'";
				};
				if($buku_saldo_debet!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " buku_saldo_debet LIKE '%".$buku_saldo_debet."%'";
				};
				if($buku_saldo_kredit!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " buku_saldo_kredit LIKE '%".$buku_saldo_kredit."%'";
				};
				$result = $this->db->query($query);
			}
			return $result;
		}
}
?>