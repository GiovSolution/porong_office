<? /* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
    #songbee	mukhlisona@gmail.com
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: member_setup Model
	+ Description	: For record model process back-end
	+ Filename 		: c_member_setup.php
 	+ creator 		: 
 	+ Created on 06/Apr/2010 12:55:05
	
*/

class M_member_setup extends Model{
		
		//constructor
		function M_member_setup() {
			parent::Model();
		}
		
		//function for get list record
		function member_setup_list($filter,$start,$end){
			$query = "SELECT * FROM member_setup";
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();

			if($nbrows>0){
				$row=$result->row();
				$arr[0]['setmember_id']=1;
				$arr[0]['setmember_transhari']=number_format($row->setmember_transhari);
				$arr[0]['setmember_pointhari']=number_format($row->setmember_pointhari);
				$arr[0]['setmember_transbulan']=number_format($row->setmember_transbulan);
				$arr[0]['setmember_transtenggang']=number_format($row->setmember_transtenggang);
				$arr[0]['setmember_pointbulan']=number_format($row->setmember_pointbulan);
				$arr[0]['setmember_periodeaktif']=number_format($row->setmember_periodeaktif);
				$arr[0]['setmember_periodetenggang']=number_format($row->setmember_periodetenggang);
				$arr[0]['setmember_pointtenggang']=number_format($row->setmember_pointtenggang);
				$arr[0]['setmember_rp_perpoint']=number_format($row->setmember_rp_perpoint);
				$arr[0]['setmember_point_perrp']=number_format($row->setmember_point_perrp);				
				$arr[0]['setmember_mintransx']=number_format($row->setmember_mintransx);
				$arr[0]['setmember_mintransrp']=number_format($row->setmember_mintransrp);
				$arr[0]['setmember_waktu']=number_format($row->setmember_waktu);				
				
				$jsonresult = json_encode($arr);
				return '({"total":"'.$nbrows.'","results":'.$jsonresult.'})';
			} else {
				return '({"total":"0", "results":""})';
			}
		}
		
		//function for create new record
		function member_setup_create($setmember_transhari, $setmember_pointhari ,$setmember_transbulan, $setmember_pointbulan ,
									 $setmember_periodeaktif ,$setmember_periodetenggang ,$setmember_transtenggang, $setmember_pointtenggang ,
									 $setmember_author ,$setmember_date_create,  $setmember_mintransx, $setmember_mintransrp, $setmember_waktu ){
			$data = array(
				"setmember_transhari"=>$setmember_transhari, 
				"setmember_transbulan"=>$setmember_transbulan, 
				"setmember_periodeaktif"=>$setmember_periodeaktif, 
				"setmember_periodetenggang"=>$setmember_periodetenggang, 
				"setmember_transtenggang"=>$setmember_transtenggang, 
				"setmember_author"=>$setmember_author, 
				"setmember_date_create"=>$setmember_date_create,
				"setmember_mintransx"=>$setmember_mintransx, 
				"setmember_mintransrp"=>$setmember_mintransrp, 
				"setmember_waktu"=>$setmember_waktu				
			);
			$this->db->insert('member_setup', $data); 
			if($this->db->affected_rows())
				return '1';
			else
				return '0';
		}
		
		//function for update record
		function member_setup_update($setmember_id,$setmember_transhari, $setmember_pointhari ,$setmember_transbulan, $setmember_pointbulan ,
									 $setmember_periodeaktif ,$setmember_periodetenggang ,$setmember_transtenggang, $setmember_pointtenggang, 
									 $setmember_rp_perpoint, $setmember_point_perrp, $setmember_update,$setmember_date_update,  $setmember_mintransx, $setmember_mintransrp, $setmember_waktu){
			$data = array(
				"setmember_transhari"=>$setmember_transhari,
				"setmember_pointhari"=>$setmember_pointhari,
				"setmember_transbulan"=>$setmember_transbulan,
				"setmember_pointbulan"=>$setmember_pointbulan,
				"setmember_periodeaktif"=>$setmember_periodeaktif, 
				"setmember_periodetenggang"=>$setmember_periodetenggang,
				"setmember_pointtenggang"=>$setmember_pointtenggang,
				"setmember_transtenggang"=>$setmember_transtenggang, 
				"setmember_rp_perpoint"=>$setmember_rp_perpoint,
				"setmember_point_perrp"=>$setmember_point_perrp,
				"setmember_update"=>$setmember_update, 
				"setmember_mintransx"=>$setmember_mintransx, 
				"setmember_mintransrp"=>$setmember_mintransrp, 
				"setmember_waktu"=>$setmember_waktu,	
				"setmember_date_update"=>$setmember_date_update 
			);
			
			//$this->db->where('setmember_id', $setmember_id);
			$this->db->update('member_setup', $data);
			$sql="UPDATE member_setup set setmember_revised=(setmember_revised+1)";
			$this->db->query($sql);
			return '1';
		}
		
				
}
?>