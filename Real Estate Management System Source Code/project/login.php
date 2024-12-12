<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

if(isset($_POST['submit'])){

   // $id = create_unique_id();
   // $name = $_POST['name'];
   // $name = filter_var($name, FILTER_SANITIZE_STRING); s
   // $number = $_POST['number'];
   // $number = filter_var($number, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING); 
   // $c_pass = sha1($_POST['c_pass']);
   // $c_pass = filter_var($c_pass, FILTER_SANITIZE_STRING);   

   $verify_users = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ? LIMIT 1");
   $verify_users->execute([$email, $pass]);
   $row = $verify_users->fetch(PDO::FETCH_ASSOC);
         
   if($verify_users->rowCount() > 0){
      setcookie('user_id', $row['id'], time() + 60*60*24*30, '/');
      header('location:home.php');
      }
   else{
      $warning_msg[] = 'incorrect id or password!';
      }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<!-- login section starts  -->

<section class="form-container">

   <form action="" method="post">
      <h3>Welcome!</h3>
      <!-- <input type="tel" name="name" required maxlength="50" placeholder="enter your name" class="box"> -->
      <input type="email" name="email" required maxlength="50" placeholder="enter your email" class="box">
      <!-- <input type="number" name="number" required min="0" max="9999999999" maxlength="10" placeholder="enter your number" class="box"> -->
      <input type="password" name="pass" required maxlength="20" placeholder="enter your password" class="box">
      <!-- <input type="password" name="c_pass" required maxlength="20" placeholder="confirm your password" class="box"> -->
      <p>don't have an account? <a href="register.php">register now</a></p>
      <input type="submit" value="login now" name="submit" class="btn">
   </form>

</section>

<!-- register section ends -->










<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<?php include 'components/footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<?php include 'components/message.php'; ?>

</body>
</html>