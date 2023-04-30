<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION)) {
    session_start();
}

function getNextFurnitureID() {
    global $db;

    //Get last row of furniture table
    $query = "select furnitureID from Furniture where furnitureID=(select max(furnitureID) from Furniture);";
    $statement = $db->prepare($query);
    $statement->execute();
    $results = $statement -> fetch();
    $statement->closeCursor();
    $furnitureID = (int)$results['furnitureID'] + 1;
    return $furnitureID;
}

function addFurniture($category, $material, $dimensions, $listingID) {
    global $db;

    $furnitureID = getNextFurnitureID();

    $query = "insert into Furniture values (:furnitureID, :categoryID, :material, :dimensions, :listingID)";
    $statement = $db->prepare($query);
    $statement->bindValue(':furnitureID', $furnitureID);
    $statement->bindValue(':categoryID', $category);
    $statement->bindValue(':material', $material);
    $statement->bindValue(':dimensions', $dimensions);
    $statement->bindValue(':listingID', $listingID);
    $statement->execute();
    $statement->closeCursor();
}

function deleteFurniture($listingID) {
    global $db;

    $query = "delete from Furniture where listingID=:listingID";
    $statement = $db->prepare($query);
    $statement->bindValue(':listingID', $listingID);
    $statement->execute();
    $statement->closeCursor();
}

?>