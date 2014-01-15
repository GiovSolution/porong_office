<?php
/* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
    #songbee	mukhlisona@gmail.com
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: ganti password Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_tbl_ganti_pasword.php
 	+ Author  		: 
 	+ Created on 01/May/2009 06:35:27
	
*/

//class of tbl_m_warna
class C_gpass extends Controller {

	//constructor
	function C_gpass(){
		parent::Controller();
		session_start();
		$this->load->model('m_gpass', '', TRUE);
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_gpass');
	}
	
	function get(){
		$user_id=$_SESSION[SESSION_USERID];
		$result=$this->m_gpass->get($user_id);
		echo $result;
	}
	
	//function for update record
	function update(){
		//POST variable here
		$user_id=$_SESSION[SESSION_USERID];
		$user_passwdlama=trim(@$_POST["user_passwdlama"]);
		$user_passwdlama=str_replace("/(<\/?)(p)([^>]*>)", "",$user_passwdlama);
		$user_passwdlama=str_replace("'", '"',$user_passwdlama);
		
		$user_passwd=trim(@$_POST["user_passwd"]);
		$user_passwd=str_replace("/(<\/?)(p)([^>]*>)", "",$user_passwd);
		$user_passwd=str_replace("'", '"',$user_passwd);
		
		$result = $this->m_gpass->update_users($user_id, $user_passwd, $user_passwdlama );
		echo $result;
	}
	
	
	// Encodes a SQL array into a JSON formated string
	function JEncode($arr){
		if (version_compare(PHP_VERSION,"5.2","<"))
		{    
			require_once("./JSON.php"); //if php<5.2 need JSON class
			$json = new Services_JSON();//instantiate new json object
			$data=$json->encode($arr);  //encode the data in json format
		} else {
			$data = json_encode($arr);  //encode the data in json format
		}
		return $data;
	}
	
	// Encodes a YYYY-MM-DD into a MM-DD-YYYY string
	function codeDate ($date) {
	  $tab = explode ("-", $date);
	  $r = $tab[1]."/".$tab[2]."/".$tab[0];
	  return $r;
	}
	
}
?>