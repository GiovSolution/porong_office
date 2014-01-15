<? /* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
    #songbee	mukhlisona@gmail.com
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: inbox Model
	+ Description	: For record model process back-end
	+ Filename 		: c_inbox.php
 	+ Author  		: 
 	+ Created on 01/Feb/2010 14:30:05
	
*/

class M_inbox extends Model{
		
		//constructor
		function M_inbox() {
			parent::Model();
		}
		
		//function for get list record
		function inbox_list($filter,$start,$end){
			$query = "SELECT * FROM inbox WHERE inbox_status!='Hide'";
			
			// For simple search
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (SenderNumber LIKE '%".addslashes($filter)."%' OR 
							 TextDecoded LIKE '%".addslashes($filter)."%' )";
			}
			
			$query .= " ORDER BY receivingDateTime DESC ";

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
		
		function inbox_save($inbox_pengirim,$inbox_isi,$inbox_task,$inbox_id){
			$sql="";
			//yg disimpan cukup message & tanggalnya aja. by hendri 2010-06-16
			if($inbox_task=='draft'){
				$sql="insert into draft(
						draft_message,
						draft_date,
						draft_creator,
						draft_date_create)
					 values(
						'".$inbox_isi."',
						'".date('Y/m/d H:i:s')."',
						'".$_SESSION[SESSION_USERID]."',
						'".date('Y/m/d H:i:s')."')";
				$this->db->query($sql);
				//echo $sql;
			}
			else{
				$sql="insert into outbox(
						outbox_destination,
						outbox_message,
						outbox_date,
						outbox_status,
						outbox_creator,
						outbox_date_create,
						DestinationNumber,
						TextDecoded)
					values(
						'".$inbox_pengirim."',
						'".$inbox_isi."',
						'".date('Y/m/d H:i:s')."',
						'unsent',
						'".$_SESSION[SESSION_USERID]."',
						'".date('Y/m/d H:i:s')."',
						'".$inbox_pengirim."',
						'".$inbox_isi."'
						)";
				
				$sql2="update inbox set inbox_status='Replied' where ID='".$inbox_id."'";
				$this->db->query($sql);
				$this->db->query($sql2);
				$sql="";				
			}	
			return '1';
		}
		
		
		//fcuntion for delete record (tidak benar2 dhapus, hanya dihide)
		function inbox_delete($pkid){
			// You could do some checkups here and return '0' or other error consts.
			// Make a single query to delete all of the inboxs at the same time :
			if(sizeof($pkid)<1){
				return '0';
			} else if (sizeof($pkid) == 1){
				$query = "UPDATE inbox SET inbox_status='Hide' WHERE ID = ".$pkid[0];
				$this->db->query($query);
			} else {
				$query = "UPDATE inbox SET inbox_status='Hide' WHERE ";
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
		
		//function for advanced search record
		function inbox_search($inbox_id ,$SenderNumber ,$TextDecoded ,$inbox_date ,$inbox_creator ,$inbox_date_create ,$inbox_update ,
							  $inbox_date_update ,$inbox_revised ,$start,$end){
			//full query
			$query="select * from inbox";
			
			
			if($SenderNumber!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " SenderNumber LIKE '%".$SenderNumber."%'";
			};
			if($TextDecoded!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " TextDecoded LIKE '%".$TextDecoded."%'";
			};
			if($inbox_date!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " receivingDateTime LIKE '%".$inbox_date."%'";
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
		function inbox_print($inbox_id ,$SenderNumber ,$TextDecoded ,$inbox_date ,$inbox_creator ,$inbox_date_create ,$inbox_update ,
							 $inbox_date_update ,$inbox_revised ,$option,$filter){
			//full query
			$sql="select * from inbox";
			if($option=='LIST'){
				$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
				$sql .= " (SenderNumber LIKE '%".addslashes($filter)."%' OR 
						   TextDecoded LIKE '%".addslashes($filter)."%'  )";
			
			} else if($option=='SEARCH'){
				
				if($SenderNumber!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " SenderNumber LIKE '%".$SenderNumber."%'";
				};
				if($TextDecoded!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " TextDecoded LIKE '%".$TextDecoded."%'";
				};
				if($inbox_date!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " inbox_date LIKE '%".$inbox_date."%'";
				};
			}
			$query = $this->db->query($sql);
			return $query->result();
		}
		
		//function  for export to excel
		function inbox_export_excel($inbox_id ,$SenderNumber ,$TextDecoded ,$inbox_date ,$inbox_creator ,$inbox_date_create ,$inbox_update ,
									$inbox_date_update ,$inbox_revised ,$option,$filter){
			//full query
			$sql="select inbox_date as Tanggal,SenderNumber as Pengirim, TextDecoded as 'Isi Pesan' from inbox";
			if($option=='LIST'){
				$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
				$sql .= " (SenderNumber LIKE '%".addslashes($filter)."%' OR 
						   TextDecoded LIKE '%".addslashes($filter)."%'  )";
			
			} else if($option=='SEARCH'){
				
				if($SenderNumber!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " SenderNumber LIKE '%".$SenderNumber."%'";
				};
				if($TextDecoded!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " TextDecoded LIKE '%".$TextDecoded."%'";
				};
				if($inbox_date!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " inbox_date LIKE '%".$inbox_date."%'";
				};
			}
			$query = $this->db->query($sql);
			return $query;
		}
		
}
?>