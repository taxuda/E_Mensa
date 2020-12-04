<?php
// INPUT PREPROCESSING
/**
 * there is problem htmlspecialchars doesn't work (nl-admin.php and AKCAY_wunschgericht.php)
 * simple preprocessing input data
 * @param $data
 * @return string
 */
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);        //???
    $data = htmlspecialchars($data);    //???
    return $data;
}
// INPUT VALIDATION
/**
 * check if name only contains letters, whitespace
 * and has valid length
 * @param $checked_name, name to be checked
 * @param $max_length , max valid length
 * @return string describes error
 */
function validName($checked_name, $max_length){
    if(!preg_match("/^[a-zA-Z-' ]*$/",$checked_name)){
        return "Only letters and white space allowed";
    }else if(strlen($checked_name) > $max_length){
        return "Invalid length of text";
    }
}

/**
 * check if the email is allowed correct format
 * and has a valid length
 * contains no predefined junk mails
 * @param $checked_mail
 * @param $max_length
 * @return string describes error
 */
function validMail($checked_mail, $max_length){
    if(!filter_var($checked_mail,FILTER_VALIDATE_EMAIL)){
        return "Invalid email format";
    }else if(strpos($checked_mail, "rcpt.at")
        ||strpos($checked_mail, "damnthespam.at")
        ||strpos($checked_mail, "wegwerfmail.de")
        ||strpos($checked_mail,"trashmail.")){
        return "Junk mail";
    }else if(strlen($checked_mail) > $max_length) {
        return "Invalid length of mail";
    }
}

/**
 * check long text
 * con thieu loai bo ki tu html dac biet
 * loai bo ki tu sql-statement
 * @param $checked_comment
 * @param $max_length
 * @return string describes error
 */
function validComment($checked_comment, $max_length){
    if(strlen($checked_comment) > $max_length){
        return "Invalid length of comment";
    }
}
?>
