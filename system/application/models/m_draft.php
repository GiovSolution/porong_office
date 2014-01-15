<? /* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
    #songbee	mukhlisona@gmail.com
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: draft Model
	+ Description	: For record model process back-end
	+ Filename 		: c_draft.php
 	+ Author  		: 
 	+ Created on 01/Feb/2010 14:30:05
	
*/

class M_draft extends Model{
		
		var $bulan=array('Januari','Pebruari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember');
		//constructor
		function M_draft() {
			parent::Model();
		}
		
		//function for get list record
		function draft_list($filter,$start,$end){
			$query = "SELECT * FROM draft ";

			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (draft_message LIKE '%".addslashes($filter)."%'  )";
			}
			
			$query .= ' ORDER BY draft_id desc';
			
			$result = $this->db->query($query);
			$nbrows = $result->num_rows();
			$limit = $query." LIMIT ".$start.",".$end;		
			$result = $this->db->query($limit);  
			//$this->firephp->log($query);
			if($nbrows>0){
				$i=0;
				foreach($result->result() as $row){
					$arr[$i]["draft_id"]=$row->draft_id;

// yg disimpan cukup msg nya saja. by hendri 2010-06-16					
/*					$arr[$i]["draft_jenis"]=ucwords($row->draft_jenis);
					if($row->draft_jenis=='group'){
						$sql="select phonegroup_nama from phonegroup where phonegroup_id='".$row->draft_destination."'";
						$query=$this->db->query($sql);
						if($query->num_rows())
						{
							$ds=$query->row();
							$arr[$i]["draft_destination_view"]=$ds->phonegroup_nama;
						}else{
							$arr[$i]["draft_destination_view"]="";
						}
						$arr[$i]["draft_destination"]=$ds->phonegroup_nama;
						$arr[$i]["draft_destination_tglawal"]="";
						$arr[$i]["draft_destination_blnawal"]="";
						$arr[$i]["draft_destination_tglakhir"]="";
						$arr[$i]["draft_destination_blnakhir"]="";
					}else if($row->draft_jenis=='number'){
						$arr[$i]["draft_destination_view"]=$row->draft_destination;
						$arr[$i]["draft_destination"]=$row->draft_destination;
						$arr[$i]["draft_destination_tglawal"]="";
						$arr[$i]["draft_destination_blnawal"]="";
						$arr[$i]["draft_destination_tglakhir"]="";
						$arr[$i]["draft_destination_blnakhir"]="";
					}else if($row->draft_jenis=='semua'){
						$arr[$i]["draft_destination_view"]=$row->draft_destination;
						$arr[$i]["draft_destination"]=$row->draft_destination;
						$arr[$i]["draft_destination_tglawal"]="";
						$arr[$i]["draft_destination_blnawal"]="";
						$arr[$i]["draft_destination_tglakhir"]="";
						$arr[$i]["draft_destination_blnakhir"]="";
					}else if($row->draft_jenis=='kelamin'){
						$arr[$i]["draft_destination_view"]=($row->draft_destination=='P'?'Perempuan':'Laki-laki');
						$arr[$i]["draft_destination"]=$row->draft_destination;
						$arr[$i]["draft_destination_tglawal"]="";
						$arr[$i]["draft_destination_blnawal"]="";
						$arr[$i]["draft_destination_tglakhir"]="";
						$arr[$i]["draft_destination_blnakhir"]="";
					}else if($row->draft_jenis=='ultah'){
						$tgl_awal=substr($row->draft_destination,3,2);
						$bln_awal=substr($row->draft_destination,0,2);
						$tgl_akhir=substr($row->draft_destination,11,2);
						$bln_akhir=substr($row->draft_destination,8,2);
						
						$arr[$i]["draft_destination_view"]='Tanggal: '.$tgl_awal."-".$this->bulan[((int)$bln_awal)-1]." s/d ".$tgl_akhir."-".$this->bulan[((int)$bln_akhir)-1];
						$arr[$i]["draft_destination"]=$row->draft_destination;
						$arr[$i]["draft_destination_blnawal"]=$bln_awal;
						$arr[$i]["draft_destination_tglawal"]=$tgl_awal;
						$arr[$i]["draft_destination_blnakhir"]=$bln_akhir;
						$arr[$i]["draft_destination_tglakhir"]=$tgl_akhir;
					}else if($row->draft_jenis=='member'){
						if(eregi('Expired',$row->draft_destination)){
							$dst_exp=split(":",$row->draft_destination);
							$dst_tgl=$dst_exp[1];
							$arr[$i]["draft_destination_view"]='Expired: '.substr($dst_tgl,0,10)." s/d ".substr($dst_tgl,13,10);
							$arr[$i]["draft_destination"]=$dst_exp[0];
							$arr[$i]["draft_destination_tglawal"]=substr($dst_tgl,0,10);
							$arr[$i]["draft_destination_blnawal"]="";
							$arr[$i]["draft_destination_tglakhir"]=substr($dst_tgl,13,10);
							$arr[$i]["draft_destination_blnakhir"]="";
						}else{
							$arr[$i]["draft_destination_view"]=$row->draft_destination;
							$arr[$i]["draft_destination"]=$row->draft_destination;
							$arr[$i]["draft_destination_tglawal"]="";
							$arr[$i]["draft_destination_blnawal"]="";
							$arr[$i]["draft_destination_tglakhir"]="";
							$arr[$i]["draft_destination_blnakhir"]="";
						}
					}
*/					
					$arr[$i]["draft_message"]=$row->draft_message;
					$arr[$i]["draft_date"]=$row->draft_date;
					$arr[$i]["draft_creator"]=$row->draft_creator;
					$arr[$i]["draft_date_create"]=$row->draft_date_create;
					$arr[$i]["draft_update"]=$row->draft_update;
					$arr[$i]["draft_date_update"]=$row->draft_date_update;
					$arr[$i]["draft_revised"]=$row->draft_revised;
					$i++;
				}
				if(sizeof($arr)>0){ 
					$jsonresult = json_encode($arr);
					return '({"total":"'.$nbrows.'","results":'.$jsonresult.'})';
				}else{
					return '({"total":"0", "results":""})';
				}
			} else {
				return '({"total":"0", "results":""})';
			}
		}
		
		//function for create new record
		function draft_create($draft_destination ,$draft_message ,$draft_date ,$draft_creator ,$draft_date_create ){
			$data = array(
				"draft_destination"=>$draft_destination, 
				"draft_message"=>$draft_message, 
				"draft_date"=>$draft_date, 
				"draft_creator"=>$_SESSION[SESSION_USERID], 
				"draft_date_create"=>date('Y-m-d H:i:s')	
			);
			$this->db->insert('draft', $data); 
			if($this->db->affected_rows())
				return '1';
			else
				return '0';
		}
		
		//function for update record
		function draft_update($idraft_id,$idraft_dest,$idraft_isi,$idraft_opsi,$idraft_task,$draft_update,$draft_date_update){
			$data = array(
				"draft_jenis"=>$idraft_opsi,
				"draft_message"=>$idraft_isi, 
				"draft_update"=>$_SESSION[SESSION_USERID], 
				"draft_date_update"=>date('Y-m-d H:i:s') 
			);
			
			if($idraft_opsi=="group"){
				$sql="select phonegroup_id from phonegroup where phonegroup_id='".$idraft_dest."'";
				$query=$this->db->query($sql);
				if($query->num_rows())
					$data["draft_destination"]=$idraft_dest;
			}else{
				$data["draft_destination"]=$idraft_dest;
			}
			
			$this->db->where('draft_id', $idraft_id);
			$this->db->update('draft', $data);
			//echo $this->db->last_query();
			$sql="UPDATE draft set draft_revised=(draft_revised+1) where draft_id='".$idraft_id."'";
			$this->db->query($sql);
			return '1';
		}
		
		//fcuntion for delete record
		function draft_delete($pkid){
			// You could do some checkups here and return '0' or other error consts.
			// Make a single query to delete all of the drafts at the same time :
			if(sizeof($pkid)<1){
				return '0';
			} else if (sizeof($pkid) == 1){
				$query = "DELETE FROM draft WHERE draft_id = ".$pkid[0];
				$this->db->query($query);
			} else {
				$query = "DELETE FROM draft WHERE ";
				for($i = 0; $i < sizeof($pkid); $i++){
					$query = $query . "draft_id= ".$pkid[$i];
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
		function draft_search($draft_id ,$draft_destination ,$draft_message ,$draft_date ,$draft_creator ,$draft_date_create ,$draft_update ,
							  $draft_date_update ,$draft_revised ,$start,$end){
			//full query
			$query="select * from draft";
			
			
			if($draft_message!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " draft_message LIKE '%".$draft_message."%'";
			};
			if($draft_date!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " draft_date LIKE '%".$draft_date."%'";
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
		function draft_print($draft_id ,$draft_destination, $draft_jenis ,$draft_message ,$draft_date ,$draft_creator ,$draft_date_create ,
							 $draft_update ,$draft_date_update ,$draft_revised ,$option,$filter){
			//full query
			$sql="select * from draft";
			if($option=='LIST'){
				$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
				$sql .= " (draft_message LIKE '%".addslashes($filter)."%' )";
			} else if($option=='SEARCH'){
				
				if($draft_message!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " draft_message LIKE '%".$draft_message."%'";
				};
				if($draft_date!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " draft_date LIKE '%".$draft_date."%'";
				};
				
			}
			$query = $this->db->query($sql);
			return $query->result();
		}
		
		//function  for export to excel
		function draft_export_excel($draft_id ,$draft_destination, $draft_jenis ,$draft_message ,$draft_date ,$draft_creator ,$draft_date_create ,
									$draft_update ,$draft_date_update ,$draft_revised ,$option,$filter){
			//full query
			$sql="select draft_date as Tanggal, draft_message as 'Isi Pesan' from draft";
			if($option=='LIST'){
				$sql .=eregi("WHERE",$sql)? " AND ":" WHERE ";
				$sql .= " (draft_message LIKE '%".addslashes($filter)."%' )";
			} else if($option=='SEARCH'){
				
				if($draft_message!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " draft_message LIKE '%".$draft_message."%'";
				};
				if($draft_date!=''){
					$sql.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$sql.= " draft_date LIKE '%".$draft_date."%'";
				};
				
			}
			$query = $this->db->query($sql);
			return $query;
		}
		
}
?>