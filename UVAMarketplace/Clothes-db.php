<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION)) {
    session_start();
}

function getNextClothesID() {
    global $db;

    $query = "select clothesID from Clothes where clothesID=(select max(clothesID) from Clothes);";
    $statement = $db->prepare($query);
    $statement->execute();
    $results = $statement -> fetch();
    $statement->closeCursor();
    $clothesID = (int)$results['clothesID'] + 1;
    return $clothesID;
}

function getClothesByListingID($listingID) {
    global $db;

    $query = "select * from Clothes where listingID=:listingID";
    $statement = $db->prepare($query);
    $statement->bindValue(':listingID', $listingID);
    $statement->execute();
    $results = $statement -> fetch();
    $statement->closeCursor();
    return $results;
}

function addClothes($category, $size, $listingID) {
    global $db;

    $clothesID = getNextClothesID();

    $query = "insert into Clothes values (:clothesID, :categoryID, :size, :listingID)";
    $statement = $db->prepare($query);
    $statement->bindValue(':clothesID', $clothesID);
    $statement->bindValue(':categoryID', $category);
    $statement->bindValue(':size', $size);
    $statement->bindValue(':listingID', $listingID);
    $statement->execute();
    $statement->closeCursor();
}

function updateClothes($size, $listingID) {
    global $db;

    $query = "update Clothes set size=:size where listingID=:listingID";
    $statement = $db->prepare($query);
    $statement->bindValue(':size', $size);
    $statement->bindValue(':listingID', $listingID);
    $statement->execute();
    $statement->closeCursor();
}

function deleteClothes($listingID) {
    global $db;

    $query = "delete from Clothes where listingID=:listingID";
    $statement = $db->prepare($query);
    $statement->bindValue(':listingID', $listingID);
    $statement->execute();
    $statement->closeCursor();
}

?>