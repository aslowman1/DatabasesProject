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
$favorites = getFavoriteListings($user['computingID']);

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
  <title>View Profile</title> 
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
  <link rel="stylesheet" href="activity-styles.css" /> 
</head>
<body>  
<img style="max-width: 300px; height:auto; max-height: 200px;  margin-left: auto; margin-right: auto;" src="../profilePics/<?=$user['profilePic']?>" > <br>
Computing ID: <?php echo $user['computingID']; ?> <br>
Name: <?php echo $user['name']; ?> <br>
Year: <?php echo $user['year']; ?> <br> <br>

Favorites:
<div class="row justify-content-center">  
    <table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
      <thead>
      <tr style="background-color:#B0B0B0">
        <th> Image </th>    
        <th >Title </th>
        <th> Price </th>   
        <th> Post Date </th>
        <th> View </th>
        <th> Make Offer </th>
      </tr>
      </thead>
    <?php foreach ($favorites as $listing): ?>
      <tr>
        <td><img src="../itemPics/<?=$listing['itemPic']?>" width=40 height=40></td>
        <td><?php echo $listing['title']; ?></td>  
        <td>$<?php echo $listing['listed_price']; ?></td>  
        <td><?php echo $listing['post_date']; ?></td> 
        <td> 
          <form action="viewProfile.php" method="post" >
            <input type="submit" name="viewListingBtn" value="View" class="btn btn-dark"/>
            <input type="hidden" name="listingToView" value="<?php echo $listing['listingID'];?>" />     
          </form>  
        </td>  
        <td> 
          <form action="viewProfile.php" method="post" >
            <input type="submit" name="makeOfferBtn" value="Offer" class="btn btn-dark"/>
            <input type="hidden" name="listingToOffer" value="<?php echo $listing['listingID'];?>" />     
          </form>  
        </td>
      </tr>
    <?php endforeach; ?>
</table>
</div>

Listings:
<div class="row justify-content-center">  
    <table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
      <thead>
      <tr style="background-color:#B0B0B0">
        <th> Image </th>    
        <th >Title </th>
        <th> Price </th>   
        <th> Post Date </th>
        <th> View </th>
        <?php if($isMyProfile) : ?>
            <th> Edit </th>
            <th> Delete </th>
        <?php endif; ?>
        <?php if(!$isMyProfile) : ?>
            <th> Make Offer </th>
        <?php endif; ?>
      </tr>
      </thead>
    <?php foreach ($listings as $listing): ?>
      <tr>
        <td><img src="../itemPics/<?=$listing['itemPic']?>" width=40 height=40></td>
        <td><?php echo $listing['title']; ?></td>  
        <td>$<?php echo $listing['listed_price']; ?></td>  
        <td><?php echo $listing['post_date']; ?></td> 
        <td> 
          <form action="viewProfile.php" method="post" >
            <input type="submit" name="viewListingBtn" value="View" class="btn btn-dark"/>
            <input type="hidden" name="listingToView" value="<?php echo $listing['listingID'];?>" />     
          </form>  
        </td>  
        <?php if($isMyProfile) : ?>
        <td> 
          <form action="viewProfile.php" method="post" >
            <input type="submit" name="editListingBtn" value="Edit" class="btn btn-dark"/>
            <input type="hidden" name="listingToEdit" value="<?php echo $listing['listingID'];?>" />     
          </form>  
        </td>     
        <td> 
          <form action="viewProfile.php" method="post" >
            <input type="submit" name="deleteListingBtn" value="Delete" class="btn btn-danger"/>
            <input type="hidden" name="listingToDelete" value="<?php echo $listing['listingID'];?>" />     
          </form>  
        </td>
        <?php else : ?>  
        <td> 
          <form action="viewProfile.php" method="post" >
            <input type="submit" name="makeOfferBtn" value="Offer" class="btn btn-dark"/>
            <input type="hidden" name="listingToOffer" value="<?php echo $listing['listingID'];?>" />     
          </form>  
        </td>
        <?php endif; ?>
      </tr>
    <?php endforeach; ?>
</table>
</div>
</body>
</html>