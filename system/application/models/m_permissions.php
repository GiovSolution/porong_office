<? /* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
    #songbee	mukhlisona@gmail.com
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: permissions Model
	+ Description	: For record model process back-end
	+ Filename 		: c_permissions.php
 	+ Author  		: Zainal, Mukhlison
 	+ Created on 11/Jul/2009 06:46:58
	
*/

class M_permissions extends Model{
		
		//constructor
		function M_permissions() {
			parent::Model();
		}
		
		//function for get list record
		function permissions_list($filter,$start,$end){
			$query = "SELECT * FROM permissions";
			
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (perm_group LIKE '%".addslashes($filter)."%' OR perm_menu LIKE '%".addslashes($filter)."%' OR perm_priv LIKE '%".addslashes($filter)."%' )";
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
		function permissions_update($perm_group ,$perm_menu ,$perm_priv ){
			$data = array(
				"perm_group"=>$perm_group,			
				"perm_menu"=>$perm_menu,			
				"perm_priv"=>$perm_priv			
			);
			$this->db->where('perm_group,perm_menu', $perm_group,perm_menu);
			$this->db->update('permissions', $data);
			
			if($this->db->affected_rows())
				return '1';
			else
				return '0';
		}
		
		//function for create new record
		function permissions_create($perm_group ,$perm_menu ,$perm_priv ){
			$data = array(
				"perm_group"=>$perm_group,	
				"perm_menu"=>$perm_menu,	
				"perm_priv"=>$perm_priv	
			);
			$this->db->insert('permissions', $data); 
			if($this->db->affected_rows())
				return '1';
			else
				return '0';
		}
		
		//fcuntion for delete record
		function permissions_delete($pkid){
			// You could do some checkups here and return '0' or other error consts.
			// Make a single query to delete all of the permissionss at the same time :
			if(sizeof($pkid)<1){
				return '0';
			} else if (sizeof($pkid) == 1){
				$query = "DELETE FROM permissions WHERE perm_group,perm_menu = ".$pkid[0];
				$this->db->query($query);
			} else {
				$query = "DELETE FROM permissions WHERE ";
				for($i = 0; $i < sizeof($pkid); $i++){
					$query = $query . "perm_group,perm_menu= ".$pkid[$i];
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
		function permissions_search($perm_group ,$perm_menu ,$perm_priv ,$start,$end){
			//full query
			$query="select * from permissions";
			
			if($perm_group!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " perm_group LIKE '%".$perm_group."%'";
			};
			if($perm_menu!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " perm_menu LIKE '%".$perm_menu."%'";
			};
			if($perm_priv!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " perm_priv LIKE '%".$perm_priv."%'";
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
		function permissions_print($perm_group ,$perm_menu ,$perm_priv ,$option,$filter){
			//full query
			$query="select * from permissions";
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (perm_group LIKE '%".addslashes($filter)."%' OR perm_menu LIKE '%".addslashes($filter)."%' OR perm_priv LIKE '%".addslashes($filter)."%' )";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($perm_group!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " perm_group LIKE '%".$perm_group."%'";
				};
				if($perm_menu!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " perm_menu LIKE '%".$perm_menu."%'";
				};
				if($perm_priv!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " perm_priv LIKE '%".$perm_priv."%'";
				};
				$result = $this->db->query($query);
			}
			return $result;
		}
		
		//function  for export to excel
		function permissions_export_excel($perm_group ,$perm_menu ,$perm_priv ,$option,$filter){
			//full query
			$query="select * from permissions";
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (perm_group LIKE '%".addslashes($filter)."%' OR perm_menu LIKE '%".addslashes($filter)."%' OR perm_priv LIKE '%".addslashes($filter)."%' )";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($perm_group!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " perm_group LIKE '%".$perm_group."%'";
				};
				if($perm_menu!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " perm_menu LIKE '%".$perm_menu."%'";
				};
				if($perm_priv!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " perm_priv LIKE '%".$perm_priv."%'";
				};
				$result = $this->db->query($query);
			}
			return $result;
		}
		

}
?>