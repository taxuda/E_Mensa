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
    echo "$countPageLoad";
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
            echo " Besuche";

            ?> </h3></div>
    <div class="grid-b"><h3><?php
            $filename = fopen("./daten/newsletter.csv","r");
            countLineCsv($filename);
            echo " Anmeldungen Zum Newsletter";
            fclose($filename);
            ?> </h3></div>
    <div class="grid-c"><h3>

            <?php
            /*

            AUFGABE 1 -- Auskommentiert mit mysql ansatz

            $count = 0;
            if (file_exists("gerichtFile.csv")) {
              $file = fopen("gerichtFile.csv", "r");
              while(!feof($file)){
                $line = fgets($file);
                $count = $count + 1;
              }
            }
            echo $count;*/

            $link=mysqli_connect("127.0.0.1", // Host der Datenbank
                "ich",                 // Benutzername zur Anmeldung
                "kekw123",    // Passwort
                "emensawerbeseite",      // Auswahl der Datenbanken (bzw. des Schemas)
            // optional port der Datenbank
            );

            if (!$link) {
                echo "Verbindung fehlgeschlagen: ", mysqli_connect_error();
                exit();
            }

            $sql = "SELECT COUNT(*) AS anz from gericht";

            $result1 = mysqli_query($link, $sql);
            if (!$result1) {
                echo "Fehler während der Abfrage:  ", mysqli_error($link);
                exit();
            }


            $row = mysqli_fetch_assoc($result1);
            echo $row['anz'];



            mysqli_free_result($result1);
            mysqli_close($link);

            ?>
            Speisen</h3></div>
</div>
</body>
</html>

