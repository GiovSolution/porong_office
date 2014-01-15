<? /* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
    #songbee	mukhlisona@gmail.com
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: phonegroup Model
	+ Description	: For record model process back-end
	+ Filename 		: c_phonegroup.php
 	+ Author  		: 
 	+ Created on 01/Feb/2010 14:30:05
	
*/

class M_phonegroup extends Model{
		
		//constructor
		function M_phonegroup() {
			parent::Model();
		}
		
		function sms_save($isms_dest,$isms_isi,$isms_opsi,$isms_task, $isms_jnsklm, $isms_ultah, $isms_crm){
			$sql="";
			/*if($isms_task=='draft'){
				$sql="insert into draft(
						draft_jenis,
						draft_destination,
						draft_message,
						draft_date,
						draft_creator,
						draft_date_create)
					 values(
						'".$isms_opsi."',
						'".$isms_dest."',
						'".$isms_isi."',
						'".date('Y/m/d H:i:s')."',
						'".$_SESSION[SESSION_USERID]."',
						'".date('Y/m/d H:i:s')."')";
				$this->db->query($sql);
				//echo $sql;
			}	*/	
			//yg disimpan cukup message & tanggalnya aja. by hendri 2010-06-16
			if($isms_task=='draft'){
				$sql="insert into draft(
						draft_message,
						draft_date,
						draft_creator,
						draft_date_create)
					 values(
						'".$isms_isi."',
						'".date('Y/m/d H:i:s')."',
						'".$_SESSION[SESSION_USERID]."',
						'".date('Y/m/d H:i:s')."')";
				$this->db->query($sql);
				//echo $sql;
			}
			else{
				if($isms_opsi=="semua"){
					$sql="select cust_id, cust_hp from customer WHERE cust_aktif='Aktif' and CONVERT(cust_hp, SIGNED INTEGER)>0";
					$query=$this->db->query($sql);
					foreach($query->result() as $row){
						$sql="insert into outbox(
								outbox_cust,
								outbox_destination,
								outbox_message,
								outbox_date,
								outbox_status,
								outbox_creator,
								outbox_date_create,
								DestinationNumber,
								TextDecoded,
								CreatorID)
							values(
								'".$row->cust_id."',
								'".$row->cust_hp."',
								'".$isms_isi."',
								'".date('Y/m/d H:i:s')."',
								'unsent',
								'".$_SESSION[SESSION_USERID]."',
								'".date('Y/m/d H:i:s')."',
								'".$row->cust_hp."',
								'".$isms_isi."',
								'Program')";
							//echo $sql;
						$this->db->query($sql);
						$sql="";
					}
				}elseif($isms_opsi=="number"){
					$dest=split(",",$isms_dest);
					foreach($dest as $listdest=>$value){
						$sql="insert into outbox(
								outbox_destination,
								outbox_message,
								outbox_date,
								outbox_status,
								outbox_creator,
								outbox_date_create,
								DestinationNumber,
								TextDecoded,
								CreatorID)
							values(
								'".$value."',
								'".$isms_isi."',
								'".date('Y/m/d H:i:s')."',
								'unsent',
								'".$_SESSION[SESSION_USERID]."',
								'".date('Y/m/d H:i:s')."',
								'".$value."',
								'".$isms_isi."',
								'Program')";
						$this->db->query($sql);
						$sql="";
					}
				}elseif($isms_opsi=="group"){
					$sql="SELECT cust_hp,cust_id from customer WHERE cust_aktif='Aktif' and cust_id IN(
						  		SELECT phonegrouped_cust FROM phonegrouped 
								    WHERE phonegrouped_group='".$isms_dest."')
						 		AND CONVERT(cust_hp, SIGNED INTEGER)>0";
					$query=$this->db->query($sql);
					foreach($query->result() as $row){
						$sql_sms="insert into outbox(
								outbox_destination,
								outbox_cust,
								outbox_message,
								outbox_date,
								outbox_status,
								outbox_creator,
								outbox_date_create,
								DestinationNumber,
								TextDecoded,
								CreatorID)
							values(
								'".$row->cust_hp."',
								'".$row->cust_id."',
								'".$isms_isi."',
								'".date('Y/m/d H:i:s')."',
								'unsent',
								'".$_SESSION[SESSION_USERID]."',
								'".date('Y/m/d H:i:s')."',
								'".$row->cust_hp."',
								'".$isms_isi."',
								'Program'
								)";
							//echo $sql;
						$this->db->query($sql_sms);
					}
				}elseif($isms_opsi=="cust"){ //dikirim per customer
					$sql="SELECT cust_hp,cust_id from customer WHERE cust_id = '".$isms_dest."'
						 		AND CONVERT(cust_hp, SIGNED INTEGER)>0";
					$query=$this->db->query($sql);
					if($query->num_rows()){
						$data=$query->row();
						$cust_id=$data->cust_id;
						$cust_hp=$data->cust_hp;
					}else{
						return '2'; //jika customer tidak memiliki no HP
					}
					
						$sql_sms="insert into outbox(
								outbox_destination,
								outbox_cust,
								outbox_message,
								outbox_date,
								outbox_status,
								outbox_creator,
								outbox_date_create,
								DestinationNumber,
								TextDecoded,
								CreatorID)
							values(
								'".$cust_hp."',
								'".$cust_id."',
								'".$isms_isi."',
								'".date('Y/m/d H:i:s')."',
								'unsent',
								'".$_SESSION[SESSION_USERID]."',
								'".date('Y/m/d H:i:s')."',
								'".$cust_hp."',
								'".$isms_isi."',
								'Program'
								)";
							//echo $sql;
						$this->db->query($sql_sms);
				}
