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

class M_member_exc extends Model{
		
		//constructor
		function M_member_exc() {
			parent::Model();
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
				//$pattern=date("dmy").substr($rs_record['cust_no'],2);
				$pattern=date("dmy").substr($rs_record['cust_no'],-6);
				$pattern2=$cabang_value.substr($rs_record['cust_no'],-6);
				$member_no=$this->m_public_function->get_nomor_member('member','member_no',$pattern,$pattern2,16,14);
			}
			
			$member_valid = date('Y-m-d', strtotime("$date_now +$periode_aktif days"));
			//$sql="SELECT member_id FROM member WHERE member_cust='$member_cust'";
			//* vu_member berisi customer yang berstatus member yang sudah ditambah dengan masa tenggang dr db.member_setup ???? /
			//$sql = "SELECT member_id, member_no FROM vu_member WHERE member_cust='$member_cust'";
			
			//$sql = "SELECT member_id, member_no FROM member WHERE member_cust='$member_cust' AND ((member_valid + interval $periode_tenggang day) > date_format(now(), '%Y-%m-%d')) AND member_status='Serah Terima'";
			//untuk perpanjangan, tidak perlu melihat (member_valid + interval $periode_tenggang day), yg penting cust sdh pernah jadi member, otomatis lsg perpanjangan
			//update 2011-07-19: utk perpanjangan, jika ((member_valid + interval $periode_tenggang day) < date_format(now(), '%Y-%m-%d')) maka dianggap buat 'baru'
			$sql = "SELECT member_id, member_no 
					FROM member 
					WHERE 
						member_cust='$member_cust' AND 
						((member_valid + interval $periode_tenggang day) > date_format(now(), '%Y-%m-%d')) AND
						(member_status='Daftar' OR member_status='Cetak') ";
			$rs=$this->db->query($sql);
			if($rs->num_rows()){
					$record = $rs->row_array();
					//* customer melakukan 'perpanjangan' member  --> yg tgl validnya masih/
					$dti_member = array(
					"member_cust"=>$member_cust, 
					"member_no"=>$record['member_no'], 
					"member_register"=>$date_now, 
					"member_valid"=>$member_valid, 
					"member_jenis"=>'perpanjangan', 
					"member_status"=>'Daftar', 
					"member_tglserahterima"=>NULL,
					"member_creator"=>@$_SESSION[SESSION_USERID]
					);
					$this->db->insert('member', $dti_member); 
					if($this->db->affected_rows()){
						$this->cust_member_update($member_cust);
						return '1';
					}else
						return '0';				
			}else{
					//* Customer yang belum sama sekali menjadi Member Miracle atau masa aktif member sudah lewat dari masa tenggang /
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
					if($this->db->affected_rows()){
						$this->cust_member_update($member_cust);
						return '1';
					}else
						return '0';			
			}		
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
		
		
}
?>