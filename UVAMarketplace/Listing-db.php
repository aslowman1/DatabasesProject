<?php
ini_set('error_reporting', -1);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require('Clothes-db.php');
require('Furniture-db.php');
require('Books-db.php');


if (!isset($_SESSION)) {
    session_start();
}

function getListingByID($listingID) {
    global $db;

    $query = "select * from Listing where listingID=:listingID";
    $statement = $db->prepare($query);
    $statement->bindValue(':listingID', $listingID);
    $statement->execute();
    $results = $statement -> fetch();
    $statement->closeCursor();
    return $results;
}

function getListingsByUser($computingID) {
    global $db;

    $query = "select * from Listing where sellerID=:computingID order by post_date DESC";
    $statement = $db->prepare($query);
    $statement->bindValue(':computingID', $computingID);
    $statement->execute();
    $results = $statement -> fetchALL();
    $statement->closeCursor();
    return $results;
}

function getFavoriteListings($computingID) {
    global $db;

    $query = "select * from Listing where exists (select * from favorites where buyerID=:buyerID and Listing.listingID=favorites.listingID)";
    $statement = $db->prepare($query);
    $statement->bindValue(':buyerID', $computingID);
    $statement->execute();
    $results = $statement -> fetchALL();
    $statement->closeCursor();
    return $results;
}

function getAllListings($orderBy) {
    global $db;

    //Clothes
    if ($orderBy == "2") {
        $query = "SELECT * FROM Listing WHERE listingID in (select Clothes.listingID from Clothes where Listing.listingID = Clothes.listingID)";
    }
    //Furniture
    elseif ($orderBy == "1") {
        $query = "SELECT * FROM Listing WHERE listingID in (select Furniture.listingID from Furniture where Listing.listingID = Furniture.listingID)";
    }
    //Textbook
    elseif ($orderBy == "3") {
        $query = "SELECT * FROM Listing WHERE listingID in (select Books.listingID from Books where Listing.listingID = Books.listingID)";
    }
    else{
        $query = "SELECT * FROM Listing WHERE 
            listingID in (select Clothes.listingID from Clothes where Listing.listingID = Clothes.listingID) or
            listingID in (select Furniture.listingID from Furniture where Listing.listingID = Furniture.listingID) or
            listingID in (select Books.listingID from Books where Listing.listingID = Books.listingID) ORDER BY $orderBy";
    }
    $statement = $db->prepare($query);
    $statement->execute();
    $listings = $statement->fetchAll();
    $statement->closeCursor();
    return $listings;
  }

function deleteListing($listingID) {
    global $db;

    $listing = getListingByID($listingID);
    $category = $listing['categoryID'];

    //Clothes
    if ($category == 2) {
        deleteClothes($listingID);
    }
    //Furniture
    elseif ($category == 1) {
        deleteFurniture($listingID);
    }
    //Textbook
    else {
        deleteBook($listingID);
    }

    $query = "delete from favorites where listingID=:listingID";
    $statement = $db->prepare($query);
    $statement->bindValue(':listingID', $listingID);
    $statement->execute();
    $statement->closeCursor();

    $query = "delete from evaluates where offerID in (select offerID from Offer where listingID=:listingID)";
    $statement = $db->prepare($query);
    $statement->bindValue(':listingID', $listingID);
    $statement->execute();
    $statement->closeCursor();

    $query = "delete from Offer where listingID=:listingID";
    $statement = $db->prepare($query);
    $statement->bindValue(':listingID', $listingID);
    $statement->execute();
    $statement->closeCursor();

    $query = "delete from Listing where listingID=:listingID";
    $statement = $db->prepare($query);
    $statement->bindValue(':listingID', $listingID);
    $statement->execute();
    $statement->closeCursor();


}

