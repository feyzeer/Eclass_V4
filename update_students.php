<?php include 'protection.php'; ?>
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

<?php
    $servername = "localhost";
    $username = "root";
    $password = "password";
    $dbname = "e_classe_db";
  
    $conn = new mysqli($servername, $username, $password, $dbname);
  
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

  if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    $id = mysqli_real_escape_string($conn,$_GET['id']);
  
    $sql = "SELECT * FROM students WHERE id = $id";
    $value = mysqli_fetch_assoc(mysqli_query($conn, $sql));
    
    echo '
    <form class="w-50 mx-auto" method="POST" id="basic-form" action="">
<div class="form-group">
  <label for="fname">name:</label>
  <input class="form-control"  type="text" id="fname" name="fname" value="'.$value['fname'].'">
</div>
<div class="form-group">
  <label for="email">email:</label>
  <input class="form-control"  type="text" id="email" name="email" value="'.$value['email'].'">
</div>
<div class="form-group">
  <label for="phone">phone:</label>
  <input class="form-control"  type="text" id="phone" name="phone" value="'.$value['phone'].'">
</div>
<div class="form-group">
  <label for="enroll">enroll:</label>
  <input class="form-control"  type="text" id="enroll" name="enroll" value="'.$value['enroll'].'" >
</div>
<input type="hidden" name="id" value="'.$_GET['id'].'">
  <input type="submit" class="btn btn-primary" value="Submit">
</form>
    ';
  } else {

    $id = mysqli_real_escape_string($conn,$_POST['id']);
    $fname = mysqli_real_escape_string($conn,$_POST['fname']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $phone = mysqli_real_escape_string($conn,$_POST['phone']);
    $enroll = mysqli_real_escape_string($conn,$_POST['enroll']);

    $sql = "UPDATE students SET fname='$fname', email='$email', phone='$phone', enroll='$enroll'
    WHERE id = $id
    ";

    if (mysqli_query($conn, $sql)) {
      header('location: students.php?msg=Student Updated');
    } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

  }
  

mysqli_close($conn);


?>

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