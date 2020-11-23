<?php
$link = mysqli_connect(
    "127.0.0.1",            // Host der Datenbank
    "root",                 // Benutzername zur Anmeldung
    "root",             // Passwort
    "emensawerbeseite", // Auswahl der Datenbanken (bzw. des Schemas)
// optional port der Datenbank
);

if (!$link) {
    echo "Verbindung fehlgeschlagen: ", mysqli_connect_error();
    exit();
}
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
    <table>
        <thead>
        <tr>
            <th><?php echo implode('</th><th>', array_keys(current($table))); ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($table as $row): array_map('htmlentities', $row); ?>
            <tr>
                <td><?php echo implode('</td><td class = "preis">', $row); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
</body>
</html>
