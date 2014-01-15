<? /* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
    #songbee	mukhlisona@gmail.com
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: sent_item Model
	+ Description	: For record model process back-end
	+ Filename 		: M_sent_item.php
 	+ Author  		: Natalie
 	 	+ Created on 20/Apr/2011 14:17
	
*/

class M_sent_item extends Model{
		
		//constructor
		function M_sent_item() {
			parent::Model();
		}
		
		//function for get list record
		function sent_item_list($filter,$start,$end){
			$query =   "SELECT s.*, c.cust_no, c.cust_nama
						FROM sentitems s
						left join customer c on c.cust_id = s.cust_id";
			
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (cust_no LIKE '%".addslashes($filter)."%' OR cust_nama LIKE '%".addslashes($filter)."%' OR DestinationNumber LIKE '%".addslashes($filter)."%' OR 
							 TextDecoded LIKE '%".addslashes($filter)."%')";
			}

			$query .= " ORDER BY SendingDateTime DESC ";
			
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
			//$limit = $query." LIMIT ".$start.",".$end;		
			//$result = $this->db->query($limit);   
			if($end!=0){
				$limit = $query." LIMIT ".$start.",".$end;
				$result = $this->db->query($limit);
			}
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
		/*function sent_item_status_sent($filter,$start,$end){
			$query =   "SELECT 
							count(sentitems_status) as status_sent
						FROM sentitems 
						WHERE sentitems_status = 'sent'";
			
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (DestinationNumber LIKE '%".addslashes($filter)."%' OR TextDecoded LIKE '%".addslashes($filter)."%' )";
			}

			//$query .= "";
			
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
		function sent_item_status_unsent($filter,$start,$end){
			$query =   "SELECT 
							count(sentitems_status) as status_unsent
						FROM sentitems 
						WHERE sentitems_status = 'unsent'";
			
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (DestinationNumber LIKE '%".addslashes($filter)."%' OR TextDecoded LIKE '%".addslashes($filter)."%' )";
			}

			//$query .= "";
			
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
		function sent_item_status_failed($filter,$start,$end){
			$query =   "SELECT 
							count(sentitems_status) as status_failed
						FROM sentitems 
						WHERE sentitems_status = 'failed'";
			
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (DestinationNumber LIKE '%".addslashes($filter)."%' OR TextDecoded LIKE '%".addslashes($filter)."%' )";
			}

			//$query .= "";
			
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
		} */
		
		
		//fcuntion for delete record
		function sent_item_delete($pkid){
			// You could do some checkups here and return '0' or other error consts.
			// Make a single query to delete all of the sent_items at the same time :
			if(sizeof($pkid)<1){
				return '0';
			} else if (sizeof($pkid) == 1){
				$query = "DELETE FROM sentitems WHERE ID = ".$pkid[0];
				$this->db->query($query);
			} else {
				$query = "DELETE FROM sentitems WHERE ";
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

		function sent_item_delete_all(){
			// You could do some checkups here and return '0' or other error consts.
			// Make a single query to delete all of the sent_items at the same time :
			$query = "DELETE FROM sentitems ";
			$this->db->query($query);
			 
			
			if($this->db->affected_rows()>0)
				return '1';
			else
				return '0';
		}
		
		//function for advanced search record
		function sent_item_search($ID ,$DestinationNumber ,$TextDecoded ,$SendingDateTime,$SendingDateTimeEnd,$SendingTime,$SendingTimeEnd, $Status,$start,$end){
			//full query
			$query =   "SELECT * FROM sentitems";
			
			
			if($DestinationNumber!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " DestinationNumber LIKE '%".$DestinationNumber."%'";
			};
			if($TextDecoded!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " TextDecoded LIKE '%".$TextDecoded."%'";
			};
			
			if($SendingDateTime!='' AND $SendingDateTimeEnd!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				if($SendingDateTime==$SendingDateTimeEnd){
					$query.= " (SendingDateTime like '%".$SendingDateTime."%' OR SendingDateTime like '%".$SendingDateTimeEnd."%')";
				}else{
					$query.= " (substring(SendingDateTime,1,10) = '".$SendingDateTime."' OR substring(SendingDateTime,1,10) = '".$SendingDateTimeEnd."')";
				}
			};
			
			if($SendingTime!='' AND $SendingTimeEnd!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " SUBSTR(SendingDateTime,12) BETWEEN '".$SendingTime."' AND '".$SendingTimeEnd."'";
			};
			
			if($Status!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " Status = '".$Status."'";
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
		
		//function for resend SMS
		function sent_item_resend($ID ,$DestinationNumber ,$TextDecoded ,$SendingDateTime,$SendingDateTimeEnd, $SendingTime,$SendingTimeEnd,$Status,$start,$end){
			//full query
			$query =   "SELECT * FROM sentitems";
			
			if($DestinationNumber!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " DestinationNumber LIKE '%".$DestinationNumber."%'";
			};
			if($TextDecoded!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " TextDecoded LIKE '%".$TextDecoded."%'";
			};
			
			if($SendingDateTime!='' AND $SendingDateTimeEnd!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				if($SendingDateTime=$SendingDateTimeEnd){
					$query.= " (SendingDateTime like '%".$SendingDateTime."%' OR SendingDateTime like '%".$SendingDateTimeEnd."%')";
				}else{
					$query.= " (SendingDateTime > '".$SendingDateTime."' AND SendingDateTime < '".$SendingDateTimeEnd."')";
				}
			};
			
			if($SendingTime!='' AND $SendingTimeEnd!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " SUBSTR(SendingDateTime,12) BETWEEN '".$SendingTime."' AND '".$SendingTimeEnd."'";
			};
			
			if($Status!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " Status = '".$Status."'";
			}/*else{
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " Status = 'SendingOK'";
			}*/;
			
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();	  
			$ret = 0;
			
			$querystatus =   "SELECT * FROM sentitems where status <> 'SendingError'";
			$resultstatus = $this->db->query($querystatus);
			$nbrows_status = $resultstatus->num_rows();	 
			
			//looping dimulai disini
			if ($nbrows <= 1000) { //cek apakah sms yg akan di resend lbh dr 1000 sms
				if ($Status=='' && $nbrows_status <> 0){
					return '3'; //jika langsung resend, tanpa melalui adv search dan ada status yg selain SendingError
				}else{	
					for ($i = 0; $i < $nbrows; $i++) {
						$record = $result->row($i);
						$cust_id= $record->cust_id;		
						$DestinationNumber= $record->DestinationNumber;
						$TextDecoded= $record->TextDecoded;		
						$sent_item_id= $record->ID;							
						
						$data=array(
							"outbox_cust"	=> $cust_id,
							"outbox_destination"	=> $DestinationNumber,
							"outbox_message"	=> $TextDecoded,
							"outbox_date"		=> date('Y/m/d H:i:s'),
							"outbox_status"	=> 'unsent',
							"outbox_creator"		=> $_SESSION[SESSION_USERID],
							"outbox_date_create"	=> date('Y/m/d H:i:s'),
							"DestinationNumber"		=> $DestinationNumber,
							"TextDecoded"	=> $TextDecoded,
							"CreatorID"		=> $_SESSION[SESSION_USERID]
						);
						
							$this->db->insert('outbox',$data);
							
							$query_delete = "DELETE from sentitems where ID = '".$sent_item_id."' ";
							
							$result_delete=$this->db->query($query_delete);
							$ret = 1;
					}
					if ($ret == 1)
						
						return 1;	//sent item sukses dipindah ke outbox
					else
						return 0; 
				}
			}
			else
				return 2; //jika sms yang akan di resend lbh dr 1000 sms
		}
		
		//function for print record
		function sent_item_print($ID ,$DestinationNumber ,$TextDecoded ,$SendingDateTime ,$option,$filter){
			//full query
			$query =   "SELECT * FROM sentitems ";
			
			if($option=='LIST'){
				$query .=eregi("WHERE",$sql)? " AND ":" WHERE ";
				$query .= " (DestinationNumber LIKE '%".addslashes($filter)."%' OR 
							 TextDecoded LIKE '%".addslashes($filter)."%' )";
			} else if($option=='SEARCH'){
				if($DestinationNumber!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " DestinationNumber LIKE '%".$DestinationNumber."%'";
				};
				if($TextDecoded!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " TextDecoded LIKE '%".$TextDecoded."%'";
				};
				if($SendingDateTime!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " SendingDateTime LIKE '%".$SendingDateTime."%'";
				};
				
			}
			$query = $this->db->query($query);
			
			return $query->result();
		}
		
		//function  for export to excel
		function sent_item_export_excel($ID ,$DestinationNumber ,$TextDecoded ,$SendingDateTime, $option,$filter){
			//full query
			$query =   "SELECT SendingDateTime as 'Tanggal Kirim', TextDecoded as 'Isi Pesan', DestinationNumber as 'No HP'
						FROM sentitems";
			
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (DestinationNumber LIKE '%".addslashes($filter)."%' OR 
							 TextDecoded LIKE '%".addslashes($filter)."%' )";
			} else if($option=='SEARCH'){
				if($DestinationNumber!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " DestinationNumber LIKE '%".$DestinationNumber."%'";
				};
				if($TextDecoded!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " TextDecoded LIKE '%".$TextDecoded."%'";
				};
				if($SendingDateTime!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " SendingDateTime LIKE '%".$SendingDateTime."%'";
				};
			
			}
			$query = $this->db->query($query);
			return $query;
		}
		
}
?>