Für M4-A2 alle Informationen über Security steht in Ordner security 
zu Verfügung.  
SECURITY STRATEGIES: Input Client->Server || Ouput Server->Client
1) Formular: Genaral->Test Input from Client! 
(found in newsletter.php, nl_admin.php and wunschgericht.php)
    ->Input Preprocessing and Validation
2) SQL Injektion: (found in wunschgericht.php)
    -> Input-Mark, Prepared Statement.
3) XSS: html tags with php embedded
    -> htmlspecialchars()
        all output from server to client in html
    -> htmlspecialchars()
    (found in all formulars and output from server -> client)
