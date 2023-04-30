<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION)) {
    session_start();
}

function getNextOfferID() {
    global $db;

    //Get last row of books table
    $query = "select offerID from Offer where offerID=(select max(offerID) from Offer);";
    $statement = $db->prepare($query);
    $statement->execute();
    $results = $statement -> fetch();
    $statement->closeCursor();
    $offerID = (int)$results['offerID'] + 1;
    return $offerID;
}

//Check if user has already submitted an offer for the listing
function hasOffered($listingID, $buyerID) {
    global $db;

    $query = "select * from Offer where buyerID=:buyerID and listingID=:listingID";
    $statement = $db -> prepare($query);
    $statement -> bindValue(':buyerID', $buyerID);
    $statement->bindValue(':listingID', $listingID);
    $statement -> execute();
    $results = $statement -> fetch();
    $statement -> closeCursor();

    return !empty($results);
}

function getPendingOffersForListing($listingID) {
    global $db;

    $query = "select * from Offer where listingID=:listingID order by offer_price DESC";
    $statement = $db -> prepare($query);
    $statement->bindValue(':listingID', $listingID);
    $statement -> execute();
    $results = $statement -> fetchAll();
    $statement -> closeCursor();
    
    return $results;
}

function getAllOffersForListing($listingID) {
    global $db;

    $query = "select * from Offer where listingID=:listingID order by offer_price DESC";
    $statement = $db -> prepare($query);
    $statement->bindValue(':listingID', $listingID);
    $statement -> execute();
    $results = $statement -> fetchAll();
    $statement -> closeCursor();
    
    return $results;
}

function addOffer($listingID, $buyerID, $offerPrice) {
    global $db;
    $offerPrice = (float)$offerPrice;

    if (!hasOffered($listingID, $buyerID)) {
        $offerID = getNextOfferID();

        print($offerID);
        $query = "insert into Offer values (:offerID, :offerPrice, :buyerID, :listingID)";
        $statement = $db->prepare($query);
        $statement->bindValue(':offerID', $offerID);
        $statement->bindValue(':offerPrice', $offerPrice);
        $statement->bindValue(':buyerID', $buyerID);
        $statement->bindValue(':listingID', $listingID);
        $statement->execute();
        $statement->closeCursor();
    }
    else {
        updateOffer($listingID, $buyerID, $offerPrice);
    }

}

function updateOffer($listingID, $buyerID, $offerPrice) {
    global $db;

    $query = "update Offer set offer_price=:offerPrice where buyerID=:buyerID and listingID=:listingID";
    $statement = $db->prepare($query);
    $statement->bindValue(':offerPrice', $offerPrice);
    $statement -> bindValue(':buyerID', $buyerID);
    $statement->bindValue(':listingID', $listingID);
    $statement->execute();
    $statement->closeCursor();
}

function rejectOffer($offerID, $sellerID) {
    global $db;

    $status = "Rejected";
    $query = "insert into evaluates values (:offerID, :sellerID, :status)";
    $statement = $db->prepare($query);
    $statement->bindValue(':offerID', $offerID);
    $statement->bindValue(':sellerID', $sellerID);
    $statement->bindValue(':status', $status);
    $statement->execute();
    $statement->closeCursor();
}

?>