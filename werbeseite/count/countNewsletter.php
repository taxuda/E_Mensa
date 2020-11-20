<?php
$newsletter = file_get_contents("../daten/newsletter.csv");
var_dump($newsletter);
echo "<br>";
$array = unserialize($newsletter);
var_dump($array);
echo "<br>";
// ket luan: chi co the unserialize dong dau tien
// doc tung dong mot, dem so luong dong
//ini_set('auto_detect_line_endings',TRUE);
$file = fopen("../daten/newsletter.csv","r");
$count = 0;
while(!feof($file)){
    if(($line = fgetcsv($file)) !== false){
        var_dump($line);
        echo "<br>";
        $ar = unserialize($line[0]);
        var_dump($ar);
        echo "<br>";
        $count++;
    }
}
echo $count;
fclose($file);
//ini_set('auto_detect_line_endings',TRUE);
?>
