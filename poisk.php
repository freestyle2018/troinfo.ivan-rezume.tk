<?php

include '../../pass.php';



function russian_date($date) {
   $translation = array(
      "Mon" => "пн",
      "Tue" => "вт",
      "Wed" => "ср",
      "Thu" => "чт",
      "Fri" => "пт",
      "Sat" => "сб",
      "Sun" => "вс",

      "January" => "января",
      "Jan" => "янв",
      "February" => "февраля",
      "Feb" => "фев",
      "March" => "марта",
      "Mar" => "мар",
      "April" => "апреля",
      "Apr" => "апр",
      "May" => "мая",
      "May" => "мая",
      "June" => "июня",
      "Jun" => "июн",
      "July" => "июля",
      "Jul" => "июл",
      "August" => "августа",
      "Aug" => "авг",
      "September" => "сентября",
      "Sep" => "сен",
      "October" => "октября",
      "Oct" => "окт",
      "November" => "ноября",
      "Nov" => "ноя",
      "December" => "декабря",
      );
   
      return strtr($date, $translation); 
}
   



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
      '%' => '',
      );
   
      return strtr($text, $translation); 
}


$zapros_post = $_POST["zapros"];
$zapros_post = zamena_simvolov($zapros_post);
strip_tags($zapros_post);
htmlspecialchars($zapros_post);
trim($zapros_post);



$url = $_SERVER['PHP_SELF'];



include '../temp/wapka.php';

$spisok_get = $_GET["spisok"];

$doska_kat_id_get = $_GET["doska_kat_id"];

$doska_kat_id_get = zamena_simvolov($doska_kat_id_get);
substr($doska_kat_id_get,0,4);
strip_tags($doska_kat_id_get); 


echo" <TABLE class=peredovica cellSpacing=0 cellPadding=0 width='100%' border=0>\n";
echo"   <TR vAlign=top>\n";
echo"      <TD class=nav width='12%' rowSpan=2>\n";

include '../temp/menu.php';

echo"     </TD>\n";


echo"<td width='53%' id='latest-news' >\n";


     echo "<table>\n";
     echo "<tr>\n";
        echo "<td valign='top'>\n";
           echo "   <form action='/doska/poisk.php' method='post'>\n";
           echo "   <span class='doska_poisk'>Поиск по ключевому слову</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='zapros' size='20' maxlength='50' value=''>\n";
           echo "   <input type='submit' value='Поиск' size='50'>\n";
           echo "   </form>";
        echo "</td>\n";
     echo "</tr>\n";
     echo "</table>\n";
  





echo"<table cellSpacing=0 cellPadding=0 border=0>\n";
echo "<tr>\n";
  echo "<td align='left'>\n";
     echo "<table>\n";
     echo "<tr>\n";
        echo "<td valign='top'>\n";
           echo "   <span class='doska_katalog'><a class='doska_edit_ssulka' href='/doska/'>Полный список объявлений</a>&nbsp;&nbsp;<a class='doska_edit_ssulka' href='/doska/doska_edit.php?vid=3'>Разместите свое объявление</a>&nbsp;&nbsp;</span>\n";
        echo "</td>\n";
        echo "<td valign='top'>\n";
           echo "   <div class='doska_katalog'><a href='/doska/doska_edit.php'><img class='obvlenie_img' src='/img/obvlenie.gif'></a></div>\n";
        echo "</td>\n";
     echo "</tr>\n";
     echo "</table>\n";
  echo "</td>\n";
echo "</tr>\n";
echo"</table>\n";








