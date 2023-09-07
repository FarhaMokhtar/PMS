<?php
require_once 'config.php';
require_once 'user.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['name'];
    $password = $_POST['password'];
    $email =$_POST['email'];
    $role = "user"; // Default role for new users

    // Validate input
    $errors = array();
    if (empty($username)) {
      $errors[] = "Username is required.";
  }

  if (empty($password)) {
      $errors[] = "Password is required.";
  }

  if (empty($email)) {
      $errors[] = "email is required.";
  }
   // Check if username already exists
   $stmt = $conn->prepare("SELECT * FROM `users` WHERE `username` = ?");
   $stmt->bind_param("s", $username);
   $stmt->execute();
   $result = $stmt->get_result();
   $existingUser = $result->fetch_assoc();
   if ($existingUser) {
    $errors[] = "Username already exists.";
   }
   
    // If no errors, create the user
    if (empty($errors)) {
      $userCreated = $user->creatuser($username ,$email ,$password ,$role);
      if ($userCreated) {
          $_SESSION['user_id'] = $conn->insert_id;
          $_SESSION['username'] = $username;
          $_SESSION['role'] = $role;

          header("Location: home.php");
          exit();
      } else {
          $errorMessage = "Failed to create user.";
      }
  }
}
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<style>
    body{
        background-image: url(https://images.unsplash.com/photo-1597567175782-1e5771f7f313?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1374&q=80);
        width: 100%;
        height: 200px;
        background-repeat: no-repeat;
        background-size: cover;

    }
    form{
        width: 80%;
        margin: auto;
        padding: 20px;
    }
    .form{
        margin: 60px;
        margin-top: 120px;
        border: 5px solid wheat;
        border-radius: 10px;
    }
    .color_white{
        color: wheat;
    }
</style>
</head>
<body>
<?php if (isset($errorMessage)) : ?>
  <div class="alert alert-danger text-center">
      <?php echo $errorMessage; 
      unset($errorMessage);
      ?>
  </div>
    <?php endif; ?>

    <?php if (!empty($errors)) : ?>
        <ul>
            <?php foreach ($errors as $error) : ?>
                <li class="alert alert-danger text-center"><?php 
                echo $error;
                unset($error);
                 ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <div class="form">
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label color_white">Name</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="inputEmail3" name="name">
            </div>
          </div>
        <div class="form-group row">
          <label for="inputEmail3" class="col-sm-2 col-form-label color_white">Email</label>
          <div class="col-sm-10">
            <input type="email" class="form-control" id="inputEmail3" name="email">
          </div>
        </div>
        <div class="form-group row">
          <label for="inputPassword3" class="col-sm-2 col-form-label color_white">Password</label>
          <div class="col-sm-10">
            <input type="password" class="form-control" id="inputPassword3" name="password">
          </div>
        </div>
       
        <fieldset class="form-group">
          <div class="row">
            <legend class="col-form-label col-sm-2 pt-0 color_white">who are you? </legend>
            <div class="col-sm-10">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="option1" checked name="role">
                <label class="form-check-label color_white" for="gridRadios1">
                   USER
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" value="option2" name="role">
                <label class="form-check-label color_white" for="gridRadios2">
                  ADMIN
                </label>
              </div>
            </div>
          </div>
        </fieldset>
     
        <div class="form-group row">
          <div class="col-sm-10">
            <button type="submit" class="btn btn-primary">Sign up</button>
          </div>
        </div>
      </form>
    </div>

</body>
</html>