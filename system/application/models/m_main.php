<?php 

class M_main extends Model{

	function M_main(){
		parent::Model();
	}

	function get_menus(){
		if($_SESSION[SESSION_USERID]==='Super Admin')
			$sql="SELECT * FROM menus P 
					WHERE P.menu_parent=0 
					ORDER BY P.menu_position ASC";
		else
			$sql="SELECT * FROM menus P 
					WHERE P.menu_parent=0 
					AND P.menu_id IN(SELECT C.menu_parent FROM vu_menus C
									 WHERE C.menu_parent=P.menu_id
									 AND C.group_id='".$_SESSION[SESSION_GROUPID]."')
					ORDER BY P.menu_position ASC";
	
		$query=$this->db->query($sql);
		$rs=$query->result_array();
		return $rs;
	}
	
	
	function get_background(){
		$background="";
		$sql="select info_background from info";
		$query=$this->db->query($sql);
		if($query->num_rows()){
			$rs=$query->row();
			$background=$rs->info_background;
		}
		return $background;
	}	
	
	
	function get_sub_menus(){
		if($_SESSION[SESSION_USERID]==='Super Admin')
			$sql="select * from menus where menu_parent<>0 order by menu_parent,menu_position asc";
		else
			$sql="select * from vu_menus where group_id='".$_SESSION[SESSION_GROUPID]."' and menu_parent<>0 order by menu_parent,menu_position asc ";
		$query=$this->db->query($sql);
		$rs=$query->result_array();
		return $rs;
	}
	
	function get_shortcuts(){
		if($_SESSION[SESSION_USERID]==='Super Admin')
			$sql="select * from menus where menu_parent<>0 and menu_leftpanel='Y' order by menu_parent,menu_position asc";
		else
			$sql="select * from vu_menus where menu_parent<>0 and group_id='".$_SESSION[SESSION_GROUPID]."' and menu_leftpanel='Y' order by menu_parent,menu_position asc ";
		$query=$this->db->query($sql);
		$rs=$query->result_array();
		return $rs;
	}
	
	
}
?>