function createListing($title, $location, $description, $category, $size, $material, $dimensions, $bookTitle, $course, $IBSN, $condition, $listed_price, $itemPic) {
    global $db;
    date_default_timezone_set('America/New_York');
    $category = (int)$category;
    $listed_price = (float)$listed_price; 

    //Get last row of listing table
    $query = "select listingID from Listing where listingID=(select max(listingID) from Listing);";
    $statement = $db->prepare($query);
    $statement->execute();
    $results = $statement -> fetch();
    $statement->closeCursor();
    $listingID = (int)$results['listingID'] + 1;

    $_SESSION['listingID'] = $listingID; //Used for view listing

    if ($itemPic['name']) {
        //Add profile pic under profilePics/username.jpg/png/jpeg
        $imgExt = pathinfo($itemPic['name'], PATHINFO_EXTENSION);
        $imgName = $listingID.'.'.$imgExt;
        $tmpName = $itemPic['tmp_name'];
        $uploadPath = '../itemPics/'.$imgName;
        move_uploaded_file($tmpName, $uploadPath);
    }
    else {
        $imgName = "defaultItem.jpeg";
    }

    //Add listing
    $query = "insert into Listing values (:listingID, :title, :post_date, :location, :description, :itemPic, :condition, :listed_price, :sellerID, :categoryID)";
    $statement = $db->prepare($query);
    $statement->bindValue(':listingID', $listingID);
    $statement->bindValue(':title', $title);
    $statement->bindValue(':post_date', date('Y-m-d H:i:s'));
    $statement->bindValue(':location', $location);
    $statement->bindValue(':description', $description);
    $statement->bindValue(':itemPic', $imgName);
    $statement->bindValue(':condition', $condition);
    $statement->bindValue(':listed_price', $listed_price);
    $statement->bindValue(':sellerID', $_SESSION['computingID']);
    $statement->bindValue(':categoryID', $category);
    $statement->execute();
    $statement->closeCursor();

    //Clothes
    if ($category == 2) {
        //Add clothes entry
        addClothes($category, $size, $listingID);
    }
    //Furniture
    elseif ($category == 1) {
        //Add furniture entry
        addFurniture($category, $material, $dimensions, $listingID);
    }
    //Textbook
    else {
        //Add book entry
        addBook($category, $bookTitle, $course, $IBSN, $listingID);
    }
}


function updateListing($listingID, $title, $location, $description, $category, $size, $material, $dimensions, $bookTitle, $course, $IBSN, $condition, $listed_price, $itemPic) {
    global $db;

    $category = (int)$category;
    $listed_price = (float)$listed_price; 
    $_SESSION['listingID'] = $listingID; //Used for view listing
    $listing = getListingByID($listingID);

    if ($itemPic['name']) {
        //Add profile pic under profilePics/username.jpg/png/jpeg
        $imgExt = pathinfo($itemPic['name'], PATHINFO_EXTENSION);
        $imgName = $listingID.'.'.$imgExt;
        $tmpName = $itemPic['tmp_name'];
        $uploadPath = '../itemPics/'.$imgName;
        move_uploaded_file($tmpName, $uploadPath);
    }
    else {
        $imgName = $listing['itemPic'];
    }


    //update listing
    //$query = "update Listing set title=:title, location=:location, description=:description, itemPic=:itemPic, condition=:condition, listed_price=:listed_price where listingID=:listingID";
    $query = "update Listing set title=:title, location=:location, description=:description, `condition`=:condition, itemPic=:itemPic, listed_price=:listed_price  where listingID=:listingID";
    $statement = $db->prepare($query);
    $statement->bindValue(':listingID', $listingID);
    $statement->bindValue(':title', $title);
    $statement->bindValue(':location', $location);
    $statement->bindValue(':description', $description);
    $statement->bindValue(':itemPic', $imgName);
    $statement->bindValue(':condition', $condition);
    $statement->bindValue(':listed_price', $listed_price);
    $statement->execute();
    $statement->closeCursor();

    //Furniture
    if ($category == 1) {
        updateFurniture($material, $dimensions, $listingID);
    }
    //Clothes
    if ($category == 2) {
        updateClothes($size, $listingID);
    }
    //Textbook
    else {
        updateBook($bookTitle, $course, $IBSN, $listingID);
    }
}


?>