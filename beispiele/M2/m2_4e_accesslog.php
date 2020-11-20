<?php
/**
 * Praktikum DBWT. Autoren:
 * Sendar, Akcay, 3235196
 * Vorname2, Tran, 3255934
 */
    $file = fopen('./accesslog.txt', 'a');
    if(!$file){
        die('Öffnen fehlgeschlagen');
    }
    else{
        $browser = "";
        // strpos checks whether a strings contains a substring
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE'))
            $browser = 'Internet explorer';
        else if(strpos($_SERVER['HTTP_USER_AGENT'], 'Trident'))
            $browser = 'Internet explorer';
        else if(strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox'))
            $browser = 'Mozilla Firefox';
        else if(strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome'))
            $browser =  'Google Chrome';
        else if(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini'))
            $browser = "Opera Mini";
        else if(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera'))
            $browser = "Opera";
        else if(strpos($_SERVER['HTTP_USER_AGENT'], 'Safari'))
            $browser = "Safari";
        else
            $browser = 'Something else';

        $UserIp = "$_SERVER[REMOTE_ADDR]";
        $Date = date("Y.m.d")." ".date("H:i")." Uhr ";
        $newline = $Date.$browser." ".$UserIp."\n";
        fwrite($file, $newline);
    }
    fclose($file);
?>
