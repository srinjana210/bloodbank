<?php
    
    session_start();
    
    //Checking if a Receiver or a hospital is already logged in or not
    if($_SESSION["id"] and $_SESSION["userType"] === "hospital"){
      header("location: addBloodInfo.php");
      die();
    }
    elseif($_SESSION["id"] and $_SESSION["userType"] === "receiver"){
      header("location: bloodInfo.php");
      die();
    }
    session_unset();
    session_destroy();
    
  
    //including the header (includes/header.php)
    include_once("includes/header.php");
    
    $error = "";
    if(isset($_POST["submit"])){

        if(validateData($_POST["email"])){
            $email = $_POST["email"];
        }
        else{
            $error = "Email is not Valid";
        }

        if(validateData($_POST["password"])){
            $password = $_POST["password"];
        }
        else{
            $error = "Password is not Valid";
        }

        if(!$error){

            //this is object is from CRUD.php. All classes in that file is written by me from scratch
            $query = new query();
            $result = $query->getData("receivers","password, id", array("email"=>$email));

            if($result){
                $hashPassword = $result[0][0];
                $id = $result[0][1];
                
                if(password_verify($password, $hashPassword)){
                    session_start();
                    $_SESSION["id"] = $id;
                    $_SESSION["userType"] = "receiver";
                    header("location: bloodInfo.php");
                    die();
                }
                else{
                    $error = "Entered Email or Password was wrong!!";
                }
            }

            else{
                $error = "Entered Email or Password was wrong!!";
            }

        }

    }
?>   

    <div class="container " id="login-form">
    
    <?php

        if($error != "") echo "<div class='alert alert-danger'>$error</div>";
        if(isset($_GET["registered"])){
            echo "<div class='alert alert-success'>Successfully Registered! Login Here</div>";
        } 
     
     ?>

    <form action = '<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>' method="post" class="col-lg-6 col-sm-8 col-xs-12 col-lg-offset-3 col-sm-offset-2 jumbotron">
    
        <p class="text-center" id="heading">Receiver Login</p><br>

        <div class="form-group">
            <input type="email" class="form-control" placeholder="Enter Email" name="email" required>
        </div>

        <div class="form-group">
            <input type="password" class="form-control" placeholder="Enter Password" name="password" required>
        </div><br>
        <input type="submit" value="LogIn" class="btn btn-info btn-lg center-block" name="submit"> 
        <hr>

        <a href="loginHospital.php" class="btn btn-warning btn-lg center-block">Login as Hospital</a><br>
    
        <p class="text-center" id="or">-----or-----</p>
        <a href="registerHospital.php" class="btn btn-danger center-block">Register</a><br>
     
    </form>
    
    </div>


<?php 

    //including footer (includes/footer.php)
    include_once("includes/footer.php")

?>