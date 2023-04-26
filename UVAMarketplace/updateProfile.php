<?php
require("connect-db.php");
require('Account-db.php');
require('User-db.php');


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
    if (!empty($_POST['updateProfileBtn'])) {
        $computingID = $_POST['computingID'];
        $name = $_POST['name'];
        $year = $_POST['year'];
        $profilePic = $_FILES['profilePic'];
        $username = $_SESSION['username'];
        updateProfile($computingID, $name, $year, $profilePic);
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
    <h1>Update Profile</h1>
    <form action="updateProfile.php" method="post" enctype="multipart/form-data">     
      <input type="hidden" name="computingID" value="<?=$_SESSION['computingID']?>" minlength="6" maxlength="7" required />
      Name: <input type="text" name="name" value ="<?=$_SESSION['name']?>" required /> <br/>

      <input type="radio" name="year" value="1" <?php echo ($_SESSION['year']=="1") ? 'checked="checked"':'';?>>
      <label for="1">1</label><br>
      <input type="radio" name="year" value="2" <?php echo ($_SESSION['year']=="2") ? 'checked="checked"':'';?>>
      <label for="2">2</label><br>
      <input type="radio" name="year" value="3" <?php echo ($_SESSION['year']=="3") ? 'checked="checked"':'';?>>
      <label for="3">3</label><br>
      <input type="radio" name="year" value="4" <?php echo ($_SESSION['year']=="4") ? 'checked="checked"':'';?>>
      <label for="4">4</label><br>

      <input type="file" name="profilePic" accept="image/png, image/jpeg, image/jpg"> <br>
      <input type="submit" name ="updateProfileBtn" value="Submit" class="btn" /> <br/>
    </form>
  </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    
</body>
</html>