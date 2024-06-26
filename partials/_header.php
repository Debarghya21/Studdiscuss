<?php
session_start();

echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="/StudDiscuss">StudDiscuss</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/StudDiscuss">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="about.php">About</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Categories.
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">';
          $sql="SELECT category_name,category_id FROM `categories`";
          $result=mysqli_query($conn,$sql);
          while($row=mysqli_fetch_assoc($result)){
            echo '<li><a class="dropdown-item" href="threadlist.php?catid='.$row['category_id'].'">'.$row['category_name'].'</a></li>';
          }
           
          echo '</ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="contact.php"  >Contacts</a>
        </li>
      </ul>
      <form class="d-flex" action="search.php" method="get">
      <input class="form-control me-2" name="search" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-success" type="submit">Search</button>
    </form>
      <div class="mx-2">';
      if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
        echo '<div class="container"><div class="row"><div class="col-sm"><p class="text-light <!--my-0 mx-2-->">Welcome '.$_SESSION['useremail'].'</p></div><div class="col-sm"><a href="partials/_logout.php" class="btn btn-outline-success my-2" >Logout</a></div></div></div>';
      }
      else{
     echo  '<button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#loginModal">login</button>
      <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#signupModal">Signup</button>';
      }

     echo  '</div>
   
    </div>
  </div>
</nav>';
include 'partials/_loginModal.php';
include 'partials/_signupModal.php';
if(isset($_GET['signupsuccess']) && $_GET['signupsuccess']=="true"){
  echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success!</strong> You can now login.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';

}
?>