<?php
require("connect-db.php");
require('Account-db.php');
require('User-db.php');
require('Listing-db.php');
require('Offer-db.php');

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
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['makeOfferBtn'])) {
        $buyerID = $_SESSION['computingID'];
        $offerPrice = $_POST['offerPrice'];
        $listingID = $listing['listingID'];
        addOffer($listingID, $buyerID, $offerPrice);
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
<h1> <?php echo $listing['title']?></h1>
<body>  
<img style="max-width: 300px; height:auto; max-height: 200px;  margin-left: auto; margin-right: auto;" src="../itemPics/<?=$listing['itemPic']?>" > <br>
Description: <?php echo $listing['description']?> <br>
Date posted: <?php echo $listing['post_date']?> <br>
Location: <?php echo $listing['location']?> <br>
Condition: <?php echo $listing['condition']?> <br>
Price: $<?php echo $listing['listed_price']?> <br>
<form action="makeOffer.php" method="post" enctype="multipart/form-data">     
    Offer price: $<input type="number" step="0.01" min=0 name="offerPrice"> <br>
    <input type="submit" name ="makeOfferBtn" value="Submit Offer" class="btn" />
</form>
</body>
</html>