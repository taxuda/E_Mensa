<?php
$suesskartoffleltaschen = [ // Kurzschreibweise für ein Array (entspricht = array())
    'name' => 'Süßkartoffeltaschen mit Frischkäse und Kräutern gefüllt',
    'description' => 'Die Süßkartoffeln werden vorsichtig aufgeschnitten und der Frischkäse eingefüllt.',
    'price_intern' => 2.90,
    'price_extern' => 3.90,
    'allergens' => [11, 13],
    'amount' => 42,  // Anzahl der verfügbaren Gerichte.
    'bild' => 'suesskartoffelBild.jpg'
];
$rindfleisch = [ // Kurzschreibweise für ein Array (entspricht = array())
    'name' => 'Rindfleisch mit Bambus, Kaiserschoten und rotem Paprika dazu Mie Nudeln',
    'description' => 'Sehr lecker!',
    'price_intern' => 3.50,
    'price_extern' => 6.20,
    'allergens' => [11, 13],
    'amount' => 42, // Anzahl der verfügbaren Gerichte.
    'bild' => 'rindfleischBild.jpg'
];
$spinatrisotto = [ // Kurzschreibweise für ein Array (entspricht = array())
    'name' => 'Spinatrisotto mit kleinen Samosateigecken und gemischter Salat',
    'description' => 'Die Süßkartoffeln werden vorsichtig aufgeschnitten und der Frischkäse eingefüllt.',
    'price_intern' => 2.90,
    'price_extern' => 5.30,
    'allergens' => [11, 13],
    'amount' => 42,   // Anzahl der verfügbaren Gerichte.
    'bild' => 'spinatrisottoBild.jpg'
];
$allergens = array(
    11 => 'Gluten',
    12 => 'Krebstiere',
    13 => 'Eier',
    14 => 'Fisch',
    17 => 'Milch'
);
$text1 = serialize($suesskartoffleltaschen);
$text2 = serialize($rindfleisch);
$text3 = serialize($spinatrisotto);
$text4 = serialize($allergens);
file_put_contents("suesskartoffeltaschen.txt",$text1);
file_put_contents("rindfleisch.txt",$text2);
file_put_contents("spinatrisotto.txt",$text3);


$text1 = serialize($suesskartoffleltaschen)."\n";
$text2 = serialize($rindfleisch)."\n";
$text3 = serialize($spinatrisotto)."\n";
$text4 = serialize($allergens)."\n";

file_put_contents("../daten/gerichte.csv",$text1,FILE_APPEND);
file_put_contents("../daten/gerichte.csv",$text2,FILE_APPEND);
file_put_contents("../daten/gerichte.csv",$text3,FILE_APPEND);

?>
