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
    

    
    
    $id = $_GET['threadid'];
    $sql = "SELECT * FROM `threads` WHERE thread_id = '$id'";
    $result = mysqli_query($conn,$sql);
        // starting while here

    while($row = mysqli_fetch_assoc($result)){
        $title = $row['thread_title'];
        $desc = $row['thread_desc'];
        $thread_user_id = $row['thread_user_id'];
        // Query the users table to find out the name of OP
        $sql2 = "SELECT user_email FROM `users` WHERE sno ='$thread_user_id'";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($result2);
        $posted_by = $row2['user_email'];
    }   
    
    ?>
    <?php 
    $showalert = false;
    $method = $_SERVER['REQUEST_METHOD'];
    if($method=='POST'){
        $comment = $_POST['comment'];
        $sno = $_POST['sno'];
        $sql = "INSERT INTO `comments` ( `comment_by`, `comment_content`, `thread_id`, `comment_time`) VALUES ( '$sno', '$comment', '$id', current_timestamp())";
        $result = mysqli_query($conn, $sql);
        $showalert = true;
        if($showalert){
            echo 
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
           
            <strong>success!</strong> your comment is posted succesfully.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
    }
    
    ?>


    <!-- slider starts here -->



    <!-- category container starts here -->
    <div class="container my-4 bg-body-secondary">
        <div class="jumbotron">
            <h1 class="display-4"> <?php echo $title; ?></h1>
            <p class="lead"><?php echo $desc; ?></p>
            <hr class="my-4">
            <p>It uses the data only coming from threads</p>
            <p class="lead">
            <p>posted by: <b> <?php echo $posted_by;?></b></p>
            </p>
        </div>
    </div>

    <?php
    if(isset($_SESSION['loggedin'])&& $_SESSION['loggedin'] == true){
    echo '<div class="container">
        <h1 class="py-2">add comments</h1>
        <form action="' .$_SERVER['REQUEST_URI']. '" method="post">

            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">write your comment</label>
                <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                <input type="hidden" name="sno" value=" '.$_SESSION['sno'].'">
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
        <h1 class="py-2">Discussions</h1>
</div>';
    }
    else{
        echo '<div class="container my-4 bg-body-secondary">
        <h1 class="py-2">Add comment</h1>
        <p class="lead">plz login first to add your comment</p>
        </div>
        ';
    }
?>

    <div class="container">
        <?php 

            $id = $_GET['threadid'];
                $sql = "SELECT * FROM `comments` WHERE thread_id = '$id'";
                $result = mysqli_query($conn,$sql);
                $noResult = true;
                // starting while here
                
                while($row = mysqli_fetch_assoc($result)){
                    $noResult= false;
                    $id = $row['comment_id'];
                    $content = $row['comment_content'];
                    $comment_time = $row['comment_time'];
                    $thread_user_id =$row['comment_by'];
                    $sql2 ="SELECT user_email FROM users WHERE sno = '$thread_user_id'";
                    $result2 = mysqli_query($conn, $sql2);
                    $row2 = mysqli_fetch_assoc($result2);
                    
                    
                    
                    echo  '<div class="d-flex">
                    <div class="flex-shrink-0">
                    <img src="https://picsum.photos/70/70/" alt="...">
                    </div>
                    <div class="flex-grow-1 ms-3">
                     <p class="fw-bold">'. $row2['user_email'] .' at '. $comment_time .'</p>
                    '. $content .'
                    </div>
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
    </div>

    <?php include 'partials/_footer.php';?>

</body>

</html>