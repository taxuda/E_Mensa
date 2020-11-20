<?php
/**
 * Praktikum DBWT. Autoren:
 * Sendar, Akcay, 3235196
 * Vorname2, Tran, 3255934
 */
$famousMeals = [
    1 => ['name' =>'Currywurst mit Pommes',
          'winner' => [2001, 2003, 2007, 2010, 2020] ],
    2 => ['name' =>'Hähnchencrossies mit Paprikareis',
          'winner' => [2002, 2004, 2008] ],
    3 => ['name' =>'Spaghetti Bolonese',
          'winner' => [2011, 2012, 2017] ],
    4 => ['name' =>'Jägerschnizel mit Pommes',
          'winner' => [2019] ]
];
const BEGINN_YEAR = 2000;
const EVENTUELL_YEAR = 2020;
$notWinnerYears = array_fill(BEGINN_YEAR, EVENTUELL_YEAR - BEGINN_YEAR + 1, true);
//Tao index nhu la nam.
function notWinnerYears($famousMeals, $notWinnerYears){
    // Gap mot nam trong $famousMeals: NAM THANG
    // $notWinnerYears[NAM THANG] = false
    // Cuoi cung chi con NHUNG NAM KHONG THANG
    // $notWinnerYear[NHUNG NAM KHONG THANG] = true;
    foreach($famousMeals as $meal){
        foreach($meal['winner'] as $year){
            $notWinnerYears[(int)$year] = false;
        }
    }
    for($i = BEGINN_YEAR; $i < EVENTUELL_YEAR + 1; $i++){
        //$notWinnerYear[NHUNG NAM KHONG THANG] = true;
        // In ra NHUNG NAM KHONG THANG === index
        if($notWinnerYears[$i]){
            echo "<p>$i<br></p>";
        }
    }
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>The most famous meals!</title>
        <style>
            li{
                margin-bottom: 5px;
            }
        </style>
    </head>
    <body>
        <ol>
            <?php
            foreach($famousMeals as $meals){
                echo "<li>".$meals['name']."<br>";
                $count = count($meals['winner']);
                foreach($meals['winner'] as $year){
                    $count--;
                    if($count > 0){ echo $year.", ";}
                    else{ echo $year;}
                }
                echo "</li>";
            }
            ?>
        </ol>
        <h4>In diesen Jahren ab 2000 bis heute keine Gewinner existieren.</h4>
        <?php
            notWinnerYears($famousMeals, $notWinnerYears);
        ?>
    </body>
</html>
