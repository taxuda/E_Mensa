<?php
$link= mysqli_connect(
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
$sql = "SELECT id, name, beschreibung FROM gericht";

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
        <title>test datenbank</title>
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
                    <td><?php echo implode('</td><td>', $row); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
    </body>
</html>