/*				elseif($isms_opsi=='kelamin'){
					$sql="select cust_hp from customer where cust_kelamin='".$isms_dest."' AND cust_hp<>'' AND cust_hp is not null";
					$query=$this->db->query($sql);
					foreach($query->result() as $row){
						$sql="insert into outbox(
								outbox_destination,
								outbox_message,
								outbox_date,
								outbox_status,
								outbox_creator,
								outbox_date_create)
							values(
								'".$row->cust_hp."',
								'".$isms_isi."',
								'".date('Y/m/d H:i:s')."',
								'unsent',
								'".$_SESSION[SESSION_USERID]."',
								'".date('Y/m/d H:i:s')."')";
							//echo $sql;
						$this->db->query($sql);
						$sql="";
					}
				}

				elseif($isms_opsi=='ultah'){
					$tgl_start=substr($isms_dest,1,5);
					$tgl_end=substr($isms_dest,8,5);
					
					$sql="select cust_hp, cust_id from customer where date_format(cust_tgllahir,'%m-%d') >= '".$tgl_start."' AND 
															 date_format(cust_tgllahir,'%m-%d') <= '".$tgl_end."' AND
															 cust_hp<>'' AND cust_hp is not null" ;
					$query=$this->db->query($sql);
					foreach($query->result() as $row){
						$sql="insert into outbox(
								outbox_cust,
								outbox_destination,
								outbox_message,
								outbox_date,
								outbox_status,
								outbox_creator,
								outbox_date_create)
							values(
								'".$row->cust_id."',
								'".$row->cust_hp."',
								'".$isms_isi."',
								'".date('Y/m/d H:i:s')."',
								'unsent',
								'".$_SESSION[SESSION_USERID]."',
								'".date('Y/m/d H:i:s')."')";
							//echo $sql;
						$this->db->query($sql);
						$sql="";
					}
				}
*/				
				elseif($isms_opsi=='member'){
					$sms_opsi=split(":",$isms_dest);
					$membership=$sms_opsi[0];
					$expired=$sms_opsi[1];

					//if($expired!=="")
					if($expired!=="x")
					{
						$tgl_start=substr($expired,0,10);
						$tgl_end=substr($expired,13,10);
					}
					
					//$sql="select cust_hp from vu_member_cust WHERE cust_hp<>'' AND cust_hp is not null";
					$sql=  "select cust_hp, cust_id from vu_customer
							WHERE cust_aktif='Aktif' and CONVERT(cust_hp, SIGNED INTEGER)>0";
							
					if($membership=="Expired"){
						$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
						$sql .=" date_format(member_valid,'%Y-%m-%d') >='".$tgl_start."' AND 
								 date_format(member_valid,'%Y-%m-%d') <='".$tgl_end."'";
					}
/*					else if($membership!=="Semua"){
						$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
						$sql .=" member_status='".$membership."'";
					}
*/
					else if($membership=="Aktif"){
						$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
						$sql .=" date_format(member_valid,'%Y-%m-%d') >='".date('Y-m-d')."'";
					}
					else if($membership=="Non Aktif"){
						$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
						$sql .=" date_format(member_valid,'%Y-%m-%d') <'".date('Y-m-d')."'";
					}
					else if($membership=="Non Member"){
						$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
						$sql .=" member_no is NULL ";
					}
					else if($membership=="Semua"){
						$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
						$sql .=" member_no is not NULL ";
					}
					
					if ($isms_jnsklm !== "") {
						$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
						$sql .=" cust_kelamin = '".$isms_jnsklm."'";
					}
					
					if ($isms_crm !== "") {
						$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
						$sql .=" cust_priority = '".$isms_crm."'";
					}
					
					if ($isms_ultah !== "") {
						$tgl_ultah_start=substr($isms_ultah,5,5);
						$tgl_ultah_end=substr($isms_ultah,18,5);
						
						$sql .= eregi("WHERE",$sql)? " AND ":" WHERE ";
						$sql .= " date_format(cust_tgllahir,'%m-%d') BETWEEN '".$tgl_ultah_start."' AND '".$tgl_ultah_end."'";					
					}
				
					$query=$this->db->query($sql);
					foreach($query->result() as $row){
						$sql="insert into outbox(
								outbox_cust,
								outbox_destination,
								outbox_message,
								outbox_date,
								outbox_status,
								outbox_creator,
								outbox_date_create,
								DestinationNumber,
								TextDecoded,
								CreatorID)
							values(
								'".$row->cust_id."',
								'".$row->cust_hp."',
								'".$isms_isi."',
								'".date('Y/m/d H:i:s')."',
								'unsent',
								'".$_SESSION[SESSION_USERID]."',
								'".date('Y/m/d H:i:s')."',
								'".$row->cust_hp."',
								'".$isms_isi."',
								'Program'
								)";
							//echo $sql;
						$this->db->query($sql);
						$sql="";
					}
					
				}

			}		
			return '1';
		}
		
		function get_available($query,$start,$end){

			$sql="SELECT concat(cust_nama,' (',cust_no,')') AS cust_nama, cust_no, cust_hp, cust_id
				  FROM    customer
					  WHERE  cust_id NOT IN (SELECT phonegrouped_cust FROM phonegrouped) 
						  AND CONVERT(cust_hp, SIGNED INTEGER) > 0";
						  
	   
			if($query!==""){
				$sql.=" and cust_nama like '%".$query."%' or cust_hp like '%".$query."%'";
			}
			$result = $this->db->query($sql);
			$nbrows = $result->num_rows();
			$limit = $sql." LIMIT ".$start.",".$end;		
			$result = $this->db->query($limit);  
			
			$this->firephp->log($limit);
			
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
		
		function get_cust_available($umur, $agama, $kota, $propinsi, $pendidikan, $kelamin, $profesi, $hobi, 
									$stsnikah, $priority, $unit, $aktif, $no, $nama, $group_id, $query,$start,$end){
			
			$sql="SELECT concat(cust_nama,' (',cust_no,')') AS cust_nama, cust_no, cust_hp, cust_id
				  FROM    customer";

			if($group_id!=="" && $group_id>0){
				$sql.=" WHERE  cust_id NOT IN (SELECT phonegrouped_cust FROM phonegrouped WHERE phonegrouped_group='".$group_id."')"; 
			}
			
			$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
			$sql.="	CONVERT(cust_hp, SIGNED INTEGER) > 0";
			
						
			if($umur!=""){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.= " cust_umur LIKE '%".$umur."%'";
			}
			
			if($kota!=""){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.= " cust_kota LIKE '%".$kota."%'";
			}
			if($propinsi!=""){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.= " cust_propinsi LIKE '%".$propinsi."%'";
			}
			if($pendidikan!=""){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.= " cust_pendidikan LIKE '%".$pendidikan."%'";
			}
			if($kelamin!=""){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.= " cust_kelamin LIKE '%".$kelamin."%'";
			}
			if($profesi!=""){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.= " cust_profesi LIKE '%".$profesi."%'";
			}
			if($hobi!=""){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.= " cust_hobi LIKE '%".$hobi."%'";
			}
			if($priority!=""){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.= " cust_priority LIKE '%".$priority."%'";
			}
			if($unit!=""){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.= " cust_unit LIKE '%".$unit."%'";
			}
			
			if($aktif!=""){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.= " cust_aktif LIKE '%".$aktif."%'";
			}
			
			if($no!=""){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.= " cust_no LIKE '%".$no."%'";
			}
			
			if($nama!=""){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.= " cust_nama LIKE '%".$nama."%'";
			}
			
			if($query!==""){
				$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
				$sql.=" cust_hp like '%".$query."%'";
			}
			
			
			
			$result = $this->db->query($sql);
			$nbrows = $result->num_rows();
			$limit = $sql." LIMIT ".$start.",".$end;		
			$result = $this->db->query($limit);  
			$this->firephp->log($limit);
			
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
		
		function get_phonegrouped($id,$query,$start,$end){
			
			$sql="SELECT concat(cust_nama,' (',cust_no,')') as cust_nama, cust_no,cust_hp, cust_id FROM customer, phonegrouped
					WHERE cust_id=phonegrouped_cust AND phonegrouped_group='".$id."'";
			if($query!==""){
				$sql.=" AND cust_nama like '%".$query."%' or cust_hp like '%".$query."%'";
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
		
		//function for get list record
		function get_phonegroup_list($filter,$start,$end){
			$query = "SELECT * FROM vu_phonegroup";

			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (phonegroup_nama LIKE '%".addslashes($filter)."%' OR phonegroup_jumlah)";
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
		
		//function for get list record
		function phonegroup_list($filter,$start,$end){
			$query = "SELECT * FROM phonegroup where phonegroup_aktif = 'Aktif'";
			
			// For simple search
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (phonegroup_nama LIKE '%".addslashes($filter)."%' OR 
							 phonegroup_detail LIKE '%".addslashes($filter)."%')";
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
		
		//function for get list record
		function phonegrouped_list($phonegroup_id,$filter,$start,$end){
			$query = "SELECT phonegrouped_cust, cust_nama, cust_no, cust_alamat, cust_kota FROM phonegrouped 
					LEFT JOIN customer ON (phonegrouped_cust = cust_id)
					WHERE phonegrouped_group='".$phonegroup_id."'";
			
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (cust_nama LIKE '%".addslashes($filter)."%' OR 
							 cust_alamat LIKE '%".addslashes($filter)."%' OR 
							 cust_no LIKE '%".addslashes($filter)."%')";
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
		
		//function for create new record
		function phonegroup_create($phonegroup_nama ,$phonegroup_detail , $phonegroup_aktif,$phonegroup_creator ,$phonegroup_date_create, $phonegroup_data ){
			if($phonegroup_aktif == '' || $phonegroup_aktif == 'Aktif'){
				$phonegroup_aktif = 'Aktif';
			}else{
				$phonegroup_aktif = 'Tidak Aktif';
			}
		
			$data = array(
				"phonegroup_nama"=>$phonegroup_nama, 
				"phonegroup_detail"=>$phonegroup_detail, 
				"phonegroup_aktif"=>$phonegroup_aktif,
				"phonegroup_creator"=>$phonegroup_creator, 
				"phonegroup_date_create"=>$phonegroup_date_create 
			);
			$this->db->insert('phonegroup', $data); 
			if($this->db->affected_rows()){
				if($phonegroup_data!=""){
					$phonegrouped_group=$this->db->insert_id();
					$phonegrouped_cust=split(",",$phonegroup_data);
					if(count($phonegrouped_cust)>0){
						$sql="delete from phonegrouped where phonegrouped_group='".$phonegrouped_group."'";
						$this->db->query($sql);
						foreach($phonegrouped_cust as $pnumber=>$value){
							$sql="insert into phonegrouped(phonegrouped_group,phonegrouped_cust)
									values('".$phonegrouped_group."','".$value."')";
							$this->db->query($sql);
							$sql="";
						}
					}
				}
				return '1';
			}else
				return '0';
		}
		
		//function for update record
		function phonegroup_update($phonegroup_id,$phonegroup_nama,$phonegroup_detail, $phonegroup_aktif,$phonegroup_update,$phonegroup_date_update,$phonegroup_data){
			if($phonegroup_aktif == '' || $phonegroup_aktif == 'Aktif'){
				$phonegroup_aktif = 'Aktif';
			}else{
				$phonegroup_aktif = 'Tidak Aktif';
			}
			
			$data = array(
				"phonegroup_nama"=>$phonegroup_nama, 
				"phonegroup_detail"=>$phonegroup_detail, 
				"phonegroup_aktif"=>$phonegroup_aktif,
				"phonegroup_update"=>$phonegroup_update, 
				"phonegroup_date_update"=>$phonegroup_date_update 
			);
			$phonegrouped_group=$phonegroup_id;
			$this->db->where('phonegroup_id', $phonegroup_id);
			$this->db->update('phonegroup', $data);
			$sql="UPDATE phonegroup set phonegroup_revised=(phonegroup_revised+1) where phonegroup_id='".$phonegroup_id."'";
			$this->db->query($sql);
			$sql="delete from phonegrouped where phonegrouped_group='".$phonegrouped_group."'";
			$this->db->query($sql);
				
			if($phonegroup_data!=""){
				$phonegrouped_cust=split(",",$phonegroup_data);
				if(count($phonegrouped_cust)>0){
					foreach($phonegrouped_cust as $pnumber=>$value){
						$sql="insert into phonegrouped(phonegrouped_group,phonegrouped_cust)
								values('".$phonegrouped_group."','".$value."')";
						$this->db->query($sql);
						$sql="";
					}
				}
			}
			return '1';
		}
		
		function get_detail_phonegroup($phonegrouped_group,$start,$end){
			$query = "SELECT phonegrouped_cust
						FROM phonegrouped
						WHERE phonegrouped_group='$phonegrouped_group'
						ORDER BY phonegrouped_cust DESC";
			
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
		
		//fcuntion for delete record
		function phonegroup_delete($pkid){
			// You could do some checkups here and return '0' or other error consts.
			// Make a single query to delete all of the phonegroups at the same time :
			if(sizeof($pkid)<1){
				return '0';
			} else if (sizeof($pkid) == 1){
				$query = "DELETE FROM phonegroup WHERE phonegroup_id = ".$pkid[0];
				$this->db->query($query);
				
				$query2 = "delete from phonegrouped where phonegrouped_group = ".$pkid[0];
				$this->db->query($query2);
			} else {
				$query = "DELETE FROM phonegroup WHERE ";
				for($i = 0; $i < sizeof($pkid); $i++){
					$query = $query . "phonegroup_id= ".$pkid[$i];
					if($i<sizeof($pkid)-1){
						$query = $query . " OR ";
					}     
				}
				$this->db->query($query);
				
				$query2 = "delete from phonegrouped where phonegrouped_group = ".$pkid[0];
				$this->db->query($query2);
			}
			if($this->db->affected_rows()>0)
				return '1';
			else
				return '0';
		}
		
		//fcuntion for delete record
		function detail_phonegroup_delete($pkid){
			// You could do some checkups here and return '0' or other error consts.
			// Make a single query to delete all of the phonegroups at the same time :
			if(sizeof($pkid)<1){
				return '0';
			} else if (sizeof($pkid) == 1){
				$query = "DELETE FROM phonegrouped WHERE phonegrouped_cust = ".$pkid[0];
				$this->db->query($query);
			}
			if($this->db->affected_rows()>0)
				return '1';
			else
				return '0';
		}
		
		//function for advanced search record
		function phonegroup_search($phonegroup_id ,$phonegroup_nama ,$phonegroup_detail , $phonegroup_aktif,$phonegroup_creator ,$phonegroup_date_create ,
								   $phonegroup_update ,$phonegroup_date_update ,$phonegroup_revised ,$start,$end){
			//full query
			$query="select * from phonegroup";
			
			if($phonegroup_nama!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " phonegroup_nama LIKE '%".$phonegroup_nama."%'";
			};
			if($phonegroup_detail!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " phonegroup_detail LIKE '%".$phonegroup_detail."%'";
			};
			if($phonegroup_aktif!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " phonegroup_aktif = '".$phonegroup_aktif."'";
			}else{
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " phonegroup_aktif = 'Aktif'";
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
		function phonegroup_print($phonegroup_id ,$phonegroup_nama ,$phonegroup_detail ,$phonegroup_aktif,$phonegroup_creator ,$phonegroup_date_create ,
								  $phonegroup_update ,$phonegroup_date_update ,$phonegroup_revised ,$option,$filter){
			//full query
			$sql="select * from phonegroup";
			if($option=='LIST'){
				$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
				$sql .= " (phonegroup_nama LIKE '%".addslashes($filter)."%' OR 
						   phonegroup_detail LIKE '%".addslashes($filter)."%' )";
				$query = $this->db->query($sql);
			} else if($option=='SEARCH'){
				
				if($phonegroup_nama!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " phonegroup_nama LIKE '%".$phonegroup_nama."%'";
				};
				if($phonegroup_detail!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " phonegroup_detail LIKE '%".$phonegroup_detail."%'";
				};
				if($phonegroup_aktif!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " phonegroup_aktif = '".$phonegroup_aktif."'";
				}else{
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " phonegroup_aktif = 'Aktif'";
				};		
				
				$query = $this->db->query($sql);
			}
			return $query->result();
		}
		
		//function  for export to excel
		function phonegroup_export_excel($phonegroup_id ,$phonegroup_nama ,$phonegroup_detail ,$phonegroup_aktif, $phonegroup_creator ,$phonegroup_date_create ,
										 $phonegroup_update ,$phonegroup_date_update ,$phonegroup_revised ,$option,$filter){
			//full query
			$sql="select phonegroup_nama as Nama, phonegroup_detail as Keterangan from phonegroup";
			if($option=='LIST'){
				$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
				$sql .= " (phonegroup_nama LIKE '%".addslashes($filter)."%' OR 
						   phonegroup_detail LIKE '%".addslashes($filter)."%' )";
				$query = $this->db->query($sql);
			} else if($option=='SEARCH'){
				
				if($phonegroup_nama!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " phonegroup_nama LIKE '%".$phonegroup_nama."%'";
				};
				if($phonegroup_detail!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " phonegroup_detail LIKE '%".$phonegroup_detail."%'";
				};
				if($phonegroup_aktif!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " phonegroup_aktif = '".$phonegroup_aktif."'";
				}else{
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " phonegroup_aktif = 'Aktif'";
				};		
		
				$query = $this->db->query($sql);
			}
			return $query;
		}
		
}
?>