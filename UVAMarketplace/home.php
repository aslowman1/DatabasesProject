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
<?php include 'navbar.php';?>
<head>
  <meta charset="utf-8">   
  <meta http-equiv="X-UA-Compatible" content="IE=edge">  <!-- required to handle IE -->
  <meta name="viewport" content="width=device-width, initial-scale=1">  
  <title>Home</title> 
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
  <link rel="stylesheet" href="activity-styles.css" /> 

  <?php include 'navbar.php';?>

  <div class="container-fluid" style="padding-top: 20px">
  <div class="row justify-content-end">
    <div class="col-4" style="padding-bottom: 10px">
      <button class="btn btn-dark" type="button" data-toggle="collapse" data-target="#sortPanel" aria-expanded="false" aria-controls="sortPanel" style="float: right; font-family: Lucida Console, Courier New, monospace; 
      font-size: 15px; text-align: center; font-weight: bold ">Sort Products</button>
    </div>
  </div>
  <div class="collapse" id="sortPanel" style="">
    <div class="row mt-3">
      <div class="col">
        <form action="home.php" method="post">
          <div class="input-group">
            <label for="sortBy" class="input-group-text">Sort by:</label>
            <select name="sortBy" id="sortBy" class="form-select">
              <option value="listed_price DESC">Price(High to Low)</option>
              <option value="listed_price">Price (Low to High)</option>
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
      max-width: 400px;
      margin: auto;
      font-family: arial;
      box-shadow: 5px 5px 10px 1px rgba(0, 0, 0, 0.6);
      background-color: #EDDECF;
    }
    .button-group {
      display: flex;
      justify-content: center;
    }
    .button-group form {
      margin: 0 5px;
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
      height: 30px;
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
      font-size: 15px;
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
    h1{
      font-weight: bold;
      font-family: Tahoma, Geneva, sans-serif; 
      font-size: 15px
    }

  </style>
</head>
<body>
  <div class="container">
    <div class="row row-cols-4 g-3">
      <?php foreach ($listings as $listing): ?>
        <div class="col">
          <div class="card h-100" >
            <img style="max-width: 300px; height:auto; max-height: 200px;  margin-left: auto; margin-right: auto; padding-top: 5px" src="../itemPics/<?=$listing['itemPic']?>" class="card-img-top"/>
            <div class="card-body">
              <h5 class="card-title" style="font-family: Lucida Console, Courier New, monospace; font-size: 20px; text-align: center;
              font-weight: bold"><?php echo $listing['title']; ?></h5>
              <div class="row">
                <p class="card-text" style="text-align: left, font-size: 10px;  line-height: 0.8;" >
                <div class="col-sm">
                  <h1>Seller:</h1> <?php echo getUser($listing['sellerID'])['name']; ?> <br>
                </div>
                <div class="col-sm" style="text-align: right">
                    <h1>Price:</h1> $<?php echo $listing['listed_price']; ?> <br>
                    <h1>Location:</h1> <?php echo $listing['location']; ?> <br>
                    <h1>Post date:</h1> <?php echo $listing['post_date']; ?>
                </div>
                </p>
                <div class="button-group">
                  <form action="home.php" method="post" >
                    <input type="submit" name="viewListingBtn" value="View Listing" class="button"/>
                    <input type="hidden" name="listingToView" value="<?php echo $listing['listingID'];?>" />     
                  </form> 
                  <form action="home.php" method="post" >
                    <input type="submit" name="viewSellerBtn" value="View Seller" class="button"/>
                    <input type="hidden" name="sellerID" value="<?php echo $listing['sellerID'];?>" />     
                  </form>
                  <form action="home.php" method="post" >
                <?php if(!($listing['sellerID'] == $_SESSION['computingID'])) : ?>
                  <input type="submit" name="makeOfferBtn" value="Make Offer" class="btn btn-dark"/>
                  <input type="hidden" name="listingToOffer" value="<?php echo $listing['listingID'];?>" />
                <?php endif; ?>
                </form>
              </div>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</body>



</body>
</html>