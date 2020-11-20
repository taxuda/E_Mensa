<?php
function countPageLoad($pageLoaded){
    $countPageLoad = 0;
    if(!file_exists($pageLoaded)){
        $countPageLoad = 1;
    }else{
        $countPageLoad = unserialize(file_get_contents($pageLoaded));
        $countPageLoad++;
    }
    $line = serialize($countPageLoad)."\n";
    file_put_contents('./daten/pageload.csv',$line);
    echo $countPageLoad;
}
//counting numbers of line in a file.csv
function countLineCsv($Csvfile){
    $count = 0;
    while(!feof($Csvfile)){
        if(($line = fgetcsv($Csvfile)) !== false){
            $count++;
        }
    }
    echo "$count";
}
/**
//test count page loaded
$filename ='../daten/pageload.csv';
countPageLoad($filename);
fclose($filename);

echo "<br>";
//test count line csv
$file = fopen("../daten/newsletter.csv","r");
countLineCsv($file);
fclose($file);

echo "<br>";
$file = fopen("../daten/gerichte.csv","r");
countLineCsv($file);
fclose($file);
//*/
?>
<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="UTF-8">
        <title>Zahlen von Werbeseite</title>
    </head>
    <body>
    <h2 id="Zahlen">E-Mensa in Zahlen</h2>
    <div class="grid-container1">
        <div class="grid-a"><h3><?php
                $filename ='./daten/pageload.csv';
                countPageLoad($filename);
                fclose($filename);
                ?> </h3></div>
        <div class="grid-b"><h3><?php
                $filename = fopen("./daten/newsletter.csv","r");
                countLineCsv($filename);
                echo " Anmeldungen Zum Newsletter";
                fclose($filename);
                ?> </h3></div>
        <div class="grid-c"><h3><?php
                $filename = fopen("./daten/gerichte.csv","r");
                countLineCsv($filename);
                echo " Speisen";
                fclose($filename);
                ?></h3></div>
    </div>
    </body>
</html>
