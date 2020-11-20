<?php
/**
 * Praktikum DBWT. Autoren:
 * Sendar, Akcay, 3235196
 * Vorname2, Tran, 3255934
 */
include 'm2_4a_standardparameter.php';
const ZAHL1 = 1;
const ZAHL2 = 2;
const ZAHL3 = 3;
const ZAHL4 = 4;
const ZAHL5 = 5;

echo 'Mehrfach addieren <br>';
echo "ZAHL1 + ZAHL2 = ".addieren(ZAHL1,ZAHL2)."<br>";
echo "ZAHL2 + ZAHL3 = ".addieren(ZAHL2,ZAHL3)."<br>";
echo "ZAHL3 + ZAHL4 = ".addieren(ZAHL3,ZAHL4)."<br>";
echo "ZAHL4 + ZAHL5 = ".addieren(ZAHL4,ZAHL5)."<br>";
echo "<br>";

echo "for-Schleifer zu automatisieren! <br>";
for($i = 1; $i < 5; $i++){
    $a = $i * 2;
    $b = $i * 3;
    echo "$a + $b = ".addieren($a,$b)."<br>";
}
?>

