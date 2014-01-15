<?php 

class M_security extends Model{

	function M_security(){
		parent::Model();
	}

	function get_user_group(){
		return $_SESSION[SESSION_GROUPID];
	}

	function get_access_group($group_id,$form_id){
		
		if($_SESSION[SESSION_USERID]=='Super Admin'){
			return 'RCUDP';
		}else{
			
		$sql="select perm_priv from permissions where perm_group='".$group_id."' and  perm_menu='".$form_id."'";
		$query=$this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			return $row->perm_priv;
		}else
			return "";
		
		}
	}
	
	function get_access_group_by_kode($form_kode){
		
		if($_SESSION[SESSION_USERID]=='Super Admin'){
			return 'RCUDP';
		}else{
				
			$sql="select perm_priv from vu_permissions where perm_group='".$_SESSION[SESSION_GROUPID]."' and  menu_kode='".$form_kode."'";
			$query=$this->db->query($sql);
			if ($query->num_rows() > 0)
			{
				$row = $query->row();
				return $row->perm_priv;
			}else
				return "";
		}
		//$this->firephp->log($sql);
	}	
}
?>