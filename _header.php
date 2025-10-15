<?php
session_start();
if(isset($_SESSION['loggedin'])&& $_SESSION['loggedin'] == true){
  echo '';

}
echo '
<nav class="navbar navbar-expand-lg bg-dark navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="/idiscuss">iforum</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="about.php">about</a>
        </li>
        
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            categories
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li>
      <li class="nav-item">
          <a class="nav-link" href="contact.php">contact</a>
        </li>
      </ul>
      ';

if(isset($_SESSION['loggedin'])&& $_SESSION['loggedin'] == true){
   echo '<form class="d-flex" role="search">
  <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"/>
  <button class="btn btn-success" type="submit">Search</button>
 <p class="text-light"> welcome '.$_SESSION['useremail'].'</p></form>
  
  <a href="partials/_logout.php" class="btn btn-outline-success ml-2">Logout</a>
</form>
 ';

}
else{
  echo '<form class="d-flex" role="search">
  <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"/>
  <button class="btn btn-success" type="submit">Search</button>
  </form>
  <div class="mx-2">
        <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#loginmodal">login</button>
        <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#signupmodal">signup</button>
      </div>';
}
echo'
  </div>
  </div>
</nav>

';
include '_loginmodal.php';
include '_signupmodal.php';
if(isset($_GET['signupsuccess'])&& $_GET['signupsuccess'] == "true"){
  echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
  <strong>Success</strong> You have been signed in
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';

}


// else{
//   echo '<div class="alert alert-warning alert-dismissible fade show my-0" role="alert">
//   <strong>warning</strong> invalid credentials
//   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
// </div>';
// }
?>
<!-- <li class="nav-item">
          <a class="nav-link" href="threadlist.php">threads</a>
        </li> -->