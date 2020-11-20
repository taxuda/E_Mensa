<?php
/**
 * Praktikum DBWT. Autoren:
 * Sendar, Akcay, 3235196
 * Vorname2, Tran, 3255934
 */
include 'm2_4a_standardparameter.php';

const GET_ERSTE_ZAHL = 'a';
const GET_ZWEITE_ZAHL = 'b';
const GET_BUTTON_VALUE = 'button';
$result = false;

if(isset($_GET[GET_ERSTE_ZAHL])&&isset($_GET[GET_ZWEITE_ZAHL])){
    $a = (int)$_GET[GET_ERSTE_ZAHL];
    $b = (int)$_GET[GET_ZWEITE_ZAHL];
    if($_GET[GET_BUTTON_VALUE] === 'Addieren'){
        $result = addieren($a,$b);
    }
    else if($_GET[GET_BUTTON_VALUE] === 'Multiplizieren' ){
        $result = $a * $b;
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8"/>
    <title>Addrieren von zwei Zahlen</title>
    <style></style>
</head>
<body>
<form action="m2_4c_addform.php" method="get">
    <input type="text" name="a" value="<?php echo $_GET[GET_ERSTE_ZAHL]?>" required>
    <input type="text" name="b" value="<?php echo $_GET[GET_ZWEITE_ZAHL]?>"required>
    <input type="submit" name="button" value="Addieren">
    <input type="submit" name="button" value="Multiplizieren">
</form>
<?php
if($result !== false){
    echo "Das Ergebnis lautet: ", $result;
}
?>
</body>
</html>