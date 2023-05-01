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

    h2, input, option, select, textarea{
      font-family: "Lucida Console", Courier New, monospace;
      font-size: 15px;
      text-align: center;
      font-weight: bold;
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
      padding: 30px;
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
</head>
<body>  
  <div class="card">  
    <h1>Edit Listing</h1>
    <form action="updateListing.php" method="post" enctype="multipart/form-data">     
      <h2> Listing Title: </h2>   <input type="text" name="title" value="<?=$listing['title']?>" required /> <br/>
      <h2> Location: </h2>   <input type="text" name="location" value="<?=$listing['location']?>" required /> <br/>
      <h2> Description: </h2> 
      <textarea name="description" rows="4" cols="50"><?php echo($listing['description']); ?> </textarea> <br> 
      
      <?php if($listing['categoryID'] == "2") : ?>
      <div id="size"> <h2> Size: </h2> <input type="text" id="sizText" name="sizeText" value="<?=$clothes['size']?>" /> <br/> </div>
    
      <?php elseif($listing['categoryID'] == "1") : ?>
      <div id="material"> <h2> Material:</h2> <input type="text" id="materialText" name="materialText" value="<?=$furniture['material']?>"/> <br> </div>
      <div id="dimensions"> <h2> Dimensions: </h2> <input type="text" id="dimensionsText" name="dimensionsText" value="<?=$furniture['dimensions']?>"/> <br> </div>
      
      <?php elseif($listing['categoryID'] == "3") : ?>
      <div id="book"> <h2> Textbook Title: </h2> <input type="text" id="bookTitleText" name="bookTitleText" value="<?=$book['name']?>"/> <br/> </div>
      <div id="course"><h2> Course: </h2> <input type="text" id="courseText" name="courseText"  value="<?=$book['course']?>"/><br/> </div>
      <div id="IBSN"> <h2> ISBN: </h2>  <input type="text" id="IBSNText" name="IBSNText" value="<?=$book['IBSN']?>"/> <br>  </div>
    
      <?php endif; ?>

      <h2> Condition: </h2> 
      <select name="condition">
        <option value="New" <?php echo ($listing['condition']=="New") ? 'selected':'';?>>New</option>
        <option value="Good" <?php echo ($listing['condition']=="Good") ? 'selected':'';?>>Good</option>
        <option value="Fair" <?php echo ($listing['condition']=="Fair") ? 'selected':'';?>>Fair</option>
        <option value="Poor" <?php echo ($listing['condition']=="Poor") ? 'selected':'';?> >Poor</option>
        </select> 

        <h2> Price: </h2>  
      $<input type="number" step="0.01" min=0 name="price" value="<?=$listing['listed_price']?>"> </br>

      <h2> Image:</h2>  
      <input type="file" name="itemPic" accept="image/png, image/jpeg, image/jpg"> </br> </br>
      <div class="button"> </br>
          <input type="submit" name ="updateListingBtn" value="Submit" class="btn" /> 
      </div>
    </form>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.0/jquery.min.js"></script>


</body>
</html>