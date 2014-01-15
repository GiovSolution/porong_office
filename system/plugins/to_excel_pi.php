<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
* Excel library for Code Igniter applications
* Author: Derek Allard, Dark Horse Consulting, www.darkhorse.to, April 2006
*/

function to_excel($query, $filename='exceloutput')
{
     $headers = ''; // just creating the var for field headers to append to below
     $data = ''; // just creating the var for field data to append to below
     $file=fopen("export2excel.php",'w');
	 
     $obj =& get_instance();
     $ftype=array();
	 
     $fields = $query->field_data();
     if ($query->num_rows() == 0) {
          echo '<p>The table appears to have no data.</p>';
     } else {
          foreach ($fields as $field) {
             $headers .= ucwords(str_replace("_"," ",$field->name)). "\t";
			 $ftype[]=$field->type;
          }

          foreach ($query->result() as $row) {
               $line = '';
			   $i=0;
               foreach($row as $value) {                                            
                    if ((!isset($value)) OR ($value == "")) {
                         $value = " \t";
                    } else {
                        $value = str_replace('"', '\"', $value);

						if($ftype[$i]=="date")
							$value=convertDate($value);
                         
						 $value = '' . strip_tags(html_entity_decode($value)) . '' . "\t";
						
                    }
                    $line .= $value;
					$i++;
               }
               $data .= trim($line)."\n";
          }
          
          $data = str_replace("\r","",$data);
          $isi="<?php ";               
          $isi.="header(\"Content-type: application/x-msdownload\"); \n";
          $isi.="header(\"Content-Disposition: attachment; filename=$filename.xls\"); \n";
          $isi.="echo \"$headers\n$data\";";
		  $isi.="?>";
		  fwrite($file,$isi);
		  fclose($file);
     }
}

function convertDate ($date) {
  $tab = explode ("-", $date);
  $r = $tab[1]."/".$tab[2]."/".$tab[0];
  return $r;
}

?> 