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
  <input class="form-control" required type="text" id="name" name="fname">
</div>
<div class="form-group">
  <label for="schedule">schedule:</label>
  <input class="form-control" required type="text" id="schedule" name="schedule">
</div>
<div class="form-group">
  <label for="balance">balance:</label>
  <input class="form-control" required type="text" id="balance" name="balance">
</div>
  <input type="submit" class="btn btn-primary" value="Submit">
</form>

<script>

$(document).ready(function() {
    $("#basic-form").validate({
        rules: {
            email : {
                required: true,
                email: true
            },
            balance: {
                required: true,
                number: true,
                min: 0
            },
            schedule: {
                required: true,
                minlength: 3    
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

  $fname= mysqli_real_escape_string($conn,$_POST['fname']);
  $schedule= mysqli_real_escape_string($conn,$_POST['schedule']);
  $balance= mysqli_real_escape_string($conn,$_POST['balance']);
  $date = date("Y-m-d");

  echo $fname."<br>".$schedule."<br>"."<br>".$balance;

  
  $sql = "INSERT INTO payment_details (fname, schedule, balance, fdate)
   VALUES ('$fname', '$schedule', '$balance', '$date')";

  if (mysqli_query($conn, $sql)) {
    header('location: payment.php?msg=Payment added');
  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }

mysqli_close($conn);

}

?>