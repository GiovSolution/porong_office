<? /* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
    #songbee	mukhlisona@gmail.com
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: menus Model
	+ Description	: For record model process back-end
	+ Filename 		: c_menus.php
 	+ Author  		: Zainal, Mukhlison
 	+ Created on 11/Jul/2009 06:46:58
	
*/

class M_menus extends Model{
		
		//constructor
		function M_menus() {
			parent::Model();
		}
		
		//function for get list record
		function menus_list($filter,$start,$end){
			$query = "SELECT * FROM menus";
			
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (menu_id LIKE '%".addslashes($filter)."%' OR menu_parent LIKE '%".addslashes($filter)."%' OR menu_position LIKE '%".addslashes($filter)."%' OR menu_title LIKE '%".addslashes($filter)."%' OR menu_link LIKE '%".addslashes($filter)."%' OR menu_cat LIKE '%".addslashes($filter)."%' OR menu_confirm LIKE '%".addslashes($filter)."%' OR menu_leftpanel LIKE '%".addslashes($filter)."%' OR menu_iconpanel LIKE '%".addslashes($filter)."%' OR menu_iconmenu LIKE '%".addslashes($filter)."%' )";
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
		function menus_update($menu_id ,$menu_parent ,$menu_position ,$menu_title ,$menu_link ,$menu_cat ,$menu_confirm ,$menu_leftpanel ,$menu_iconpanel ,$menu_iconmenu ){
			$data = array(
				"menu_id"=>$menu_id,			
				"menu_parent"=>$menu_parent,			
				"menu_position"=>$menu_position,			
				"menu_title"=>$menu_title,			
				"menu_link"=>$menu_link,			
				"menu_cat"=>$menu_cat,			
				"menu_confirm"=>$menu_confirm,			
				"menu_leftpanel"=>$menu_leftpanel,			
				"menu_iconpanel"=>$menu_iconpanel,			
				"menu_iconmenu"=>$menu_iconmenu			
			);
			$this->db->where('menu_id', $menu_id);
			$this->db->update('menus', $data);
			
			if($this->db->affected_rows())
				return '1';
			else
				return '0';
		}
		
		//function for create new record
		function menus_create($menu_parent ,$menu_position ,$menu_title ,$menu_link ,$menu_cat ,$menu_confirm ,$menu_leftpanel ,$menu_iconpanel ,$menu_iconmenu ){
			$data = array(
	
				"menu_parent"=>$menu_parent,	
				"menu_position"=>$menu_position,	
				"menu_title"=>$menu_title,	
				"menu_link"=>$menu_link,	
				"menu_cat"=>$menu_cat,	
				"menu_confirm"=>$menu_confirm,	
				"menu_leftpanel"=>$menu_leftpanel,	
				"menu_iconpanel"=>$menu_iconpanel,	
				"menu_iconmenu"=>$menu_iconmenu	
			);
			$this->db->insert('menus', $data); 
			if($this->db->affected_rows())
				return '1';
			else
				return '0';
		}
		
		//fcuntion for delete record
		function menus_delete($pkid){
			// You could do some checkups here and return '0' or other error consts.
			// Make a single query to delete all of the menuss at the same time :
			if(sizeof($pkid)<1){
				return '0';
			} else if (sizeof($pkid) == 1){
				$query = "DELETE FROM menus WHERE menu_id = ".$pkid[0];
				$this->db->query($query);
			} else {
				$query = "DELETE FROM menus WHERE ";
				for($i = 0; $i < sizeof($pkid); $i++){
					$query = $query . "menu_id= ".$pkid[$i];
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
		function menus_search($menu_id ,$menu_parent ,$menu_position ,$menu_title ,$menu_link ,$menu_cat ,$menu_confirm ,$menu_leftpanel ,$menu_iconpanel ,$menu_iconmenu ,$start,$end){
			//full query
			$query="select * from menus";
			
			if($menu_id!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " menu_id LIKE '%".$menu_id."%'";
			};
			if($menu_parent!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " menu_parent LIKE '%".$menu_parent."%'";
			};
			if($menu_position!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " menu_position LIKE '%".$menu_position."%'";
			};
			if($menu_title!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " menu_title LIKE '%".$menu_title."%'";
			};
			if($menu_link!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " menu_link LIKE '%".$menu_link."%'";
			};
			if($menu_cat!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " menu_cat LIKE '%".$menu_cat."%'";
			};
			if($menu_confirm!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " menu_confirm LIKE '%".$menu_confirm."%'";
			};
			if($menu_leftpanel!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " menu_leftpanel LIKE '%".$menu_leftpanel."%'";
			};
			if($menu_iconpanel!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " menu_iconpanel LIKE '%".$menu_iconpanel."%'";
			};
			if($menu_iconmenu!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " menu_iconmenu LIKE '%".$menu_iconmenu."%'";
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
		function menus_print($menu_id ,$menu_parent ,$menu_position ,$menu_title ,$menu_link ,$menu_cat ,$menu_confirm ,$menu_leftpanel ,$menu_iconpanel ,$menu_iconmenu ,$option,$filter){
			//full query
			$query="select * from menus";
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (menu_id LIKE '%".addslashes($filter)."%' OR menu_parent LIKE '%".addslashes($filter)."%' OR menu_position LIKE '%".addslashes($filter)."%' OR menu_title LIKE '%".addslashes($filter)."%' OR menu_link LIKE '%".addslashes($filter)."%' OR menu_cat LIKE '%".addslashes($filter)."%' OR menu_confirm LIKE '%".addslashes($filter)."%' OR menu_leftpanel LIKE '%".addslashes($filter)."%' OR menu_iconpanel LIKE '%".addslashes($filter)."%' OR menu_iconmenu LIKE '%".addslashes($filter)."%' )";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($menu_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " menu_id LIKE '%".$menu_id."%'";
				};
				if($menu_parent!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " menu_parent LIKE '%".$menu_parent."%'";
				};
				if($menu_position!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " menu_position LIKE '%".$menu_position."%'";
				};
				if($menu_title!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " menu_title LIKE '%".$menu_title."%'";
				};
				if($menu_link!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " menu_link LIKE '%".$menu_link."%'";
				};
				if($menu_cat!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " menu_cat LIKE '%".$menu_cat."%'";
				};
				if($menu_confirm!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " menu_confirm LIKE '%".$menu_confirm."%'";
				};
				if($menu_leftpanel!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " menu_leftpanel LIKE '%".$menu_leftpanel."%'";
				};
				if($menu_iconpanel!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " menu_iconpanel LIKE '%".$menu_iconpanel."%'";
				};
				if($menu_iconmenu!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " menu_iconmenu LIKE '%".$menu_iconmenu."%'";
				};
				$result = $this->db->query($query);
			}
			return $result;
		}
		
		//function  for export to excel
		function menus_export_excel($menu_id ,$menu_parent ,$menu_position ,$menu_title ,$menu_link ,$menu_cat ,$menu_confirm ,$menu_leftpanel ,$menu_iconpanel ,$menu_iconmenu ,$option,$filter){
			//full query
			$query="select * from menus";
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (menu_id LIKE '%".addslashes($filter)."%' OR menu_parent LIKE '%".addslashes($filter)."%' OR menu_position LIKE '%".addslashes($filter)."%' OR menu_title LIKE '%".addslashes($filter)."%' OR menu_link LIKE '%".addslashes($filter)."%' OR menu_cat LIKE '%".addslashes($filter)."%' OR menu_confirm LIKE '%".addslashes($filter)."%' OR menu_leftpanel LIKE '%".addslashes($filter)."%' OR menu_iconpanel LIKE '%".addslashes($filter)."%' OR menu_iconmenu LIKE '%".addslashes($filter)."%' )";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($menu_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " menu_id LIKE '%".$menu_id."%'";
				};
				if($menu_parent!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " menu_parent LIKE '%".$menu_parent."%'";
				};
				if($menu_position!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " menu_position LIKE '%".$menu_position."%'";
				};
				if($menu_title!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " menu_title LIKE '%".$menu_title."%'";
				};
				if($menu_link!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " menu_link LIKE '%".$menu_link."%'";
				};
				if($menu_cat!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " menu_cat LIKE '%".$menu_cat."%'";
				};
				if($menu_confirm!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " menu_confirm LIKE '%".$menu_confirm."%'";
				};
				if($menu_leftpanel!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " menu_leftpanel LIKE '%".$menu_leftpanel."%'";
				};
				if($menu_iconpanel!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " menu_iconpanel LIKE '%".$menu_iconpanel."%'";
				};
				if($menu_iconmenu!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " menu_iconmenu LIKE '%".$menu_iconmenu."%'";
				};
				$result = $this->db->query($query);
			}
			return $result;
		}
		

}
?>