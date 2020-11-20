<?php
/**
 * Praktikum DBWT. Autoren:
 * Sendar, Akcay, 3235196
 * Dat, Tran, 3255934
 */
const GET_PARAM_SORT_TYPE = 'sortType';
const GET_PARAM_SORTING = 'sorting';
const GET_PARAM_SEARCH_NAME = 'search_name';

// Funktion: Inhalte für Tabelle aus Datei einlesen!
$filename = fopen("./daten/newsletter.csv","r");
if(isset($_GET[GET_PARAM_SORTING])){// with sorting
    while(!feof($filename)){
        // insert csv line as element-array
        if(($line=fgetcsv($filename))!== false){
            $element = unserialize($line[0]);
            // insert element into $newsletter array with key
            // key = Name or key = Value
            $key = $element[$_GET[GET_PARAM_SORT_TYPE]];
            $newsletter["$key"] = $element;
            // sorting $newsletter by key
            ksort($newsletter);
        }
    }
}else{// without sorting
    while(!feof($filename)) {
        // insert each csv line as element-array
        if (($line = fgetcsv($filename)) !== false) {
            $element = unserialize($line[0]);
            // insert element into $newsletter without sorting
            $newsletter[] = $element;
        }
    }
}
/**
var_dump($newsletter);
echo "<br>";
ksort($newsletter);
var_dump($newsletter);
*/
fclose($filename);

//Funktion: Suchen nach Name
function suchenNachName($search_name, $datenhaltung){
    foreach($datenhaltung as $element){
        if(stripos($element["Name"],$search_name) !== false){
            $search_result[] = $element;
        }
    }
    return $search_result;
}

if(isset($_GET[GET_PARAM_SEARCH_NAME])){
    $newsletter = suchenNachName($_GET[GET_PARAM_SEARCH_NAME], $newsletter);
}
?>

<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="UTF-8">
        <title>Newsletter Verwaltung</title>
    </head>
    <body>
    <form method="get">
        <label for="search_name">Filter nach Name:</label>
        <input id="search_name" type="text" name="search_name" value="<?php echo $_GET[GET_PARAM_SEARCH_NAME]; ?>">
        <input type="submit" value="Suchen">
    </form>
    <!--Table of Newsletter Anmelder-->
    <?php if (count($newsletter) > 0): ?>
        <table>
            <thead>
            <tr>
                <th><?php echo implode('</th><th>', array_keys(current($newsletter))); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($newsletter as $row): array_map('htmlentities', $row); ?>
                <tr>
                    <td><?php echo implode('</td><td>', $row); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
    <!--End of Table of Newsletter Anmelder-->
    <!--Sortierung Formular-->
    <p><strong>Sortierung bei:</strong></p>
    <form action="nl-admin.php" method="get">
        <label for="NameSort">Name</label>
        <input type="radio" id="NameSort" name="sortType" value="Name">
        <label for="EmailSort">Email</label>
        <input type="radio" id="EmailSort" name="sortType" value="Email"><br>
        <input type="submit" name="sorting" value="Sorting">
    </form>
    <!--End of Sortierung Formular-->
    </body>
</html>