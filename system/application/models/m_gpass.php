<? /* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
    #songbee	mukhlisona@gmail.com
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: Ganti Password Model
	+ Description	: For record model process back-end
	+ Filename 		: M_tbl_lap_kunjungan.php
 	+ Author  		: 
 	+ Created on 01/May/2009 06:35:27
	
*/

class M_gpass extends Model{
		
		//constructor
		function M_gpass() {
			parent::Model();
		}
		
		
		//function for get list record
		function get($user_id){
			$query = "SELECT * FROM users WHERE user_id='".$user_id."'";
						
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
			
			if($nbrows>0){
				foreach($result->result() as $row){
					$arr[] = $row;
				}
				$jsonresult = json_encode($arr);
				return '({"total":"1","results":'.$jsonresult.'})';
			} else {
				return '({"total":"0", "results":""})';
			}
		}
		
		//function for update record
		function update_users($user_id, /*$user_nama, $user_kelamin, $user_tgllahir, $user_alamat, $user_kota, $user_notelp,*/ $user_passwd, $user_passwdlama ){
			$key=false;
			$sql="select user_passwd from users WHERE user_name='".$user_id."'";
			$query=$this->db->query($sql);
			if($query->num_rows()>0){
				$rs=$query->row_array();
				if($rs["user_passwd"]==md5($user_passwdlama))
					$key=true;
			}
			$data = array(	
				/*"user_id"=>$user_id,		
				"user_nama"=>$user_nama,			
				"user_tgllahir"=>$user_tgllahir,			
				"user_kelamin"=>$user_kelamin,
				"user_alamat"=>$user_alamat,
				"user_kota"=>$user_kota,
				"user_notelp"=>$user_notelp		*/	
			);
			
			if($key){
			
				if(!is_null($user_passwd) & trim($user_passwd)<>"")
					$data["user_passwd"]=md5($user_passwd);
					
				$this->db->where('user_name',$user_id);
				$this->db->update('users', $data);
				
				if($this->db->affected_rows())
					return '1';
				else
					return '0';
			}else
				return '0';
		}

}
?>