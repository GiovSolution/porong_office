<? /* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com,
    #songbee	mukhlisona@gmail.com
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id

	+ Module  		: neraca Model
	+ Description	: For record model process back-end
	+ Filename 		: c_neraca.php
 	+ Author  		: Zainal, Anam
 	+ Created on 12/Mar/2010 10:45:40

*/

class M_neraca extends Model{

		//constructor
		function M_neraca() {
			parent::Model();
		}
		//function for advanced search record
		function neraca_search($buku_periode, $buku_tglawal, $buku_tglakhir, $buku_bulan, 
								$buku_tahun, $buku_akun, $start,$end, $neraca_jenis){

			if($neraca_jenis=='Aktiva'){
				$neraca_jenis	= 1;
				$neraca_jenis3	= 1;
			}
			else {
				$neraca_jenis	= 2;
				$neraca_jenis3	= 3;
			}
				
			//AKUN LEVEL 1
			$sql = "SELECT 
						A.akun_id, A.akun_saldo, A.akun_kode, A.akun_jenis, A.akun_nama, A.akun_level,
						B.akun_id as akun_parent_id, B.akun_nama as akun_parent
					FROM akun A, akun B
					WHERE 
						A.akun_level=3 AND 
						A.akun_parent_kode=B.akun_kode AND 
						A.akun_jenis='BS' AND 
						B.akun_level=2 AND 
						(A.akun_kode LIKE '__.".$neraca_jenis."%' OR A.akun_kode LIKE '__.".$neraca_jenis3."%')
					ORDER by A.akun_kode ASC";

			$master=$this->db->query($sql);
			//$this->firephp->log($sql);
			$nbrows=$master->num_rows();

			$saldo=0;
			$saldo_akhir=0;
			$i=0;
			$total_nilai_periode=0;
			$total_nilai=0;
			
			foreach($master->result() as $row){
			
				//s/d bulan ini
				
/*				$sql="SELECT A.akun_kode,sum(B.buku_debet) as debet,sum(B.buku_kredit) as kredit
						FROM	buku_besar B, akun A
						WHERE B.buku_akun=A.akun_id
						AND replace(A.akun_kode,'.','') like  '".str_replace(".","",$row->akun_kode)."%'
						AND date_format(buku_tanggal,'%Y-%m-%d')>=date_format('".$_SESSION["periode_awal"]."','%Y-%m-%d')
						AND date_format(buku_tanggal,'%Y-%m-%d')<=date_format('".$_SESSION["periode_akhir"]."','%Y-%m-%d')";
*/
				$sql = "SELECT 
							A.akun_kode,
							sum(B.buku_debet) as debet,
							sum(B.buku_kredit) as kredit
						FROM buku_besar B, akun A
						WHERE 
							B.buku_akun=A.akun_id
							AND replace(A.akun_kode,'.','') like  '".str_replace(".","",$row->akun_kode)."%'
							AND date_format(buku_tanggal,'%Y-%m-%d')>=date_format('".$_SESSION["periode_awal"]."','%Y-%m-%d')
							AND date_format(buku_tanggal,'%Y-%m-%d')<=date_format('".$_SESSION["periode_akhir"]."','%Y-%m-%d')";
					
				if($buku_periode=="bulan"){
					$sql.="	AND date_format(buku_tanggal,'%Y-%m')<='".$buku_tahun."-".$buku_bulan."'";
				}elseif($buku_periode=="tanggal"){
					$sql.="	AND date_format(buku_tanggal,'%Y-%m-%d')<='".$buku_tglakhir."'";
				}
				//$sql.="GROUP BY A.akun_kode";
				$sql.="	ORDER BY A.akun_kode ASC";
				//$this->firephp->log($sql);
				
				
				//GET SALDO BEFORE
				$data[$i]["neraca_saldo"]=0;

				$sqlsaldo =    "SELECT 
									A.akun_kode, sum(A.akun_debet) as debet, sum(A.akun_kredit) as kredit, A.akun_saldo
								FROM vu_akun A
								WHERE replace(A.akun_kode,'.','') like  '".str_replace(".","",$row->akun_kode)."%'";
				
				$rssaldo=$this->db->query($sqlsaldo);
				
				if($rssaldo->num_rows()){
					$rowsaldo=$rssaldo->row();
					if($rowsaldo->akun_saldo=='Debet'){
						$saldo_akhir= ($rowsaldo->debet-$rowsaldo->kredit);
					}else{
						$saldo_akhir= ($rowsaldo->kredit-$rowsaldo->debet);
					}
				}
				//$saldo_akhir=0;
				//$this->firephp->log($sqlsaldo.' '.$saldo_akhir.'<br/>');
				//----->

				$isi=$this->db->query($sql);
				//$this->firephp->log($sql);
				
				if($isi->num_rows()){
					$rowisi=$isi->row();
					$data[$i]["neraca_akun"]=$row->akun_id;
					$data[$i]["neraca_level"]=$row->akun_level;
					$data[$i]["neraca_jenis"]=$row->akun_parent;
					$data[$i]["neraca_jenis_id"]=$row->akun_parent_id;
					$data[$i]["neraca_akun_kode"]=$row->akun_kode;
					$data[$i]["neraca_akun_nama"]=$row->akun_nama;

					if($row->akun_saldo=='Debet'){
						$data[$i]["neraca_saldo"]=$saldo_akhir+($rowisi->debet-$rowisi->kredit);
					}else{
						$data[$i]["neraca_saldo"]=$saldo_akhir+($rowisi->kredit-$rowisi->debet);
					}
				}else{
					$data[$i]["neraca_akun"]=$row->akun_id;
					$data[$i]["neraca_level"]=$row->akun_level;
					$data[$i]["neraca_jenis"]=$row->akun_parent;
					$data[$i]["neraca_jenis_id"]=$row->akun_parent_id;
					$data[$i]["neraca_akun_kode"]=$row->akun_kode;
					$data[$i]["neraca_akun_nama"]=$row->akun_nama;
					$data[$i]["neraca_saldo"]=$saldo_akhir;
				}
				
				
				//bulan ini --> tidak dipakai
				$sql="SELECT A.akun_kode,sum(B.buku_debet) as debet,sum(B.buku_kredit) as kredit
						FROM	buku_besar B, akun A
						WHERE B.buku_akun=A.akun_id
						AND replace(A.akun_kode,'.','') like  '".str_replace(".","",$row->akun_kode)."%'
						AND date_format(buku_tanggal,'%Y-%m-%d')>=date_format('".$_SESSION["periode_awal"]."','%Y-%m-%d')
						AND date_format(buku_tanggal,'%Y-%m-%d')<=date_format('".$_SESSION["periode_akhir"]."','%Y-%m-%d')";

				if($buku_periode=="bulan"){
					$sql.="	AND date_format(buku_tanggal,'%Y-%m')='".$buku_tahun."-".$buku_bulan."'";
				}
				//$sql.="GROUP BY A.akun_kode";
				$sql.="	ORDER BY A.akun_kode ASC";

				$isi=$this->db->query($sql);
				if($isi->num_rows()){
					$rowisi=$isi->row();
					if($row->akun_saldo=='Debet')
						$data[$i]["neraca_saldo_periode"]=$saldo_akhir+($rowisi->debet-$rowisi->kredit);
					else
						$data[$i]["neraca_saldo_periode"]=$saldo_akhir+($rowisi->kredit-$rowisi->debet);
				}else{
					$data[$i]["neraca_saldo_periode"]=0;
				}
				$total_nilai+=$data[$i]["neraca_saldo"];
				$total_nilai_periode+=$data[$i]["neraca_saldo_periode"];
				$i++;
			}

			//LAPORAN LABA RUGI
			//2011-11-02, hendri: sementara ditutup dulu, karena belum tahu kegunaannya, sepertinya sudah terwakilkan oleh neraca_jenis3 = 3
			
			if($neraca_jenis==2) {
				$sql="SELECT	A.akun_id,A.akun_saldo,A.akun_kode,A.akun_jenis,A.akun_nama,A.akun_level,B.akun_id as akun_parent_id,
								B.akun_nama as akun_parent
						FROM 	akun A, akun B
						WHERE 	A.akun_level=2
								AND A.	akun_parent_kode=B.akun_kode
								AND A.akun_jenis='R/L'
								AND B.akun_level=1
						ORDER by A.akun_kode ASC";
	
				$master=$this->db->query($sql);
				$nbrows=$master->num_rows();
				
				//$this->firephp->log("sql=".$sql);
				
				$saldo=0;
				$saldo_akhir=0;
				$saldo_akhir_periode=0;
				$saldo_akun=0;
				$saldo_buku=0;
				
				//SALDO AWAL
				$sqlsaldo =    "SELECT
									A.akun_kode, sum(A.akun_debet) as debet, sum(A.akun_kredit) as kredit, A.akun_saldo
								FROM vu_akun A
								WHERE akun_jenis='R/L'
								GROUP BY A.akun_saldo";
				
				$rssaldo=$this->db->query($sqlsaldo);
				
				if($rssaldo->num_rows()){
					foreach($rssaldo->result() as $rs){
							if($rs->akun_saldo=='Debet'){
								$saldo_akhir-= ($rs->debet-$rs->kredit);
							}else{
								$saldo_akhir+= ($rs->kredit-$rs->debet);
							}
					}
				}
				
				$saldo_akhir_periode=$saldo_akhir;
				
				//print_r('Saldo Awal'); print_r($saldo_akhir_periode);
				
				$test="";
				
				foreach($master->result() as $row){
					//SALDO AWAL
/*					$saldo_akun=0;
					$sqlsaldo="SELECT 	A.akun_kode,sum(A.akun_debet) as debet,
										sum(A.akun_kredit) as kredit, 
										A.akun_saldo
								FROM	akun A
								WHERE   akun_jenis='R/L'
								AND 	replace(A.akun_kode,'.','') like  '".str_replace(".","",$row->akun_kode)."%' 
								GROUP BY A.akun_saldo";
		
					$rssaldo=$this->db->query($sqlsaldo);
					if($rssaldo->num_rows()){
						foreach($rssaldo->result() as $rs){
							if($rs->akun_saldo=='Debet'){
								$saldo_akun+= ($rs->debet-$rs->kredit);
							}else{
								$saldo_akun+= ($rs->kredit-$rs->debet);
							}
						}
					}
					
					//$this->firephp->log("saldo group : ".$row->akun_kode." => ".$saldo_akun);
					
					if($saldo_akun<>0){
						if($row->akun_saldo=='Debet'){
							$saldo_akhir=$saldo_akhir-$saldo_akun;
							$saldo_akhir_periode=$saldo_akhir_periode-$saldo_akun;
							$test.="-".$saldo_akun;
						}else{
							$saldo_akhir=$saldo_akhir+$saldo_akun;
							$saldo_akhir_periode=$saldo_akhir_periode+$saldo_akun;
							$test.="+".$saldo_akun;
						}
					}
*/					

					//saldo dari buku besar
					$sql="SELECT A.akun_kode,
							sum(B.buku_debet) as debet,sum(B.buku_kredit) as kredit, A.akun_saldo
							FROM buku_besar B, akun A
							WHERE B.buku_akun=A.akun_id
							AND date_format(buku_tanggal,'%Y-%m-%d')>=date_format('".$_SESSION["periode_awal"]."','%Y-%m-%d')
							AND date_format(buku_tanggal,'%Y-%m-%d')<=date_format('".$_SESSION["periode_akhir"]."','%Y-%m-%d')
							AND A.akun_jenis='R/L'
							AND replace(A.akun_kode,'.','') like  '".str_replace(".","",$row->akun_kode)."%' ";
							/*GROUP BY A.akun_kode, A.akun_saldo";*/
					
					if($buku_periode=="bulan"){
						$sql.="	AND date_format(B.buku_tanggal,'%Y-%m')<='".$buku_tahun."-".$buku_bulan."'";
					}elseif($buku_periode=="tanggal"){
							$sql.="	AND date_format(buku_tanggal,'%Y-%m-%d')<='".$buku_tglakhir."'";
					}		
								
					$rlisi=$this->db->query($sql);
					if($rlisi->num_rows()){
						foreach($rlisi->result() as $rowisi){
						
		/*					print_r($sql);
							print_r(', akun_kode: '); print_r($rowisi->akun_kode);
							print_r(', debet: '); print_r($rowisi->debet);
							print_r(', kredit: '); print_r($rowisi->kredit);					
		*/					
/*							if($rowisi->akun_saldo=='Debet'){
								$saldo_buku= ($rowisi->debet-$rowisi->kredit);
							}else{
								$saldo_buku= ($rowisi->kredit-$rowisi->debet);
							}
*/
							$saldo_buku= ($rowisi->kredit-$rowisi->debet);
							
						}
					}
					
					//print_r($rowisi->akun_saldo); print_r(' '); print_r($saldo_buku);
					
					//print_r('Saldo Akhir: '); print_r($saldo_akhir);
					
					$saldo_akhir = $saldo_akhir + $saldo_buku;

// tidak perlu, karena sudah dihitung di atas			
/*					if($saldo_buku<>0){
						if($row->akun_saldo=='Debet'){
							$saldo_akhir=$saldo_akhir-$saldo_buku;
							$test.="-".$saldo_akun;
						}else{
							$saldo_akhir=$saldo_akhir+$saldo_buku;
							$test.="+".$saldo_akun;
						}
					}
*/				
					//bulan ini
					$saldo=0;
					$sql="SELECT A.akun_kode,sum(B.buku_debet) as debet,sum(B.buku_kredit) as kredit, A.akun_saldo
							FROM	buku_besar B, akun A
							WHERE B.buku_akun=A.akun_id
							AND date_format(buku_tanggal,'%Y-%m-%d')>=date_format('".$_SESSION["periode_awal"]."','%Y-%m-%d')
							AND date_format(buku_tanggal,'%Y-%m-%d')<=date_format('".$_SESSION["periode_akhir"]."','%Y-%m-%d')
							AND replace(A.akun_kode,'.','') like  '".str_replace(".","",$row->akun_kode)."%' 
							AND A.akun_jenis='R/L'";
					if($buku_periode=="bulan"){
						$sql.="	AND date_format(B.buku_tanggal,'%Y-%m')='".$buku_tahun."-".$buku_bulan."'";
					}elseif($buku_periode=="tanggal"){
							$sql.="	AND date_format(buku_tanggal,'%Y-%m-%d')<='".$buku_tglakhir."'";
					}
		
					$sql.=" GROUP BY A.akun_kode, A.akun_saldo";
					
					if($rlisi->num_rows()){
						foreach($rlisi->result() as $rowisi){
/*							if($rowisi->akun_saldo=='Debet'){
								$saldo_buku= ($rowisi->debet-$rowisi->kredit);
							}else{
								$saldo_buku= ($rowisi->kredit-$rowisi->debet);
							}							
*/						
							$saldo_buku= ($rowisi->kredit-$rowisi->debet);
						}
					}
							
					$saldo_akhir_periode = $saldo_akhir_periode + $saldo_buku;
					
// tidak perlu, karena sudah dihitung di atas					
/*					if($saldo_buku<>0){
						if($row->akun_saldo=='Debet'){
							$saldo_akhir_periode=$saldo_akhir_periode-$saldo_buku;
							$test.="-".$saldo_akun;
						}else{
							$saldo_akhir_periode=$saldo_akhir_periode+$saldo_buku;
							$test.="+".$saldo_akun;
						}
					}
*/					
					
				}

				$data[$i]["neraca_akun"]=777;
				$data[$i]["neraca_jenis"]='RUGI/LABA BERSIH';
				$data[$i]["neraca_level"]=1;
				$data[$i]["neraca_jenis_id"]=777;
				$data[$i]["neraca_akun_kode"]="777.";
				$data[$i]["neraca_akun_nama"]="LABA/RUGI BERSIH";			
				$data[$i]["neraca_saldo"]=$saldo_akhir;
				$data[$i]["neraca_saldo_periode"]=$saldo_akhir_periode;
							
				//$this->firephp->log($test);
				
				$total_nilai+=$data[$i]["neraca_saldo"];
				$total_nilai_periode+=$data[$i]["neraca_saldo_periode"];
				$i++;	
				
			}
			
			
			$data[$i]["neraca_akun"]=9999;
			$data[$i]["neraca_jenis"]='TOTAL';
			$data[$i]["neraca_level"]=2;
			$data[$i]["neraca_jenis_id"]=9999;
			$data[$i]["neraca_akun_kode"]="999.";
			$data[$i]["neraca_akun_nama"]="TOTAL";			
			$data[$i]["neraca_saldo"]=$total_nilai;
			$data[$i]["neraca_saldo_periode"]=$total_nilai_periode;
			
			
			if($nbrows>0){
				$jsonresult = json_encode($data);
				return '({"total":"'.$nbrows.'","results":'.$jsonresult.'})';
			} else {
				return '({"total":"0", "results":""})';
			}
		}

