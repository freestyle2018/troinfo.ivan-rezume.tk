﻿<?php

include '../../pass.php';



function zamena_kavuchek($text) {
   $translation = array(
      '"' => '&quot;',
      "\'" => "&lsquo;"
      );
   
      return strtr($text, $translation); 
}



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
   






$url = $_SERVER['PHP_SELF'];



include '../temp/wapka.php';


$vid_get = $_GET["vid"];
$obrezat = $_GET["obrezat"];
$doska_tekst_info_get = $_GET["doska_tekst_info"];
$doska_tekst_info_post = $_POST["doska_tekst_info"];
//$doska_tekst_info_post = stripslashes($doska_tekst_info_post);
$doska_tekst_info_post = zamena_kavuchek($doska_tekst_info_post);

$doska_tekst_info = $_POST["doska_tekst_info"];
//$doska_tekst_info = stripslashes($doska_tekst_info);
$doska_tekst_info = zamena_kavuchek($doska_tekst_info);
$doska_tekst_date = $_POST["doska_tekst_date"];
$doska_tekst_img = $_POST["doska_tekst_img"];
$doska_kat_id = $_POST["doska_kat_id"];
$proverka = $_POST["proverka"];

function resizeimg($filename, $smallimage, $w, $h) 
  { 
    // Имя файла с масштабируемым изображением 
    $filename = $filename; 
    // Имя файла с уменьшенной копией. 
    $smallimage = $smallimage;     
    // определим коэффициент сжатия изображения, которое будем генерить 
    $ratio = $w/$h; 
    // получим размеры исходного изображения 
    $size_img = getimagesize($filename); 
    // Если размеры меньше, то масштабирования не нужно 
    if (($size_img[0]<$w) && ($size_img[1]<$h)) return true; 
    // получим коэффициент сжатия исходного изображения 
    $src_ratio=$size_img[0]/$size_img[1]; 

    // Здесь вычисляем размеры уменьшенной копии, чтобы при масштабировании сохранились 
    // пропорции исходного изображения 
    if ($ratio<$src_ratio) 
    { 
      $h = $w/$src_ratio; 
    } 
    else 
    { 
      $w = $h*$src_ratio; 
    } 
    // создадим пустое изображение по заданным размерам 
    $dest_img = imagecreatetruecolor($w, $h);   
    $white = imagecolorallocate($dest_img, 255, 255, 255);        
    if ($size_img[2]==2)  $src_img = imagecreatefromjpeg($filename);                       
    else if ($size_img[2]==1) $src_img = imagecreatefromgif($filename);                       
    else if ($size_img[2]==3) $src_img = imagecreatefrompng($filename); 

    // масштабируем изображение     функцией imagecopyresampled() 
    // $dest_img - уменьшенная копия 
    // $src_img - исходной изображение 
    // $w - ширина уменьшенной копии 
    // $h - высота уменьшенной копии         
    // $size_img[0] - ширина исходного изображения 
    // $size_img[1] - высота исходного изображения 
    imagecopyresampled($dest_img, $src_img, 0, 0, 0, 0, $w, $h, $size_img[0], $size_img[1]);                 
    // сохраняем уменьшенную копию в файл 
    if ($size_img[2]==2)  imagejpeg($dest_img, $smallimage);                       
    else if ($size_img[2]==1) imagegif($dest_img, $smallimage);                       
    else if ($size_img[2]==3) imagepng($dest_img, $smallimage); 
    // чистим память от созданных изображений 
    imagedestroy($dest_img); 
    imagedestroy($src_img); 
    return true;          
  }   

echo" <TABLE class=peredovica cellSpacing=0 cellPadding=0 width='100%' border=0>\n";
echo"   <TR vAlign=top>\n";
echo"      <TD class=nav width='12%' rowSpan=2>\n";

include '../temp/menu.php';

echo"     </TD>\n";


echo"<td width='53%' id='latest-news' >\n";

