<?php
const GET_PARAM_MIN_STARS = 'search_min_stars';
const GET_PARAM_SEARCH_TEXT = 'search_text';
const GET_PARAM_SHOW_DESCRIPTION =  'show_description';
const GET_PARAM_LANGUEGE = 'used_languege';

$languege = [
        'de' => [
                'Gericht: ',
                'Bewertungen(Insgesamt:',
                'Die zugehörigen Allergene zum Gericht',
                'Suchen',
                'Sterne',
                'Autor',
                'p' => 'Preise',
                'ip' => 'Interner Preis: ',
                'xp' => 'Externer Preis: '
        ],
        'en' => [
            'Dish: ',
            'Reviews(Total:',
            'The associated allergens to the dish',
            'Search',
            'Stars',
            'Author',
            'p' => 'Price',
            'ip' => 'Internal price: ',
            'xp' => 'External price: '
        ]
];

$showLanguege = $languege['de'];
if($_GET[GET_PARAM_LANGUEGE]==='en'){
    $showLanguege = $languege['en'];
}

/**
 * Liste aller möglichen Allergene.
 */
$allergens = array(
    11 => 'Gluten',
    12 => 'Krebstiere',
    13 => 'Eier',
    14 => 'Fisch',
    17 => 'Milch'
);

$meal = [ // Kurzschreibweise für ein Array (entspricht = array())
    'name' => 'Süßkartoffeltaschen mit Frischkäse und Kräutern gefüllt',
    'description' => 'Die Süßkartoffeln werden vorsichtig aufgeschnitten und der Frischkäse eingefüllt.',
    'price_intern' => 2.90,
    'price_extern' => 3.90,
    'allergens' => [11, 13],
    'amount' => 42   // Anzahl der verfügbaren Gerichte.
];

$ratings = [
    [   'text' => 'Die Kartoffel ist einfach klasse. Nur die Fischstäbchen schmecken nach Käse. ',
        'author' => 'Ute U.',
        'stars' => 2 ],
    [   'text' => 'Sehr gut. Immer wieder gerne',
        'author' => 'Gustav G.',
        'stars' => 4 ],
    [   'text' => 'Der Klassiker für den Wochenstart. Frisch wie immer',
        'author' => 'Renate R.',
        'stars' => 4 ],
    [   'text' => 'Kartoffel ist gut. Das Grüne ist mir suspekt.',
        'author' => 'Marta M.',
        'stars' => 3 ]
];

$showRatings = [];
if (!empty($_GET[GET_PARAM_SEARCH_TEXT])) {
    $searchTerm = $_GET[GET_PARAM_SEARCH_TEXT];
    foreach ($ratings as $rating) {
        //Returns the position of the first occurrence of a string inside another string (case-insensitive)
        if (stripos($rating['text'], $searchTerm) !== false) {
            $showRatings[] = $rating;
        }
    }
} elseif (!empty($_GET[GET_PARAM_MIN_STARS])) {
    $minStars = $_GET[GET_PARAM_MIN_STARS];
    foreach ($ratings as $rating) {
        if ($rating['stars'] >= $minStars) {
            $showRatings[] = $rating;
        }
    }
} else {
    $showRatings = $ratings;
}

function calcMeanStars($ratings) : float { // : float gibt an, dass der Rückgabewert vom Typ "float" ist
    $sum = (float) 0;
    //$i = 1;
    foreach ($ratings as $rating) {
        //$sum += $rating['stars'] / $i;
        //$i++;
        $sum += $rating['stars'];
    }
    return $sum / count($ratings);
}

?>
<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="UTF-8"/>
        <title>Gericht: <?php echo $meal['name']; ?></title>
        <style type="text/css">
            * {
                font-family: Arial, serif;
            }
            .rating {
                color: darkgray;
            }

            footer{
                margin-left: 0%;
                text-align: right;}

            footer>ul li{
                display: inline;
            }

            a:link {
                color: blue;
                background-color: transparent;
                text-decoration: none;
            }
            a:visited {
                color: pink;
                background-color: transparent;
                text-decoration: none;
            }
            a:hover {
                color: blue;
                background-color: transparent;
                text-decoration: underline;
            }
            a:active {
                color: yellow;
                background-color: transparent;
                text-decoration: underline;
        </style>
    </head>
    <body>
        <h1><?php echo $showLanguege[0], $meal['name']; ?></h1>
        <p><?php echo $meal['description']; ?></p>
        <h1><?php echo $showLanguege[1],calcMeanStars($ratings); ?>)</h1>
        <!--add them danh sach thanh phan gay di ung -->
        <h1> <?php echo $showLanguege[2]; ?></h1>
        <ul>
            <?php
            foreach($allergens as $allergen){
                echo "<li>$allergen</li>";
            }
            ?>
        </ul>

        <!-- add gia cua san pham. Descriptionlist-->
        <h1><?php echo $showLanguege['p'];?></h1>
        <ul>
            <?php
                echo "<li>", $showLanguege['ip'],number_format($meal['price_intern'],2);"</li>";
                echo "<li>", $showLanguege['xp'],number_format($meal['price_extern'],2);"</li>";
            ?>
        </ul>

        <form method="get">
            <label for="search_text">Filter:</label>
            <input id="search_text" type="text" name="search_text" value="<?php echo $_GET[GET_PARAM_SEARCH_TEXT] ?>">
            <input type="submit" value="<?php echo $showLanguege[3]; ?>">
        </form>
        <table class="rating">
            <thead>
            <tr>
                <?php
                echo "<td>Text</td>";
                echo "<td>$showLanguege[4]</td>";
                echo "<td>$showLanguege[5]</td>";
                ?>
            </tr>
            </thead>
            <tbody>
            <?php
        foreach ($showRatings as $rating) {
            echo "<tr><td class='rating_text'>{$rating['text']}</td>
                      <td class='rating_stars'>{$rating['stars']}</td>
                      <td class='rating_autor'>{$rating['author']}</td>
                  </tr>";
        }
        ?>
            </tbody>
        </table>
        <footer>
            <ul>
                <li><a href="http://localhost:9050/meal.php?used_languege=de">de</a></li>
                <li><a href="http://localhost:9050/meal.php?used_languege=en">en</a></li>
            </ul>
        </footer>
    </body>
</html>