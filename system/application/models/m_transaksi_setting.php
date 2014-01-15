<? /* 	
	+ Module  		: transaksi_setting Model
	+ Description	: For record model process back-end
	+ Filename 		: c_transaksi_setting.php
 	+ creator 		:   Nat

	
*/

class M_transaksi_setting extends Model{
		
		//constructor
		function M_transaksi_setting() {
			parent::Model();
		}
		
		//function for get list record
		function transaksi_setting_list($filter,$start,$end){
			$query = "SELECT * FROM transaksi_setting";
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
			
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				//$query .= " (setcrm_id LIKE '%".addslashes($filter)."%')";
			}
			
			
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
		function transaksi_setting_create($trans_op_days, $trans_update, $trans_date_update){
			$data = array(
				"trans_op_days"=>$trans_op_days,
				"trans_update"=>$trans_update, 
				"trans_date_update"=>$trans_date_update 
			);
			$this->db->insert('transaksi_setting', $data); 
			if($this->db->affected_rows())
				return '1';
			else
				return '0';
		}
		
		//function for update record
		function transaksi_setting_update($trans_op_days, $mb_days, $kembali_poin_days, $trans_update, $trans_date_update){
			$data = array(				
				"trans_op_days"=>$trans_op_days,
				"mb_days"=>$mb_days,				
				"kembali_poin_days"=>$kembali_poin_days,
				"trans_update"=>$trans_update, 
				"trans_date_update"=>$trans_date_update 
			);
			
			//$this->db->where('setcrm_id', $setcrm_id);
			
			//$this->db->insert('transaksi_setting', $data);
			$this->db->update('transaksi_setting', $data);
			$sql="UPDATE transaksi_setting set trans_revised=(trans_revised+1)";
			$this->db->query($sql);
			if($this->db->affected_rows())
			return '1';
			else
			return '0';			
		}
}
?>