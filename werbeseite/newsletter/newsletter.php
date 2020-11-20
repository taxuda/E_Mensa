<?php
const GET_PARAM_NAME = 'name';
const GET_PARAM_EMAIL = 'email';
const GET_PARAM_SPRACHE = 'languege';
const GET_PARAM_SUBMIT = 'submitted';
$fehler = false;
//Vorverarbeitung und nehmen die Daten
if($_POST[GET_PARAM_SUBMIT]){ //Submitted: Es gibt jetzt die Daten, die verarbeitet werden.
    $name = trim($_POST[GET_PARAM_NAME]??NULL);
    $email = $_POST[GET_PARAM_EMAIL];
    $sprache = $_POST[GET_PARAM_SPRACHE];
    //Eingabevalidierung

    if(!$name){//Name nicht leer ist!
        $fehler[] = "Name muss gesetzt sein!";
    }
    if (!filter_var($email,FILTER_VALIDATE_EMAIL)){//Email-Adrresse korrekt format ist!
        $fehler[] = "Bitte gültig Emailformat eingeben!";
    }
    elseif (strpos($email, "rcpt.at")
        ||strpos($email, "damnthespam.at")
        ||strpos($email, "wegwerfmail.de")
        ||strpos($email,"trashmail.")){
        $fehler[] = "Bitte kein Spamemail eingeben!";
    }
    if($fehler){//Fehler gefunden.
        $getFehler = true;
    }
    else{//Fehler nicht gefuden.
        $getFehler = false;
        //Speicherung
        if(!$getFehler){
            $line = ["Name" => $name,
                "Email" => $email,
                "Sprache" => $sprache,
                "Datenschutz" => "Ja"];
            $daten = serialize($line)."\n";
            file_put_contents("./daten/newsletter.csv",$daten, FILE_APPEND);
            $sucessed = true;
        }
    }
}

//var_dump($fehler); //test Fehler-Array


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>newletter_form</title>
</head>
<body>
<form id="newsletter" method="post" >
    <h2 id="Kontkt">Interesse geweckt? Wir informieren Sie!</h2>
    <?php if($getFehler){?>
        <div>
            <h3>Fehler:</h3>
            <ul>
                <?php foreach($fehler as $error): ?>
                    <li><?php echo $error;?></li>
                <?php endforeach;?>
            </ul>
        </div>
    <?php }?>
    <?php if($sucessed){?>
        <div>Newsletteranmeldung erfolgreich!</div>
    <?php }?>
    <fieldset>
        <!--first line -->
        <label for="name">Ihr Name:</label>
        <input type="text" id="name" value="<?php echo htmlspecialchars($name);?>"
               name="name" required>
        <label for="email">Ihre Email</label>
        <input type="text" id="email" value="<?php echo htmlspecialchars($email);?>"
               name="email" required>
        <label for="languege">Newsletter bitte in:</label>
        <select id="languege " name="languege">
            <option value ="de" <?php if($sprache == 'de'){ echo "selected";}?>>
                Deutsch</option>
            <option value ="en" <?php if($sprache == 'en'){ echo "selected";}?>>
                Englisch</option>
            <option value ="fr" <?php if($sprache == 'fr'){ echo "selected";}?>>
                Franzörisch</option>
        </select>
        <br>
        <!--second line-->
        <input type="checkbox" required>
        <label>Den Datenschutzbestimmungen stimme ich zu</label>
        <input type="submit" name="submitted" value="Zum Newsletter anmelden">
    </fieldset>
</form>
</body>
</html>
