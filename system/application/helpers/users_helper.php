<?

function get_user_group(){
	return $_SESSION[SESSION_GROUPID];
}

function get_sales_group(){
	$sql="select user_id from tbl_users where user_manager='".$_SESSION[SESSION_USERID]."'";
	$query=$this->db->query($sql);
	$rs=$query->result_array();
	return $rs;
}

function get_access_group($group_id,$form_id){
	$sql="select perm_priv from tbl_permissions where perm_group='".$group_id."' and  perm_menu='".$form_id."'";
	$query=$this->db->query($sql);
	if ($query->num_rows() > 0)
	{
   		$row = $query->row();
		return $row->perm_priv;
	}else
		return "";
}
?>