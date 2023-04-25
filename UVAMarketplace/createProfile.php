<?php
require("connect-db.php");

require('Account-db.php');

if (!isset($_SESSION)) {
    session_start();
}

if (!$_SESSION['username']) {
    header("Location: signup.php");
    exit();
} 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['createProfileBtn'])) {
        $computingID = $_POST['computingID'];
        $name = $_POST['name'];
        $year = $_POST['year'];
        $profilePic = $_FILES['profilePic'];
        $username = $_SESSION['username'];
        createProfile($computingID, $name, $year, $profilePic, $username);
        setSessionVars($username);
        header("Location: home.php");
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
  <title>Create Profile</title> 
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
  <link rel="stylesheet" href="activity-styles.css" /> 
</head>
<body>  
  <div>  
    <h1>Create Profile</h1>
    <form action="createProfile.php" method="post" enctype="multipart/form-data">     
      Computing ID: <input type="text" name="computingID" minlength="6" maxlength="7" required /> <br/>
      Name: <input type="text" name="name" required /> <br/>

      <input type="radio" name="year" value="1" checked>
      <label for="1">1</label><br>
      <input type="radio" name="year" value="2">
      <label for="2">2</label><br>
      <input type="radio" name="year" value="3">
      <label for="3">3</label><br>
      <input type="radio" name="year" value="4">
      <label for="4">4</label><br>

      <input type="file" name="profilePic" accept="image/png, image/jpeg, image/jpg"> <br>
      <input type="submit" name ="createProfileBtn" value="Submit" class="btn" /> <br/>
    </form>
  </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    
</body>
</html>