		//function for print record
		function neraca_print($buku_periode, $buku_tglawal, $buku_tglakhir, $buku_bulan, 
								$buku_tahun, $buku_akun, $start,$end, $neraca_jenis){

			if($neraca_jenis=='Aktiva')
				$neraca_jenis=1;
			else 
				$neraca_jenis=2;
				
			//AKUN LEVEL 1
			$sql="SELECT A.akun_id,A.akun_saldo,A.akun_kode,A.akun_jenis,A.akun_nama,A.akun_level,B.akun_id as akun_parent_id, B.akun_nama as akun_parent
					FROM akun A, akun B
					WHERE A.akun_level=2
					AND A.akun_parent_kode=B.akun_kode
					AND A.akun_jenis='BS'
					AND B.akun_level=1
					AND A.akun_kode LIKE '".$neraca_jenis."%'
					ORDER by A.akun_kode ASC";

			$master=$this->db->query($sql);
			$nbrows=$master->num_rows();

			$saldo=0;
			$saldo_akhir=0;
			$i=0;
			$total_nilai_periode=0;
			$total_nilai=0;
			
			foreach($master->result() as $row){
			
				//s/d bulan ini
				$sql="SELECT A.akun_kode,A.akun_saldo,sum(B.buku_debet) as debet,sum(B.buku_kredit) as kredit
						FROM	buku_besar B, akun A
						WHERE B.buku_akun=A.akun_id
						AND replace(A.akun_kode,'.','') like  '".str_replace(".","",$row->akun_kode)."%'
						AND date_format(buku_tanggal,'%Y-%m-%d')>=date_format('".$_SESSION["periode_awal"]."','%Y-%m-%d')
						AND date_format(buku_tanggal,'%Y-%m-%d')<=date_format('".$_SESSION["periode_akhir"]."','%Y-%m-%d')";

				if($buku_periode=="bulan"){
					$sql.="	AND date_format(buku_tanggal,'%Y-%m')<='".$buku_tahun."-".$buku_bulan."'";
				}elseif($buku_periode=="tanggal"){
					$sql.="	AND date_format(buku_tanggal,'%Y-%m-%d')<='".$buku_tglakhir."'";
				}
				//$sql.="GROUP BY A.akun_kode";
				$sql.="	ORDER BY A.akun_kode ASC";
				//$this->firephp->log($sql);
				
				
				//GET SALDO BEFORE
				$data[$i]["neraca_saldo"]=0;

				$sqlsaldo="SELECT 	A.akun_kode,sum(A.akun_debet) as debet,sum(A.akun_kredit) as kredit, A.akun_saldo
							FROM	vu_akun A
							WHERE   replace(A.akun_kode,'.','') like  '".str_replace(".","",$row->akun_kode)."%'";
				
				
				$rssaldo=$this->db->query($sqlsaldo);
				if($rssaldo->num_rows()){
					$rowsaldo=$rssaldo->row();
					if($rowsaldo->akun_saldo=='Debet'){
						$saldo_akhir= ($rowsaldo->debet-$rowsaldo->kredit);
					}else{
						$saldo_akhir= ($rowsaldo->kredit-$rowsaldo->debet);
					}
				}
				//$this->firephp->log($sqlsaldo.' '.$saldo_akhir.'<br/>');
				//----->

				$isi=$this->db->query($sql);
				//$this->firephp->log($sql);
				
				if($isi->num_rows()){
					$rowisi=$isi->row();
					$data[$i]["neraca_akun"]=$row->akun_id;
					$data[$i]["neraca_level"]=$row->akun_level;
					$data[$i]["neraca_jenis"]=$row->akun_parent;
					$data[$i]["neraca_jenis_id"]=$row->akun_parent_id;
					$data[$i]["neraca_akun_kode"]=$row->akun_kode;
					$data[$i]["neraca_akun_nama"]=$row->akun_nama;

					if($row->akun_saldo=='Debet'){
						$data[$i]["neraca_saldo"]=$saldo_akhir+($rowisi->debet-$rowisi->kredit);
					}else{
						$data[$i]["neraca_saldo"]=$saldo_akhir+($rowisi->kredit-$rowisi->debet);
					}
				}else{
					$data[$i]["neraca_akun"]=$row->akun_id;
					$data[$i]["neraca_level"]=$row->akun_level;
					$data[$i]["neraca_jenis"]=$row->akun_parent;
					$data[$i]["neraca_jenis_id"]=$row->akun_parent_id;
					$data[$i]["neraca_akun_kode"]=$row->akun_kode;
					$data[$i]["neraca_akun_nama"]=$row->akun_nama;
					$data[$i]["neraca_saldo"]=$saldo_akhir;
				}
				
				
				//bulan ini
				$sql="SELECT A.akun_kode,A.akun_saldo,sum(B.buku_debet) as debet,sum(B.buku_kredit) as kredit
						FROM	buku_besar B, akun A
						WHERE B.buku_akun=A.akun_id
						AND replace(A.akun_kode,'.','') like  '".str_replace(".","",$row->akun_kode)."%'
						AND date_format(buku_tanggal,'%Y-%m-%d')>=date_format('".$_SESSION["periode_awal"]."','%Y-%m-%d')
						AND date_format(buku_tanggal,'%Y-%m-%d')<=date_format('".$_SESSION["periode_akhir"]."','%Y-%m-%d')";

				if($buku_periode=="bulan"){
					$sql.="	AND date_format(buku_tanggal,'%Y-%m')='".$buku_tahun."-".$buku_bulan."'";
				}
				//$sql.="GROUP BY A.akun_kode";
				$sql.="	ORDER BY A.akun_kode ASC";

				$isi=$this->db->query($sql);
				if($isi->num_rows()){
					$rowisi=$isi->row();
					if($row->akun_saldo=='Debet')
						$data[$i]["neraca_saldo_periode"]=$saldo_akhir+($rowisi->debet-$rowisi->kredit);
					else
						$data[$i]["neraca_saldo_periode"]=$saldo_akhir+($rowisi->kredit-$rowisi->debet);
				}else{
					$data[$i]["neraca_saldo_periode"]=0;
				}

				$i++;
			}

			//LAPORAN LABA RUGI
			
			if($neraca_jenis==2) {
				$sql="SELECT	A.akun_id,A.akun_saldo,A.akun_kode,A.akun_jenis,A.akun_nama,A.akun_level,B.akun_id as akun_parent_id,
								B.akun_nama as akun_parent
						FROM 	akun A, akun B
						WHERE 	A.akun_level=2
								AND A.	akun_parent_kode=B.akun_kode
								AND A.akun_jenis='R/L'
								AND B.akun_level=1
						ORDER by A.akun_kode ASC";
	
				$master=$this->db->query($sql);
				$nbrows=$master->num_rows();
				
				//$this->firephp->log("sql=".$sql);
				
				$saldo=0;
				$saldo_akhir=0;
				$saldo_akhir_periode=0;
				$saldo_akun=0;
				$saldo_buku=0;
				
				//SALDO AWAL
				/*$sqlsaldo="SELECT 	A.akun_kode,sum(A.akun_debet) as debet,
									sum(A.akun_kredit) as kredit, 
									A.akun_saldo
							FROM	akun A
							WHERE   akun_jenis='R/L'
							GROUP BY A.akun_saldo";
				
				$rssaldo=$this->db->query($sqlsaldo);
				if($rssaldo->num_rows()){
					foreach($rssaldo->result() as $rs){
							if($rs->akun_saldo=='Debet'){
								$saldo_akhir-= ($rs->debet-$rs->kredit);
							}else{
								$saldo_akhir+= ($rs->kredit-$rs->debet);
							}
					}
				}
				
				$saldo_akhir_periode=$saldo_akhir;
				
				$this->firephp->log($saldo_akhir);*/
				
				$test="";

				foreach($master->result() as $row){
					//SALDO AWAL
					$saldo_akun=0;
					$sqlsaldo="SELECT 	A.akun_kode,sum(A.akun_debet) as debet,
										sum(A.akun_kredit) as kredit, 
										A.akun_saldo
								FROM	vu_akun A
								WHERE   akun_jenis='R/L'
								AND 	replace(A.akun_kode,'.','') like  '".str_replace(".","",$row->akun_kode)."%' 
								GROUP BY A.akun_saldo";
		
					$rssaldo=$this->db->query($sqlsaldo);
					if($rssaldo->num_rows()){
						foreach($rssaldo->result() as $rs){
							if($rs->akun_saldo=='Debet'){
								$saldo_akun+= ($rs->debet-$rs->kredit);
							}else{
								$saldo_akun+= ($rs->kredit-$rs->debet);
							}
						}
					}
					
					//$this->firephp->log("saldo group : ".$row->akun_kode." => ".$saldo_akun);
					
					if($saldo_akun<>0){
						if($row->akun_saldo=='Debet'){
							$saldo_akhir=$saldo_akhir-$saldo_akun;
							$saldo_akhir_periode=$saldo_akhir_periode-$saldo_akun;
							$test.="-".$saldo_akun;
						}else{
							$saldo_akhir=$saldo_akhir+$saldo_akun;
							$saldo_akhir_periode=$saldo_akhir_periode+$saldo_akun;
							$test.="+".$saldo_akun;
						}
					}
					

					//saldo dari buku besar
					$sql="SELECT A.akun_kode, A.akun_saldo,sum(B.buku_debet) as debet,sum(B.buku_kredit) as kredit
							FROM	buku_besar B, akun A
							WHERE B.buku_akun=A.akun_id
							AND date_format(buku_tanggal,'%Y-%m-%d')>=date_format('".$_SESSION["periode_awal"]."','%Y-%m-%d')
							AND date_format(buku_tanggal,'%Y-%m-%d')<=date_format('".$_SESSION["periode_akhir"]."','%Y-%m-%d')
							AND A.akun_jenis='R/L'
							AND replace(A.akun_kode,'.','') like  '".str_replace(".","",$row->akun_kode)."%' 
							GROUP BY A.akun_kode";
					$rlisi=$this->db->query($sql);
					if($rlisi->num_rows()){
						foreach($rlisi->result() as $rowisi){
							if($rowisi->akun_saldo=='Debet'){
								$saldo_buku= ($rowisi->debet-$rowisi->kredit);
							}else{
								$saldo_buku= ($rowisi->kredit-$rowisi->debet);
							}
						}
					}
					
					
					if($saldo_buku<>0){
						if($row->akun_saldo=='Debet'){
							$saldo_akhir=$saldo_akhir-$saldo_buku;
							$test.="-".$saldo_akun;
						}else{
							$saldo_akhir=$saldo_akhir+$saldo_buku;
							$test.="+".$saldo_akun;
						}
					}
					
					//bulan ini
					$saldo=0;
					$sql="SELECT A.akun_kode,A.akun_saldo,sum(B.buku_debet) as debet,sum(B.buku_kredit) as kredit
							FROM	buku_besar B, akun A
							WHERE B.buku_akun=A.akun_id
							AND date_format(buku_tanggal,'%Y-%m-%d')>=date_format('".$_SESSION["periode_awal"]."','%Y-%m-%d')
							AND date_format(buku_tanggal,'%Y-%m-%d')<=date_format('".$_SESSION["periode_akhir"]."','%Y-%m-%d')
							AND replace(A.akun_kode,'.','') like  '".str_replace(".","",$row->akun_kode)."%' 
							AND A.akun_jenis='R/L'";
					if($buku_periode=="bulan"){
						$sql.="	AND date_format(B.buku_tanggal,'%Y-%m')='".$buku_tahun."-".$buku_bulan."'";
					}elseif($buku_periode=="tanggal"){
							$sql.="	AND date_format(buku_tanggal,'%Y-%m-%d')<='".$buku_tglakhir."'";
					}
		
					$sql.=" GROUP BY A.akun_kode";
					
					if($rlisi->num_rows()){
						foreach($rlisi->result() as $rowisi){
							if($row->akun_saldo=='Debet'){
								$saldo_buku= ($rowisi->debet-$rowisi->kredit);
							}else{
								$saldo_buku= ($rowisi->kredit-$rowisi->debet);
							}
						}
					}
					
					if($saldo_buku<>0){
						if($row->akun_saldo=='Debet'){
							$saldo_akhir_periode=$saldo_akhir_periode-$saldo_buku;
							$test.="-".$saldo_akun;
						}else{
							$saldo_akhir_periode=$saldo_akhir_periode+$saldo_buku;
							$test.="+".$saldo_akun;
						}
					}
					
					
				}
				
				$data[$i]["neraca_akun"]=777;
				$data[$i]["neraca_jenis"]='RUGI/LABA BERSIH';
				$data[$i]["neraca_level"]=2;
				$data[$i]["neraca_jenis_id"]=777;
				$data[$i]["neraca_akun_kode"]="777.";
				$data[$i]["neraca_akun_nama"]="LABA/RUGI BERSIH";			
				$data[$i]["neraca_saldo"]=$saldo_akhir;
				$data[$i]["neraca_saldo_periode"]=$saldo_akhir_periode;
			}

			if($master->num_rows()>0){
				return $data;
			}else{
				return 0;
			}
		}

}
?>