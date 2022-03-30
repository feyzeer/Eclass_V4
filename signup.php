<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    

    if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['username'])){
        $servername = "localhost";
        $username = "root";
        $password = "password";
        $dbname = "e_classe_db";
    
        $conn = new mysqli($servername, $username, $password, $dbname);
    
        if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        }
        
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = hash('sha256', $_POST['password']);
        
        
        $sql = "SELECT * FROM comptes WHERE email='$email'";

        $foo = mysqli_query($conn, $sql);
        
        if ( mysqli_num_rows($foo) == 0){
            $insert = "INSERT INTO comptes (username, email, password) VALUES ('$username', '$email', '$password')";
            mysqli_query($conn, $insert);
            header('location: signin.php?success=1');
            exit();
        } else {
            $err = "User Already exists!";
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <style>
        body {
            height : 70vh;
            background-image: linear-gradient(to top right,#00C1FE, #FAFFC1);
        }

    </style>
    <?php include 'toast/toast.php';?>

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
            <h2 class='text-center h5 mt-4'>REGISTER</h2>
            <h3 class="mb-5 text-center font-weight-light h6 mt-1 text-secondary">Enter your credentials to access your account</h3>
            
            <label for="username">Username</label>
            <input type="text" class="form-control" name="username" id="username" placeholder="Ali">

            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com">
      
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Password">

          <input type="submit" class="w-100 mt-3 btn btn-lg btn-info text-white">
            <?php
            if (isset($err) and !(empty($err))){
                echo "<script>new Toast({message: '$err',type: 'danger'});</script>";
            }
        ?>
        </form>
      </main>

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
            },
            username: {
                required: true,
                minlength: 3,
                maxlength: 10
            }
        }
    });
});

</script>

</body>
</html>
