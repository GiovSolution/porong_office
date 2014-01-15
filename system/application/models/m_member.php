<? /* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
    #songbee	mukhlisona@gmail.com
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: member Model
	+ Description	: For record model process back-end
	+ Filename 		: c_member.php
 	+ Author  		: 
 	+ Created on 01/Sep/2009 10:36:44
	
*/

class M_member extends Model{
		
		//constructor
		function M_member() {
			parent::Model();
		}
		
		function member_cetak(){
		
			$query = "SELECT member.*,cust_nama as cust_nama, cust_no as cust_no FROM member,customer where member_cust=cust_id and member_status='Daftar' ORDER BY member_jenis";
			$row=$this->db->query($query);
			
			//$query = "UPDATE member set member_status='print' where member_status='register'";
			//$query = "UPDATE member set member_status='Cetak', member_tglserahterima=NULL where member_status='Daftar'";
			$date_now=date('Y-m-d');
			$query =   "UPDATE member set 
							member_status='Cetak', 
							member_tglcetak='$date_now'
						where member_status='Daftar'"; // by hendri, 2010-09-21, utk mencatat tanggal Cetak 
			$this->db->query($query);
			//$query = "SELECT member.*,cust_nama as member_nama FROM member,customer where member_cust=cust_id and member_status='print'";
			
			return $row->result();
		}
		
		function member_aktivasi($member_id){
			$date_now=date('Y-m-d');
			//$query = "UPDATE member set member_status='aktif' where member_status='print'";
			$query = "UPDATE member set member_status='Serah Terima', member_tglserahterima='$date_now' WHERE member_status='Cetak' AND member_id='$member_id'";
			$this->db->query($query);
			return '1';
		}
		
