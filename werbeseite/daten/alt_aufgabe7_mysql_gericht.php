<?php
/**
 * Praktikum DBWT. Autoren:
 * Sendar, Akcay, 3235196
 * Dat, Tran, 3255934
 */
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

$sql = "SELECT name, preis_intern, preis_extern FROM gericht ORDER BY name ASC LIMIT 5";

$result1 = mysqli_query($link, $sql);
if (!$result1) {
    echo "Fehler während der Abfrage:  ", mysqli_error($link);
    exit();
}

$sql = "SELECT name, GROUP_CONCAT(gericht_hat_allergen.code) AS allergene FROM gericht
JOIN gericht_hat_allergen ON gericht.id = gericht_hat_allergen.gericht_id GROUP BY gericht_hat_allergen.gericht_id ORDER BY gericht.name";

$result2 = mysqli_query($link, $sql);
if (!$result2) {
    echo "Fehler während der Abfrage:  ", mysqli_error($link);
    exit();
}

while ($row = mysqli_fetch_assoc($result1)) {
    echo '<tr>';

    echo "<td>".$row['name']."</td>";
    echo "<td>".str_replace(".", ",", sprintf("%.2f€", $row['preis_intern']))."</td>";
    echo "<td>".str_replace(".", ",", sprintf("%.2f€", $row['preis_extern']))."</td>";
    echo "<td>";
    while ($row1 = mysqli_fetch_assoc($result2)) {
        if ($row['name'] === $row1['name']) {
            echo $row1['allergene'];
        }
    }
    $result2 = mysqli_query($link, $sql);
    echo "</td>";

    echo '</tr>';
}

mysqli_free_result($result1);
mysqli_free_result($result2);
mysqli_close($link);

/*SELECT gericht.name, GROUP_CONCAT(gericht_hat_allergen.code) AS allergene FROM gericht
JOIN gericht_hat_allergen ON gericht.id = gericht_hat_allergen.gericht_id GROUP BY gericht_hat_allergen.gericht_id ORDER BY gericht.name;

SELECT gericht.name, gericht_hat_allergen.code AS allergene FROM gericht
LEFT JOIN gericht_hat_allergen ON gericht.id = gericht_hat_allergen.gericht_id ORDER BY gericht.name;
*/
?>
<!DOCTYPE html>
<html>
<h2 id="Speisen">Köstlichkeiten, die Sie erwarten</h2>
<div class="preis">
    <table>
        <tr>
            <th></th>
            <th>Preis intern</th>
            <th>Preis extern</th>
            <th></th>
        </tr>
        <?php include 'alt_aufgabe7_mysql_gericht.php'; ?>
        <tr>
            <td>...</td>
            <td>...</td>
            <td>...</td>
            <td>...</td>
        </tr>
    </table>
</div>
</html>