echo"<table cellSpacing=0 cellPadding=0 border=0>\n";
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
echo"</table>\n";

echo"<table cellSpacing=0 cellPadding=0 border=0>\n";
echo"<tr>\n";
   echo"<td colspan='2'>\n";
      //echo "<b>Уважаемые рекламодатели!</b><br>\n";
      //echo "Разместить объявление на нашем сайте может как частное, так и юридическое лицо.<br>\n";
      //echo "В данный момент существует четыре вида объявлений. Оплата объявлений происходит при <b>помощи смс сервиса</b>.<br><br>\n";
      
      //echo "Вы можете выбрать, интересующий Вас вариант объявления:<br><br>\n";
   echo"</td>\n";
echo"</tr>\n";
echo"<tr>\n";
   echo"<td width='250'>\n";
      //echo "<a class='doska_edit' href='/doska/doska_edit.php?vid=3'>не более <b>250</b> символов</a>&nbsp;&nbsp;&nbsp; - 0 руб<br>\n";
      //echo "<a class='doska_edit' href='/doska/doska_edit.php?vid=4'><b>размещение картинки</b></a>&nbsp;&nbsp; - 0 руб<br>\n";
   echo"</td>\n";
   echo"<td align='center' valign='middle'>\n";
      
      if($vid_get == 3){
         echo "<b><span style='color:black'>Объявление:<br>не более 250 символов</span></b>\n";
      }
      else if($vid_get == 4){
         echo "<b><span style='color:black'>Объявление:<br>размещение картинки</span></b><br><small>технические требования:<br>jpeg-картинка, ширина:280 пикселей, высота: 187 пикселей;</small>\n";
      }
      else{
         echo "<b><span style='color:black'>&nbsp;&nbsp;</span></b>\n";
      }
   echo"</td>\n";
echo"</tr>\n";
echo"</table>\n";





if ($vid_get == 3){
   if (isset($obrezat)){
      $doska_tekst_info_get = substr($doska_tekst_info_get, 0, 250);
      $doska_tekst_info = $doska_tekst_info_get;
   }
   else{
      if (strlen($doska_tekst_info) > 250 && isset($proverka)){
         echo"<br><b>Количество символов больше 250 символов!</b><br><a href='/doska/doska_edit.php?vid=3&obrezat=1&doska_tekst_info=".$doska_tekst_info_post."'><span style='color:red'>Укоротить объявление до 250 символов.</span></a><br>\n";
         //echo strlen($doska_tekst_info_post);
      }
      else if (strlen($doska_tekst_info) == 0 && isset($proverka)){
         echo"<br><b><span style='color:red'>В объявлении нет информации!</span></b>\n";
      }
      //else if (isset($proverka) && isset($_POST['random_string']) && $captcha_check && $_POST['doska_kat_id'] <> ""){
      else if (isset($proverka) && $_POST['doska_kat_id'] <> ""){
         echo "<HTML><HEAD><META HTTP-EQUIV='Refresh' CONTENT='0; URL=/doska/doska_record.php?doska_tekst_info=".$doska_tekst_info."&doska_tekst_date=".$doska_tekst_date."&doska_tekst_img=".$doska_tekst_img."&doska_kat_id=".$doska_kat_id."'></HEAD>";
      }
   }
}




