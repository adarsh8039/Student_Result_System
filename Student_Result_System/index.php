<?php
$login = false;
$showErrorAlert = "";
if(!empty($_POST)){

  include 'include/_db.php';

  $username = $_POST["username"];
  $password = $_POST["password"];
    
  $sql = "select * from admin where username='$username'";
  $result = mysqli_query($conn,$sql);
  $num = mysqli_num_rows($result);

  if($num == 1){
    while($row = mysqli_fetch_assoc($result)){
      if (password_verify($password,$row['password'])) {
        $login = true;
        session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header("location: dashboard.php");   
      }
      else
      {
        $showErrorAlert = "Invailid details.";
      }

    }
  }
  else
  {
    $showErrorAlert = "Username doesn't exist.";
  }
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <title>Admin | Login</title>
    <!-- Bootstrap core CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Js -->
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <style>
      html,
      body {
        height: 100%;
      }

      body {
        display: flex;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }

      .form-signin {
        width: 100%;
        max-width: 330px;
        padding: 15px;
        margin: auto;
      }

      .form-signin .checkbox {
        font-weight: 400;
      }

      .form-signin .form-floating:focus-within {
        z-index: 2;
      }

      .form-signin input[type="email"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
      }

      .form-signin input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
      }

      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
  </head>
  <body class="text-center">
    <main class="form-signin">
      <form action="index.php" method="post">
        <img class="mb-4" src="image/logo.png" alt="" width="100" height="100">
        <h1 class="h3 mb-3 fw-normal">Please sign in</h1>
        <?php
          if($showErrorAlert){
            echo "
            <div class='alert alert-danger alert-dismissible fade show' role='alert'>
            <strong>Operation Failed!</strong>  $showErrorAlert
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
          }
        ?>

        <div class="form-floating">
          <input type="text" class="form-control" id="username" name="username" placeholder="Username">
          <label for="username">Username</label>
        </div>
        <div class="form-floating">
          <input type="password" class="form-control" id="password" name="password" placeholder="Password">
          <label for="password">Password</label>
        </div>

        <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
        <p class="mt-5 mb-3 text-muted">&copy; Result Management System 2021–2022</p>
      </form>
    </main>         
  </body>
</html>
