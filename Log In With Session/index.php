<?php
session_start();

$name="MIR";
$password="abcd";
$err=null;

if(isset($_SESSION['username'])){
    header('Location: dashboard.php');
    exit();
}

if($_POST){
    if($_POST['username']===$name and $_POST['password']===$password){
        $_SESSION['username']=$_POST['username'];
        header("Location: dashboard.php");
        exit();
    }else{
        $err="invalid name and pass";
    }
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Login</title>
</head>
<body>
    <div>
        <h1>Login</h1>
        <form method="post">
            <div class="form-group">
                <label for="username mb-3 ">Username</label>
                <input type="text" class="form-control" id="username" placeholder="Enter username" name="username">
                <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
            </div>
            <div class="form-group mt-3">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Password" name="password">
            </div>
            <!-- <div class="form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div> -->
            <button type="submit" class="btn btn-primary mt-3">Submit</button>
            </form>
        <?php
        if($err!==null){
            echo "<p class='text-danger mt-3'>$err</p>";
        }
        ?>
    </div>
</body>
</html>