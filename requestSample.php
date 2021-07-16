<?php

    session_start();
    //including the header (includes/header.php)
    include_once("includes/header.php");
    loginRequired("receiver");

    $id = $_SESSION["id"];
    $query = new query();
    $result = $query->getData("receivers","name, bloodGroup, id", array("id"=>$id));
    $name = $result[0]["name"];
    $receiverId = $result[0]["id"];
    $bloodGroup = $result[0]["bloodGroup"];

    $hospitals = $query->getData("hospitals", "name, id");

    //when user clicks the request button!
    if(isset($_POST["submit"])){

        $hospitalId = $_POST["hospital"];
        $hospital = $query->getdata("hospitals", "name", array("id"=>$hospitalId))[0][0];
        $units = $_POST["units"];
        $result = $query->getData("requestedBloods", "*", array("receiverId"=>$id));

        foreach($result as $data){
            if($data["hospitalName"] === $hospital){
                $error = "<div class = 'alert alert-danger'>You Have already Requested in this Hospital</div>";
            }
        }
        if(!isset($error)){
            $query->addData("requestedBloods", array("receiverId"=>$receiverId, "receiverName"=>$name, "hospitalId"=>$hospitalId, "hospitalName"=>$hospital, "bloodGroup"=>$bloodGroup, "units"=>$units));
            header("location: bloodInfo.php");
        }
        
    }

?>   

    <h1 class="text-center">Request Blood Sample</h1><br><br>
    <div class="container ">
        
    <?php if(isset($error)) echo $error  ?>
        <form action = '<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>' method="post" class="col-lg-6 col-sm-8 col-xs-12 col-lg-offset-3 col-sm-offset-2 jumbotron">
        
        <div class="form-group">
            <label for="name">Your Blood Name</label>
            <input type="text" name="name" value=<?php echo $name ?> class="form-control" disabled>
        </div>

        <div class="form-group">
            <label for="bloodGroup">Your Blood Group</label>
            <input type="text" name="bloodGroup" value=<?php echo $bloodGroup ?> class="form-control" disabled>
        </div>

        <div class="form-group">
            <label for="hospitals">Choose Hospital</label>
            <select name="hospital" id="hospitals" class="form-control">

                <?php

                    foreach($hospitals as $hospital){

                        echo "<option value= " . $hospital["id"] . ">" .$hospital["name"]. "</option>";

                    }
                ?>
            
            </select>
        </div>

        <div class="form-group">
            <label for="units">Enter Blood Sample Units</label>
            <input type="number" name="units" value= 1 class="form-control" min = 1>
        </div>
        
        <input type="submit" value="Request" class="center-block btn btn-success btn-lg" name="submit"> 
        
        </form>
    
    </div>

<?php 

    //including footer (includes/footer.php)
    include_once("includes/footer.php");

?>