if ($vid_get == 4){
   $imageinfo = getimagesize($_FILES['doska_tekst_img']['tmp_name']);
   
   if($_FILES['doska_tekst_img']['name'] == "" && isset($proverka)){
      echo "<br><span style='color:red'><b>Извините, но Вы не выбрали изображение для загрузки.</b></span>\n";
   }
   else if($imageinfo['mime'] != 'image/gif' && $imageinfo['mime'] != 'image/jpeg' && isset($proverka)) {
      echo "<br><span style='color:red'><b>Извините, но загружать можно, только JPEG.</b></span>\n";
   }
   else if($imageinfo[0] > 280 && isset($proverka)){
      echo "<br><span style='color:red'><b>Извините, но размер файл превышает свой размер по ширине.</b></span>\n";
   }
   else if($imageinfo[1] > 187 && isset($proverka)){
      echo "<br><span style='color:red'><b>Извините, но размер файл превышает свой размер по высоте.</b></span>\n";
   }
   else if(isset($proverka) && isset($_POST['random_string']) && $captcha_check && $_POST['doska_kat_id'] <> "") {
      
      $ext = strrchr($_FILES['doska_tekst_img']['name'], ".");
         
      //Определяем значение description в таблице photocat
      $zapros02 = "SELECT doska_kat_description FROM doska_kat WHERE doska_kat_id = ".$doska_kat_id."";
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
            
            
            echo $doska_img_post;
         }
         
      }
      resizeimg( "../".$doska_img_post,  "../".$doska_img_post, 600, 600);
      resizeimg( "../".$doska_img_post,  "../".$doska_img_post, 280, 187);
      
      $query = "SET character_set_client = utf8";
      mysql_query($query);
      $query = "SET character_set_connection = utf8";
      mysql_query($query);
      $query = "SET character_set_results = utf8";
      mysql_query($query);
      
      $zapros30="INSERT INTO doska_tekst VALUES (NULL , NULL , '".$doska_tekst_info."', '".$doska_tekst_date."' , NULL , 'prosto', 'hide', 'hide', '".$doska_img_post."' , '".$doska_kat_id."')";
      mysql_query($zapros30);
      
      echo "<HTML><HEAD><META HTTP-EQUIV='Refresh' CONTENT='0; URL=/doska/doska_moderacia.php?doska_kat_id_get=".$doska_kat_id."'></HEAD>";
   }
}




if (isset($_POST['random_string']) && $captcha_check){}
elseif(isset($_POST['random_string'])) {
   echo "<br><span style='color:red'><b>Код введен НЕПРАВИЛЬНО попробуйте еще раз!</b></span>\n";
}


if(isset($proverka) && $_POST['doska_kat_id'] == ""){
   echo "<br><span style='color:red'><b>Вы не выбрали раздел для объявления!</b></span>\n";
}





