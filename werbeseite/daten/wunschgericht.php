<!DOCTYPE HTML>
<html>
    <head>
        <title>wunschgericht</title>
    </head>
    <body>
        <form action="wunschgericht.php" method="post">
            <label for="wunschgericht_name">Name des Wunschgerichts:</label><br>
            <input type="text" required id="wunschgericht_name" name="wunschgericht_name" maxlength="100" /><br><br>

            <label for="ersteller_name">Name des Authors (optional):</label><br>
            <input type="text" name="ersteller_name" id="ersteller_name" maxlength="100" /><br><br>

            <label for="ersteller_email">Email des Authors:</label><br>
            <input type="email" required name="ersteller_email" id="ersteller_email" maxlength="100" /><br><br>

            <label for="wunschgericht_beschreibung">Beschreibung:</label><br>
            <textarea required name="wunschgericht_beschreibung" id="wunschgericht_beschreibung" rows="4" cols="50" maxlength="255"></textarea>

            <br><input type="submit" name="submit" value="Wunsch abschicke"></input>
        </form>
    </body>
</html>

<?php
if (isset($_POST['submit'])){
    $link=mysqli_connect("127.0.0.1", // Host der Datenbank
        "ich",                 // Benutzername zur Anmeldung
        "kekw123",    // Passwort
        "emensawerbeseite"      // Auswahl der Datenbanken (bzw. des Schemas)
// optional port der Datenbank
    );

    if (!$link) {
        echo "Verbindung fehlgeschlagen: ", mysqli_connect_error();
        exit();
    }

    $mysql_con = mysqli_connect("127.0.0.1","ich","kekw123","emensawerbeseite");

    $query = [
            'wunsch_eintrag' => "INSERT INTO Wunschgerichte (name, beschreibung) VALUES ( ? , ? )",
            'ersteller_eintrag' => "INSERT INTO Ersteller (name, email) VALUES ( ? , ? )",
            'verfasst_eintrag' => "INSERT INTO verfasst(id_wunsch, id_ersteller, erstellt_am) VALUES ( ? , ? ,now())"
    ];



    if (empty($_POST['ersteller_name'])){
        $query = array_replace($query,array('ersteller_eintrag' => "INSERT INTO Ersteller (email) VALUES ( ? )"));
    }

    mysqli_begin_transaction($mysql_con);

    try {
        //INSERT TO Wunschgericht
        $stmt_wunsch = mysqli_prepare($mysql_con,$query['wunsch_eintrag']);
        mysqli_stmt_bind_param($stmt_wunsch, 'ss', $_POST['wunschgericht_name'],$_POST['wunschgericht_beschreibung']);
        mysqli_stmt_execute($stmt_wunsch);

        //INSERT TO Ersteller
        $stmt_ersteller = mysqli_prepare($mysql_con,$query['ersteller_eintrag']);
        if (empty($_POST['ersteller_name'])){
            mysqli_stmt_bind_param($stmt_ersteller, 's', $_POST['ersteller_email']);
        }else{
            mysqli_stmt_bind_param($stmt_ersteller, 'ss', $_POST['ersteller_name'], $_POST['ersteller_email']);
        }
        mysqli_stmt_execute($stmt_ersteller);

        $query = array_replace($query,array('verfasst_eintrag' => "INSERT INTO verfasst(id_wunsch, id_ersteller, erstellt_am) VALUES ( $stmt_wunsch->insert_id , $stmt_ersteller->insert_id ,now())"));

        //INSERT TO verfasst
        $stmt = mysqli_prepare($mysql_con,$query['verfasst_eintrag']);
        mysqli_stmt_execute($stmt);

        mysqli_commit($mysql_con);

    } catch (mysqli_sql_exception $exception) {
        mysqli_rollback($mysql_con);

        throw $exception;
    }
}

/*
if (isset($_POST['submit'])){
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

    $statement = mysqli_stmt_init($link);
    $query1 = "INSERT INTO Wunschgerichte (name, beschreibung) VALUES ( ? , ? )";
    $query2 = "INSERT INTO Ersteller (name, email) VALUES ( ? , ? )";

    if (empty($_POST['ersteller_name'])){
        $query2 = "INSERT INTO Ersteller (email) VALUES ( ? )";
        var_dump($query2);
    }


    mysqli_stmt_prepare($statement,$query1);
    mysqli_stmt_bind_param($statement, 'ss',
        $_POST['wunschgericht_name'],
        $_POST['wunschgericht_beschreibung']
    );
    mysqli_stmt_execute($statement);

    mysqli_stmt_prepare($statement,$query2);

    if (empty($_POST['ersteller_name'])){
        mysqli_stmt_bind_param($statement, 's',
            $_POST['ersteller_email']
        );
    }else{
        mysqli_stmt_bind_param($statement, 'ss',
            $_POST['ersteller_name'],
            $_POST['ersteller_email']
        );
    }

    mysqli_stmt_execute($statement);

    $q_wkey = "SELECT id FROM Wunschgerichte ORDER BY id DESC LIMIT 1";
    mysqli_stmt_prepare($statement,$q_wkey);
    mysqli_stmt_execute($statement);
    $res = mysqli_stmt_get_result($statement);
    $wkey = mysqli_fetch_array($res);

    $q_ekey = "SELECT id FROM Ersteller ORDER BY id DESC LIMIT 1";
    mysqli_stmt_prepare($statement,$q_ekey);
    mysqli_stmt_execute($statement);
    $res = mysqli_stmt_get_result($statement);
    $ekey = mysqli_fetch_array($res);

    $query3 = "INSERT INTO verfasst(id_wunsch, id_ersteller, erstellt_am) VALUES ( ? , ? ,now())";
    mysqli_stmt_prepare($statement,$query3);
    mysqli_stmt_bind_param($statement, 'ss',
        $wkey[0],
        $ekey[0]
    );

    mysqli_stmt_execute($statement);



//$result1 = mysqli_stmt_get_result($statement);

//mysqli_free_result($result1);
    mysqli_close($link);
}
*/
?>