<?php
require("connect-db.php");
require('Account-db.php');
require('User-db.php');
require('Listing-db.php');


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
<?php include 'navbar.php';?>
<head>
  <meta charset="utf-8">   
  <meta http-equiv="X-UA-Compatible" content="IE=edge">  <!-- required to handle IE -->
  <meta name="viewport" content="width=device-width, initial-scale=1">  
  <title>Home</title> 
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
  <link rel="stylesheet" href="activity-styles.css" /> 
  <div class="row">
  <div class="col">
    <form action="home.php" method="post" >
      <label for="sortBy">Sort by:</label>
      <select name="sortBy" id="sortBy">
        <option value="listed_price DESC">Highest Price</option>
        <option value="listed_price">Lowest Price</option>
        <option value="post_date DESC">Date</option>
        <option value="1">Furniture</option>
        <option value="2">Clothes</option>
        <option value="3">Books</option>
      </select>
      <input type="submit" name="sortBtn" value="Sort" class="btn btn-dark"/>
    </form>
  </div>
</div>
</head>
<body>  


<div class="row row-cols-3 g-3">
<?php foreach ($listings as $listing): ?>
  <div class="col">
    <div class="card h-100" >
    <img style="max-width: 300px; height:auto; max-height: 200px;  margin-left: auto; margin-right: auto;" src="../itemPics/<?=$listing['itemPic']?>" class="card-img-top"/>
      <div class="card-body">
        <h5 class="card-title"><?php echo $listing['title']; ?></h5>
        <p class="card-text">
            Seller: <?php echo getUser($listing['sellerID'])['name']; ?> <br>
            Price: $<?php echo $listing['listed_price']; ?> <br>
            Description: <?php echo $listing['description']; ?> <br>
            Location: <?php echo $listing['location']; ?>
            Post date: <?php echo $listing['post_date']; ?>
        </p>
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
  <?php endforeach; ?>
</div>


</body>
</html>