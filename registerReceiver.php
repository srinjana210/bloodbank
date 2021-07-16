<?php

    //checking if the user is already loggedIn or not
    session_start();        
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
    
    //initializing the error variable
    $error = "";

    //When User clicks the register button
    if(isset($_POST["submit"])){
        
        if(validateData($_POST["name"])){
            $name = $_POST["name"];
        }
        else{
            $error = "Name is not Valid";
        }

        if(validateData($_POST["email"])){
            $email = $_POST["email"];
        }
        else{
            $error = "Email is not Valid";
        }

        $password = $_POST["password"];
        $confirmPassword = $_POST["confirmPassword"];

        if(validateData($password) and validateData($confirmPassword) and $password === $confirmPassword and strlen($password)>8){
            $password = password_hash($password, PASSWORD_BCRYPT);
        }
        else{
            $error = "Password is not Valid";
        }
        $bloodGroup = $_POST["bloodGroup"];

        if(!$error){

            //this is object is from CRUD.php. All classes in that file is written by me from scratch
            $query = new query();
            if($query->getData("receivers", "*", array("email"=>$email))){
                $error = "User already exist. Try Login In";
            }
            else{
                $query->addData("receivers", array("name"=>$name, "password"=>$password, "email"=>$email, "bloodGroup"=>$bloodGroup));
                header("location: index.php?registered=true");
                die();
            }
        }
    }
?>   

    <div class="container " id="login-form">
    
    <?php if($error != "") echo "<div class='alert alert-danger'>$error</div>" ?>

    <form action = '<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>' method="post" class="col-lg-6 col-sm-8 col-xs-12 col-lg-offset-3 col-sm-offset-2 jumbotron">
    
        <p class="text-center" id="heading">Receiver Register</p><br>

        <div class="form-group">
            <input type="text" class="form-control" placeholder="Enter Name" name="name" required>
        </div>

        <div class="form-group">
            <input type="email" class="form-control" placeholder="Enter Email" name="email" required>
        </div>
        
        <div id = "passError" class="text-danger"></div>
        <div class="form-group">
            <input type="password" class="form-control" id = "passwordR" placeholder="Enter Password" name="password" required>
        </div>

        <div id = "confirmPassError" class="text-danger"></div>
        <div class="form-group">
            <input type="password" class="form-control" id = "confirmPasswordR" placeholder="Confirm Password" name="confirmPassword" required>
        </div>

        <div class="form-group">

            <label for="blood-groups">Choose Your Blood Group</label>
            <select name="bloodGroup" id="blood-groups" class="form-control">
            
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
            
            </select>
        </div>


        <br><input type="submit" value="Register" class="btn btn-info btn-lg center-block" name="submit"> <hr>

            <a href="registerHospital.php" class="btn btn-warning btn-lg center-block">Register as Hospital</a><br>
            
            <p class="text-center" id="or">-----or-----</p>
            <a href="index.php" class="btn btn-danger center-block">LogIn</a><br>
             
        </form>
    
    </div>

<?php 

    //including footer (includes/footer.php)
    include_once("includes/footer.php")

?>