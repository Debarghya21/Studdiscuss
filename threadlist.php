<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>StudDiscuss - An online student discussion forum

    </title>
  </head>
  <body>
  <?php include 'partials/_dbconnect.php';?> // Connecting to the database.
    <?php include 'partials/_header.php';?>
    
    <?php
    $id=$_GET['catid'];
    $sql="SELECT * FROM `categories` WHERE category_id=$id";
    $result=mysqli_query($conn,$sql);
    while($row=mysqli_fetch_assoc($result)){ // Fetch the categories.
      $catname=$row['category_name'];
      $catdesc=$row['category_description'];
    }
    ?>
    <?php
    $showAlert=false;
    $method=$_SERVER['REQUEST_METHOD'];
    if($method=='POST'){ // When the form is submitted.
      $th_title=$_POST['title'];
      $th_desc=$_POST['desc'];
      $sno=$_POST['sno'];
      $sql="INSERT INTO `threads` ( `thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES ( '$th_title', '$th_desc', '$id', '$sno', current_timestamp());";
      $result=mysqli_query($conn,$sql);
      $showAlert=true;
      if($showAlert){ // Success Alert when the thread is added.
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Your thread is added. Please wait for other student to reply.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
      }
    }
    ?>
   <div class="container my-4">
   <div class="jumbotron">
  <h1 class="display-4"><?php echo $catname;?></h1>
  <p class="lead"><?php echo $catdesc;?></p>
  <hr class="my-4">
  <p>Share your knowledge in StudDiscuss Forum. Create unique posts. ...
Keep posts courteous. ...
Use respectful language when posting. ...
Posting content from private messages and displaying that subject matter on the public forum is prohibited. ...
Edit and delete posts as necessary using the tools provided by the forum.</p>
  <p class="lead">
    <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>
  </p>
</div>
   </div>
   <?php
   if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
   echo '<div class="container">
   <h1 class="py-2">Start Discussions here.</h1>
   <form action="'.$_SERVER['REQUEST_URI'].'" method="post">
  <div class="form-group">
    <label for="exampleInputEmail1">Problem Title</label>
    <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp" placeholder="Problem Title">
    <small id="emailHelp" class="form-text text-muted">Keep your problem title short and to the point.</small>
  </div>
  <div class="form-group">
    <label for="exampleFormControlTextarea1">Elaborate your concern.</label>
    <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
    <input type="hidden" name="sno" value="'.$_SESSION['sno'].'">
  </div>
 
  <button type="submit" class="btn btn-success my-2">Submit</button>
</form>
   </div>';}
   else{
    echo '<div class="container">
    <h1 class="py-2">Start Discussions here.</h1>
    <p class="lead">You are not logged in. Please login to start a discussion</p>
    </div>';
   }
   ?>
   <div class="container">
    <h1 class="py-2">See all Questions here.</h1>
    <?php
    $id=$_GET['catid'];
    $sql="SELECT * FROM `threads` WHERE thread_cat_id=$id";
    $result=mysqli_query($conn,$sql);
    $noResult=true;
    while($row=mysqli_fetch_assoc($result)){ // Fetching the thread results.
      $noResult=false;
      $id=$row['thread_id'];
      $title=$row['thread_title'];
      $desc=$row['thread_desc'];
      $thread_time=$row['timestamp'];
      $thread_user_id=$row['thread_user_id'];
      $sql2="SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
      $result2=mysqli_query($conn,$sql2);
      $row2=mysqli_fetch_assoc($result2);
      echo ' <div class="media my-3">
      <img class="mr-3" src="img/user_default.png" width="60px" alt="Generic placeholder image">
      <p class="font-weight-bold my-0">'.$row2['user_email'].' posted at '.$thread_time.'</p>
      <div class="media-body">
        <h5 class="mt-0"><a href="thread.php?threadid='.$id.'">'.$title.'</a></h5>
        '.$desc.'
      </div>
    </div>';
    }
    if($noResult){ // When no threads are found.
      echo '<div class="jumbotron jumbotron-fluid">
      <div class="container">
        <p class="display-6">No Threads Found</p>
        <p class="lead">Be the first person to ask.</p>
      </div>
    </div>';
    }
    ?>
    
   </div>
    <?php include 'partials/_footer.php'?>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>
</html>
