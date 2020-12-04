<?php
$link = mysqli_connect(
    "127.0.0.1",            // Host der Datenbank
    "ich",                 // Benutzername zur Anmeldung
    "kekw123",             // Passwort
    "emensawerbeseite", // Auswahl der Datenbanken (bzw. des Schemas)
// optional port der Datenbank
);

if (!$link) {
    echo "Verbindung fehlgeschlagen: ", mysqli_connect_error();
    exit();
}
// Daten von Gerichte für Tabelle
$sql = "select g.name as Gericht, g.preis_intern as 'Preis Intern', g.preis_extern as 'Preis Extern', group_concat(' ', gha.code) as Allergen 
from gericht g join gericht_hat_allergen gha on g.id = gha.gericht_id group by g.name order by g.name asc limit 5";

$result = mysqli_query($link, $sql);
if (!$result) {
    echo "Fehler während der Abfrage:  ", mysqli_error($link);
    exit();
}

while ($row = mysqli_fetch_assoc($result)) {
    $table[] = $row;
}

mysqli_free_result($result);

// Daten der verwendeten Allergene
$sql = "select CONCAT(a.name, ': ' , a.code) from gericht g
    join gericht_hat_allergen gha on g.id = gha.gericht_id
    join allergen a on gha.code = a.code where g.name is not null group by a.name;";
$result = mysqli_query($link, $sql);
if (!$result) {
    echo "Fehler während der Abfrage:  ", mysqli_error($link);
    exit();
}

while ($row = mysqli_fetch_assoc($result)) {
    $allergene[] = $row;
}
mysqli_free_result($result);
mysqli_close($link);
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Table der Gerichten</title>
</head>
<body>
<?php if (count($table) > 0): ?>
    <div class="preis">
    <table>
        <thead>
        <tr>
            <th><?php echo implode('</th><th>', array_keys(current($table))); ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($table as $row): array_map('htmlentities', $row); ?>
            <tr>
                <?php
                echo "<td>",htmlspecialchars($row['Gericht']),"</td>";
                echo "<td>",htmlspecialchars(str_replace(".", ",", sprintf("%.2f€", $row['Preis Intern']))),"</td>";
                echo "<td>",htmlspecialchars(str_replace(".", ",", sprintf("%.2f€", $row['Preis Extern']))),"</td>";
                echo "<td>",htmlspecialchars($row['Allergen']),"</td>";
                ?>
                <!-- XSS Schwachstelle: Output from server -> client
                <td> <?php //echo implode('</td><td class = "preis">', $row); ?></td>
                -->
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>
<?php endif; ?>

<!-- die Liste der verwendeten Allergene -->
<div class = "allergen_legende">
    <h2> Allergen Legende</h2>
    <ul class ="text-muted">
        <?php foreach($allergene as $row): array_map('htmlentities', $row);?>
        <?php foreach($row as $element){
            echo "<li>",htmlspecialchars($element),"</li>";
            }?>
        <!-- XSS Schwachstelle: Output from server -> client
            <li><?php
                // echo implode('</li><li>',$row);
                ?></li> -->
        <?php endforeach; ?>
    </ul>
</div>
</body>
</html>
