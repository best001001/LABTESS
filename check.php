<?php
$dir = "./";

// Open a directory, and read its contents
if (is_dir($dir)){
if ($dh = opendir($dir)){
while (($file = readdir($dh)) !== false){
// if(stripos($file, '.png') !== false ){
echo "filename:" . $file . "<br>";
/* if (!unlink($file)){
echo ("Error deleting<br>");
}else{
echo ("Deleted<br>");
}*/
// }
}
closedir($dh);
}
}
?>