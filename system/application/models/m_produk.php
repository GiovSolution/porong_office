<? /* 	
	GIOV Solution
*/

class M_produk extends Model{
		
		//constructor
		function M_produk() {
			parent::Model();
		}
		
		//function for detail
		//get record list
		function detail_satuan_konversi_list($master_id,$query,$start,$end) {
			$query = "SELECT * FROM satuan_konversi where konversi_produk='".$master_id."'";
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
		
		//function for detail
		//get record list
		function detail_produk_racikan_list($master_id,$query,$start,$end) {
			$query = "SELECT * FROM produk_racikan where pracikan_master='".$master_id."'";
			$query.=" ORDER BY pracikan_produk ASC";
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
		
		
		function get_kontribusi_produk_list(){
		$sql="SELECT kategori2_id,kategori2_nama FROM kategori2 WHERE  kategori2_aktif='Aktif'";
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
		//get master id, note : not done yet
		function get_master_id() {
			$query = "SELECT max(produk_id) as master_id from produk";
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
		
	function get_satuan_by_produk_racik_list($djproduk_id,$produk_id){
		if($djproduk_id<>0)
			$sql="SELECT satuan_id,satuan_nama,konversi_nilai,satuan_kode,konversi_default,produk_harga FROM satuan LEFT JOIN satuan_konversi ON(konversi_satuan=satuan_id) LEFT JOIN produk ON(konversi_produk=produk_id) LEFT JOIN produk_racikan ON(pracikan_produk=produk_id) WHERE produk_id='$djproduk_id'";
		
		if($produk_id<>0)
			$sql="SELECT satuan_id,satuan_nama,konversi_nilai,satuan_kode,konversi_default,produk_harga FROM satuan LEFT JOIN satuan_konversi ON(konversi_satuan=satuan_id) LEFT JOIN produk ON(konversi_produk=produk_id) WHERE produk_id='$produk_id'";
			
		if($djproduk_id==0 && $produk_id==0)
			$sql="SELECT satuan_id,satuan_nama,konversi_nilai,satuan_kode,konversi_default,produk_harga FROM produk,satuan_konversi,satuan WHERE produk_id=konversi_produk AND konversi_satuan=satuan_id";
		//$sql="SELECT satuan_id,satuan_nama,satuan_kode FROM satuan";
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
		
		
		
		function get_produk_list($query,$start,$end){
			$rs_rows=0;
			if(is_numeric($query)==true){
				$sql_dproduk="SELECT pracikan_produk FROM produk_racikan WHERE pracikan_master='$query'";
				$rs=$this->db->query($sql_dproduk);
				$rs_rows=$rs->num_rows();
			}
			
			//$sql="select * from vu_produk WHERE produk_aktif='Aktif'";
			$sql="select * from vu_produk WHERE produk_aktif='Aktif'";
			if($query<>"" && is_numeric($query)==false){
				$sql.=eregi("WHERE",$sql)? " AND ":" WHERE ";
				$sql.=" (produk_kode like '%".$query."%' or produk_nama like '%".$query."%' or satuan_nama like '%".$query."%' or kategori_nama like '%".$query."%' or group_nama like '%".$query."%' or produk_kodelama like '%".$query."%') ";
			}else{
				if($rs_rows){
					$filter="";
					$sql.=eregi("AND",$sql)? " OR ":" AND ";
					foreach($rs->result() as $row_dproduk){
						
						$filter.="OR produk_id='".$row_dproduk->pracikan_produk."' ";
					}
					$sql=$sql."(".substr($filter,2,strlen($filter)).")";
				}
			}
			$sql.=" ORDER BY produk_id ASC";
			/*if($query<>"")
				$sql.=" WHERE (produk_kode like '%".$query."%' or produk_nama like '%".$query."%' or satuan_nama like '%".$query."%'
							 or kategori_nama like '%".$query."%' or group_nama like '%".$query."%') ";*/
			//echo $sql;
			
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
		
		
		//purge all detail from master
		function detail_satuan_konversi_purge($master_id){
			$sql="DELETE from satuan_konversi where konversi_produk='".$master_id."'";
			$result=$this->db->query($sql);
			return '1';
		}
		//*eof
		
		//purge all detail from master
		function detail_produk_racikan_purge($master_id){
			$sql="DELETE from produk_racikan where pracikan_master='".$master_id."'";
			$result=$this->db->query($sql);
			return '1';
		}
		//*eof
		
		
		//insert detail record
		function detail_satuan_konversi_insert($konversi_id ,$konversi_produk ,$konversi_satuan ,$konversi_nilai ,$konversi_default){
			//if master id not capture from view then capture it from max pk from master table
			if($konversi_produk=="" || $konversi_produk==NULL){
				$konversi_produk=$this->get_master_id();
			}
			
			$data = array(
				"konversi_produk"=>$konversi_produk, 
				"konversi_satuan"=>$konversi_satuan, 
				"konversi_nilai"=>$konversi_nilai,
				"konversi_default"=>$konversi_default
			);
			$this->db->insert('satuan_konversi', $data); 
			if($this->db->affected_rows())
				return '1';
			else
				return '0';

		}
		//end of function
		
		//insert detail record
		function detail_produk_racikan_insert($pracikan_id ,$pracikan_master ,$pracikan_produk ,$pracikan_satuan ,$pracikan_jumlah ){
			//if master id not capture from view then capture it from max pk from master table
			if($pracikan_master=="" || $pracikan_master==NULL){
				$pracikan_master=$this->get_master_id();
			}
			
			$data = array(
				"pracikan_master"=>$pracikan_master, 
				"pracikan_produk"=>$pracikan_produk, 
				"pracikan_satuan"=>$pracikan_satuan, 
				"pracikan_jumlah"=>$pracikan_jumlah 
			);
			$this->db->insert('produk_racikan', $data); 
			if($this->db->affected_rows())
				return '1';
			else
				return '0';

		}
		//end of function
		
		
		/*function get_kode($pattern_g,$pattern_j){
			$result=$this->m_public_function->get_kode_2("produk","produk_kode",$pattern_g,$pattern_j,6);
			return $result;
		}*/
		
		function get_kode($pattern){
			$result=$this->m_public_function->get_kode_1("produk","produk_kode",$pattern,7);
			return $result;
		}
		//function for get list record
		function produk_list($filter,$start,$end){
			//$query = "SELECT * FROM produk,produk_group,kategori,satuan,jenis,kategori2 WHERE produk_group=group_id AND produk_kategori=kategori_id AND produk_satuan=satuan_id AND produk_jenis=jenis_id AND produk_kontribusi=kategori2_id";
			$query="select * from vu_produk where produk_aktif = 'Aktif'";
			
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (produk_kode LIKE '%".addslashes($filter)."%' OR jenis_nama LIKE '%".addslashes($filter)."%' OR kategori_nama LIKE '%".addslashes($filter)."%' OR produk_nama LIKE '%".addslashes($filter)."%' )";
				$query .= " AND produk_aktif = 'Aktif'"; // by hendri, simple search khusus aktif only
			}
			$query.=" ORDER BY produk_id DESC";
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
		function produk_update($produk_id ,$produk_kode ,$produk_kodelama ,$produk_group ,$produk_kategori , $produk_racikan, $produk_edit_harga, $produk_kontribusi, $produk_jenis , $produk_tipe, $produk_nama ,$produk_satuan ,
								$produk_du ,$produk_dm , $produk_dultah, $produk_dcard, $produk_dkolega, $produk_dkeluarga, $produk_downer, $produk_dgrooming, $produk_dwartawan, $produk_dstaffdokter, $produk_dstaffnondokter,$produk_dpromo,
								$produk_point,$produk_kredit ,$produk_volume ,$produk_harga ,$produk_keterangan ,$produk_aktif,$produk_aktif_th ,$produk_aktif_ki ,$produk_aktif_hr ,$produk_aktif_tp ,$produk_aktif_dps ,$produk_aktif_jkt ,$produk_aktif_mta ,$produk_aktif_blpn ,$produk_aktif_kuta ,$produk_aktif_btm ,$produk_aktif_mks ,$produk_aktif_mdn ,$produk_aktif_lbk ,$produk_aktif_mnd ,$produk_aktif_ygk,$produk_aktif_corp,$produk_aktif_mlg, $produk_aktif_smg,$produk_awal_jumlah, $produk_awal_nilai,$produk_tgl_awal_nilai, $produk_harga_ki,$produk_harga_mdn,$produk_harga_mnd,$produk_harga_ygk,$produk_harga_mta, $produk_harga_lbk, $produk_harga_hr, $produk_harga_tp, $produk_harga_dps, $produk_harga_blpn, $produk_harga_kuta, $produk_harga_corp, $produk_harga_btm, $produk_harga_jkt,$produk_harga_smg, $produk_harga_mks, $produk_harga_mlg, $produk_bpom){
		
		if ($produk_aktif=="")
			$produk_aktif = "Aktif";
		if ($produk_point=="")
			$produk_point = 1;
			
		if($produk_bpom=='true')
			$produk_bpom="1";
		else if($produk_bpom=='false')
			$produk_bpom="0";

		if($produk_aktif_th=='true')
			$th="1";
		else if($produk_aktif_th=='false')
			$th="0";	
			
		if($produk_aktif_ki=='true')
			$ki="1";
		else if($produk_aktif_ki=='false')
			$ki="0";			

		if($produk_aktif_hr=='true')
			$hr="1";
		else if($produk_aktif_hr=='false')
			$hr="0";	
			
		if($produk_aktif_tp=='true')
			$tp="1";
		else if($produk_aktif_tp=='false')
			$tp="0";	
			
		if($produk_aktif_dps=='true')
			$dps="1";
		else if($produk_aktif_dps=='false')
			$dps="0";	
			
		if($produk_aktif_jkt=='true')
			$jkt="1";
		else if($produk_aktif_jkt=='false')
			$jkt="0";	
			
		if($produk_aktif_mta=='true')
			$mta="1";
		else if($produk_aktif_mta=='false')
			$mta="0";	
			
		if($produk_aktif_blpn=='true')
			$blpn="1";
		else if($produk_aktif_blpn=='false')
			$blpn="0";	
			
		if($produk_aktif_kuta=='true')
			$kuta="1";
		else if($produk_aktif_kuta=='false')
			$kuta="0";	
			
		if($produk_aktif_btm=='true')
			$btm="1";
		else if($produk_aktif_btm=='false')
			$btm="0";	
			
		if($produk_aktif_mks=='true')
			$mks="1";
		else if($produk_aktif_mks=='false')
			$mks="0";	
			
		if($produk_aktif_mdn=='true')
			$mdn="1";
		else if($produk_aktif_mdn=='false')
			$mdn="0";	
			
		if($produk_aktif_lbk=='true')
			$lbk="1";
		else if($produk_aktif_lbk=='false')
			$lbk="0";	
			
		if($produk_aktif_mnd=='true')
			$mnd="1";
		else if($produk_aktif_mnd=='false')
			$mnd="0";	
			
		if($produk_aktif_ygk=='true')
			$ygk="1";
		else if($produk_aktif_ygk=='false')
			$ygk="0";	
			
		if($produk_aktif_corp=='true')
			$corp="1";
		else if($produk_aktif_corp=='false')
			$corp="0";	
			
		if($produk_aktif_mlg=='true')
			$mlg="1";
		else if($produk_aktif_mlg=='false')
			$mlg="0";	
			
		if($produk_aktif_smg=='true')
			$smg="1";
		else if($produk_aktif_smg=='false')
			$smg="0";
			
		$temp_aktif=$th.$ki.$hr.$tp.$dps.$jkt.$mta.$blpn.$kuta.$corp.$mks.$mdn.$lbk.$mnd.$ygk.$mlg.$btm.'000'.$smg;
		
			if ($produk_aktif=="")
				$produk_aktif = "Aktif";
			if ($produk_point=="")
				$produk_point=1;
			$data = array(
				"produk_kode"=>$produk_kode, 
				"produk_kodelama"=>$produk_kodelama, 
				"produk_nama"=>$produk_nama, 
				"produk_tipe"=>$produk_tipe, 
				"produk_point"=>$produk_point, 
				"produk_kredit"=>$produk_kredit, 
				"produk_volume"=>$produk_volume, 
				"produk_harga"=>$produk_harga,
				"produk_harga_ki"=>$produk_harga_ki,
				"produk_harga_mdn"=>$produk_harga_mdn,
				"produk_harga_mnd"=>$produk_harga_mnd,
				"produk_harga_ygk"=>$produk_harga_ygk,
				"produk_harga_mta"=>$produk_harga_mta,
				"produk_harga_lbk"=>$produk_harga_lbk,
				"produk_harga_hr"=>$produk_harga_hr,
				"produk_harga_tp"=>$produk_harga_tp,
				"produk_harga_dps"=>$produk_harga_dps,
				"produk_harga_blpn"=>$produk_harga_blpn,
				"produk_harga_kuta"=>$produk_harga_kuta,
				"produk_harga_corp"=>$produk_harga_corp,
				"produk_harga_btm"=>$produk_harga_btm,
				"produk_harga_jkt"=>$produk_harga_jkt,
				"produk_harga_smg"=>$produk_harga_smg,
				"produk_harga_mks"=>$produk_harga_mks,
				"produk_harga_mlg"=>$produk_harga_mlg,
				"produk_du"=>$produk_du,
				"produk_dm"=>$produk_dm,
				"produk_dultah"=>$produk_dultah, 
				"produk_dcard"=>$produk_dcard, 
				"produk_dkolega"=>$produk_dkolega, 
				"produk_dkeluarga"=>$produk_dkeluarga, 
				"produk_downer"=>$produk_downer, 
				"produk_dgrooming"=>$produk_dgrooming, 
				"produk_dwartawan"=>$produk_dwartawan, 
				"produk_dstaffdokter"=>$produk_dstaffdokter, 
				"produk_dstaffnondokter"=>$produk_dstaffnondokter, 
				"produk_dpromo"=>$produk_dpromo, 
				"produk_keterangan"=>$produk_keterangan, 
				"produk_aktif_cabang"=>$temp_aktif,
				"produk_aktif"=>$produk_aktif,
				"produk_saldo_awal"=>$produk_awal_jumlah,
				"produk_nilai_saldo_awal"=>$produk_awal_nilai,
				"produk_tgl_nilai_saldo_awal"=>$produk_tgl_awal_nilai,
				"produk_bpom"=>$produk_bpom
			);
			
			if($produk_racikan=='true')
				$data["produk_racikan"]=1;
			if($produk_racikan=='false')
				$data["produk_racikan"]=0;
				
			if($produk_edit_harga=='true')
				$data["produk_edit_harga"]=1;
			if($produk_edit_harga=='false')
				$data["produk_edit_harga"]=0;
			
			$sql_produk_awal = "SELECT produk_group, produk_jenis FROM produk WHERE produk_id='$produk_id'";
			$rs_produk_awal = $this->db->query($sql_produk_awal);
			if($rs_produk_awal->num_rows()){
				$record_produk_awal = $rs_produk_awal->row_array();
				$produk_group_awal = $record_produk_awal['produk_group'];
				$produk_jenis_awal = $record_produk_awal['produk_jenis'];
			}
			
			
			// generate kode //
			$group_kode = '';
			if(is_numeric($produk_group) || is_numeric($produk_jenis)){
				$sql_g="SELECT group_id,group_kode FROM produk_group WHERE group_id='".$produk_group."'";
				$rs_g=$this->db->query($sql_g);
				if($rs_g->num_rows()){
					$rs_sql_g=$rs_g->row();
					$group_kode=$rs_sql_g->group_kode;
					$data["produk_group"]=$produk_group;
				}else{
					$sql_g="SELECT group_kode FROM produk,produk_group WHERE produk_group=group_id AND produk_id='".$produk_id."'";
					$rs_g=$this->db->query($sql_g);
					if($rs_g->num_rows()){
						$rs_sql_g=$rs_g->row();
						$group_kode=$rs_sql_g->group_kode;
					}
				}
							
				$sql_j="SELECT jenis_id,jenis_kode FROM jenis WHERE jenis_id='".$produk_jenis."'";
				$rs_j=$this->db->query($sql_j);
				if($rs_j->num_rows()){
					$rs_sql_j=$rs_j->row();
					$jenis_kode=$rs_sql_j->jenis_kode;
					$data["produk_jenis"]=$produk_jenis;
				}else{
					$sql_j="SELECT jenis_kode FROM produk,jenis WHERE produk_jenis=jenis_id AND produk_id='".$produk_id."'";
					$rs_j=$this->db->query($sql_j);
					if($rs_j->num_rows()){
						$rs_sql_j=$rs_j->row();
						$jenis_kode=$rs_sql_j->jenis_kode;
					}
				}
				$pattern=$group_kode.$jenis_kode;
				$produk_kode=$this->get_kode($pattern);
				if($produk_kode!=="" && strlen($produk_kode)==7){
					$data["produk_kode"]=$produk_kode;
				}
			}
			//log
			$data['produk_update']=$_SESSION[SESSION_USERID];
			$data['produk_date_update']=date('Y-m-d H:i:s');
			
//			$sql="SELECT kategori_id FROM kategori WHERE kategori_id='".$produk_kategori."'";
//			$rs=$this->db->query($sql);
//			if($rs->num_rows())
//				$data["produk_kategori"]=$produk_kategori;
			
			$sql="SELECT kategori2_id FROM kategori2 WHERE kategori2_id='".$produk_kontribusi."'";
			$rs=$this->db->query($sql);
			if($rs->num_rows())
				$data["produk_kontribusi"]=$produk_kontribusi;
				
			$sql="SELECT satuan_id FROM satuan WHERE satuan_id='".$produk_satuan."'";
			$rs=$this->db->query($sql);
			if($rs->num_rows())
				$data["produk_satuan"]=$produk_satuan;
						
			$this->db->where('produk_id', $produk_id);
			$this->db->update('produk', $data);
			
			//log
			if($this->db->affected_rows()){
				$sql="UPDATE produk set produk_revised=(produk_revised+1) WHERE produk_id='".$produk_id."'";
				$this->db->query($sql);
			}
			return '1';
		}
		
		//function for create new record
		function produk_create($produk_kode ,$produk_kodelama ,$produk_group ,$produk_kategori , $produk_racikan, $produk_edit_harga, $produk_kontribusi ,$produk_jenis , $produk_tipe, $produk_nama ,$produk_satuan ,
								$produk_du ,$produk_dm , $produk_dultah, $produk_dcard, $produk_dkolega, $produk_dkeluarga, $produk_downer, $produk_dgrooming, $produk_dwartawan, $produk_dstaffdokter, $produk_dstaffnondokter,$produk_dpromo,
								$produk_point ,$produk_kredit ,$produk_volume ,$produk_harga ,$produk_keterangan ,$produk_aktif,$produk_aktif_th ,$produk_aktif_ki ,$produk_aktif_hr ,$produk_aktif_tp ,$produk_aktif_dps ,$produk_aktif_jkt ,$produk_aktif_mta ,$produk_aktif_blpn ,$produk_aktif_kuta ,$produk_aktif_btm ,$produk_aktif_mks ,$produk_aktif_mdn ,$produk_aktif_lbk ,$produk_aktif_mnd ,$produk_aktif_ygk,$produk_aktif_corp,$produk_aktif_mlg,$produk_aktif_smg, $produk_awal_jumlah, $produk_awal_nilai , $produk_tgl_awal_nilai, $produk_harga_ki,$produk_harga_mdn,$produk_harga_mnd,$produk_harga_ygk,$produk_harga_mta, $produk_harga_lbk, $produk_harga_hr,$produk_harga_tp, $produk_harga_dps, $produk_harga_blpn, $produk_harga_kuta, $produk_harga_corp, $produk_harga_btm, $produk_harga_jkt,$produk_harga_smg, $produk_harga_mks , $produk_harga_mlg, $produk_bpom){
			/*if ($produk_aktif=="")
				$produk_aktif = "Aktif";*/
			if($produk_harga=="")
				$produk_harga=0;
			if($produk_point=="")
				$produk_point=1;
					
			if($produk_bpom=='true')
				$produk_bpom="1";
			else if($produk_bpom=='false')
				$produk_bpom="0";
					
			if($produk_aktif_th=='true')
			{
				$th="1";
				$produk_aktif = "Aktif";
			}
			else if($produk_aktif_th=='false')
			{
				$th="0";	
				$produk_aktif = "Tidak Aktif";
			}
				
			if($produk_aktif_ki=='true')
				$ki="1";
			else if($produk_aktif_ki=='false')
				$ki="0";			

			if($produk_aktif_hr=='true')
				$hr="1";
			else if($produk_aktif_hr=='false')
				$hr="0";	
				
			if($produk_aktif_tp=='true')
				$tp="1";
			else if($produk_aktif_tp=='false')
				$tp="0";	
				
			if($produk_aktif_dps=='true')
				$dps="1";
			else if($produk_aktif_dps=='false')
				$dps="0";	
				
			if($produk_aktif_jkt=='true')
				$jkt="1";
			else if($produk_aktif_jkt=='false')
				$jkt="0";	
				
			if($produk_aktif_mta=='true')
				$mta="1";
			else if($produk_aktif_mta=='false')
				$mta="0";	
				
			if($produk_aktif_blpn=='true')
				$blpn="1";
			else if($produk_aktif_blpn=='false')
				$blpn="0";	
				
			if($produk_aktif_kuta=='true')
				$kuta="1";
			else if($produk_aktif_kuta=='false')
				$kuta="0";	
				
			if($produk_aktif_btm=='true')
				$btm="1";
			else if($produk_aktif_btm=='false')
				$btm="0";	
				
			if($produk_aktif_mks=='true')
				$mks="1";
			else if($produk_aktif_mks=='false')
				$mks="0";	
				
			if($produk_aktif_mdn=='true')
				$mdn="1";
			else if($produk_aktif_mdn=='false')
				$mdn="0";	
				
			if($produk_aktif_lbk=='true')
				$lbk="1";
			else if($produk_aktif_lbk=='false')
				$lbk="0";	
				
			if($produk_aktif_mnd=='true')
				$mnd="1";
			else if($produk_aktif_mnd=='false')
				$mnd="0";	
				
			if($produk_aktif_ygk=='true')
				$ygk="1";
			else if($produk_aktif_ygk=='false')
				$ygk="0";	
				
			if($produk_aktif_corp=='true')
				$corp="1";
			else if($produk_aktif_corp=='false')
				$corp="0";
				
			if($produk_aktif_mlg=='true')
				$mlg="1";
			else if($produk_aktif_mlg=='false')
				$mlg="0";	
				
			if($produk_aktif_smg=='true')
				$smg="1";
			else if($produk_aktif_smg=='false')
				$smg="0";	
				
			$temp_aktif=$th.$ki.$hr.$tp.$dps.$jkt.$mta.$blpn.$kuta.$corp.$mks.$mdn.$lbk.$mnd.$ygk.$mlg.$btm.'000'.$smg;						
				
			$data = array(
				"produk_kode"=>$produk_kode,
				"produk_kodelama"=>$produk_kodelama,
				"produk_kategori"=>$produk_kategori, 
				"produk_kontribusi"=>$produk_kontribusi,
				"produk_jenis"=>$produk_jenis, 
				"produk_tipe"=>$produk_tipe, 
				"produk_group"=>$produk_group,
				"produk_nama"=>$produk_nama, 
				"produk_satuan"=>$produk_satuan, 
				"produk_du"=>$produk_du, 
				"produk_dm"=>$produk_dm, 
				"produk_dultah"=>$produk_dultah, 
				"produk_dcard"=>$produk_dcard, 
				"produk_dkolega"=>$produk_dkolega, 
				"produk_dkeluarga"=>$produk_dkeluarga, 
				"produk_downer"=>$produk_downer, 
				"produk_dgrooming"=>$produk_dgrooming, 
				"produk_dwartawan"=>$produk_dwartawan, 
				"produk_dstaffdokter"=>$produk_dstaffdokter, 
				"produk_dstaffnondokter"=>$produk_dstaffnondokter, 
				"produk_dpromo"=>$produk_dpromo, 
				"produk_point"=>$produk_point, 
				"produk_kredit"=>$produk_kredit, 
				"produk_volume"=>$produk_volume, 
				"produk_harga"=>$produk_harga,
				"produk_harga_ki"=>$produk_harga_ki,
				"produk_harga_mdn"=>$produk_harga_mdn,
				"produk_harga_mnd"=>$produk_harga_mnd,
				"produk_harga_ygk"=>$produk_harga_ygk,
				"produk_harga_mta"=>$produk_harga_mta,	
				"produk_harga_lbk"=>$produk_harga_lbk,
				"produk_harga_hr"=>$produk_harga_hr,
				"produk_harga_tp"=>$produk_harga_tp,
				"produk_harga_dps"=>$produk_harga_dps,
				"produk_harga_blpn"=>$produk_harga_blpn,
				"produk_harga_kuta"=>$produk_harga_kuta,
				"produk_harga_corp"=>$produk_harga_corp,
				"produk_harga_btm"=>$produk_harga_btm,
				"produk_harga_jkt"=>$produk_harga_jkt,
				"produk_harga_smg"=>$produk_harga_smg,
				"produk_harga_mks"=>$produk_harga_mks,
				"produk_harga_mlg"=>$produk_harga_mlg,
				"produk_keterangan"=>$produk_keterangan, 
				"produk_aktif_cabang"=>$temp_aktif,
				"produk_aktif"=>$produk_aktif,
				"produk_saldo_awal"=>$produk_awal_jumlah,
				"produk_nilai_saldo_awal"=>$produk_awal_nilai,
				"produk_tgl_nilai_saldo_awal"=>$produk_tgl_awal_nilai,
				"produk_bpom"=>$produk_bpom
			);
			
			if($produk_racikan=='true')
				$data["produk_racikan"]=1;
			if($produk_racikan=='false')
				$data["produk_racikan"]=0;
				
			if($produk_edit_harga=='true')
				$data["produk_edit_harga"]=1;
			if($produk_edit_harga=='false')
				$data["produk_edit_harga"]=0;	
			
			
			//log
			$data['produk_creator']=$_SESSION[SESSION_USERID];
			$data['produk_date_create']=date('Y-m-d H:i:s');
			$data['produk_revised']='0';
			
			/*$sql="SELECT group_id, group_kode FROM produk_group WHERE group_id='".$produk_group."' ";
			$rs=$this->db->query($sql);
			if($rs->num_rows()){
				$row=$rs->row();
				
				$sql_2="SELECT jenis_id, jenis_kode FROM jenis WHERE jenis_id='".$produk_jenis."' ";
				$rs_2=$this->db->query($sql_2);
				if($rs_2->num_rows()){
					$row_2=$rs_2->row();
					$data["produk_kode"]=$this->get_kode($row->group_kode,$row_2->jenis_kode);
				}
				
				
			}*/
			
			//generate produk kode
			//get group kode
			
			$kategori_kode="";
			$jenis_kode="";
			
			$sql_g="SELECT kategori_id, kategori_kode FROM kategori WHERE kategori_id='".$produk_kategori."'";
			$rs_g=$this->db->query($sql_g);
			if($rs_g->num_rows()){
				$rs_sql_g=$rs_g->row();
				$kategori_kode=$rs_sql_g->kategori_kode;
				$data["produk_kategori"]=$produk_kategori;
			}
			//get group2 kode
			$sql_g="SELECT jenis_id FROM jenis WHERE jenis_id='".$produk_jenis."'";
			$rs_g=$this->db->query($sql_g);
			if($rs_g->num_rows()){
				$rs_sql_g=$rs_g->row();
				//$jenis_kode=$rs_sql_g->jenis_kode;
				$data["produk_jenis"]=$produk_jenis;
			}
			//$pattern=$group_kode.$jenis_kode;
			$pattern=$kategori_kode;
			$produk_kode=$this->get_kode($pattern);
			//echo $produk_kode;
			if($produk_kode!=="" /*&& strlen($produk_kode)==5*/)
				$data["produk_kode"]=$produk_kode;
				
			$this->db->insert('produk', $data); 
			if($this->db->affected_rows())
				return '1';
			else
				return '0';
		}
		
		//fcuntion for delete record
		function produk_delete($pkid){
			// You could do some checkups here and return '0' or other error consts.
			// Make a single query to delete all of the produks at the same time :
			if(sizeof($pkid)<1){
				return '0';
			} else if (sizeof($pkid) == 1){
				$query = "DELETE FROM produk WHERE produk_id = ".$pkid[0];
				$this->db->query($query);
			} else {
				$query = "DELETE FROM produk WHERE ";
				for($i = 0; $i < sizeof($pkid); $i++){
					$query = $query . "produk_id= ".$pkid[$i];
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
		function produk_search($produk_id ,$produk_kode ,$produk_kodelama ,$produk_group ,$produk_kategori ,$produk_jenis ,$produk_nama ,$produk_satuan ,
								$produk_du ,$produk_dm ,$produk_dultah, $produk_dcard, $produk_dkolega, $produk_dkeluarga, $produk_downer, $produk_dgrooming,
								$produk_point ,$produk_kredit,$produk_kontribusi ,$produk_volume ,$produk_harga ,$produk_keterangan ,$produk_aktif ,$start,$end, $kategori2_nama){
			//full query
			if($produk_aktif=="")
				$produk_aktif="Aktif";
			$query="select * from vu_produk";
			
			if($produk_id!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " produk_id LIKE '%".$produk_id."%'";
			};
			if($produk_kode!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " produk_kode LIKE '%".$produk_kode."%'";
			};
			if($produk_kodelama!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " produk_kodelama LIKE '%".$produk_kodelama."%'";
			};
			if($produk_group!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " produk_group = '".$produk_group."'";
			};
			if($produk_kategori!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " kategori_id = '".$produk_kategori."'";
			};
			if($kategori2_nama!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " kategori2_nama = '".$kategori2_nama."'";
			};
			if($produk_jenis!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " produk_jenis = '".$produk_jenis."'";
			};
			if($produk_nama!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " produk_nama LIKE '%".$produk_nama."%'";
			};
			if($produk_satuan!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " produk_satuan LIKE '%".$produk_satuan."%'";
			};
			if($produk_du!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " produk_du = '".$produk_du."'";
			};
			if($produk_dm!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " produk_dm = '".$produk_dm."'";
			};
			if($produk_dultah!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " produk_dultah = '".$produk_dultah."'";
			};
			if($produk_dcard!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " produk_dcard = '".$produk_dcard."'";
			};
			if($produk_dkolega!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " produk_dkolega = '".$produk_dkolega."'";
			};
			if($produk_dkeluarga!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " produk_dkeluarga = '".$produk_dkeluarga."'";
			};
			if($produk_downer!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " produk_downer = '".$produk_downer."'";
			};
			if($produk_dgrooming!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " produk_dgrooming = '".$produk_dgrooming."'";
			};
			if($produk_point!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " produk_point LIKE '%".$produk_point."%'";
			};
			if($produk_kredit!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " produk_kredit LIKE '%".$produk_kredit."%'";
			};
			if($produk_kontribusi!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " produk_kontribusi='".$produk_kontribusi."'";
			};
			if($produk_volume!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " produk_volume = '".$produk_volume."'";
			};
			if($produk_harga!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " produk_harga = '".$produk_harga."'";
			};
			if($produk_keterangan!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " produk_keterangan LIKE '%".$produk_keterangan."%'";
			};
			if($produk_aktif!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " produk_aktif = '".$produk_aktif."'";
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
		function produk_print($produk_id ,$produk_kode ,$produk_kodelama ,$produk_group ,$produk_kategori ,$produk_jenis ,$produk_nama ,$produk_satuan ,
								$produk_du ,$produk_dm , $produk_dultah, $produk_dcard, $produk_dkolega, $produk_dkeluarga, $produk_downer, $produk_dgrooming,
								$produk_point ,$produk_kredit,$produk_volume ,$produk_harga ,$produk_keterangan ,$produk_aktif ,$option,$filter){
			//full query
			$query="select * from vu_produk";
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (produk_id LIKE '%".addslashes($filter)."%' OR produk_kode LIKE '%".addslashes($filter)."%' OR produk_kodelama LIKE '%".addslashes($filter)."%' OR produk_group LIKE '%".addslashes($filter)."%' OR produk_kategori LIKE '%".addslashes($filter)."%' OR produk_jenis LIKE '%".addslashes($filter)."%' OR produk_nama LIKE '%".addslashes($filter)."%' OR produk_satuan LIKE '%".addslashes($filter)."%' OR produk_du LIKE '%".addslashes($filter)."%' OR produk_dm LIKE '%".addslashes($filter)."%' OR produk_point LIKE '%".addslashes($filter)."%' OR produk_kredit LIKE '%".addslashes($filter)."%' OR produk_volume LIKE '%".addslashes($filter)."%' OR produk_harga LIKE '%".addslashes($filter)."%' OR produk_keterangan LIKE '%".addslashes($filter)."%' )";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($produk_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " produk_id LIKE '%".$produk_id."%'";
				};
				if($produk_kode!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " produk_kode LIKE '%".$produk_kode."%'";
				};
				if($produk_kodelama!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " produk_kodelama LIKE '%".$produk_kodelama."%'";
				};
				if($produk_group!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " produk_group LIKE '%".$produk_group."%'";
				};
				if($produk_kategori!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " produk_kategori LIKE '%".$produk_kategori."%'";
				};
				if($produk_jenis!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " produk_jenis LIKE '%".$produk_jenis."%'";
				};
				if($produk_nama!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " produk_nama LIKE '%".$produk_nama."%'";
				};
				if($produk_satuan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " produk_satuan LIKE '%".$produk_satuan."%'";
				};
				if($produk_du!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " produk_du LIKE '%".$produk_du."%'";
				};
				if($produk_dm!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " produk_dm LIKE '%".$produk_dm."%'";
				};
				if($produk_dultah!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " produk_dultah = '".$produk_dultah."'";
				};
				if($produk_dcard!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " produk_dcard = '".$produk_dcard."'";
				};
				if($produk_dkolega!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " produk_dkolega = '".$produk_dkolega."'";
				};
				if($produk_dkeluarga!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " produk_dkeluarga = '".$produk_dkeluarga."'";
				};
				if($produk_downer!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " produk_downer = '".$produk_downer."'";
				};
				if($produk_dgrooming!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " produk_dgrooming = '".$produk_dgrooming."'";
				};
				if($produk_point!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " produk_point LIKE '%".$produk_point."%'";
				};
				if($produk_kredit!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " produk_kredit LIKE '%".$produk_kredit."%'";
				};
				if($produk_volume!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " produk_volume LIKE '%".$produk_volume."%'";
				};
				if($produk_harga!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " produk_harga LIKE '%".$produk_harga."%'";
				};
				if($produk_keterangan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " produk_keterangan LIKE '%".$produk_keterangan."%'";
				};
				// if($produk_aktif!=''){
					// $query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					// $query.= " produk_aktif = 'Aktif'";
				// };
				$result = $this->db->query($query);
			}
			return $result;
		}
		
		//function  for export to excel
		function produk_export_excel($produk_id ,$produk_kode ,$produk_kodelama ,$produk_group ,$produk_kategori ,$produk_jenis ,$produk_nama ,$produk_satuan ,
										$produk_du ,$produk_dm , $produk_dultah, $produk_dcard, $produk_dkolega, $produk_dkeluarga, $produk_downer, $produk_dgrooming,
										$produk_point ,$produk_kredit, $produk_volume ,$produk_harga ,$produk_keterangan ,$produk_aktif ,$option,$filter){
			//full query
			$query="SELECT	if(produk_kodelama='','-',ifnull(produk_kodelama,'-')) AS kode_lama,
							ifnull(produk_kode,'-') AS kode_baru,
							ifnull(produk_nama,'-') AS nama,
							ifnull(group_nama,'-') AS group_1,
							ifnull(jenis_nama,'-') AS group_2,
							ifnull(kategori_nama,'-') AS jenis,
							ifnull(satuan_nama,'-') AS satuan,
							ifnull(produk_du,'-') AS 'DU (%)',
							ifnull(produk_dm,'-') AS 'DM (%)',
							ifnull(produk_dultah,'-') AS 'dultah (%)',
							ifnull(produk_dcard,'-') AS 'dcard (%)',
							ifnull(produk_dkolega,'-') AS 'dkolega (%)',
							ifnull(produk_dkeluarga,'-') AS 'dkeluarga (%)',
							ifnull(produk_downer,'-') AS 'downer (%)',
							ifnull(produk_dgrooming,'-') AS 'dgrooming (%)',
							ifnull(produk_dwartawan,'-') AS 'dwartawan (%)',
							ifnull(produk_dstaffdokter,'-') AS 'dstaffdokter (%)',
							ifnull(produk_dstaffnondokter,'-') AS 'dstaffnondokter (%)',
							ifnull(produk_dpromo,'-') AS 'dpromo (%)',
							ifnull(produk_point,'-') AS point,
							ifnull(produk_kredit,'-') AS kredit,
							ifnull(produk_volume,'-') AS vol,
							ifnull(produk_harga,'-') AS harga,
							produk_aktif AS aktif,
							produk_keterangan

					from 	vu_produk";
					
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (produk_id LIKE '%".addslashes($filter)."%' OR produk_kode LIKE '%".addslashes($filter)."%' OR produk_kodelama LIKE '%".addslashes($filter)."%' OR produk_group LIKE '%".addslashes($filter)."%' OR produk_kategori LIKE '%".addslashes($filter)."%' OR produk_jenis LIKE '%".addslashes($filter)."%' OR produk_nama LIKE '%".addslashes($filter)."%' OR produk_satuan LIKE '%".addslashes($filter)."%' OR produk_du LIKE '%".addslashes($filter)."%' OR produk_dm LIKE '%".addslashes($filter)."%' OR produk_point LIKE '%".addslashes($filter)."%' OR produk_kredit LIKE '%".addslashes($filter)."%' OR produk_volume LIKE '%".addslashes($filter)."%' OR produk_harga LIKE '%".addslashes($filter)."%' OR produk_keterangan LIKE '%".addslashes($filter)."%' OR produk_aktif = '".addslashes($filter)."' )";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($produk_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " produk_id LIKE '%".$produk_id."%'";
				};
				if($produk_kode!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " produk_kode LIKE '%".$produk_kode."%'";
				};
				if($produk_kodelama!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " produk_kodelama LIKE '%".$produk_kodelama."%'";
				};
				if($produk_group!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " produk_group = '".$produk_group."'";
				};
				if($produk_kategori!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " kategori_id = '".$produk_kategori."'";
				};
				if($produk_jenis!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " produk_jenis = '".$produk_jenis."'";
				};
				if($produk_nama!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " produk_nama LIKE '%".$produk_nama."%'";
				};
				if($produk_satuan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " produk_satuan LIKE '%".$produk_satuan."%'";
				};
				if($produk_du!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " produk_du = '".$produk_du."'";
				};
				if($produk_dm!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " produk_dm = '".$produk_dm."'";
				};
				if($produk_dultah!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " produk_dultah = '".$produk_dultah."'";
				};
				if($produk_dcard!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " produk_dcard = '".$produk_dcard."'";
				};
				if($produk_dkolega!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " produk_dkolega = '".$produk_dkolega."'";
				};
				if($produk_dkeluarga!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " produk_dkeluarga = '".$produk_dkeluarga."'";
				};
				if($produk_downer!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " produk_downer = '".$produk_downer."'";
				};
				if($produk_dgrooming!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " produk_dgrooming = '".$produk_dgrooming."'";
				};
				if($produk_point!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " produk_point = '".$produk_point."'";
				};
				if($produk_kredit!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " produk_kredit = '".$produk_kredit."'";
				};
				if($produk_volume!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " produk_volume = '".$produk_volume."'";
				};
				if($produk_harga!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " produk_harga = '".$produk_harga."'";
				};
				if($produk_keterangan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " produk_keterangan LIKE '%".$produk_keterangan."%'";
				};
				 if($produk_aktif!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " produk_aktif = '".$produk_aktif."'";
				}else{
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " produk_aktif = 'Aktif'";
				};
				$result = $this->db->query($query);
			}
			return $result;
		}
		
}
?>