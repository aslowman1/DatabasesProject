<?php
require("connect-db.php");
require('Account-db.php');
require('User-db.php');
require('Listing-db.php');
require('Offer-db.php');
require('favorites-db.php');

if (!isset($_SESSION)) {
    session_start();
}

if (!$_SESSION['username']) {
    header("Location: signup.php");
    exit();
} 
elseif(!isUser($_SESSION['username'])) {
    header("Location: createProfile.php");
    exit();
}
elseif (!$_SESSION) {
    setSessionVars($_SESSION['username']);
}
elseif (!$_SESSION['listingID']) {
    header("Location: home.php");
    exit();
}

$listing = getListingByID($_SESSION['listingID']);
$listingID = $listing['listingID'];
$isMyListing = $listing['sellerID'] == $_SESSION['computingID'];
if ($isMyListing) {
    $offers = getPendingOffersForListing($listing['listingID']);
}
else {
    $isFavorite = isFavorite($_SESSION['computingID'], $listing['listingID']);
}

if ($listing['categoryID'] == "1") {
  $furniture = getFurnitureByListingID($listingID);
}
elseif ($listing['categoryID'] == "2") {
  $clothes = getClothesByListingID($listingID);
}
else {
  $book = getBookByListingID($listingID);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['makeOfferBtn'])) {
        $_SESSION['listingID'] = $_POST['listingToOffer'];
        header("Location: makeOffer.php");
        exit();
    }
    elseif (!empty($_POST['favoriteBtn'])) {
        favorite($_SESSION['computingID'], $listing['listingID']);
        $isFavorite = isFavorite($_SESSION['computingID'], $listing['listingID']);
    }
    elseif (!empty($_POST['unfavoriteBtn'])) {
        unfavorite($_SESSION['computingID'], $listing['listingID']);
        $isFavorite = isFavorite($_SESSION['computingID'], $listing['listingID']);
    }    
    elseif (!empty($_POST['rejectOfferBtn'])) {
      rejectOffer($_POST['offerToReject']);
      $offers = getPendingOffersForListing($listing['listingID']);

    }    

}


?>

<!DOCTYPE html>
<html>
<?php include 'navbar.php';?>
<head>
  <meta charset="utf-8">   
  <meta http-equiv="X-UA-Compatible" content="IE=edge">  <!-- required to handle IE -->
  <meta name="viewport" content="width=device-width, initial-scale=1">  
  <title>Home</title> 
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
  <link rel="stylesheet" href="activity-styles.css" /> 
</head>
<h1> <?php echo $listing['title']?></h1>
<body>  
<img style="max-width: 300px; height:auto; max-height: 200px;  margin-left: auto; margin-right: auto;" src="../itemPics/<?=$listing['itemPic']?>" > <br>
Description: <?php echo $listing['description']?> <br>
Date posted: <?php echo $listing['post_date']?> <br>
Location: <?php echo $listing['location']?> <br>
<?php if($listing['categoryID'] == "2") : ?>
  Size: <?php echo $clothes['size']?> <br>

  <?php elseif($listing['categoryID'] == "1") : ?>
  Material: <?php echo $furniture['material']?> <br>
  Dimensions: <?php echo $furniture['dimensions']?> <br>
  
  <?php elseif($listing['categoryID'] == "3") : ?>
  Book: <?php echo $book['name']?> <br>
  Course: <?php echo $book['course']?> <br>
  ISBN: <?php echo $book['IBSN']?> <br>
<?php endif; ?>

Condition: <?php echo $listing['condition']?> <br>
Price: $<?php echo $listing['listed_price']?> <br>




<?php if(!$isMyListing) : ?>
    <form action="viewListing.php" method="post" >
        <input type="submit" name="makeOfferBtn" value="Make Offer" class="btn btn-dark"/>
        <input type="hidden" name="listingToOffer" value="<?php echo $listing['listingID'];?>" /> 
    <?php if(!$isFavorite) : ?>
            <input type="submit" name="favoriteBtn" value="Add to favorites" class="btn btn-warning"/>
            <input type="hidden" name="listingToFavorite" value="<?php echo $listing['listingID'];?>" /> 
    <?php else : ?>
            <input type="submit" name="unfavoriteBtn" value="Unfavorite" class="btn btn-danger"/>
    <?php endif; ?>
    </form>

<?php else : //is my listing?>
    Offers: 
    <div class="row justify-content-center">  
    <table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
      <thead>
      <tr style="background-color:#B0B0B0">
        <th> Buyer name </th> 
        <th> Computing ID </th>
        <th> Offer Price </th>
        <th>Accept </th>
        <th> Reject </th>
      </tr>
      </thead>
    <?php foreach ($offers as $offer): ?>
    <?php $buyer = getUser($offer['buyerID']); ?>
      <tr>
        <td><?php echo $buyer['name']; ?></td>  
        <td><?php echo $buyer['computingID']; ?></td> 
        <td>$<?php echo $offer['offer_price']; ?></td>  
        <td> 
          <form action="viewListing.php" method="post" >
            <input type="submit" name="acceptOfferBtn" value="Accept" class="btn btn-success"/>
            <input type="hidden" name="offerToAccept" value="<?php echo $offer['offerID'];?>" />     
          </form>  
        </td> 
        <td> 
          <form action="viewListing.php" method="post" >
            <input type="submit" name="rejectOfferBtn" value="Reject" class="btn btn-danger"/>
            <input type="hidden" name="offerToReject" value="<?php echo $offer['offerID'];?>" />     
          </form>  
        </td> 
      </tr>
    <?php endforeach; ?>
</table>
</div>
<?php endif; ?>

</body>
</html>