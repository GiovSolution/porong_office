<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function terbilang($num) {
  $digits = array(
    0 => "nol",
    1 => "satu",
    2 => "dua",
    3 => "tiga", 
    4 => "empat",
    5 => "lima",
    6 => "enam",
    7 => "tujuh",
    8 => "delapan",
    9 => "sembilan");
  $orders = array(
     0 => "",
     1 => "puluh",
     2 => "ratus",
     3 => "ribu",
     6 => "juta",
     9 => "miliar",
    12 => "triliun",
    15 => "kuadriliun");

  $is_neg = $num < 0; $num = "$num";

  //// angka di kiri desimal

  $int = ""; if (preg_match("/^[+-]?(\d+)/", $num, $m)) $int = $m[1];
  $mult = 0; $wint = "";

  // ambil ribuan/jutaan/dst
  while (preg_match('/(\d{1,3})$/', $int, $m)) {
    
    // ambil satuan, puluhan, dan ratusan
    $s = $m[1] % 10; 
    $p = ($m[1] % 100 - $s)/10;
    $r = ($m[1] - $p*10 - $s)/100;
    
    // konversi ratusan
    if ($r==0) $g = "";
    elseif ($r==1) $g = "se$orders[2]";
    else $g = $digits[$r]." $orders[2]";
    
    // konversi puluhan dan satuan
    if ($p==0) {
      if ($s==0);
      elseif ($s==1) $g = ($g ? "$g ".$digits[$s] :
                                ($mult==0 ? $digits[1] : "se"));
      else $g = ($g ? "$g ":"") . $digits[$s];
    } elseif ($p==1) {
      if ($s==0) $g = ($g ? "$g ":"") . "se$orders[1]";
      elseif ($s==1) $g = ($g ? "$g ":"") . "sebelas";
      else $g = ($g ? "$g ":"") . $digits[$s] . " belas";
    } else {
      $g = ($g ? "$g ":"").$digits[$p]." puluh".
           ($s > 0 ? " ".$digits[$s] : "");
    }

    // gabungkan dengan hasil sebelumnya
    $wint = ($g ? $g.($g=="se" ? "":" ").$orders[$mult]:"").
            ($wint ? " $wint":""); 
    
    // pangkas ribuan/jutaan/dsb yang sudah dikonversi
    $int = preg_replace('/\d{1,3}$/', '', $int);
    $mult+=3;
  }
  if (!$wint) $wint = $digits[0];
  
  //// angka di kanan desimal

  $frac = ""; if (preg_match("/\.(\d+)/", $num, $m)) $frac = $m[1];
  $wfrac = "";
  for ($i=0; $i<strlen($frac); $i++) {
    $wfrac .= ($wfrac ? " ":"").$digits[substr($frac,$i,1)];
  }
  
  return ($is_neg ? "minus ":"").$wint.($wfrac ? " koma $wfrac":"");
}


function ubah_rupiah($string) 
  { 

   $Negative = 0; 
       
   //check to see if number is negative 
    if(preg_match("/^-/",$string)) 
    { 
     //setflag 
     $Negative = 1; 
     //remove negative sign 
     $string = preg_replace("|-|","",$string); 
    } 

   //look for commas in the string and remove them.     
   $string = preg_replace("|,|","",$string); 
    
   // split the string into two parts First and Second 
   // First is before decimal, second is after. format = First.Second 
   $Full = split("[.]",$string); 
   
   $Count = count($Full); 
     
   if($Count > 1) 
   { 
    $First = $Full[0]; 
    $Second = $Full[1]; 
     $NumCents = strlen($Second); 
      if($NumCents == 2) 
       { 
           //do nothing already at correct length 
       } 
      else if($NumCents < 2) 
       { 
           //add an extra zero to the end 
           $Second = $Second . "0"; 
       } 
      else if($NumCents > 2) 
       { 
           //either string off the end digits or round up 
           // I say string everything but the first 3 digits and then round 
        // since it is rare that anything after 3 digits effects the round 
        // you can change if you need greater accurcy, I don't so I didn't 
           // write that into the code. 
           $Temp = substr($Second,0,3); 
           $Rounded = round($Temp,-1); 
           $Second = substr($Rounded,0,2); 
            
       }   

   } 
   else 
   { 
    //there was no decimal on the end so add to zeros     
    $First = $Full[0];     
    $Second = "00"; 
   } 

  $length = strlen($First); 

  if( $length <= 3 ) 
    { 
     //To Short to add a comma 
    //combine the first part and the second. 
    $string = $First . "." . $Second;     

    if($Negative == 1) 
     {     
      $string = "-" . $string; 
     } 

    return $string; 
    } 
  else 
    { 
    $loop_count = intval( ( $length / 3 ) ); 
    $section_length = -3; 
    for( $i = 0; $i < $loop_count; $i++ ) 
      { 
      $sections[$i] = substr( $First, $section_length, 3 ); 
      $section_length = $section_length - 3; 
      } 

    $stub = ( $length % 3 );     
    if( $stub != 0 ) 
      { 
      $sections[$i] = substr( $First, 0, $stub ); 
      } 
    $Done = implode( ".", array_reverse( $sections ) ); 
    $Done = $Done . "," . $Second; 

    if($Negative == 1) 
     {     
      $Done = "-" . $Done; 
     } 

    return  $Done; 
    } 
  } 
 
