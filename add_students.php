<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<?php include 'toast/toast.php';?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>

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

<form class="w-50 mx-auto" method="POST" id="basic-form" action="">
<div class="form-group">
  <label for="fname">name:</label>
  <input class="form-control"  type="text" id="fname" name="fname">
</div>
<div class="form-group">
  <label for="lname">email:</label>
  <input class="form-control"  type="email" id="email" name="email">
</div>
<div class="form-group">
  <label for="lname">phone:</label>
  <input class="form-control"  type="text" id="phone" name="phone">
</div>
<div class="form-group">
  <label for="lname">enroll:</label>
  <input class="form-control"  type="text" id="enroll" name="enroll">
</div>
  <input type="submit" class="btn btn-primary" value="Submit">
</form>

<script>

$(document).ready(function() {
    $("#basic-form").validate({
        rules: {
            fname : {
                required: true,
                minlength: 3,
                maxlength: 15
            },
            email: {
                required: true,
                minlength: 3,
                email: true
            },
            phone: {
                required: true,
                minlength: 10,
                number: true
            },
            enroll: {
                required: true,
                number: true
            }
        }
    });
});


</script>

<?php

include 'protection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $servername = "localhost";
  $username = "root";
  $password = "password";
  $dbname = "e_classe_db";

  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $fname=mysqli_real_escape_string($conn,$_POST['fname']);
  $email=mysqli_real_escape_string($conn,$_POST['email']);
  $phone=mysqli_real_escape_string($conn,$_POST['phone']);
  $enroll=mysqli_real_escape_string($conn,$_POST['enroll']);
  $date = date("Y-m-d");

  echo $fname."<br>".$email."<br>".$phone."<br>".$enroll;

  
  $sql = "INSERT INTO students (fname, email, phone, enroll, fdate) VALUES ('$fname', '$email', '$phone', '$enroll', '$date')";

  if (mysqli_query($conn, $sql)) {
    header('location: students.php?msg=Student added successfully');
  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }

mysqli_close($conn);

}

?>