if (isset($zapros_post)){
   $word = strtok($zapros_post, " ,");
   $j = 0;
   while ($word)
   {
      $keywords_array[$j] = $word;
      $word = strtok(" ,");
      $j++;
   } 
   $kolvo = $j;
   
   $vuborka_polnaia_array = array("0");
   
   
   for ($j=0; $j < $kolvo; $j++){
      $slovo = $keywords_array[$j];
      array_push($vuborka_polnaia_array, $slovo);
      if(strlen($slovo) >= 7){
         $dlina = strlen($slovo);
         for ($i=1; $i <= 3; $i++){
            $dlina_posle = $dlina - $i;
            array_push($vuborka_polnaia_array, substr($slovo, 0, $dlina_posle));
         }
      }
      else if(strlen($slovo) >= 5 && strlen($slovo) < 7){
         $dlina = strlen($slovo);
         for ($i=1; $i <= 2; $i++){
            $dlina_posle = $dlina - $i;
            array_push($vuborka_polnaia_array, substr($slovo, 0, $dlina_posle));
         }
      }
      else if(strlen($slovo) == 4){
         $dlina = strlen($slovo);
         for ($i=1; $i <= 1; $i++){
            $dlina_posle = $dlina - $i;
            array_push($vuborka_polnaia_array, substr($slovo, 0, $dlina_posle));
         }
      }
   }
   
   
   
   array_shift($vuborka_polnaia_array);
   $final_array = array("0");
   
   
   for ($i=0; $i < sizeof($vuborka_polnaia_array); $i++){
       $query = "SET character_set_client = utf8";
       mysql_query($query);
       $query = "SET character_set_connection = utf8";
       mysql_query($query);
       $query = "SET character_set_results = utf8";
       mysql_query($query);                                                                                     
       $zapros20=@"SELECT doska_tekst_id FROM doska_tekst WHERE doska_tekst_name LIKE '%".$vuborka_polnaia_array[$i]."%' AND doska_tekst_show='show'";
       $result20=@mysql_query($zapros20);
       $num_results20 =@ mysql_num_rows($result20);
       
           
       for ($j=0; $j < $num_results20; $j++){
           $row20 = mysql_fetch_array($result20);
           //echo "id = ".$row20["doska_tekst_id"]."<br>";
           array_push($final_array, $row20["doska_tekst_id"]);
       }
       
   }
   
   
   for ($i=0; $i < sizeof($vuborka_polnaia_array); $i++){
       $query = "SET character_set_client = utf8";
       mysql_query($query);
       $query = "SET character_set_connection = utf8";
       mysql_query($query);
       $query = "SET character_set_results = utf8";
       mysql_query($query);                                                                                     
       $zapros20=@"SELECT doska_tekst_id FROM doska_tekst WHERE doska_tekst_info LIKE '%".$vuborka_polnaia_array[$i]."%' AND doska_tekst_show='show'";
       $result20=@mysql_query($zapros20);
       $num_results20 =@ mysql_num_rows($result20);
       
           
       for ($j=0; $j < $num_results20; $j++){
           $row20 = mysql_fetch_array($result20);
           //echo "id = ".$row20["doska_tekst_id"]."<br>";
           array_push($final_array, $row20["doska_tekst_id"]);
       }
       
   }
   
   
   array_shift($final_array);
   $final_array_2 = array_count_values($final_array);
   arsort($final_array_2);
   $final_array_3 = array_keys($final_array_2);
   
}

$doska_tekst_date_array = array(); 
$doska_tekst_name_array = array();
$doska_tekst_info_array = array();


