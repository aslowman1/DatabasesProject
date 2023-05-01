<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
<body>
<style>
    .navbar {
        /* background: transparent; */
        background-color: rgba(0, 0, 0, 0.5);
    }

    .logo {
        border-radius: 50%;
    }

    .profilePic {
        border-radius: 50%;
    }

    .nav-link {
        font-weight: bolder;
        display: block;
        font-size: 1.1em;
        font-weight: bold;
        color: white;
        padding: 10px;
        /* border-radius: 15%; */
        font-family: "Encode Sans", sans-serif;
    }

    a {
        font-weight: bolder;
        display: block;
        font-size: 1.1em;
        font-weight: bold;
        color: white;
    }

    .dropdown:hover .dropdown-menu {
        display: block;
        margin-top: 0;
    }

    .dropdown-menu-end {
        right: 0;
        left: auto;
    }
</style>

<nav class="navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="home.php" style="font-family: Lucida Console, Courier New, monospace; padding: 15px; font-size:25px, color:white;">UVA Marketplace
            </a>
            <div class="nav">
                <a class="nav-link" href="createListing.php" style="color: #FFFFFF">Create Listing</a> 
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" aria-expanded="false" style="color: white;"><img src="../profilePics/<?=$_SESSION['profilePic']?>" width="40" height="40" class="rounded-circle"> </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="viewProfile.php?profile=user">My Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="updateProfile.php">Edit Profile</a></li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </li>
            </div>
        </div>
    </nav>
</body>
<!-- <div class = "navbar">
    <a class="navbar-brand" href="home.php" style="font-family: Lucida Console, Courier New, monospace; padding: 15px; font-size:25px, color:FFFFFF">UVA Marketplace</a>

    <a class="nav-link" href="createListing.php" style="color: #FFFFFF; font-family: Tahoma, Geneva, sans-serif; font-size: 15px;
      letter-spacing: 2px; word-spacing: 2px">Create Listing</a> 

        <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img src="../profilePics/<?=$_SESSION['profilePic']?>" 
            width="40" height="40" class="rounded-circle"> </a>
        <div class="dropdown-menu dropdown-menu-sw" style="right:0" aria-labelledby="dropdown01">
        <a class="dropdown-item" href="viewProfile.php?profile=user">My Profile</a>
        <a class="dropdown-item" href="updateProfile.php">Edit Profile</a>
        <a class="dropdown-item" href="logout.php">Logout</a>
        
    </div>
 
    
    
</div>     -->