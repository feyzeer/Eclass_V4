<?php

if (isset($_POST['remember'])){
    session_cache_expire(60 * 24 * 30);
} else {
    session_cache_expire(60 * 24);
}
session_start();
if (isset($_SESSION['id'])) {
    header('location: dashboard.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    

    if (isset($_POST['email']) && isset($_POST['password'])){
        $servername = "localhost";
        $username = "root";
        $password = "password";
        $dbname = "e_classe_db";
    
        $conn = new mysqli($servername, $username, $password, $dbname);
    
        if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        }
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = hash('sha256', $_POST['password']);
        

        //admin@gmail.com' #
        //
        
        $sql = "SELECT * FROM comptes WHERE email='$email' AND password='$password'";

        $foo = mysqli_query($conn, $sql);
        
        if ( mysqli_num_rows($foo) != 0){
            session_start();
            //echo var_dump(mysqli_fetch_assoc($foo));
            $result = mysqli_fetch_assoc($foo);
            $_SESSION['id'] = $result['id'];
            $_SESSION['username'] = $result['username'];
            $_SESSION['email'] = $result['email'];
            header('location: dashboard.php');
            echo $_SESSION['id']."<br>";
            echo $_SESSION['username']."<br>";
            echo $_SESSION['email']."<br>";
            exit();
        } else {
            $err = "Invalid login or password";
        }

    } else {
        echo "INPUTS REQUIRED";
    }
    mysqli_close($conn);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<?php include 'toast/toast.php';?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>

<style>
        body {
            height : 70vh;
            background-image: linear-gradient(to top right,#00C1FE, #FAFFC1);
        }

    </style>
</head>
<body>
    <style>
        
        label.error {
        color: #a94442;
        background-color: #f2dede;
        border-color: #ebccd1;
        padding:1px 20px 1px 20px;
        border-radius: 3px;
        margin : 5px;
        }

    </style>
    <main style="margin-top: 30vh;">
        <form class="mx-auto bg-light p-4" style="max-width: 400px;border-radius: 15px;" id="basic-form" method="POST">
          <h1 style="" class="ms-4 ps-2 border-start border-4 mb-3 fw-bold border-info" >E-classe</h1>
            <h2 class='text-center h5 mt-4'>SIGN IN</h2>
            <h3 class="mb-5 text-center font-weight-light h6 mt-1 text-secondary">Enter your credentials to access your account</h3>
            <br>
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" id="email"  placeholder="name@example.com">
            <br>
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" id="password"  placeholder="********">

            <label for="floatingRemember">Remember me</label>
            <input type="checkbox" class="form-check-input" name="remember" id="floatingRemember" value="1">
      
          <input type="submit" class="w-100 mt-3 btn btn-lg btn-info text-white">
            <div class="mt-2 text-center text-black-50">
                <span>Forgot your password? <a class="text-info" href="#">Reset Password</a></span>
            </div>
            <?php
            if (isset($err) and !(empty($err))){
                echo "<script>new Toast({message: '$err',type: 'danger'});</script>";
            }
        ?>
        </form>
      </main>
<?php 

    if (isset($_GET['success'])) {
        echo "<script>new Toast({message: 'Account created! please login',type: 'success'});</script>";
    }

?>

<script>

$(document).ready(function() {
    $("#basic-form").validate({
        rules: {
            email : {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 3
            }
        }
    });
});

</script>
</body>
</html>