function to_money($string) 
  { 

   $Negative = 0; 
       
   //check to see if number is negative 
    if(preg_match("/^-/",$string)) 
    { 
     //setflag 
     $Negative = 1; 
     //remove negative sign 
     $string = preg_replace("|-|","",$string); 
    } 

   //look for commas in the string and remove them.     
   $string = preg_replace("|,|","",$string); 
    
   // split the string into two parts First and Second 
   // First is before decimal, second is after. format = First.Second 
   $Full = split("[.]",$string); 
   
   $Count = count($Full); 
     
   if($Count > 1) 
   { 
    $First = $Full[0]; 
    $Second = $Full[1]; 
     $NumCents = strlen($Second); 
      if($NumCents == 2) 
       { 
           //do nothing already at correct length 
       } 
      else if($NumCents < 2) 
       { 
           //add an extra zero to the end 
           $Second = $Second . "0"; 
       } 
      else if($NumCents > 2) 
       { 
           //either string off the end digits or round up 
           // I say string everything but the first 3 digits and then round 
        // since it is rare that anything after 3 digits effects the round 
        // you can change if you need greater accurcy, I don't so I didn't 
           // write that into the code. 
           $Temp = substr($Second,0,3); 
           $Rounded = round($Temp,-1); 
           $Second = substr($Rounded,0,2); 
            
       }   

   } 
   else 
   { 
    //there was no decimal on the end so add to zeros     
    $First = $Full[0];     
    $Second = "00"; 
   } 

  $length = strlen($First); 

  if( $length <= 3 ) 
    { 
     //To Short to add a comma 
    //combine the first part and the second. 
    $string = $First . "." . $Second;     

    if($Negative == 1) 
     {     
      $string = "-" . $string; 
     } 

    return $string; 
    } 
  else 
    { 
    $loop_count = intval( ( $length / 3 ) ); 
    $section_length = -3; 
    for( $i = 0; $i < $loop_count; $i++ ) 
      { 
      $sections[$i] = substr( $First, $section_length, 3 ); 
      $section_length = $section_length - 3; 
      } 

    $stub = ( $length % 3 );     
    if( $stub != 0 ) 
      { 
      $sections[$i] = substr( $First, 0, $stub ); 
      } 
    $Done = implode( ".", array_reverse( $sections ) ); 
    $Done = $Done . "," . $Second; 

    if($Negative == 1) 
     {     
      $Done = "-" . $Done; 
     } 

    return  $Done; 
    } 
  } 
function rupiah($angka){
	/*$rupiah="";
	$rp=strlen($angka);
	while ($rp>3){
		$rupiah = ".". substr($angka,-3). $rupiah;
		$s=strlen($angka) - 3;
		$angka=substr($angka,0,$s);
		$rp=strlen($angka);
	}
	//$rupiah = "Rp." . $angka . $rupiah . ",00-";
	$rupiah = $angka . $rupiah;
	return $rupiah;*/
	$rupiah="";
	$rupiah=number_format($angka,0,"",".");
	return $rupiah;
}
?>
