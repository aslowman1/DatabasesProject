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
    $offers = getAllOffersForListing($listing['listingID']);
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
    elseif (!empty($_POST['unfavoriteBtn'])) {
        unfavorite($_SESSION['computingID'], $listing['listingID']);
        $isFavorite = isFavorite($_SESSION['computingID'], $listing['listingID']);
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

    h3{
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
    <p>Description: <?php echo $listing['description']?></p> <br>
    <p>Date posted: <?php echo $listing['post_date']?> </p><br>
    <p>Location: <?php echo $listing['location']?></p> <br>
    <p>Condition: <?php echo $listing['condition']?> </p><br>
    <p>Price: $<?php echo $listing['listed_price']?> </p><br>

    <?php if($listing['categoryID'] == "2") : ?>
      <p>Size: <?php echo $clothes['size']?> </p><br>

      <?php elseif($listing['categoryID'] == "1") : ?>
        <p>Material: <?php echo $furniture['material']?></p> <br>
        <p>Dimensions: <?php echo $furniture['dimensions']?> </p><br>
      
      <?php elseif($listing['categoryID'] == "3") : ?>
        <p>Book: <?php echo $book['name']?> </p><br>
        <p>Course: <?php echo $book['course']?> </p><br>
        <p>ISBN: <?php echo $book['IBSN']?></p> <br>

    <?php endif; ?>

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
                <div class = "button">
                  <input type="submit" name="acceptOfferBtn" value="Accept" class="btn btn-success"/>
                </div>
                <input type="hidden" name="offerToAccept" value="<?php echo $offer['offerID'];?>" />  

              </form>  
            </td> 
            <td> 
              <form action="viewListing.php" method="post" >
                <div class = "button">
                  <input type="submit" name="rejectOfferBtn" value="Reject" class="btn btn-danger"/>
                </div>
                <input type="hidden" name="offerToReject" value="<?php echo $offer['offerID'];?>" />     
              </form>  
            </td> 
          </tr>
        <?php endforeach; ?>
    </table>
    </div>
    <?php endif; ?>
   </div>      
</body>
</html>