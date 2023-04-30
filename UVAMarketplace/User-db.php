<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION)) {
    session_start();
}

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
    $_SESSION['profile'] = $user['computingID'];
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

function getUser($computingID) {
    global $db;

    $query = "select * from User where computingID=:computingID";
    $statement = $db -> prepare($query);
    $statement -> bindValue(':computingID', $computingID);
    $statement -> execute();
    $results = $statement -> fetch();
    $statement -> closeCursor();

    return $results;
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

function updateProfile($computingID, $name, $year, $profilePic, $username) {
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
        $imgName = $_SESSION['profilePic'];
    }

    //Create template
    $query = "update User set name=:name, year=:year, profilePic=:profilePic where computingID=:computingID";
    $statement = $db->prepare($query);
    $statement->bindValue(':computingID', $computingID);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':year', $year);
    $statement->bindValue(':profilePic', $imgName);
    $statement->execute();
    $statement->closeCursor();
}

?>