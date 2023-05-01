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
$isComplete = false;
$finalOffer = getFinalOffer($listing['listingID']);
if ($finalOffer) {
  $isComplete = true;
}

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
    elseif (!empty($_POST['acceptOfferBtn'])) {
      acceptOffer($_POST['offerToAccept']);
      header("Location: viewListing.php");
      exit();
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
<style>
    body {
      background-image: url("homepage_large.jpg");
      background-size: cover;
    }


    h1{
      font-family: Tahoma, Geneva, sans-serif;
      font-size: 25px;
      letter-spacing: 2px;
      word-spacing: 2px;
      color: #000000;
      font-weight: 700;
      text-decoration: none;
      font-style: normal;
      font-variant: normal;
      text-transform: none;
    }

    p{
      font-family: "Lucida Console", Courier New, monospace;
      font-size: 15px;
      text-align: center;
      font-weight: bold;
      line-height: 0;
    }

    h3, input, td, th{
      font-family: Tahoma, Geneva, sans-serif;
      font-size: 10px;
      letter-spacing: 2px;
      word-spacing: 2px;
      color: #000000;
      font-weight: 700;
      text-decoration: none;
      font-style: normal;
      font-variant: normal;
      text-transform: none;
    }
    

    .card {
      padding-top: 25px;
      box-shadow: 5px 5px 10px 1px rgba(0, 0, 0, 0.6);
      max-width: 600px;
      margin: 100px auto;
      text-align: center;
      font-family: arial;
      background-color: #DA8E41;
      display: flex;
      flex-grow: 1;
    }

    .button{
      align-items: center;
      appearance: none;
      background-color: #FCFCFD;
      border-radius: 4px;
      border-width: 0;
      box-shadow: rgba(45, 35, 66, 0.4) 0 2px 4px,rgba(45, 35, 66, 0.3) 0 7px 13px -3px,#D6D6E7 0 -3px 0 inset;
      box-sizing: border-box;
      color: #36395A;
      cursor: pointer;
      display: inline-flex;
      font-family: "JetBrains Mono",monospace;
      height: 48px;
      justify-content: center;
      line-height: 1;
      list-style: none;
      overflow: hidden;
      padding-left: 16px;
      padding-right: 16px;
      position: relative;
      text-align: left;
      text-decoration: none;
      transition: box-shadow .15s,transform .15s;
      user-select: none;
      -webkit-user-select: none;
      touch-action: manipulation;
      white-space: nowrap;
      will-change: box-shadow,transform;
      font-size: 18px;
      margin-bottom: 30px;
    }

    .button:focus {
      box-shadow: #D6D6E7 0 0 0 1.5px inset, rgba(45, 35, 66, 0.4) 0 2px 4px, rgba(45, 35, 66, 0.3) 0 7px 13px -3px, #D6D6E7 0 -3px 0 inset;
    }

    .button:hover {
      box-shadow: rgba(45, 35, 66, 0.4) 0 4px 8px, rgba(45, 35, 66, 0.3) 0 7px 13px -3px, #D6D6E7 0 -3px 0 inset;
      transform: translateY(-2px);
    }

    .button:active {
      box-shadow: #D6D6E7 0 3px 7px inset;
      transform: translateY(2px);
    }


  </style>
<body>  
  <div class="card">
    <h1> <?php echo $listing['title']?></h1>
    <img style="max-width: 300px; height:auto; max-height: 200px;  margin-left: auto; margin-right: auto;" src="../itemPics/<?=$listing['itemPic']?>" > <br>
    <p>Description: </p> <h3> <?php echo $listing['description']?> </h3><br>
    <p>Date posted: </p> <h3> <?php echo $listing['post_date']?></h3> <br>
    <p>Location: </p> <h3> <?php echo $listing['location']?> </h3> <br>
    <p>Condition: </p><h3> <?php echo $listing['condition']?> </h3><br>
    <p>Listed Price:</p> <h3>$<?php echo $listing['listed_price']?></h3> <br>

    <?php if($listing['categoryID'] == "2") : ?>
      <p>Size: </p> <h3> <?php echo $clothes['size']?> </h3> <br>

      <?php elseif($listing['categoryID'] == "1") : ?>
        <p>Material: </p> <?php echo $furniture['material']?></h3><br>
        <p>Dimensions: </p> <?php echo $furniture['dimensions']?> </h3>><br>
      
      <?php elseif($listing['categoryID'] == "3") : ?>
        <p>Book: </p> <h3> <?php echo $book['name']?> </h3> <br>
        <p>Course: </p> <h3> <?php echo $book['course']?> </h3> <br>
        <p>ISBN: </p> <h3> <?php echo $book['IBSN']?> </h3> <br>

    <?php endif; ?>

  <?php if (!$isComplete) : ?>
    <?php if(!$isMyListing) : ?>
        <form action="viewListing.php" method="post" >
          <div class = "button">
              <input type="submit" name="makeOfferBtn" value="Make Offer" class="btn"/>
          </div>
            <input type="hidden" name="listingToOffer" value="<?php echo $listing['listingID'];?>" /> 
        <?php if(!$isFavorite) : ?>
            <div class = "button">
                <input type="submit" name="favoriteBtn" value="Add to favorites" class="btn"/>
            </div>
                <input type="hidden" name="listingToFavorite" value="<?php echo $listing['listingID'];?>" /> 
        <?php else : ?>
          <div class = "button">
                <input type="submit" name="unfavoriteBtn" value="Unfavorite" class="btn"/>
          </div>
        <?php endif; ?>
        </form>

    <?php else : //is my listing?>
      <p> Offers: </p>
        <div class="row justify-content-center">  
        <table class="table table-bordered table-striped" style="width:70%">
          <thead>
          <tr style="background-color:white">
            <th> Buyer name </th> 
            <th> Computing ID </th>
            <th> Offer Price </th>
            <th>Accept </th>
            <th> Reject </th>
          </tr>
          </thead>
        <?php foreach ($offers as $offer): ?>
        <?php $buyer = getUser($offer['buyerID']); ?>
          <tr style="background-color:white">
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
    <?php endif; ?>
    <?php else: ?>
      <p>Sold price: $<?php echo($finalOffer[0]['offer_price']);?> </p><br>
    <?php endif; ?>
    </div>



   </div>      
</body>
</html>