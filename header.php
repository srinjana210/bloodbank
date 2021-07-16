<?php

  include("CRUD.php");

  function loginRequired($type){
    if(!$_SESSION["id"] or $_SESSION["userType"] != "$type"){
      header("location: index.php");
    }
  }

  //defining a function for validation(Email, name, password etc...) Good from protection from SQL injection
  function validateData($data){
    $textPattern = "/^[a-zA-Z0-9!@#$%^&*\.\s&\-]*$/";
    return preg_match($textPattern, $data);
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- CDN link for Bootstrap 3(CSS) -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="styleSheets/styleSheet.css">

    <title>The Blood Bank</title>
</head>
<body class="img-responsive">
  <img src="images/background.jpg" alt="background" class="bround hidden-xs" style="z-index: -1000; position:absolute; opacity:0.2;">

<nav class="navbar navbar-default" id="navbar">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <div class="navbar-header" id="navbar-header">
            <a class="navbar-brand" href="images/logo.png"><img src="images/logo.png" alt="Logo" id = "logo"></a>
            <a class="navbar-brand" href="index.php" id="brand-name">The Blood Bank</a>
            
        </div>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      

      <ul class="nav navbar-nav navbar-right">
        <li><a href="bloodInfo.php" class="btn btn-lg">Blood-Info</a></li>
        <?php

          //logout button accrding to the login state
          if(session_status() === PHP_SESSION_ACTIVE){
            if(isset($_SESSION["id"]) and isset($_SESSION["userType"])){
              echo "<li><a href='logout.php' class='btn btn-lg'>LogOut</a></li>";
            }
          }

        ?>
        

      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
