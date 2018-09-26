



<?php

include '../../pass.php';




function zamena_simvolov($text) {
   $translation = array(
      '(' => '',
      ')' => '',
      '[' => '',
      ']' => '',
      '{' => '',
      '}' => '',
      '^' => '',
      '$' => '',
      '|' => '',
      '+' => '',
      '.' => '',
      '*' => '',
      '?' => '',
      '!' => '',
      '\\' => '',
      ':' => '',
      ';' => '',
      '<' => '',
      '>' => '',
      '&' => '',
      '#' => '',
      '\'' => '',
      '\"' => '',
      );
   
      return strtr($text, $translation); 
}





$doska_tekst_id_post = $_POST["doska_tekst_id"];
$doska_kat_id_post = $_POST["doska_kat_id"];

$doska_tekst_id_post = zamena_simvolov($doska_tekst_id_post);
substr($doska_tekst_id_post,0,8);
strip_tags($doska_tekst_id_post); 


$doska_kat_id_post = zamena_simvolov($doska_kat_id_post);
substr($doska_kat_id_post,0,4);
strip_tags($doska_kat_id_post); 

      
 







   
   $query = "SET character_set_client = utf8";
   mysql_query($query);
   $query = "SET character_set_connection = utf8";
   mysql_query($query);
   $query = "SET character_set_results = utf8";
   mysql_query($query);
   
   $date = getdate();
   
   if(strlen($date["mon"]) == 1){
      $doska_tekst_date = $date["year"]."-0".$date["mon"]."-".$date["mday"];
   }
   else{
      $doska_tekst_date = $date["year"]."-".$date["mon"]."-".$date["mday"];
   }
   
   
   
   
   $zapros30="UPDATE doska_tekst SET doska_tekst_show = 'show', doska_tekst_date = '".$doska_tekst_date."' WHERE doska_tekst_id = '".$doska_tekst_id_post."'";
   mysql_query($zapros30);








echo "<HTML><HEAD><META HTTP-EQUIV='Refresh' CONTENT='0; URL=/doska/index.php?doska_kat_id=".$doska_kat_id_post."'></HEAD>";


?>


