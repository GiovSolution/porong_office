<? /* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
    #songbee	mukhlisona@gmail.com
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: penerimaan_invoice Model
	+ Description	: For record model process back-end
	+ Filename 		: c_penerimaan_invoice.php
 	+ Author  		: Zainal, Mukhlison
 	+ Created on 11/Jul/2009 06:46:58
	
*/

class M_penerimaan_invoice extends Model{
		
		//constructor
		function M_penerimaan_invoice() {
			parent::Model();
		}
		
		//function for get list record
		function penerimaan_invoice_list($filter,$start,$end){
			$query = "SELECT * FROM penerimaan_invoice";
			
			// For simple search
			if ($filter<>""){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (invoice_id LIKE '%".addslashes($filter)."%' OR invoice_no LIKE '%".addslashes($filter)."%' OR invoice_supplier LIKE '%".addslashes($filter)."%' OR invoice_noorder LIKE '%".addslashes($filter)."%' OR invoice_tanggal LIKE '%".addslashes($filter)."%' OR invoice_nilai LIKE '%".addslashes($filter)."%' )";
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
		function penerimaan_invoice_update($invoice_id ,$invoice_no ,$invoice_supplier ,$invoice_noorder ,$invoice_tanggal ,$invoice_nilai ){
			$data = array(
				"invoice_id"=>$invoice_id,			
				"invoice_no"=>$invoice_no,			
				"invoice_supplier"=>$invoice_supplier,			
				"invoice_noorder"=>$invoice_noorder,			
				"invoice_tanggal"=>$invoice_tanggal,			
				"invoice_nilai"=>$invoice_nilai			
			);
			$this->db->where('invoice_id', $invoice_id);
			$this->db->update('penerimaan_invoice', $data);
			
			if($this->db->affected_rows())
				return '1';
			else
				return '0';
		}
		
		//function for create new record
		function penerimaan_invoice_create($invoice_no ,$invoice_supplier ,$invoice_noorder ,$invoice_tanggal ,$invoice_nilai ){
			$data = array(
	
				"invoice_no"=>$invoice_no,	
				"invoice_supplier"=>$invoice_supplier,	
				"invoice_noorder"=>$invoice_noorder,	
				"invoice_tanggal"=>$invoice_tanggal,	
				"invoice_nilai"=>$invoice_nilai	
			);
			$this->db->insert('penerimaan_invoice', $data); 
			if($this->db->affected_rows())
				return '1';
			else
				return '0';
		}
		
		//fcuntion for delete record
		function penerimaan_invoice_delete($pkid){
			// You could do some checkups here and return '0' or other error consts.
			// Make a single query to delete all of the penerimaan_invoices at the same time :
			if(sizeof($pkid)<1){
				return '0';
			} else if (sizeof($pkid) == 1){
				$query = "DELETE FROM penerimaan_invoice WHERE invoice_id = ".$pkid[0];
				$this->db->query($query);
			} else {
				$query = "DELETE FROM penerimaan_invoice WHERE ";
				for($i = 0; $i < sizeof($pkid); $i++){
					$query = $query . "invoice_id= ".$pkid[$i];
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
		function penerimaan_invoice_search($invoice_id ,$invoice_no ,$invoice_supplier ,$invoice_noorder ,$invoice_tanggal ,$invoice_nilai ,$start,$end){
			//full query
			$query="select * from penerimaan_invoice";
			
			if($invoice_id!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " invoice_id LIKE '%".$invoice_id."%'";
			};
			if($invoice_no!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " invoice_no LIKE '%".$invoice_no."%'";
			};
			if($invoice_supplier!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " invoice_supplier LIKE '%".$invoice_supplier."%'";
			};
			if($invoice_noorder!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " invoice_noorder LIKE '%".$invoice_noorder."%'";
			};
			if($invoice_tanggal!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " invoice_tanggal LIKE '%".$invoice_tanggal."%'";
			};
			if($invoice_nilai!=''){
				$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
				$query.= " invoice_nilai LIKE '%".$invoice_nilai."%'";
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
		function penerimaan_invoice_print($invoice_id ,$invoice_no ,$invoice_supplier ,$invoice_noorder ,$invoice_tanggal ,$invoice_nilai ,$option,$filter){
			//full query
			$query="select * from penerimaan_invoice";
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (invoice_id LIKE '%".addslashes($filter)."%' OR invoice_no LIKE '%".addslashes($filter)."%' OR invoice_supplier LIKE '%".addslashes($filter)."%' OR invoice_noorder LIKE '%".addslashes($filter)."%' OR invoice_tanggal LIKE '%".addslashes($filter)."%' OR invoice_nilai LIKE '%".addslashes($filter)."%' )";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($invoice_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " invoice_id LIKE '%".$invoice_id."%'";
				};
				if($invoice_no!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " invoice_no LIKE '%".$invoice_no."%'";
				};
				if($invoice_supplier!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " invoice_supplier LIKE '%".$invoice_supplier."%'";
				};
				if($invoice_noorder!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " invoice_noorder LIKE '%".$invoice_noorder."%'";
				};
				if($invoice_tanggal!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " invoice_tanggal LIKE '%".$invoice_tanggal."%'";
				};
				if($invoice_nilai!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " invoice_nilai LIKE '%".$invoice_nilai."%'";
				};
				$result = $this->db->query($query);
			}
			return $result;
		}
		
		//function  for export to excel
		function penerimaan_invoice_export_excel($invoice_id ,$invoice_no ,$invoice_supplier ,$invoice_noorder ,$invoice_tanggal ,$invoice_nilai ,$option,$filter){
			//full query
			$query="select * from penerimaan_invoice";
			if($option=='LIST'){
				$query .=eregi("WHERE",$query)? " AND ":" WHERE ";
				$query .= " (invoice_id LIKE '%".addslashes($filter)."%' OR invoice_no LIKE '%".addslashes($filter)."%' OR invoice_supplier LIKE '%".addslashes($filter)."%' OR invoice_noorder LIKE '%".addslashes($filter)."%' OR invoice_tanggal LIKE '%".addslashes($filter)."%' OR invoice_nilai LIKE '%".addslashes($filter)."%' )";
				$result = $this->db->query($query);
			} else if($option=='SEARCH'){
				if($invoice_id!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " invoice_id LIKE '%".$invoice_id."%'";
				};
				if($invoice_no!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " invoice_no LIKE '%".$invoice_no."%'";
				};
				if($invoice_supplier!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " invoice_supplier LIKE '%".$invoice_supplier."%'";
				};
				if($invoice_noorder!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " invoice_noorder LIKE '%".$invoice_noorder."%'";
				};
				if($invoice_tanggal!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " invoice_tanggal LIKE '%".$invoice_tanggal."%'";
				};
				if($invoice_nilai!=''){
					$query.=eregi("WHERE",$query)?" AND ":" WHERE ";
					$query.= " invoice_nilai LIKE '%".$invoice_nilai."%'";
				};
				$result = $this->db->query($query);
			}
			return $result;
		}
		

}
?>