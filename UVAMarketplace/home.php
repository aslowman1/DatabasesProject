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

$listings = getAllListings($orderBy = 'post_date DESC');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (!empty($_POST['viewListingBtn'])) {
    $_SESSION['listingID'] = $_POST['listingToView'];
    header("Location: viewListing.php");
    exit();
  }
  elseif (!empty($_POST['viewSellerBtn'])) {
    $_SESSION['profile'] = $_POST['sellerID'];
    header("Location: viewProfile.php");
    exit();
  }
  elseif (!empty($_POST['sortBtn'])) {
    $orderBy = $_POST['sortBy'];
    $listings = getAllListings($orderBy);
  }
  elseif (!empty($_POST['makeOfferBtn'])) {
    $_SESSION['listingID'] = $_POST['listingToOffer'];
    header("Location: makeOffer.php");
    exit();  
}
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">   
  <meta http-equiv="X-UA-Compatible" content="IE=edge">  <!-- required to handle IE -->
  <meta name="viewport" content="width=device-width, initial-scale=1">  
  <title>Home</title> 
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
  <link rel="stylesheet" href="activity-styles.css" /> 

  <?php include 'navbar.php';?>
  <div class="container-fluid">
  <div class="row justify-content-end">
    <div class="col-4">
      <button class="btn btn-dark" type="button" data-toggle="collapse" data-target="#sortPanel" aria-expanded="false" aria-controls="sortPanel" style="float: right;">Sort Products</button>
    </div>
  </div>
  <div class="collapse" id="sortPanel" style="">
    <div class="row mt-3">
      <div class="col">
        <form action="home.php" method="post">
          <div class="input-group">
            <label for="sortBy" class="input-group-text">Sort by:</label>
            <select name="sortBy" id="sortBy" class="form-select">
              <option value="listed_price DESC">Highest Price</option>
              <option value="listed_price">Lowest Price</option>
              <option value="post_date DESC">Date</option>
              <option value="1">Furniture</option>
              <option value="2">Clothes</option>
              <option value="3">Books</option>
            </select>
            <button type="submit" name="sortBtn" class="btn btn-dark">Sort</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
  <style>
    body {
      background-image: url("homepage_large.jpg");
      background-size: cover;
    }
    .card {
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
    }
    .button-group {
      display: flex;
      justify-content: center;
    }
    .button-group form {
      margin: 0 5px;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="row row-cols-3 g-3">
      <?php foreach ($listings as $listing): ?>
        <div class="col">
          <div class="card h-100" >
            <img style="max-width: 300px; height:auto; max-height: 200px;  margin-left: auto; margin-right: auto;" src="../itemPics/<?=$listing['itemPic']?>" class="card-img-top"/>
            <div class="card-body">
              <h5 class="card-title"><?php echo $listing['title']; ?></h5>
              <p class="card-text" >
                  Seller: <?php echo getUser($listing['sellerID'])['name']; ?> <br>
                  Price: $<?php echo $listing['listed_price']; ?> <br>
                  Description: <?php echo $listing['description']; ?> <br>
                  Location: <?php echo $listing['location']; ?>
                  Post date: <?php echo $listing['post_date']; ?>
              </p>
              <div class="button-group">
                <form action="home.php" method="post" >
                  <input type="submit" name="viewListingBtn" value="View Listing" class="btn btn-dark"/>
                  <input type="hidden" name="listingToView" value="<?php echo $listing['listingID'];?>" />     
                </form> 
                <form action="home.php" method="post" >
                  <input type="submit" name="viewSellerBtn" value="View Seller" class="btn btn-dark"/>
                  <input type="hidden" name="sellerID" value="<?php echo $listing['sellerID'];?>" />     
                </form>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</body>

</html>