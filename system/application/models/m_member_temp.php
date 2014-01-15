<? /* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
    #songbee	mukhlisona@gmail.com
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: member_temp Model
	+ Description	: For record model process back-end
	+ Filename 		: c_member_temp.php
 	+ creator 		: 
 	+ Created on 22/Apr/2010 10:01:41
	
*/

class M_member_temp extends Model{
		
		//constructor
		function M_member_temp() {
			parent::Model();
		}
		
		function get_info(){
			$sql="
				select cabang.cabang_kota from info 
				left join cabang on info.info_cabang = cabang.cabang_id";
			$query = $this->db->query($sql);
			return $query->row();
		}
		
		//function for get list record
		function member_temp_list($filter,$start,$end){
			//$date_minus_one=date('Y-m-d',mktime(0,0,0,date("m"),date("d")-1,date("Y")));
			$date_now=date('Y-m-d');
			$this->db->where('membert_register <', $date_now);
			$this->db->delete('member_temp');
			
			$query =   "SELECT membert_id, membert_cust, cust_no, cust_nama, membert_no, membert_register, membert_valid, membert_jenis, membert_status, membert_check_daftar,
						member_valid
						FROM member_temp 
						LEFT JOIN vu_customer ON (membert_cust=cust_id) 
						WHERE member_valid <= date_format(DATE_ADD(now(), INTERVAL 3 month), '%Y-%m-%d') or membert_jenis = 'baru' ";			
			
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (cust_no LIKE '%".addslashes($filter)."%' ) OR (cust_nama LIKE '%".addslashes($filter)."%' )";
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
		
		//function for update record
		function member_temp_update($membert_id,$membert_cust,$membert_no,$membert_register,$membert_valid,$membert_jenis,$membert_status, $membert_check_daftar){
			if($membert_check_daftar=='true'){
				$sql="select cabang.cabang_value from info join cabang on cabang.cabang_id=info.info_cabang";
				$rs=$this->db->query($sql);
				if($rs->num_rows()){
					$rs_record=$rs->row_array();
					$cabang_value=$rs_record['cabang_value'];
					if ($cabang_value < 10) {
						$cabang_value = '0'.$cabang_value; 
					}
				}
			
				//* proses didaftarkan ke db.member sebagai member Miracle /
				$dtu_member = array(
					"membert_check_daftar"=>$membert_check_daftar
				);
				$this->db->where('membert_id', $membert_id);
				$this->db->update('member_temp', $dtu_member);
				if($this->db->affected_rows()){
					if($membert_jenis=='baru'){
						//* db.member.member_no TIDAK BERUBAH /
						$sql = "SELECT cust_no FROM customer WHERE cust_id='$membert_cust'";
						$rs=$this->db->query($sql);
						if($rs->num_rows()){
							$rs_record=$rs->row_array();
							//$pattern=date("ymd").substr($rs_record['cust_no'],-6);
							$pattern=date("dmy").substr($rs_record['cust_no'],-6);
							$pattern2=$cabang_value.substr($rs_record['cust_no'],-6);
							$member_no=$this->m_public_function->get_nomor_member('member','member_no',$pattern,$pattern2,16,14);
							//$member_no = $rs_record['member_no'];
						}
					}else if($membert_jenis=='perpanjangan'){
						$member_no=str_replace('-', '', $membert_no);
					}
					//* INSERT to db.member untuk diproses menjadi member Miracle /
					/*$sql="SELECT membert_cust, membert_register, membert_valid, membert_jenis, membert_status FROM member_temp WHERE member_temp.membert_id='$membert_id'";
					$rs=$this->db->query($sql);
					$record=$rs->row_array();
					
					$dti_member=array(
					"member_cust"=>$record['membert_cust'],
					"member_no"=>$member_no,
					"member_register"=>$record['membert_register'],
					"member_valid"=>$record['membert_valid'],
					"member_jenis"=>$record['membert_jenis'],
					"member_status"=>$record['membert_status']
					);
					$this->db->insert('member', $dti_member);*/
					$dti_member=array(
					"member_cust"=>$membert_cust,
					"member_no"=>$member_no,
					"member_register"=>$membert_register,
					"member_valid"=>$membert_valid,
					"member_jenis"=>$membert_jenis,
					"member_status"=>$membert_status,
					"member_membert"=>$membert_id,
					"member_creator"=>@$_SESSION[SESSION_USERID]
					);
					$this->db->insert('member', $dti_member);
					if($this->db->affected_rows()){
						//* UPDATE db.customer.cust_member dari db.member.member_id /
						$this->cust_member_update($membert_cust);
					}
				}
			}else{
				//* proses pembatalan member di db.member /
				$dtu_member = array(
					"membert_check_daftar"=>$membert_check_daftar
				);
				$this->db->where('membert_id', $membert_id);
				$this->db->update('member_temp', $dtu_member);
				if($this->db->affected_rows()){
					$this->db->where('member_membert', $membert_id);
					$this->db->delete('member');
					if($this->db->affected_rows()){
						//* UPDATE db.customer.cust_member ke cust_member sebelumnya /
						$this->cust_member_update($membert_cust);
					}
				}
			}
			return '1';
		}
		
		function cust_member_update($cust_id){
			$date_now = date('Y-m-d');
			$sql = "SELECT max(member_id) AS member_id FROM member WHERE member_cust='$cust_id' AND member_valid>'$date_now'";
			$rs=$this->db->query($sql);
			if($rs->num_rows()){
				$record = $rs->row_array();
				$dtu_customer=array(
				"cust_member"=>$record['member_id']
				);
				$this->db->where('cust_id', $cust_id);
				$this->db->update('customer', $dtu_customer);
			}else{
				$dtu_customer=array(
				"cust_member"=>0
				);
				$this->db->where('cust_id', $cust_id);
				$this->db->update('customer', $dtu_customer);
			}
		}
		
		//fcuntion for delete record
		function member_temp_delete($pkid){
			// You could do some checkups here and return '0' or other error consts.
			// Make a single query to delete all of the member_temps at the same time :
			if(sizeof($pkid)<1){
				return '0';
			} else if (sizeof($pkid) == 1){
				$query = "DELETE FROM member_temp WHERE membert_id = ".$pkid[0];
				$this->db->query($query);
			} else {
				$query = "DELETE FROM member_temp WHERE ";
				for($i = 0; $i < sizeof($pkid); $i++){
					$query = $query . "membert_id= ".$pkid[$i];
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
		function member_temp_search($membert_id ,$membert_cust ,$membert_no ,$membert_register ,$membert_valid ,$membert_jenis ,$membert_status ,$start,$end){
			//full query
			$query="select * from member_temp";
			
			if($membert_id!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " membert_id LIKE '%".$membert_id."%'";
			};
			if($membert_cust!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " membert_cust LIKE '%".$membert_cust."%'";
			};
			if($membert_no!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " membert_no LIKE '%".$membert_no."%'";
			};
			if($membert_register!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " membert_register LIKE '%".$membert_register."%'";
			};
			if($membert_valid!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " membert_valid LIKE '%".$membert_valid."%'";
			};
			if($membert_jenis!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " membert_jenis LIKE '%".$membert_jenis."%'";
			};
			if($membert_status!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " membert_status LIKE '%".$membert_status."%'";
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
		function member_temp_print($membert_id ,$membert_cust ,$membert_no ,$membert_register ,$membert_valid ,$membert_jenis ,$membert_status ,$option,$filter){
			//full query
			$sql="select * from member_temp";
			if($option=='LIST'){
				$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
				$sql .= " (membert_id LIKE '%".addslashes($filter)."%' OR membert_cust LIKE '%".addslashes($filter)."%' OR membert_no LIKE '%".addslashes($filter)."%' OR membert_register LIKE '%".addslashes($filter)."%' OR membert_valid LIKE '%".addslashes($filter)."%' OR membert_jenis LIKE '%".addslashes($filter)."%' OR membert_status LIKE '%".addslashes($filter)."%' )";
				$query = $this->db->query($sql);
			} else if($option=='SEARCH'){
				if($membert_id!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " membert_id LIKE '%".$membert_id."%'";
				};
				if($membert_cust!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " membert_cust LIKE '%".$membert_cust."%'";
				};
				if($membert_no!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " membert_no LIKE '%".$membert_no."%'";
				};
				if($membert_register!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " membert_register LIKE '%".$membert_register."%'";
				};
				if($membert_valid!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " membert_valid LIKE '%".$membert_valid."%'";
				};
				if($membert_jenis!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " membert_jenis LIKE '%".$membert_jenis."%'";
				};
				if($membert_status!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " membert_status LIKE '%".$membert_status."%'";
				};
				$query = $this->db->query($sql);
			}
			return $query->result();
		}
		
		//function for print record
		function member_temp_print_member($membert_cust){
			//full query
			$sql="select 
					cust_nama,
					cust_no,
					cust_alamat,
					cust_kota,
					cust_telprumah,
					cust_telprumah2,
					cust_telpkantor,
					cust_hp,
					cust_hp2,
					cust_hp3
				from member_temp 
				left join customer on (customer.cust_id = member_temp.membert_cust) where membert_cust='$membert_cust'";
			$query = $this->db->query($sql);
			return $query->result();
		}
		
		//function  for export to excel
		function member_temp_export_excel($membert_id ,$membert_cust ,$membert_no ,$membert_register ,$membert_valid ,$membert_jenis ,$membert_status ,$option,$filter){
			//full query
			$sql="select * from member_temp";
			if($option=='LIST'){
				$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
				$sql .= " (membert_id LIKE '%".addslashes($filter)."%' OR membert_cust LIKE '%".addslashes($filter)."%' OR membert_no LIKE '%".addslashes($filter)."%' OR membert_register LIKE '%".addslashes($filter)."%' OR membert_valid LIKE '%".addslashes($filter)."%' OR membert_jenis LIKE '%".addslashes($filter)."%' OR membert_status LIKE '%".addslashes($filter)."%' )";
				$query = $this->db->query($sql);
			} else if($option=='SEARCH'){
				if($membert_id!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " membert_id LIKE '%".$membert_id."%'";
				};
				if($membert_cust!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " membert_cust LIKE '%".$membert_cust."%'";
				};
				if($membert_no!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " membert_no LIKE '%".$membert_no."%'";
				};
				if($membert_register!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " membert_register LIKE '%".$membert_register."%'";
				};
				if($membert_valid!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " membert_valid LIKE '%".$membert_valid."%'";
				};
				if($membert_jenis!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " membert_jenis LIKE '%".$membert_jenis."%'";
				};
				if($membert_status!=''){
					$sql.=eregi("WHERE",$sql)?" AND ":" WHERE ";
					$sql.= " membert_status LIKE '%".$membert_status."%'";
				};
				$query = $this->db->query($sql);
			}
			return $query;
		}
		
}
?>