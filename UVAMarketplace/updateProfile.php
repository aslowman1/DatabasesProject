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

        updateProfile($computingID, $name, $year, $profilePic, $username);
        setSessionVars($username);

        header("Location: viewProfile.php");
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

    label, input, select{
      font-family: "Lucida Console", Courier New, monospace;
      font-size: 15px;
      text-align: center;
      font-weight: bold;
      line-height: 0;
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
      margin-bottom: 30px;
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
  <?php include 'navbar.php';?>
  <div class="card">
    <div class="row justify-content-center">
      <div class="col-12 col-md-6">
        <h1 class="text-center mb-4">Update Profile</h1>
        <form action="updateProfile.php" method="post" enctype="multipart/form-data">     
          <input type="hidden" name="computingID" value="<?=$_SESSION['computingID']?>" minlength="6" maxlength="7" required />
          <div class="mb-3">
            <label for="name" class="form-label">Name:</label>
            <input type="text" name="name" id="name" class="form-control" value="<?=$_SESSION['name']?>" required />
          </div>
          <div class="mb-3">
            <label for="year" class="form-label">Year:</label>
            <select name="year" id="year" class="form-select">
              <option value="1" <?php echo ($_SESSION['year']=="1") ? 'selected':'';?>>1</option>
              <option value="2" <?php echo ($_SESSION['year']=="2") ? 'selected':'';?>>2</option>
              <option value="3" <?php echo ($_SESSION['year']=="3") ? 'selected':'';?>>3</option>
              <option value="4" <?php echo ($_SESSION['year']=="4") ? 'selected':'';?>>4</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="profilePic" class="form-label">Profile Picture:</label>
            <input type="file" name="profilePic" id="profilePic" accept="image/png, image/jpeg, image/jpg" class="form-control">
          </div>
          <div class="button">
            <input type="submit" name="updateProfileBtn" value="Submit" class="btn"  >
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    
 </body>
</html>