for ($i=0; $i < sizeof($final_array_3); $i++){
   $query = "SET character_set_client = utf8";
   mysql_query($query);
   $query = "SET character_set_connection = utf8";
   mysql_query($query);
   $query = "SET character_set_results = utf8";
   mysql_query($query); 
   
   $zapros20=@"SELECT doska_tekst_name, doska_tekst_date FROM doska_tekst WHERE doska_tekst_id LIKE '%".$final_array_3[$i]."%'";
   $result20=@mysql_query($zapros20);
   $num_results20 =@ mysql_num_rows($result20);
       
          
   for ($j=0; $j < $num_results20; $j++){
      $row20 = mysql_fetch_array($result20);
	  $doska_tekst_date_array[$i] = $row20["doska_tekst_date"];
      $doska_tekst_name_array[$i] = $row20["doska_tekst_name"];
   }
   
   
   $zapros21=@"SELECT doska_tekst_info, doska_tekst_date FROM doska_tekst WHERE doska_tekst_id LIKE '%".$final_array_3[$i]."%'";
   $result21=@mysql_query($zapros21);
   $num_results21 =@ mysql_num_rows($result21);
       
          
   for ($j=0; $j < $num_results21; $j++){
      $row21 = mysql_fetch_array($result21);
	  $doska_tekst_date_array[$i] = $row21["doska_tekst_date"];
      $doska_tekst_info_array[$i] = $row21["doska_tekst_info"];
   }
   
                                                                              
   //$zapros20=@mysql_query("SELECT doska_tekst_name FROM doska_tekst WHERE doska_tekst_id LIKE '%".$final_array_3[$i]."%'");
   //$doska_tekst_name_array[$i] = mysql_result($zapros20,doska_tekst_name);
   //$zapros20=@mysql_query("SELECT doska_tekst_info FROM doska_tekst WHERE doska_tekst_id LIKE '%".$final_array_3[$i]."%'");
   //$doska_tekst_info_array[$i] = mysql_result($zapros20,doska_tekst_info);
   //$doska_tekst_img_array[$i]  = mysql_result($zapros20,doska_tekst_img);
}
   

$ostatok = sizeof($final_array_3) % 2;

if(sizeof($final_array_3) == 0){
   echo "<b>По Вашему запросу информации не найдено!</b>";
}


