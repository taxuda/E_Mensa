# EMensa_DBWT
E-Mensa für das Praktikumsprojekt der FH-Aachen DBWT 20/21.

Für M4-A2 alle Informationen über Security steht in Ordner security 
zu Verfügung.  
SECURITY STRATEGIES: Input Client->Server || Ouput Server->Client
1) Formular: Test Input from Client! found in newsletter.php, nl_admin.php and wunschgericht.
    ->Input Preprocessing and Validation
2) SQL Injektion: Found in wunschgericht.php
    -> Input-Mark, Prepared Statement.
3) XSS: html tags with php embedded
    -> htmlspecialchars()
        all output from server to client in html
    -> htmlspecialchars()