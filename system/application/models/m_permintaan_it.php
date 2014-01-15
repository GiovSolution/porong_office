<? /* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)

	
	+ Module  		: Permintaan IT Model
	+ Description	: For record model process back-end
	+ Filename 		: m_permintaan_it.php
 	+ Author  		: Isaac
 	+ Created on 
	
*/

class m_permintaan_it extends Model{
		
		//constructor
		function m_permintaan_it() {
			parent::Model();
		}
		
		function get_cabang_list(){
			$sql="SELECT cabang_id,cabang_nama FROM cabang ";
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
		
		function get_user_login(){
			$username = $_SESSION[SESSION_USERID];
			$sql="SELECT 
						users.user_karyawan AS user_karyawan, 
						karyawan.karyawan_nama AS karyawan_nama,
						users.user_name AS user_name
					FROM users 
			LEFT JOIN karyawan ON karyawan.karyawan_id = users.user_karyawan
			WHERE user_name ='".$username."'";
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
			$query = "SELECT max(permintaan_id) as master_id from permintaan_it";
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
		
		//insert detail record
		function detail_catatan_insert($array_dcatatan_id ,$dcatatan_master ,$array_dcatatan_tanggal, $array_dcatatan_user, $array_dcatatan_isi){
			//$datetime_now = date('Y-m-d H:i:s');
			//if master id not capture from view then capture it from max pk from master table
			if($dcatatan_master=="" || $dcatatan_master==NULL || $dcatatan_master==0){
				$dcatatan_master=$this->get_master_id();
			}
			
			$size_array = sizeof($array_dcatatan_user) - 1;
			
			for($i = 0; $i < sizeof($array_dcatatan_user); $i++){
				$dcatatan_id = $array_dcatatan_id[$i];
				$dcatatan_master = $dcatatan_master;
				$dcatatan_tanggal = $array_dcatatan_tanggal[$i];
				$dcatatan_user = $array_dcatatan_user[$i];
				$dcatatan_isi = $array_dcatatan_isi[$i];
				
				$sql = "SELECT dcatatan_id
						,dcatatan_revised
					FROM permintaan_it_catatan
					WHERE dcatatan_id='".$dcatatan_id."'";
				$rs = $this->db->query($sql);
				
				if($rs->num_rows()){
				// jika datanya sudah ada maka update saja
					$dtu_dcatatan = array(
						"dcatatan_master"=>$dcatatan_master,
						"dcatatan_tanggal"=>$dcatatan_tanggal,
						"dcatatan_user"=>$dcatatan_user,
						"dcatatan_isi"=>$dcatatan_isi,
						//"dcatatan_revised"=>$dcatatan_revised+1
					);
					$this->db->where('dcatatan_id', $dcatatan_id);
					$this->db->update('permintaan_it_catatan', $dtu_dcatatan); 
					if($this->db->affected_rows()){
						$sql="UPDATE permintaan_it_catatan set dcatatan_revised=(dcatatan_revised+1) WHERE dcatatan_id='".$dcatatan_id."'";
						$this->db->query($sql);
					}
				} else {
					$data = array(
						"dcatatan_master"=>$dcatatan_master,
						"dcatatan_tanggal"=>$dcatatan_tanggal,
						"dcatatan_user"=>$dcatatan_user,
						"dcatatan_isi"=>$dcatatan_isi
					);
					$this->db->insert('permintaan_it_catatan', $data); 
					
				}
					
				}
				return '1';
		}
		//end of function
		
		//function for detail
		//get record list
		function detail_catatan_list($master_id,$query,$start,$end) {
			$query = "SELECT * FROM permintaan_it_catatan where dcatatan_master='".$master_id."'";

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
		
		
		//function for get list record
		function permintaan_list($filter,$start,$end){
			$username = $_SESSION[SESSION_USERID];
			$sql_id_cust= "SELECT user_karyawan FROM users WHERE user_name ='".$username."'";
			$query_id_cust= $this->db->query($sql_id_cust);
			$data_id_cust= $query_id_cust->row();
			$permintaan_client_id= $data_id_cust->user_karyawan;
			$query = "
			SELECT karyawan.karyawan_nama AS nama, 
				cabang.cabang_nama AS cabang,
				(SELECT karyawan_nama FROM karyawan WHERE karyawan_id = permintaan_it.permintaan_mengetahui) AS mengetahui_nama,
				(SELECT karyawan_nama FROM karyawan WHERE karyawan_id = permintaan_it.permintaan_mengetahui2) AS mengetahui_nama2,
				permintaan_it.permintaan_cabang AS cabang_id,
				permintaan_it.permintaan_client AS client,
				permintaan_it.permintaan_id as permintaan_id,
				permintaan_it.permintaan_tanggal_masalah AS tanggal_masalah,
				permintaan_it.permintaan_type AS tipe,
				permintaan_it.permintaan_type2 AS tipe2,
				permintaan_it.permintaan_type3 AS tipe3,
				permintaan_it.permintaan_judul AS judul, 
				permintaan_it.permintaan_masalah AS masalah,
				permintaan_it.permintaan_prioritas AS prioritas,
				permintaan_it.permintaan_mengetahui AS mengetahui,
				permintaan_it.permintaan_mengetahui_status AS mengetahui_status,
				permintaan_it.permintaan_mengetahui_keterangan AS mengetahui_keterangan,
				permintaan_it.permintaan_mengetahui_status2 AS mengetahui_status2,
				permintaan_it.permintaan_mengetahui_keterangan2 AS mengetahui_keterangan2,
				permintaan_it.permintaan_mengetahui2 AS mengetahui2,
				permintaan_it.permintaan_penyelesaian AS penyelesaian, 
				permintaan_it.permintaan_tanggal_selesai AS tanggal_selesai, 
				permintaan_it.permintaan_status AS status
			FROM permintaan_it
				LEFT JOIN karyawan ON permintaan_it.permintaan_client = karyawan.karyawan_id
				LEFT JOIN cabang ON permintaan_it.permintaan_cabang = cabang.cabang_id";
			
			if ($permintaan_client_id<>"2" && $permintaan_client_id<>"11" && $permintaan_client_id<>"66" && $permintaan_client_id<>"79"){
				//$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " WHERE (permintaan_it.permintaan_client ='".$permintaan_client_id."' OR permintaan_it.permintaan_mengetahui ='".$permintaan_client_id."' OR permintaan_it.permintaan_mengetahui2 ='".$permintaan_client_id."')";
			}
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (karyawan.karyawan_nama LIKE '%".addslashes($filter)."%' OR cabang.cabang_nama LIKE '%".addslashes($filter)."%' OR permintaan_it.permintaan_judul LIKE '%".addslashes($filter)."%' )";
			}
			$query.=" ORDER BY tanggal_masalah DESC";
			
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
		function permintaan_update($permintaan_id, $permintaan_client, $permintaan_nama ,$permintaan_cabang ,$permintaan_tanggalmasalah ,$permintaan_tipe,$permintaan_tipe2,$permintaan_tipe3 ,$permintaan_judul ,$permintaan_permintaan ,$permintaan_prioritas, $permintaan_mengetahui, $permintaan_mengetahuistatus, $permintaan_mengetahuiketerangan, $permintaan_mengetahuistatus2, $permintaan_mengetahuiketerangan2, $permintaan_mengetahui2 ,$permintaan_penyelesaian ,$permintaan_status, $permintaan_tanggalselesai ){
			if ($permintaan_tipe=="")
				$permintaan_tipe = "MIS";
			if ($permintaan_prioritas=="")
				$permintaan_prioritas = "Normal";
			if ($permintaan_status=="")
				$permintaan_status = "Baru";
			
			$username = $_SESSION[SESSION_USERID];
			$data = array(
				"permintaan_id"=>$permintaan_id,
				"permintaan_client"=>$permintaan_client,
				//"permintaan_cabang"=>$permintaan_cabang,	
				"permintaan_tanggal_masalah"=>$permintaan_tanggalmasalah,	
				"permintaan_type"=>$permintaan_tipe,
				"permintaan_type2"=>$permintaan_tipe2,
				"permintaan_type3"=>$permintaan_tipe3,				
				"permintaan_judul"=>$permintaan_judul,	
				"permintaan_masalah"=>$permintaan_permintaan,	
				"permintaan_prioritas"=>$permintaan_prioritas,				
				"permintaan_penyelesaian"=>$permintaan_penyelesaian,
				"permintaan_mengetahui_status"=>$permintaan_mengetahuistatus,
				"permintaan_mengetahui_keterangan"=>$permintaan_mengetahuiketerangan,
				"permintaan_mengetahui_status2"=>$permintaan_mengetahuistatus2,
				"permintaan_mengetahui_keterangan2"=>$permintaan_mengetahuiketerangan2,
				"permintaan_status"=>$permintaan_status,
				"permintaan_tanggal_selesai"=>$permintaan_tanggalselesai					
			);
			
			
			$sql_karyawan="SELECT karyawan_nama FROM karyawan WHERE karyawan_id='".$permintaan_client."'";
			$rs_karyawan=$this->db->query($sql_karyawan);
			if($rs_karyawan->num_rows()) {
				$data_karyawan = $rs_karyawan->row();
				$karyawan_nama= $data_karyawan->karyawan_nama;
			} else {
				$karyawan_nama = '';
			}
			
			$sql="SELECT cabang_id FROM cabang WHERE cabang_id='".$permintaan_cabang."'";
			$rs=$this->db->query($sql);
			if($rs->num_rows())
				$data["permintaan_cabang"]=$permintaan_cabang;
				
			$sql="SELECT karyawan_id FROM karyawan WHERE karyawan_id='".$permintaan_mengetahui."'";
			$rs=$this->db->query($sql);
			if($rs->num_rows())
				$data["permintaan_mengetahui"]=$permintaan_mengetahui;
			
			$sql="SELECT karyawan_id FROM karyawan WHERE karyawan_id='".$permintaan_mengetahui2."'";
			$rs=$this->db->query($sql);
			if($rs->num_rows())
				$data["permintaan_mengetahui2"]=$permintaan_mengetahui2;

			$this->db->where('permintaan_id', $permintaan_id);
			$this->db->update('permintaan_it', $data);
			
			// UPDATE KIRIM EMAIL KE IT DAN ORANG YG BERSANGKUTAN
			// untuk kirim email
			if ($permintaan_cabang <> 'Pilih Satu') {
				$sql_cabang= "SELECT cabang_nama FROM cabang WHERE cabang_id ='".$permintaan_cabang."'";
				$query_cabang= $this->db->query($sql_cabang);
				if($query_cabang->num_rows()){
					$data_cabang= $query_cabang->row();
					$cabang_nama= $data_cabang->cabang_nama;
				} else {
					$cabang_nama = $permintaan_cabang;
				}
			}
			else {
				$cabang_nama = "";
			}
			// ambil email mengetahui
			if ($permintaan_mengetahui <> 'Pilih Satu' && $permintaan_mengetahui <> '') {
				$sql_mengetahui= "SELECT karyawan_emiracle FROM karyawan WHERE karyawan_nama ='".$permintaan_mengetahui."'";
				$query_mengetahui= $this->db->query($sql_mengetahui);
				if($query_mengetahui->num_rows()){
					$data_mengetahui= $query_mengetahui->row();
					$email_mengetahui= $data_mengetahui->karyawan_emiracle;
				} else {
					$email_mengetahui = '';
				}
			}
			else {
				$email_mengetahui = '';
			}
			if ($permintaan_mengetahui2 <> 'Pilih Satu' && $permintaan_mengetahui2 <> '') {
				$sql_mengetahui2= "SELECT karyawan_emiracle FROM karyawan WHERE karyawan_nama ='".$permintaan_mengetahui2."'";
				$query_mengetahui2= $this->db->query($sql_mengetahui2);
				if($query_mengetahui2->num_rows()){
					$data_mengetahui2= $query_mengetahui2->row();
					$email_mengetahui2= $data_mengetahui2->karyawan_emiracle;
				} else {
					$email_mengetahui2 = '';
				}
			} else {
				$email_mengetahui2 = '';
			}
			if ($permintaan_client <> '') {
				$sql_client= "SELECT karyawan_emiracle FROM karyawan WHERE karyawan_id ='".$permintaan_client."'";
				$query_client= $this->db->query($sql_client);
				if($query_client->num_rows()){
					$data_client= $query_client->row();
					$email_client= $data_client->karyawan_emiracle;
				} else {
					$email_client = '';
				}
			} else {
				$email_client = '';
			}
			
			
			$config = Array(
				'protocol' => 'smtp',
				'smtp_host' => 'mail.miracle-clinic.com',
				'smtp_port' => 25,
				'smtp_user' => 'admin@miracle-clinic.com',
				'smtp_pass' => 'serve3LOVE',
			);
			$this->load->library('email', $config);
			$this->email->set_newline("\r\n");
			
			$this->email->from('admin@miracle-clinic.com', 'Miracle Information System');
			
			$email_kirim = $email_mengetahui.','.$email_mengetahui2.','
			.'isaac@miracle-clinic.com, 
			hendri@miracle-clinic.com, 
			freddy@miracle-clinic.com, 
			sindarto@miracle-clinic.com,
			natalie@miracle-clinic.com,
			windra@miracle-clinic.com,
			it@miracle-clinic.com';
			
			$email_kirim = $email_mengetahui.','.$email_mengetahui2.','.$email_client.','.'isaac@miracle-clinic.com';
			//$this->email->to('isaac@miracle-clinic.com');
			$this->email->to($email_kirim);
			
			$judul_email = 'Permintaan IT dari '.$karyawan_nama;
			$isi_email = 
				'Dear : '.$karyawan_nama.''
				."\n\n".
				'Cabang			: '.$cabang_nama 
				."\n".	
				'Tanggal		: '.$permintaan_tanggalmasalah
				."\n".
				'Prioritas		: '.$permintaan_prioritas
				."\n".
				'Permintaan		: '.$permintaan_permintaan 
				."\n".
				'Tgl. Selesai	: '.$permintaan_tanggalselesai
				."\n".
				'Penyelesaian	: '.$permintaan_penyelesaian
				."\n". 
				'Pemohon		: '.$karyawan_nama;
			$this->email->subject($judul_email);
			$this->email->message($isi_email);
			//$this->email->send();

			return '1';

		}
		
		//function for create new record
		function permintaan_create($permintaan_nama ,$permintaan_cabang ,$permintaan_tanggalmasalah ,$permintaan_tipe,$permintaan_tipe2,$permintaan_tipe3 ,$permintaan_judul ,$permintaan_permintaan, $permintaan_prioritas, $permintaan_mengetahui, $permintaan_mengetahuistatus, $permintaan_mengetahuiketerangan, $permintaan_mengetahuistatus2, $permintaan_mengetahuiketerangan2, $permintaan_mengetahui2, $permintaan_penyelesaian ,$permintaan_status, $permintaan_tanggalselesai ){
			if ($permintaan_tipe=="")
				$permintaan_tipe = "MIS";
			if ($permintaan_tipe2=="")
				$permintaan_tipe2 = "";
			if ($permintaan_tipe3=="")
				$permintaan_tipe3 = "";
			if ($permintaan_prioritas=="")
				$permintaan_prioritas = "Low";
			if ($permintaan_status=="")
				$permintaan_status = "Baru";
			if ($permintaan_mengetahui=="")
				$permintaan_mengetahui = "Pilih Satu";
			if ($permintaan_mengetahui2=="")
				$permintaan_mengetahui2 = "Pilih Satu";
			if ($permintaan_mengetahuistatus=="")
				$permintaan_mengetahuistatus = "Pilih Satu";
			if ($permintaan_mengetahuistatus2=="")
				$permintaan_mengetahuistatus2 = "Pilih Satu";
			if ($permintaan_tanggalselesai=="")
				$permintaan_tanggalselesai = date('Y-m-d');
							
			$username = $_SESSION[SESSION_USERID];
			$sql_id_cust= "SELECT user_karyawan FROM users WHERE user_name ='".$username."'";
			$query_id_cust= $this->db->query($sql_id_cust);
			$data_id_cust= $query_id_cust->row();
			$permintaan_client_id= $data_id_cust->user_karyawan;
			
			$data = array(
				"permintaan_client"=>$permintaan_client_id,	
				"permintaan_cabang"=>$permintaan_cabang,	
				"permintaan_tanggal_masalah"=>$permintaan_tanggalmasalah,	
				"permintaan_type"=>$permintaan_tipe,
				"permintaan_type2"=>$permintaan_tipe2,
				"permintaan_type3"=>$permintaan_tipe3,				
				"permintaan_judul"=>$permintaan_judul,	
				"permintaan_masalah"=>$permintaan_permintaan,	
				"permintaan_prioritas"=>$permintaan_prioritas,	
				"permintaan_mengetahui"=>$permintaan_mengetahui,
				"permintaan_mengetahui2"=>$permintaan_mengetahui2,
				"permintaan_mengetahui_status"=>$permintaan_mengetahuistatus,
				"permintaan_mengetahui_keterangan"=>$permintaan_mengetahuiketerangan,
				"permintaan_mengetahui_status2"=>$permintaan_mengetahuistatus2,
				"permintaan_mengetahui_keterangan2"=>$permintaan_mengetahuiketerangan2,
				"permintaan_penyelesaian"=>$permintaan_penyelesaian,
				"permintaan_status"=>$permintaan_status,
				"permintaan_tanggal_selesai"=>$permintaan_tanggalselesai			
				//"gudang_revised"=>'0'	
			);
			$this->db->insert('permintaan_it', $data); 
			
			// untuk kirim email
			if ($permintaan_cabang <> 'Pilih Satu') {
			$sql_cabang= "SELECT cabang_nama FROM cabang WHERE cabang_id ='".$permintaan_cabang."'";
			$query_cabang= $this->db->query($sql_cabang);
			$data_cabang= $query_cabang->row();
			$cabang_nama= $data_cabang->cabang_nama;
			}
			else {
				$cabang_nama = "";
			}
			
			// ambil email mengetahui
			if ($permintaan_mengetahui <> 'Pilih Satu') {
				$sql_mengetahui= "SELECT karyawan_emiracle FROM karyawan WHERE karyawan_id ='".$permintaan_mengetahui."'";
				$query_mengetahui= $this->db->query($sql_mengetahui);
				if($query_mengetahui->num_rows()){
					$data_mengetahui= $query_mengetahui->row();
					$email_mengetahui= $data_mengetahui->karyawan_emiracle;
				} else {
					$email_mengetahui= '';
				}
			} else {
				$email_mengetahui = '';
			}
			
			if ($permintaan_mengetahui2 <> 'Pilih Satu') {
				$sql_mengetahui2= "SELECT karyawan_emiracle FROM karyawan WHERE karyawan_id ='".$permintaan_mengetahui2."'";
				$query_mengetahui2= $this->db->query($sql_mengetahui2);
				if($query_mengetahui2->num_rows()){
					$data_mengetahui2= $query_mengetahui2->row();
					$email_mengetahui2= $data_mengetahui2->karyawan_emiracle;
				} else {
					$email_mengetahui2= '';
				}
			} else {
				$email_mengetahui2 = '';
			}
			
			
			$config = Array(
				'protocol' => 'smtp',
				'smtp_host' => 'mail.miracle-clinic.com',
				'smtp_port' => 25,
				'smtp_user' => 'admin@miracle-clinic.com',
				'smtp_pass' => 'serve3LOVE',
			);
			$this->load->library('email', $config);
			$this->email->set_newline("\r\n");
			
			$this->email->from('admin@miracle-clinic.com', 'Miracle Information System');
			
			$email_kirim = $email_mengetahui.','.$email_mengetahui2.','
			.'isaac@miracle-clinic.com, 
			hendri@miracle-clinic.com, 
			freddy@miracle-clinic.com, 
			sindarto@miracle-clinic.com,
			natalie@miracle-clinic.com,
			windra@miracle-clinic.com,
			it@miracle-clinic.com';
			
			$email_kirim = $email_mengetahui.','.$email_mengetahui2.','.'isaac@miracle-clinic.com';
			//$this->email->to('isaac@miracle-clinic.com');
			$this->email->to($email_kirim);
			
			$judul_email = 'Permintaan IT dari '.$username;
			$isi_email = 
				'Dear : IT '
				."\n\n".
				'Cabang		: '.$cabang_nama 
				."\n".	
				'Tanggal	: '.$permintaan_tanggalmasalah
				."\n".
				'Prioritas	: '.$permintaan_prioritas
				."\n".
				'Permintaan	: '.$permintaan_permintaan 
				."\n". 
				'Pemohon	: '.$username;
			$this->email->subject($judul_email);
			$this->email->message($isi_email);
			$this->email->send();
			/*
			if (!$this->email->send())
				show_error($this->email->print_debugger());
			else
				echo 'Your e-mail has been sent!'; 
			*/
			// end kirim email
			
			if($this->db->affected_rows())
				return '1';
			else
				return '0';
		}
		
		//fcuntion for delete record
		function gudang_delete($pkid){
			// You could do some checkups here and return '0' or other error consts.
			// Make a single query to delete all of the gudangs at the same time :
			if(sizeof($pkid)<1){
				return '0';
			} else if (sizeof($pkid) == 1){
				$query = "DELETE FROM gudang WHERE gudang_id = ".$pkid[0];
				$this->db->query($query);
			} else {
				$query = "DELETE FROM gudang WHERE ";
				for($i = 0; $i < sizeof($pkid); $i++){
					$query = $query . "gudang_id= ".$pkid[$i];
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
		function permintaan_search($permintaan_nama ,$permintaan_cabang ,$permintaan_tanggalmasalah ,$permintaan_tipe ,$permintaan_judul ,$permintaan_prioritas ,$permintaan_status, $permintaan_tanggalselesai, $start,$end){
			//if($gudang_aktif=="")
			//	$gudang_aktif="Aktif";
			if($permintaan_status=="")
				$permintaan_status="Open";
			//full query
			$username = $_SESSION[SESSION_USERID];
			$sql_id_cust= "SELECT user_karyawan FROM users WHERE user_name ='".$username."'";
			$query_id_cust= $this->db->query($sql_id_cust);
			$data_id_cust= $query_id_cust->row();
			$permintaan_client_id= $data_id_cust->user_karyawan;
			$query="
			SELECT karyawan.karyawan_nama AS nama, 
				cabang.cabang_nama AS cabang, 
				permintaan_it.permintaan_cabang AS cabang_id,
				permintaan_it.permintaan_client AS client,
				permintaan_it.permintaan_id as permintaan_id,
				permintaan_it.permintaan_tanggal_masalah AS tanggal_masalah,
				permintaan_it.permintaan_type AS tipe, 
				permintaan_it.permintaan_judul AS judul, 
				permintaan_it.permintaan_masalah AS masalah,
				permintaan_it.permintaan_prioritas AS prioritas,
				permintaan_it.permintaan_penyelesaian AS penyelesaian, 
				permintaan_it.permintaan_tanggal_selesai AS tanggal_selesai, 
				permintaan_it.permintaan_status AS status
			FROM permintaan_it
				LEFT JOIN karyawan ON permintaan_it.permintaan_client = karyawan.karyawan_id
				LEFT JOIN cabang ON permintaan_it.permintaan_cabang = cabang.cabang_id";
			
			if($permintaan_nama!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " karyawan.karyawan_nama LIKE '%".$permintaan_nama."%'";
			};
			if($permintaan_cabang!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " cabang.cabang_nama LIKE '%".$permintaan_cabang."%'";
			};
			if($permintaan_tanggalmasalah!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " permintaan_it.permintaan_tanggal_masalah LIKE '%".$permintaan_tanggalmasalah."%'";
			};
			if($permintaan_tipe!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " permintaan_it.permintaan_type LIKE '%".$permintaan_tipe."%'";
			};
			if($permintaan_judul!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " permintaan_it.permintaan_judul LIKE '%".$permintaan_judul."%'";
			};
			if($permintaan_prioritas!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " permintaan_it.permintaan_prioritas LIKE '%".$permintaan_prioritas."%'";
			};
			if($permintaan_status!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " permintaan_it.permintaan_status LIKE '%".$permintaan_status."%'";
			};
			if($permintaan_tanggalselesai!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " permintaan_it.permintaan_tanggal_selesai LIKE '%".$permintaan_tanggalselesai."%'";
			};

			if ($permintaan_client_id<>"2" && $permintaan_client_id<>"11" && $permintaan_client_id<>"66" && $permintaan_client_id<>"79"){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (permintaan_it.permintaan_client ='".$permintaan_client_id."')";
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
		
		//function for print record
		function gudang_print($gudang_id ,$gudang_nama ,$gudang_lokasi ,$gudang_keterangan ,$gudang_aktif ,$gudang_creator ,$gudang_date_create ,$gudang_update ,$gudang_date_update ,$gudang_revised ,$option,$filter){
			//full query
			$query="select * from gudang";
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (gudang_id LIKE '%".addslashes($filter)."%' OR gudang_nama LIKE '%".addslashes($filter)."%' OR gudang_lokasi LIKE '%".addslashes($filter)."%' OR gudang_keterangan LIKE '%".addslashes($filter)."%' OR gudang_aktif LIKE '%".addslashes($filter)."%' OR gudang_creator LIKE '%".addslashes($filter)."%' OR gudang_date_create LIKE '%".addslashes($filter)."%' OR gudang_update LIKE '%".addslashes($filter)."%' OR gudang_date_update LIKE '%".addslashes($filter)."%' OR gudang_revised LIKE '%".addslashes($filter)."%' )";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($gudang_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_id LIKE '%".$gudang_id."%'";
				};
				if($gudang_nama!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_nama LIKE '%".$gudang_nama."%'";
				};
				if($gudang_lokasi!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_lokasi LIKE '%".$gudang_lokasi."%'";
				};
				if($gudang_keterangan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_keterangan LIKE '%".$gudang_keterangan."%'";
				};
				if($gudang_aktif!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_aktif LIKE '%".$gudang_aktif."%'";
				};
				if($gudang_creator!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_creator LIKE '%".$gudang_creator."%'";
				};
				if($gudang_date_create!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_date_create LIKE '%".$gudang_date_create."%'";
				};
				if($gudang_update!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_update LIKE '%".$gudang_update."%'";
				};
				if($gudang_date_update!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_date_update LIKE '%".$gudang_date_update."%'";
				};
				if($gudang_revised!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_revised LIKE '%".$gudang_revised."%'";
				};
				$result = $this->db->query($query);
			}
			return $result;
		}
		
		//function  for export to excel
		function gudang_export_excel($gudang_id ,$gudang_nama ,$gudang_lokasi ,$gudang_keterangan ,$gudang_aktif ,$gudang_creator ,$gudang_date_create ,$gudang_update ,$gudang_date_update ,$gudang_revised ,$option,$filter){
			//full query
			$query="select 	gudang_nama AS nama,
							gudang_lokasi AS lokasi,
							gudang_keterangan AS keterangan,
							gudang_aktif AS aktif

					from gudang";
					
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (gudang_id LIKE '%".addslashes($filter)."%' OR gudang_nama LIKE '%".addslashes($filter)."%' OR gudang_lokasi LIKE '%".addslashes($filter)."%' OR gudang_keterangan LIKE '%".addslashes($filter)."%' OR gudang_aktif LIKE '%".addslashes($filter)."%' OR gudang_creator LIKE '%".addslashes($filter)."%' OR gudang_date_create LIKE '%".addslashes($filter)."%' OR gudang_update LIKE '%".addslashes($filter)."%' OR gudang_date_update LIKE '%".addslashes($filter)."%' OR gudang_revised LIKE '%".addslashes($filter)."%' )";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($gudang_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_id LIKE '%".$gudang_id."%'";
				};
				if($gudang_nama!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_nama LIKE '%".$gudang_nama."%'";
				};
				if($gudang_lokasi!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_lokasi LIKE '%".$gudang_lokasi."%'";
				};
				if($gudang_keterangan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_keterangan LIKE '%".$gudang_keterangan."%'";
				};
				if($gudang_aktif!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_aktif LIKE '%".$gudang_aktif."%'";
				};
				if($gudang_creator!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_creator LIKE '%".$gudang_creator."%'";
				};
				if($gudang_date_create!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_date_create LIKE '%".$gudang_date_create."%'";
				};
				if($gudang_update!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_update LIKE '%".$gudang_update."%'";
				};
				if($gudang_date_update!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_date_update LIKE '%".$gudang_date_update."%'";
				};
				if($gudang_revised!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " gudang_revised LIKE '%".$gudang_revised."%'";
				};
				$result = $this->db->query($query);
			}
			return $result;
		}
		

}
?>