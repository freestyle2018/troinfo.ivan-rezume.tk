﻿<?php

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
      );
   
      return strtr($text, $translation); 
}



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


$query = "SET character_set_client = utf8";
mysql_query($query);
$query = "SET character_set_connection = utf8";
mysql_query($query);
$query = "SET character_set_results = utf8";
mysql_query($query);                                                                                        
$zapros=@"SELECT * FROM doska_kat ORDER BY doska_kat_id";
$result=@mysql_query($zapros);
$num_results =@ mysql_num_rows($result);


echo "<table width='100%'  cellSpacing=0 cellPadding=0 border=0>\n";

  echo "<tr>\n";
  echo "<td align='left'>\n";
     echo "<table>\n";
     echo "<tr>\n";
        echo "<td valign='top'>\n";
           echo "   <form action='/doska/poisk.php' method='post'>\n";
           echo "   <span class='doska_poisk'>Поиск по ключевому слову</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='zapros' size='20' maxlength='50' value=''>\n";
           echo "   <input type='submit' value='Поиск' size='50'>\n";
           echo "   </form>";
        echo "</td>\n";
     echo "</tr>\n";
     echo "</table>\n";
  echo "</td>\n";
  echo "</tr>\n";   
      
if(!$doska_kat_id_get){
  echo "<tr>\n";
  echo "<td align='left'>\n";
     echo "<table>\n";
     echo "<tr>\n";
        echo "<td valign='top'>\n";
           echo "   <span class='doska_katalog'><a class='doska_edit_ssulka' href='/doska/doska_moderacia.php'>Объявление на модерации</a>&nbsp;&nbsp;<a class='doska_edit_ssulka' href='/doska/doska_edit.php?vid=3'>Разместите свое объявление</a>&nbsp;&nbsp;</span>\n";
        echo "</td>\n";
        echo "<td valign='top'>\n";
           echo "   <div class='doska_katalog'><a href='/doska/doska_edit.php?vid=3'><img class='obvlenie_img' src='/img/obvlenie.gif'></a></div>\n";
        echo "</td>\n";
     echo "</tr>\n";
     echo "</table>\n";
  echo "</td>\n";
  echo "</tr>\n";    
}
else{
  echo "<tr>\n";
  echo "<td align='left'>\n";
     echo "<table>\n";
     echo "<tr>\n";
        echo "<td valign='top'>\n";
           echo "   <span class='doska_katalog'><a class='doska_edit_ssulka' href='/doska/doska_moderacia.php?doska_kat_id_get=".$doska_kat_id_get."'>Объявление на модерации</a>&nbsp;&nbsp;<a class='doska_edit_ssulka' href='/doska/doska_edit.php?vid=3'>Разместите свое объявление</a>&nbsp;&nbsp;</span>\n";
        echo "</td>\n";
        echo "<td valign='top'>\n";
           echo "   <div class='doska_katalog'><a href='/doska/doska_edit.php?vid=3'><img class='obvlenie_img' src='/img/obvlenie.gif'></a></div>\n";
        echo "</td>\n";
     echo "</tr>\n";
     echo "</table>\n";
  echo "</td>\n";
  echo "</tr>\n";
}
  
  
      
      
  if(!$doska_kat_id_get){
      
      for ($l=0; $l < $num_results; $l++){
         $row = mysql_fetch_array($result);
         echo "<tr>\n";
         echo "<td align='left' valign='top'>\n";
            echo "   <div class='doska_katalog'><a class='doska_katalog_ssulka' href='/doska/index.php?doska_kat_id=".$row["doska_kat_id"]."'>".$row["doska_kat_name"]."</a></div>\n";
         echo "</td>\n";
         echo "</tr>\n";
        
         echo "<tr>\n";
         echo "<td>\n";   
         echo    "<div class='doska_line'></div>\n";   
         echo "</td>\n";
         echo "</tr>\n";
      }
  }    
  else{
      for ($l=0; $l < $num_results; $l++){
         $row = mysql_fetch_array($result);
         if($row["doska_kat_id"] == $doska_kat_id_get){
            echo "<tr>\n";
            $query = "SET character_set_client = utf8";
            mysql_query($query);
            $query = "SET character_set_connection = utf8";
            mysql_query($query);
            $query = "SET character_set_results = utf8";
            mysql_query($query); 
            if(isset($spisok_get)){
               $zapros2=@"SELECT * FROM doska_tekst WHERE doska_kat_id = ".$doska_kat_id_get." AND doska_tekst_show = 'show' ORDER BY doska_tekst_date DESC";
            }                                                                                      
            else{
               $zapros2=@"SELECT * FROM doska_tekst WHERE doska_kat_id = ".$doska_kat_id_get." AND doska_tekst_show = 'show' ORDER BY doska_tekst_date DESC LIMIT 0 , 6";
            }
            $result2=@mysql_query($zapros2);
            $num_results2 =@ mysql_num_rows($result2);
            
            for ($i=0; $i < $num_results2; $i++){
               $row2 = mysql_fetch_array($result2);
               $doska_tekst_date_array[$i] = $row2["doska_tekst_date"];
               $doska_tekst_name_array[$i] = $row2["doska_tekst_name"];
               $doska_tekst_info_array[$i] = $row2["doska_tekst_info"];
               $doska_tekst_date_array[$i] = $row2["doska_tekst_date"];
               $doska_tekst_img_array[$i] = $row2["doska_tekst_img"];
            }
            
            echo "<td align='left' valign='top'>\n";
               if(isset($spisok_get)){
                  echo "   <div class='katalog_block'><span class='doska_katalog_id'>".$row["doska_kat_name"]."</span>&nbsp;&nbsp;<a href='/doska/' class='doska_oglavlenie'>(оглавление объявлений)</span></a>\n";
               }
               else{
                  echo "   <div class='doska_katalog'><a class='doska_katalog_ssulka' href='/doska/index.php?doska_kat_id=".$row["doska_kat_id"]."&spisok=all'>".$row["doska_kat_name"]." <span style='color:red'><small>(полный список)</small></span></a></div>\n";
                  
               }
               $ostatok = $num_results2 % 2;
      
               if($ostatok <> 0){
                  $num_results2 = $num_results2 - 1;
               }
               
               for ($i=0; $i < $num_results2; $i += 2){

                  $row2 = mysql_fetch_array($result2);
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
                     
                     echo "<td>\n";
                     echo "   <img class='border0' src='/none.gif' width='6' height='1'>";
                     echo "</td>\n";
                     
                     echo "<td>\n";
                     if($doska_tekst_img_array[$i+1] == ""){
                        echo "<div class='text'>\n";
                        echo "<div class='t'>\n";
                           echo "<div class='angles l'></div>\n";
                           echo "<div class='angles r'></div>\n";
                        echo "</div>\n";
                        
                        echo "<div class='content'>\n";
                           echo "   <span style='color:grey' class='size'><b>".$doska_tekst_date_array[$i]."</b></span>";
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
               
               // ЕСЛИ КОЛИЧЕСТВО ОБЪЯВЛЕНИЙ НЕЧЕТНОЕ ЧИСЛО!!!!!!
      
      
      
               if($ostatok <> 0){
                  echo "<tr>\n";
                  echo "<td valign='top'>\n";
                  
                  
                  $row2 = mysql_fetch_array($result2);
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
               
            echo "</td>\n";
            echo "</tr>\n";
            
            
         }
         else{
            if(!isset($spisok_get)){
               echo "<tr>\n";
               echo "<td align='left' valign='top'>\n";
                  echo "   <div class='doska_katalog'><a class='doska_katalog_ssulka' href='/doska/index.php?doska_kat_id=".$row["doska_kat_id"]."'>".$row["doska_kat_name"]."</a></div>\n";
               echo "</td>\n";
               echo "</tr>\n";
            }
         }
         
         if(!isset($spisok_get)){
            echo "<tr>\n";
            echo "<td>\n";   
            echo    "<div class='doska_line'></div>\n";   
            echo "</td>\n";
            echo "</tr>\n";
         }
      }
      
      
      
      
      
      
     
     
  }
  
  
  


echo "</table>\n";


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


