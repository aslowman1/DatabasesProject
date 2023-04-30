<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION)) {
    session_start();
}

function getNextBookID() {
    global $db;

    //Get last row of books table
    $query = "select bookID from Books where bookID=(select max(bookID) from Books);";
    $statement = $db->prepare($query);
    $statement->execute();
    $results = $statement -> fetch();
    $statement->closeCursor();
    $bookID = (int)$results['bookID'] + 1;
    return $bookID;
}

function getBookByListingID($listingID) {
    global $db;

    $query = "select * from Books where listingID=:listingID";
    $statement = $db->prepare($query);
    $statement->bindValue(':listingID', $listingID);
    $statement->execute();
    $results = $statement -> fetch();
    $statement->closeCursor();
    return $results;
}

function addBook($category, $bookTitle, $course, $IBSN, $listingID) {
    global $db;

    $bookID = getNextBookID();

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

function updateBook( $bookTitle, $course, $IBSN, $listingID) {
    global $db;

    $query = "update Books set name=:bookTitle, course=:course, IBSN=:IBSN where listingID=:listingID";
    $statement = $db->prepare($query);
    $statement->bindValue(':bookTitle', $bookTitle);
    $statement->bindValue(':course', $course);
    $statement->bindValue(':IBSN', $IBSN);
    $statement->bindValue(':listingID', $listingID);
    $statement->execute();
    $statement->closeCursor();
}

function deleteBook($listingID) {
    global $db;

    $query = "delete from Books where listingID=:listingID";
    $statement = $db->prepare($query);
    $statement->bindValue(':listingID', $listingID);
    $statement->execute();
    $statement->closeCursor();
}

?>