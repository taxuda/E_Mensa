<?php
/**
 * Praktikum DBWT. Autoren:
 * Sendar, Akcay, 3235196
 * Dat, Tran, 3255934
 */
?>
<!DOCTYPE html>
<html lang="de">
    <head>
     <meta charset="UTF-8" />
        <title>E-Mensa</title>
        <style></style>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="styling.css">
    </head>
    <body>
    <div class="grid-container">
        <div class="r1">
            <nav class="navbar navbar-expand-lg navbar-light bg-light rounded">
                <div class="collapse navbar-collapse justify-content-md-center" id="navbarsExample08">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="navbar-brand" href="#">E-Mensa Logo</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="r2">
            <nav class="navbar navbar-expand-lg navbar-light bg-light rounded">
                <div class="collapse navbar-collapse" id="OOF">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#Ankuendigung">Ankündigung</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#Speisen">Speisen</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#Zahlen">Zahlen</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#Kontkt">Kontkt</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#Wichtig">Wichtig für uns</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="r3"></div>
        <div class="r4">
            <h2 id="Ankündigung">Bald gibt es Essen auch online ;)</h2>
            <p class="t1">"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
                "Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>

            <h2 id="Speisen">Köstlichkeiten, die Sie erwarten</h2>
            <!-- Table der Gerichten -->
            <!-- List of Allergen -->
            <?php include './gericht/gerichtAusDB.php'; ?>

            <!-- Platzhalter für Zahlen -->
            <?php include './count/count.php';?>

            <!-- Newsletterform -->
            <?php include './newsletter/newsletter.php' ?>


            <h2 id="Wichtig">Das ist uns wichtig</h2>
            <ul class="center-ul">
                <li>Beste frische saisonale Zutaten</li>
                <li>Ausgewogene abwechslungsreiche Gerichte</li>
                <li>Sauberkeit</li>
            </ul>
            <h2 style="text-align: center; padding-bottom: 20px">Wir freuen uns auf Ihren Besuch!</h2>

        </div>
    </div>

    <footer>
        <ul>
            <li>(c) E-Mensa GmbH</li>
            <li>Serdar Akcay & Xuan Dat Tran</li>
            <li><a href="#">Impressum</a></li>
        </ul>
    </footer>
    </body>
</html>
