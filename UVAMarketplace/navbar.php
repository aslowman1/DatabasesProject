<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
<nav class="navbar navbar-expand-md bg-dark navbar-dark">
    <a class="navbar-brand" href="home.php">UVA Marketplace</a>
    
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="collapsibleNavbar">   
        <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="createListing.php">Create Listing</a>
        </li>                                                  
        <li class="nav-item dropdown" style="right:0">
            <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img src="../profilePics/<?=$_SESSION['profilePic']?>" 
                width="40" height="40" class="rounded-circle"> </a>
            <div class="dropdown-menu dropdown-menu-sw" style="right:0" aria-labelledby="dropdown01">
            <a class="dropdown-item" href="viewProfile.php">View Profile</a>
            <a class="dropdown-item" href="updateProfile.php">Edit Profile</a>
            <a class="dropdown-item" href="logout.php">Logout</a>
            </div>
        </li> 
        </ul>
    </div>        
</nav>