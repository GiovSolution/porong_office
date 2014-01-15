<? /* 	
	+ Module  		: crm_setup Model
	+ Description	: For record model process back-end
	+ Filename 		: c_crm_setup.php
 	+ creator 		:  Fred

	
*/

class M_crm_setup extends Model{
		
		//constructor
		function M_crm_setup() {
			parent::Model();
		}
		
		//function for get list record
		function crm_setup_list($filter,$start,$end){
			$query = "SELECT * FROM crm_setup";
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
			
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (setcrm_id LIKE '%".addslashes($filter)."%')";
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
		function crm_setup_create($setcrm_frequency_count, $setcrm_frequency_days, $setcrm_frequency_value_morethan, $setcrm_frequency_value_equal, $setcrm_frequency_value_lessthan,
													$setcrm_recency_days, $setcrm_recency_value_morethan, $setcrm_recency_value_lessthan,
													$setcrm_spending_days, $setcrm_spending_value_morethan, $setcrm_spending_value_equal, $setcrm_spending_value_lessthan,
													$setcrm_highmargin_treatment, $setcrm_highmargin_days, $setcrm_highmargin_value_morethan, $setcrm_highmargin_value_equal, $setcrm_highmargin_value_lessthan,
													$setcrm_referal_person, $setcrm_referal_days, $setcrm_referal_morethan, $setcrm_referal_equal, $setcrm_referal_lessthan,
													$setcrm_kerewelan_high, $setcrm_kerewelan_normal, $setcrm_kerewelan_low,
													$setcrm_disiplin_days, $setcrm_disiplin_persentase_pembatalan, $setcrm_disiplin_persentase_telat, $setcrm_disiplin_menit_telat, $setcrm_disiplin_batal_value_morethan, $setcrm_disiplin_batal_value_lessthan, $setcrm_disiplin_telat_value_morethan, $setcrm_disiplin_telat_value_lessthan,
													$setcrm_treatment_days, $setcrm_treatment_nonmedis, $setcrm_treatment_medis, $setcrm_treatment_morethan, $setcrm_treatment_equal, $setcrm_treatment_lessthan,
													$setcrm_result_nilai_atas, $setcrm_result_nilai_bawah,
													$setcrm_author, $setcrm_date_create){
			$data = array(
			
				"setcrm_frequency_count"=>$setcrm_frequency_count, 
				"setcrm_frequency_days"=>$setcrm_frequency_days, 
				"setcrm_frequency_value_morethan"=>$setcrm_frequency_value_morethan, 
				"setcrm_frequency_value_equal"=>$setcrm_frequency_value_equal, 
				"setcrm_frequency_value_lessthan"=>$setcrm_frequency_value_lessthan, 
				
				"setcrm_recency_days"=>$setcrm_recency_days, 
				"setcrm_recency_value_morethan"=>$setcrm_recency_value_morethan, 
				//"setcrm_recency_value_equal"=>$setcrm_recency_value_equal, 
				"setcrm_recency_value_lessthan"=>$setcrm_recency_value_lessthan, 
		
				"setcrm_spending_days"=>$setcrm_spending_days, 
				"setcrm_spending_value_morethan"=>$setcrm_spending_value_morethan, 
				"setcrm_spending_value_equal"=>$setcrm_spending_value_equal, 
				"setcrm_spending_value_lessthan"=>$setcrm_spending_value_lessthan, 
				
				"setcrm_highmargin_treatment"=>$setcrm_highmargin_treatment, 
				"setcrm_highmargin_days"=>$setcrm_highmargin_days, 
				"setcrm_highmargin_value_morethan"=>$setcrm_highmargin_value_morethan, 
				"setcrm_highmargin_value_equal"=>$setcrm_highmargin_value_equal, 
				"setcrm_highmargin_value_lessthan"=>$setcrm_highmargin_value_lessthan, 
				
				"setcrm_referal_person"=>$setcrm_referal_person, 
				"setcrm_referal_days"=>$setcrm_referal_days, 
				"setcrm_referal_morethan"=>$setcrm_referal_morethan, 
				"setcrm_referal_equal"=>$setcrm_referal_equal, 
				"setcrm_referal_lessthan"=>$setcrm_referal_lessthan, 
				
				"setcrm_kerewelan_high"=>$setcrm_kerewelan_high, 
				"setcrm_kerewelan_normal"=>$setcrm_kerewelan_normal, 
				"setcrm_kerewelan_low"=>$setcrm_kerewelan_low, 
				
				"setcrm_disiplin_days"=>$setcrm_disiplin_days, 
				"setcrm_disiplin_persentase_pembatalan"=>$setcrm_disiplin_persentase_pembatalan, 
				"setcrm_disiplin_persentase_telat"=>$setcrm_disiplin_persentase_telat, 
				"setcrm_disiplin_menit_telat"=>$setcrm_disiplin_menit_telat, 
				"setcrm_disiplin_batal_value_morethan"=>$setcrm_disiplin_batal_value_morethan, 
				"setcrm_disiplin_batal_value_lessthan"=>$setcrm_disiplin_batal_value_lessthan, 
				"setcrm_disiplin_telat_value_morethan"=>$setcrm_disiplin_telat_value_morethan, 
				"setcrm_disiplin_telat_value_lessthan"=>$setcrm_disiplin_telat_value_lessthan, 
				
				"setcrm_treatment_days"=>$setcrm_treatment_days, 
				"setcrm_treatment_nonmedis"=>$setcrm_treatment_nonmedis, 
				"setcrm_treatment_medis"=>$setcrm_treatment_medis, 
				"setcrm_treatment_morethan"=>$setcrm_treatment_morethan, 
				"setcrm_treatment_equal"=>$setcrm_treatment_equal, 
				"setcrm_treatment_lessthan"=>$setcrm_treatment_lessthan, 
				
				"setcrm_result_nilai_atas"=>$setcrm_result_nilai_atas,
				"setcrm_result_nilai_bawah"=>$setcrm_result_nilai_bawah,
				
				"setcrm_author"=>$setcrm_author, 
				"setcrm_date_create"=>$setcrm_date_create 
			);
			$this->db->insert('crm_setup', $data); 
			if($this->db->affected_rows())
				return '1';
			else
				return '0';
		}
		
		//function for update record
		function crm_setup_update($setcrm_id,
								$setcrm_frequency_count, $setcrm_frequency_days, $setcrm_frequency_value_morethan, $setcrm_frequency_value_equal, $setcrm_frequency_value_lessthan,
								$setcrm_recency_days, $setcrm_recency_value_morethan, $setcrm_recency_value_lessthan,
								$setcrm_spending_days, $setcrm_spending_value_morethan, $setcrm_spending_value_equal, $setcrm_spending_value_lessthan,
								$setcrm_highmargin_treatment, $setcrm_highmargin_days, $setcrm_highmargin_value_morethan, $setcrm_highmargin_value_equal, $setcrm_highmargin_value_lessthan,
								$setcrm_referal_person, $setcrm_referal_days, $setcrm_referal_morethan, $setcrm_referal_equal, $setcrm_referal_lessthan,
								$setcrm_kerewelan_high, $setcrm_kerewelan_normal, $setcrm_kerewelan_low,
								$setcrm_disiplin_days, $setcrm_disiplin_persentase_pembatalan, $setcrm_disiplin_persentase_telat, $setcrm_disiplin_menit_telat, $setcrm_disiplin_batal_value_morethan, $setcrm_disiplin_batal_value_lessthan, $setcrm_disiplin_telat_value_morethan, $setcrm_disiplin_telat_value_lessthan,
								$setcrm_treatment_days, $setcrm_treatment_nonmedis, $setcrm_treatment_medis, $setcrm_treatment_morethan, $setcrm_treatment_equal, $setcrm_treatment_lessthan,
								$setcrm_result_nilai_atas, $setcrm_result_nilai_bawah,
								$setcrm_update, $setcrm_date_update){
			$data = array(
			
				"setcrm_frequency_count"=>$setcrm_frequency_count, 
				"setcrm_frequency_days"=>$setcrm_frequency_days, 
				"setcrm_frequency_value_morethan"=>$setcrm_frequency_value_morethan, 
				"setcrm_frequency_value_equal"=>$setcrm_frequency_value_equal, 
				"setcrm_frequency_value_lessthan"=>$setcrm_frequency_value_lessthan, 
				
				"setcrm_recency_days"=>$setcrm_recency_days, 
				"setcrm_recency_value_morethan"=>$setcrm_recency_value_morethan, 
				//"setcrm_recency_value_equal"=>$setcrm_recency_value_equal, 
				"setcrm_recency_value_lessthan"=>$setcrm_recency_value_lessthan, 
		
				"setcrm_spending_days"=>$setcrm_spending_days, 
				"setcrm_spending_value_morethan"=>$setcrm_spending_value_morethan, 
				"setcrm_spending_value_equal"=>$setcrm_spending_value_equal, 
				"setcrm_spending_value_lessthan"=>$setcrm_spending_value_lessthan, 
				
				"setcrm_highmargin_treatment"=>$setcrm_highmargin_treatment, 
				"setcrm_highmargin_days"=>$setcrm_highmargin_days, 
				"setcrm_highmargin_value_morethan"=>$setcrm_highmargin_value_morethan, 
				"setcrm_highmargin_value_equal"=>$setcrm_highmargin_value_equal, 
				"setcrm_highmargin_value_lessthan"=>$setcrm_highmargin_value_lessthan, 
				
				"setcrm_referal_person"=>$setcrm_referal_person, 
				"setcrm_referal_days"=>$setcrm_referal_days, 
				"setcrm_referal_morethan"=>$setcrm_referal_morethan, 
				"setcrm_referal_equal"=>$setcrm_referal_equal, 
				"setcrm_referal_lessthan"=>$setcrm_referal_lessthan, 
				
				"setcrm_kerewelan_high"=>$setcrm_kerewelan_high, 
				"setcrm_kerewelan_normal"=>$setcrm_kerewelan_normal, 
				"setcrm_kerewelan_low"=>$setcrm_kerewelan_low, 
				
				"setcrm_disiplin_days"=>$setcrm_disiplin_days, 
				"setcrm_disiplin_persentase_pembatalan"=>$setcrm_disiplin_persentase_pembatalan, 
				"setcrm_disiplin_persentase_telat"=>$setcrm_disiplin_persentase_telat, 
				"setcrm_disiplin_menit_telat"=>$setcrm_disiplin_menit_telat, 
				"setcrm_disiplin_batal_value_morethan"=>$setcrm_disiplin_batal_value_morethan, 
				"setcrm_disiplin_batal_value_lessthan"=>$setcrm_disiplin_batal_value_lessthan, 
				"setcrm_disiplin_telat_value_morethan"=>$setcrm_disiplin_telat_value_morethan, 
				"setcrm_disiplin_telat_value_lessthan"=>$setcrm_disiplin_telat_value_lessthan, 
				
				"setcrm_treatment_days"=>$setcrm_treatment_days, 
				"setcrm_treatment_nonmedis"=>$setcrm_treatment_nonmedis, 
				"setcrm_treatment_medis"=>$setcrm_treatment_medis, 
				"setcrm_treatment_morethan"=>$setcrm_treatment_morethan, 
				"setcrm_treatment_equal"=>$setcrm_treatment_equal, 
				"setcrm_treatment_lessthan"=>$setcrm_treatment_lessthan, 
				
				"setcrm_result_nilai_atas"=>$setcrm_result_nilai_atas,
				"setcrm_result_nilai_bawah"=>$setcrm_result_nilai_bawah,
				
				"setcrm_update"=>$setcrm_update, 
				"setcrm_date_update"=>$setcrm_date_update 
			);
			
			//$this->db->where('setcrm_id', $setcrm_id);
			
			$this->db->insert('crm_setup', $data);
			$this->db->update('crm_setup', $data);
			$sql="UPDATE crm_setup set setcrm_revised=(setcrm_revised+1)";
			$this->db->query($sql);
			if($this->db->affected_rows())
			return '1';
			else
			return '0';
			
			
		}
	
	
		
}
?>