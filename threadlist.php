<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>iforum - coding forum</title>
</head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
</script>

<body>
    <?php

     include 'partials/_header.php';
     include 'partials/_dbconnect.php';
    

    
    
    $id = $_GET['catid'];
    $sql = "SELECT * FROM `categories` WHERE category_id = '$id'";
    $result = mysqli_query($conn,$sql);
        // starting while here

    while($row = mysqli_fetch_assoc($result)){
        $catname = $row['category_name'];
        $catdesc = $row['category_description'];
    }   
    
    ?>
    <?php 
    $showalert = false;
    $method = $_SERVER['REQUEST_METHOD'];
    if($method=='POST'){
        $th_title = $_POST['title'];
        $th_desc = $_POST['desc'];
        $sno = $_POST['sno'];
        $sql = "INSERT INTO `threads` ( `thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES ('$th_title', '$th_desc', '$id', '$sno', current_timestamp())";
        $result = mysqli_query($conn, $sql);
        $showalert = true;
        if($showalert){
            echo 
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>success!</strong> your thread is posted succesfully.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
    }
    
    ?>


    <!-- slider starts here -->



    <!-- category container starts here -->
    <div class="container my-4 bg-body-secondary">
        <div class="jumbotron ">
            <h1 class="display-4">welcome to <?php echo $catname; ?></h1>
            <p class="lead"><?php echo $catdesc; ?></p>
            <hr class="my-4">
            <p>It uses the data only coming from threads</p>
            <p class="lead">
                <a class="btn btn-success btn-lg" href="#" role="button">Learn more</a>
            </p>
        </div>
    </div>
    <?php
    if(isset($_SESSION['loggedin'])&& $_SESSION['loggedin'] == true){
    echo '<div class="container">

        <h1 class="py-2">Ask question</h1>
        <form action=" ' .$_SERVER['REQUEST_URI'] .'" method="post">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">problem title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">keep our title as crisp as you can</div>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">elaborate your concern</label>
                <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
                <input type="hidden" name="sno" value=" '.$_SESSION['sno'].'">
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>';
    }
    else{
        echo '<div class="container my-4 bg-body-secondary">
        <h1 class="py-2">Ask question</h1>
        <p class="lead">plz login first to start discussion</p>
        </div>';
    }
?>



    <div class="container">

        <h1 class="py-2">Browse question</h1>
        
        <?php 

$id = $_GET['catid'];
$sql = "SELECT * FROM `threads` WHERE thread_cat_id = '$id'";
$result = mysqli_query($conn,$sql);
$noResult = true;
// starting while here

while($row = mysqli_fetch_assoc($result)){
    $noResult= false;
    $id = $row['thread_id'];
    $title = $row['thread_title'];
    $desc = $row['thread_desc'];
    $thread_time = $row['timestamp'];
   
    $thread_user_id =$row['thread_user_id'];
    $sql2 ="SELECT user_email FROM users WHERE sno = '$thread_user_id'";
    $result2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_assoc($result2);

        
    
    
    echo  '<div class="d-flex">
    <div class="flex-shrink-0">
    <img src="https://picsum.photos/70/70/" alt="...">
    </div>
    <div class="flex-grow-1 ms-3">
    
    <h5 class="mt-0"><a class = "text-dark" href="threads.php?threadid='. $id .'">'. $title .'</a></h5>
    '. $desc .'</div>'.'<div> <p class="fw-bold"> asked by '. $row2['user_email'] .' at '.$thread_time.'</p> </div>'.'
    </div>';
}   

if($noResult){
    echo '<div class="jumbotron jumbotron-fluid bg-body-secondary">
    <div class="container">
    <p class="display-4">No Comments Found</p>
    <p class="lead"> Be the first person to comment</p>
    </div>
    </div> ';
}
?>
        <hr>
        
    </div>
        
    <?php include 'partials/_footer.php';?>

</body>

</html>