<?php

    session_start();
    //including the header (includes/header.php)
    include_once("includes/header.php");
    $bloodGroup = "";
    $hospitalName = "";
    if(isset($_POST["submit"])){

        if(validateData($_POST["hospitalName"])){
            $hospitalName = $_POST["hospitalName"]."%";
        }
        else{
            $error = "Invalid Search";
        }
    }

    $query = new query();
    $condition = array();

    //Search Button Logic
    if($hospitalName){
        $tempQuery = "SELECT id FROM hospitals ";
        $tempQuery .= "WHERE name like " . "'$hospitalName'";
        $tempResult = $query->prep_and_run($tempQuery);

        $tempQuery = "SELECT * FROM hospitalBloodData WHERE ";
        
        $len = count($tempResult);
        $i = 0;
        foreach($tempResult as $data){
            if($i != $len-1){
                $tempQuery .= "id= " . $data["id"] . " or ";
            }
            else{
                $tempQuery .= "id= " . $data["id"];
            }
            $i++;    
        }
        $bloodInfo = $query->prep_and_run($tempQuery);
    }
    else{
        $bloodInfo = $query->getData("hospitalBloodData","*");
    }
    
    //Greeting according to who loggedIn
    if(isset($_SESSION["id"])){

        $id = $_SESSION["id"];
        if($_SESSION["userType"] == "receiver"){
            $result = $query->getData("receivers","*", array("id"=>$id));
            $name = $result[0]["name"];
        }
        elseif($_SESSION["userType"] == "hospital"){
            $result = $query->getData("hospitals","*", array("id"=>$id));
            $name = $result[0]["name"];
        }
        
    }
    

?>   

    <h1 class="text-center">Welcome <?php if(isset($name)) echo $name ?></h1><br>
    <div class="container ">

        <form action = '<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>' method="post" class=" form-inline">
            
            <h2 class="text-center">Filter/Search Here!</h2><br>
            
            <div class="row">
                
                <div class="col-sm-3 col-xs-12 col-lg-3 col-md-3 col-sm-offset-5">
                    <input type="text" class="form-control " placeholder="Search" name="hospitalName">
                </div>
    
            </div><br>

            <input type="submit" value="Search" class="center-block btn btn-info" name="submit"><br> 
            
        </form><br>
    

        <table class="table table-hover">

            <tr><th>Name</th><th>Email</th><th>A+</th><th>A-</th><th>B+</th><th>B-</th><th>AB+</th><th>AB-</th><th>O+</th><th>O-</th></tr>

            <?php
                if($bloodInfo){

                    //Displaying all the sample information of all the hospitals
                    foreach($bloodInfo as $info){
                        
                        $id = $info["id"];
                        $result = $query->getData("hospitals", "name, email", array("id"=>$id))[0];
                        $name = $result["name"];
                        $email = $result["email"];
                        echo "<tr><td>" . $name . "</td><td>" . $email . "</td><td>". $info["AP"] ." units". "</td><td>" . $info["AN"] ." units". "</td><td>" . $info["BP"] ." units". "</td><td>" . $info["BN"] ." units". "</td><td>" . $info["ABP"] ." units". "</td><td>" . $info["ABN"] ." units". "</td><td>" . $info["OP"] ." units". "</td><td>" . $info["ONeg"] ." units". "</td><tr>";
                    }

                }
                else{
                    echo "<div class = 'alert alert-success'>No Data To Show</div>";
                }
            ?>

        </table><br><br>
        <a class="center-block btn btn-success btn-lg" style="width: fit-content;" href="requestSample.php">Request Sample+</a> 
        <div class="alert text-danger center-block" style="width: max-content;">&#9432; Only Receivers can Request for Sample</div>
    </div>

<?php 

    //including footer (includes/footer.php)
    include_once("includes/footer.php");

?>