<? /* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com,
    #songbee	mukhlisona@gmail.com
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id

	+ Module  		: users Model
	+ Description	: For record model process back-end
	+ Filename 		: c_users.php
 	+ Author  		: zainal, mukhlison
 	+ Created on 16/Jul/2009 15:35:27

*/

class M_users extends Model{

		//constructor
		function M_users() {
			parent::Model();
		}

		//function for get list record
		function users_list($filter,$start,$end){
			$query = "SELECT * FROM users,karyawan,usergroups WHERE user_karyawan=karyawan_id AND user_groups=group_id";

			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (user_name LIKE '%".addslashes($filter)."%' OR
							 karyawan_nama LIKE '%".addslashes($filter)."%' OR
							 group_name LIKE '%".addslashes($filter)."%' )";
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
		function users_update($user_id ,$user_name ,$user_passwd ,$user_karyawan,$user_groups ,$user_aktif ){
		//function users_update($user_id, $user_name, $user_karyawan, $user_log, $user_groups, $user_aktif ){
			if ($user_aktif=="")
				$user_aktif = "Aktif";

			$data = array(
				"user_id"=>$user_id,
				"user_name"=>$user_name,
				//"user_passwd"=>md5($user_passwd),
				"user_aktif"=>$user_aktif
			);

			$sql="SELECT karyawan_id FROM karyawan WHERE karyawan_id='".$user_karyawan."'";
			$rs=$this->db->query($sql);
			if($rs->num_rows())
				$data["user_karyawan"]=$user_karyawan;
			if($user_passwd!=="")
				$data["user_passwd"]=md5($user_passwd);

			$sql="SELECT group_id FROM usergroups WHERE group_id='".$user_groups."'";
			$rs=$this->db->query($sql);
			if($rs->num_rows())
				$data["user_groups"]=$user_groups;

			$this->db->where('user_id', $user_id);
			$this->db->update('users', $data);
			return '1';
			//return $this->db->last_query();
		}

		//function for create new record
		function users_create($user_name ,$user_passwd ,$user_karyawan ,$user_log ,$user_groups ,$user_aktif ){
		if ($user_aktif=="")
			$user_aktif = "Aktif";
			$data = array(

				"user_name"=>$user_name,
				"user_passwd"=>md5($user_passwd),
				"user_karyawan"=>$user_karyawan,
				"user_log"=>$user_log,
				"user_groups"=>$user_groups,
				"user_aktif"=>$user_aktif
			);
			$this->db->insert('users', $data);
			if($this->db->affected_rows())
				return '1';
			else
				return '0';
		}

		//fcuntion for delete record
		function users_delete($pkid){
			// You could do some checkups here and return '0' or other error consts.
			// Make a single query to delete all of the userss at the same time :
			if(sizeof($pkid)<1){
				return '0';
			} else if (sizeof($pkid) == 1){
				$query = "DELETE FROM users WHERE user_id = ".$pkid[0];
				$this->db->query($query);
			} else {
				$query = "DELETE FROM users WHERE ";
				for($i = 0; $i < sizeof($pkid); $i++){
					$query = $query . "user_id= ".$pkid[$i];
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
		function users_search($user_id ,$user_name,$user_karyawan ,$user_log ,$user_groups ,$user_aktif ,$start,$end){
			//full query
			$query = "SELECT * FROM users,karyawan,usergroups WHERE user_karyawan=karyawan_id AND user_groups=group_id";

			if($user_name!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " user_name LIKE '%".$user_name."%'";
			};
			if($user_karyawan!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " user_karyawan = '".$user_karyawan."'";
			};

			if($user_groups!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " user_groups ='".$user_groups."'";
			};
			if($user_aktif!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " user_aktif LIKE '%".$user_aktif."%'";
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
		function users_print($user_id ,$user_name  ,$user_karyawan ,$user_log ,$user_groups ,$user_aktif ,$option,$filter){
			//full query
			$query = "SELECT * FROM users,karyawan,usergroups WHERE user_karyawan=karyawan_id AND user_groups=group_id";

			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (user_name LIKE '%".addslashes($filter)."%' OR
							 karyawan_nama LIKE '%".addslashes($filter)."%' OR
							 group_name LIKE '%".addslashes($filter)."%' )";

			} else if($option=='SEARCH'){
				if($user_name!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " user_name LIKE '%".$user_name."%'";
				};
				if($user_karyawan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " user_karyawan = '".$user_karyawan."'";
				};

				if($user_groups!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " user_groups = '".$user_groups."'";
				};
				if($user_aktif!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " user_aktif LIKE '%".$user_aktif."%'";
				};
			}
			$result = $this->db->query($query);
			return $result;
		}

		//function  for export to excel
		function users_export_excel($user_id ,$user_name ,$user_karyawan ,$user_log ,$user_groups ,$user_aktif ,$option,$filter){
			//full query
			$query="SELECT user_name as Username, karyawan_nama as 'Nama Karyawan',  group_name as 'Group', user_aktif as Aktif
					FROM users,karyawan,usergroups WHERE user_karyawan=karyawan_id AND user_groups=group_id";
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (user_name LIKE '%".addslashes($filter)."%' OR
							 karyawan_nama LIKE '%".addslashes($filter)."%' OR
							 group_name LIKE '%".addslashes($filter)."%' )";

			} else if($option=='SEARCH'){

				if($user_name!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " user_name LIKE '%".$user_name."%'";
				};
				if($user_karyawan!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " user_karyawan = '".$user_karyawan."'";
				};

				if($user_groups!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " user_groups = '".$user_groups."'";
				};
				if($user_aktif!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " user_aktif LIKE '%".$user_aktif."%'";
				};
			}
			$result = $this->db->query($query);
			return $result;
		}


}
?>