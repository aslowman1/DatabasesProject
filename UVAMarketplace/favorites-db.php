<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION)) {
    session_start();
}

function isFavorite($buyerID, $listingID) {
    global $db;

    $query = "select * from favorites where buyerID=:buyerID and listingID=:listingID";
    $statement = $db -> prepare($query);
    $statement -> bindValue(':buyerID', $buyerID);
    $statement->bindValue(':listingID', $listingID);
    $statement -> execute();
    $results = $statement -> fetch();
    $statement -> closeCursor();

    return !empty($results);
}

function favorite($buyerID, $listingID) {
    global $db;

    $query = "insert into favorites values (:buyerID, :listingID)";
    $statement = $db->prepare($query);
    $statement->bindValue(':buyerID', $buyerID);
    $statement->bindValue(':listingID', $listingID);
    $statement->execute();
    $statement->closeCursor();
}

function unfavorite($buyerID, $listingID) {
    global $db;

    $query = "delete from favorites where buyerID=:buyerID and listingID=:listingID";
    $statement = $db -> prepare($query);
    $statement -> bindValue(':buyerID', $buyerID);
    $statement->bindValue(':listingID', $listingID);
    $statement -> execute();
    $statement -> closeCursor();
}

?>