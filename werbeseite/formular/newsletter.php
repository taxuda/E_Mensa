<?php
const POST_PARAM_NAME = 'name';
const POST_PARAM_EMAIL = 'email';
const POST_PARAM_SPRACHE = 'languege';
const LENGTH_NAME = 80;
const LENGTH_EMAIL = 320;
//const GET_PARAM_SUBMIT = 'submitted';
// define variables and set to empty values
$name = $email = ""; // define params data
$nameErr = $emailErr = "";      // define errors
include 'input_preprocessing_validation.php';
// PREPROCESSING AND VALIDATION INPUT DATEN
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $sprache = $_POST[POST_PARAM_SPRACHE];
    if (empty($_POST[POST_PARAM_NAME])) {
        $nameErr = "Name is required";
    } else {
        $name = test_input($_POST[POST_PARAM_NAME] ?? null);
        $name = test_input($name);
        // check if name only contains letters and whitespace and valid length
        $nameErr = validName($name, LENGTH_NAME);
    }
    if (empty($_POST[POST_PARAM_EMAIL])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST[POST_PARAM_EMAIL] ?? null);
        $email = test_input($email);
        // check if email in correct format, valid length and not predefined junk mails
        $emailErr = validMail($email, LENGTH_EMAIL);
    }
}

$isErr = ($nameErr || $emailErr);
if($_SERVER["REQUEST_METHOD"] == "POST" || !$isErr) { // if input data valid, save into datei
    $line = ["Name" => $name,
            "Email" => $email,
            "Sprache" => $sprache,
            "Datenschutz" => "Ja"];
    $daten = serialize($line)."\n";
    file_put_contents("./daten/newsletter.csv",$daten, FILE_APPEND);
}
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
    <?php if($isErr){?>
        <div>
            <h3>Fehler:</h3>
            <ul>
                <?php if($nameErr){ ?>
                    <li><?php echo $nameErr;?></li>
                <?php }?>
                <?php if($emailErr){ ?>
                    <li><?php echo $emailErr;?></li>
                <?php }?>
            </ul>
        </div>
    <?php }?>
    <?php if($_SERVER["REQUEST_METHOD"] == "POST" || !$isErr){?>
        <div>Newsletteranmeldung erfolgreich!</div>
    <?php }?>
    <fieldset>
        <!--first line -->
        <label for="name">Ihr Name:</label>
        <input type="text" id="name" value="<?php echo htmlspecialchars(isset($name)?$name:'');?>"
               name="name" required><br>
        <label for="email">Ihre Email</label>
        <input type="text" id="email" value="<?php echo htmlspecialchars(isset($email)?$email:'');?>"
               name="email" required><br>
        <label for="languege">Newsletter bitte in:</label>
        <select id="languege " name="languege">
            <option value ="de" <?php if(isset($sprache) && $sprache == 'de'){ echo "selected";}?>>
                Deutsch</option>
            <option value ="en" <?php if(isset($sprache) && $sprache == 'en'){ echo "selected";}?>>
                Englisch</option>
            <option value ="fr" <?php if(isset($sprache) && $sprache == 'fr'){ echo "selected";}?>>
                Franzörisch</option>
        </select>
        <br>
        <!--second line-->
        <input type="checkbox" required>
        <label>Den Datenschutzbestimmungen stimme ich zu</label><br>
        <input type="submit" name="submitted" value="Zum Newsletter anmelden">
    </fieldset>
</form>
</body>
</html>
