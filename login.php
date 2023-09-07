<?php
require_once 'config.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM `users` WHERE `username` = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        header("Location: index.php");
        exit();
    } else {
      $_SESSION['errorMessage'] = "Invalid username or password.";
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

<?php if (isset($_SESSION['errorMessage'])) : ?>
    <div class="alert alert-danger text-center">
    <?php
    echo $_SESSION['errorMessage'];
    unset($_SESSION['errorMessage']);
     ?>
    </div>
     <?php endif; ?> 
    <div class="form">
    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
       
        <div class="form-group row">
          <label for="inputEmail3" class="col-sm-2 col-form-label color_white">Name</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="inputEmail3" name="username">
          </div>
        </div>
        <div class="form-group row">
          <label for="inputPassword3" class="col-sm-2 col-form-label color_white">Password</label>
          <div class="col-sm-10">
            <input type="password" class="form-control" id="inputPassword3" name="password">
          </div>
        </div>  
       
        <div class="form-group row">
          <div class="col-sm-10">
            <button type="submit" class="btn btn-primary">Sign in</button>
          </div>
        </div>
      </form>
    </div>

</body>
</html>


