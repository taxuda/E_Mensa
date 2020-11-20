<?php
/**
 * Praktikum DBWT. Autoren:
 * Sendar, Akcay, 3235196
 * Dat, Tran, 3255934
 */
const GET_PARAM_SORT_TYPE = 'sortType';
const GET_PARAM_SORTING = 'sorting';
const GET_PARAM_SEARCH_NAME = 'search_name';

function csvLinesIntoArray($csvfile){
    while(!feof($csvfile)) {
        // insert each csv line as element-array
        if (($line = fgetcsv($csvfile)) !== false) {
            $element = unserialize($line[0]);
            // insert element into $newsletter
            $result[] = $element;
        }
    }
    return $result;
}

//Inhalte für Tabelle aus Datei zum $newsletter einlesen!
$filename = fopen("./daten/newsletter.csv","r");
$newsletter = csvLinesIntoArray($filename);
/**
var_dump($newsletter);
echo "<br>";
ksort($newsletter);
var_dump($newsletter);
 */
fclose($filename);

function sorting($datenhaltung, $sort_type){
    // make the new array $result from $datenhaltung
    // $result = ['key' => 'element'] compared to $datenhaltung = ['element']
    foreach($datenhaltung as $element){
        // key = Name or key = Value
        $key = $element[$sort_type];
        // insert element into $result array with key
        $result["$key"] = $element;
    }
    // sorting $result by key
    ksort($result);
    return $result;
}
// Sorting by Name or Email
if(isset($_GET[GET_PARAM_SORTING])){
    $newsletter = sorting($newsletter, $_GET[GET_PARAM_SORT_TYPE]);
}

// suchen nach Name
function suchenNachName($search_name, $datenhaltung){
    foreach($datenhaltung as $element){
        if(stripos($element["Name"],$search_name) !== false){
            $search_result[] = $element;
        }
    }
    return $search_result;
}
// Suchen nach Name
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
    <!-- Search Filter-->
    <form method="get">
        <label for="search_name">Filter nach Name:</label>
        <input id="search_name" type="text" name="search_name" value="<?php echo $_GET[GET_PARAM_SEARCH_NAME]; ?>">
        <input type="submit" value="Suchen">
    </form>
    <!-- End Of Search Filter-->
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