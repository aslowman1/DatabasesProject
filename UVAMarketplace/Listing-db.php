<?php
ini_set('error_reporting', -1);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION)) {
    session_start();
}

function getListing($listingID) {
    global $db;

    $query = "select * from Listing where listingID=:listingID";
    $statement = $db->prepare($query);
    $statement->bindValue(':listingID', $listingID);
    $statement->execute();
    $results = $statement -> fetch();
    $statement->closeCursor();
    return $results;
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

    print($imgName);
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
        //Get last row of clothes table
        $query = "select clothesID from Clothes where clothesID=(select max(clothesID) from Clothes);";
        $statement = $db->prepare($query);
        $statement->execute();
        $results = $statement -> fetch();
        $statement->closeCursor();
        $clothesID = (int)$results['clothesID'] + 1;

        //Add clothes entry
        $query = "insert into Clothes values (:clothesID, :categoryID, :size, :listingID)";
        $statement = $db->prepare($query);
        $statement->bindValue(':size', $size);
        $statement->bindValue(':clothesID', $clothesID);
        $statement->bindValue(':categoryID', $category);
        $statement->bindValue(':listingID', $listingID);
        $statement->execute();
        $statement->closeCursor();
    }
    //Furniture
    elseif ($category == 1) {
        //Get last row of furniture table
        $query = "select furnitureID from Furniture where furnitureID=(select max(furnitureID) from Furniture);";
        $statement = $db->prepare($query);
        $statement->execute();
        $results = $statement -> fetch();
        $statement->closeCursor();
        $furnitureID = (int)$results['furnitureID'] + 1;

        //Add furniture entry
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
    //Textbook
    else {
        //Get last row of books table
        $query = "select bookID from Books where bookID=(select max(bookID) from Books);";
        $statement = $db->prepare($query);
        $statement->execute();
        $results = $statement -> fetch();
        $statement->closeCursor();
        $bookID = (int)$results['bookID'] + 1;

        //Add book entry
        $query = "insert into Books values (:bookID, :categoryID, :bookTitle, :course, :IBSN, :listingID)";
        $statement = $db->prepare($query);
        $statement->bindValue(':bookID', $bookID);
        $statement->bindValue(':categoryID', $category);
        $statement->bindValue(':bookTitle', $bookTitle);
        $statement->bindValue(':course', $course);
        $statement->bindValue(':IBSN', $IBSN);
        $statement->bindValue(':listingID', $listingID);
        $statement->execute();
        $statement->closeCursor();
    }
}


?>