if (isset($vid_get)){

   if ($vid_get == 4){
      echo"<form action='/doska/doska_edit.php?vid=4' method='post' target='_self' enctype='multipart/form-data'>\n";
      echo"<table cellSpacing=0 cellPadding=0 border=0>\n";
      echo"<tr>\n";
         echo"<td valign='top'>\n";
         echo"</td>\n";
         echo"<td valign='top' height='15'>\n";
         echo"</td>\n";
      echo"</tr>\n";
      echo"<tr>\n";
         echo"<td valign='top'>\n";
         
         echo"<b>Картинка объявления:&nbsp;&nbsp;</b>\n";
         echo"</td>\n";
         echo"<td valign='top'>\n";
         
         $date = getdate();
         $month = $date["mon"];
         $day   = $date["mday"];
         if(strlen($date["mon"]) == 1){
            $month = "0".$date["mon"]; 
         }
         if(strlen($date["mday"]) == 1){
            $day = "0".$date["mday"]; 
         }
         $doska_tekst_date = $date["year"]."-".$month."-".$day;
         
         echo"<input    name='doska_tekst_img' type='file' size='25'>\n";
         
         echo"<input    name='doska_tekst_date' type='hidden' value='".$doska_tekst_date."'>\n";
         echo"<input    name='doska_tekst_info'  type='hidden' value=''>\n";
         echo"<input    name='proverka'  type='hidden' value='1'>\n";
         
         echo"</td>\n";
      echo"</tr>\n";
      echo"<tr>\n";
         echo"<td valign='top'>\n";
         echo"</td>\n";
         echo"<td valign='top' height='5'>\n";
         echo"</td>\n";
      echo"</tr>\n";
      echo"<tr>\n";
         echo"<td valign='top'>\n";
            echo"<b>Раздел объявления:&nbsp;&nbsp;</b>\n";
         echo"</td>\n";
         echo"<td valign='top'>\n";
            echo "<select  name='doska_kat_id'>\n";
               echo "<option value=''>-Выберите подходящий раздел-&nbsp; &nbsp; &nbsp;</option>\n";
               $query = "SET character_set_results = utf8";
               mysql_query($query);
               $zapros40="SELECT * FROM doska_kat ORDER BY doska_kat_id";
               $result40=mysql_query($zapros40);
               $num_results40 =@ mysql_num_rows($result40);
               for ($i=0; $i < $num_results40; $i++){
                  $row40 = mysql_fetch_array($result40);
                  echo "<option value='".$row40["doska_kat_id"]."'>".$row40["doska_kat_name"]."</option>\n";
               }
            echo "</select>\n";
         echo"</td>\n";
      echo"</tr>\n";
      echo"<tr>\n";
         echo"<td valign='top'>\n";
         echo"</td>\n";
         echo"<td valign='top' height='5'>\n";
         echo"</td>\n";
      echo"</tr>\n";
      echo"<tr>\n";
         echo"<td valign='top'>\n";
         echo"</td>\n";
         echo"<td valign='top'>\n";
            echo"<img width='245' height='28' src='/doska/captcha.php' border=1>\n";
         echo"</td>\n";
      echo"</tr>\n";
      
      echo"<tr>\n";
         echo"<td valign='top'>\n";
            echo"<b>Введите код:</b>\n";
         echo"</td>\n";
         echo"<td valign='top'>\n";
            echo"<input type=text name=random_string size='37'>\n";
         echo"</td>\n";
      echo"</tr>\n";
      echo"<tr>\n";
         echo"<td valign='top'>\n";
         echo"</td>\n";
         echo"<td valign='top' height='5'>\n";
         echo"</td>\n";
      echo"</tr>\n";
      echo"<tr>\n";
         echo"<td valign='top'>\n";
         echo"</td>\n";
         echo"<td valign='top'>\n";
            echo"<input type='submit' width='800' value='Отправить на модерацию'>\n";
            echo"</form>\n";
         echo"</td>\n";
      echo"</tr>\n";
   echo"</table>\n";
   }
   else{
      echo"<table cellSpacing=0 cellPadding=0 border=0>\n";
      echo"<tr>\n";
         echo"<td>\n";
         echo"</td>\n";
         echo"<td align='right'>\n";
         if($vid_get == 1){
            echo"<span id='text-counter' class='schetchik_simvolov'>80</span> символов\n";
         }
         else if($vid_get == 2){
            echo"<span id='text-counter' class='schetchik_simvolov'>120</span> символов\n";
         }
         else if($vid_get == 3){
            echo"<span id='text-counter' class='schetchik_simvolov'>250</span> символов\n";
         }
         
         echo"</td>\n";
      echo"</tr>\n";
      echo"<tr>\n";
         echo"<td valign='top'>\n";
         if($vid_get == 1){
            echo"<form action='/doska/doska_edit.php?vid=1' method='post' target='_self'>\n";
         }
         else if($vid_get == 2){
            echo"<form action='/doska/doska_edit.php?vid=2' method='post' target='_self'>\n";
         }
         else if($vid_get == 3){
            echo"<form action='/doska/doska_edit.php?vid=3' method='post' target='_self'>\n";
         }
         echo"<b>Текст объявления:&nbsp;&nbsp;</b>\n";
         echo"</td>\n";
         echo"<td valign='top'>\n";
         
         $date = getdate();
         $month = $date["mon"];
         $day   = $date["mday"];
         if(strlen($date["mon"]) == 1){
            $month = "0".$date["mon"]; 
         }
         if(strlen($date["mday"]) == 1){
            $day = "0".$date["mday"]; 
         }
         $doska_tekst_date = $date["year"]."-".$month."-".$day;
         
         if($vid_get == 1){
            ?>
               <textarea name='doska_tekst_info' id='text-count' cols='55' rows='4' onkeyup="textCounter(this,'text-counter',80)" onpaste="textCounter(this,'text-counter',80)"><?php echo $doska_tekst_info; ?></textarea>
            <?php
         }
         else if($vid_get == 2){
            ?>
               <textarea name='doska_tekst_info' id='text-count' cols='55' rows='4' onkeyup="textCounter(this,'text-counter',120)" onpaste="textCounter(this,'text-counter',120)"><?php echo $doska_tekst_info; ?></textarea>
            <?php
         }
         else if($vid_get == 3){
            ?>
               <textarea name='doska_tekst_info' id='text-count' cols='55' rows='4' onkeyup="textCounter(this,'text-counter',250)" onpaste="textCounter(this,'text-counter',250)"><?php echo $doska_tekst_info; ?></textarea>
            <?php
         }
         
         echo"<input    name='doska_tekst_date' type='hidden' value='".$doska_tekst_date."'>\n";
         echo"<input    name='doska_tekst_img'  type='hidden' value=''>\n";
         echo"<input    name='proverka'  type='hidden' value='1'>\n";
         
         echo"</td>\n";
      echo"</tr>\n";
      echo"<tr>\n";
         echo"<td valign='top'>\n";
            echo"<b>Раздел объявления:&nbsp;&nbsp;</b>\n";
         echo"</td>\n";
         echo"<td valign='top'>\n";
            echo "<select  name='doska_kat_id'>\n";
               echo "<option value=''>-Выберите подходящий раздел-&nbsp; &nbsp; &nbsp; </option>\n";
               $zapros40="SELECT * FROM doska_kat ORDER BY doska_kat_id";
               $result40=mysql_query($zapros40);
               $num_results40 =@ mysql_num_rows($result40);
               for ($i=0; $i < $num_results40; $i++){
                  $row40 = mysql_fetch_array($result40);
                  echo "<option value='".$row40["doska_kat_id"]."'>".$row40["doska_kat_name"]."</option>\n";
               }
            echo "</select>\n";
         echo"</td>\n";
      echo"</tr>\n";
      echo"<tr>\n";
         echo"<td valign='top'>\n";
         echo"</td>\n";
         echo"<td valign='top' height='5'>\n";
         echo"</td>\n";
      echo"</tr>\n";
      //echo"<tr>\n";
         //echo"<td valign='top'>\n";
         //echo"</td>\n";
         //echo"<td valign='top'>\n";
            //echo"<img width='245' height='28' src='/doska/captcha.php' border=1>\n";
         //echo"</td>\n";
      //echo"</tr>\n";
      //echo"<tr>\n";
         //echo"<td valign='top'>\n";
         //echo"</td>\n";
         //echo"<td valign='top' height='5'>\n";
         //echo"</td>\n";
      //echo"</tr>\n";
      //echo"<tr>\n";
         //echo"<td valign='top'>\n";
            //echo"<b>Введите код:\n";
         //echo"</td>\n";
         //echo"<td valign='top'>\n";
            //echo"<input type=text name=random_string size='37'>\n";
         //echo"</td>\n";
      //echo"</tr>\n";
      //echo"<tr>\n";
         //echo"<td valign='top'>\n";
         //echo"</td>\n";
         //echo"<td valign='top' height='5'>\n";
         //echo"</td>\n";
      //echo"</tr>\n";
      echo"<tr>\n";
         echo"<td valign='top'>\n";
         echo"</td>\n";
         echo"<td valign='top'>\n";
            echo"<input type='submit' value='Отправить на модерацию'>\n";
            echo"</form>\n";
         echo"</td>\n";
      echo"</tr>\n";
      echo"</table>\n";
   }
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


