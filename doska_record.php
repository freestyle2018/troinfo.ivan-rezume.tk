<?php

include '../../pass.php';




function zamena_simvolov($text) {
   $translation = array(

      '[' => '(',
      ']' => ')',
      '{' => '(',
      '}' => ')',



      
      '*' => '&middot;',
      '<' => '&lang;',
      '>' => '&rang;',
      '&' => '&amp;',
      '\'' => '&quot;',
      '\"' => '&quot;',
      );
   
      return strtr($text, $translation); 
}





function zamena_simvolov2($text) {
   $translation = array(
      '[' => '(',
      ']' => ')',
      '{' => '(',
      '}' => ')',
      '^' => '',
      
      
      '-' => '&minus;',
      '*' => '&middot;',
      '<' => '&lang;',
      '>' => '&rang;',
      '&' => '&amp;',
      );
   
      return strtr($text, $translation); 
}



function zamena_kavuchek($text) {
   $translation = array(
      '"' => '&quot;',
      "\'" => "&lsquo;"
      );
   
      return strtr($text, $translation); 
}




$img_post = $_GET["img"];


$doska_tekst_info_post = $_GET["doska_tekst_info"];
$doska_tekst_date_post = $_GET["doska_tekst_date"];
$doska_tekst_img_post = $_GET["doska_tekst_img"];
$doska_kat_id_post = $_GET["doska_kat_id"];

//echo $doska_tekst_info_post."<br>";

$doska_tekst_info_post = stripslashes($doska_tekst_info_post);
$doska_tekst_info_post = zamena_simvolov($doska_tekst_info_post);

$novosti_id_get = zamena_simvolov2($novosti_id_get);
substr($novosti_id_get,0,13);
strip_tags($novosti_id_get); 

substr($doska_tekst_img_post,0,0);

$doska_kat_id_post = zamena_simvolov($doska_kat_id_post);
substr($doska_kat_id_post,0,3);
strip_tags($doska_kat_id_post); 


$doska_tekst_date_post = zamena_simvolov($doska_tekst_date_post);
substr($doska_tekst_date_post,0,3);
strip_tags($doska_tekst_date_post); 



 






if (!empty($_FILES['doska_tekst_img']['tmp_name'])){
      
   $ext = strrchr($_FILES['doska_tekst_img']['name'], ".");
      
   //Определяем значение description в таблице photocat
   $zapros02 = "SELECT doska_kat_description FROM doska_kat WHERE doska_kat_id = ".$doska_kat_id_post."";
   $result02= mysql_query($zapros02);
   $num_results02 = mysql_num_rows($result02);
    
   while($row02 = mysql_fetch_array($result02)){
      $name_cat = $row02["doska_kat_description"];
           
      $doska_img_post = "img_doska/".$name_cat."/".date("YmdHis",time())."$ext";
        
      // Перемещаем файл из временной директории сервера в
      // директорию /files/$name_cat Web-приложения
      if (copy($_FILES['doska_tekst_img']['tmp_name'], "../".$doska_img_post))
      {
         // Уничтожаем файл во временной директории
         unlink($_FILES['doska_tekst_img']['tmp_name']);
         // Изменяем права доступа к файлу
         chmod("../".$doska_img_post, 0644);
      }
   }
}



echo $doska_tekst_info_post."<br>";
echo $doska_tekst_date_post."<br>";
echo $doska_kat_id_post."<br>";



   
   $query = "SET character_set_client = utf8";
   mysql_query($query);
   $query = "SET character_set_connection = utf8";
   mysql_query($query);
   $query = "SET character_set_results = utf8";
   mysql_query($query);
   
   $doska_tekst_info_post = zamena_kavuchek($doska_tekst_info_post);
   
   
   if($img_post == 1){
      $zapros30="INSERT INTO doska_tekst VALUES (NULL , NULL , '".$doska_tekst_info_post."', '".$doska_tekst_date_post."' , NULL , 'prosto', 'hide', 'hide', '".$doska_img_post."' , '".$doska_kat_id_post."')";
      mysql_query($zapros30);
   }
   else{
      $zapros30="INSERT INTO doska_tekst VALUES (NULL , NULL , '".$doska_tekst_info_post."', '".$doska_tekst_date_post."' , NULL , 'prosto', 'hide', 'hide', '".$doska_tekst_img_post."' , '".$doska_kat_id_post."')";
      mysql_query($zapros30);
   }

header("Location: /doska/doska_moderacia.php?doska_kat_id_get=".$doska_kat_id_post);

?>


