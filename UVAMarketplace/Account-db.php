<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function isUsernameAvailable($username) {
    global $db;

    $query = "select * from Account where username=:username";
    $statement = $db -> prepare($query);
    $statement -> bindValue(':username', $username);
    $statement -> execute();
    $results = $statement -> fetch();
    $statement -> closeCursor();

    return empty($results);
}

function isValidLogin($username, $pwd) {
    global $db;
    
    //Check if username exists
    $query = "select * from Account where username=:username";
    $statement = $db -> prepare($query);
    $statement -> bindValue(':username', $username);
    $statement -> execute();
    $results = $statement -> fetch();
    $statement -> closeCursor();
    if (empty($results)) {
        return FALSE;
    }

    //Check if the passwords match
    $hashedPwd = $results['password'];
    return ($hashedPwd == crypt($pwd, $hashedPwd) || $hashedPwd == $pwd); //Temp second condition
}

function createAccount($username, $pwd) {
    global $db;

    //Generate unique salt for each password
    $salt = uniqid('', true);
    $algo = '6'; // CRYPT_SHA512
    $rounds = '5042';
    $cryptSalt = '$'.$algo.'$rounds='.$rounds.'$'.$salt;

    $hashedPwd = crypt($pwd, $cryptSalt);
    $query = "insert into Account values (:username, :pwd)";
    $statement = $db->prepare($query);
    $statement->bindValue(':username', $username);
    $statement->bindValue(':pwd', crypt($pwd, $cryptSalt)); //Hash password

    $statement->execute();
    $statement->closeCursor();
}
?>