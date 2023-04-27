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

        header("Location: home.php");
        exit();
    }
}

?>

<!DOCTYPE html>
<html>
<?php include 'navbar.php';?>
<head>
	<title>Update Profile Page</title>
	<style>
		body {
			background-image: url('tundy.jpeg'); /* Change the image path to your desired background image */
			background-repeat: no-repeat;
			background-size: cover;
			display: flex;
			justify-content: center;
			align-items: center;
			height: 100vh;
			margin: 0;
			padding: 0;
			font-family: Arial, sans-serif;
			font-size: 16px;
		}

		form {
			background-color: #fff;
			padding: 30px;
			border-radius: 10px;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
			display: flex;
			flex-direction: column;
			align-items: center;
			text-align: center;
		}

		h1 {
			margin: 0 0 30px;
			font-size: 32px;
			font-weight: bold;
		}

		input,
		select {
			padding: 10px;
			margin-bottom: 20px;
			width: 100%;
			box-sizing: border-box;
			border: none;
			border-radius: 5px;
			box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
		}

		textarea {
			padding: 10px;
			margin-bottom: 20px;
			width: 100%;
			box-sizing: border-box;
			border: none;
			border-radius: 5px;
			box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
			resize: none;
			height: 100px;
		}

		button {
			padding: 10px 20px;
			background-color: #333;
			color: #fff;
			border: none;
			border-radius: 5px;
			box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
			cursor: pointer;
			font-size: 16px;
		}

		button:hover {
			background-color: #444;
		}
	</style>
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