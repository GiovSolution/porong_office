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

class M_Trial_balance extends Model{

		//constructor
		function M_Trial_balance() {
			parent::Model();
		}

		function trial_balance_generate($tgl_awal, $tgl_akhir ){
			
			//SUM buku besar per kode akun
			/*$sql = "SELECT hasil.*
					FROM 
					(	SELECT 
							A.akun_id,
							A.akun_kode,
							A.akun_nama,
							A.akun_debet,
							A.akun_kredit,
							A.akun_saldo,
							ifnull(sum(b.buku_debet), 0) AS buku_debet,
							ifnull(sum(b.buku_kredit), 0) AS buku_kredit
						FROM akun A
						LEFT JOIN buku_besar b ON b.buku_akun = A.akun_id
						WHERE 
							b.buku_tanggal >= (select setup_periode_awal from akun_setup limit 1) and
							b.buku_tanggal <= (select setup_periode_akhir from akun_setup limit 1)								
						GROUP BY A.akun_id
					) AS hasil
					WHERE 
						hasil.buku_debet > 0 OR 
						hasil.buku_kredit > 0 OR
						hasil.akun_kredit > 0 OR
						hasil.akun_debet > 0
					ORDER by akun_kode ASC";
			*/
			
			$sql = "SELECT 
						akun_id, akun_kode, akun_nama, akun_saldo,
						sum(akun_debet) as akun_debet, 
						sum(akun_kredit) as akun_kredit, 
						sum(buku_debet) as buku_debet, 
						sum(buku_kredit) as buku_kredit
					FROM 
					(	
						SELECT 
							A.akun_id,
							A.akun_kode,
							A.akun_nama,
							0 as akun_debet,
							0 as akun_kredit,
							A.akun_saldo,
							ifnull(sum(b.buku_debet), 0) AS buku_debet,
							ifnull(sum(b.buku_kredit), 0) AS buku_kredit
						FROM akun A
						LEFT JOIN buku_besar b ON b.buku_akun = A.akun_id
						WHERE 
							b.buku_tanggal >= (select setup_periode_awal from akun_setup limit 1) and
							b.buku_tanggal <= (select setup_periode_akhir from akun_setup limit 1)								
						GROUP BY A.akun_id
						
						union
						
						select
							akun_id,
							akun_kode,
							akun_nama,
							akun_debet,
							akun_kredit,
							akun_saldo,
							0 AS buku_debet,
							0 AS buku_kredit
						FROM vu_akun	
					) 
					AS hasil
					WHERE 
						buku_debet <> 0 OR 
						buku_kredit <> 0 OR
						akun_kredit <> 0 OR
						akun_debet <> 0
					GROUP BY akun_id
					ORDER by akun_kode ASC
			";
			$result = $this->db->query($sql);
			$nbrows= $result->num_rows();
			
			//$this->firephp->log($limit);
			$i=0;
			$j=0;
			$group_akun="";
			$group_akun_s="";
			$saldo=0;
			if($nbrows>0){
				
				$sqldel="DELETE from trial_balance 
						 WHERE date_format(akun_periode_awal,'Y-m-d')=date_format('".$tgl_awal."','Y-m-d')
						 AND date_format(akun_periode_akhir,'Y-m-d')=date_format('".$tgl_akhir."','Y-m-d')";
				$this->db->query($sqldel);
				
				foreach($result->result() as $row){

					//VAR  SALDO AWAL dan BUKU
					$buku_debet=0;
					$buku_kredit=0;
					$saldo_awal=0;

					//CEK TRANSAKSINYA
					$sqlbuku="SELECT  ifnull(sum(buku_debet),0) as buku_debet, ifnull(sum(buku_kredit),0) as buku_kredit
							FROM buku_besar WHERE buku_akun='".$row->akun_id."'";
					if($tgl_awal!=''){
						$sqlbuku.=eregi("WHERE",$sqlbuku)?" AND ":" WHERE ";
						$sqlbuku.= " date_format(buku_tanggal,'%Y-%m-%d') >= '".$tgl_awal."'";
					}

					if($tgl_akhir!=''){
						$sqlbuku.=eregi("WHERE",$sqlbuku)?" AND ":" WHERE ";
						$sqlbuku.= " date_format(buku_tanggal,'%Y-%m-%d') <= '".$tgl_akhir."'";
					}

					$rsbuku=$this->db->query($sqlbuku);
					if($rsbuku->num_rows()){
						$rowbuku=$rsbuku->row();
						$buku_debet=$rowbuku->buku_debet;
						$buku_kredit=$rowbuku->buku_kredit;
					}

					//CEK SALDO AWALNYA

					if($tgl_awal!==""){
						if($row->akun_saldo=='Debet'){
							$sql = "SELECT sum(ifnull(buku_debet, 0)) - sum(ifnull(buku_kredit, 0)) as buku_saldo
									FROM buku_besar
									WHERE 
										buku_akun = ".$row->akun_id." and
										buku_tanggal >= (select setup_periode_awal from akun_setup limit 1) and
										buku_tanggal <= (select setup_periode_akhir from akun_setup limit 1) and
										buku_tanggal < '".$tgl_awal."'";
						} else {
							$sql = "SELECT sum(ifnull(buku_kredit, 0)) - sum(ifnull(buku_debet, 0)) as buku_saldo
									FROM buku_besar
									WHERE 
										buku_akun = ".$row->akun_id." and
										buku_tanggal >= (select setup_periode_awal from akun_setup limit 1) and
										buku_tanggal <= (select setup_periode_akhir from akun_setup limit 1) and
										buku_tanggal < '".$tgl_awal."'";
						}
						$rs_saldo_awal=$this->db->query($sql);
						if($rs_saldo_awal->num_rows()){
							$row_saldo_awal=$rs_saldo_awal->row();
							//$saldo_awal=$row_saldo_awal->buku_saldo;

							if($row->akun_saldo=='Debet'){
								$saldo_awal=$row_saldo_awal->buku_saldo+$row->akun_debet-$row->akun_kredit;
							}else{
								$saldo_awal=$row_saldo_awal->buku_saldo+$row->akun_kredit-$row->akun_debet;
							}

						}
					}else{
						if($row->akun_saldo=='Debet'){
							$saldo_awal=$row->akun_debet-$row->akun_kredit;
						}else{
							$saldo_awal=$row->akun_kredit-$row->akun_debet;
						}
					}

					$trial_akun_id=$row->akun_id;
					$trial_akun_kode=$row->akun_kode;
					$trial_akun_nama=$row->akun_nama;
					$trial_akun_jenis=($row->akun_saldo=='Debet'?'DB':'CR');
					$trial_akun_saldo_jenis=($row->akun_saldo=='Debet'?'DB':'CR');
					$trial_akun_debet=$buku_debet;
					$trial_akun_kredit=$buku_kredit;
					$trial_akun_awal=$saldo_awal;
					$trial_akun_awal_jenis=($row->akun_saldo=='Debet'?'DB':'CR');

					if($row->akun_saldo=='Debet'){
						/*$trial_akun_awal=($trial_akun_awal<0?abs($trial_akun_awal):$trial_akun_awal);
						$trial_akun_awal_jenis=($trial_akun_awal<0?"CR":"DB");*/
						
						$trial_akun_saldo=$trial_akun_awal+$trial_akun_debet-$trial_akun_kredit;
					}else{
						/*$trial_akun_awal=($trial_akun_awal<0?abs($trial_akun_awal):$trial_akun_awal);
						$trial_akun_awal_jenis=($trial_akun_awal<0?"DB":"CR");*/
						$trial_akun_saldo=$trial_akun_awal-$trial_akun_debet+$trial_akun_kredit;
					}

					/*if($trial_akun_saldo<0){
						$trial_akun_saldo=abs($trial_akun_saldo);
						$trial_akun_saldo_jenis=($trial_akun_jenis=='CR'?'DB':'CR');
					}*/
					
					$sql="INSERT INTO trial_balance(akun_id,
                                         akun_kode,
                                         akun_nama,
                                         akun_jenis,
                                         akun_saldo,
                                         akun_debet,
                                         akun_kredit,
                                         akun_awal,
                                         akun_awal_jenis,
                                         akun_akhir,
                                         akun_akhir_jenis,
                                         akun_periode_awal,
                                         akun_periode_akhir,
                                         akun_generate_date)
								VALUES (".$trial_akun_id.",
										'".$trial_akun_kode."',
										'".$trial_akun_nama."',
										'".$trial_akun_jenis."',
										'".$trial_akun_saldo_jenis."',
										".$trial_akun_debet.",
										".$trial_akun_kredit.",
										".$trial_akun_awal.",
										'".$trial_akun_awal_jenis."',
										".$trial_akun_saldo.",
										'".$trial_akun_saldo_jenis."',
										'".$tgl_awal."',
										'".$tgl_akhir."',
										'".date('Y-m-d')."')";
					$this->db->query($sql);
					
					
				}
				/* SQL asli dari Zainal
				$sql="INSERT INTO trial_balance(akun_id,
                                         akun_kode,
                                         akun_nama,
                                         akun_jenis,
                                         akun_saldo,
                                         akun_debet,
                                         akun_kredit,
                                         akun_awal,
                                         akun_awal_jenis,
                                         akun_akhir,
                                         akun_akhir_jenis,
                                         akun_periode_awal,
                                         akun_periode_akhir,
                                         akun_generate_date)
						 SELECT 999999999 as akun_id, '999.999.999' as akun_kode,
						        'TOTAL' as akun_nama, 'D/K' as akun_jenis, 'D/K' as akun_saldo,
								sum(akun_debet) as debet, sum(akun_kredit) as akun_kredit,
								sum(akun_awal) as akun_awal, 'D/K' as akun_awal_jenis,
								sum(akun_awal) as akun_akhir, 'D/K' as akun_akhir_jenis,
								akun_periode_awal,
								akun_periode_akhir,
								akun_generate_date
						FROM  trial_balance
						WHERE  date_format(akun_periode_awal,'Y-m-d')=date_format('".$tgl_awal."','Y-m-d')
								AND date_format(akun_periode_akhir,'Y-m-d')=date_format('".$tgl_akhir."','Y-m-d')";
				*/		
				
				// SQL dari Hendri
				$sql = "INSERT INTO trial_balance(
							akun_id,
							akun_kode,
							akun_nama,
							akun_jenis,
							akun_saldo,
							akun_debet,
							akun_kredit,
							akun_awal,
							akun_awal_jenis,
							akun_akhir,
							akun_akhir_jenis,
							akun_periode_awal,
							akun_periode_akhir,
							akun_generate_date)
						SELECT 
							999999999 as akun_id, 
							'999.999.999' as akun_kode,
							'TOTAL' as akun_nama, 
							'D/K' as akun_jenis, 
							'D/K' as akun_saldo,
							sum(akun_debet) as debet, 
							sum(akun_kredit) as akun_kredit,
							sum(case when akun_awal_jenis = 'DB' then akun_awal else -akun_awal end) as akun_awal, 
							'D/K' as akun_awal_jenis,
							sum(case when akun_akhir_jenis = 'DB' then akun_akhir else -akun_akhir end) as akun_akhir, 
							'D/K' as akun_akhir_jenis,
							akun_periode_awal,
							akun_periode_akhir,
							akun_generate_date
						FROM  trial_balance
						WHERE  date_format(akun_periode_awal,'Y-m-d')=date_format('".$tgl_awal."','Y-m-d')
								AND date_format(akun_periode_akhir,'Y-m-d')=date_format('".$tgl_akhir."','Y-m-d')";
					$this->db->query($sql);
				
			}
			
			return '1';
		}
		
				//function for advanced search record
		function trial_balance_search($tgl_awal, $tgl_akhir ,$start,$end ){

			$sql="SELECT akun_id,
					   akun_kode,
					   akun_nama,
					   akun_jenis,
					   akun_saldo,
					   akun_debet,
					   akun_kredit,
					   akun_awal,
					   akun_awal_jenis,
					   akun_akhir,
					   akun_akhir_jenis,
					   akun_periode_awal,
					   akun_periode_akhir,
					   akun_generate_date
				  FROM trial_balance
				  WHERE date_format(akun_periode_awal,'Y-m-d')=date_format('".$tgl_awal."','Y-m-d') 
				  		AND date_format(akun_periode_akhir,'Y-m-d')=date_format('".$tgl_akhir."','Y-m-d')";
			$result=$this->db->query($sql);
			$nbrows=$result->num_rows();
			$sql.=" ORDER BY akun_kode ";
			if($end=="") $end=15;
			$limit = $sql." LIMIT ".$start.",".$end;
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

		//function for print record
		function trial_balance_print($tgl_awal, $tgl_akhir ,$start,$end){
			
			$sql="SELECT akun_id,
					   akun_kode,
					   akun_nama,
					   akun_jenis,
					   akun_saldo,
					   akun_debet,
					   akun_kredit,
					   akun_awal,
					   akun_awal_jenis,
					   akun_akhir,
					   akun_akhir_jenis,
					   akun_periode_awal,
					   akun_periode_akhir,
					   akun_generate_date
				  FROM trial_balance
				  WHERE date_format(akun_periode_awal,'Y-m-d')=date_format('".$tgl_awal."','Y-m-d') 
				  		AND date_format(akun_periode_akhir,'Y-m-d')=date_format('".$tgl_akhir."','Y-m-d')";
			$sql.=" ORDER BY akun_kode ";
			$result=$this->db->query($sql);
			$nbrows=$result->num_rows();
			//$this->firephp->log($sql);
			
			if($nbrows>0){
				return $result->result();
			} else {
				return NULL;
			}
		}

		//function  for export to excel
		function trial_balance_export_excel($buku_akun, $tgl_awal, $tgl_akhir ,$start,$end){
			$sql="SELECT akun_id,
					   akun_kode,
					   akun_nama,
					   akun_jenis,
					   akun_saldo,
					   akun_debet,
					   akun_kredit,
					   akun_awal,
					   akun_awal_jenis,
					   akun_akhir,
					   akun_akhir_jenis,
					   akun_periode_awal,
					   akun_periode_akhir,
					   akun_generate_date
				  FROM trial_balance
				  WHERE date_format(akun_periode_awal,'Y-m-d')=date_format('".$tgl_awal."','Y-m-d') 
				  		AND date_format(akun_periode_akhir,'Y-m-d')=date_format('".$tgl_akhir."','Y-m-d')";
			$result=$this->db->query($sql);
			$nbrows=$result->num_rows();
			
			$result = $this->db->query($query);
			
			if($nbrows>0){
				return $result->result();
			} else {
				return NULL;
			}
		}
}
?>