if($ostatok <> 0){
   $kol_vo_obiavlenii = sizeof($final_array_3) - 1;
}
else{
  $kol_vo_obiavlenii = sizeof($final_array_3);
}  
 
   
   for ($i=0; $i < $kol_vo_obiavlenii; $i += 2){
      echo "<table  cellSpacing=0 cellPadding=0 border=0>\n";
      echo "<tr valign='top'>\n";                        
      echo "<td>\n";               
      //if($doska_tekst_img_array[$i] == ""){
      if(1 == 1){
         echo "<div class='text'>\n";
            echo "<div class='t'>\n";
               echo "<div class='angles l'></div>\n";
               echo "<div class='angles r'></div>\n";
            echo "</div>\n";
                        
            echo "<div class='content'>\n";
			   echo "   <span style='color:grey' class='size'><b>".$doska_tekst_date_array[$i]."</b></span>";
               echo "   <span class='size'><b>".$doska_tekst_name_array[$i]."</b>".$doska_tekst_info_array[$i]."</span>\n";
            echo "</div>\n";
                        
            echo "<div class='b'>\n";
               echo "<div class='angles l'></div>\n";
               echo "<div class='angles r'></div>\n";
            echo "</div>\n";
         echo "</div>\n";
      }
      else{
         echo "<div class='roundborder'>\n";
            echo "<div class='t'>\n";
               echo "<div class='angles l'></div>\n";
               echo "<div class='angles r'></div>\n";
            echo "</div>\n";
                                          
            echo "<div class='picture'>\n";
               echo "<img class='border0' src='/".$doska_tekst_img_array[$i]."'>";
            echo "</div>\n";
                        
            echo "<div class='b'>\n";
               echo "<div class='angles l'></div>\n";
               echo "<div class='angles r'></div>\n";
            echo "</div>\n";
         echo "</div>\n";
      }               
      echo "</td>\n";
       
                     
      echo "<td>\n";
         echo "   <img class='border0' src='/none.gif' width='6' height='1'>";
      echo "</td>\n";
         
         
                     
      echo "<td>\n";
         //if($doska_tekst_img_array[$i] == ""){
         if(1 == 1){
            echo "<div class='text'>\n";
               echo "<div class='t'>\n";
                  echo "<div class='angles l'></div>\n";
                  echo "<div class='angles r'></div>\n";
               echo "</div>\n";
                        
               echo "<div class='content'>\n";
			      echo "   <span style='color:grey' class='size'><b>".$doska_tekst_date_array[$i+1]."</b></span>";
                  echo "   <span class='size'><b>".$doska_tekst_name_array[$i+1]."</b>".$doska_tekst_info_array[$i+1]."</span>\n";
               echo "</div>\n";
                        
               echo "<div class='b'>\n";
                  echo "<div class='angles l'></div>\n";
                  echo "<div class='angles r'></div>\n";
               echo "</div>\n";
            echo "</div>\n";
         }
         else{
            echo "<div class='roundborder'>\n";
               echo "<div class='t'>\n";
                  echo "<div class='angles l'></div>\n";
                  echo "<div class='angles r'></div>\n";
               echo "</div>\n";
                        
               echo "<div class='picture'>\n";
                  echo "<img class='border0' src='/".$doska_tekst_img_array[$i+1]."'>";
               echo "</div>\n";
                        
               echo "<div class='b'>\n";
                  echo "<div class='angles l'></div>\n";
                  echo "<div class='angles r'></div>\n";
               echo "</div>\n";
            echo "</div>\n";
         }
      echo "</td>\n";
      echo "</tr>\n";
            
      echo "<tr>\n";
      echo "<td colspan='2' height='3'>\n";
      echo "</td>\n";
      echo "</tr>\n";
                     
      echo "</table>\n";
   }
   
   if($ostatok <> 0){
      echo "<table  cellSpacing=0 cellPadding=0 border=0>\n";
      echo "<tr valign='top'>\n";
                     
      echo "<td>\n";
                     
      if($doska_tekst_img_array[$i] == ""){
         echo "<div class='text'>\n";
         echo "<div class='t'>\n";
            echo "<div class='angles l'></div>\n";
            echo "<div class='angles r'></div>\n";
         echo "</div>\n";
                        
         echo "<div class='content'>\n";
		    echo "   <span style='color:grey' class='size'><b>".$doska_tekst_date_array[$i]."</b></span>";
            echo "   <span class='size'><b>".$doska_tekst_name_array[$i]."</b>".$doska_tekst_info_array[$i]."</span>\n";
         echo "</div>\n";
                        
         echo "<div class='b'>\n";
            echo "<div class='angles l'></div>\n";
            echo "<div class='angles r'></div>\n";
         echo "</div>\n";
         echo "</div>\n";
      }
      else{
         echo "<div class='roundborder'>\n";
         echo "<div class='t'>\n";
            echo "<div class='angles l'></div>\n";
            echo "<div class='angles r'></div>\n";
         echo "</div>\n";
                      
         echo "<div class='picture'>\n";
            echo "<img class='border0' src='/".$doska_tekst_img_array[$i]."'>";
         echo "</div>\n";
                        
         echo "<div class='b'>\n";
            echo "<div class='angles l'></div>\n";
            echo "<div class='angles r'></div>\n";
         echo "</div>\n";
         echo "</div>\n";
      }
                     
      echo "</td>\n";
      echo "</tr>\n";
      echo "</table>\n";
   }





?>
 </TD>
  <TD width="33%"><!-- ТОП 7 -->
    <TABLE cellSpacing=0 cellPadding=0 width=100% border=0>
        <TR vAlign=top>
           <TD width=50%>
           
            <iframe class="reklama_sboku" width=240 height=1003
            src="/reklama_sboku/objii/001.html"
            frameborder=0 vspace=0 hspace=0 scrolling=no
            marginwidth=0 marginheight=0></iframe>
           
           </TD>
        </TR>
    </TABLE>
    
    <br>
  </TD>
<?php


echo"   <td width='2%'><!-- правое поле 2 процента --></td>\n";
echo"   </tr>\n";
echo"   <tr valign='bottom'><td class='pravaya' width='33%'>\n";


echo"   </td><td> </td></tr></tbody></table>\n";









include '../temp/botom.php';




echo"</body></html>\n";


?>


