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


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['createListingBtn'])) {
        $title = $_POST['title'];
        $location = $_POST['location'];
        $description = $_POST['description'];
        $category = $_POST['category'];

        $size = $_POST['sizeText'];
        $material = $_POST['materialText'];
        $dimensions = $_POST['dimensionsText'];
        $bookTitle = $_POST['bookTitleText'];
        $course = $_POST['courseText'];
        $IBSN = $_POST['IBSNText'];

        $condition = $_POST['condition'];
        $listed_price = $_POST['price'];
        $itemPic = $_FILES['itemPic'];

        createListing($title, $location, $description, $category, $size, $material, $dimensions, $bookTitle, $course, $IBSN, $condition, $listed_price, $itemPic);
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
    <h1>Create Listing</h1>
    <form action="createListing.php" method="post" enctype="multipart/form-data">     
      Listing Title: <br> <input type="text" name="title" required /> <br/>
      Location: <br> <input type="text" name="location" required /> <br/>
      Description: <br>
      <textarea name="description" rows="4" cols="50"> </textarea> <br> 

      Category: <br>
      <input type="radio" name="category" id="clothes" value="2" checked>
      <label for="Clothes">Clothes</label><br>
      <input type="radio" name="category" id="furniture" value="1">
      <label for="Furniture">Furniture</label><br>
      <input type="radio" name="category" id="books" value="3">
      <label for="Books">Textbook</label> <br> <br>
      
      <div id="size">Size: <br> <input type="text" id="sizText" name="sizeText" /> <br/> </div>

      <div id="material">Material: <br> <input type="text" id="materialText" name="materialText"/> <br> </div>
      <div id="dimensions"> Dimensions: <br> <input type="text" id="dimensionsText" name="dimensionsText"/> <br> </div>
      
      <div id="book">Textbook Title: <br> <input type="text" id="bookTitleText" name="bookTitleText"/> <br/> </div>
      <div id="course">Course: <br> <input type="text" id="courseText" name="courseText"/> <br/> </div>
      <div id="IBSN">IBSN: <br> <input type="text" id="IBSNText" name="IBSNText" /> <br> </div>
    
      Condition: <br>
      <select name="condition">
        <option value="New" selected>New</option>
        <option value="Good">Good</option>
        <option value="Fair">Fair</option>
        <option value="Poor" >Poor</option>
        </select> <br> <br>

      Price: <br>
      $<input type="number" step="0.01" min=0 name="price"> <br>

      Image: <br>
      <input type="file" name="itemPic" accept="image/png, image/jpeg, image/jpg"> <br>
      <input type="submit" name ="createListingBtn" value="Submit" class="btn" /> <br/>
    </form>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.0/jquery.min.js"></script>

  <script>
    $(document).ready(function() {
      
      // add a click event listener to the first radio button
      $('#clothes').click(function() {
        if ($(this).is(':checked')) {
          $('#size').show();
          $('#sizeText').attr("required", true);

          $('#material').hide();
          $('#materialText').attr('required', false);

          $('#dimensions').hide();
          $('#dimensionsText').attr('required', false);

          $('#book').hide();
          $('#bookTitleText').attr('required', false);

          $('#course').hide();
          $('#courseText').attr('required', false);

          $('#IBSN').hide();
          $('#IBSNText').attr('required', false);
        }
      });
      
      $('#furniture').click(function() {
        if ($(this).is(':checked')) {
          $('#size').hide();
          $('#sizeText').attr('required', false);

          $('#material').show();
          $('#materialText').attr('required', true);

          $('#dimensions').show();
          $('#dimensionsText').attr('required', true);

          $('#book').hide();
          $('#bookTitleText').attr('required', false);

          $('#course').hide();
          $('#courseText').attr('required', false);

          $('#IBSN').hide();
          $('#IBSNText').attr('required', false);
        }
      });

      $('#books').click(function() {
        if ($(this).is(':checked')) {
          $('#size').hide();
          $('#sizeText').attr('required', false);

          $('#material').hide();
          $('#materialText').attr('required', false);

          $('#dimensions').hide();
          $('#dimensionsText').attr('required', false);

          $('#book').show();
          $('#bookTitleText').attr('required', true);

          $('#course').show();
          $('#courseText').attr('required', true);

          $('#IBSN').show();
          $('#IBSNText').attr('required', true);
        }
      });
      $('#clothes').click();
    });
  </script>
</body>
</html>