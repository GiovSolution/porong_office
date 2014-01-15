<? /* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
    #songbee	mukhlisona@gmail.com
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: info Model
	+ Description	: For record model process back-end
	+ Filename 		: c_info.php
 	+ Author  		: Zainal, Mukhlison
 	+ Created on 11/Jul/2009 06:46:58
	
*/

class M_info extends Model{
		
		//constructor
		function M_info() {
			parent::Model();
		}
		
		function get_detail_info(){
			$sql="select * from info";
			$result=$this->db->query($sql);
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
		
		
		//auto cabang
		function get_auto_cabang ($cabang_id){
		$sql = "SELECT * from cabang where cabang_id='".$cabang_id."' and cabang_aktif!='Tidak Aktif' order by cabang_id desc limit 1";
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
		//function for get list record
		function info_list($filter,$start,$end){
			$query = "SELECT * FROM info";
						
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
		function info_update($info_id ,$info_nama ,$info_alamat ,$info_notelp ,$info_nofax ,$info_email ,$info_website ,$info_slogan, $info_cabang){
			$data = array(
				"info_id"=>$info_id,			
				"info_nama"=>$info_nama,			
				"info_alamat"=>$info_alamat,			
				"info_notelp"=>$info_notelp,			
				"info_nofax"=>$info_nofax,			
				"info_email"=>$info_email,			
				"info_website"=>$info_website,			
				"info_slogan"=>$info_slogan,
				"info_cabang"=>$info_cabang
			);
			$this->db->where('info_id', $info_id);
			$this->db->update('info', $data);
			
			if($this->db->affected_rows())
				return "{success:true}";
			else
				return "{failure:true}";
		}
		
		
}
?>