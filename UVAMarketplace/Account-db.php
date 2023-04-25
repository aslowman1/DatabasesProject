<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

function setSessionVars($username) {
    global $db;

    $query = "select * from User where username=:username";
    $statement = $db -> prepare($query);
    $statement -> bindValue(':username', $username);
    $statement -> execute();
    $user = $statement -> fetch();
    $statement -> closeCursor();

    $_SESSION['computingID'] = $user['computingID'];
    $_SESSION['name'] = $user['name'];
    $_SESSION['year'] = $user['year'];
    $_SESSION['profilePic'] = $user['profilePic'];
}

function isUser($username) {
    global $db;

    $query = "select * from User where username=:username";
    $statement = $db -> prepare($query);
    $statement -> bindValue(':username', $username);
    $statement -> execute();
    $results = $statement -> fetch();
    $statement -> closeCursor();

    return !empty($results);
}

function hasAccount($username) {
    global $db;

    $query = "select * from Account where username=:username";
    $statement = $db -> prepare($query);
    $statement -> bindValue(':username', $username);
    $statement -> execute();
    $results = $statement -> fetch();
    $statement -> closeCursor();

    return !empty($results);
}

function isValidLogin($username, $pwd) {
    global $db;
    
    //Check username
    if (!hasAccount($username)) {
        return FALSE;
    }

    //Get user/password
    $query = "select * from Account where username=:username";
    $statement = $db -> prepare($query);
    $statement -> bindValue(':username', $username);
    $statement -> execute();
    $results = $statement -> fetch();
    $statement -> closeCursor();

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

function createProfile($computingID, $name, $year, $profilePic, $username) {
    global $db;
    $year = (int)$year;
    if ($profilePic['name']) {
        //Add profile pic under profilePics/username.jpg/png/jpeg
        $imgExt = pathinfo($profilePic['name'], PATHINFO_EXTENSION);
        $imgName = $username.'.'.$imgExt;
        $tmpName = $profilePic['tmp_name'];
        $uploadPath = '../profilePics/'.$imgName;

        move_uploaded_file($tmpName, $uploadPath);
    }
    else {
        $imgName = "default.jpeg";
    }

    //Create template
    $query = "insert into User values (:computingID, :name, :year, :profilePic, :username)";
    $statement = $db->prepare($query);
    $statement->bindValue(':computingID', $computingID);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':year', $year);
    $statement->bindValue(':profilePic', $imgName);
    $statement->bindValue(':username', $username);
    $statement->execute();
    $statement->closeCursor();
}
?>