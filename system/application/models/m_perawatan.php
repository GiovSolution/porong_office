<? /* 	
	Miracle IT Team
*/

class M_perawatan extends Model{
		
		//constructor
		function M_perawatan() {
			parent::Model();
		}
		
		function get_satuan_detail_list($master_id){
			$sql="SELECT satuan_id,satuan_kode,satuan_nama FROM satuan";
			if($master_id<>""){
				$sql.=" WHERE satuan_id IN(SELECT dterima_satuan FROM detail_terima_beli WHERE dterima_master='".$master_id."')";
				$sql.=" OR satuan_id IN(SELECT dtbonus_satuan FROM detail_terima_bonus WHERE dtbonus_master='".$master_id."')";
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
		}
		
		function get_satuan_produk_list($selected_id){
			
			$sql="SELECT satuan_id,satuan_kode,satuan_nama FROM vu_satuan_konversi WHERE produk_aktif='Aktif'";
			
			if($selected_id!==""){
				$sql.=(eregi("WHERE",$sql)?" AND ":" WHERE ")." produk_id='".$selected_id."'";
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
		}
		
		function get_satuan_selected_list($selected_id){
			$sql="SELECT satuan_id,satuan_kode,satuan_nama FROM satuan";
			if($selected_id!=="")
			{
				$selected_id=substr($selected_id,0,strlen($selected_id)-1);
				$sql.=" WHERE satuan_id IN(".$selected_id.")";
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
		}
		
		function get_produk_list($query,$start,$end){
			$rs_rows=0;
			if(is_numeric($query)==true){
				$sql_dproduk="SELECT krawat_produk FROM perawatan_konsumsi WHERE krawat_master='$query'";
				$rs=$this->db->query($sql_dproduk);
				$rs_rows=$rs->num_rows();
			}

			$sql="select * from vu_produk_satuan_terkecil WHERE produk_aktif='Aktif'";
			if($query<>"" && is_numeric($query)==false){
				$sql.=eregi("WHERE",$sql)? " AND ":" WHERE ";
				$sql.=" (produk_kode like '%".$query."%' or 
						 produk_nama like '%".$query."%' or 
						 satuan_nama like '%".$query."%' or 
						 kategori_nama like '%".$query."%' or 
						 group_nama like '%".$query."%' or 
						 produk_kodelama like '%".$query."%') ";
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
		
		//function for detail
		//get record list
		function detail_perawatan_konsumsi_list($master_id,$query,$start,$end) {
			$query = "SELECT * FROM perawatan_konsumsi where krawat_master='".$master_id."'";
			$query.=" ORDER BY krawat_produk ASC";
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
/*			$limit = $query." LIMIT ".$start.",".$end;			
			$result = $this->db->query($limit);  */
			//$this->firephp->log($query);
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
		
		//get record list
		function detail_perawatan_alat_list($master_id,$query,$start,$end) {
			$query = "SELECT * FROM perawatan_alat where arawat_master='".$master_id."'";
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
			/*$limit = $query." LIMIT ".$start.",".$end;			
			$result = $this->db->query($limit);  */
			
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
		
		//get master id, note : not done yet
		function get_master_id() {
			$query = "SELECT max(rawat_id) as master_id from perawatan";
			$result = $this->db->query($query);
			if($result->num_rows()){
				$data=$result->row();
				$master_id=$data->master_id;
				return $master_id;
			}else{
				return '0';
			}
		}
		//eof
		
		//purge all detail from master
		function detail_perawatan_konsumsi_purge($master_id){
			$sql="DELETE from perawatan_konsumsi where krawat_master='".$master_id."'";
			$result=$this->db->query($sql);
			return '1';
		}
		//*eof
		
		//purge all detail from master
		function detail_perawatan_alat_purge($master_id){
			$sql="DELETE from perawatan_alat where arawat_master='".$master_id."'";
			$result=$this->db->query($sql);
			return '1';
		}
		//*eof
		
		//insert detail record
		function detail_perawatan_konsumsi_insert($array_krawat_id ,$krawat_master ,$array_krawat_produk ,$array_krawat_satuan ,
												  $array_krawat_jumlah ){
				
			$query="";
		   	for($i = 0; $i < sizeof($array_krawat_id); $i++){
			
			$sql_temp = "select konversi_satuan from satuan_konversi where konversi_produk = '".$array_krawat_produk[$i]."' and konversi_nilai = 1";
			$result_temp = $this->db->query($sql_temp);
			$data=$result_temp->row();
			$krawat_satuan=$data->konversi_satuan;
	
			

				$data = array(
					"krawat_master"=>$krawat_master, 
					"krawat_produk"=>$array_krawat_produk[$i], 
					"krawat_satuan"=>$krawat_satuan, 
					"krawat_jumlah"=>$array_krawat_jumlah[$i]
				);
				
								
				if($array_krawat_id[$i]==0){
					$this->db->insert('perawatan_konsumsi', $data); 
					
					$query = $query.$this->db->insert_id();
					if($i<sizeof($array_krawat_id)-1){
						$query = $query . ",";
					} 
					
				}else{
					$query = $query.$array_krawat_id[$i];
					if($i<sizeof($array_krawat_id)-1){
						$query = $query . ",";
					} 
					$this->db->where('krawat_id', $array_krawat_id[$i]);
					$this->db->update('perawatan_konsumsi', $data);
				}
			}
			
			if($query<>""){
				$sql="DELETE FROM perawatan_konsumsi WHERE  krawat_master='".$krawat_master."' AND
						krawat_id NOT IN (".$query.")";
				$this->db->query($sql);
			}
			
			return '1';


		}
		//end of function
		
		//insert detail record
		function detail_perawatan_alat_insert($array_arawat_id ,$arawat_master ,$array_arawat_alat ,$array_arawat_jumlah ){
			
			$query="";
		   	for($i = 0; $i < sizeof($array_arawat_id); $i++){

				$data = array(
					"arawat_master"=>$arawat_master, 
					"arawat_alat"=>$array_arawat_alat[$i], 
					"arawat_jumlah"=>$array_arawat_jumlah[$i]
				);
				
								
				if($array_arawat_id[$i]==0){
					$this->db->insert('perawatan_alat', $data); 
					
					$query = $query.$this->db->insert_id();
					if($i<sizeof($array_arawat_id)-1){
						$query = $query . ",";
					} 
					
				}else{
					$query = $query.$array_arawat_id[$i];
					if($i<sizeof($array_arawat_id)-1){
						$query = $query . ",";
					} 
					$this->db->where('arawat_id', $array_arawat_id[$i]);
					$this->db->update('perawatan_alat', $data);
				}
			}
			
			if($query<>""){
				$sql="DELETE FROM perawatan_alat WHERE  arawat_master='".$arawat_master."' AND
						arawat_id NOT IN (".$query.")";
				$this->db->query($sql);
			}

		}
		//end of function
		
		/*function get_kode($pattern_g,$pattern_j){
			$result=$this->m_public_function->get_kode_2("perawatan","rawat_kode",$pattern_g,$pattern_j,6);
			return $result;
		}
		*/
		
		function get_kontribusi_rawat_list(){
			$sql="SELECT kategori2_id,kategori2_nama 
					FROM kategori2 
					LEFT JOIN kategori ON(kategori2.kategori2_jenis=kategori.kategori_id) 
					WHERE kategori_jenis='perawatan' and kategori2_aktif='Aktif'";
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
		
		
		function get_kode($pattern){
			$result=$this->m_public_function->get_kode_1("perawatan","rawat_kode",$pattern,6);
			return $result;
		}
		
		//function for get list record
		function perawatan_list($filter,$start,$end){
			$query = "SELECT * from vu_perawatan where rawat_aktif = 'Aktif'";
			
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (rawat_kode LIKE '%".addslashes($filter)."%' OR 
							 rawat_kodelama LIKE '%".addslashes($filter)."%' OR 
							 rawat_nama LIKE '%".addslashes($filter)."%' OR 
							 group_nama LIKE '%".addslashes($filter)."%' OR 
							 jenis_nama LIKE '%".addslashes($filter)."%' OR 
							 kategori_nama LIKE '%".addslashes($filter)."%')";
				$query .= " AND rawat_aktif = 'Aktif'"; // by hendri, simple search khusus aktif only
			}
			
			//$this->firephp->log($query);
			$query.=" ORDER BY rawat_id DESC";
			
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
		function perawatan_update($rawat_id ,$rawat_kode ,$rawat_kodelama ,$rawat_nama, $rawat_highmargin, $rawat_edit_harga, $rawat_group ,$rawat_kategori,$rawat_kontribusi ,$rawat_jenis ,$rawat_keterangan,
									$rawat_du ,$rawat_dm ,$rawat_dultah, $rawat_dcard, $rawat_dkolega, $rawat_dkeluarga, $rawat_downer, $rawat_dgrooming, $rawat_dwartawan, $rawat_dstaffdokter, $rawat_dstaffnondokter,$rawat_dpromo,
									$rawat_point , $rawat_durasi, $rawat_kredit, $rawat_kreditrp, $rawat_jumlah_tindakan, $rawat_harga ,$rawat_gudang ,$rawat_aktif, $rawat_aktif_th ,$rawat_aktif_ki ,$rawat_aktif_hr ,$rawat_aktif_tp ,$rawat_aktif_dps ,$rawat_aktif_jkt,$rawat_aktif_mta ,$rawat_aktif_blpn ,$rawat_aktif_kuta ,$rawat_aktif_btm ,$rawat_aktif_mks ,$rawat_aktif_mdn ,$rawat_aktif_lbk ,$rawat_aktif_mnd ,$rawat_aktif_ygk,$rawat_aktif_mlg, $rawat_aktif_smg,$rawat_harga_ki,$rawat_harga_mdn,$rawat_harga_mnd,$rawat_harga_ygk,$rawat_harga_mta, $rawat_harga_lbk, $rawat_harga_hr, $rawat_harga_tp, $rawat_harga_dps, $rawat_harga_blpn, $rawat_harga_kuta,$rawat_harga_btm, $rawat_harga_jkt,$rawat_harga_smg, $rawat_harga_mks, $rawat_harga_mlg){
			if ($rawat_aktif=="")
				$rawat_aktif = "Aktif";
			if ($rawat_point=="")
				$rawat_point = 1;
				
			if($rawat_aktif_th=='true')
				$th="1";
			else if($rawat_aktif_th=='false')
				$th="0";	
				
			if($rawat_aktif_ki=='true')
				$ki="1";
			else if($rawat_aktif_ki=='false')
				$ki="0";			

			if($rawat_aktif_hr=='true')
				$hr="1";
			else if($rawat_aktif_hr=='false')
				$hr="0";	
				
			if($rawat_aktif_tp=='true')
				$tp="1";
			else if($rawat_aktif_tp=='false')
				$tp="0";	
				
			if($rawat_aktif_dps=='true')
				$dps="1";
			else if($rawat_aktif_dps=='false')
				$dps="0";	
				
			if($rawat_aktif_jkt=='true')
				$jkt="1";
			else if($rawat_aktif_jkt=='false')
				$jkt="0";	
				
			if($rawat_aktif_mta=='true')
				$mta="1";
			else if($rawat_aktif_mta=='false')
				$mta="0";	
				
			if($rawat_aktif_blpn=='true')
				$blpn="1";
			else if($rawat_aktif_blpn=='false')
				$blpn="0";	
				
			if($rawat_aktif_kuta=='true')
				$kuta="1";
			else if($rawat_aktif_kuta=='false')
				$kuta="0";	
				
			if($rawat_aktif_btm=='true')
				$btm="1";
			else if($rawat_aktif_btm=='false')
				$btm="0";	
				
			if($rawat_aktif_mks=='true')
				$mks="1";
			else if($rawat_aktif_mks=='false')
				$mks="0";	
				
			if($rawat_aktif_mdn=='true')
				$mdn="1";
			else if($rawat_aktif_mdn=='false')
				$mdn="0";	
				
			if($rawat_aktif_lbk=='true')
				$lbk="1";
			else if($rawat_aktif_lbk=='false')
				$lbk="0";	
				
			if($rawat_aktif_mnd=='true')
				$mnd="1";
			else if($rawat_aktif_mnd=='false')
				$mnd="0";	
				
			if($rawat_aktif_ygk=='true')
				$ygk="1";
			else if($rawat_aktif_ygk=='false')
				$ygk="0";	
				
			if($rawat_aktif_mlg=='true')
				$mlg="1";
			else if($rawat_aktif_mlg=='false')
				$mlg="0";	
				
			if($rawat_aktif_smg=='true')
				$smg="1";
			else if($rawat_aktif_smg=='false')
				$smg="0";	
				
			$temp_aktif=$th.$ki.$hr.$tp.$dps.$jkt.$mta.$blpn.$kuta.'0'.$mks.$mdn.$lbk.$mnd.$ygk.$mlg.$btm.'000'.$smg;
			
			$data = array(
				"rawat_id"=>$rawat_id, 
//				"rawat_kode"=>$rawat_kode, 
				"rawat_kodelama"=>$rawat_kodelama, 
				"rawat_nama"=>$rawat_nama, 
//				"rawat_group"=>$rawat_group, 
//				"rawat_kategori"=>$rawat_kategori, 
				"rawat_keterangan"=>$rawat_keterangan, 
//				"rawat_du"=>$rawat_du, 
//				"rawat_dm"=>$rawat_dm, 
				"rawat_point"=>$rawat_point,
				"rawat_durasi"=>$rawat_durasi,
				"rawat_kredit"=>$rawat_kredit,
				"rawat_kreditrp"=>$rawat_kreditrp,
				"rawat_jumlah_tindakan"=>$rawat_jumlah_tindakan,
				"rawat_harga"=>$rawat_harga, 
				"rawat_harga_ki"=>$rawat_harga_ki,
				"rawat_harga_mdn"=>$rawat_harga_mdn,
				"rawat_harga_mnd"=>$rawat_harga_mnd,
				"rawat_harga_ygk"=>$rawat_harga_ygk,
				"rawat_harga_mta"=>$rawat_harga_mta,
				"rawat_harga_lbk"=>$rawat_harga_lbk,
				"rawat_harga_hr"=>$rawat_harga_hr,
				"rawat_harga_tp"=>$rawat_harga_tp,
				"rawat_harga_dps"=>$rawat_harga_dps,
				"rawat_harga_jkt"=>$rawat_harga_jkt,
				"rawat_harga_blpn"=>$rawat_harga_blpn,
				"rawat_harga_kuta"=>$rawat_harga_kuta,
				"rawat_harga_btm"=>$rawat_harga_btm,
				"rawat_harga_smg"=>$rawat_harga_smg,
				"rawat_harga_mks"=>$rawat_harga_mks,
				"rawat_harga_mlg"=>$rawat_harga_mlg,
//				"rawat_gudang"=>$rawat_gudang, 
				"rawat_aktif"=>$rawat_aktif, 
				"rawat_aktif_cabang"=>$temp_aktif,
				"rawat_update"=>$_SESSION[SESSION_USERID],			
				"rawat_date_update"=>date('Y-m-d H:i:s')			
			);
			if($rawat_highmargin=='true')
				$data["rawat_highmargin"]=1;
			if($rawat_highmargin=='false')
				$data["rawat_highmargin"]=0;
				
			if($rawat_edit_harga=='true')
				$data["rawat_edit_harga"]=1;
			if($rawat_edit_harga=='false')
				$data["rawat_edit_harga"]=0;	
			
			$sql="SELECT group_id,group_durawat,group_dmrawat,group_dultah, group_dcard, group_dkolega, group_dkeluarga, group_downer, group_dgrooming, group_dwartawan, group_dstaffdokter, group_dstaffnondokter, group_kelompok FROM produk_group WHERE group_id='".$rawat_group."'";
			$rs=$this->db->query($sql);
			if($rs->num_rows()){
				$data["rawat_group"]=$rawat_group;
				$rs_sql=$rs->row();
				$data["rawat_du"]=$rs_sql->group_durawat;
				$data["rawat_dm"]=$rs_sql->group_dmrawat;
				$data["rawat_dultah"]=$rs_sql->group_dultah;
				$data["rawat_dcard"]=$rs_sql->group_dcard;
				$data["rawat_dkolega"]=$rs_sql->group_dkolega;
				$data["rawat_dkeluarga"]=$rs_sql->group_dkeluarga;
				$data["rawat_downer"]=$rs_sql->group_downer;
				$data["rawat_dgrooming"]=$rs_sql->group_dgrooming;
				$data["rawat_dwartawan"]=$rs_sql->group_dwartawan;
				$data["rawat_dstaffdokter"]=$rs_sql->group_dstaffdokter;
				$data["rawat_dstaffnondokter"]=$rs_sql->group_dstaffnondokter;
				$data["rawat_dpromo"]=$rs_sql->group_dpromo;
				$data["rawat_kategori"]=$rs_sql->group_kelompok;
			}
			
			$sql="SELECT kategori_id FROM kategori WHERE kategori_id='".$rawat_kategori."'";
			$rs=$this->db->query($sql);
			if($rs->num_rows())
				$data["rawat_kategori"]=$rawat_kategori;
				
			$sql="SELECT kategori2_id FROM kategori2 WHERE kategori2_id='".$rawat_kontribusi."'";
			$rs=$this->db->query($sql);
			if($rs->num_rows())
				$data["rawat_kontribusi"]=$rawat_kontribusi;
			
			$sql="SELECT jenis_id FROM jenis WHERE jenis_id='".$rawat_jenis."'";
			$rs=$this->db->query($sql);
			if($rs->num_rows())
				$data["rawat_jenis"]=$rawat_jenis;
				
			$sql="SELECT gudang_id FROM gudang WHERE gudang_id='".$rawat_gudang."'";
			$rs=$this->db->query($sql);
			if($rs->num_rows())
				$data["rawat_gudang"]=$rawat_gudang;
			
			//generate rawat kode
			//get group kode
			//$group_kode="";
			//$jenis_kode="";
			
			$sql_g="SELECT group_id,group_kode FROM produk_group WHERE group_id='".$rawat_group."'";
			$rs_g=$this->db->query($sql_g);
			if($rs_g->num_rows()){
				$rs_sql_g=$rs_g->row();
				$group_kode=$rs_sql_g->group_kode;
				$data["rawat_group"]=$rawat_group;
			}else{
				$sql_q="select SUBSTRING(rawat_kode,1,2) as group_kode from perawatan where rawat_id='".$rawat_id."'";
				$rs_g=$this->db->query($sql_g);
				if($rs_g->num_rows()){
					$rs_sql_g=$rs_g->row();
					$group_kode=$rs_sql_g->group_kode;
				}
			}
			//get jenis kode
			$sql_j="SELECT jenis_id,jenis_kode FROM jenis WHERE jenis_id='".$rawat_jenis."'";
			$rs_j=$this->db->query($sql_j);
			if($rs_j->num_rows()){
				$rs_sql_j=$rs_j->row();
				$jenis_kode=$rs_sql_j->jenis_kode;
				$data["rawat_jenis"]=$rawat_jenis;
			}else{
				$sql_j="select SUBSTRING(rawat_kode,3,2) as jenis_kode from perawatan where rawat_id='".$rawat_id."'";
				$rs_j=$this->db->query($sql_j);
				if($rs_j->num_rows()){
					$rs_sql_j=$rs_j->row();
					$jenis_kode=$rs_sql_j->jenis_kode;
				}
			}
			
			if(is_numeric($rawat_group) || is_numeric($rawat_jenis)){
				$pattern=$group_kode.$jenis_kode;
				$rawat_kode=$this->get_kode($pattern);
				if($rawat_kode!=="" && strlen($rawat_kode)==6){
					$data["rawat_kode"]=$rawat_kode;
				}
			}
				
			$sql="SELECT rawat_du FROM perawatan WHERE rawat_du!='".$rawat_du."' AND rawat_id='".$rawat_id."'";
			$rs=$this->db->query($sql);
			if($rs->num_rows())
				$data["rawat_du"]=$rawat_du;
			
			$sql="SELECT rawat_dm FROM perawatan WHERE rawat_dm!='".$rawat_dm."' AND rawat_id='".$rawat_id."'";
			$rs=$this->db->query($sql);
			if($rs->num_rows())
				$data["rawat_dm"]=$rawat_dm;
			
			$sql="SELECT rawat_dultah FROM perawatan WHERE rawat_dultah!='".$rawat_dultah."' AND rawat_id='".$rawat_id."'";
			$rs=$this->db->query($sql);
			if($rs->num_rows())
				$data["rawat_dultah"]=$rawat_dultah;
				
			$sql="SELECT rawat_dcard FROM perawatan WHERE rawat_dcard!='".$rawat_dcard."' AND rawat_id='".$rawat_id."'";
			$rs=$this->db->query($sql);
			if($rs->num_rows())
				$data["rawat_dcard"]=$rawat_dcard;
				
			$sql="SELECT rawat_dkolega FROM perawatan WHERE rawat_dkolega!='".$rawat_dkolega."' AND rawat_id='".$rawat_id."'";
			$rs=$this->db->query($sql);
			if($rs->num_rows())
				$data["rawat_dkolega"]=$rawat_dkolega;	
			
			$sql="SELECT rawat_dkeluarga FROM perawatan WHERE rawat_dkeluarga!='".$rawat_dkeluarga."' AND rawat_id='".$rawat_id."'";
			$rs=$this->db->query($sql);
			if($rs->num_rows())
				$data["rawat_dkeluarga"]=$rawat_dkeluarga;
			
			$sql="SELECT rawat_downer FROM perawatan WHERE rawat_downer!='".$rawat_downer."' AND rawat_id='".$rawat_id."'";
			$rs=$this->db->query($sql);
			if($rs->num_rows())
				$data["rawat_downer"]=$rawat_downer;
			
			$sql="SELECT rawat_dgrooming FROM perawatan WHERE rawat_dgrooming!='".$rawat_dgrooming."' AND rawat_id='".$rawat_id."'";
			$rs=$this->db->query($sql);
			if($rs->num_rows())
				$data["rawat_dgrooming"]=$rawat_dgrooming;
						
			$sql="SELECT rawat_dwartawan FROM perawatan WHERE rawat_dwartawan!='".$rawat_dwartawan."' AND rawat_id='".$rawat_id."'";
			$rs=$this->db->query($sql);
			if($rs->num_rows())
				$data["rawat_dwartawan"]=$rawat_dwartawan;
				
			$sql="SELECT rawat_dstaffdokter FROM perawatan WHERE rawat_dstaffdokter!='".$rawat_dstaffdokter."' AND rawat_id='".$rawat_id."'";
			$rs=$this->db->query($sql);
			if($rs->num_rows())
				$data["rawat_dstaffdokter"]=$rawat_dstaffdokter;
				
			$sql="SELECT rawat_dstaffnondokter FROM perawatan WHERE rawat_dstaffnondokter!='".$rawat_dstaffnondokter."' AND rawat_id='".$rawat_id."'";
			$rs=$this->db->query($sql);
			if($rs->num_rows())
				$data["rawat_dstaffnondokter"]=$rawat_dstaffnondokter;
				
			$sql="SELECT rawat_dpromo FROM perawatan WHERE rawat_dpromo!='".$rawat_dpromo."' AND rawat_id='".$rawat_id."'";
			$rs=$this->db->query($sql);
			if($rs->num_rows())
				$data["rawat_dpromo"]=$rawat_dpromo;

			$this->db->where('rawat_id', $rawat_id);
			$this->db->update('perawatan', $data);
			
			if($this->db->affected_rows()){
				$sql="UPDATE perawatan set rawat_revised=(rawat_revised+1) WHERE rawat_id='".$rawat_id."'";
				$this->db->query($sql);
			}
			return $rawat_id;
		}
		
		//function for create new record
		function perawatan_create($rawat_kode ,$rawat_kodelama ,$rawat_nama, $rawat_highmargin, $rawat_edit_harga, $rawat_group ,$rawat_kategori, $rawat_kontribusi ,$rawat_jenis ,$rawat_keterangan ,
									$rawat_du ,$rawat_dm, $rawat_dultah, $rawat_dcard, $rawat_dkolega, $rawat_dkeluarga, $rawat_downer, $rawat_dgrooming, $rawat_dwartawan, $rawat_dstaffdokter, $rawat_dstaffnondokter, $rawat_dpromo,
									$rawat_point , $rawat_durasi, $rawat_kredit, $rawat_kreditrp, $rawat_jumlah_tindakan, $rawat_harga ,$rawat_gudang ,$rawat_aktif ,$rawat_aktif_th ,$rawat_aktif_ki ,$rawat_aktif_hr ,$rawat_aktif_tp ,$rawat_aktif_dps ,$rawat_aktif_jkt ,$rawat_aktif_mta ,$rawat_aktif_blpn ,$rawat_aktif_kuta ,$rawat_aktif_btm ,$rawat_aktif_mks ,$rawat_aktif_mdn ,$rawat_aktif_lbk ,$rawat_aktif_mnd ,$rawat_aktif_ygk,$rawat_aktif_mlg, $rawat_aktif_smg,$rawat_harga_ki,$rawat_harga_mdn,$rawat_harga_mnd,$rawat_harga_ygk,$rawat_harga_mta, $rawat_harga_lbk, $rawat_harga_hr, $rawat_harga_tp, $rawat_harga_dps, $rawat_harga_blpn, $rawat_harga_kuta,$rawat_harga_btm, $rawat_harga_jkt, $rawat_harga_smg, $rawat_harga_mks, $rawat_harga_mlg){
		if ($rawat_aktif=="")
			
		if ($rawat_point=="")
			$rawat_point = 1;

		if($rawat_aktif_th=='true')
		{
			$th="1";
			$rawat_aktif = "Aktif";
		}
		else if($rawat_aktif_th=='false')
		{
			$th="0";	
			$rawat_aktif = "Tidak Aktif";
		}
			
		if($rawat_aktif_ki=='true')
			$ki="1";
		else if($rawat_aktif_ki=='false')
			$ki="0";			

		if($rawat_aktif_hr=='true')
			$hr="1";
		else if($rawat_aktif_hr=='false')
			$hr="0";	
			
		if($rawat_aktif_tp=='true')
			$tp="1";
		else if($rawat_aktif_tp=='false')
			$tp="0";	
			
		if($rawat_aktif_dps=='true')
			$dps="1";
		else if($rawat_aktif_dps=='false')
			$dps="0";	
			
		if($rawat_aktif_jkt=='true')
			$jkt="1";
		else if($rawat_aktif_jkt=='false')
			$jkt="0";	
			
		if($rawat_aktif_mta=='true')
			$mta="1";
		else if($rawat_aktif_mta=='false')
			$mta="0";	
			
		if($rawat_aktif_blpn=='true')
			$blpn="1";
		else if($rawat_aktif_blpn=='false')
			$blpn="0";	
			
		if($rawat_aktif_kuta=='true')
			$kuta="1";
		else if($rawat_aktif_kuta=='false')
			$kuta="0";	
			
		if($rawat_aktif_btm=='true')
			$btm="1";
		else if($rawat_aktif_btm=='false')
			$btm="0";	
			
		if($rawat_aktif_mks=='true')
			$mks="1";
		else if($rawat_aktif_mks=='false')
			$mks="0";	
			
		if($rawat_aktif_mdn=='true')
			$mdn="1";
		else if($rawat_aktif_mdn=='false')
			$mdn="0";	
			
		if($rawat_aktif_lbk=='true')
			$lbk="1";
		else if($rawat_aktif_lbk=='false')
			$lbk="0";	
			
		if($rawat_aktif_mnd=='true')
			$mnd="1";
		else if($rawat_aktif_mnd=='false')
			$mnd="0";	
			
		if($rawat_aktif_ygk=='true')
			$ygk="1";
		else if($rawat_aktif_ygk=='false')
			$ygk="0";	
			
		if($rawat_aktif_mlg=='true')
			$mlg="1";
		else if($rawat_aktif_mlg=='false')
			$mlg="0";	
			
		if($rawat_aktif_smg=='true')
			$smg="1";
		else if($rawat_aktif_smg=='false')
			$smg="0";	
			
		//$temp_aktif=$th.$ki.$hr.$tp.$dps.$jkt.$mta.$blpn.$kuta.$btm.$mks.$mdn.$lbk.$mnd.$ygk.$mlg.'000';
		$temp_aktif=$th.$ki.$hr.$tp.$dps.$jkt.$mta.$blpn.$kuta.'0'.$mks.$mdn.$lbk.$mnd.$ygk.$mlg.$btm.'000'.$smg;

			$data = array(
				"rawat_kode"=>$rawat_kode,
				"rawat_nama"=>$rawat_nama, 
				"rawat_group"=>$rawat_group, 
				"rawat_kategori"=>$rawat_kategori, 
				"rawat_jenis"=>$rawat_jenis, 
				"rawat_keterangan"=>$rawat_keterangan, 
				"rawat_du"=>$rawat_du, 
				"rawat_dm"=>$rawat_dm,
				"rawat_dultah"=>$rawat_dultah,
				"rawat_dcard"=>$rawat_dcard,
				"rawat_dkolega"=>$rawat_dkolega,
				"rawat_dkeluarga"=>$rawat_dkeluarga,
				"rawat_downer"=>$rawat_downer,
				"rawat_dgrooming"=>$rawat_dgrooming,
				"rawat_dwartawan"=>$rawat_dwartawan,
				"rawat_dstaffdokter"=>$rawat_dstaffdokter,
				"rawat_dstaffnondokter"=>$rawat_dstaffnondokter,
				"rawat_dpromo"=>$rawat_dpromo,
				"rawat_point"=>$rawat_point,
				"rawat_durasi"=>$rawat_durasi,
				"rawat_kredit"=>$rawat_kredit,
				"rawat_kreditrp"=>$rawat_kreditrp,
				"rawat_jumlah_tindakan"=>$rawat_jumlah_tindakan,
				"rawat_harga"=>$rawat_harga,
				"rawat_harga_ki"=>$rawat_harga_ki,
				"rawat_harga_mdn"=>$rawat_harga_mdn,
				"rawat_harga_mnd"=>$rawat_harga_mnd,
				"rawat_harga_ygk"=>$rawat_harga_ygk,
				"rawat_harga_mta"=>$rawat_harga_mta,
				"rawat_harga_lbk"=>$rawat_harga_lbk,
				"rawat_harga_hr"=>$rawat_harga_hr,
				"rawat_harga_tp"=>$rawat_harga_tp,
				"rawat_harga_dps"=>$rawat_harga_dps,
				"rawat_harga_jkt"=>$rawat_harga_jkt,
				"rawat_harga_blpn"=>$rawat_harga_blpn,
				"rawat_harga_kuta"=>$rawat_harga_kuta,
				"rawat_harga_btm"=>$rawat_harga_btm,
				"rawat_harga_smg"=>$rawat_harga_smg,
				"rawat_harga_mks"=>$rawat_harga_mks,
				"rawat_harga_mlg"=>$rawat_harga_mlg,
				"rawat_gudang"=>$rawat_gudang,
				"rawat_kontribusi"=>$rawat_kontribusi,
				"rawat_aktif"=>$rawat_aktif,
				"rawat_creator"=>$_SESSION[SESSION_USERID],	
				"rawat_date_create"=>date('Y-m-d H:i:s'),	
				"rawat_aktif_cabang"=>$temp_aktif,
				"rawat_revised"=>'0'	
			);
			
			if($rawat_highmargin=='true')
				$data["rawat_highmargin"]=1;
			if($rawat_highmargin=='false')
				$data["rawat_highmargin"]=0;
				
			if($rawat_edit_harga=='true')
				$data["rawat_edit_harga"]=1;
			if($rawat_edit_harga=='false')
				$data["rawat_edit_harga"]=0;
			
			/*$sql="SELECT group_id,group_kode FROM produk_group WHERE group_id='".$rawat_group."' ";
			$rs=$this->db->query($sql);
			if($rs->num_rows()){
				$row=$rs->row();	
				$sql_2="SELECT jenis_id,jenis_kode FROM jenis WHERE jenis_id='".$rawat_jenis."' ";
				$rs_2=$this->db->query($sql_2);
				if($rs_2->num_rows()){
					$row_2=$rs_2->row();
					$data["rawat_kode"]=$this->get_kode($row->group_kode,$row_2->jenis_kode);
				}
			}*/
			
			//generate rawat kode
			//get group kode
			$group_kode="";
			$jenis_kode="";
			
			$sql_g="SELECT group_id,group_kode FROM produk_group WHERE group_id='".$rawat_group."'";
			$rs_g=$this->db->query($sql_g);
			if($rs_g->num_rows()){
				$rs_sql_g=$rs_g->row();
				$group_kode=$rs_sql_g->group_kode;
				$data["rawat_group"]=$rawat_group;
			}
			//get jenis kode
			$sql_j="SELECT jenis_id,jenis_kode FROM jenis WHERE jenis_id='".$rawat_jenis."'";
			$rs_j=$this->db->query($sql_j);
			if($rs_j->num_rows()){
				$rs_sql_j=$rs_j->row();
				$jenis_kode=$rs_sql_j->jenis_kode;
				$data["rawat_jenis"]=$rawat_jenis;
			}
			
			$pattern=$group_kode.$jenis_kode;
			$rawat_kode=$this->get_kode($pattern);
			if($rawat_kode!=="" && strlen($rawat_kode)==6)
				$data["rawat_kode"]=$rawat_kode;
				
			$this->db->insert('perawatan', $data); 
			if($this->db->affected_rows())
				return $this->db->insert_id();
			else
				return '0';
		}
		
		//fcuntion for delete record
		function perawatan_delete($pkid){
			// You could do some checkups here and return '0' or other error consts.
			// Make a single query to delete all of the perawatans at the same time :
			if(sizeof($pkid)<1){
				return '0';
			} else if (sizeof($pkid) == 1){
				$query = "DELETE FROM perawatan WHERE rawat_id = ".$pkid[0];
				$this->db->query($query);
			} else {
				$query = "DELETE FROM perawatan WHERE ";
				for($i = 0; $i < sizeof($pkid); $i++){
					$query = $query . "rawat_id= ".$pkid[$i];
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
		function perawatan_search($rawat_id ,$rawat_kode ,$rawat_kodelama ,$rawat_nama ,$rawat_group ,$rawat_kategori ,$rawat_jenis ,$rawat_keterangan ,
									$rawat_du ,$rawat_dm , $rawat_dultah, $rawat_dcard, $rawat_dkolega, $rawat_dkeluarga, $rawat_downer, $rawat_dgrooming,
									$rawat_point , $rawat_durasi, $rawat_kredit, $rawat_jumlah_tindakan, $rawat_harga ,$rawat_gudang ,$rawat_aktif ,$start,$end, $kategori2_nama){
			//full query
			/*if($rawat_aktif==""){
				$rawat_aktif="Aktif";
			}*/
			$query="SELECT * FROM vu_perawatan";
			
			if($rawat_id!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " rawat_id = '".$rawat_id."'";
			};
			if($rawat_kode!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " rawat_kode LIKE '%".$rawat_kode."%'";
			};
			if($rawat_kodelama!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " rawat_kodelama LIKE '%".$rawat_kodelama."%'";
			};
			if($rawat_nama!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " rawat_nama LIKE '%".$rawat_nama."%'";
			};
			if($rawat_group!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " rawat_group LIKE '%".$rawat_group."%'";
			};
			if($rawat_kategori!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " rawat_kategori = '".$rawat_kategori."'";
			};
			if($kategori2_nama!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " kategori2_nama = '".$kategori2_nama."'";
			};
			if($rawat_jenis!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " rawat_jenis = '".$rawat_jenis."'";
			};
			if($rawat_keterangan!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " rawat_keterangan LIKE '%".$rawat_keterangan."%'";
			};
			if($rawat_du!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " rawat_du = '".$rawat_du."'";
			};
			if($rawat_dm!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " rawat_dm = '".$rawat_dm."'";
			};
			if($rawat_dultah!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " rawat_dultah = '".$rawat_dultah."'";
			};
			if($rawat_dcard!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " rawat_dcard = '".$rawat_dcard."'";
			};
			if($rawat_dkolega!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " rawat_dkolega = '".$rawat_dkolega."'";
			};
			if($rawat_dkeluarga!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " rawat_dkeluarga = '".$rawat_dkeluarga."'";
			};
			if($rawat_downer!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " rawat_downer = '".$rawat_downer."'";
			};
			if($rawat_dgrooming!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " rawat_dgrooming = '".$rawat_dgrooming."'";
			};
			if($rawat_point!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " rawat_point LIKE '%".$rawat_point."%'";
			};
			if($rawat_durasi!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " rawat_durasi LIKE '%".$rawat_durasi."%'";
			};
			if($rawat_harga!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " rawat_harga = '".$rawat_harga."'";
			};
			if($rawat_gudang!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " rawat_gudang = '".$rawat_gudang."'";
			};
			if($rawat_aktif!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " rawat_aktif = '".$rawat_aktif."'";
			};
			//echo $query;
			$query.=" ORDER BY rawat_id DESC";
			
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
		function perawatan_print($rawat_id 
								,$rawat_kode 
								,$rawat_kodelama 
								,$rawat_nama 
								,$rawat_group 
								,$rawat_kategori 
								,$rawat_jenis 
								,$rawat_keterangan 
								,$rawat_du 
								,$rawat_dm 
								,$rawat_dultah
								,$rawat_dcard
								,$rawat_dkolega
								,$rawat_dkeluarga
								,$rawat_downer
								,$rawat_dgrooming
								,$rawat_point 
								,$rawat_durasi
								,$rawat_kredit
								,$rawat_jumlah_tindakan
								,$rawat_harga 
								,$rawat_gudang 
								,$rawat_aktif 
								,$option
								,$filter){
			//full query
			// $result;
			// $this->load->database();
			//$this->firephp->log($option, 'option');
			$query="select * from vu_perawatan";
			if($option=='LIST'){
				//$this->firephp->log('LIST');
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (rawat_kode LIKE '%".addslashes($filter)."%' OR 
							 rawat_kodelama LIKE '%".addslashes($filter)."%' OR 
							 rawat_nama LIKE '%".addslashes($filter)."%' OR 
							 group_nama LIKE '%".addslashes($filter)."%' OR 
							 jenis_nama LIKE '%".addslashes($filter)."%' OR 
							 kategori_nama LIKE '%".addslashes($filter)."%')";

			} else if($option=='SEARCH'){
				//$this->firephp->log('SEARCH');
				if($rawat_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " rawat_id LIKE '%".$rawat_id."%'";
				};
				if($rawat_kode!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " rawat_kode LIKE '%".$rawat_kode."%'";
				};
				if($rawat_kodelama!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " rawat_kodelama LIKE '%".$rawat_kodelama."%'";
				};
				if($rawat_nama!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " rawat_nama LIKE '%".$rawat_nama."%'";
				};
				if($rawat_group!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " rawat_group = '".$rawat_group."'";
				};
				if($rawat_kategori!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " rawat_kategori = '".$rawat_kategori."'";
				};
				if($rawat_jenis!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " rawat_jenis = '".$rawat_jenis."'";
				};
				if($rawat_keterangan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " rawat_keterangan LIKE '%".$rawat_keterangan."%'";
				};
				if($rawat_du!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " rawat_du = '".$rawat_du."'";
				};
				if($rawat_dm!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " rawat_dm = '".$rawat_dm."'";
				};
				if($rawat_dultah!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " rawat_dultah = '".$rawat_dultah."'";
				};
				if($rawat_dcard!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " rawat_dcard = '".$rawat_dcard."'";
				};
				if($rawat_dkolega!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " rawat_dkolega = '".$rawat_dkolega."'";
				};
				if($rawat_dkeluarga!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " rawat_dkeluarga = '".$rawat_dkeluarga."'";
				};
				if($rawat_downer!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " rawat_downer = '".$rawat_downer."'";
				};
				if($rawat_dgrooming!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " rawat_dgrooming = '".$rawat_dgrooming."'";
				};
	
				if($rawat_point!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " rawat_point = '".$rawat_point."'";
				};
				if($rawat_durasi!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " rawat_durasi = '".$rawat_durasi."'";
				};
				if($rawat_harga!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " rawat_harga = '".$rawat_harga."'";
				};
				if($rawat_gudang!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " rawat_gudang = '".$rawat_gudang."'";
				};
				if($rawat_aktif!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " rawat_aktif = '".$rawat_aktif."'";
				};
	
			}
			
			$query.=" ORDER BY rawat_id DESC";
			
			$result = $this->db->query($query);
			return $result;
				
		}
		
		//function  for export to excel
		function perawatan_export_excel(
			$rawat_id,
			$rawat_kode,
			$rawat_kodelama,
			$rawat_nama,
			$rawat_group,
			$rawat_kategori,
			$rawat_jenis,
			$rawat_keterangan,
			$rawat_du,
			$rawat_dm,
			$rawat_dultah,
			$rawat_dcard,
			$rawat_dkolega,
			$rawat_dkeluarga,
			$rawat_downer,
			$rawat_dgrooming,
			$rawat_point,
			$rawat_durasi,
			$rawat_kredit, 
			$rawat_jumlah_tindakan, 
			$rawat_harga,
			$rawat_gudang,
			$rawat_aktif,
			$option,
			$filter
		){
			//full query
			$query="SELECT
						if(rawat_kodelama='','-',ifnull(rawat_kodelama,'-')) AS 'Kode lama',
						ifnull(rawat_kode,'-') AS 'Kode baru',
						ifnull(rawat_nama,'-') AS 'Nama Perawatan',
						ifnull(group_nama,'-') AS 'Group 1',
						ifnull(jenis_nama,'-') AS  'Group 2',
						ifnull(kategori_nama,'-') AS Jenis,
						ifnull(rawat_du,'-') AS 'DU(%)',
						ifnull(rawat_dm,'-') AS 'DM(%)',
						ifnull(rawat_dultah,'-') AS 'Ultah(%)',
						ifnull(rawat_dcard,'-') AS 'Card(%)',
						ifnull(rawat_dkolega,'-') AS 'Kolega(%)',
						ifnull(rawat_dkeluarga,'-') AS 'Keluarga(%)',
						ifnull(rawat_downer,'-') AS 'Owner(%)',
						ifnull(rawat_dgrooming,'-') AS 'Grooming(%)',
						ifnull(rawat_point,'-') AS Poin,
						ifnull(rawat_durasi,'-') AS Durasi,
						ifnull(rawat_kredit,'-') AS Kredit,
						ifnull(rawat_harga,'-') AS 'Harga (Rp)',
						ifnull(gudang_nama,'-') AS Gudang,
						rawat_aktif AS Aktif
					from vu_perawatan";
					
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (rawat_kode LIKE '%".addslashes($filter)."%' OR 
							 rawat_kodelama LIKE '%".addslashes($filter)."%' OR 
							 rawat_nama LIKE '%".addslashes($filter)."%' OR 
							 group_nama LIKE '%".addslashes($filter)."%' OR 
							 jenis_nama LIKE '%".addslashes($filter)."%' OR 
							 kategori_nama LIKE '%".addslashes($filter)."%')";
			} else if($option=='SEARCH'){
				if($rawat_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " rawat_id LIKE '%".$rawat_id."%'";
				};
				if($rawat_kode!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " rawat_kode LIKE '%".$rawat_kode."%'";
				};
				if($rawat_kodelama!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " rawat_kodelama LIKE '%".$rawat_kodelama."%'";
				};
				if($rawat_nama!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " rawat_nama LIKE '%".$rawat_nama."%'";
				};
				if($rawat_group!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " rawat_group = '".$rawat_group."'";
				};
				if($rawat_kategori!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " rawat_kategori = '".$rawat_kategori."'";
				};
				if($rawat_jenis!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " rawat_jenis = '".$rawat_jenis."'";
				};
				if($rawat_keterangan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " rawat_keterangan LIKE '%".$rawat_keterangan."%'";
				};
				if($rawat_du!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " rawat_du = '".$rawat_du."'";
				};
				if($rawat_dm!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " rawat_dm = '".$rawat_dm."'";
				};
				if($rawat_dultah!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " rawat_dultah = '".$rawat_dultah."'";
				};
				if($rawat_dcard!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " rawat_dcard = '".$rawat_dcard."'";
				};
				if($rawat_dkolega!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " rawat_dkolega = '".$rawat_dkolega."'";
				};
				if($rawat_dkeluarga!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " rawat_dkeluarga = '".$rawat_dkeluarga."'";
				};
				if($rawat_downer!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " rawat_downer = '".$rawat_downer."'";
				};
				if($rawat_dgrooming!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " rawat_dgrooming = '".$rawat_dgrooming."'";
				};	
				if($rawat_point!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " rawat_point = '".$rawat_point."'";
				};
				if($rawat_durasi!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " rawat_durasi = '".$rawat_durasi."'";
				};
				if($rawat_harga!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " rawat_harga = '".$rawat_harga."'";
				};
				if($rawat_gudang!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " rawat_gudang = '".$rawat_gudang."'";
				};
				if($rawat_aktif!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " rawat_aktif = '".$rawat_aktif."'";
				};
				
			}
			$query.=" ORDER BY rawat_id DESC";
			
			$result = $this->db->query($query);
			return $result;
		}
		
}
?>