		//function for get list record
		function member_list($filter,$start,$end){
			/*$query =   "SELECT 
							m.*,
							c.cust_nama, c.cust_no 
						FROM member m
						LEFT JOIN customer c on c.cust_id = m.member_cust";*/ // query lama
			
			$query =  "SELECT m.member_id, m.member_cust,
							case when length(m.member_no)=14 then concat(substr(m.member_no,1,2),'-',substr(m.member_no,3,6),'-',substr(m.member_no,9)) else concat(substr(m.member_no,1,6),'-',substr(m.member_no,7,6),'-',substr(m.member_no,13)) end as member_no,
							m.member_register, m.member_valid, m.member_nota_ref, m.member_point, m.member_jenis, m.member_status, m.member_tglcetak, m.member_creator, m.member_date_create, m.member_update, m.member_date_update, m.member_revised,
							c.cust_nama, 
							c.cust_no 
						FROM customer c
						RIGHT JOIN member m on c.cust_member = m.member_id
						WHERE m.member_cust <> '0'";
			
			
			// For simple search
			if ($filter<>""){
				$query.=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query.= " (cust_nama LIKE '%".addslashes($filter)."%' OR cust_no LIKE '%".addslashes($filter)."%' OR member_no LIKE '%".addslashes($filter)."%')";
			} 
			
			$query.=" ORDER BY member_register DESC";
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
		function member_update($member_id ,$member_no , $member_status){
			$date_now=date('Y-m-d');
			$data = array(
				//"member_id"=>$member_id, 
			//	"member_cust"=>$member_cust, 
				"member_no"=>$member_no, 
				//"member_register"=>$member_register, 
				//"member_valid"=>$member_valid, 
				//"member_nota_ref"=>$member_nota_ref, 
				//"member_point"=>$member_point, 
				//"member_jenis"=>$member_jenis, 
				"member_status"=>$member_status, 
				//"member_tglserahterima"=>$member_tglserahterima 
			);
			
			/*if($member_status=='Serah Terima'){
				$data['member_tglserahterima']=$date_now;
			}else{
				$data['member_tglserahterima']=NULL;
			}*/
			
			$this->db->where('member_id', $member_id);
			$this->db->update('member', $data);
			
			return '1';
		}
		
		//function for create new record
		function member_create($member_cust ,$member_no ,$member_register ,$member_valid ,$member_nota_ref ,$member_point ,$member_jenis ,$member_status ,$member_tglserahterima ){
			$data = array(
				"member_cust"=>$member_cust, 
				"member_no"=>$member_no, 
				"member_register"=>$member_register, 
				"member_valid"=>$member_valid, 
				"member_nota_ref"=>$member_nota_ref, 
				"member_point"=>$member_point, 
				"member_jenis"=>$member_jenis, 
				"member_status"=>$member_status, 
				"member_tglserahterima"=>$member_tglserahterima 
			);
			$this->db->insert('member', $data); 
			if($this->db->affected_rows())
				return '1';
			else
				return '0';
		}
		
		//Adding Member Tanpa-Transaksi
		function member_add($member_cust ){
			$date_now=date('Y-m-d');
			
			$sql="SELECT setmember_transhari, setmember_periodeaktif, setmember_periodetenggang, setmember_transtenggang FROM member_setup LIMIT 1";
			$rs=$this->db->query($sql);
			if($rs->num_rows()){
				$rs_record=$rs->row_array();
				$min_trans_member_baru=$rs_record['setmember_transhari'];
				$periode_tenggang=$rs_record['setmember_periodetenggang'];
				$min_trans_tenggang=$rs_record['setmember_transtenggang'];
				$periode_aktif=$rs_record['setmember_periodeaktif'];
			}
			
			$sql="select cabang.cabang_value from info join cabang on cabang.cabang_id=info.info_cabang";
			$rs=$this->db->query($sql);
			if($rs->num_rows()){
				$rs_record=$rs->row_array();
				$cabang_value=$rs_record['cabang_value'];
				if ($cabang_value < 10) {
					$cabang_value = '0'.$cabang_value; 
				}
			}
			
			$sql = "SELECT cust_no FROM customer WHERE cust_id='$member_cust'";
			$rs=$this->db->query($sql);
			if($rs->num_rows()){
				$rs_record=$rs->row_array();
				$pattern=date("ymd").substr($rs_record['cust_no'],-6);
				$pattern2=$cabang_value.substr($rs_record['cust_no'],-6);
				$member_no=$this->m_public_function->get_nomor_member('member','member_no',$pattern,$pattern2,16,14);
			}
			
			$member_valid = date('Y-m-d', strtotime("$date_now +$periode_aktif days"));
			$data = array(
				"member_cust"=>$member_cust, 
				"member_no"=>$member_no, 
				"member_register"=>$date_now, 
				"member_valid"=>$member_valid, 
				"member_jenis"=>'baru', 
				"member_status"=>'Daftar', 
				"member_tglserahterima"=>NULL,
				"member_creator"=>@$_SESSION[SESSION_USERID]
			);
			$this->db->insert('member', $data); 
			if($this->db->affected_rows())
				return '1';
			else
				return '0';
		}
		
		//fcuntion for delete record
		function member_delete($pkid){
			// You could do some checkups here and return '0' or other error consts.
			// Make a single query to delete all of the members at the same time :
			if(sizeof($pkid)<1){
				return '0';
			} else if (sizeof($pkid) == 1){
				$query = "DELETE FROM member WHERE member_id = ".$pkid[0];
				$this->db->query($query);
			} else {
				$query = "DELETE FROM member WHERE ";
				for($i = 0; $i < sizeof($pkid); $i++){
					$query = $query . "member_id= ".$pkid[$i];
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
		function member_search($member_id ,$member_cust ,$member_no ,$member_register, $member_register_end, $member_valid, $member_valid_end, $member_point ,$member_jenis ,$member_status, $member_tglcetak, $member_tglcetak_end, /*$member_tglserahterima, $member_tglserahterima_end,*/ $start,$end){
			//full query
			$query = "SELECT m.member_id, m.member_cust,
							case when length(m.member_no)=14 then concat(substr(m.member_no,1,2),'-',substr(m.member_no,3,6),'-',substr(m.member_no,9)) else concat(substr(m.member_no,1,6),'-',substr(m.member_no,7,6),'-',substr(m.member_no,13)) end as member_no,
							m.member_register, m.member_valid, m.member_nota_ref, m.member_point, m.member_jenis, m.member_status, m.member_tglcetak, m.member_creator, m.member_date_create, m.member_update, m.member_date_update, m.member_revised,
						c.cust_nama,
						c.cust_no 
					FROM customer c
					RIGHT JOIN member m on c.cust_member = m.member_id ";					
			
			if($member_cust!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " m.member_cust = ".$member_cust;
			};
			if($member_no!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " member_no LIKE '%".$member_no."%'";
			};
			if($member_register!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " member_register >= '".$member_register."'";
			};
			if($member_register_end!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " member_register <= '".$member_register_end."'";
			};
			if($member_valid!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " member_valid >= '".$member_valid."'";
			};
			if($member_valid_end!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " member_valid <= '".$member_valid_end."'";
			};
			if($member_jenis!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " member_jenis = '".$member_jenis."'";
			};
			if($member_status!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " member_status = '".$member_status."'";
			};
			if($member_tglcetak!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " member_tglcetak >= '".$member_tglcetak."'";
			};
			if($member_tglcetak_end!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " member_tglcetak <= '".$member_tglcetak_end."'";
			};
/*			if($member_tglserahterima!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " member_tglserahterima >= '".$member_tglserahterima."'";
			};
			if($member_tglserahterima_end!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " member_tglserahterima <= '".$member_tglserahterima_end."'";
			};
*/			
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
		function member_print($member_id
							  ,$member_cust
							  ,$member_no
							  ,$member_register
							  ,$member_register_end
							  ,$member_valid
							  ,$member_valid_end
							  ,$member_nota_ref
							  ,$member_point
							  ,$member_jenis
							  ,$member_status
							  ,$member_tglcetak
							  ,$member_tglcetak_end
							  , /*$member_tglserahterima,*/ $option
							  ,$filter){
			//full query
			//$query="select * from member";
			$date_now=date('Y-m-d');
			$query = "SELECT cust_no
					,cust_nama
					,member_id
					,member_cust
					,case when length(member_no)=14 then concat(substr(member_no,1,2),'-',substr(member_no,3,6),'-',substr(member_no,9)) else concat(substr(member_no,1,6),'-',substr(member_no,7,6),'-',substr(member_no,13)) end as member_no
					,INSERT(INSERT(member_no,7,0,'-'),14,0,'-') AS no_member
					,member_register
					,member_valid
					,member_jenis
					,member_status
					,member_tglcetak
				FROM member
				LEFT JOIN customer on customer.cust_id = member.member_cust";
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (cust_nama LIKE '%".addslashes($filter)."%' OR cust_no LIKE '%".addslashes($filter)."%' OR member_no LIKE '%".addslashes($filter)."%')";
				//$query .= " ORDER BY member_jenis";
				//$result = $this->db->query($query);
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($member_cust!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " member.member_cust = ".$member_cust;
				};
				if($member_no!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " member_no LIKE '%".$member_no."%'";
				};
				if($member_register!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " member_register >= '".$member_register."'";
				};
				if($member_register_end!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " member_register <= '".$member_register_end."'";
				};
				if($member_valid!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " member_valid >= '".$member_valid."'";
				};
				if($member_valid_end!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " member_valid <= '".$member_valid_end."'";
				};
				if($member_jenis!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " member_jenis = '".$member_jenis."'";
				};
				if($member_status!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " member_status = '".$member_status."'";
				};
				if($member_tglcetak!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " member_tglcetak >= '".$member_tglcetak."'";
				};
				if($member_tglcetak_end!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " member_tglcetak <= '".$member_tglcetak_end."'";
				};
/*				if($member_tglserahterima!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " member_tglserahterima LIKE '%".$member_tglserahterima."%'";
				};
*/				//$query .= " ORDER BY member_jenis";
				//$result = $this->db->query($query);
				$result = $this->db->query($query);
			}
				
				$rs = $this->db->query($query);
				$jum_baris = $rs->num_rows();
				
				//looping dimulai disini
				for ($i = 0; $i < $jum_baris; $i++) {
					$record = $rs->row($i);
					$data_arr= $record->member_no;				
				
					$query2 = "UPDATE member SET member_status = 'Cetak', member_tglcetak='$date_now' WHERE (case when length(member_no)=14 then concat(substr(member_no,1,2),'-',substr(member_no,3,6),'-',substr(member_no,9)) else concat(substr(member_no,1,6),'-',substr(member_no,7,6),'-',substr(member_no,13)) end) = '$data_arr' AND member_status = 'Daftar'";
					$rs2 = $this->db->query($query2);
				}
				
				
				return $result->result();
		}
		
		//function  for export to excel
		function member_export_excel($member_id
									 ,$member_cust
									 ,$member_no
									 ,$member_register
									 ,$member_register_end
									 ,$member_valid
									 ,$member_valid_end
									 ,$member_nota_ref
									 ,$member_point
									 ,$member_jenis
									 ,$member_status
									 ,$member_tglcetak
									 ,$member_tglcetak_end
									 ,/*$member_tglserahterima ,*/ $option
									 ,$filter){
			$date_now=date('Y-m-d');
			$query = "SELECT cust_no AS no_cust
					,cust_nama AS customer
					,case when length(member_no)=14 then concat(substr(member_no,1,2),'-',substr(member_no,3,6),'-',substr(member_no,9)) else concat(substr(member_no,1,6),'-',substr(member_no,7,6),'-',substr(member_no,13)) end as member_no
					/*,INSERT(INSERT(member_no,7,0,'-'),14,0,'-') AS no_member*/
					,member_register AS tgl_daftar
					,member_valid AS tgl_valid
					,member_jenis AS jenis
					,member_status AS status
					,member_tglcetak AS tgl_cetak
				FROM member m
				LEFT JOIN customer c on c.cust_id = m.member_cust";
			
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (member_status = 'Daftar' OR member_status = 'Cetak') AND (cust_nama LIKE '%".addslashes($filter)."%' OR cust_no LIKE '%".addslashes($filter)."%' OR member_no LIKE '%".addslashes($filter)."%')";
				//$result = $this->db->query($query);
			}else if($option=='SEARCH'){
				if($member_cust!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " m.member_cust = ".$member_cust;
				};
				if($member_no!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " member_no LIKE '%".$member_no."%'";
				};
				if($member_register!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " member_register >= '".$member_register."'";
				};
				if($member_register_end!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " member_register <= '".$member_register_end."'";
				};
				if($member_valid!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " member_valid >= '".$member_valid."'";
				};
				if($member_valid_end!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " member_valid <= '".$member_valid_end."'";
				};
				if($member_jenis!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " member_jenis = '".$member_jenis."'";
				};
				if($member_status!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " member_status = '".$member_status."'";
				};
				if($member_tglcetak!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " member_tglcetak >= '".$member_tglcetak."'";
				};
				if($member_tglcetak_end!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " member_tglcetak <= '".$member_tglcetak_end."'";
				};
				
/*				if($member_tglserahterima!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " member_tglserahterima LIKE '%".$member_tglserahterima."%'";
				};
*/				//$result = $this->db->query($query);
			}
				
				
				$result = $this->db->query($query);
				
				$rs = $this->db->query($query);
				$jum_baris = $rs->num_rows();
				
				//looping dimulai disini
				for ($i = 0; $i < $jum_baris; $i++) {
					$record = $rs->row($i);
					$data_arr= $record->member_no;				
				
					$query2 = "UPDATE member SET member_status = 'Cetak', member_tglcetak='$date_now' WHERE (case when length(member_no)=14 then concat(substr(member_no,1,2),'-',substr(member_no,3,6),'-',substr(member_no,9)) else concat(substr(member_no,1,6),'-',substr(member_no,7,6),'-',substr(member_no,13)) end) = '$data_arr'  AND member_status = 'Daftar'";
					$rs2 = $this->db->query($query2);
				}
				return $result;
}
}
?>