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
elseif(isset($_GET['profile'])){
    $_SESSION['profile'] = $_SESSION['computingID'];
 }
elseif (!isset($_SESSION['profile'])) {
    $_SESSION['profile'] = $_SESSION['computingID'];
}

//Current profile
$user = getUser($_SESSION['profile']);

$isMyProfile = $user['computingID'] == $_SESSION['computingID'];
$listings = getListingsByUser($user['computingID']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['viewListingBtn'])) {
        $_SESSION['listingID'] = $_POST['listingToView'];
        header("Location: viewListing.php");
        exit();
    }
    elseif (!empty($_POST['editListingBtn'])) {
        $_SESSION['listingID'] = $_POST['listingToView'];
        header("Location: viewListing.php");
        exit();
    }
    elseif (!empty($_POST['deleteListingBtn'])) {
        $_SESSION['listingID'] = NULL;
        deleteListing($_POST['listingToDelete']);
        $listings = getListingsByUser($user['computingID']);
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
  <title>View Profile</title> 
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
  <link rel="stylesheet" href="activity-styles.css" /> 
  <style>
    body {
			background-image: url('homepage_large.jpg'); 
      background-size: cover;
    }
    .container {
      background-color: white;
      padding: 15px;
      border-radius: 5px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
      margin-top: 20px;
      margin-left: 20px;
      max-width: 500px;
    }
    .listing-container {
      background-color: white;
      border-radius: 5px;
      padding: 30px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
      max-width: 700px;
    }
    .offers-container{
      background-color: white;
      padding: 15px;
      border-radius: 5px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
      margin-left: 20px;
      max-width: 700px;
    }
  </style>
</head>
<body> 
<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-4">
      <img style="max-width: 100%; height:auto; max-height: 200px; margin-top: 20px;" src="../profilePics/<?=$user['profilePic']?>" >
    </div>
    <div class="col-8">
      <h2><?php echo $user['name']; ?></h2>
      <p>Computing ID: <?php echo $user['computingID']; ?></p>
      <p>Year: <?php echo $user['year']; ?></p>
    </div>
  </div>
</div>

<div style="display: flex;">
  <div class="listing-container">
    <h2>Listings Posted</h2>
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Image</th>
          <th>Title</th>
          <th>Price</th>
          <th>Post Date</th>
          <th>View</th>
          <?php if($isMyProfile) : ?>
            <th>Edit</th>
            <th>Delete</th>
          <?php endif; ?>
          <?php if(!$isMyProfile) : ?>
            <th>Make Offer</th>
          <?php endif; ?>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($listings as $listing): ?>
          <tr>
            <td><img src="../itemPics/<?=$listing['itemPic']?>" width=40 height=40></td>
            <td><?php echo $listing['title']; ?></td>
            <td>$<?php echo $listing['listed_price']; ?></td>
            <td><?php echo $listing['post_date']; ?></td>
            <td>
              <form action="viewProfile.php" method="post">
                <input type="submit" name="viewListingBtn" value="View" class="btn btn-dark"/>
                <input type="hidden" name="listingToView" value="<?php echo $listing['listingID'];?>" />
              </form>
            </td>
            <?php if($isMyProfile) : ?>
              <td>
                <form action="viewProfile.php" method="post">
                  <input type="submit" name="editListingBtn" value="Edit" class="btn btn-dark"/>
                  <input type="hidden" name="listingToEdit" value="<?php echo $listing['listingID'];?>" />
                </form>
              </td>
              <td>
                <form action="viewProfile.php" method="post">
                  <input type="submit" name="deleteListingBtn" value="Delete" class="btn btn-danger"/>
                  <input type="hidden" name="listingToDelete" value="<?php echo $listing['listingID'];?>" />
                </form>
              </td>
            <?php endif; ?>
            <?php if(!$isMyProfile) : ?>
              <td>
                <form action="viewProfile.php" method="post">
                  <input type="submit" name="makeOfferBtn" value="Offer" class="btn btn-dark"/>
                  <input type="hidden" name="listingToOffer" value="<?php echo $listing['listingID'];?>" />
                </form>
              </td>
            <?php endif; ?>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <div class="offers-container">
    <h2>Offers</h2>
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Image</th>
          <th>Title</th>
          <th>Offer Price</th>
          <th>Offer Status</th>
          <th>View</th>
          <?php if($isMyProfile) : ?>
            <th>Edit</th>
            <th>Delete</th>
          <?php endif; ?>
          <?php if(!$isMyProfile) : ?>
            <th>Make Offer</th>
          <?php endif; ?>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($listings as $listing): ?>
          <tr>
            <td><img src="../itemPics/<?=$listing['itemPic']?>" width=40 height=40></td>
            <td><?php echo $listing['title']; ?></td>
            <td>$<?php echo $listing['listed_price']; ?></td>
            <td><?php echo $listing['post_date']; ?></td>
            <td>
              <form action="viewProfile.php" method="post">
                <input type="submit" name="viewListingBtn" value="View" class="btn btn-dark"/>
                <input type="hidden" name="listingToView" value="<?php echo $listing['listingID'];?>" />
              </form>
            </td>
            <?php if($isMyProfile) : ?>
              <td>
                <form action="viewProfile.php" method="post">
                  <input type="submit" name="editListingBtn" value="Edit" class="btn btn-dark"/>
                  <input type="hidden" name="listingToEdit" value="<?php echo $listing['listingID'];?>" />
                </form>
              </td>
              <td>
                <form action="viewProfile.php" method="post">
                  <input type="submit" name="deleteListingBtn" value="Delete" class="btn btn-danger"/>
                  <input type="hidden" name="listingToDelete" value="<?php echo $listing['listingID'];?>" />
                </form>
              </td>
            <?php endif; ?>
            <?php if(!$isMyProfile) : ?>
              <td>
                <form action="viewProfile.php" method="post">
                  <input type="submit" name="makeOfferBtn" value="Offer" class="btn btn-dark"/>
                  <input type="hidden" name="listingToOffer" value="<?php echo $listing['listingID'];?>" />
                </form>
              </td>
            <?php endif; ?>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>


</body>
</html>