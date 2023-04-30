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
elseif (!$_SESSION['listingID']) {
    header("Location: home.php");
    exit();
}

$listing = getListingByID($_SESSION['listingID']);
$category = $listing['categoryID'];
$listingID = $listing['listingID'];
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
    if (!empty($_POST['updateListingBtn'])) {
        $title = $_POST['title'];
        $location = $_POST['location'];
        $description = $_POST['description'];
        
        $size = isset($_POST['sizeText'])=="New" ? $_POST['sizeText']:'';
        $material = isset($_POST['materialText'])=="New" ? $_POST['materialText']:'';
        $dimensions = isset($_POST['dimensionsText'])=="New" ? $_POST['dimensionsText']:'';
        $bookTitle = isset($_POST['bookTitleText'])=="New" ? $_POST['bookTitleText']:'';
        $course = isset($_POST['courseText'])=="New" ? $_POST['courseText']:'';
        $IBSN = isset($_POST['IBSNText'])=="New" ? $_POST['IBSNText']:'';

        $condition = $_POST['condition'];
        $listed_price = $_POST['price'];
        $itemPic = $_FILES['itemPic'];

        updateListing($listingID, $title, $location, $description, $category, $size, $material, $dimensions, $bookTitle, $course, $IBSN, $condition, $listed_price, $itemPic);
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
  <title>Create Profile</title> 
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
  <link rel="stylesheet" href="activity-styles.css" /> 
</head>
<body>  
  <div>  
    <h1>Edit Listing</h1>
    <form action="updateListing.php" method="post" enctype="multipart/form-data">     
      Listing Title: <br> <input type="text" name="title" value="<?=$listing['title']?>" required /> <br/>
      Location: <br> <input type="text" name="location" value="<?=$listing['location']?>" required /> <br/>
      Description: <br>
      <textarea name="description" rows="4" cols="50"><?php echo($listing['description']); ?> </textarea> <br> 
      
      <?php if($listing['categoryID'] == "2") : ?>
      <div id="size">Size: <br> <input type="text" id="sizText" name="sizeText" value="<?=$clothes['size']?>" /> <br/> </div>
    
      <?php elseif($listing['categoryID'] == "1") : ?>
      <div id="material">Material: <br> <input type="text" id="materialText" name="materialText" value="<?=$furniture['material']?>"/> <br> </div>
      <div id="dimensions"> Dimensions: <br> <input type="text" id="dimensionsText" name="dimensionsText" value="<?=$furniture['dimensions']?>"/> <br> </div>
      
      <?php elseif($listing['categoryID'] == "3") : ?>
      <div id="book">Textbook Title: <br> <input type="text" id="bookTitleText" name="bookTitleText" value="<?=$book['name']?>"/> <br/> </div>
      <div id="course">Course: <br> <input type="text" id="courseText" name="courseText"  value="<?=$book['course']?>"/><br/> </div>
      <div id="IBSN">ISBN: <br> <input type="text" id="IBSNText" name="IBSNText" value="<?=$book['IBSN']?>"/> <br>  </div>
    
      <?php endif; ?>

      Condition: <br>
      <select name="condition">
        <option value="New" <?php echo ($listing['condition']=="New") ? 'selected':'';?>>New</option>
        <option value="Good" <?php echo ($listing['condition']=="Good") ? 'selected':'';?>>Good</option>
        <option value="Fair" <?php echo ($listing['condition']=="Fair") ? 'selected':'';?>>Fair</option>
        <option value="Poor" <?php echo ($listing['condition']=="Poor") ? 'selected':'';?> >Poor</option>
        </select> <br> <br>

      Price: <br>
      $<input type="number" step="0.01" min=0 name="price" value="<?=$listing['listed_price']?>"> <br>

      Image: <br>
      <input type="file" name="itemPic" accept="image/png, image/jpeg, image/jpg"> <br>
      <input type="submit" name ="updateListingBtn" value="Submit" class="btn" /> <br/>
    </form>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.0/jquery.min.js"></script>


</body>
</html>