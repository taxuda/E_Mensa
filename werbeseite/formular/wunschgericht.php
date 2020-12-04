<?php
// Daten aus Formular in DB eintragen
// Daten wg_submit, wg_name, wg_beschreibung, es_name, es_email
// const POST_PARAM_WUNSCHGERICHT_SUBMITTED = 'wunschgericht_submit';

const POST_PARAM_NAME = 'wunschgericht_name';
const POST_PARAM_BESCHREIBUNG = 'wunschgericht_beschreibung';
const POST_PARAM_ERSTELLERIN_NAME = 'erstellerIn_name';
const POST_PARAM_ERSTELLERIN_EMAIL = 'erstellerIn_email';
const LENGTH_NAME = 80;
const LENGTH_EMAIL = 320;
const LENGTH_BESCHREIBUNG = 800;
// define variables and set to empty values
$name = $beschreibung = $erstellerIn_name = $erstellerIn_email = "";
$nameErr = $beschreibungErr = $erstellerIn_nameErr = $erstellerIn_emailErr = "";

include 'input_preprocessing_validation.php';
// PREPROCESSING AND VALIDATION INPUT DATEN
if ($_SERVER["REQUEST_METHOD"] == "POST") { // Tien hanh xu ly du lieu hoac khong
    // TIEN XU LY DU LIEU
    if(empty($_POST[POST_PARAM_NAME])){
        $nameErr = "Name of Gericht is required";
    }else{
        $name = test_input($_POST[POST_PARAM_NAME] ?? null);
        $name = test_input($name);
        // check if name only contains letters and whitespace and valid length
        $nameErr = validName($name,LENGTH_NAME);
    }
    if(empty($_POST[POST_PARAM_ERSTELLERIN_NAME])){
        $erstellerIn_name = "anonym";
        $erstellerIn_nameErr = "";
    }else{
        $erstellerIn_name = test_input($_POST[POST_PARAM_ERSTELLERIN_NAME] ?? null);
        $erstellerIn_name = test_input($erstellerIn_name);
        // check if name only contains letters and whitespace and valid length
        $erstellerIn_nameErr = validName($erstellerIn_name,LENGTH_NAME);
    }
    if(empty($_POST[POST_PARAM_ERSTELLERIN_EMAIL])){
        $erstellerIn_emailErr = "Email is required";
    }else{
        $erstellerIn_email = test_input($_POST[POST_PARAM_ERSTELLERIN_EMAIL] ?? null);
        $erstellerIn_email = test_input($erstellerIn_email);
        // check if email in correct format, valid length and not predefined junk mails
        $erstellerIn_emailErr = validMail($erstellerIn_email, LENGTH_EMAIL);
    }
    if(empty($_POST[POST_PARAM_BESCHREIBUNG])){
        $beschreibungErr = "Beschreibung is required";
    }else{
        $beschreibung = test_input($_POST[POST_PARAM_BESCHREIBUNG] ?? null);
        $beschreibung = test_input($beschreibung);
        // check if beschreibung only contains letters and whitespace and valid length
        $beschreibungErr = validComment($beschreibung, LENGTH_BESCHREIBUNG);
    }
}

// In DB eintrage, insert into name, beschreibung, es_name, es_email
if(($_SERVER["REQUEST_METHOD"] == "POST")&&!($nameErr||$beschreibungErr||$erstellerIn_emailErr||$erstellerIn_nameErr)){

    $mysql_con = mysqli_connect("127.0.0.1","ich","kekw123","emensawerbeseite");
    // BEGIN TRANSACTION
    mysqli_begin_transaction($mysql_con);

    // INPUT-MASK
    $name = mysqli_real_escape_string($mysql_con,$name);
    $beschreibung = mysqli_real_escape_string($mysql_con,$beschreibung);
    $erstellerIn_name = mysqli_real_escape_string($mysql_con,$erstellerIn_name);
    $erstellerIn_email = mysqli_real_escape_string($mysql_con,$erstellerIn_email);

    // PREPARED STATEMENT
    $query = [
        'wunsch_eintrag' => "INSERT INTO Wunschgerichte (name, beschreibung) VALUES ( ? , ? )",
        'ersteller_eintrag' => "INSERT INTO Ersteller (name, email) VALUES ( ? , ? )",
        'verfasst_eintrag' => "INSERT INTO verfasst(id_wunsch, id_ersteller, erstellt_am) VALUES ( ? , ? ,now())"
    ];
    if (!isset($erstellerIn_name)){
        $query = array_replace($query,array('ersteller_eintrag' => "INSERT INTO Ersteller (email) VALUES ( ? )"));
    }

    try {
        //INSERT TO Wunschgericht
        $stmt_wunsch = mysqli_prepare($mysql_con,$query['wunsch_eintrag']);
        mysqli_stmt_bind_param($stmt_wunsch, 'ss', $name,$beschreibung);
        mysqli_stmt_execute($stmt_wunsch);

        //INSERT TO Ersteller
        $stmt_ersteller = mysqli_prepare($mysql_con,$query['ersteller_eintrag']);
        if (empty($erstellerIn_name)){
            mysqli_stmt_bind_param($stmt_ersteller, 's', $erstellerIn_email);
        }else{
            mysqli_stmt_bind_param($stmt_ersteller, 'ss', $erstellerIn_name, $erstellerIn_email);
        }
        mysqli_stmt_execute($stmt_ersteller);

        $query = array_replace($query,array('verfasst_eintrag' => "INSERT INTO verfasst(id_wunsch, id_ersteller, erstellt_am) VALUES ( $stmt_wunsch->insert_id , $stmt_ersteller->insert_id ,now())"));

        //INSERT TO verfasst
        $stmt = mysqli_prepare($mysql_con,$query['verfasst_eintrag']);
        mysqli_stmt_execute($stmt);

        // transaktion
        mysqli_commit($mysql_con);

    } catch (mysqli_sql_exception $exception) {
        mysqli_rollback($mysql_con);

        throw $exception;
    }
}
?>
<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="UTF-8">
        <title>Wunschgericht</title>
        <style>
            .error {color: #FF0000;}
        </style>
    </head>
    <body>
        <h2>Wunschgericht Formular</h2>
        <p><span class="error">* required field</span></p>
    <!-- formular um Wunschgericht zu erstellen -->
        <form method="post" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>>
            <label for="wunschgericht_name">Name des Wunschgerichts:</label><br>
            <input type="text" maxlength="80" id="wunschgericht_name" name="wunschgericht_name"
                   value="<?php echo $name; ?>"required>
            <span class="error">* <?php echo $nameErr;?></span>
            <br>

            <label for="erstellerIn_name">Name des Authors (optional):</label><br>
            <input type="text" maxlength="80" id="erstellerIn_name" name="erstellerIn_name"
                   value="<?php echo $erstellerIn_name;?>">
            <br>

            <label for="erstellerIn_email">Email des Authors:</label><br>
            <input type="text" maxlength="320" id="erstellerIn_email" name="erstellerIn_email"
                   value="<?php echo $erstellerIn_email;?>" required>
            <span class="error">* <?php echo $erstellerIn_emailErr;?></span>
            <br>

            <label for="wunschgericht_beschreibung">Beschreibung:</label><br>
            <textarea maxlength="800" rows="4" cols="50" id="wunschgericht_beschreibung" name="wunschgericht_beschreibung" required>
                <?php echo $beschreibung; ?>
            </textarea>
            <span class="error">* <?php echo $beschreibungErr;?></span>
            <br>

            <input type="submit" name="wunschgericht_submit" value="Wunsch abschicke">
        </form>
    </body>
</html>
