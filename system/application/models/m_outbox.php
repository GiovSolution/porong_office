<? /* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
    #songbee	mukhlisona@gmail.com
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: outbox Model
	+ Description	: For record model process back-end
	+ Filename 		: c_outbox.php
 	+ Author  		: 
 	+ Created on 01/Feb/2010 14:30:05
	
*/

class M_outbox extends Model{
		
		//constructor
		function M_outbox() {
			parent::Model();
		}
		
		//function for get list record
		function outbox_list($filter,$start,$end){
			$query =   "SELECT 
							o.*, 
							c.cust_no, c.cust_nama 
						FROM outbox o
						LEFT JOIN customer c on c.cust_id = o.outbox_cust ";
			
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (outbox_destination LIKE '%".addslashes($filter)."%' OR 
							 outbox_message LIKE '%".addslashes($filter)."%' OR 
							 outbox_status LIKE '%".addslashes($filter)."%')";
			}

			$query .= " ORDER BY outbox_status ASC, outbox_date DESC ";
			
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
		function outbox_status_sent($filter,$start,$end){
			$query =   "SELECT 
							count(status) as status_sent
						FROM sentitems 
						WHERE  status like '%OK%' or status = 'DeliveryPending'";
			
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (outbox_destination LIKE '%".addslashes($filter)."%' OR outbox_message LIKE '%".addslashes($filter)."%' )";
			}

			//$query .= "";
			
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
/*			$limit = $query." LIMIT ".$start.",".$end;		
			$result = $this->db->query($limit);  */
			
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
		function outbox_status_unsent($filter,$start,$end){
			$query =   "SELECT 
							count(outbox_status) as status_unsent
						FROM outbox 
						WHERE outbox_status = 'unsent'";
			
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (outbox_destination LIKE '%".addslashes($filter)."%' OR outbox_message LIKE '%".addslashes($filter)."%' )";
			}

			//$query .= "";
			
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
/*			$limit = $query." LIMIT ".$start.",".$end;		
			$result = $this->db->query($limit); */ 
			
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
		function outbox_status_failed($filter,$start,$end){
			$query =   "SELECT 
							count(status) as status_failed
						FROM sentitems 
						WHERE id not in (select id from sentitems WHERE status like '%OK%' or status = 'DeliveryPending')";
			
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (outbox_destination LIKE '%".addslashes($filter)."%' OR outbox_message LIKE '%".addslashes($filter)."%' )";
			}

			//$query .= "";
			
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
/*			$limit = $query." LIMIT ".$start.",".$end;		
			$result = $this->db->query($limit); */ 
			
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
		function outbox_delete($pkid){
			// You could do some checkups here and return '0' or other error consts.
			// Make a single query to delete all of the outboxs at the same time :
			if(sizeof($pkid)<1){
				return '0';
			} else if (sizeof($pkid) == 1){
				$query = "DELETE FROM outbox WHERE ID = ".$pkid[0];
				$this->db->query($query);
			} else {
				$query = "DELETE FROM outbox WHERE ";
				for($i = 0; $i < sizeof($pkid); $i++){
					$query = $query . "ID= ".$pkid[$i];
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

		function outbox_delete_all(){
			// You could do some checkups here and return '0' or other error consts.
			// Make a single query to delete all of the outboxs at the same time :
			$query = "DELETE FROM outbox ";
			$this->db->query($query);
			 
			
			if($this->db->affected_rows()>0)
				return '1';
			else
				return '0';
		}
		
		//function for advanced search record
		function outbox_search($ID ,$outbox_destination ,$outbox_message ,$outbox_date, $outbox_status ,$outbox_creator ,$outbox_date_create, 
							   $outbox_update , $outbox_date_update ,$outbox_revised ,$start,$end){
			//full query
			$query =   "SELECT 
							o.*, 
							c.cust_no, c.cust_nama 
						FROM outbox o
						LEFT JOIN customer c on c.cust_id = o.outbox_cust ";
			
			
			if($outbox_destination!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " outbox_destination LIKE '%".$outbox_destination."%'";
			};
			if($outbox_message!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " outbox_message LIKE '%".$outbox_message."%'";
			};
			
			if($outbox_date!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " outbox_date LIKE '%".$outbox_date."%'";
			};
			
			if($outbox_status!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " outbox_status ='".$outbox_status."'";
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
		function outbox_print($ID ,$outbox_destination ,$outbox_message ,$outbox_date , $outbox_status, 
							  $outbox_creator ,$outbox_date_create ,$outbox_update ,
							  $outbox_date_update ,$outbox_revised ,$option,$filter){
			//full query
			$query =   "SELECT 
							o.*, 
							c.cust_no, c.cust_nama 
						FROM outbox o
						LEFT JOIN customer c on c.cust_id = o.outbox_cust ";
			
			if($option=='LIST'){
				$query .=eregi("WHERE",$sql)? " AND ":" WHERE ";
				$query .= " (outbox_destination LIKE '%".addslashes($filter)."%' OR 
							 outbox_message LIKE '%".addslashes($filter)."%' OR
							 outbox_status ='".addslashes($filter)."' )";
			} else if($option=='SEARCH'){
				if($outbox_destination!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " outbox_destination LIKE '%".$outbox_destination."%'";
				};
				if($outbox_message!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " outbox_message LIKE '%".$outbox_message."%'";
				};
				if($outbox_date!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " outbox_date LIKE '%".$outbox_date."%'";
				};
				
				if($outbox_status!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " outbox_status ='".$outbox_status."'";
				};
			}
			$query = $this->db->query($query);
			
			return $query->result();
		}
		
		//function  for export to excel
		function outbox_export_excel($ID ,$outbox_destination ,$outbox_message ,$outbox_date , $outbox_status, 
									 $outbox_creator ,$outbox_date_create ,
									 $outbox_update ,$outbox_date_update ,$outbox_revised ,$option,$filter){
			//full query
			$query =   "SELECT outbox_date as 'Tanggal Kirim', outbox_message as 'Isi Pesan', cust_no as 'No Cust', cust_nama as 'Customer',
								outbox_destination as 'No HP', outbox_status as Status								
						FROM outbox o
						LEFT JOIN customer c on c.cust_id = o.outbox_cust ";
			
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (outbox_destination LIKE '%".addslashes($filter)."%' OR 
							 outbox_message LIKE '%".addslashes($filter)."%' OR
							 outbox_status ='".addslashes($filter)."' )";
			} else if($option=='SEARCH'){
				if($outbox_destination!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " outbox_destination LIKE '%".$outbox_destination."%'";
				};
				if($outbox_message!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " outbox_message LIKE '%".$outbox_message."%'";
				};
				if($outbox_date!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " outbox_date LIKE '%".$outbox_date."%'";
				};
				
				if($outbox_status!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " outbox_status ='".$outbox_status."'";
				};
			}
			$query = $this->db->query($query);
			return $query;
		}
		
}
?>